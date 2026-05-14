# 🎓 ESP Plateforme — Installation

Plateforme numérique intégrée pour la gestion administrative, académique et financière des étudiants de l'ESP.

## 📋 Pré-requis

| Outil | Version |
|---|---|
| PHP | 8.2+ (8.4 recommandé) |
| Composer | 2.x |
| MySQL ou MariaDB | 5.7+ / 10.4+ |

Sur Windows, [Laragon](https://laragon.org/) ou [XAMPP](https://www.apachefriends.org/) couvrent tout.

## 🚀 Installation (5 minutes)

### 1. Décompresser le ZIP
Place le dossier où tu veux, par exemple `C:\dev\esp-laravel\`.

### 2. Installer les dépendances PHP
```bash
cd esp-laravel
composer install
```

### 3. Créer ton fichier `.env`
```bash
copy .env.example .env
```

Ouvre `.env` et adapte **DB_PORT**, **DB_USERNAME**, **DB_PASSWORD** à ta config MySQL :
```env
DB_PORT=3306         # ou 3307 selon ton install
DB_USERNAME=root
DB_PASSWORD=         # ton mot de passe root, souvent vide en local
```

### 4. Générer la clé d'application
```bash
php artisan key:generate
```

### 5. Créer la base + importer le schéma de l'équipe
Dans phpMyAdmin OU en ligne de commande :
```sql
CREATE DATABASE esp_plateforme CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Puis importe le fichier **`database.sql`** (fourni à la racine du projet) dans la base `esp_plateforme`.

> **Avec phpMyAdmin** : sélectionne `esp_plateforme` → onglet *Importer* → choisis `database.sql` → *Exécuter*.
>
> **En ligne de commande** :
> ```bash
> mysql -u root -p esp_plateforme < database.sql
> ```

### 6. Appliquer les extensions Laravel + remplir avec les données de test
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

### 7. Lancer le serveur
```bash
php artisan serve
```

➡️ Ouvre **http://127.0.0.1:8000**

## 🔑 Comptes de test (mot de passe : `password`)

| Email | Rôle |
|---|---|
| `etudiant@esp.sn` | Étudiant (Mohamed KAMARA) |
| `agent@esp.sn` | Agent administratif |
| `finance@esp.sn` | Responsable financier |
| `enseignant@esp.sn` | Enseignant *(espace placeholder)* |
| `admin@esp.sn` | Administrateur système *(espace placeholder)* |

Les 2 comptes existants de l'équipe (`fatou.dianko@esp.sn` et `assane12.dianko@esp.sn`) sont préservés.

## 🗂️ Structure du projet

```
esp-laravel/
├── app/
│   ├── Models/                      # Eloquent : Utilisateur, Etudiant, Paiement, Candidat…
│   └── Http/Controllers/
│       ├── AuthController.php
│       ├── AgentAdminController.php  ← Module Agent administratif
│       ├── Finance/                  ← Module Responsable financier
│       └── Etudiant/                 ← Espace étudiant
├── database/
│   ├── migrations/                  # 1 migration d'extension qui complète database.sql
│   └── seeders/                     # Données de démo
├── resources/views/
│   ├── auth/                        # login + register
│   ├── etudiant/                    # 6 vues étudiant
│   ├── agent/                       # 6 vues agent admin
│   ├── finance/                     # 6 vues responsable financier
│   └── layouts/                     # sidebar, auth
├── routes/web.php                   # Toutes les routes
├── database.sql                     # Schéma équipe (à importer en BDD)
└── .env.example                     # Modèle de config
```

## 🆘 Problèmes courants

**« could not find driver »**
→ Active l'extension `pdo_mysql` dans `php.ini`.

**« Access denied for user 'root' »**
→ Mot de passe MySQL incorrect dans `.env` → re-vérifie `DB_PASSWORD`.

**« Connection refused on port 3306 »**
→ MySQL tourne peut-être sur un autre port (3307 fréquent sous Windows). Vérifie avec `netstat -an | findstr LISTENING | findstr 330`.

**Les uploads (photos, documents) n'apparaissent pas**
→ Tu as oublié `php artisan storage:link` à l'étape 6.

**« Class "App\Models\Utilisateur" not found » ou autre erreur d'autoload**
→ Lance `composer dump-autoload`.

---

*Projet réalisé par Mohamed Mourtada KAMARA — module Dev Web, ESP Dakar*
