<?php
  session_start();
  // Verificar si el usuario ha iniciado sesión
  if (!isset($_SESSION['pk_usuario'])) {
    // Redirigir a la página de login si no está autenticado
    echo("<script>window.location.assign('Login.html');</script>");
    exit();
  }

  require_once 'controladores/conexion.php';
  $pdo = Conexion::getPDO();
  $sql = $pdo->query("SELECT ti.nombre AS t_nombre, ti.a_paterno AS t_paterno, ti.a_materno AS t_materno, p.nombre, p.a_paterno, p.a_materno, tar.folio, c.tipo_consulta, ti.dependencia, c.pago FROM consulta c INNER JOIN paciente p ON c.fk_paciente=p.pk_paciente INNER JOIN titular ti ON p.fk_titular=ti.pk_titular LEFT JOIN tarjeton tar ON ti.pk_titular=tar.fk_titular WHERE c.fecha = CURDATE() ORDER BY c.pk_consulta DESC");
  $pacientes = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Pacientes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/alerta_controlP.css">
    <link rel="stylesheet" href="css/control_pacientes.css">
</head>
<body>
  <?php include 'menu.php'?>

  <div style="margin: 15px 0 0 20px;">
  <a href="Inicio.php" class="back-button" title="Regresar">
    <i class="fas fa-arrow-left"></i>
    <span class="back-text">Regresar</span>
  </a>
</div>

  <div class="titulo-container-subtle">
    <h2 style="text-align: center; margin-top: 20px;" class="titulo-pagina">CONTROL DE PACIENTES</h2>
  </div>

  <div class="registro-container">
    <h2 class="titulo-registro">Buscador de pacientes:</h2>
    <div class="registro-fila">
      <div class="search-box">
        <i class="fas fa-search"></i>
        <input id="buscador" type="text" placeholder="Buscar paciente...">
      </div>
      <div style="margin-left: auto;">
        <button class="boton-registrar" onclick="mostrarModal()">REGISTRAR CONSULTA</button>
      </div>
    </div>
  </div>
<div class="titulo-containerr-subtlee">
    <h2 style="text-align: center; margin-top: 20px;" class="titulo-pagina">LISTA DE PACIENTES</h2>
  </div>


  <table class="tabla-pacientes" id="tablaPacientes">

    <thead>
      <tr>
        <th>Nombre Titular:</th>
        <th>Nombre Paciente:</th>
        <th>Tarjeton:</th>
        <th>Área:</th>
        <th>Dependencia:</th>
        <th>Apoyo/Pago:</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($pacientes)): ?>
        <tr>
          <td colspan="6" style="text-align:center">
            No se encontraron pacientes.
          </td>
        </tr>
      <?php endif; ?>
      <?php foreach ($pacientes as $paciente): ?>
        <tr>
          <td><?= htmlspecialchars($paciente['t_nombre'].' '.$paciente['t_paterno'].' '.$paciente['t_materno'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($paciente['nombre'].' '.$paciente['a_paterno'].' '.$paciente['a_materno'], ENT_QUOTES, 'UTF-8') ?></td>
          <td class="resaltado">
            <?= !empty($paciente['folio']) ? htmlspecialchars($paciente['folio'], ENT_QUOTES, 'UTF-8'): 'Sin Tarjeton'?>
          </td>
          <td>
            <span class="resaltado-azul">
              <?= htmlspecialchars($paciente['tipo_consulta'], ENT_QUOTES, 'UTF-8') ?>
            </span>
          </td>
          <td><?= !empty($paciente['dependencia']) ? htmlspecialchars($paciente['dependencia'], ENT_QUOTES, 'UTF-8'): 'No Tiene' ?></td>
          <td><?= htmlspecialchars($paciente['pago'],   ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  
  <div id="modalFormulario">
    <div class="modal-contenido">

      <!-- Botón de cerrar con ícono de X -->
      <button class="cerrar" onclick="cerrarModal()" title="Cerrar">
        <i class="fas fa-times"></i>
      </button>

      <form id="formControlP">
        <label>Nombre Titular:</label>
        <input type="text" name="nombre_t" placeholder="Nombre">
        <input type="text" name="paterno_t" placeholder="Apellido paterno">
        <input type="text" name="materno_t" placeholder="Apellido materno">

        <label>Tarjeton:</label>
        <input type="text" name="tarjeton" class="resaltado" placeholder="Tarjeton">

        <label>Dependencia:</label>
        <input type="text" name="dependencia" placeholder="Dependencia">

        <label>Nombre Paciente:</label>
        <input type="text" name="nombre_p" placeholder="Nombre">
        <input type="text" name="paterno_p" placeholder="Apellido paterno">
        <input type="text" name="materno_p" placeholder="Apellido materno">

        <label>Área:</label>
        <input type="text" name="area" class="resaltado-azul" placeholder="Área">

        <label>Apoyo/Pago:</label>
        <input type="number" min="0" name="apoyo" placeholder="Apoyo">

        <label>Fecha:</label>
        <input type="date" name="fecha">

        <label>Parentesco:</label>
        <select id="opciones" name="parentesco">
          <option value="">-- Selecciona el Parentesco --</option>
          <option value="Esposo">Esposa/o</option>
          <option value="Hija">Hija</option>
          <option value="Hijo">Hijo</option>
          <option value="Misma persona">Misma persona</option>
        </select>

        <!-- Botón enviar agregado debajo del formulario -->
        <button type="submit" class="enviar-modal">Enviar Datos</button>
      </form>
    </div>  
  </div>

  <script>
    function mostrarModal() {
      document.getElementById('modalFormulario').style.display = 'flex';
    }
    function cerrarModal() {
      document.getElementById('modalFormulario').style.display = 'none';
    }

    // Buscador dinámico
    document.getElementById('buscador').addEventListener('keyup', function () {
      const filtro = this.value.toLowerCase();
      const filas = document.querySelectorAll('#tablaPacientes tbody tr');

      filas.forEach(fila => {
        const nombreTitular = fila.cells[0].textContent.toLowerCase();
        const nombrePaciente = fila.cells[1].textContent.toLowerCase();
        const tarjeton = fila.cells[2].textContent.toLowerCase();

        const coincide = nombreTitular.includes(filtro) || nombrePaciente.includes(filtro) || tarjeton.includes(filtro);

        fila.style.display = coincide ? '' : 'none';
      });
    });
  </script>

  <script src="js/control_pacientes.js"></script>
</body>
</html>