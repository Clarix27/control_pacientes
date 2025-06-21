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
  <link rel="stylesheet" href="css/menu.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<style>
  * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
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
      font-size: 20px;
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

    .card {
      background: #eee;
      padding: 30px 20px 20px 20px;
      border-radius: 8px;
      margin-bottom: 30px;
      position: relative;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .etiqueta {
      position: absolute;
      top: -12px;
      left: 10px;
      background: #6ec1e4;
      color: rgb(0, 0, 0);
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
      font-weight: bold;
    }

    .detalle-cita {
      position: absolute;
      top: 10px;
      right: 10px;
      background: #9CD8D9;
      color: black;
      padding: 6px 12px;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }

    .card h4 {
      text-transform: uppercase;
      font-weight: bold;
      margin-bottom: 15px;
      font-size: 15px;
      color: #555;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px 40px;
      font-size: 15px;
      color: #333;
    }

    .tabla-container {
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: left;
    }

    th {
      background: #ccc;
      font-weight: bold;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .detalle-cita-afiliado {
      background: #9CD8D9;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: bold;
      color: black;
      cursor: pointer;
    }

    .btn-afiliado {
      background: #0ed142;
      color: white;
      font-weight: bold;
      padding: 6px 12px;
      border: none;
      border-radius: 4px;
      float: right;
      margin-bottom: 10px;
      cursor: pointer;
    }
    /* Título centrado simple */
    
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

a i {
  text-decoration: none;
}
a {
  text-decoration: none;
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
  margin-right: 5px;
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



  .titulo-container-subtle h2 {
  margin: 0;
  font-size: 21px;
  font-weight: 600;
  text-align: center;
  color: #2c3e50;
  }

  a i {
    text-decoration: none;
  }
  a {
    text-decoration: none;
  }
  .back-button {
  color: #333;
  font-size: 18px;
  font-weight: bold;
  text-decoration: none;
  text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
  transition: color 0.3s ease;
}

.back-button:hover {
  color: #cc1a1a;
  text-shadow: 1px 1px 3px rgba(204, 26, 26, 0.6);
}

.back-text {
  font-size: 18px;  
  font-weight: normal;
}
.back-button:hover {
  color: #cc1a1a;
  text-shadow: 1px 1px 3px rgba(204, 26, 26, 0.6);
}
</style>
<body>
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
  <a href="ver_receta.php?id=<?= $pk_titular ?>" class="btn-accion btn-historial" title="Ver Recetas">
    <i class="fas fa-envelope-open-text"></i>
  </a>
  <a href="agregar_receta.php?id_t=<?=urlencode($pk_titular)?>" class="btn-accion btn-agregar" title="Agregar Receta">
    <i class="fas fa-file-medical"></i>
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
  <a href="Editar_afiliado.php?id=<?= urlencode($fila['pk_beneficiario']) ?>" class="btn-accion btn-editar" title="Editar">
      <i class="fas fa-pen-to-square"></i>
    </a>
    <a href="ver_receta.php" class="btn-accion btn-historial" title="Ver Recetas">
      <i class="fas fa-envelope-open-text"></i>
    </a>
    <a href="Recetas.php?id_t=<?=urlencode($pk_titular)?>&id_b=<?=urlencode($fila['pk_beneficiario'])?>"class="btn-accion btn-agregar" title="Agregar Receta">
      <i class="fas fa-file-medical"></i>
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
</body>
</html>
