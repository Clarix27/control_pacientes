<?php
  require_once 'controladores/info_titular.php';
  $id_titular = $_GET['id_t'];
  $id_beneficiario = $_GET['id_b'];

  $titular = titular_id($id_titular);
  $beneficiario = info_beneficiario($id_beneficiario);
  $b_materno = $beneficiario['a_materno'] ?? '';
  $t_materno = $beneficiario['a_materno'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Receta Médica - Afiliado</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="css/alerta_receta.css">
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

    .titulo-pagina {
    font-size: 28px;
    font-weight: bold;
    color: #333;
    }

.titulo-container-subtle {
  width: 100%;
  margin: 20px 0 10px 0;
  padding: 2px 5px;
  background: #9CD8D9;
  border-left: 8px solid #CC1A1A;
  box-shadow: 0 3px 10px rgba(0,0,0,0.15);
  border-radius: 0; /* ← Esquinas rectas */
}



.titulo-container-subtle h2 {
 margin: 0;
 font-size: 21px;
 font-weight: 600;
 text-align: center;
 color: #2c3e50;
}

.btn-submit {
  background-color: #2980b9; /* azul fuerte */
  color: white;
  font-size: 16px;
  padding: 12px 30px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-submit:hover {
  background-color: #9CD8D9; /* azul más claro */
  transform: scale(1.05);
}


  </style>
</head>
<body>

  <?php include 'menu.php' ?>

  <a href="Historial_titular.php?id=<?=urlencode($id_titular)?>" class="back-button">
    <i class="fas fa-arrow-left"></i>
    <span class="back-text">Regresar</span>
  </a>

  <div  class="titulo-container-subtle">
    <h2 style= "text-align: center; margin-top: 20px;" class="titulo-pagina">RECETA MEDICA</h2>
  </div>

  <form id="formRecetas">
    <div class="content">
      <div class="tabla-datos">
        <table>
          <tr>
            <td>
              <label>Nombre Paciente:</label>
              <input type="text" value="<?= htmlspecialchars($beneficiario['nombre'], ENT_QUOTES, 'UTF-8') ?>" name="p_nombre" readonly>
            </td>
            <td>
              <label>Apellido Paterno Paciente:</label>
              <input type="text" value="<?= htmlspecialchars($beneficiario['a_paterno'], ENT_QUOTES, 'UTF-8') ?>"  name="p_paterno" readonly>
            </td>
            <td>
              <label>Apellido Materno Paciente:</label>
              <input type="text" value="<?= htmlspecialchars($b_materno, ENT_QUOTES, 'UTF-8') ?>"  name="p_materno" readonly>
            </td>
          </tr>
          <tr>
            <td>
              <label>Nombre Titular:</label>
              <input type="text" value="<?= htmlspecialchars($titular['nombre'], ENT_QUOTES, 'UTF-8') ?>" disabled>
            </td>
            <td>
              <label>Apellido Paterno Titular:</label>
              <input type="text" value="<?= htmlspecialchars($titular['a_paterno'], ENT_QUOTES, 'UTF-8') ?>" disabled>
            </td>
            <td>
              <label>Apellido Materno Titular:</label>
              <input type="text" value="<?= htmlspecialchars($t_materno, ENT_QUOTES, 'UTF-8') ?>" disabled>
            </td>
          </tr>
          <tr>
            <td>
              <label>Fecha:</label>
              <input type="date" name="fecha">
            </td>
            <td>
              <label>Núm. de Tarjetón:</label>
              <input type="text" name="num_tarjeton">
            </td>
            <td>
              <label>Área de Trabajo:</label>
              <input type="text" name="area_trabajo">
            </td>
          </tr>
        </table>
      </div>

      <div class="rx-container">
        <label>RX:</label>
        <textarea name="rx" placeholder="Escribe la receta aquí..."></textarea>
      </div>
    </div>

    <!-- Campo oculto que no se muestra -->
    <input type="hidden" name="pk_beneficiario" value="<?= htmlspecialchars($id_beneficiario, ENT_QUOTES, 'UTF-8') ?>">
    <!-- Campo oculto que no se muestra -->
    <input type="hidden" name="pk_titular" value="<?= htmlspecialchars($id_titular, ENT_QUOTES, 'UTF-8') ?>">

    <div style="text-align: center; margin: 30px 0;">
      <button type="submit" class="btn-submit">
        <i class="fas fa-paper-plane"></i> Guardar Receta
      </button>
    </div>
  </form>

  <script src="js/recetas.js"></script>
</body>
</html>


