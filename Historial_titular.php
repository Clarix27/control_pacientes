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
  <link rel="stylesheet" href="css/menu.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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
.titulo-pagina {
 
 font-size: 28px;
 font-weight: bold;
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


</style>
<body>
<?php include 'menu.php'?>


<!-- Flecha de regreso abajo del navbar, esquina izquierda -->
<div style="margin: 15px 0 0 20px;">
  <a href="lista_titulares.php" class="back-button" title="Regresar">
    <i class="fas fa-arrow-left"></i>
    <span class="back-text">Regresar</span>
  </a>
</div>

    <div  class="titulo-container-subtle">
    <h2 style= "text-align: center; margin-top: 20px;" class="titulo-pagina">HISTORIAL CLÍNICO </h2>
    </div>

  <div class="content">
    <div class="card">
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
