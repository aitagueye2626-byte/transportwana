<?php

function init_donnees() {
    if (!isset($_SESSION['trajets'])) {
        $_SESSION['trajets'] = [
            ['id' => 1, 'depart' => 'Dakar', 'arrivee' => 'Thies', 'date' => '2026-07-14', 'heure' => '14:00', 'places_total' => 3, 'places_dispo' => 3, 'prix' => 2500, 'statut' => 'a_venir', 'voiture_id' => 1, 'passagers' => []],
            ['id' => 2, 'depart' => 'Dakar', 'arrivee' => 'Saint-Louis', 'date' => '2026-07-10', 'heure' => '09:00', 'places_total' => 2, 'places_dispo' => 1, 'prix' => 3000, 'statut' => 'en_cours', 'voiture_id' => 1, 'passagers' => [['nom' => 'Fatou Diop', 'places' => 1]]],
        ];
    }
    if (!isset($_SESSION['voitures'])) {
        $_SESSION['voitures'] = [
            ['id' => 1, 'marque_modele' => 'Toyota Corolla', 'immatriculation' => 'DK-1234-AB', 'places' => 4],
        ];
    }
    if (!isset($_SESSION['prochain_id_trajet'])) $_SESSION['prochain_id_trajet'] = 3;
    if (!isset($_SESSION['prochain_id_voiture'])) $_SESSION['prochain_id_voiture'] = 2;
    if (!isset($_SESSION['conducteur'])) $_SESSION['conducteur'] = null;
}

function get_trajets() {
    return $_SESSION['trajets'];
}

function trouver_trajet($id) {
    foreach ($_SESSION['trajets'] as $t) {
        if ($t['id'] === $id) return $t;
    }
    return null;
}

function ajouter_trajet($depart, $arrivee, $date, $heure, $places, $prix, $voiture_id) {
    $id = $_SESSION['prochain_id_trajet']++;
    $_SESSION['trajets'][] = [
        'id' => $id, 'depart' => $depart, 'arrivee' => $arrivee, 'date' => $date, 'heure' => $heure,
        'places_total' => $places, 'places_dispo' => $places, 'prix' => $prix,
        'statut' => 'a_venir', 'voiture_id' => $voiture_id, 'passagers' => [],
    ];
    return $id;
}

function changer_statut_trajet($id, $statut) {
    foreach ($_SESSION['trajets'] as $i => $t) {
        if ($t['id'] === $id) {
            $_SESSION['trajets'][$i]['statut'] = $statut;
            return true;
        }
    }
    return false;
}

function rechercher_trajets($depart, $arrivee, $date, $places) {
    $resultats = [];
    foreach ($_SESSION['trajets'] as $t) {
        $ok_depart = $depart === '' || stripos($t['depart'], $depart) !== false;
        $ok_arrivee = $arrivee === '' || stripos($t['arrivee'], $arrivee) !== false;
        $ok_date = $date === '' || $t['date'] === $date;
        $ok_places = $t['places_dispo'] >= max(1, $places);
        $ok_statut = $t['statut'] === 'a_venir';
        if ($ok_depart && $ok_arrivee && $ok_date && $ok_places && $ok_statut) {
            $resultats[] = $t;
        }
    }
    return $resultats;
}

function reserver_place($trajet_id, $nom, $nb_places) {
    foreach ($_SESSION['trajets'] as $i => $t) {
        if ($t['id'] === $trajet_id) {
            if ($t['places_dispo'] < $nb_places) return false;
            $_SESSION['trajets'][$i]['places_dispo'] -= $nb_places;
            $_SESSION['trajets'][$i]['passagers'][] = ['nom' => $nom, 'places' => $nb_places];
            return true;
        }
    }
    return false;
}

function get_voitures() {
    return $_SESSION['voitures'];
}

function ajouter_voiture($marque_modele, $immatriculation, $places) {
    $id = $_SESSION['prochain_id_voiture']++;
    $_SESSION['voitures'][] = ['id' => $id, 'marque_modele' => $marque_modele, 'immatriculation' => $immatriculation, 'places' => $places];
    return $id;
}

function a_une_voiture() {
    return !empty($_SESSION['voitures']);
}

function inscrire_conducteur($nom, $prenom, $email, $telephone) {
    $_SESSION['conducteur'] = ['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'telephone' => $telephone];
}

function connecter_conducteur($email, $mot_de_passe) {
    if ($email === '' || $mot_de_passe === '') return false;
    if (empty($_SESSION['conducteur'])) {
        $_SESSION['conducteur'] = ['nom' => 'Gueye', 'prenom' => 'Aita', 'email' => $email, 'telephone' => '77 000 00 00'];
    }
    return true;
}

function deconnecter_conducteur() {
    $_SESSION['conducteur'] = null;
}

function est_connecte() {
    return !empty($_SESSION['conducteur']);
}

function conducteur_actuel() {
    return $_SESSION['conducteur'];
}

function libelle_statut($statut) {
    $labels = ['a_venir' => 'A venir', 'en_cours' => 'En cours', 'termine' => 'Termine', 'annule' => 'Annule'];
    return $labels[$statut] ?? $statut;
}

function classes_statut($statut) {
    $classes = [
        'a_venir' => 'bg-blue-100 text-blue-700',
        'en_cours' => 'bg-amber-100 text-amber-700',
        'termine' => 'bg-gray-100 text-gray-600',
        'annule' => 'bg-red-100 text-red-700',
    ];
    return $classes[$statut] ?? 'bg-gray-100 text-gray-600';
}
