<?php

function debut_page($titre) {
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($titre) ?></title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-50 min-h-screen">
        <header class="bg-white border-b border-gray-200">
            <div class="max-w-md mx-auto px-4 py-3 flex items-center justify-between">
                <a href="index.php" class="font-semibold text-gray-900">Covoiturage</a>
                <?php if (est_connecte()): ?>
                    <span class="text-xs text-gray-500">
                        <?= htmlspecialchars(conducteur_actuel()['prenom']) ?>
                        &middot; <a href="index.php?route=conducteur_deconnexion" class="text-red-600 hover:underline">Deconnexion</a>
                    </span>
                <?php endif; ?>
            </div>
        </header>
        <main class="max-w-md mx-auto px-4 py-6">
    <?php
    return ob_get_clean();
}

function fin_page() {
    return '</main></body></html>';
}

function vue_accueil() {
    ob_start();
    ?>
    <h1 class="text-xl font-semibold text-gray-900 mb-1">Bienvenue</h1>
    <p class="text-sm text-gray-500 mb-8">Choisissez votre profil pour continuer.</p>
    <div class="space-y-4">
        <a href="index.php?route=conducteur_<?= est_connecte() ? 'mes_trajets' : 'connexion' ?>"
           class="block w-full text-center bg-gray-900 text-white font-medium py-3 rounded-lg hover:bg-gray-800">
            Je suis conducteur
        </a>
        <a href="index.php?route=passager_recherche"
           class="block w-full text-center border border-gray-300 text-gray-900 font-medium py-3 rounded-lg hover:bg-gray-100">
            Je suis passager
        </a>
    </div>
    <?php
    return ob_get_clean();
}

function vue_inscription($erreur) {
    ob_start();
    ?>
    <h1 class="text-lg font-semibold text-gray-900 mb-6">Inscription conducteur</h1>
    <?php if ($erreur): ?>
        <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg px-3 py-2"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>
    <form method="post" action="index.php?route=conducteur_inscription" class="space-y-4">
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Nom</label>
                <input type="text" name="nom" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Prenom</label>
                <input type="text" name="prenom" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Email</label>
            <input type="email" name="email" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Telephone</label>
            <input type="tel" name="telephone" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Mot de passe</label>
            <input type="password" name="mot_de_passe" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Confirmer mot de passe</label>
            <input type="password" name="confirmation" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <button type="submit" class="w-full bg-gray-900 text-white font-medium py-3 rounded-lg hover:bg-gray-800">S'inscrire</button>
    </form>
    <p class="text-center text-sm text-gray-500 mt-6">
        Deja inscrit ? <a href="index.php?route=conducteur_connexion" class="text-blue-700 hover:underline">Se connecter</a>
    </p>
    <?php
    return ob_get_clean();
}

function vue_connexion($erreur) {
    ob_start();
    ?>
    <h1 class="text-lg font-semibold text-gray-900 mb-6">Connexion</h1>
    <?php if ($erreur): ?>
        <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg px-3 py-2"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>
    <form method="post" action="index.php?route=conducteur_connexion" class="space-y-4">
        <div>
            <label class="block text-xs text-gray-500 mb-1">Email</label>
            <input type="email" name="email" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Mot de passe</label>
            <input type="password" name="mot_de_passe" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <button type="submit" class="w-full bg-gray-900 text-white font-medium py-3 rounded-lg hover:bg-gray-800">Se connecter</button>
    </form>
    <p class="text-center text-sm text-gray-500 mt-6">
        Pas de compte ? <a href="index.php?route=conducteur_inscription" class="text-blue-700 hover:underline">S'inscrire</a>
    </p>
    <?php
    return ob_get_clean();
}

function vue_ajouter_voiture($erreur) {
    ob_start();
    ?>
    <h1 class="text-lg font-semibold text-gray-900 mb-6">Ajouter une voiture</h1>
    <?php if ($erreur): ?>
        <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg px-3 py-2"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>
    <form method="post" action="index.php?route=conducteur_ajouter_voiture" class="space-y-4">
        <div>
            <label class="block text-xs text-gray-500 mb-1">Marque et modele</label>
            <input type="text" name="marque_modele" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Immatriculation</label>
            <input type="text" name="immatriculation" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Nombre de places</label>
            <input type="number" name="places" min="1" max="8" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <button type="submit" class="w-full bg-gray-900 text-white font-medium py-3 rounded-lg hover:bg-gray-800">Enregistrer la voiture</button>
    </form>
    <?php
    return ob_get_clean();
}

function vue_ajouter_trajet($voitures, $erreur) {
    ob_start();
    ?>
    <h1 class="text-lg font-semibold text-gray-900 mb-6">Ajouter un trajet</h1>
    <?php if ($erreur): ?>
        <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg px-3 py-2"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>
    <form method="post" action="index.php?route=conducteur_ajouter_trajet" class="space-y-4">
        <div>
            <label class="block text-xs text-gray-500 mb-1">Ville de depart</label>
            <input type="text" name="depart" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Ville d'arrivee</label>
            <input type="text" name="arrivee" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Date</label>
                <input type="date" name="date" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Heure</label>
                <input type="time" name="heure" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Places</label>
                <input type="number" name="places" min="1" max="8" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Prix / place</label>
                <input type="number" name="prix" min="1" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Voiture</label>
            <select name="voiture_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <?php foreach ($voitures as $v): ?>
                    <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['marque_modele']) ?> (<?= htmlspecialchars($v['immatriculation']) ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="w-full bg-gray-900 text-white font-medium py-3 rounded-lg hover:bg-gray-800">Publier le trajet</button>
    </form>
    <?php
    return ob_get_clean();
}

function vue_mes_trajets($trajets) {
    ob_start();
    ?>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-lg font-semibold text-gray-900">Mes trajets</h1>
        <a href="index.php?route=conducteur_ajouter_voiture" class="text-xs text-gray-500 hover:underline">+ Voiture</a>
    </div>
    <?php if (empty($trajets)): ?>
        <p class="text-sm text-gray-500 mb-6">Vous n'avez encore publie aucun trajet.</p>
    <?php else: ?>
        <div class="space-y-3 mb-6">
            <?php foreach ($trajets as $t): ?>
                <a href="index.php?route=conducteur_detail_trajet&id=<?= $t['id'] ?>" class="block border border-gray-200 rounded-xl px-4 py-3 hover:border-gray-400">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-medium text-gray-900"><?= htmlspecialchars($t['depart']) ?> &rarr; <?= htmlspecialchars($t['arrivee']) ?></span>
                        <span class="text-xs px-2 py-1 rounded-full <?= classes_statut($t['statut']) ?>"><?= libelle_statut($t['statut']) ?></span>
                    </div>
                    <p class="text-xs text-gray-500"><?= htmlspecialchars($t['date']) ?> a <?= htmlspecialchars($t['heure']) ?> &middot; <?= $t['places_dispo'] ?>/<?= $t['places_total'] ?> places</p>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <a href="index.php?route=conducteur_ajouter_trajet" class="block w-full text-center bg-gray-900 text-white font-medium py-3 rounded-lg hover:bg-gray-800">+ Ajouter un trajet</a>
    <?php
    return ob_get_clean();
}

function vue_detail_trajet($t) {
    ob_start();
    ?>
    <a href="index.php?route=conducteur_mes_trajets" class="text-xs text-gray-500 hover:underline">&larr; Mes trajets</a>
    <h1 class="text-lg font-semibold text-gray-900 mt-2 mb-4"><?= htmlspecialchars($t['depart']) ?> &rarr; <?= htmlspecialchars($t['arrivee']) ?></h1>
    <div class="border border-gray-200 rounded-xl px-4 py-4 mb-6 space-y-1">
        <p class="text-sm text-gray-600"><?= htmlspecialchars($t['date']) ?> a <?= htmlspecialchars($t['heure']) ?></p>
        <p class="text-sm text-gray-600"><?= $t['places_dispo'] ?> places restantes sur <?= $t['places_total'] ?></p>
        <p class="text-sm text-gray-600"><?= $t['prix'] ?> FCFA par place</p>
        <span class="inline-block mt-2 text-xs px-2 py-1 rounded-full <?= classes_statut($t['statut']) ?>">Statut : <?= libelle_statut($t['statut']) ?></span>
    </div>
    <h2 class="text-sm font-medium text-gray-700 mb-2">Passagers reserves</h2>
    <div class="border border-gray-200 rounded-xl px-4 py-3 mb-6">
        <?php if (empty($t['passagers'])): ?>
            <p class="text-sm text-gray-500">Aucune reservation pour le moment.</p>
        <?php else: ?>
            <ul class="text-sm text-gray-700 space-y-1">
                <?php foreach ($t['passagers'] as $p): ?>
                    <li><?= htmlspecialchars($p['nom']) ?> &middot; <?= $p['places'] ?> place(s)</li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <div class="space-y-3">
        <?php if ($t['statut'] === 'a_venir'): ?>
            <form method="post" action="index.php?route=conducteur_demarrer_trajet">
                <input type="hidden" name="id" value="<?= $t['id'] ?>">
                <button type="submit" class="w-full bg-green-600 text-white font-medium py-3 rounded-lg hover:bg-green-700">Demarrer le trajet</button>
            </form>
            <form method="post" action="index.php?route=conducteur_annuler_trajet">
                <input type="hidden" name="id" value="<?= $t['id'] ?>">
                <button type="submit" class="w-full bg-red-600 text-white font-medium py-3 rounded-lg hover:bg-red-700">Annuler le trajet</button>
            </form>
        <?php elseif ($t['statut'] === 'en_cours'): ?>
            <form method="post" action="index.php?route=conducteur_terminer_trajet">
                <input type="hidden" name="id" value="<?= $t['id'] ?>">
                <button type="submit" class="w-full border border-gray-900 text-gray-900 font-medium py-3 rounded-lg hover:bg-gray-100">Terminer le trajet</button>
            </form>
        <?php else: ?>
            <p class="text-sm text-gray-500 text-center">Ce trajet est <?= strtolower(libelle_statut($t['statut'])) ?>, aucune action disponible.</p>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

function vue_recherche() {
    ob_start();
    ?>
    <h1 class="text-lg font-semibold text-gray-900 mb-6">Rechercher un trajet</h1>
    <form method="get" action="index.php" class="space-y-4">
        <input type="hidden" name="route" value="passager_resultats">
        <div>
            <label class="block text-xs text-gray-500 mb-1">Ville de depart</label>
            <input type="text" name="depart" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Ville d'arrivee</label>
            <input type="text" name="arrivee" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Date</label>
            <input type="date" name="date" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Nombre de places</label>
            <input type="number" name="places" min="1" value="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <button type="submit" class="w-full bg-gray-900 text-white font-medium py-3 rounded-lg hover:bg-gray-800">Rechercher</button>
    </form>
    <?php
    return ob_get_clean();
}

function vue_resultats($trajets, $depart, $arrivee) {
    ob_start();
    ?>
    <a href="index.php?route=passager_recherche" class="text-xs text-gray-500 hover:underline">&larr; Modifier la recherche</a>
    <h1 class="text-lg font-semibold text-gray-900 mt-2 mb-6">
        <?= ($depart || $arrivee) ? htmlspecialchars($depart) . ' &rarr; ' . htmlspecialchars($arrivee) : 'Tous les trajets' ?>
    </h1>
    <?php if (empty($trajets)): ?>
        <p class="text-sm text-gray-500">Aucun trajet disponible pour ces criteres.</p>
    <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($trajets as $t): ?>
                <div class="border border-gray-200 rounded-xl px-4 py-3">
                    <p class="font-medium text-gray-900"><?= htmlspecialchars($t['depart']) ?> &rarr; <?= htmlspecialchars($t['arrivee']) ?></p>
                    <p class="text-xs text-gray-500 mb-2"><?= htmlspecialchars($t['date']) ?> a <?= htmlspecialchars($t['heure']) ?> &middot; <?= $t['places_dispo'] ?> place(s) disponible(s)</p>
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-gray-900"><?= $t['prix'] ?> FCFA</span>
                        <a href="index.php?route=passager_reserver&id=<?= $t['id'] ?>" class="bg-gray-900 text-white text-sm px-4 py-2 rounded-lg hover:bg-gray-800">Reserver</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php
    return ob_get_clean();
}

function vue_reserver($t, $confirmee, $erreur) {
    ob_start();
    ?>
    <h1 class="text-lg font-semibold text-gray-900 mb-6">Reserver une place</h1>
    <div class="border border-gray-200 rounded-xl px-4 py-3 mb-6">
        <p class="font-medium text-gray-900"><?= htmlspecialchars($t['depart']) ?> &rarr; <?= htmlspecialchars($t['arrivee']) ?></p>
        <p class="text-xs text-gray-500"><?= htmlspecialchars($t['date']) ?> a <?= htmlspecialchars($t['heure']) ?> &middot; <?= $t['places_dispo'] ?> place(s) disponible(s)</p>
    </div>
    <?php if ($confirmee): ?>
        <div class="text-center py-6">
            <p class="text-green-700 font-medium mb-2">Reservation confirmee !</p>
            <p class="text-sm text-gray-500 mb-6">Le conducteur vous contactera avant le depart.</p>
            <a href="index.php?route=passager_recherche" class="inline-block bg-gray-900 text-white font-medium px-6 py-3 rounded-lg hover:bg-gray-800">Rechercher un autre trajet</a>
        </div>
    <?php else: ?>
        <?php if ($erreur): ?>
            <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg px-3 py-2"><?= htmlspecialchars($erreur) ?></div>
        <?php endif; ?>
        <form method="post" action="index.php?route=passager_reserver" class="space-y-4">
            <input type="hidden" name="id" value="<?= $t['id'] ?>">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Votre nom</label>
                <input type="text" name="nom" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Nombre de places</label>
                <input type="number" name="nb_places" min="1" max="<?= $t['places_dispo'] ?>" value="1" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Mode de paiement</label>
                <select name="paiement" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option>Carte bancaire</option>
                    <option>Mobile money</option>
                </select>
            </div>
            <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                <span class="text-sm text-gray-600">Total a payer</span>
                <span class="font-medium text-gray-900"><?= $t['prix'] ?> FCFA / place</span>
            </div>
            <button type="submit" class="w-full bg-green-600 text-white font-medium py-3 rounded-lg hover:bg-green-700">Payer et confirmer</button>
        </form>
    <?php endif; ?>
    <?php
    return ob_get_clean();
}
