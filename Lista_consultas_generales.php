<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consulta con Receta</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      font-family: Arial, sans-serif;
      background: #fff;
    }

    .titulo-container-subtle {
      background: #008080;
      border-left: 8px solid #CC1A1A;
      padding: 2px 5px;
      margin: 10px 0 10px 0;
      box-shadow: 0 3px 10px rgba(0,0,0,0.15);
    }

    .titulo-container-subtle h2 {
      margin: 0;
      font-size: 21px;
      font-weight: 600;
      text-align: center;
      color: white;
    }
    

    .back-button {
      color: #333;
      font-size: 18px;
      font-weight: bold;
      text-decoration: none;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
      transition: color 0.3s ease;
      display: inline-block;
      margin: 20px;
    }

    .back-button:hover {
      color: #cc1a1a;
      text-shadow: 1px 1px 3px rgba(204, 26, 26, 0.6);
    }

    .back-text {
      font-size: 18px;  
      font-weight: normal;
    }

    .contenedor-consultas {
      width: 100%;
      padding: 40px 20px 0 20px;
    }

    .tarjeta-consulta {
      background-color: #eee;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      padding: 30px 20px 20px 20px;
      margin-bottom: 30px;
      position: relative;
    }

    .fecha-etiqueta {
      position: absolute;
      top: -12px;
      left: 10px;
      background: #6ec1e4;
      color: #000;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
      font-weight: bold;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px 40px;
      font-size: 15px;
      color: #333;
    }

    .tarjeton {
      color: #cc1a1a;
      font-weight: bold;
    }

    .btn-agregar {
      background-color: #f39c12;
      padding: 8px 14px;
      border-radius: 6px;
      color: #000;
      font-weight: bold;
      text-decoration: none;
      box-shadow: 1px 1px 2px rgba(0,0,0,0.2);
      transition: all 0.2s ease-in-out;
      display: inline-block;
      margin-top: 15px;
    }

    .btn-agregar:hover {
      background-color: #e67e22;
    }

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
      color: #b1071e;
      font-weight: bold;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<?php include 'menu.php'?>

  <a href="#" class="back-button"><i class="fas fa-arrow-left"></i> <span class="back-text">Regresar</span></a>

  <div class="titulo-container-subtle">
    <h2 class="titulo-pagina">HISTORIAL CLÍNICO</h2>
  </div>

  <div class="contenedor-consultas">
    <div class="tarjeta-consulta">
      <div class="fecha-etiqueta">24/06/2025</div>

      <div class="info-grid">
        <div><strong>Nombre del Paciente:</strong> Clara Juliana Estrada Peraza</div>
        <div><strong>Tarjetón:</strong> <span class="tarjeton">TJT-5588</span></div>
        <div><strong>Área de Consulta:</strong> Psicología</div>
      </div>

      <div style="margin-top: 20px;">
        <h4 style="color: #333; margin-bottom: 10px;">Receta Médica Asociada</h4>
        <div class="info-grid">
          <div><strong>Medicamento:</strong> Sertralina 50mg</div>
          <div><strong>Frecuencia:</strong> Una vez al día</div>
          <div><strong>Duración:</strong> 30 días</div>
        </div>
        <a href="#" class="btn-agregar"><i class="fas fa-file-medical"></i> Ver Detalle Receta</a>
      </div>
    </div>
  </div>

  <footer>
    Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo. 
    <a href="#">Aviso de privacidad</a>
  </footer>

</body>
</html>