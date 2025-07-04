<?php
  session_start();
  // Verificar si el usuario ha iniciado sesión
  if (!isset($_SESSION['pk_usuario'])) {
    // Redirigir a la página de login si no está autenticado
    echo("<script>window.location.assign('Login.html');</script>");
    exit();
  }
  require_once 'controladores/conexion.php';
  require_once 'controladores/info_titular.php';

  if (!isset($_GET['id'])) {
      echo "ID no proporcionado";
      exit;
  }

  $id = intval($_GET['id']);
  $titular = titular_id($id);

  if (!$titular) {
      echo "Titular no encontrado.";
      exit;
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Editar Titular - DIF Escuinapa</title>

  <link rel="stylesheet" href="css/estilo_reg_titular.css">
  <link rel="stylesheet" href="css/alerta_titular.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/menu.css">
</head>
<body>

<?php include 'menu.php' ?>

<?php include 'regresar.php'?>

<div class="main-content">
  <div class="form-container">
    <h2 style=" filter: brightness(0) invert(1);" class="form-title">Editar titular</h2>
    <form id="formEditarTitular" method="POST" action="controladores/procesar_edicion.php">
      <input type="hidden" name="id" value="<?= htmlspecialchars($titular['pk_titular']) ?>">

      <div class="form-row">
        <div class="form-group">
        <input type="text" name="nombre" placeholder="Nombre" value="<?= htmlspecialchars($titular['nombre']) ?>" required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,40}" title="Solo letras, mínimo 4 caracteres.">
        </div>
        <div class="form-group">
          <input type="text" name="apaterno" placeholder="Apellido paterno" value="<?= htmlspecialchars($titular['a_paterno']) ?>" required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,40}" title="Solo letras, mínimo 4 caracteres.">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <input type="text" name="amaterno" placeholder="Apellido materno" value="<?= htmlspecialchars($titular['a_materno']) ?>" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,40}" title="Solo letras, mínimo 4 caracteres.">
        </div>
        <div class="form-group">
          <input type="text" name="puesto" placeholder="Puesto" value="<?= htmlspecialchars($titular['puesto']) ?>" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <input type="text" name="calle" placeholder="Calle" value="<?= htmlspecialchars($titular['calle']) ?>">
        </div>
        <div class="form-group">
        <input type="text" name="num_casa" placeholder="Número de casa" value="<?= htmlspecialchars($titular['num_casa']) ?>">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
        <input type="text" name="colonia" placeholder="Colonia" value="<?= htmlspecialchars($titular['colonia']) ?>">
        </div>
        <div class="form-group">
        <input type="text" name="municipio" placeholder="Municipio" value="<?= htmlspecialchars($titular['municipio']) ?>">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group" style="width: 100%;">
        <input type="text" name="direccion" placeholder="Dirección" value="<?= htmlspecialchars($titular['direccion']) ?>">
        </div>
      </div>

      <div class="form-group">
        <select name="categoria" required>
          <option value="" disabled>CATEGORÍA</option>
          <option value="confianza" <?= $titular['categoria'] === 'confianza' ? 'selected' : '' ?>>Confianza</option>
          <option value="sindicalizado" <?= $titular['categoria'] === 'sindicalizado' ? 'selected' : '' ?>>Sindicalizado</option>
          <option value="seguridad" <?= $titular['categoria'] === 'seguridad' ? 'selected' : '' ?>>Seguridad Pública</option>
        </select>
      </div>

      <button type="submit" class="submit-btn">Guardar Cambios</button>
    </form>
  </div>
</div>

  <footer>
    Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo. 
    <a href="aviso_privacidad.php">Aviso de privacidad</a>
  </footer>
</body>
</html>

<script>
  document.getElementById('formEditarTitular').addEventListener('submit', function(e) {
    const requiredFields = ['nombre', 'apaterno', 'puesto', 'categoria'];
    let valid = true;

    requiredFields.forEach(name => {
      const input = document.querySelector(`[name="${name}"]`);
      if (!input || input.value.trim() === '') {
        input.style.border = '2px solid red';
        valid = false;
      } else {
        input.style.border = '';
      }
    });

    if (!valid) {
      e.preventDefault();
      alert('Por favor llena todos los campos obligatorios.');
    }
  });
</script>

