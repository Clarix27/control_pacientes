<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Consulta con Receta</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      font-family: Arial, sans-serif;
      background: #fff;
    }
    .back-button {
      color: #333; font-size: 18px; font-weight: bold;
      text-decoration: none; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
      transition: color 0.3s ease;
    }
    .back-button:hover {
      color: #cc1a1a;
      text-shadow: 1px 1px 3px rgba(204,26,26,0.6);
    }
    .back-text { font-size: 18px; font-weight: normal; }

    .tituloo_container-subtle h2 {
      text-align: center;
      margin: 20px 0;
      padding: 10px 5px;
      background: #008080;
      border-left: 8px solid #CC1A1A;
      color: #fff;
      font-weight: 600;
      font-size: 21px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.15);
    }

    .registro-container {
      background-color: #D9D9D9;
      border-radius: 10px;
      padding: 15px 20px;
      margin: 20px;
    }
    .registro-fila {
      display: flex;
      justify-content: flex-start; /* alineado a la izquierda */
      align-items: center;
      gap: 10px;
    }
    .search-box {
      display: flex;
      align-items: center;
      background: #fff;
      border-radius: 30px;
      padding: 5px 10px;
      border: 1px solid #ccc;
    }
    .search-box i {
      margin-right: 8px;
      color: #666;
      font-size: 16px;
    }
    .search-box input[type="date"] {
      border: none;
      outline: none;
      padding: 5px 10px;
      font-size: 14px;
      border-radius: 30px;
      width: 180px;
      cursor: pointer;
    }

  .contenedor-consultas-multicolumna {
  display: grid;
  /* 2 columnas, cada una al menos 600px y luego se reparten el espacio sobrante */
  grid-template-columns: repeat(2, minmax(600px, 1fr));
  gap: 30px 40px;
  max-width: 1300px;    /* 600 + 600 + gap ≈ 1300 */
  margin: 0 auto;
  padding: 40px 30px 60px;
}

.tarjeta-consulta {
  background-color: #eee;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  padding: 30px;
  position: relative;
  width: auto;          /* respeta el grid */
}

/* Opcional: en pantallas < 1200 baja a 1 columna */
@media (max-width: 1200px) {
  .contenedor-consultas-multicolumna {
    grid-template-columns: 1fr;
    max-width: 600px;
  }
}


    .fecha-etiqueta {
      position: absolute;
      top: -12px; left: 10px;
      background: #6ec1e4;
      color: #000;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
      font-weight: bold;
    }
    .tarjeton { color: #cc1a1a; font-weight: bold; }

    footer {
      margin-top: auto;
      text-align: center;
      font-size: 14px;
      padding: 20px 10px;
      background-color: #f8f8f8;
      color: #444;
      border-top: 1px solid #ccc;
    }
    footer a {
      color: #b1071e; font-weight: bold; text-decoration: none;
    }
    footer a:hover { text-decoration: underline; }
  </style>
</head>
<body>

  <?php include 'menu.php'; ?>

  <div style="margin: 15px 0 0 20px;">
    <a href="Lista_titulares.php?id=<?=urlencode($pk_titular)?>" class="back-button">
      <i class="fas fa-arrow-left"></i>
      <span class="back-text">Regresar</span>
    </a>
  </div>

  <div class="tituloo_container-subtle">
    <h2>LISTA DE RECETAS</h2>
  </div>

  <div class="registro-container">
    <div class="registro-fila">
      <a>Filtro por fecha:</a>
      <div class="search-box">
        <i class="fas fa-calendar-alt"></i>
        <input id="filtro-fecha" type="date" placeholder="Seleccionar fecha">
      </div>
    </div>
  </div>

  <div class="contenedor-consultas-multicolumna">
    <!-- Ejemplo de tarjeta -->
    <div class="tarjeta-consulta">
      <div class="fecha-etiqueta">24/06/2025</div>
      <div style="display:flex; flex-direction:column; gap:10px; font-size:15px; color:#333;">
        <div><strong>Paciente:</strong> Clara Juliana Estrada Peraza</div>
        <div><strong>Tarjetón:</strong> <span class="tarjeton">000123456</span></div>
        <div><strong>Área de Consulta:</strong> Psicología</div>
        <div style="background:#fff; padding:10px; border-left:4px solid #129990; border-radius:6px;">
          <i class="fas fa-capsules" style="color:#129990; margin-right:8px;"></i>
          <span><strong>Receta:</strong> Sertralina 50mg</span>
        </div>
      </div>
    </div>

    <div class="tarjeta-consulta">
      <div class="fecha-etiqueta">03/07/2025</div>
      <div style="display:flex; flex-direction:column; gap:10px; font-size:15px; color:#333;">
        <div><strong>Paciente:</strong> Clara Juliana Estrada Peraza</div>
        <div><strong>Tarjetón:</strong> <span class="tarjeton">000123456</span></div>
        <div><strong>Área de Consulta:</strong> Psicología</div>
        <div style="background:#fff; padding:10px; border-left:4px solid #129990; border-radius:6px;">
          <i class="fas fa-capsules" style="color:#129990; margin-right:8px;"></i>
          <span><strong>Receta:</strong> Sertralina 50mg</span>
        </div>
      </div>
    </div>


    <div class="tarjeta-consulta">
      <div class="fecha-etiqueta">24/06/2025</div>
      <div style="display:flex; flex-direction:column; gap:10px; font-size:15px; color:#333;">
        <div><strong>Paciente:</strong> Clara Juliana Estrada Peraza</div>
        <div><strong>Tarjetón:</strong> <span class="tarjeton">000123456</span></div>
        <div><strong>Área de Consulta:</strong> Psicología</div>
        <div style="background:#fff; padding:10px; border-left:4px solid #129990; border-radius:6px;">
          <i class="fas fa-capsules" style="color:#129990; margin-right:8px;"></i>
          <span><strong>Receta:</strong> Sertralina 50mg</span>
        </div>
      </div>
    </div>


    <!-- Repite más tarjetas según datos -->
  </div>

  <footer>
    Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo.
    <a href="#">Aviso de privacidad</a>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const filtro = document.getElementById('filtro-fecha');
      const tarjetas = document.querySelectorAll('.tarjeta-consulta');

      filtro.addEventListener('change', () => {
        const sel = filtro.value; // "YYYY-MM-DD"
        tarjetas.forEach(t => {
          const txt = t.querySelector('.fecha-etiqueta').textContent.trim();
          const [d,m,y] = txt.split('/');
          const fechaTar = `${y}-${m.padStart(2,'0')}-${d.padStart(2,'0')}`;
          t.style.display = (!sel || fechaTar === sel) ? 'block' : 'none';
        });
      });
    });
  </script>

</body>
</html>
