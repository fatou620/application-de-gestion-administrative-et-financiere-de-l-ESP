<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Étend le schéma importé de l'équipe (database.sql) avec :
 *  - les colonnes nécessaires aux modules Agent Administratif & Responsable Financier
 *  - les tables candidats / dossiers_candidature / inscriptions
 *  - un remember_token sur utilisateurs (pour Laravel Auth)
 *
 * Ce fichier est sûr à exécuter sur un schéma déjà étendu : il vérifie l'existence
 * de chaque colonne / table avant de l'ajouter.
 */
return new class extends Migration {
    public function up(): void
    {
        // ───── utilisateurs : statut enum élargi + remember_token ─────
        if (!Schema::hasColumn('utilisateurs', 'remember_token')) {
            Schema::table('utilisateurs', function (Blueprint $t) {
                $t->string('remember_token', 100)->nullable()->after('statut');
            });
        }
        DB::statement("ALTER TABLE utilisateurs MODIFY statut ENUM('actif','inactif','suspendu') DEFAULT 'actif'");

        // ───── etudiants : niveau_id, lieu_naissance, adresse ─────
        Schema::table('etudiants', function (Blueprint $t) {
            if (!Schema::hasColumn('etudiants', 'niveau_id')) {
                $t->unsignedInteger('niveau_id')->nullable()->after('utilisateur_id');
                $t->foreign('niveau_id')->references('id')->on('niveaux')->nullOnDelete();
            }
            if (!Schema::hasColumn('etudiants', 'lieu_naissance')) {
                $t->string('lieu_naissance', 120)->nullable()->after('date_naissance');
            }
            if (!Schema::hasColumn('etudiants', 'adresse')) {
                $t->string('adresse', 255)->nullable()->after('lieu_naissance');
            }
        });

        // ───── paiements : statut + valide_par + mode élargi ─────
        DB::statement("ALTER TABLE paiements MODIFY mode ENUM('orange_money','wave','especes','cheque','virement') NOT NULL");
        Schema::table('paiements', function (Blueprint $t) {
            if (!Schema::hasColumn('paiements', 'statut')) {
                $t->enum('statut', ['valide', 'en_attente', 'rejete'])->default('valide')->after('reference_trans');
            }
            if (!Schema::hasColumn('paiements', 'valide_par')) {
                $t->unsignedInteger('valide_par')->nullable()->after('statut');
                $t->foreign('valide_par')->references('id')->on('utilisateurs')->nullOnDelete();
            }
        });

        // ───── documents_numeriques : commentaire, valide_par, date_validation ─────
        Schema::table('documents_numeriques', function (Blueprint $t) {
            if (!Schema::hasColumn('documents_numeriques', 'commentaire')) {
                $t->text('commentaire')->nullable()->after('statut_validation');
            }
            if (!Schema::hasColumn('documents_numeriques', 'valide_par')) {
                $t->unsignedInteger('valide_par')->nullable()->after('commentaire');
                $t->foreign('valide_par')->references('id')->on('utilisateurs')->nullOnDelete();
            }
            if (!Schema::hasColumn('documents_numeriques', 'date_validation')) {
                $t->timestamp('date_validation')->nullable()->after('date_depot');
            }
        });

        // ───── annonces : auteur_id, cible ─────
        Schema::table('annonces', function (Blueprint $t) {
            if (!Schema::hasColumn('annonces', 'auteur_id')) {
                $t->unsignedInteger('auteur_id')->nullable()->after('niveau_id');
                $t->foreign('auteur_id')->references('id')->on('utilisateurs')->nullOnDelete();
            }
            if (!Schema::hasColumn('annonces', 'cible')) {
                $t->enum('cible', ['tous', 'etudiants', 'enseignants', 'agent_administratif'])
                  ->default('tous')->after('priorite');
            }
        });

        // ───── seances_cours : niveau_id + enseignant ─────
        Schema::table('seances_cours', function (Blueprint $t) {
            if (!Schema::hasColumn('seances_cours', 'niveau_id')) {
                $t->unsignedInteger('niveau_id')->nullable()->after('matiere_id');
                $t->foreign('niveau_id')->references('id')->on('niveaux')->nullOnDelete();
            }
            if (!Schema::hasColumn('seances_cours', 'enseignant')) {
                $t->string('enseignant', 120)->nullable()->after('salle');
            }
        });

        // ───── candidats ─────
        if (!Schema::hasTable('candidats')) {
            Schema::create('candidats', function (Blueprint $t) {
                $t->id();
                $t->string('numero_candidature', 30)->unique();
                $t->string('nom', 80);
                $t->string('prenom', 80);
                $t->string('email', 150);
                $t->string('telephone', 30)->nullable();
                $t->date('date_naissance');
                $t->string('lieu_naissance', 120)->nullable();
                $t->string('diplome', 60);
                $t->unsignedInteger('filiere_voulue_id')->nullable();
                $t->enum('statut', ['nouveau', 'en_cours', 'incomplet', 'valide', 'rejete'])->default('nouveau');
                $t->text('motif_rejet')->nullable();
                $t->unsignedInteger('traite_par')->nullable();
                $t->timestamp('date_traitement')->nullable();
                $t->timestamps();

                $t->foreign('filiere_voulue_id')->references('id')->on('filieres')->nullOnDelete();
                $t->foreign('traite_par')->references('id')->on('utilisateurs')->nullOnDelete();
            });
        }

        // ───── dossiers_candidature ─────
        if (!Schema::hasTable('dossiers_candidature')) {
            Schema::create('dossiers_candidature', function (Blueprint $t) {
                $t->id();
                $t->unsignedBigInteger('candidat_id');
                $t->string('type_piece', 100);
                $t->string('url_fichier', 255);
                $t->enum('statut', ['en_attente', 'valide', 'rejete'])->default('en_attente');
                $t->text('commentaire')->nullable();
                $t->timestamp('date_depot')->useCurrent();
                $t->timestamps();

                $t->foreign('candidat_id')->references('id')->on('candidats')->cascadeOnDelete();
            });
        }

        // ───── inscriptions ─────
        if (!Schema::hasTable('inscriptions')) {
            Schema::create('inscriptions', function (Blueprint $t) {
                $t->id();
                $t->unsignedInteger('etudiant_id');
                $t->unsignedInteger('niveau_id');
                $t->string('annee_academique', 12);
                $t->enum('statut', ['en_attente', 'validee', 'rejetee', 'annulee'])->default('en_attente');
                $t->decimal('frais_scolarite', 12, 2)->default(0);
                $t->unsignedInteger('valide_par')->nullable();
                $t->timestamp('date_validation')->nullable();
                $t->text('commentaire')->nullable();
                $t->timestamps();

                $t->foreign('etudiant_id')->references('id')->on('etudiants')->cascadeOnDelete();
                $t->foreign('niveau_id')->references('id')->on('niveaux');
                $t->foreign('valide_par')->references('id')->on('utilisateurs')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
        Schema::dropIfExists('dossiers_candidature');
        Schema::dropIfExists('candidats');
        // Les ALTER sont laissés en place : un rollback partiel risquerait de
        // casser le schéma de l'équipe — préférable de drop/recréer la BDD.
    }
};
