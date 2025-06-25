<?php
  session_start();
  // Verificar si el usuario ha iniciado sesión
  if (!isset($_SESSION['pk_usuario'])) {
    // Redirigir a la página de login si no está autenticado
    echo("<script>window.location.assign('Login.html');</script>");
    exit();
  }
  
  require_once 'controladores/conexion.php';
  $mes = intval($_GET['mes']);
  $anio = intval($_GET['anio']);
  $pdo = Conexion::getPDO();
  $stmt = $pdo->prepare("SELECT ti.nombre AS t_nombre, ti.a_paterno AS t_paterno, ti.a_materno AS t_materno, p.nombre, p.a_paterno, p.a_materno, tar.folio, c.tipo_consulta, ti.dependencia, c.pago FROM consulta c INNER JOIN paciente p ON c.fk_paciente = p.pk_paciente INNER JOIN titular ti  ON p.fk_titular = ti.pk_titular LEFT JOIN tarjeton tar ON tar.fk_titular = ti.pk_titular WHERE MONTH(c.fecha) = :mes AND YEAR(c.fecha) = :anio ORDER BY DAY(c.fecha) DESC, c.pk_consulta DESC");
  $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
  $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
  $stmt->execute();
  $expediente = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Expediente Seleccionado</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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

  .tabla-expediente {
    width: 95%;
    margin: 30px auto;
    font-family: 'Poppins', sans-serif;
  }

  .tabla-expediente table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  .tabla-expediente th {
    background-color: #bcb8b8;
    padding: 12px;
    font-weight: bold;
    border: 1px solid #666;
  }

  .tabla-expediente td {
    background-color: #d9d9d9;
    padding: 10px;
    border: 1px solid #999;
  }

  .rojo {
    color: #c80000;
    font-weight: bold;
  }

  .area {
    font-weight: bold;
    padding: 4px 10px;
    border-radius: 4px;
    display: inline-block;
  }

  .area.celeste {
    background-color: #9CD8D9;
  }

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
  border: 1px solid #666;
}

.tabla-expediente td {
  background-color: #d9d9d9;
  padding: 10px;
  border: 1px solid #999;
}

.rojo {
  color: #c80000;
  font-weight: bold;
}

.area {
  font-weight: bold;
  padding: 4px 10px;
  border-radius: 4px;
  display: inline-block;
}

.area.celeste {
  background-color: #9CD8D9;
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

.titulo-registro {
  font-size: 20px;
  font-weight: 600;
  color: #2c3e50;
  text-align: left;
  margin: 0;
  font-size: 21px;
  font-weight: 600;
  text-align: center;
  color: #2c3e50;
  }

  .titulo-registro {
    font-size: 20px;
    font-weight: 600;
    color: #2c3e50;
    text-align: left;
    margin: 0;
    padding: 0 0 10px 0;
  }
</style>
<body>
  <?php include 'menu.php'?>

    <?php include 'regresar.php'?>

  <div  class="titulo-container-subtle">
    <h2 style= "text-align: center; margin-top: 20px;" class="titulo-pagina">EXPEDIENTE SELECCIONADO</h2>
  </div>

  <div class="tabla-expediente">
    <table>
      <thead>
        <tr>
          <th>Nombre Titular:</th>
          <th>Nombre Paciente:</th>
          <th>Tarjetón:</th>
          <th>Área:</th>
          <th>Dependencia:</th>
          <th>Apoyo/Pago:</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($expediente)): ?>
          <tr>
            <td colspan="6" style="text-align:center">Vacío</td>
          </tr>
        <?php else: ?>
          <?php foreach ($expediente as $exp): ?>
            <tr>
              <td><?= htmlspecialchars($exp['t_nombre'].' '.$exp['t_paterno'].' '.$exp['t_materno'],   ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($exp['nombre'].' '.$exp['a_paterno'].' '.$exp['a_materno'],  ENT_QUOTES, 'UTF-8') ?></td>
              <td class="rojo">
                <?= !empty($exp['folio']) ? htmlspecialchars($exp['folio'], ENT_QUOTES, 'UTF-8'): 'Sin Tarjeton'?>
              </td>
              <td>
                <span class="area celeste">
                  <?= htmlspecialchars($exp['tipo_consulta'], ENT_QUOTES, 'UTF-8') ?>
                </span>
              </td>
              <td><?= !empty($exp['dependencia']) ? htmlspecialchars($exp['dependencia'], ENT_QUOTES, 'UTF-8'): 'Sin Dependencia'?></td>
              <td><?= htmlspecialchars($exp['pago'],   ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</body>
</html>


