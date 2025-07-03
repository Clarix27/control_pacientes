<?php
  session_start();
  // Verificar si el usuario ha iniciado sesión
  if (!isset($_SESSION['pk_usuario'])) {
    // Redirigir a la página de login si no está autenticado
    echo("<script>window.location.assign('Login.html');</script>");
    exit();
  }
  
  require_once 'controladores/info_titular.php';
  $id_titular = $_GET['id_t'];
  $id_beneficiario = $_GET['id_b'];

  $titular = titular_id($id_titular);
  // Obtener tarjetón del titular
require_once 'controladores/conexion.php';
$pdo = Conexion::getPDO();
$stmt_tarjeton = $pdo->prepare("SELECT folio FROM tarjeton WHERE fk_titular = ?");
$stmt_tarjeton->execute([$id_titular]);
$tarjeton = $stmt_tarjeton->fetch(PDO::FETCH_ASSOC);
$folio_tarjeton = $tarjeton['folio'] ?? 'No asignado';

  $t_materno = $titular['a_materno'] ?? '';
  $beneficiario = info_beneficiario($id_beneficiario);
  $b_materno = $beneficiario['a_materno'] ?? '';


?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Receta Médica - Afiliado</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="css/alerta_receta.css">
  <link rel="stylesheet" href="css/estilo_recetas.css">
</head>
<body>

  <?php include 'menu.php' ?>


  <div style="margin: 15px 0 0 20px;">
  <a href="Lista_consultas.php" class="back-button">
    <i class="fas fa-arrow-left"></i>
    <span class="back-text">Regresar</span>
  </a>
  </div>


  <div  class="titulo-container-subtle">
    <h2 style= "text-align: center; margin-top: 20px;" class="titulo-pagina">RECETA MEDICA</h2>
  </div>

  <form id="formRecetas">
    <div class="content">
      <div class="tabla-datos">
        <table>
          <tr>
            <td>
              <label>Nombre Paciente:</label>
              <input type="text" value="<?= htmlspecialchars($beneficiario['nombre'], ENT_QUOTES, 'UTF-8') ?>" name="p_nombre" readonly>
            </td>
            <td>
              <label>Apellido Paterno Paciente:</label>
              <input type="text" value="<?= htmlspecialchars($beneficiario['a_paterno'], ENT_QUOTES, 'UTF-8') ?>"  name="p_paterno" readonly>
            </td>
            <td>
              <label>Apellido Materno Paciente:</label>
              <input type="text" value="<?= htmlspecialchars($b_materno, ENT_QUOTES, 'UTF-8') ?>"  name="p_materno" readonly>
            </td>
          </tr>
          <tr>
            <td>
              <label>Nombre Titular:</label>
              <input type="text" value="<?= htmlspecialchars($titular['nombre'], ENT_QUOTES, 'UTF-8') ?>" disabled>
            </td>
            <td>
              <label>Apellido Paterno Titular:</label>
              <input type="text" value="<?= htmlspecialchars($titular['a_paterno'], ENT_QUOTES, 'UTF-8') ?>" disabled>
            </td>
            <td>
              <label>Apellido Materno Titular:</label>
              <input type="text" value="<?= htmlspecialchars($t_materno, ENT_QUOTES, 'UTF-8') ?>" disabled>
            </td>
          </tr>
          <tr>
            <td>
              <label>Fecha:</label>
              <input type="date" name="fecha">
            </td>
            <td>
  <label>Núm. de Tarjetón:</label>
  <input type="text" name="num_tarjeton" value="<?= htmlspecialchars($folio_tarjeton) ?>" readonly>
</td>
            <td>
              <label>Área:</label>
              <input type="text" name="area_trabajo">
            </td>
          </tr>
        </table>
      </div>

      <div class="rx-container">
        <label>RX:</label>
        <textarea name="rx" placeholder="Escribe la receta aquí..."></textarea>
      </div>
    </div>

    <!-- Campo oculto que no se muestra -->
    <input type="hidden" name="pk_titular" value="<?= htmlspecialchars($id_titular, ENT_QUOTES, 'UTF-8') ?>">

    <div style="text-align: center; margin: 30px 0;">
      <button type="submit" class="btn-submit">
        <i class="fas fa-paper-plane"></i> Guardar Receta
      </button>
    </div>
  </form>

  <script src="js/recetas.js"></script>

  <footer>
  Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo.
  <a href="aviso_privacidad.php">Aviso de privacidad</a>
</footer>

</body>
</html>