<?php

include_once("includes/navbar.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À Propos - Bénin Tourisme</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>tailwind.config={theme:{extend:{colors:{primary:'#3b82f6',secondary:'#10b981'},borderRadius:{'none':'0px','sm':'4px',DEFAULT:'8px','md':'12px','lg':'16px','xl':'20px','2xl':'24px','3xl':'32px','full':'9999px','button':'8px'}}}}</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <style>
           body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: white;
        }
        
        .slider-container {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            background-color: white;
        }
        
        .slider {
            position: relative;
            width: 100%;
            height: 100%;
        }
        
        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        
        .slide.active {
            opacity: 1;
            z-index: 2;
        }
        
        .text-content {
            width: 50%;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            overflow-y: auto;
            max-height: 100vh;
        }
        
        .text-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #1a1a1a;
        }
        
        .text-content p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
            white-space: pre-line;
        }
        
        .image-content {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }
        
        .image-content img {
            max-height: 80%;
            max-width: 100%;
            object-fit: contain;
        }

        .skip-button {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 100;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .skip-button:hover {
            background-color: rgba(0, 0, 0, 0.9);
            transform: scale(1.05);
        }

        /* Style pour la barre de défilement */
        .text-content::-webkit-scrollbar {
            width: 8px;
        }

        .text-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .text-content::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .text-content::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
</head>
<body class="bg-white">
    <!-- Section Héro -->
    <section class="relative min-h-screen flex items-center justify-center py-32 mb-12">
        <div class="absolute inset-0 z-0">
            <img src="assets/images/collage.jpeg" alt="Hero Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 drop-shadow-lg">Découvrez l'Héritage du Bénin</h1>
            <p class="text-xl md:text-2xl text-white max-w-4xl mx-auto drop-shadow-md">
                Bienvenue au Bénin, une terre riche en histoire et en culture vibrante. Rejoignez BéninDécouverte pour explorer les royaumes anciens, les marchés animés et les paysages à couper le souffle. Découvrez le cœur de l'Afrique de l'Ouest avec nos circuits et expériences soigneusement sélectionnés. Commencez votre aventure aujourd'hui !
            </p>
        </div>
    </section>

    <!-- Section Histoire -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="w-full">
                    <img src="assets/images/Monuments Bio Guera.jpeg" alt="Histoire du Bénin" 
                         class="w-full h-[300px] object-cover rounded-lg shadow-lg transition-transform duration-300 hover:scale-[1.03]">
                </div>
                <div>
                    <h2 class="text-3xl font-bold mb-8 relative pb-4 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-24 after:h-1 after:bg-blue-600">
                        Explorez l'Histoire Riche du Bénin
                    </h2>
                    <p class="text-lg text-gray-700">
                        Plongez dans le passé fascinant du Bénin, où les royaumes anciens ont prospéré et les cultures vibrantes se sont épanouies. Ce voyage dans le temps révèle les racines du riche patrimoine du Bénin, mettant en lumière son importance dans l'histoire de l'Afrique de l'Ouest.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Culture -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="order-2 md:order-1">
                    <h2 class="text-3xl font-bold mb-8 relative pb-4 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-24 after:h-1 after:bg-blue-600">
                        Découvrez la Culture Vibrante
                    </h2>
                    <p class="text-lg text-gray-700">
                        Le Bénin est une terre de traditions riches et de cultures vibrantes, où les pratiques ancestrales se mêlent harmonieusement aux influences modernes. Des festivals colorés aux formes d'art uniques, chaque aspect de la culture béninoise raconte une histoire qui attend d'être découverte.
                    </p>
                </div>
                <div class="order-1 md:order-2">
                    <img src="assets/images/Tradition.jpeg" alt="Culture du Bénin" 
                         class="w-full h-[300px] object-cover rounded-lg shadow-lg transition-transform duration-300 hover:scale-[1.03]">
                </div>
            </div>
        </div>
    </section>
    <!-- Section lieu -->
    <section class="py-16">
    <div class="slider-container">
        <div class="slider">
            <!-- Slides will be dynamically added here -->
        </div>
    </div>

    <button class="skip-button" onclick="skipIntro()">
        Passer l'intro
    </button> 
                      
    </section>
   
    
    <!-- Section Statistiques -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Carte Art -->
                <div class="bg-white rounded-lg shadow-lg p-8 transition-transform duration-300 hover:-translate-y-2">
                    <img src="assets/images/art.jpg" alt="Art du Bénin" 
                         class="w-full h-[200px] object-cover rounded-lg mb-6">
                    <div class="text-4xl font-bold text-blue-600 mb-2">500+</div>
                    <h3 class="text-xl font-semibold mb-4">Œuvres d'Art</h3>
                    <p class="text-gray-600">
                        Explorez la diversité des artisanats traditionnels, incluant les textiles complexes et les sculptures impressionnantes qui reflètent la créativité des artisans locaux.
                    </p>
                </div>

                <!-- Carte Festivals -->
                <div class="bg-white rounded-lg shadow-lg p-8 transition-transform duration-300 hover:-translate-y-2">
                    <img src="assets/images/festival.jpeg" alt="Festivals du Bénin" 
                         class="w-full h-[200px] object-cover rounded-lg mb-6">
                    <div class="text-4xl font-bold text-blue-600 mb-2">200+</div>
                    <h3 class="text-xl font-semibold mb-4">Festivals</h3>
                    <p class="text-gray-600">
                        Participez aux célébrations des festivals animés du Bénin, où la musique, la danse et les rituels traditionnels se réunissent pour créer des expériences inoubliables.
                    </p>
                </div>

                <!-- Carte Cuisine -->
                <div class="bg-white rounded-lg shadow-lg p-8 transition-transform duration-300 hover:-translate-y-2">
                    <img src="assets/images/cuisine.jpeg" alt="Cuisine du Bénin" 
                         class="w-full h-[200px] object-cover rounded-lg mb-6">
                    <div class="text-4xl font-bold text-blue-600 mb-2">30+</div>
                    <h3 class="text-xl font-semibold mb-4">Cuisines</h3>
                    <p class="text-gray-600">
                        Savourez les saveurs du Bénin à travers ses délicieuses cuisines, qui sont une fusion d'ingrédients locaux et de traditions culinaires transmises de génération en génération.
                    </p>
                </div>

                <!-- Carte Langues -->
                <div class="bg-white rounded-lg shadow-lg p-8 transition-transform duration-300 hover:-translate-y-2">
                    <img src="assets/images/langues.jpg" alt="Langues du Bénin" 
                         class="w-full h-[200px] object-cover rounded-lg mb-6">
                    <div class="text-4xl font-bold text-blue-600 mb-2">15+</div>
                    <h3 class="text-xl font-semibold mb-4">Langues</h3>
                    <p class="text-gray-600">
                        Découvrez la diversité linguistique du Bénin, où de multiples langues sont parlées, chacune ajoutant à la riche tapisserie de l'identité de la nation.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>
</body>
</html> 