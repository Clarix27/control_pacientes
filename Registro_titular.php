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
  <title>Registro de Paciente - DIF Escuinapa</title>
  <link rel="stylesheet" href="css/estilo_reg_titular.css">
  <link rel="stylesheet" href="css/alerta_titular.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/menu.css">
</head>

<body>
<?php include 'menu.php'?>

  <div style="margin: 15px 0 0 20px;">
  <a href="Inicio.php" class="back-button" title="Regresar">
    <i class="fas fa-arrow-left"></i>
    <span class="back-text">Regresar</span>
  </a>
</div>


  <!-- FORMULARIO -->
  <div class="main-content">
    <div class="form-container">
      <h2 style=" filter: brightness(0) invert(1);" class="form-title">REGISTRO DE TITULAR</h2>
      <form id="formTitular">
        <div class="form-row">
          <div class="form-group">
            <input type="text" name="nombre" placeholder="Nombre" required>
          </div>
          <div class="form-group">
            <input type="text" name="apaterno" placeholder="Apellido paterno" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <input type="text" name="amaterno" placeholder="Apellido materno">
          </div>
          <div class="form-group">
            <input type="text" name="puesto" placeholder="Puesto" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <input type="text" name="calle" placeholder="Calle">
          </div>
          <div class="form-group">
            <input type="number" min="0" name="num_casa" placeholder="Número de casa">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <input type="text" name="colonia" placeholder="Colonia">
          </div>
          <div class="form-group">
            <input type="text" name="municipio" placeholder="Municipio">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group" style="width: 100%;">
            <input type="text" name="direccion" placeholder="Dirección">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group" style="width: 100%;">
            <input type="text" name="folio" placeholder="Número del Tarjetón">
          </div>
        </div>

        <div class="form-group">
          <select name="categoria">
            <option value="" disabled selected>CATEGORÍA</option>
            <option value="confianza">Confianza</option>
            <option value="sindicalizado">Sindicalizado</option>
            <option value="seguridad pública">Seguridad Pública</option>
          </select>
        </div>

        <button type="submit" class="submit-btn">Enviar</button>
      </form>
    </div>
  </div>

  <script src="js/registro_titular.js"></script>

  <footer>
  Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo.
  <a href="aviso_privacidad.php">Aviso de privacidad</a>
</footer>

</body>
</html>
