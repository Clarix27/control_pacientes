<?php
  require_once 'controladores/info_titular.php';
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
</head>
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

  <div class="content">
    <div class="filter">
      <label for="categoria">Filtro de búsqueda - Categoría:</label>
      <select id="categoria">
        <option value="" disabled selected>Categoría</option>
        <option value="confianza">Confianza</option>
        <option value="sindicalizado">Sindicalizado</option>
        <option value="seguridad">Seguridad Pública</option>
      </select>
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
          <th>Ver Historial</th>
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
              <td>
                <!-- Supongamos que tienes una página Historial_titular.php que recibe ?id= -->
                <a href="Historial_titular.php?id=<?= urlencode($fila['pk_titular']) ?>" class="icon-link">
                  <button class="btn-icon" title="Ver historial">
                    <i class="fas fa-notes-medical"></i>
                  </button>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</body>
</html>
