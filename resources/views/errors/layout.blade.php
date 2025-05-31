<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - STARS</title>
    
    <!-- Favicons -->
    <link href="{{ asset('img/logo.svg') }}" rel="icon">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-color: #102044;
            --secondary-color: #1a2a4d;
            --accent-color: #fa9d1c;
            --text-color: #444444;
            --heading-color: #293c5d;
            --light-text: #777;
            --white: #fff;
            --light-gray: #f8f9fc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: var(--white);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .error-container {
            text-align: center;
            padding: 2rem;
            max-width: 600px;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        .error-logo {
            width: 120px;
            height: 120px;
            margin-bottom: 2rem;
            filter: drop-shadow(0 0 20px rgba(250, 157, 28, 0.3));
            animation: float 3s infinite ease-in-out;
        }

        .error-code {
            font-size: 6rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 0.5rem;
            text-shadow: 0 4px 20px rgba(255, 255, 255, 0.1);
            animation: glow 3s infinite ease-in-out alternate;
        }

        .error-title {
            font-size: 2rem;
            font-weight: 600;
            color: var(--accent-color);
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .error-message {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, var(--accent-color), #f38c00);
            color: var(--white);
            padding: 1rem 2rem;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(250, 157, 28, 0.3);
            font-size: 1rem;
        }

        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(250, 157, 28, 0.4);
            color: var(--white);
            text-decoration: none;
        }

        .stars-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: var(--white);
            border-radius: 50%;
            animation: twinkle 4s infinite ease-in-out;
        }

        .star:nth-child(even) {
            animation-delay: 2s;
        }

        .star:nth-child(3n) {
            animation-delay: 1s;
        }

        .shooting-star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: var(--accent-color);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--accent-color);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        @keyframes glow {
            0% { text-shadow: 0 4px 20px rgba(255, 255, 255, 0.1); }
            100% { text-shadow: 0 4px 30px rgba(255, 255, 255, 0.2), 0 0 40px rgba(250, 157, 28, 0.1); }
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.2); }
        }

        @keyframes shoot {
            0% {
                transform: translateX(-100px) translateY(100px);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateX(100vw) translateY(-100px);
                opacity: 0;
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @media (max-width: 768px) {
            .error-logo {
                width: 80px;
                height: 80px;
                margin-bottom: 1.5rem;
            }
            
            .error-code {
                font-size: 4rem;
            }
            
            .error-icon {
                font-size: 5rem;
            }
            
            .error-title {
                font-size: 1.5rem;
            }
            
            .error-message {
                font-size: 1rem;
            }
            
            .error-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="stars-bg">
        <!-- Stars will be generated by JavaScript -->
    </div>
    
    <div class="error-container">
        <img src="{{ asset('img/logo.svg') }}" alt="STARS Logo" class="error-logo">
        <div class="error-code">@yield('code')</div>
        <div class="error-title">@yield('title')</div>
        <div class="error-message">@yield('message')</div>
        <a href="{{ url('/') }}" class="btn-home">
            <i class="bi bi-house-door"></i>
            Kembali ke Beranda
        </a>
    </div>

    <script>
        // Generate random stars
        function createStars() {
            const starsContainer = document.querySelector('.stars-bg');
            const numStars = 50;
            
            for (let i = 0; i < numStars; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                star.style.left = Math.random() * 100 + '%';
                star.style.top = Math.random() * 100 + '%';
                star.style.animationDelay = Math.random() * 4 + 's';
                starsContainer.appendChild(star);
            }
        }

        // Create shooting star
        function createShootingStar() {
            const starsContainer = document.querySelector('.stars-bg');
            const shootingStar = document.createElement('div');
            shootingStar.className = 'shooting-star';
            shootingStar.style.left = '-100px';
            shootingStar.style.top = Math.random() * 50 + '%';
            shootingStar.style.animation = 'shoot 3s linear';
            
            starsContainer.appendChild(shootingStar);
            
            setTimeout(() => {
                shootingStar.remove();
            }, 3000);
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            createStars();
            
            // Create shooting star every 5 seconds
            setInterval(createShootingStar, 5000);
        });
    </script>
</body>
</html>
