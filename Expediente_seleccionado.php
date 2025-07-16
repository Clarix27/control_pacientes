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
  <link rel="stylesheet" href="css/exp_sele.css">
</head>
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

  <footer>
  Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo.
  <a href="aviso_privacidad.php">Aviso de privacidad</a>
</footer>


</body>
</html>


