<?php
// newsletter.php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(__DIR__ . '/../vendor/autoload.php');
include_once("../config/database.php");
include_once("../config/mail.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Fonction de log pour le débogage
function logDebug($message) {
    $logFile = __DIR__ . '/newsletter_debug.log';
    $logMessage = date('[Y-m-d H:i:s] ') . $message . "\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Vérification de la connexion à la base de données
try {
    $pdo->query("SELECT 1");
    logDebug("Connexion à la base de données réussie");
} catch (PDOException $e) {
    logDebug("Erreur de connexion à la base de données : " . $e->getMessage());
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Vérification de l'existence de la table newsletter
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'newsletter'");
    if ($stmt->rowCount() == 0) {
        logDebug("Création de la table newsletter");
        $sql = "CREATE TABLE IF NOT EXISTS `newsletter` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `email` varchar(255) NOT NULL,
            `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `ip` varchar(45) DEFAULT NULL,
            `user_agent` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `email` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $pdo->exec($sql);
        logDebug("Table newsletter créée avec succès");
    }
} catch (PDOException $e) {
    logDebug("Erreur lors de la création de la table newsletter : " . $e->getMessage());
    die("Erreur lors de la création de la table newsletter : " . $e->getMessage());
}

function sendConfirmationEmail($email) {
    logDebug("Tentative d'envoi d'email à : " . $email);
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contactbenintourisme@gmail.com';
        $mail->Password   = 'mbrl pvvm gczs feqt';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';
        $mail->SMTPDebug  = 0;

        $mail->setFrom('contactbenintourisme@gmail.com', 'Bénin Tourisme');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Bienvenue à la newsletter - Bénin Tourisme';
        $mail->Body    = "<h2>Merci de vous être inscrit à la newsletter de Bénin Tourisme !</h2>";

        $result = $mail->send();
        logDebug("Email envoyé avec succès à : " . $email);
        return $result;
    } catch (Exception $e) {
        logDebug("Erreur d'envoi d'email : " . $e->getMessage());
        return false;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    logDebug("Traitement d'une nouvelle inscription");
    try {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        logDebug("Email reçu : " . $email);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Adresse email invalide.");
        }

        // Vérification si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM newsletter WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            throw new Exception("Cet email est déjà inscrit.");
        }

        // Insertion dans la base de données
        $stmt = $pdo->prepare("INSERT INTO newsletter (email, date_inscription, ip, user_agent) VALUES (?, NOW(), ?, ?)");
        $success = $stmt->execute([
            $email,
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['HTTP_USER_AGENT']
        ]);

        if (!$success) {
            throw new Exception("Erreur lors de l'inscription dans la base de données.");
        }

        logDebug("Email inséré dans la base de données avec succès");

        // Tentative d'envoi de l'email
        $emailSent = sendConfirmationEmail($email);
        
        if ($emailSent) {
            $_SESSION['success'] = "Inscription réussie. Email de confirmation envoyé.";
        } else {
            $_SESSION['success'] = "Inscription réussie, mais l'email de confirmation n'a pas pu être envoyé.";
        }
    } catch (Exception $e) {
        logDebug("Erreur lors de l'inscription : " . $e->getMessage());
        $_SESSION['error'] = $e->getMessage();
    }
    
    header("Location: newsletter.php");
    exit;
}

// Handle deletion
if (isset($_GET['delete'])) {
    try {
        $id = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
        if ($id === false) {
            throw new Exception("ID invalide.");
        }

        $stmt = $pdo->prepare("DELETE FROM newsletter WHERE id = ?");
        $stmt->execute([$id]);
        
        if ($stmt->rowCount() === 0) {
            throw new Exception("Email non trouvé.");
        }
        
        $_SESSION['success'] = "Email supprimé avec succès.";
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
    
    header("Location: newsletter.php?admin=1");
    exit;
}

// Handle export
if (isset($_GET['export'])) {
    try {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=newsletter_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Email', 'Date d\'inscription', 'IP', 'User Agent']);
        
        $stmt = $pdo->query("SELECT email, date_inscription, ip, user_agent FROM newsletter ORDER BY date_inscription DESC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, $row);
        }
        
        fclose($output);
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = "Erreur lors de l'export : " . $e->getMessage();
        header("Location: newsletter.php?admin=1");
        exit;
    }
}

// Récupération des emails pour l'affichage
try {
    $admin = isset($_GET['admin']);
    $stmt = $pdo->query("SELECT * FROM newsletter ORDER BY date_inscription DESC");
    $emails = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur lors de la récupération des données : " . $e->getMessage();
    $emails = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter - Bénin Tourisme</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f9f9f9; 
            margin: 0; 
            padding: 0; 
        }
        .container { 
            max-width: 800px; 
            margin: 40px auto; 
            padding: 40px; 
            background: white; 
            box-shadow: 0 0 20px rgba(0,0,0,0.1); 
            border-radius: 10px; 
        }
        h2 { 
            text-align: center; 
            color: #1a1a1a; 
            margin-bottom: 30px;
        }
        form { 
            display: flex; 
            gap: 10px; 
            justify-content: center; 
            margin-bottom: 30px; 
        }
        input[type=email] { 
            padding: 12px; 
            flex: 1; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            font-size: 16px;
        }
        input[type=submit] { 
            padding: 12px 24px; 
            background: #007bff; 
            border: none; 
            color: white; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type=submit]:hover {
            background: #0056b3;
        }
        .message { 
            text-align: center; 
            color: #28a745;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            background: #d4edda;
        }
        .error { 
            text-align: center; 
            color: #dc3545;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            background: #f8d7da;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 30px; 
            background: white;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 12px; 
            text-align: left; 
        }
        th { 
            background-color: #007bff; 
            color: white; 
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        .admin-link { 
            text-align: center; 
            margin-top: 20px; 
        }
        .admin-link a {
            color: #007bff;
            text-decoration: none;
        }
        .admin-link a:hover {
            text-decoration: underline;
        }
        .action-link {
            color: #dc3545;
            text-decoration: none;
        }
        .action-link:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 20px;
            }
            form {
                flex-direction: column;
            }
            input[type=email],
            input[type=submit] {
                width: 100%;
            }
            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Inscription à la Newsletter</h2>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="message"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (!$admin): ?>
            <form method="post" action="newsletter.php">
                <input type="email" name="email" placeholder="Votre adresse email" required>
                <input type="submit" value="S'inscrire">
            </form>
            <div class="admin-link">
                <a href="?admin=1">Accéder à l'espace admin</a>
            </div>
        <?php else: ?>
            <div style="text-align:right;">
                <a href="newsletter.php">Quitter l'admin</a>
            </div>
            <?php if (!empty($emails)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>IP</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($emails as $i => $row): ?>
                            <tr>
                                <td><?= $i+1 ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['date_inscription']) ?></td>
                                <td><?= htmlspecialchars($row['ip']) ?></td>
                                <td>
                                    <a href="?admin=1&delete=<?= $row['id'] ?>" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet email ?')"
                                       class="action-link">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div style="text-align:right;margin-top:20px;">
                    <a href="?export=1" class="admin-link">Exporter en CSV</a>
                </div>
            <?php else: ?>
                <p style="text-align:center;">Aucun email inscrit pour le moment.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
