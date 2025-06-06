<?php
  require_once 'controladores/info_titular.php';
  $pk_titular = intval($_GET['id']);

  if (empty($pk_titular)) {
    echo "<script>alert('No se encontro el ID');</script>";
    echo("<script>window.location.assign('Inicio.html');</script>");
    exit;
  }else{
    $beneficiarios = datos_beneficiarios($pk_titular);
    $titular = titular_id($pk_titular);
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Historial Médico - DIF Escuinapa</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/estilo_historial_titular.css">
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

  <div class="navbar">
    <div class="navbar-section navbar-left">
      <span class="navbar-title">Control de Pacientes</span>
    </div>
    <div class="navbar-section navbar-center">
      <a href="Inicio.html">Inicio</a>
      <a href="#">Expedientes</a>
      <a href="#">Pacientes</a>
    </div>
    <div class="navbar-section navbar-right">
      <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Buscar paciente">
      </div>
    </div>
  </div>
<!-- Flecha de regreso abajo del navbar, esquina izquierda -->
<div style="margin: 15px 0 0 20px;">
  <a href="lista_titulares.php" class="back-button" title="Regresar">
    <i class="fas fa-arrow-left"></i>
    <span class="back-text">Regresar</span>
  </a>
</div>




  <div class="content">
    <div class="card">
      <span class="etiqueta">Historial Médico</span>
      <button class="detalle-cita">Detalle cita</button>
      <h4>Sistema Municipal para el Desarrollo Integral de la Familia del Municipio de Escuinapa</h4>
      <div class="info-grid">
        <div><strong>Paciente: </strong><?= htmlspecialchars($titular['nombre'].' '.$titular['a_paterno'].' '.$titular['a_materno'], ENT_QUOTES, 'UTF-8') ?></div>
        <div><strong>Dirección: </strong><?= htmlspecialchars($titular['direccion'], ENT_QUOTES, 'UTF-8') ?></div>
        <div><strong>Domicilio: </strong><?= htmlspecialchars($titular['calle'], ENT_QUOTES, 'UTF-8') ?></div>
        <div><strong>Categoría: </strong><?= htmlspecialchars($titular['categoria'], ENT_QUOTES, 'UTF-8') ?></div>
        <div><strong>Puesto: </strong><?= htmlspecialchars($titular['puesto'], ENT_QUOTES, 'UTF-8') ?></div>
      </div>
    </div>

    <div class="tabla-container">
      <button class="btn-agregar">Agregar afiliado</button>
      <table>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Edad</th>
          <th>Sexo</th>
          <th>Parentesco</th>
          <th>Ver Citas</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($beneficiarios)): ?>
          <tr>
            <td colspan="6">No se encontraron afiliados.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($beneficiarios as $fila): ?>
            <tr>
              <td><?= htmlspecialchars($fila['nombre'].' '.$fila['a_paterno'].' '.$fila['a_materno'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($fila['edad'].' años', ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($fila['sexo'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($fila['parentesco'], ENT_QUOTES, 'UTF-8') ?></td>
              <td>
                <a href="Detalle_cita.php?id=<?= urlencode($titular['pk_titular']) ?>">
                  <button class="detalle-cita-afiliado" title="Detalle cita">
                    Detalle cita
                  </button>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
    </div>
  </div>

</body>
</html>
