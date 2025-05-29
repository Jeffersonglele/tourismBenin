<?php
session_start();
include_once(__DIR__ . "/config/database.php");

// Solution pour le flash de la navbar
echo '<style>html { visibility: hidden; opacity: 0; }</style>';

include_once(__DIR__ . "/includes/navbar.php");
include_once(__DIR__ . "/includes/header.php");

try {
    $stmt = $pdo->query("SELECT * FROM lieux ORDER BY id DESC LIMIT 6");
    $destinations = $stmt->fetchAll();
} catch (PDOException $e) {
    $destinations = [];
    $error = "Erreur lors de la récupération des destinations";
}
?>

<!-- Destinations Populaires -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-16 text-indigo-700 animate-fade-in">
            Destinations Populaires
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php if (!empty($destinations)): ?>
                <?php foreach ($destinations as $destination): ?>
                    <div class="
                        bg-white rounded-xl shadow-lg overflow-hidden
                        hover:shadow-xl transition-all duration-500
                        animate-fade-in-up hover:-translate-y-2
                        flex flex-col"
                        style="animation-delay: <?= $destination['id'] * 0.1 ?>s">
                        <img 
                            src="<?= htmlspecialchars($destination['image']) ?>" 
                            class="w-full h-56 object-cover transition-transform duration-500 hover:scale-105"
                            alt="<?= htmlspecialchars($destination['nom']) ?>"
                            loading="lazy" <!-- Optimisation du chargement -->
                        >
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">
                                <?= htmlspecialchars($destination['nom']) ?>
                            </h3>
                            <p class="text-gray-600 mb-6 flex-grow">
                                <?= htmlspecialchars(substr($destination['description'], 0, 100)) ?>...
                            </p>
                            <div class="mt-auto">
                                <a 
                                    href="pages/lieu_detail.php?id=<?= $destination['id'] ?>" 
                                    class="newsletter-btn w-full px-4 py-2 text-white rounded-lg font-semibold no-underline"
                                >
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-12 animate-fade-in">
                    <p class="text-gray-500 text-lg">Aucune destination disponible pour le moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include_once(__DIR__ . "/includes/footer.php"); ?>

<style>
    /* Styles optimisés pour la navbar */
    nav {
        transform: translateY(-100%);
        transition: transform 0.3s ease;
    }
    
    .newsletter-input {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .newsletter-input:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: #f97316;
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
    }

    .newsletter-btn {
        background: linear-gradient(45deg, #f97316, #718096);
        transition: all 0.3s ease;
    }

    .newsletter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes fadeInUp {
        from { 
            opacity: 0;
            transform: translateY(20px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fadeIn 1s ease-out forwards;
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
        opacity: 0;
    }
</style>

<script>
    // Solution pour le flash de la navbar
    document.addEventListener('DOMContentLoaded', function() {
        // Affiche toute la page
        document.documentElement.style.visibility = 'visible';
        document.documentElement.style.opacity = '1';
        
        // Anime la navbar
        document.querySelector('nav').style.transform = 'translateY(0)';
        
        // Animation des cartes au scroll
        const animateCardsOnScroll = () => {
            const cards = document.querySelectorAll('.animate-fade-in-up');
            cards.forEach(card => {
                const cardTop = card.getBoundingClientRect().top;
                const cardVisible = 100;
                
                if (cardTop < window.innerHeight - cardVisible) {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }
            });
        };

        // Initial trigger
        animateCardsOnScroll();
        
        // Trigger on scroll
        window.addEventListener('scroll', animateCardsOnScroll);

        // Hover effect for images
        const cards = document.querySelectorAll('.bg-white.rounded-xl');
        cards.forEach(card => {
            const img = card.querySelector('img');
            
            card.addEventListener('mouseenter', () => {
                img.style.transform = 'scale(1.05)';
            });
            
            card.addEventListener('mouseleave', () => {
                img.style.transform = 'scale(1)';
            });
        });
        
        // Corrige le saut de scroll
        if (window.location.hash) {
            setTimeout(function() {
                window.scrollTo(0, 0);
            }, 1);
        }
    });
</script>
