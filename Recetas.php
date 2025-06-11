<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Receta Médica - Afiliado</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
  <link rel="stylesheet" href="css/menu.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #fff;
      color: #333;
    }

    .back-button {
      color: #333;
      font-size: 28px;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 8px;
      margin: 20px;
    }

    .back-button:hover {
      color: #000;
    }

    .back-text {
      font-size: 16px;
    }

    .titulo-container-subtle {
      background: #9CD8D9;
      border-left: 8px solid #CC1A1A;
      padding: 12px 20px;
      margin: 20px auto;
      width: 90%;
      box-shadow: 0 3px 10px rgba(0,0,0,0.15);
      text-align: center;
      font-size: 22px;
      font-weight: 600;
      color: #2c3e50;
      border-radius: 6px;
    }

    .content {
      padding: 20px;
      width: 95%;
      max-width: 1200px;
      margin: auto;
    }

    .tabla-datos {
      background: #ccc;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      margin-bottom: 30px;
      overflow-x: auto;
    }

    .tabla-datos table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 15px;
    }

    .tabla-datos td {
      vertical-align: top;
      min-width: 250px;
    }

    .tabla-datos label {
      font-weight: 600;
      font-size: 14px;
      display: block;
      margin-bottom: 6px;
    }

    .tabla-datos input[type="text"],
    .tabla-datos input[type="date"] {
      width: 100%;
      padding: 8px 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      background: #fff;
      font-size: 14px;
    }

    .rx-container {
      background: #ccc;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .rx-container label {
      font-weight: 600;
      font-size: 14px;
      margin-bottom: 10px;
      display: block;
    }

    .rx-container textarea {
      width: 100%;
      height: 180px;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 14px;
      resize: vertical;
      background: #fff;
    }

    /* Responsive */
    @media screen and (max-width: 768px) {
      .tabla-datos table {
        display: block;
      }

      .tabla-datos td {
        display: block;
        width: 100% !important;
        margin-bottom: 15px;
      }

      .titulo-container-subtle {
        font-size: 18px;
      }
    }
  </style>
</head>
<body>

  <?php include 'menu.php' ?>

  <a href="historial_titular.php" class="back-button">
    <i class="fas fa-arrow-left"></i>
    <span class="back-text">Regresar</span>
  </a>

  <div class="titulo-container-subtle">
    RECETA MÉDICA
  </div>

  <div class="content">
    <div class="tabla-datos">
      <table>
        <tr>
          <td>
            <label>Nombre Paciente:</label>
            <input type="text">
          </td>
          <td>
            <label>Apellido Paterno Paciente:</label>
            <input type="text">
          </td>
          <td>
            <label>Apellido Materno Paciente:</label>
            <input type="text">
          </td>
        </tr>
        <tr>
          <td>
            <label>Nombre Titular:</label>
            <input type="text">
          </td>
          <td>
            <label>Apellido Paterno Titular:</label>
            <input type="text">
          </td>
          <td>
            <label>Apellido Materno Titular:</label>
            <input type="text">
          </td>
        </tr>
        <tr>
          <td>
            <label>Fecha:</label>
            <input type="date">
          </td>
          <td>
            <label>Núm. de Tarjetón:</label>
            <input type="text">
          </td>
          <td>
            <label>Área de Trabajo:</label>
            <input type="text">
          </td>
        </tr>
      </table>
    </div>

    <div class="rx-container">
      <label>RX:</label>
      <textarea placeholder="Escribe la receta aquí..."></textarea>
    </div>
  </div>

</body>
</html>
