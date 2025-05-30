<?php include_once("includes/navbar.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À Propos - Bénin Tourisme</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        html { scroll-behavior: smooth; }
        .glass {
            @apply backdrop-blur-lg bg-white/20 border border-white/30 shadow-xl rounded-xl;
        }
    </style>
</head>
<body class="bg-[#fdfdfd] text-gray-800">

    <!-- Section Héro avec effet de verre -->
    <section class="relative min-h-screen flex items-center justify-center px-6 py-32">
        <img src="assets/images/collage.jpeg" alt="Hero" class="absolute inset-0 object-cover w-full h-full z-0" />
        <div class="absolute inset-0 bg-black bg-opacity-60 z-0"></div>
        <div class="relative z-10 text-center max-w-4xl glass p-8 text-white">
            <h1 class="text-5xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">Découvrez l'Héritage du Bénin</h1>
            <p class="text-lg md:text-xl font-light drop-shadow">
                Une terre d’histoire, de royaumes anciens et de culture vibrante. Explorez le Bénin à travers ses trésors cachés, ses traditions vivantes et sa richesse naturelle. Commencez l’aventure maintenant !
            </p>
        </div>
    </section>

    <!-- Section Histoire -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <img src="assets/images/Monuments Bio Guera.jpeg" alt="Histoire du Bénin" class="rounded-xl shadow-lg hover:scale-105 transition-transform duration-300">
            <div>
                <h2 class="text-4xl font-bold mb-6 border-l-4 border-blue-600 pl-4">L’Histoire du Bénin</h2>
                <p class="text-lg text-gray-700 leading-relaxed">
                    Remontez le temps et découvrez les royaumes qui ont marqué le territoire béninois. Des traditions royales à l'art ancien, chaque coin du pays est empreint d’une mémoire culturelle profonde.
                </p>
            </div>
        </div>
    </section>

    <!-- Section Culture -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div class="order-2 md:order-1">
                <h2 class="text-4xl font-bold mb-6 border-l-4 border-yellow-500 pl-4">Une Culture Vivante</h2>
                <p class="text-lg text-gray-700 leading-relaxed">
                    Le Bénin est le berceau de traditions uniques, du culte Vaudou aux danses folkloriques en passant par les arts sculpturaux. Une immersion inoubliable vous attend !
                </p>
            </div>
            <img src="assets/images/Tradition.jpeg" alt="Culture" class="rounded-xl shadow-lg hover:scale-105 transition-transform duration-300 order-1 md:order-2">
        </div>
    </section>

    <!-- Section Lieux -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-12">Lieux Incontournables</h2>
            <div class="flex overflow-x-auto gap-6 scrollbar-hide pb-4 snap-x snap-mandatory">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <div class="snap-center shrink-0 w-80 h-64 rounded-xl overflow-hidden shadow-lg transform hover:scale-105 transition-transform duration-300">
                        <img src="assets/images/<?= $i ?>.jpg" class="w-full h-full object-cover" />
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>
    <!-- Section Statistiques Animées -->
<section class="py-20 bg-gray-100">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-16">Un Pays, Mille Richesses</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            
            <!-- Art -->
            <div class="bg-white p-6 rounded-xl shadow-xl text-center hover:shadow-2xl transition duration-300">
                <img src="assets/images/art.jpg" alt="Art du Bénin" class="rounded-lg w-full h-40 object-cover mb-4">
                <div class="text-4xl font-bold text-blue-600 mb-1 counter" data-target="500">0</div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Œuvres d'Art</h3>
                <p class="text-gray-600 text-sm">Textiles, sculptures et artisanats traditionnels.</p>
            </div>

            <!-- Festivals -->
            <div class="bg-white p-6 rounded-xl shadow-xl text-center hover:shadow-2xl transition duration-300">
                <img src="assets/images/festival.jpeg" alt="Festivals du Bénin" class="rounded-lg w-full h-40 object-cover mb-4">
                <div class="text-4xl font-bold text-blue-600 mb-1 counter" data-target="200">0</div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Festivals</h3>
                <p class="text-gray-600 text-sm">Musique, rituels et danses traditionnelles.</p>
            </div>

            <!-- Cuisine -->
            <div class="bg-white p-6 rounded-xl shadow-xl text-center hover:shadow-2xl transition duration-300">
                <img src="assets/images/cuisine.jpeg" alt="Cuisine du Bénin" class="rounded-lg w-full h-40 object-cover mb-4">
                <div class="text-4xl font-bold text-blue-600 mb-1 counter" data-target="30">0</div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Cuisines</h3>
                <p class="text-gray-600 text-sm">Plats typiques et recettes locales à découvrir.</p>
            </div>

            <!-- Langues -->
            <div class="bg-white p-6 rounded-xl shadow-xl text-center hover:shadow-2xl transition duration-300">
                <img src="assets/images/langues.jpg" alt="Langues du Bénin" class="rounded-lg w-full h-40 object-cover mb-4">
                <div class="text-4xl font-bold text-blue-600 mb-1 counter" data-target="15">0</div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Langues</h3>
                <p class="text-gray-600 text-sm">Une diversité linguistique unique et vivante.</p>
            </div>

        </div>
    </div>
</section>

<!-- Script d'animation des chiffres -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('.counter');

    counters.forEach(counter => {
        const animate = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const increment = Math.ceil(target / 100);

            if (count < target) {
                counter.innerText = count + increment;
                setTimeout(animate, 30);
            } else {
                counter.innerText = target + "+";
            }
        };

        animate();
    });
});
</script>



    <?php include('includes/footer.php'); ?>
</body>
</html>
