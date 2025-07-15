<?php
  session_start();
  // Verificar si el usuario ha iniciado sesión
  if (!isset($_SESSION['pk_usuario'])) {
    // Redirigir a la página de login si no está autenticado
    echo("<script>window.location.assign('Login.html');</script>");
    exit();
  }
  
  $pk_titular = $_GET['id'];
?>
<!DOCTYPE html> 
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro de Paciente - DIF Escuinapa</title>
  <link rel="stylesheet" href="css/estilo_reg_titular.css">
  <link rel="stylesheet" href="css/alerta_titular.css">
  <link rel="stylesheet" href="css/estilo_receta.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/menu.css">
  <style>
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

  <!-- BOTÓN REGRESAR -->
  <div style="margin: 15px 0 0 20px;">
    <a href="Historial_titular.php?id=<?= urlencode($pk_titular) ?>" class="back-button" title="Regresar">
      <i class="fas fa-arrow-left"></i>
      <span class="back-text">Regresar</span>
    </a>
  </div>

  <!-- FORMULARIO -->
  <div class="main-content">
    <div class="form-container">
      <h2 style=" filter: brightness(0) invert(1);" class="form-title">REGISTRO DEL BENEFICIARIO</h2>
      <form id="formBeneficiario">
        <div class="form-row">
          <div class="form-group">
            <input type="text" name="nombre" placeholder="Nombre">
          </div>
          <div class="form-group">
            <input type="text" name="apaterno" placeholder="Apellido Paterno">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <input type="text" name="amaterno" placeholder="Apellido Materno">
          </div>
          <div class="form-group">
            <input type="number" min="0"  max="200" name="edad" placeholder="Edad">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <select id="opciones" name="sexo">
              <option value="">-- Selecciona el Sexo --</option>
              <option value="M">M</option>
              <option value="F">F</option>
              <option value="N">Otro</option>
            </select>
          </div>
          <div class="form-group">
            <select id="opciones" name="parentesco">
              <option value="">-- Selecciona el Parentesco --</option>
              <option value="Esposo">Esposa/o</option>
              <option value="Hija">Hija</option>
              <option value="Hijo">Hijo</option>
            </select>
          </div>
        </div>
        <!-- Campo oculto que no se muestra -->
        <input type="hidden" name="pk_titular" value="<?= htmlspecialchars($pk_titular, ENT_QUOTES, 'UTF-8') ?>">
        <button type="submit" class="submit-btn">Enviar</button>
      </form>
    </div>
  </div>

  <script src="js/registro_afiliado.js"></script>

    <footer>
    Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo. 
    <a href="aviso_privacidad.php">Aviso de privacidad</a>
  </footer>
</body>
</html>


