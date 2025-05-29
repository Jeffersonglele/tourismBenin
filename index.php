<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie d'Images</title>
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
</head>
<body>
    <div class="slider-container">
        <div class="slider">
            <!-- Slides will be dynamically added here -->
        </div>
    </div>

    <button class="skip-button" onclick="skipIntro()">
        Passer l'intro
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = [
                {
                    image: '1.jpg',
                    title: 'Section 1',
                    description: 'Restitution des objets royaux'
                },
                {
                    image: '2.jpg',
                    title: 'Section 2',
                    description: 'Yves Appolinaire Pèdé est né en 1959 au Bénin et est décédé en 2019.\nSon œuvre reprend l\'héritage de l\'art de cour de l\'ancien royaume du Danxomè, notamment l\'appliqué sur toile rendu célèbre par la famille Yèmadjè.'
                },
                {
                    image: '5.jpg',
                    title: 'Section 3',
                    description: 'Euloge Ahanhanzo-Glèlè nous fait découvrir l\'âme du Bénin avec ses sculptures en terre cuite, inspirées de l\'histoire. Un hommage vibrant aux hommes et aux femmes qui bâtissent notre héritage.'
                },
                {
                    image: '6.jpg',
                    title: 'Section 4',
                    description: 'Des œuvres d\'art en métal pillées par des soldats coloniaux français lors d\'une exposition d\'objets béninois saisis à la présidence à Cotonou (Bénin), le 18 février 2022.'
                },
                {
                    image: '7.jpg',
                    title: 'Section 5',
                    description: 'François AZIANGUÉ\nNé en 1982 au Togo, François Aziangué s\'oriente d\'abord vers la soudure avant de s\'en détourner pour se lancer dans la création artistique.\nL\'abnégation dont elles font montre dans toutes les situations inspire à François Aziangué ses sculptures à leur effigie. On ne peut toutefois pas s\'empêcher de voir dans l\'histoire sculptée de ces femmes altières, de ces Demoiselles d\'Abomey, un pied de nez respectueux à d\'autres demoiselles, celles d\'Avignon d\'un certain Pablo Picasso.'
                },
                {
                    image: '9.jpg',
                    title: 'Section 6',
                    description: 'Siège du roi Béhanzin en vitrine'
                }
            ];
            
            let currentIndex = 0;
            const slideDelay = 3000; // 3 seconds per slide
            let isTransitioning = false;
            let totalDuration = slides.length * slideDelay;
            let startTime = Date.now();
            
            const slider = document.querySelector('.slider');
            
            // Create slides
            slides.forEach((slide, index) => {
                const slideElement = document.createElement('div');
                slideElement.className = `slide ${index === 0 ? 'active' : ''}`;
                
                // Create text content
                const textContent = document.createElement('div');
                textContent.className = 'text-content';
                
                const title = document.createElement('h2');
                title.className = 'text-4xl font-bold mb-4';
                title.textContent = slide.title;
                
                const description = document.createElement('p');
                description.className = 'text-lg';
                description.textContent = slide.description;
                
                textContent.appendChild(title);
                textContent.appendChild(description);
                
                // Create image content
                const imageContent = document.createElement('div');
                imageContent.className = 'image-content';
                
                const img = document.createElement('img');
                img.src = slide.image;
                img.alt = slide.title;
                
                imageContent.appendChild(img);
                
                // Add content to slide
                slideElement.appendChild(textContent);
                slideElement.appendChild(imageContent);
                
                slider.appendChild(slideElement);
            });
            
            // Start slideshow
            setInterval(() => {
                if (!isTransitioning) {
                    nextSlide();
                }
            }, slideDelay);

            // Check if intro is finished
            setInterval(() => {
                if (Date.now() - startTime >= totalDuration) {
                    redirectToMain();
                }
            }, 1000);
            
            function nextSlide() {
                goToSlide((currentIndex + 1) % slides.length);
            }
            
            function goToSlide(index) {
                if (isTransitioning || index === currentIndex) return;
                
                isTransitioning = true;
                const slideElements = document.querySelectorAll('.slide');
                
                // Fade out current slide
                slideElements[currentIndex].classList.remove('active');
                
                // Update current index
                currentIndex = index;
                
                // Fade in new slide
                slideElements[currentIndex].classList.add('active');
                
                // Reset transition flag after animation
                setTimeout(() => {
                    isTransitioning = false;
                }, 500);
            }

            // Make skipIntro function available globally
            window.skipIntro = function() {
                redirectToMain();
            };

            function redirectToMain() {
                window.location.href = 'main.php';
            }
        });
    </script>
</body>
</html>