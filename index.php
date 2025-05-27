<?php
session_start();
// Utiliser les chemins relatifs corrects pour les includes
include_once(__DIR__ . "/config/database.php");
include_once(__DIR__ . "/includes/header.php");
include_once(__DIR__ . "/includes/navbar.php");

// Récupérer les destinations populaires
try {
    $stmt = $pdo->query("SELECT * FROM lieux ORDER BY id DESC LIMIT 6");
    $destinations = $stmt->fetchAll();
} catch (PDOException $e) {
    $destinations = [];
    $error = "Erreur lors de la récupération des destinations";
}
?>

<!-- Hero Section -->
<section class="hero-section" style="background-image: url('assets\images\DASSA.png');">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="row min-vh-100 align-items-center">
            <div class="col-md-8 text-white">
                <h1 class="display-4 fw-bold mb-4">Découvrez le Bénin</h1>
                <p class="lead mb-4">Explorez les merveilles de notre pays à travers des expériences uniques et mémorables.</p>
                <a href="index.php#destinations" class="btn btn-primary btn-lg">Découvrir</a>
            </div>
        </div>
    </div>
</section>

<!-- Destinations Populaires -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Destinations Populaires</h2>
        <div class="row">
            <?php if (!empty($destinations)): ?>
                <?php foreach ($destinations as $destination): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="<?= htmlspecialchars($destination['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($destination['nom']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($destination['nom']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars(substr($destination['description'], 0, 100)) ?>...</p>
                                <a href="pages/lieu_detail.php?id=<?= $destination['id'] ?>" class="btn btn-primary">En savoir plus</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>Aucune destination disponible pour le moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include_once(__DIR__ . "/includes/footer.php"); ?>

<script>
    // Splash screen handling
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            const splash = document.getElementById('splash-screen');
            if (splash) {
                splash.style.opacity = '0';
                setTimeout(() => {
                    splash.style.display = 'none';
                    // Show navbar after splash screen
                    const navbar = document.getElementById('navbar');
                    if (navbar) {
                        navbar.classList.add('visible');
                    }
                }, 700);
            }
        }, 3000);

        // Scroll reveal animation
        const scrollReveal = () => {
            const elements = document.querySelectorAll('.scroll-reveal');
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                if (elementTop < window.innerHeight - elementVisible) {
                    element.classList.add('active');
                }
            });
        };

        window.addEventListener('scroll', scrollReveal);
        scrollReveal(); // Initial check

        // Navbar scroll effect
        let lastScroll = 0;
        const navbar = document.getElementById('navbar');

        if (navbar) {
            window.addEventListener('scroll', () => {
                const currentScroll = window.pageYOffset;
                
                if (currentScroll <= 0) {
                    navbar.classList.remove('scrolled');
                    return;
                }
                
                if (currentScroll > lastScroll && currentScroll > 100) {
                    // Scrolling down
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    // Scrolling up
                    navbar.style.transform = 'translateY(0)';
                    navbar.classList.add('scrolled');
                }
                
                lastScroll = currentScroll;
            });
        }

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Smooth scroll with offset for fixed navbar
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    const navbarHeight = document.getElementById('navbar')?.offsetHeight || 0;
                    const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>
</rewritten_file>