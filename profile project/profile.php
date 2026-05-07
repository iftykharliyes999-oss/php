<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>IF-T PORTFOLIO</title>

    <!-- CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

    <!-- ================= CURSOR ================= -->

    <div class="cursor"></div>

    <!-- ================= NAVBAR ================= -->

    <nav class="navbar">

        <div class="logo">
            IF-T KHAR LIYES
        </div>

        <ul class="nav-links">

            <li><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#skills">Skills</a></li>
            <li><a href="#">Projects</a></li>
            <li><a href="#">Contact</a></li>

        </ul>

    </nav>

    <!-- ================= HERO ================= -->

    <section class="hero">

        <!-- animated blobs -->
        <div class="blob blob1"></div>
        <div class="blob blob2"></div>
        <div class="grid-bg"></div>

        <!-- particles -->
        <canvas id="canvas"></canvas>

        <div class="hero-content">

            <p class="small-title">
                FULL STACK WEB DEVELOPER
            </p>

            <h1>

                BUILDING
                <span>DIGITAL</span>
                EXPERIENCES
                THAT FEEL
                <span>FUTURISTIC.</span>

            </h1>

            <p class="hero-text">

                I create high-performance web applications with modern UI,
                powerful backend architecture and immersive user experiences.

            </p>

            <div class="hero-buttons">

                <a href="#" class="btn primary-btn">
                    Explore Work
                </a>

                <a href="#" class="btn secondary-btn">
                    Hire Me
                </a>

            </div>

        </div>

    </section>

    <!-- ================= ABOUT ================= -->

    <section class="about" id="about">

        <div class="about-image">

            <div class="image-border"></div>

            <img src="WhatsApp Image 2026-04-27 at 23.55.27.jpeg" alt="IF-T">

        </div>

        <div class="about-content">

            <p class="section-tag">
                ABOUT ME
            </p>

            <h2>

                Crafting
                Modern &
                Powerful
                Web Systems

            </h2>

            <p>

                I'm a Full Stack Web Application Developer focused on creating scalable,
                visually stunning and high-performing applications using modern technologies.

            </p>

            <div class="about-cards">

                <div class="mini-card">
                    Frontend Expert
                </div>

                <div class="mini-card">
                    Backend Architect
                </div>

                <div class="mini-card">
                    API Development
                </div>

                <div class="mini-card">
                    Database Design
                </div>

            </div>

        </div>

    </section>

    <!-- ================= SKILLS ================= -->

    <section class="skills" id="skills">

        <div class="section-header">

            <p class="section-tag">
                MY SKILLS
            </p>

            <h2>
                TECHNOLOGY STACK
            </h2>

        </div>

        <div class="skills-grid">

            <div class="skill-box html-box">
                <span>HTML</span>
            </div>

            <div class="skill-box css-box">
                <span>CSS</span>
            </div>

            <div class="skill-box js-box">
                <span>JAVASCRIPT</span>
            </div>

            <div class="skill-box react-box">
                <span>REACT</span>
            </div>

            <div class="skill-box php-box">
                <span>PHP</span>
            </div>

            <div class="skill-box laravel-box">
                <span>LARAVEL</span>
            </div>

            <div class="skill-box mysql-box">
                <span>MYSQL</span>
            </div>

            <div class="skill-box tailwind-box">
                <span>TAILWIND</span>
            </div>

            <div class="skill-box bootstrap-box">
                <span>BOOTSTRAP</span>
            </div>

            <div class="skill-box jquery-box">
                <span>JQUERY</span>
            </div>

        </div>

    </section>

    <!-- ================= SCRIPT ================= -->

    <script>

        // custom cursor

        const cursor = document.querySelector(".cursor");

        document.addEventListener("mousemove", (e) => {

            cursor.style.left = e.clientX + "px";
            cursor.style.top = e.clientY + "px";

        });

        // particle system

        const canvas = document.getElementById("canvas");
        const ctx = canvas.getContext("2d");

        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        let particles = [];

        class Particle {

            constructor() {

                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;

                this.size = Math.random() * 2;

                this.speedX = (Math.random() - 0.5) * 0.5;
                this.speedY = (Math.random() - 0.5) * 0.5;

            }

            update() {

                this.x += this.speedX;
                this.y += this.speedY;

                if (this.x > canvas.width || this.x < 0) {
                    this.speedX *= -1;
                }

                if (this.y > canvas.height || this.y < 0) {
                    this.speedY *= -1;
                }

            }

            draw() {

                ctx.fillStyle = "#38bdf8";

                ctx.beginPath();

                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);

                ctx.fill();

            }

        }

        function init() {

            for (let i = 0; i < 150; i++) {

                particles.push(new Particle());

            }

        }

        function animate() {

            ctx.clearRect(0, 0, canvas.width, canvas.height);

            particles.forEach((particle) => {

                particle.update();
                particle.draw();

            });

            requestAnimationFrame(animate);

        }

        init();
        animate();

        window.addEventListener("resize", () => {

            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

        });

    </script>

</body>

</html>