<?php
session_start();
include_once("config/database.php");
require_once('vendor/autoload.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: gestionnaire/connexion.php");
    exit();
}

// Récupérer le token de la transaction depuis l'URL
$token = isset($_GET['token']) ? $_GET['token'] : null;

if ($token) {
    try {
        // Récupérer les détails de la transaction
        $transaction = \FedaPay\Transaction::retrieve($token);
        
        // Vérifier si la transaction est réussie
        if ($transaction->status === 'approved') {
            // Mettre à jour le statut de paiement dans la base de données
            $stmt = $pdo->prepare("UPDATE utilisateurs SET statut_paiement = 'payé', date_paiement = NOW() WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            
            // Stocker le message de succès
            $_SESSION['success_message'] = "Votre paiement a été effectué avec succès. Bienvenue sur Bénin Tourisme !";
        } else {
            $_SESSION['error_message'] = "Le paiement n'a pas été validé. Veuillez réessayer.";
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Une erreur est survenue lors de la vérification du paiement : " . $e->getMessage();
    }
} else {
    $_SESSION['error_message'] = "Token de transaction manquant.";
}

// Rediriger vers le tableau de bord
header("Location: gestionnaire/tableau_bord.php");
exit();
?> 