<?php
  require_once 'controladores/info_titular.php';
  $pk_titular = true;
  $datos_titular = info_titilar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Listado de Pacientes - DIF Escuinapa</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/estilo_lista_titulares.css">
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
</style>
<body>
<?php include 'menu.php'?>

  <div style="margin: 15px 0 0 20px;">
  <a href="Inicio.html?id=<?=urlencode($pk_titular)?>" class="back-button" title="Regresar">
    <i class="fas fa-arrow-left"></i>
    <span class="back-text">Regresar</span>
  </a>
</div>
 
  <div  class="titulo-container-subtle">
   <h2 style= "text-align: center; margin-top: 20px;" class="titulo-pagina">LISTA DE PACIENTES AFILIADOS AL DIF</h2>
  </div>

  <div class="content">
    <div class="filter">
  <div class="filter-left">
    <label for="categoria">Filtro de búsqueda - Categoría:</label>
    <select id="categoria">
      <option value="" disabled selected>Categoría</option>
      <option value="confianza">Confianza</option>
      <option value="sindicalizado">Sindicalizado</option>
      <option value="seguridad">Seguridad Pública</option>
    </select>
  </div>

  <div class="filter-right">
    <div class="search-box">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Buscar paciente...">
    </div>
  </div>
</div>


    <!-- Tabla para mostrar la información del titular. -->
    <table>
      <thead>
        <tr>
          <th>Nombre Titular</th>
          <th>Domicilio</th>
          <th>Puesto</th>
          <th>Dirección</th>
          <th>Dependencia</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($datos_titular)): ?>
          <tr>
            <td colspan="6">No se encontraron titulares.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($datos_titular as $fila): ?>
            <tr>
              <td><?= htmlspecialchars($fila['nombre'].' '.$fila['a_paterno'].' '.$fila['a_materno'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($fila['calle'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><strong><?= htmlspecialchars($fila['puesto'], ENT_QUOTES, 'UTF-8') ?></strong></td>
              <td><?= htmlspecialchars($fila['direccion'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><span class="badge"><?= htmlspecialchars($fila['categoria'], ENT_QUOTES, 'UTF-8') ?></span></td>
                
                <!-- ACCIONES -->
                <td>
                  <div class="acciones-container">
                    <a href="editar_titular.php?id=<?= urlencode($fila['pk_titular']) ?>" class="btn-accion btn-editar" title="Editar">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="eliminar_titular.php?id=<?= urlencode($fila['pk_titular']) ?>" class="btn-accion btn-eliminar" title="Eliminar" onclick="return confirm('¿Seguro?')">
                      <i class="fas fa-trash"></i>
                    </a>
                    <a href="Historial_titular.php?id=<?= urlencode($fila['pk_titular']) ?>" class="btn-accion btn-historial" title="Historial">
                      <i class="fas fa-file-medical"></i>
                    </a>
                  </div>
                </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</body>
</html>


