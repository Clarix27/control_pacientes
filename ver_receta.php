<?php
  session_start();
  // Verificar si el usuario ha iniciado sesión
  if (!isset($_SESSION['pk_usuario'])) {
    // Redirigir a la página de login si no está autenticado
    echo("<script>window.location.assign('Login.html');</script>");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Historial de Recetas</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f4f4;
      color: #333;
    }

    .titulo-container-subtle {
      background: #9CD8D9;
      border-left: 8px solid #CC1A1A;
      padding: 2px 5px;
      margin: 20px 0 10px 0;
      box-shadow: 0 3px 10px rgba(0,0,0,0.15);
    }

    .titulo-container-subtle h2 {
      margin: 0;
      font-size: 21px;
      font-weight: 600;
      text-align: center;
      color: #2c3e50;
    }

    .receta-lista {
      display: flex;
      flex-direction: column;
      gap: 20px;
      width: 90%;
      max-width: 1000px;
      margin: auto;
      margin-bottom: 40px;
    }

    .receta-card {
      background: #fff;
      padding: 20px;
      border-left: 6px solid #2980b9;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .receta-card h3 {
      margin-bottom: 8px;
      font-size: 18px;
      color: #2980b9;
    }

    .receta-card p {
      margin: 5px 0;
      font-size: 14px;
      line-height: 1.6;
    }

    .receta-card .fecha {
      font-weight: bold;
      color: #555;
    }

    .volver-btn {
      display: block;
      text-align: center;
      margin: 20px auto;
      background-color: #CC1A1A;
      color: white;
      padding: 10px 25px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
      text-decoration: none;
      width: fit-content;
    }

    .volver-btn:hover {
      background-color: #a30000;
    }

    .back-button {
      color: #333;
      font-size: 18px;
      font-weight: bold;
      text-decoration: none;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
      transition: color 0.3s ease;
    }

    .back-button:hover {
      color: #cc1a1a;
      text-shadow: 1px 1px 3px rgba(204, 26, 26, 0.6);
    }

    .back-text {
      font-size: 18px;  
      font-weight: normal;
    }
  </style>
</head>
<body>
    <?php include 'menu.php'?>

    <div style="margin: 15px 0 0 20px;">
  <a href="Historial_titular.php?id=<?=urlencode($id_titular)?>" class="back-button">
    <i class="fas fa-arrow-left"></i>
    <span class="back-text">Regresar</span>
  </a>
  </div>
    

  <div class="titulo-container-subtle">
    <h2>Historial de Recetas Médicas</h2>
  </div>

  <div class="receta-lista">
    <!-- Ejemplo de receta -->
    <div class="receta-card">
      <h3>Receta #1</h3>
      <p class="fecha">Fecha: 2025-06-15</p>
      <p><strong>RX:</strong><br>Paracetamol 500mg cada 8 horas por 5 días. Tomar después de alimentos.</p>
    </div>

    <div class="receta-card">
      <h3>Receta #2</h3>
      <p class="fecha">Fecha: 2025-06-10</p>
      <p><strong>RX:</strong><br>Ibuprofeno 400mg cada 6 horas solo si hay dolor. No exceder 3 dosis por día.</p>
    </div>

    <div class="receta-card">
      <h3>Receta #3</h3>
      <p class="fecha">Fecha: 2025-05-28</p>
      <p><strong>RX:</strong><br>Amoxicilina 500mg cada 8 horas durante 7 días.</p>
    </div>
  </div>

</body>
</html>