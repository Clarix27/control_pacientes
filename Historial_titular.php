<?php
  session_start();
  // Verificar si el usuario ha iniciado sesión
  if (!isset($_SESSION['pk_usuario'])) {
    // Redirigir a la página de login si no está autenticado
    echo("<script>window.location.assign('Login.html');</script>");
    exit();
  }
  
  require_once 'controladores/info_titular.php';
  $pk_titular = intval($_GET['id']);
  $estatus = 1;

  if (empty($pk_titular)) {
    echo "<script>alert('No se encontro el ID');</script>";
    echo("<script>window.location.assign('Inicio.php');</script>");
    exit;
  }else{
    $beneficiarios = datos_beneficiarios($pk_titular, $estatus);
    $titular = titular_id($pk_titular);
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Historial Médico - DIF Escuinapa</title>
  <link rel="stylesheet" href="css/eliminar_a.css">
  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="css/estilo_historial_titular.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<style>
  /* --- Forzar estilo de acciones en el card header --- */
.card {
  position: relative; /* para que el header-posicionado funcione */
}
.card > div:first-of-type {
  position: absolute;
  top: 20px;
  right: 20px;
  display: flex;
  gap: 8px;
  z-index: 1;
}
.card > div:first-of-type a.btn-lista,
.card > div:first-of-type a.btn-ver,
.card > div:first-of-type a.btn-registrar {
  width: 32px;
  height: 32px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 6px;
  color: #fff !important;
  font-size: 16px;
  transition: filter 0.2s;
}
/* tus colores originales */
.card > div:first-of-type a.btn-lista      { background: #6C5CE7; }
.card > div:first-of-type a.btn-ver        { background: #0984E3; }
.card > div:first-of-type a.btn-registrar  { background: #00B894; }

.card > div:first-of-type a.btn-lista:hover {
  filter: brightness(0.9);
}
.card > div:first-of-type a.btn-ver:hover {
  filter: brightness(0.9);
}
.card > div:first-of-type a.btn-registrar:hover {
  filter: brightness(0.9);
}
/* Asegurarnos de que los íconos dentro se pinten de blanco */
.card > div:first-of-type a.btn-lista i,
.card > div:first-of-type a.btn-ver i,
.card > div:first-of-type a.btn-registrar i {
  color: #fff;
}

</style>
<body>
  <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'actualizado'): ?>
    <div id="toast-exito" class="toast-exito">Titular actualizado con éxito</div>
    <script>
      setTimeout(() => {
        const toast = document.getElementById('toast-exito');
        if (toast) toast.style.display = 'none';
      }, 4000);
    </script>
  <?php endif; ?>

  <?php include 'menu.php'?>

  <div style="margin: 15px 0 0 20px;">
    <a href="Lista_titulares.php?id=<?=urlencode($pk_titular)?>" class="back-button" title="Regresar">
      <i class="fas fa-arrow-left"></i>
      <span class="back-text">Regresar</span>
    </a>
  </div>


  <div  class="titulo-container-subtle">
    <h2 style= "text-align: center; margin-top: 20px;" class="titulo-pagina">HISTORIAL CLÍNICO </h2>
  </div>

  <div class="content">
    <div class="card">
      <div style="float: right; margin-bottom: 10px;">
        <a href="Lista_general_consultas.php?id_t=<?= $pk_titular ?>" class="btn-accion btn-lista" title="Lista General">
         <i class="fas fa-list"></i>
        </a>
        <a href="Lista_consultas_titular.php?id_t=<?= $pk_titular ?>" class="btn-accion btn-ver" title="Ver Consultas">
          <i class="fas fa-envelope-open-text"></i>
        </a>
        <a href="Registro_consulta.php?id_t=<?= $pk_titular ?>" class="btn-accion btn-registrar" title="Agregar Consulta">
          <i class="fas fa-calendar-plus"></i>
        </a>
      </div>




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
      <button class="btn-afiliado"  onclick="location.href='Registro_afiliado.php?id=<?= urlencode($pk_titular) ?>'">Agregar afiliado</button>
      <table>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Edad</th>
          <th>Sexo</th>
          <th>Parentesco</th>
          <th>Acciones</th>
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
  <div class="acciones-container">
  <a href="Lista_general_consultas_b.php?id_t=<?= urlencode($pk_titular) ?>&id_b=<?= urlencode($fila['pk_beneficiario']) ?>" class="btn-accion btn-lista" title="Lista General">
    <i class="fas fa-list"></i>
  </a>
  <a href="Lista_consultas.php?id_t=<?= urlencode($pk_titular) ?>&id_b=<?= urlencode($fila['pk_beneficiario']) ?>" class="btn-accion btn-ver" title="Ver Consultas">
    <i class="fas fa-envelope-open-text"></i>
  </a>
  <a href="Registro_consulta_b.php?id_t=<?= urlencode($pk_titular) ?>&id_b=<?= urlencode($fila['pk_beneficiario']) ?>" class="btn-accion btn-registrar" title="Agregar Consulta">
    <i class="fas fa-calendar-plus"></i>
  </a>
  <a href="Editar_afiliado.php?id=<?= urlencode($fila['pk_beneficiario']) ?>" class="btn-accion btn-editar" title="Editar Afiliado">
    <i class="fas fa-pen-to-square"></i>
  </a>
  <a href="eliminar_afiliado.php" class="btn-accion btn-eliminar" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este afiliado?');">
    <i class="fas fa-trash"></i>
  </a>
</div>



</td>


      </tr>
    <?php endforeach; ?>
  <?php endif; ?>
</tbody>

    </table>
    </div>
  </div>
  

  <script src="js/eliminar_A.js"></script>

  <footer>
    Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo. 
    <a href="aviso_privacidad.php">Aviso de privacidad</a>
  </footer>
</body>
</html>