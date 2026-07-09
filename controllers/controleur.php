<?php

function traiter_requete() {
    init_donnees();

    $route = $_GET['route'] ?? 'accueil';
    $erreur = '';
    $confirmee = false;

    if ($route === 'conducteur_deconnexion') {
        deconnecter_conducteur();
        header('Location: index.php?route=conducteur_connexion');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if ($route === 'conducteur_inscription') {
            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telephone = trim($_POST['telephone'] ?? '');
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';
            $confirmation = $_POST['confirmation'] ?? '';
            if ($nom === '' || $prenom === '' || $email === '' || $telephone === '' || $mot_de_passe === '') {
                $erreur = 'Veuillez remplir tous les champs.';
            } elseif ($mot_de_passe !== $confirmation) {
                $erreur = 'Les mots de passe ne correspondent pas.';
            } else {
                inscrire_conducteur($nom, $prenom, $email, $telephone);
                header('Location: index.php?route=conducteur_mes_trajets');
                exit;
            }
        }

        if ($route === 'conducteur_connexion') {
            $email = trim($_POST['email'] ?? '');
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';
            if (connecter_conducteur($email, $mot_de_passe)) {
                header('Location: index.php?route=conducteur_mes_trajets');
                exit;
            }
            $erreur = 'Veuillez saisir votre email et votre mot de passe.';
        }

        if ($route === 'conducteur_ajouter_voiture') {
            $marque_modele = trim($_POST['marque_modele'] ?? '');
            $immatriculation = trim($_POST['immatriculation'] ?? '');
            $places = (int) ($_POST['places'] ?? 0);
            if ($marque_modele === '' || $immatriculation === '' || $places < 1) {
                $erreur = 'Veuillez remplir correctement tous les champs.';
            } else {
                ajouter_voiture($marque_modele, $immatriculation, $places);
                header('Location: index.php?route=conducteur_ajouter_trajet');
                exit;
            }
        }

        if ($route === 'conducteur_ajouter_trajet') {
            $depart = trim($_POST['depart'] ?? '');
            $arrivee = trim($_POST['arrivee'] ?? '');
            $date = $_POST['date'] ?? '';
            $heure = $_POST['heure'] ?? '';
            $places = (int) ($_POST['places'] ?? 0);
            $prix = (int) ($_POST['prix'] ?? 0);
            $voiture_id = (int) ($_POST['voiture_id'] ?? 0);
            if ($depart === '' || $arrivee === '' || $date === '' || $heure === '' || $places < 1 || $prix < 1) {
                $erreur = 'Veuillez remplir correctement tous les champs.';
            } else {
                ajouter_trajet($depart, $arrivee, $date, $heure, $places, $prix, $voiture_id);
                header('Location: index.php?route=conducteur_mes_trajets');
                exit;
            }
        }

        if ($route === 'conducteur_demarrer_trajet') {
            $id = (int) ($_POST['id'] ?? 0);
            changer_statut_trajet($id, 'en_cours');
            header("Location: index.php?route=conducteur_detail_trajet&id=$id");
            exit;
        }

        if ($route === 'conducteur_terminer_trajet') {
            $id = (int) ($_POST['id'] ?? 0);
            changer_statut_trajet($id, 'termine');
            header("Location: index.php?route=conducteur_detail_trajet&id=$id");
            exit;
        }

        if ($route === 'conducteur_annuler_trajet') {
            $id = (int) ($_POST['id'] ?? 0);
            changer_statut_trajet($id, 'annule');
            header("Location: index.php?route=conducteur_detail_trajet&id=$id");
            exit;
        }

        if ($route === 'passager_reserver') {
            $id = (int) ($_POST['id'] ?? 0);
            $nom = trim($_POST['nom'] ?? '');
            $nb_places = (int) ($_POST['nb_places'] ?? 1);
            if ($nom === '' || $nb_places < 1) {
                $erreur = 'Veuillez indiquer votre nom et un nombre de places valide.';
            } elseif (!reserver_place($id, $nom, $nb_places)) {
                $erreur = "Il n'y a plus assez de places disponibles sur ce trajet.";
            } else {
                $confirmee = true;
            }
        }
    }

    echo debut_page('Covoiturage');

    switch ($route) {

        case 'accueil':
            echo vue_accueil();
            break;

        case 'conducteur_inscription':
            echo vue_inscription($erreur);
            break;

        case 'conducteur_connexion':
            echo vue_connexion($erreur);
            break;

        case 'conducteur_ajouter_voiture':
            if (!est_connecte()) { header('Location: index.php?route=conducteur_connexion'); exit; }
            echo vue_ajouter_voiture($erreur);
            break;

        case 'conducteur_ajouter_trajet':
            if (!est_connecte()) { header('Location: index.php?route=conducteur_connexion'); exit; }
            if (!a_une_voiture()) { header('Location: index.php?route=conducteur_ajouter_voiture'); exit; }
            echo vue_ajouter_trajet(get_voitures(), $erreur);
            break;

        case 'conducteur_mes_trajets':
            if (!est_connecte()) { header('Location: index.php?route=conducteur_connexion'); exit; }
            echo vue_mes_trajets(get_trajets());
            break;

        case 'conducteur_detail_trajet':
            if (!est_connecte()) { header('Location: index.php?route=conducteur_connexion'); exit; }
            $trajet = trouver_trajet((int) ($_GET['id'] ?? 0));
            if (!$trajet) { header('Location: index.php?route=conducteur_mes_trajets'); exit; }
            echo vue_detail_trajet($trajet);
            break;

        case 'passager_recherche':
            echo vue_recherche();
            break;

        case 'passager_resultats':
            $depart = $_GET['depart'] ?? '';
            $arrivee = $_GET['arrivee'] ?? '';
            $date = $_GET['date'] ?? '';
            $places = (int) ($_GET['places'] ?? 1);
            echo vue_resultats(rechercher_trajets($depart, $arrivee, $date, $places), $depart, $arrivee);
            break;

        case 'passager_reserver':
            $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
            $trajet = trouver_trajet($id);
            if (!$trajet) { header('Location: index.php?route=passager_recherche'); exit; }
            echo vue_reserver($trajet, $confirmee, $erreur);
            break;

        default:
            http_response_code(404);
            echo 'Page introuvable';
    }

    echo fin_page();
}
