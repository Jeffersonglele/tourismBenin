<?php
session_start();
include_once("config/database.php");
$page_title = "Connexion - Bénin Tourisme";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($email) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nom'] = $user['nom'];
                $_SESSION['user_prenom'] = $user['prenom'];
                $_SESSION['user_email'] = $user['email'];
                
                if (isset($_GET['redirect'])) {
                    header("Location: " . $_GET['redirect']);
                } else {
                    header("Location: ..");
                }
                exit();
            } else {
                $error = "Email ou mot de passe incorrect";
            }
        } catch (PDOException $e) {
            $error = "Une erreur est survenue";
        }
    } else {
        $error = "Tous les champs sont requis";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Bénin Tourisme</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            background: #f0f2f5;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%);
            opacity: 0.95;
            z-index: -1;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            gap: 40px;
            position: relative;
            z-index: 1;
        }

        .photo-section {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 15px;
            padding: 20px;
        }

        .photo-item {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
        }

        .photo-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
        }

        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .photo-item:hover img {
            transform: scale(1.05);
        }

        .photo-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50%;
            background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .photo-item:hover::after {
            opacity: 1;
        }

        .photo-item:nth-child(1) { grid-area: 1 / 1 / 2 / 2; }
        .photo-item:nth-child(2) { grid-area: 1 / 2 / 2 / 3; }
        .photo-item:nth-child(3) { grid-area: 2 / 1 / 3 / 2; }
        .photo-item:nth-child(4) { grid-area: 2 / 2 / 3 / 3; }

        .photo-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 15px;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: white;
            font-size: 14px;
            font-weight: 500;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 2;
        }

        .photo-item:hover .photo-caption {
            opacity: 1;
        }

        .login-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            font-size: 32px;
            color: #1a237e;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            color: #495057;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-group input::placeholder {
            color: #adb5bd;
        }

        .form-group input:focus {
            outline: none;
            border-color: #1a237e;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(26, 35, 126, 0.1);
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background: #1a237e;
            border: none;
            border-radius: 10px;
            color: #fff;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-button:hover {
            background: #0d47a1;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 71, 161, 0.3);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: #6c757d;
            font-size: 13px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #dee2e6;
        }

        .divider::before { margin-right: 18px; }
        .divider::after { margin-left: 18px; }

        .facebook-login {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a237e;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .facebook-login:hover {
            color: #0d47a1;
        }

        .facebook-login i {
            margin-right: 8px;
            color: #1a237e;
        }

        .forgot-password {
            text-align: center;
            font-size: 13px;
            color: #6c757d;
            text-decoration: none;
            display: block;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: #1a237e;
        }

        .signup-box {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #495057;
            margin-top: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .signup-box a {
            color: #1a237e;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .signup-box a:hover {
            color: #0d47a1;
        }

        .error-message {
            color: #dc3545;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            background: rgba(220, 53, 69, 0.1);
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            .photo-section {
                display: none;
            }
            .login-section {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="photo-section">
            <div class="photo-item">
                <img src="assets/images/luxury-hotel.jpg" alt="Hôtel de luxe au Bénin">
                <div class="photo-caption">Hôtel de luxe</div>
            </div>
            <div class="photo-item">
                <img src="assets/images/circuit.jpeg" alt="Circuit touristique">
                <div class="photo-caption">Circuit touristique</div>
            </div>
            <div class="photo-item">
                <img src="assets/images/weloveeya.jpg" alt="Festival culturel">
                <div class="photo-caption">Festival culturel</div>
            </div>
            <div class="photo-item">
                <img src="assets/images/DASSA.png" alt="Destination touristique">
                <div class="photo-caption">Destination touristique</div>
            </div>
        </div>
        <div class="login-section">
            <div class="login-box">
                <div class="logo">
                    <h1>Bénin Tourisme</h1>
                </div>
                <?php if (isset($error)): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Mot de passe" required>
                    </div>
                    <button type="submit" class="login-button">Se connecter</button>
                </form>
                <div class="divider">OU</div>
                <a href="#" class="facebook-login">
                    <i class="fab fa-facebook-square"></i> Se connecter avec Facebook
                </a>
                <a href="#" class="forgot-password">Mot de passe oublié ?</a>
            </div>
            <div class="signup-box">
                Vous n'avez pas de compte ? <a href="#">Inscrivez-vous</a>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
</body>
</html>

