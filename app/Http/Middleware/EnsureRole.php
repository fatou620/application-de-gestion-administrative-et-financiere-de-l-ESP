<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Vérifie que l'utilisateur connecté possède l'un des rôles demandés.
     * Usage en route : ->middleware('role:agent_administratif,admin')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Veuillez vous connecter.');
        }

        if (!$user->hasAnyRole($roles)) {
            abort(403, 'Accès refusé : votre rôle ne vous permet pas d\'accéder à cet espace.');
        }

        return $next($request);
    }
}
