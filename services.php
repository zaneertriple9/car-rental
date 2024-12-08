
<?php
session_start();
error_reporting(0);
include('includes/config.php');
?> 
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<title>FritzAnn Shuttle Services  | services</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<link href="assets/css/slick.css" rel="stylesheet">
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<link href="assets/css/font-awesome.min.css" rel="stylesheet">     
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
<?php include('includes/header.php');?>
</head>
<style>
      /* Modern CSS Reset and Variables */
      :root {
            --neon-red: #ff2d55;
            --neon-blue: #0ff;
            --dark-bg: #0a0a0f;
            --card-bg: #151520;
            --text-glow: 0 0 10px rgba(0, 255, 255, 0.5);
            --card-glow: 0 0 20px rgba(255, 45, 85, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Rajdhani', sans-serif;
        }

        body {
            background: var(--dark-bg);
            color: #fff;
            overflow-x: hidden;
        }

        /* Cyberpunk Header */
        .header {
            height: 100vh;
            position: relative;
            overflow: hidden;
            background: var(--dark-bg);
        }

        .header-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 2;
            width: 100%;
            padding: 0 20px;
        }

        .header-content h1 {
            font-size: 4.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: #fff;
            text-shadow: 0 0 20px var(--neon-blue);
            animation: glitch 2s infinite;
        }

        .header-content p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 20px auto;
            color: rgba(255, 255, 255, 0.8);
        }

        /* Horizontal Car Showcase */
        .car-showcase {
            position: relative;
            padding: 4rem 0;
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            background: linear-gradient(180deg, var(--dark-bg) 0%, #1a1a2e 100%);
        }

        .car-showcase::-webkit-scrollbar {
            display: none;
        }

        .car-container {
            display: inline-flex;
            padding: 0 2rem;
        }

        .car-card {
            width: 400px;
            height: 600px;
            margin-right: 2rem;
            background: var(--card-bg);
            border: 1px solid rgba(255, 45, 85, 0.2);
            border-radius: 8px;
            position: relative;
            overflow: hidden;
            display: inline-block;
            white-space: normal;
            vertical-align: top;
            box-shadow: var(--card-glow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .car-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 0 30px rgba(255, 45, 85, 0.4);
        }

        .car-image {
            width: 100%;
            height: 300px;
            position: relative;
            overflow: hidden;
        }

        .car-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .car-card:hover .car-image img {
            transform: scale(1.1);
        }

        .car-content {
            padding: 2rem;
            position: relative;
        }

        .car-content h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--neon-red);
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .car-content p {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .neon-line {
            width: 50%;
            height: 2px;
            background: var(--neon-red);
            margin: 1rem 0;
            position: relative;
            overflow: hidden;
        }

        .neon-line::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, #fff, transparent);
            animation: neonFlow 2s linear infinite;
        }

        /* Cyberpunk Animations */
        @keyframes glitch {
            0% {
                text-shadow: 0.05em 0 0 var(--neon-red), -0.05em -0.025em 0 var(--neon-blue);
            }
            14% {
                text-shadow: 0.05em 0 0 var(--neon-red), -0.05em -0.025em 0 var(--neon-blue);
            }
            15% {
                text-shadow: -0.05em -0.025em 0 var(--neon-red), 0.025em 0.025em 0 var(--neon-blue);
            }
            49% {
                text-shadow: -0.05em -0.025em 0 var(--neon-red), 0.025em 0.025em 0 var(--neon-blue);
            }
            50% {
                text-shadow: 0.025em 0.05em 0 var(--neon-red), 0.05em 0 0 var(--neon-blue);
            }
            99% {
                text-shadow: 0.025em 0.05em 0 var(--neon-red), 0.05em 0 0 var(--neon-blue);
            }
            100% {
                text-shadow: -0.025em 0 0 var(--neon-red), -0.025em -0.025em 0 var(--neon-blue);
            }
        }

        @keyframes neonFlow {
            0% {
                left: -100%;
            }
            100% {
                left: 100%;
            }
        }
        .scroll-indicator {
            position: fixed;
            bottom: 2rem;
            font-size: 1rem;
            color: var(--neon-red);
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            animation: pulse 2s infinite;
        }

        .scroll-indicator.scroll-back {
            left: 2rem;
        }

        .scroll-indicator.scroll-forward {
            right: 2rem;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }
            50% {
                opacity: 0.3;
            }
            100% {
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-content h1 {
                font-size: 3rem;
            }

            .car-card {
                width: 300px;
                height: 500px;
            }

            .car-image {
                height: 200px;
            }
        }
  </style>
</head>
<body>
<header style="background-color: black; padding: 20px; text-align: center; font-family: 'Orbitron', sans-serif; color: #0ff;">
    <h1 style="color: #641010; ">
        Exceptional services for all your car rental needs.
    </h1>
    <p style="color:#f2f2f2; font-size: 17px; ">
        Fritzann Carental is dedicated to providing a hassle-free rental experience with the highest standards of honesty, trust, and professionalism.
    </p>
    <p style="color:#f2f2f2; font-size: 17px; ">
       Our mission remains unchanged: to provide safe, reliable, and efficient shuttle services to individuals, gov't, & private organizations in need of transportation solutions. With this new corporate structure, we are poised to take on larger projects, offer more comprehensive services, and solidify our position as a leader in the Shuttle Service industry in South Cotabato.

    </p>
</header>


    <div class="car-showcase" id="carShowcase">
    <div class="car-container">
        <div class="car-card">
            <div class="car-image">
                <img src="SERVICES/download (13).jpg" alt="Self Drive">
            </div>
            <div class="car-content">
                <h2>Self Drive – Fritzann Vehicles</h2>
                <div class="neon-line"></div>
                <p>Enjoy self-drive freedom with Fritzann. Rent a vehicle with flexible pricing and easy access. Choose from three booking options: No Account, With Account, or Walk-in.</p>
            </div>
        </div>

        <div class="car-card">
            <div class="car-image">
                <img src="SERVICES/download (14).jpg" alt="With Driver">
            </div>
            <div class="car-content">
                <h2>With Driver – Fritzann Vehicles</h2>
                <div class="neon-line"></div>
                <p>Travel in comfort with a professional driver from Fritzann. Rent a vehicle with flexible pricing and enjoy stress-free journeys. Choose from three booking options: No Account, With Account, or Walk-in.</p>
            </div>
        </div>

        <div class="car-card">
            <div class="car-image">
                <img src="SERVICES/download (15).jpg" alt="Car/Van">
            </div>
            <div class="car-content">
                <h2>Fritzann - Vehicles</h2>
                <div class="neon-line"></div>
                <p>Choose from a wide range of well-maintained vehicles, designed for comfort, safety, and reliability.</p>
            </div>
        </div>

        <div class="car-card">
            <div class="car-image">
                <img src="SERVICES/Zee Break Free Poster.jpg" alt="Group Tours">
            </div>
            <div class="car-content">
                <h2>Group Tours – Fritzann</h2>
                <div class="neon-line"></div>
                <p>Explore new destinations with Fritzann's group tours. Enjoy comfortable travel, flexible itineraries, and expert guides, all tailored to your group's needs.</p>
            </div>
        </div>

        <div class="car-card">
            <div class="car-image">
                <img src="SERVICES/download (16).jpg" alt="Family">
            </div>
            <div class="car-content">
                <h2>Family – Fritzann</h2>
                <div class="neon-line"></div>
                <p>Make family travel easy and comfortable with Fritzann. Choose from a variety of spacious, family-friendly vehicles designed for comfort, safety, and convenience.</p>
            </div>
        </div>
    </div>
</div>

    <div class="scroll-indicator scroll-back" id="scrollBack">← Scroll Back</div>
    <div class="scroll-indicator scroll-forward" id="scrollForward">Scroll to explore →</div>
    <script>
        const scrollForward = document.getElementById('scrollForward');
        const scrollBack = document.getElementById('scrollBack');
        const carShowcase = document.getElementById('carShowcase');

        // Scroll Forward
        scrollForward.addEventListener('click', () => {
            carShowcase.scrollBy({
                left: 400, // Scroll distance
                behavior: 'smooth'
            });
        });

        // Scroll Back
        scrollBack.addEventListener('click', () => {
            carShowcase.scrollBy({
                left: -400, // Negative scroll distance for backward
                behavior: 'smooth'
            });
        });

        // Hide indicators at scroll limits
        carShowcase.addEventListener('scroll', () => {
            const maxScrollLeft = carShowcase.scrollWidth - carShowcase.clientWidth;

            // Hide back button at start
            if (carShowcase.scrollLeft <= 0) {
                scrollBack.style.display = 'none';
            } else {
                scrollBack.style.display = 'block';
            }

            // Hide forward button at end
            if (carShowcase.scrollLeft >= maxScrollLeft) {
                scrollForward.style.display = 'none';
            } else {
                scrollForward.style.display = 'block';
            }
        });

        // Initial visibility check
        carShowcase.dispatchEvent(new Event('scroll'));
    </script>


<?php include('includes/footer.php');?>

<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>

<?php include('includes/login.php');?>

<?php include('includes/registration.php');?>


<?php include('includes/forgotpassword.php');?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script>
</body>
</html>