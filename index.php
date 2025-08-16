<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Illusion Planet - Piñatas Personalizadas</title>
  <style>
    /* Importar la fuente llamativa */
    @import url('https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap');

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      background: black;
      background-image: 
        radial-gradient(circle at 20% 30%, rgba(64, 224, 208, 0.6) 10%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(138, 43, 226, 0.6) 15%, transparent 50%),
        url('https://www.solarsystemscope.com/textures/download/8k_stars_milky_way.jpg');
      background-size: cover;
      background-attachment: fixed;
      color: white;
      min-height: 100vh;
      overflow-y: auto;
    }

    /* Carrusel de fondo */
    .carousel {
      position: relative;
      width: 100%;
      height: 100vh;
      overflow: hidden;
    }
    .carousel img {
      position: absolute;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 1s ease-out;
      z-index: 0;
    }
    .carousel img.active {
      opacity: 1;
      z-index: 1;
    }
    .carousel-controls {
      position: absolute;
      bottom: 15px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
    }
    .dot {
      width: 12px;
      height: 12px;
      margin: 0 5px;
      background: white;
      border-radius: 50%;
      cursor: pointer;
      opacity: 0.5;
      transition: opacity 0.3s;
    }
    .dot.active {
      opacity: 1;
    }

    /* Título y textos */
    .main-title {
      font-family: 'Luckiest Guy', cursive;
      font-size: clamp(60px, 10vw, 160px);
      font-weight: bold;
      text-align: center;
      position: absolute;
      bottom: 10px;
      left: 50%;
      transform: translateX(-50%);
      color: #ADFF2F;
      text-shadow: 3px 3px 10px rgba(0,0,0,0.6);
      z-index: 2;
    }
    .info-box {
      background: rgba(0,128,0,0.5);
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      max-width: 80%;
      margin: 20px auto;
      font-size: 30px;
      font-weight: bold;
    }
    .menu-toggle {
      position: fixed;
      bottom: 20px;
      left: 20px;
      background: yellow;
      color: black;
      padding: 12px 18px;
      cursor: pointer;
      border-radius: 5px;
      border: none;
      font-size: 18px;
      transition: background 0.3s, transform 0.2s;
      z-index: 100;
    }
    .menu-toggle:hover {
      background: #ffcc00;
      transform: scale(1.1);
    }
    .dropdown-menu {
      position: fixed;
      bottom: 60px;
      left: 20px;
      background: rgba(255,105,180,0.8);
      width: 220px;
      border-radius: 5px;
      box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
      opacity: 0;
      transform: translateY(10px);
      transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
      visibility: hidden;
      z-index: 100;
    }
    .dropdown-menu.active {
      opacity: 1;
      transform: translateY(0);
      visibility: visible;
    }
    .dropdown-menu ul {
      font-size: 22px;
      padding: 0;
      margin: 0;
    }
    .dropdown-menu li {
      padding: 10px 0;
    }
    .dropdown-menu a {
      color: white;
      text-decoration: none;
      padding: 10px 15px;
      display: block;
    }
    .dropdown-menu a:hover {
      background: #ffcc00;
      border-radius: 5px;
    }
    /* Contenedor para imágenes dinámicas */
    #itemList {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      margin-top: 30px;
    }
    #itemList img {
      width: 200px;
      height: auto;
      border-radius: 10px;
      transition: transform 0.3s ease;
      margin-bottom: 20px;
    }
    /* Formulario de pedido */
    .order-form {
      display: none;
      background: rgba(0,128,0,0.7);
      padding: 20px;
      border-radius: 10px;
      max-width: 500px;
      margin: 30px auto;
      color: white;
    }
    .order-form label,
    .order-form input,
    .order-form textarea {
      display: block;
      width: 100%;
      margin-bottom: 10px;
      font-size: 16px;
    }
    .order-form button {
      background: #ffcc00;
      color: black;
      border: none;
      padding: 10px;
      cursor: pointer;
      border-radius: 5px;
      transition: background 0.3s ease;
    }
    .order-form button:hover {
      background: #ff9900;
    }
    /* Anuncio */
    .ad-box {
      background: #ffcc00;
      text-align: center;
      font-size: 25px;
      font-weight: bold;
      padding: 15px;
      cursor: pointer;
      border-radius: 10px;
      margin-top: 30px;
      transition: background 0.3s ease;
    }
    .ad-box:hover {
      background: #ff9900;
    }
  </style>
</head>
<body>
  <!-- Carrusel de imágenes de fondo -->
  <div class="carousel">
    <img src="imagenes/fondo1.jpg" class="slide active" alt="Fondo 1">
    <img src="imagenes/fondo2.jpg" class="slide" alt="Fondo 2">
    <img src="imagenes/fondo3.jpg" class="slide" alt="Fondo 3">
    <div class="carousel-controls">
      <span class="dot active" onclick="currentSlide(0)"></span>
      <span class="dot" onclick="currentSlide(1)"></span>
      <span class="dot" onclick="currentSlide(2)"></span>
    </div>
  </div>

  <!-- Título principal -->
  <h1 class="main-title">Illusion Planet</h1>

  <!-- Botón de menú -->
  <button class="menu-toggle" id="menuButton">Menú</button>

  <!-- Menú desplegable -->
  <nav class="dropdown-menu" id="dropdownMenu">
    <ul>
      <li><a href="#" onclick="updateList(event, 'Piñatas')">Piñatas</a></li>
      <li><a href="#" onclick="updateList(event, 'Cajitas')">Cajitas</a></li>
      <li><a href="#" onclick="updateList(event, 'Sombreros')">Sombreros Personalizados</a></li>
      <li><a href="#" onclick="updateList(event, 'Candelas')">Candelas Personalizadas</a></li>
      <li><a href="#" onclick="updateList(event, 'Banderines')">Banderines</a></li>
      <li><a href="#" onclick="updateList(event, 'Confetti')">Confetti</a></li>
    </ul>
  </nav>

  <!-- Contenido principal -->
  <main id="mainContent">
    <div class="info-box">
      <p><strong>Quiénes somos:</strong> Especialistas en piñatas y decoración personalizada en Costa Rica, ofreciendo diseños únicos y coloridos para hacer de tus celebraciones momentos inolvidables.</p>
    </div>

    <!-- Anuncio que abre el formulario -->
    <div class="ad-box" id="adBox" onclick="toggleForm()">REALIZA TU PEDIDO</div>

    <!-- Formulario de Pedido -->
    <div id="orderForm" class="order-form">
      <h2>Formulario de Pedido</h2>
      <!-- Al enviar el formulario se llama a process_form.php -->
      <form action="process_form.php" method="post" enctype="multipart/form-data">
        <label for="customerName">Nombre:</label>
        <input type="text" id="customerName" name="customerName" required>

        <label for="customerEmail">Correo Electrónico:</label>
        <input type="email" id="customerEmail" name="customerEmail" required>

        <label for="customerPhone">Teléfono:</label>
        <input type="tel" id="customerPhone" name="customerPhone" required>

        <label for="customerAddress">Dirección de Envío:</label>
        <input type="text" id="customerAddress" name="customerAddress" required>

        <label for="orderDetails">Detalles del Pedido:</label>
        <textarea id="orderDetails" name="orderDetails" required></textarea>

        <label for="referenceImage">Imagen de Referencia:</label>
        <input type="file" id="referenceImage" name="referenceImage" accept="image/*">

        <button type="submit">Enviar Pedido</button>
        <button type="button" onclick="toggleForm()">Cerrar</button>
      </form>
    </div>

    <!-- Contenedor para imágenes según categoría -->
    <div id="itemList"></div>
  </main>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const menuButton = document.getElementById("menuButton");
      const dropdownMenu = document.getElementById("dropdownMenu");
      const slides = document.querySelectorAll(".slide");
      const dots = document.querySelectorAll(".dot");
      const itemList = document.getElementById("itemList");
      const orderForm = document.getElementById("orderForm");

      let currentIndex = 0;

      function showSlide(index) {
        slides.forEach((slide, i) => {
          slide.classList.remove("active");
          dots[i].classList.remove("active");
        });
        slides[index].classList.add("active");
        dots[index].classList.add("active");
        currentIndex = index;
      }

      function autoSlide() {
        setInterval(() => {
          currentIndex = (currentIndex + 1) % slides.length;
          showSlide(currentIndex);
        }, 5000);
      }

      autoSlide();

      menuButton.addEventListener("click", () => {
        dropdownMenu.classList.toggle("active");
      });

      // Cerrar el menú si se hace clic fuera de él
      window.addEventListener("click", function (event) {
        if (!menuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
          dropdownMenu.classList.remove("active");
        }
      });

      // Función para actualizar la lista de imágenes según la categoría
      window.updateList = function (event, category) {
        event.preventDefault();
        itemList.innerHTML = "";
        // (Aquí se puede agregar lógica para mostrar información según la categoría)
        let formattedCategory = category.toLowerCase();
        if (formattedCategory === "piñata" || formattedCategory === "piñatas") {
          formattedCategory = "pinata";
        }
        if (formattedCategory === "sombreros") {
          formattedCategory = "sombrero";
        }
        if (formattedCategory === "candelas") {
          formattedCategory = "candelas";
        }
        for (let i = 1; i <= 6; i++) {
          let img = document.createElement("img");
          img.src = `imagenes/${formattedCategory}${i}.jpg`;
          img.alt = `${category} ${i}`;
          img.onerror = function () {
            this.style.display = "none"; 
          };
          itemList.appendChild(img);
        }
        itemList.scrollIntoView({ behavior: "smooth" });
      };

      // Función para mostrar/ocultar el formulario de pedido
      window.toggleForm = function () {
        orderForm.style.display = (orderForm.style.display === "none" || orderForm.style.display === "") ? "flex" : "none";
      };

      // Función para que los dots funcionen
      window.currentSlide = function(index) {
        showSlide(index);
      };
    });
  </script>
</body>
</html>
