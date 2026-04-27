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

  <div class="home-content">

    <h1>
      Hello, I'm <span class="hover-text">IFTY KHAR LIYES</span>
    </h1>

    <h2>
      <span class="hover-text">Full Stack Web Application Developer</span>
    </h2>

    <p>
      I design and build <span class="hover-text">modern</span>, scalable and high-performance web applications.
      Passionate about creating <span class="hover-text">seamless user experiences</span> and powerful backend systems.
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

</body>
</html>