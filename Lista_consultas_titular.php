<?php
  session_start();
  // Verificar si el usuario ha iniciado sesión
  if (!isset($_SESSION['pk_usuario'])) {
    // Redirigir a la página de login si no está autenticado
    echo("<script>window.location.assign('Login.html');</script>");
    exit();
  }

  $id_titular = $_GET['id_t'];
  if (empty($id_titular)) {
    echo "<script>alert('No se encontro el ID');</script>";
    echo("<script>window.location.assign('Inicio.php');</script>");
    exit;
  }

  require_once 'controladores/conexion.php';
  $pdo = Conexion::getPDO();
  $sql = $pdo->prepare("SELECT c.pk_consulta, t.nombre, t.a_paterno, t.a_materno, c.tipo_consulta, c.fecha, tar.folio FROM consulta c INNER JOIN titular t ON c.fk_titular=t.pk_titular INNER JOIN tarjeton tar ON t.pk_titular=tar.fk_titular WHERE c.fk_titular = :id AND c.fk_receta IS NULL AND c.fk_beneficiario IS NULL AND c.tipo_consulta = 'CONSULTA MÉDICA' ORDER BY DAY(c.fecha) DESC, c.pk_consulta DESC;");
  $sql->bindParam(':id', $id_titular, PDO::PARAM_INT);
  $sql->execute();
  $consultas = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas Titular</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  .contenedor-consultas {
    width: 95%;
    max-width: 1000px;
    margin: 20px auto;
  }

  .tarjeta-consulta {
    background-color: #e7e7e7;
    border-radius: 12px;
    box-shadow: 2px 3px 5px rgba(0, 0, 0, 0.2);
    padding: 20px;
    position: relative;
    margin-bottom: 20px;
  }

  .fecha-etiqueta {
    position: absolute;
    top: -10px;
    left: 15px;
    background-color: #90D1CA;
    color: #000;
    font-weight: bold;
    padding: 5px 10px;
    border-radius: 8px;
    font-size: 13px;
  }

  .contenido-tarjeta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
  }

  .texto-consulta p {
    margin: 5px 0;
    font-size: 15px;
  }

  .tarjeton {
    color: #cc1a1a;
    font-weight: bold;
  }

  .btn-agregar {
    background-color: #90D1CA;
    padding: 8px 14px;
    border-radius: 6px;
    color: #000;
    font-weight: bold;
    text-decoration: none;
    box-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    transition: all 0.2s ease-in-out;
  }

  .btn-agregar:hover {
    background-color: #76c2bc;
  }

  body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    font-family: Arial, sans-serif;
    background: #fff;
  }

  footer {
    margin-top: auto;
    text-align: center;
    font-size: 14px;
    padding: 20px 10px;
    background-color: #f8f8f8;
    color: #444;
    border-top: 1px solid #ccc;
  }

  footer a {
    color: #b1071e;
    font-weight: bold;
    text-decoration: none;
  }

  footer a:hover {
    text-decoration: underline;
  }

  @media (max-width: 768px) {
    .navbar {
      flex-direction: column;
      align-items: flex-start;
      padding: 10px 15px;
    }

    .navbar-section.navbar-center {
      flex-direction: column;
      gap: 10px;
      align-items: flex-start;
      width: 100%;
      margin-top: 10px;
    }

    .menu {
      flex-direction: column;
      gap: 15px;
    }

    .menu-item {
      width: 90% !important;
      height: auto;
      padding: 30px 20px;
    }

    .filter,
    .search-box,
    .filter-left,
    .filter-right {
      flex-direction: column;
      align-items: stretch;
      width: 100%;
      gap: 10px;
    }

    .search-box input {
      width: 100%;
    }

    table {
      font-size: 14px;
      overflow-x: auto;
      display: block;
    }

    .acciones-container {
      flex-direction: column;
    }
  }

  .titulo-container-subtle {
    background: #008080;
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
    color: white;
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
</style>
<body>

  <?php include 'menu.php'?>

  <div style="margin: 15px 0 0 20px;">
    <a href="Historial_titular.php?id=<?=urlencode($id_titular)?>" class="back-button">
      <i class="fas fa-arrow-left"></i>
      <span class="back-text">Regresar</span>
    </a>
  </div>

  <div class="titulo-container-subtle">
    <h2 style="text-align: center; margin-top: 20px;" class="titulo-pagina">LISTA DE CONSULTAS DEL TITULAR</h2>
  </div>

  <div class="contenedor-consultas">
    <?php if (empty($consultas)): ?>
      <div class="sin-consultas">
        <p>No se encontraron consultas.</p>
      </div>
    <?php else: ?>
      <?php foreach ($consultas as $c): ?>
        <div class="tarjeta-consulta">
          <div class="fecha-etiqueta">
            <?= htmlspecialchars($c['fecha'], ENT_QUOTES, 'UTF-8') ?>
          </div>
          <div class="contenido-tarjeta">
            <div class="texto-consulta">
              <p>
                <strong>Paciente:</strong>
                <?= htmlspecialchars($c['nombre'] . ' ' . $c['a_paterno'] . ' ' . $c['a_materno'], ENT_QUOTES, 'UTF-8') ?>
              </p>
              <p>
                <strong>Tarjetón:</strong>
                <span class="tarjeton">
                  <?= htmlspecialchars($c['folio'], ENT_QUOTES, 'UTF-8') ?>
                </span>
              </p>
              <p>
                <strong>Área De Consulta:</strong>
                <?= htmlspecialchars($c['tipo_consulta'], ENT_QUOTES, 'UTF-8') ?>
              </p>
            </div>
            <div class="boton-consulta">
              <a href="Receta_titular.php?consulta_id=<?= urlencode($c['pk_consulta'])?>&id_t=<?=urlencode($id_titular)?>" class="btn-agregar">Agregar Receta</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <footer>
    Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo. 
    <a href="aviso_privacidad.php">Aviso de privacidad</a>
  </footer>

</body>
</html>