<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document Cl</title>

  <!-- Enlaces de estilo -->
  <link href="../INCLUDE - ESTILOS/HEADER_ESTILOS.CSS" rel="stylesheet">
  <link href="../INCLUDE - ESTILOS/FOOTER_ESTILOS.CSS" rel="stylesheet">
  <link href="../ESTILOS/index.css" rel="stylesheet">
  <link href="../ESTILOS/menu.css" rel="stylesheet">
  <link href="../ESTILOS/Menu_hamburguesa.css" rel="stylesheet">
  <link href="../ESTILOS/iniciar_sesion.css" rel="stylesheet">
  <link href="../ESTILOS/carrusel_responsivo.css" rel="stylesheet">
  <link href="../ESTILOS/estilos del loguin.css" rel="stylesheet">
  <link href="../ESTILOS/footer.css" rel="stylesheet">
  <link href="../ESTILOS/estilos_include_perfil.css" rel="stylesheet">





</head>
<body>

<style>
  
</style>

  <!-- Encabezado -->
  <?php include("../INCLUDE/HEADER_CLIENTES.PHP")?>

  <!-- Contenido principal -->
  <br><br><br>
  
  <section class="seccion-promocion">
    <div class="contenedor-principal">
      <div class="contenido-promocion">
        <div class="cabecera-promocion">
          <span class="etiqueta-destacada">¡Oferta Exclusiva!</span>
          <span class="etiqueta-tiempo-limitado">Tiempo Limitado</span>
        </div>
        
        <h2 class="titulo-promocion">Rebajas de Temporada</h2>
        <p class="descripcion-promocion">Aprovecha descuentos de hasta <strong>50%</strong> en nuestra colección de verano. Actualiza tu estilo con precios irresistibles y prepárate para destacar esta temporada.</p>
        
        <div class="caracteristicas-promocion">
          <div class="caracteristica">
            <span class="icono">🚚</span>
            <p>Envío Gratis</p>
            <span class="detalle">En compras mayores a $999</span>
          </div>
          <div class="caracteristica">
            <span class="icono">💳</span>
            <p>Variedad de tarjetas</p>
            <span class="detalle">Con Descuentos</span>
          </div>
          <div class="caracteristica">
            <span class="icono">↩️</span>
            <p>Devolución Gratuita</p>
            <span class="detalle">Hasta 30 días después</span>
          </div>
        </div>

        <div class="etiquetas-productos">
          <span class="etiqueta">Camisetas</span>
          <span class="etiqueta">Vestidos</span>
          <span class="etiqueta">Jeans</span>
          <span class="etiqueta">Accesorios</span>
        </div>

        <div class="botones-promocion">
          <a href="../PAGINAS/CATEGORIAS.PHP" class="boton-principal">
            <span class="icono-boton">🛍️</span>
            Explorar Colección
          </a>
          <a href="./PAGINAS/OFERFAS.PHP" class="boton-secundario">
            <span class="icono-boton">🏷️</span>
            Ver Ofertas
          </a>
        </div>
      </div>

      <div class="carrusel-promocion">
        <div class="contenedor-imagenes">
          <div class="slide">
            <img src="../IMAGENES/ropa2.png" width="20px" alt="Promoción 1">
            <div class="info-slide">
              <span class="descuento">-50%</span>
              <h3>Colección Verano</h3>
            </div>
          </div>
          <div class="slide">
            <img src="../IMAGENES/ropa1.png" width="20px"alt="Promoción 2">
            <div class="info-slide">
              <span class="descuento">-40%</span>
              <h3>Accesorios</h3>
            </div>
          </div>
          <div class="slide">
            <img src="../IMAGENES/ropa3.png" width="20px"alt="Promoción 3">
            <div class="info-slide">
              <span class="descuento">-30%</span>
              <h3>Nueva Temporada</h3>
            </div>
          </div>
        </div>
        <div class="controles-carrusel">
          <button class="control-carrusel activo"></button>
          <button class="control-carrusel"></button>
          <button class="control-carrusel"></button>
        </div>
      </div>
    </div>

    <div class="beneficios-compra">
      <h3 class="titulo-beneficios">¿Por qué comprar con nosotros?</h3>
      <div class="contenedor-beneficios">
        <div class="beneficio">
          <span class="icono-beneficio">⭐</span>
          <h4>Calidad Garantizada</h4>
          <p>Productos seleccionados con los más altos estándares</p>
        </div>
        <div class="beneficio">
          <span class="icono-beneficio">📦</span>
          <h4>Empaque Sustentable</h4>
          <p>Comprometidos con el medio ambiente</p>
        </div>
        <div class="beneficio">
          <span class="icono-beneficio">📞</span>
          <h4>Soporte </h4>
          <p>Estamos para ayudarte en todo momento</p>
        </div>
        <div class="beneficio">
          <span class="icono-beneficio">🔒</span>
          <h4>Compra Segura</h4>
          <p>Transacciones protegidas y seguras</p>
        </div>
      </div>
    </div>
  </section>
  

  <!-- Pie de página -->
  <?php include("../INCLUDE/FOOTER.PHP")?>

  <script>
    function toggleMenu() {
      document.getElementById('menuNav').classList.toggle('active');
    }


  
  const slides = document.querySelectorAll('.slide');
  const controls = document.querySelectorAll('.control-carrusel');
  let currentIndex = 0;

  function updateCarousel(index) {
    const totalSlides = slides.length;
    
    if (index >= totalSlides) {
      currentIndex = 0;
    } else if (index < 0) {
      currentIndex = totalSlides - 1;
    } else {
      currentIndex = index;
    }

    document.querySelector('.contenedor-imagenes').style.transform = `translateX(-${currentIndex * 100}%)`;
    controls.forEach(control => control.classList.remove('activo'));
    controls[currentIndex].classList.add('activo');
  }

  controls.forEach((control, index) => {
    control.addEventListener('click', () => updateCarousel(index));
  });

  setInterval(() => {
    updateCarousel(currentIndex + 1);
  }, 5000);

  </script>

<script>
    // Agregar clase de animación al hacer scroll
    document.addEventListener('DOMContentLoaded', () => {
        const fadeElements = document.querySelectorAll('.fade-in');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        });

        fadeElements.forEach(el => observer.observe(el));
    });
</script>
</body>
</html>
