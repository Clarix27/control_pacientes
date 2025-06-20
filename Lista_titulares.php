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
  <link rel="stylesheet" href="css/menu.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<style>
  * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      font-family: Arial, sans-serif;
      background: #fff;
    }

    .navbar {
      background: #CC1A1A;
      color: white;
      padding: 20px 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .navbar-section {
      flex: 1;
      display: flex;
      align-items: center;
    }

    .navbar-left {
      justify-content: flex-start;
    }

    .navbar-center {
      justify-content: center;
      gap: 30px;
    }

    .navbar-right {
      justify-content: flex-end;
    }

    .navbar-title {
      font-weight: bold;
      font-size: 24px;
      text-transform: uppercase;
    }

    .navbar-center a {
      color: white;
      font-weight: bold;
      font-size: 16px;
      text-decoration: none;
      text-transform: uppercase;
    }

    .search-box {
      display: flex;
      align-items: center;
      background: white;
      border-radius: 30px;
      padding: 5px 10px;
    }

    .search-box input {
      border: none;
      outline: none;
      padding: 5px 10px;
      font-size: 14px;
      border-radius: 30px;
    }

    .search-box i {
      color: black;
      margin-right: 5px;
    }

    .content {
      padding: 30px;
    }

    .filter {
      background: #eee;
      padding: 15px 20px;
      margin-bottom: 30px;
      border-radius: 10px;
      font-size: 16px;
    }

    .filter label {
      font-weight: bold;
    }

    .filter select {
      margin-left: 10px;
      padding: 5px 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      text-align: left;
    }

    th, td {
      padding: 15px;
      border: 1px solid #aaa;
      vertical-align: middle;
    }

    th {
      background: #ccc;
      font-weight: bold;
    }

    .badge {
      background: #9CD8D9;
      color: black;
      padding: 5px 10px;
      border-radius: 5px;
      display: inline-block;
      font-weight: bold;
    }

    .btn-icon {
      background: none;
      border: none;
      color: #000;
      font-size: 20px;
      cursor: pointer;
    }

    .btn-icon:hover {
      color: #00b894;
    }

    .icon-link {
      text-decoration: none;
      display: flex;
      justify-content: center;
    }

/* Título centrado simple */
.titulo-pagina {
 
  font-size: 28px;
  font-weight: bold;
  color: #333;
}

/* O si prefieres con clase diferente */
.page-title {
  text-align: center;
  font-size: 28px;
  font-weight: bold;
  color: #333;
  margin: 20px 0;
  padding: 15px;
  
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

.acciones-container {
  display: flex;
  gap: 5px;
  justify-content: center;
  align-items: center;
  flex-wrap: nowrap;
  min-width: 120px;
}

.btn-accion {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 28px;
  height: 28px;
  border-radius: 6px;
  text-decoration: none;
  color: white;
  font-size: 12px;
  transition: all 0.2s ease;
  flex-shrink: 0;
}

.btn-accion:hover {
  transform: scale(1.1);
  text-decoration: none;
  color: white;
}

.btn-editar {
  background: #3498db;
}
.btn-editar:hover {
  background: #2980b9;
}

.btn-historial {
  background: #27ae60;
}
.btn-historial:hover {
  background: #229954;
}

.btn-agregar {
  background: #f39c12;
}
.btn-agregar:hover {
  background: #e67e22;
}

.btn-eliminar {
  background: #e74c3c;
}
.btn-eliminar:hover {
  background: #c0392b;
}

.filter {
  background: #eee;
  padding: 15px 20px;
  margin-bottom: 30px;
  border-radius: 10px;
  font-size: 16px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
}

.filter-left {
  display: flex;
  align-items: center;
  gap: 10px;
}

.filter-right {
  display: flex;
  align-items: center;
  margin-top: 10px;
}

.search-box {
  display: flex;
  align-items: center;
  background: white;
  border-radius: 30px;
  padding: 5px 10px;
  border: 1px solid #ccc;
}

.search-box input {
  border: none;
  outline: none;
  padding: 5px 10px;
  font-size: 14px;
  border-radius: 30px;
  width: 200px;
}

.search-box i {
  color: #666;
  margin-right: 5px;
}

</style>
<body>
<?php include 'menu.php'?>

  <?php include 'regresar.php'?>

 
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


