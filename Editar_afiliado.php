<?php
  session_start();
  // Verificar si el usuario ha iniciado sesión
  if (!isset($_SESSION['pk_usuario'])) {
    // Redirigir a la página de login si no está autenticado
    echo("<script>window.location.assign('Login.html');</script>");
    exit();
  }
  require_once 'controladores/info_titular.php';

  $id = intval($_GET['id']);
  $beneficiario = beneficiario_id($id);

  if (!$beneficiario) {
      echo "Afiliado no encontrado.";
      exit;
  }

  // Primero obtener fk_tarjeton del beneficiario
  $fk_tarjeton = $beneficiario['fk_tarjeton'];

  $pdo = Conexion::getPDO();
  $stmt = $pdo->prepare("SELECT fk_titular FROM tarjeton WHERE pk_tarjeton = :tarjeton");
  $stmt->bindParam(':tarjeton', $fk_tarjeton, PDO::PARAM_INT);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  $pk_titular = $row ? $row['fk_titular'] : null;

?>
<!DOCTYPE html> 
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Editar Afiliado - DIF Escuinapa</title>
  <link rel="stylesheet" href="css/estilo_reg_titular.css">
  <link rel="stylesheet" href="css/alerta_titular.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/menu.css">
</head>
<body>
<?php include 'menu.php'; ?>

<div style="margin: 15px 0 0 20px;">
  <a href="Historial_titular.php?id=<?= urlencode($pk_titular) ?>" class="back-button" title="Regresar">
    <i class="fas fa-arrow-left"></i>
    <span class="back-text">Regresar</span>
  </a>
</div>

<?php if (isset($_GET['error'])): ?>
  <div id="toast-error" class="toast-error"><?= htmlspecialchars($_GET['error']) ?></div>
  <script>
    setTimeout(() => {
      const toast = document.getElementById('toast-error');
      if (toast) toast.style.display = 'none';
    }, 4000);
  </script>
<?php endif; ?>

<div class="main-content">
  <div class="form-container">
    <h2 style=" filter: brightness(0) invert(1);" class="form-title">EDITAR BENEFICIARIO</h2>
    <form id="formEditarBeneficiario" method="POST" action="controladores/procesar_edicion_afiliado.php" onsubmit="return validarFormulario();">
      <input type="hidden" name="id" value="<?= htmlspecialchars($beneficiario['pk_beneficiario']) ?>">
      <input type="hidden" name="pk_titular" value="<?= htmlspecialchars($pk_titular) ?>">

      <div class="form-row">
  <div class="form-group">
    <input
      type="text"
      name="nombre"
      placeholder="Nombre"
      value="<?= htmlspecialchars($beneficiario['nombre']) ?>"
      required
    >
  </div>
  <div class="form-group">
    <input
      type="text"
      name="apaterno"
      placeholder="Apellido Paterno"
      value="<?= htmlspecialchars($beneficiario['a_paterno']) ?>"
      required
    >
  </div>
</div>

<div class="form-row">
  <div class="form-group">
    <input
      type="text"
      name="amaterno"
      placeholder="Apellido Materno"
      value="<?= htmlspecialchars($beneficiario['a_materno']) ?>"
    >
  </div>
  <div class="form-group">
    <input
      type="number"
      name="edad"
      placeholder="Edad"
      value="<?= htmlspecialchars($beneficiario['edad']) ?>"
      min="0"
      max="130"
      required
    >
  </div>
</div>

      <div class="form-row">
        <div class="form-group">
          <select name="sexo">
            <option value="">-- Selecciona el Sexo --</option>
            <option value="M" <?= $beneficiario['sexo'] === 'M' ? 'selected' : '' ?>>M</option>
            <option value="F" <?= $beneficiario['sexo'] === 'F' ? 'selected' : '' ?>>F</option>
            <option value="N" <?= $beneficiario['sexo'] === 'N' ? 'selected' : '' ?>>Otro</option>
          </select>
        </div>
        <div class="form-group">
          <select name="parentesco">
            <option value="">-- Selecciona el Parentesco --</option>
            <option value="Esposo" <?= in_array($beneficiario['parentesco'], ['Esposo', 'Esposa']) ? 'selected' : '' ?>>Esposa/o</option>
            <option value="Hija" <?= $beneficiario['parentesco'] === 'Hija' ? 'selected' : '' ?>>Hija</option>
            <option value="Hijo" <?= $beneficiario['parentesco'] === 'Hijo' ? 'selected' : '' ?>>Hijo</option>
          </select>
        </div>
      </div>

      <button type="submit" class="submit-btn">Guardar Cambios</button>
    </form>
  </div>
</div>

<script>
function validarFormulario() {
  const form = document.forms['formEditarBeneficiario'];
  const campos = ['nombre', 'apaterno', 'edad', 'sexo', 'parentesco'];
  for (let campo of campos) {
    if (form[campo].value.trim() === "") {
      alert(`Por favor completa el campo: ${campo}`);
      return false;
    }
  }
  return true;
}
</script>

  <footer>
    Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo. 
    <a href="aviso_privacidad.php">Aviso de privacidad</a>
  </footer>

</body>
</html>
 