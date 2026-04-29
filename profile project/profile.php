<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IF-T Portfolio</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="logo">IF-T KHAR LIYES</div>

    <ul class="nav-links">
      <li><a href="#">Home</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#">Skills</a></li>
      <li><a href="#">Projects</a></li>
      <li><a href="#">Blogs</a></li>
      <li><a href="#">Contact</a></li>
    </ul>
  </nav>

  <!-- HOME -->
  <section class="home reveal-section">
    <canvas id="bg-canvas"></canvas>

    <div class="home-content">

      <h1>
        Hello, I'm <span class="hover-text">IFTY KHAR LIYES</span>
      </h1>

      <h2>
        <span class="hover-text">Full Stack Web Application Developer</span>
      </h2>

      <p>
        I design and build <span class="hover-text">modern</span>, scalable and high-performance web applications.
        Passionate about creating <span class="hover-text">seamless user experiences</span> and powerful backend
        systems.
      </p>

    </div>

  </section>

  <!-- ABOUT -->
  <section class="about reveal-section" id="about">

    <div class="about-container">

      <div class="about-image">
        <img src="WhatsApp Image 2026-04-27 at 23.55.27.jpeg" alt="IF-T">
      </div>

      <div class="about-content">

        <h2 class="hover-text">About Me</h2>

        <h3 class="hover-text">Full Stack Web Application Developer</h3>

        <p>
          I am a dedicated Full Stack Developer focused on building scalable,
          efficient, and user-friendly web applications.
        </p>

        <p>
          My expertise includes modern JavaScript frameworks, backend development,
          and database management.
        </p>

        <p>
          I am continuously learning and improving to deliver high-quality real-world solutions.
        </p>

      </div>

    </div>

  </section>

  <!-- SCRIPT -->
  <script>
    const sections = document.querySelectorAll(".reveal-section");

    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {

        if (entry.isIntersecting) {
          entry.target.classList.add("active");
          observer.unobserve(entry.target);
        }

      });
    }, {
      threshold: 0.2
    });

    sections.forEach(section => {
      observer.observe(section);
    });
  </script>
  <script>
    const canvas = document.getElementById("bg-canvas");
    const ctx = canvas.getContext("2d");

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    let particles = [];

    class Particle {
      constructor() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.z = Math.random() * 1000;
      }

      update() {
        this.z -= 2;

        if (this.z <= 0) {
          this.z = 1000;
        }
      }

      draw() {
        let scale = 300 / this.z;
        let x = (this.x - canvas.width / 2) * scale + canvas.width / 2;
        let y = (this.y - canvas.height / 2) * scale + canvas.height / 2;

        let size = (1 - this.z / 1000) * 3;

        ctx.fillStyle = "#38bdf8";
        ctx.beginPath();
        ctx.arc(x, y, size, 0, Math.PI * 2);
        ctx.fill();
      }
    }

    function init() {
      for (let i = 0; i < 200; i++) {
        particles.push(new Particle());
      }
    }

    function animate() {
      ctx.fillStyle = "rgba(2,6,23,0.5)";
      ctx.fillRect(0, 0, canvas.width, canvas.height);

      particles.forEach(p => {
        p.update();
        p.draw();
      });

      requestAnimationFrame(animate);
    }

    init();
    animate();

    /* resize fix */
    window.addEventListener("resize", () => {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
    });
  </script>
</body>

</html>