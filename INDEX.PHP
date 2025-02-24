<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LIFER</title>

  <!-- Enlaces de estilo -->
  <link href="./INCLUDE - ESTILOS/HEADER_ESTILOS.CSS" rel="stylesheet">
  <link href="./INCLUDE - ESTILOS/FOOTER_ESTILOS.CSS" rel="stylesheet">
  <link href="./ESTILOS/index.css" rel="stylesheet">
  <link href="./ESTILOS/menu.css" rel="stylesheet">
  <link href="./ESTILOS/Menu_hamburguesa.css" rel="stylesheet">
  <link href="./ESTILOS/iniciar_sesion.css" rel="stylesheet">
  <link href="./ESTILOS/carrusel_responsivo.css" rel="stylesheet">
  <link href="./ESTILOS/estilos del loguin.css" rel="stylesheet">
  <link href="./ESTILOS/footer.css" rel="stylesheet">


</head>
<body>

  <!-- Encabezado -->
  <?php include("./INCLUDE/HEADER.PHP")?>

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
        <p class="descripcion-promocion">Aprovecha descuentos de hasta <strong>50%</strong> 
        en nuestras colecciónes. Actualiza tu estilo con precios irresistibles y
         prepárate para destacar esta temporada.</p>
        
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
    <a href="../Proyecto_Tienda_Ropa/ROPA HOMBRE/CAMISETAS_H.PHP" class="etiqueta">Camisetas</a>
    <a href="../Proyecto_Tienda_Ropa/ROPA MUJER/VESTIDOS_M.PHP" class="etiqueta">Vestidos</a>
    <a href="../Proyecto_Tienda_Ropa/ROPA HOMBRE/JEANS_H.PHP" class="etiqueta">Jeans</a>
    <a href="../Proyecto_Tienda_Ropa/ACCESORIOS/ACCESORIOS.PHP" class="etiqueta">Accesorios</a>
    <a href="../Proyecto_Tienda_Ropa/ACCESORIOS/CORBATAS.PHP" class="etiqueta">Corbatas</a>
    <a href="../Proyecto_Tienda_Ropa/ROPA MUJER/BLUSAS_M.PHP" class="etiqueta">Blusas</a>

</div>

<style>
  .etiquetas-productos .etiqueta {
    text-decoration: none; /* Quita la línea de abajo */
    color: inherit; /* Mantiene el color del texto */
}

  </style>

        <div class="botones-promocion">
          <a href="https://www.google.com/maps/place/Almacen+Elfer/@5.0073489,-73.4730107,3a,75y,211.15h,93.36t/data=!3m7!1e1!3m5!1saEKWWXJXF5IZnetCiWajRw!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fcb_client%3Dmaps_sv.tactile%26w%3D900%26h%3D600%26pitch%3D-3.3554431055683125%26panoid%3DaEKWWXJXF5IZnetCiWajRw%26yaw%3D211.1532729432759!7i16384!8i8192!4m16!1m9!3m8!1s0x8e4002ac3dcd0023:0x9408de06cc563fc6!2sGuateque,+Boyac%C3%A1!3b1!8m2!3d5.006385!4d-73.471423!10e5!16s%2Fm%2F02qm9zz!3m5!1s0x8e4002ac22636b23:0xe70e4baabbfad1f!8m2!3d5.0071773!4d-73.4726258!16s%2Fg%2F11g6hw5b6z?entry=ttu&g_ep=EgoyMDI1MDIwNS4xIKXMDSoASAFQAw%3D%3D" class="boton-principal">
            <span class="icono-boton">🛍️</span>
            Explorar Ubicacion
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
            <img src="./IMAGENES/ropa2.png" width="20px" alt="Promoción 1">
            <div class="info-slide">
              <span class="descuento">-50%</span>
              <h3>Colección Verano</h3>
            </div>
          </div>
          <div class="slide">
            <img src="./IMAGENES/ropa1.png" width="20px"alt="Promoción 2">
            <div class="info-slide">
              <span class="descuento">-40%</span>
              <h3>Accesorios</h3>
            </div>
          </div>
          <div class="slide">
            <img src="./IMAGENES/ropa3.png" width="20px"alt="Promoción 3">
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
  <?php include("./INCLUDE/FOOTER.PHP")?>

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
</body>
</html>
