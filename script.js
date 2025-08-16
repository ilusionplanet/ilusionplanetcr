document.addEventListener('DOMContentLoaded', function() {
  // Función para centrar el elemento seleccionado en el menú desplegable
  function scrollToCenter(element) {
    const container = element.closest('.dropdown-menu');
    if (!container) return;
    const containerRect = container.getBoundingClientRect();
    const elementRect = element.getBoundingClientRect();
    const offset = elementRect.top - containerRect.top + container.scrollTop - (container.clientHeight / 2) + (elementRect.height / 2);
    container.scrollTo({
      top: offset,
      behavior: 'smooth'
    });
  }

  const menuButton = document.getElementById("menuButton");
  const dropdownMenu = document.getElementById("dropdownMenu");
  const slides = document.querySelectorAll(".slide");
  const dots = document.querySelectorAll(".dot");
  const itemList = document.getElementById("itemList");
  const orderForm = document.getElementById("orderForm");
  const confettiCanvas = document.getElementById("confetti-canvas");
  const modal = document.getElementById("modal");
  const modalImage = document.getElementById("modalImage");
  const modalInfo = document.getElementById("modalInfo");

  let currentIndex = 0;
  let slideInterval;

  function showSlide(index) {
    if (!slides.length || !dots.length) return;
    slides.forEach((slide, i) => {
      slide.classList.toggle("active", i === index);
      dots[i].classList.toggle("active", i === index);
    });
    currentIndex = index;
  }

  function startAutoSlide() {
    if (!slides.length) return;
    clearInterval(slideInterval);
    slideInterval = setInterval(() => {
      currentIndex = (currentIndex + 1) % slides.length;
      showSlide(currentIndex);
    }, 5000);
  }

  if (slides.length) {
    showSlide(0);
    startAutoSlide();
  }

  // Confeti en el carrusel
  if (confettiCanvas) {
    const myConfetti = confetti.create(confettiCanvas, { resize: true, useWorker: true });
    setInterval(() => {
      myConfetti({
        particleCount: 100,
        spread: 120,
        origin: { x: Math.random(), y: 0.1 }
      });
    }, 1500);
  }

  // Mapeo de información de precios por categoría
  const productDetails = {
    "Piñatas": "Piñatas: $10 cada una, pedido mínimo de 50 unidades.",
    "Cajitas": "Cajitas: $5 cada una, pedido mínimo de 30 unidades.",
    "Sombreros": "Sombreros: $8 cada uno, pedido mínimo de 30 unidades.",
    "Candelas": "Candelas: $3 cada una, 30 unidades.",
    "Banderines": "Banderines: $4 cada uno, sin pedido mínimo.",
    "Confetti": "Confetti: $2 cada paquete, sin pedido mínimo."
  };

  // Función para actualizar la galería según la categoría y centrar el elemento seleccionado
  window.updateList = function(event, category) {
    event.preventDefault();
    // Centrar el elemento seleccionado
    scrollToCenter(event.target);

    itemList.innerHTML = "";
    // Convertir la categoría a minúsculas para construir la ruta
    let formattedCategory = category.toLowerCase();
    // Convertir ambas categorías a singular para que coincida con los nombres de archivo
    if (formattedCategory === "piñatas") {
      formattedCategory = "piñata";
    }
    if (formattedCategory === "sombreros") {
      formattedCategory = "sombrero";
    }

    // Definir el rango de imágenes según la categoría:
    let startImg = 1;
    let endImg = 37;
    if (category === "Piñatas") {
      endImg = 48;
    } else if (category === "Sombreros") {
      endImg = 37;
    }

    for (let i = startImg; i <= endImg; i++) {
      let img = document.createElement("img");
      img.src = `imagenes/${formattedCategory}${i}.jpg`;
      img.alt = `${category} ${i}`;
      img.setAttribute("data-category", category);
      img.style.width = "200px";
      img.style.height = "200px";
      img.style.objectFit = "contain";
      img.style.borderRadius = "10px";
      img.addEventListener("click", function() {
        showModal(this);
      });
      img.onerror = () => { img.style.display = "none"; };
      itemList.appendChild(img);
    }
    itemList.scrollIntoView({ behavior: 'smooth' });
  };

  // Mostrar/ocultar menú desplegable
  menuButton.addEventListener("click", () => {
    dropdownMenu.classList.toggle("active");
  });

  // Cerrar el menú si se hace clic fuera de él
  window.addEventListener("click", function(event) {
    if (!menuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
      dropdownMenu.classList.remove("active");
    }
  });

  // Función de scroll suave para secciones
  window.scrollToSection = function(sectionId) {
    const element = document.getElementById(sectionId);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
    }
  };

  // Mostrar/ocultar formulario de pedido
  window.toggleForm = function () {
    orderForm.style.display = (orderForm.style.display === "none" || !orderForm.style.display) ? "flex" : "none";
  };

  // Función para mostrar el modal con imagen ampliada e información de precios
  function showModal(imgElement) {
    const category = imgElement.getAttribute("data-category");
    modalImage.src = imgElement.src;
    modalInfo.innerHTML = `<p>${productDetails[category] || ""}</p>`;
    modal.style.display = "block";
  }

  // Función para cerrar el modal
  window.closeModal = function() {
    modal.style.display = "none";
  };

  // Cerrar el modal al hacer clic fuera del contenido
  window.addEventListener("click", function(event) {
    if (event.target === modal) {
      closeModal();
    }
  });

  // Función para controlar los puntos (dots) manualmente
  window.currentSlide = function(index) {
    showSlide(index);
    startAutoSlide();
  };
});


