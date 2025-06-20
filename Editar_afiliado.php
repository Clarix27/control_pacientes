<?php
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
<style>
    .back-button {
      color: #333;
      font-size: 30px; 
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: color 0.3s ease;
    }

    .back-button:hover {
      color: #000;
    }

    .back-text {
      font-size: 18px;  
      font-weight: normal;
    }

  </style>
<body>

<?php include 'menu.php'; ?>

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
    <h2 class="form-title">Editar afiliado</h2>
    <form id="formEditarBeneficiario" method="POST" action="controladores/procesar_edicion_afiliado.php">
      <input type="hidden" name="id" value="<?= htmlspecialchars($beneficiario['pk_beneficiario']) ?>">
      <input type="hidden" name="pk_titular" value="<?= htmlspecialchars($pk_titular) ?>">

      <div class="form-row">
        <div class="form-group">
          <input type="text" name="nombre" placeholder="Nombre" value="<?= htmlspecialchars($beneficiario['nombre']) ?>">
        </div>
        <div class="form-group">
          <input type="text" name="apaterno" placeholder="Apellido Paterno" value="<?= htmlspecialchars($beneficiario['a_paterno']) ?>">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <input type="text" name="amaterno" placeholder="Apellido Materno" value="<?= htmlspecialchars($beneficiario['a_materno']) ?>">
        </div>
        <div class="form-group">
          <input type="number" min="0" max="200" name="edad" placeholder="Edad" value="<?= htmlspecialchars($beneficiario['edad']) ?>">
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
</body>
</html>
