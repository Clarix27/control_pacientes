<?php
  session_start();
  if (!isset($_SESSION['pk_usuario'])) {
    echo("<script>window.location.assign('Login.html');</script>");
    exit();
  }

  require_once 'controladores/conexion.php';
  $pdo = Conexion::getPDO();
  $sql = $pdo->query("SELECT c.pk_consulta, ti.nombre AS t_nombre, ti.a_paterno AS t_paterno, ti.a_materno AS t_materno, p.nombre, p.a_paterno, p.a_materno, c.tipo_consulta, c.pago FROM consulta c INNER JOIN paciente p ON c.fk_paciente=p.pk_paciente INNER JOIN titular ti ON p.fk_titular=ti.pk_titular WHERE c.fecha = CURDATE() AND c.fk_receta IS NULL AND c.fk_beneficiario IS NULL AND ti.categoria = 'Normal' ORDER BY c.pk_consulta DESC");
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
  <style>
    #modalFormulario {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.6);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }

    .modal-contenido {
      background: #fff;
      border-radius: 8px;
      width: 90%;
      max-width: 420px;
      padding: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      position: relative;
      animation: fadeInUp 0.25s ease-out;
      font-family: 'Roboto', sans-serif;
    }

    @keyframes fadeInUp {
      from { transform: translateY(20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .modal-contenido .cerrar {
      position: absolute;
      top: 12px;
      right: 12px;
      background: transparent;
      border: none;
      font-size: 18px;
      color: #CC1A1A;
      cursor: pointer;
    }

    .modal-contenido h3 {
      margin-bottom: 15px;
      font-size: 20px;
      font-weight: 600;
      color: #096B68;
      text-align: center;
    }

    #formControlP {
      display: grid;
      grid-template-columns: 1fr;
      gap: 12px;
    }

    #formControlP label {
      font-weight: 600;
      color: #096B68;
      font-size: 14px;
    }

    #formControlP input[type="text"],
    #formControlP input[type="number"],
    #formControlP select {
      width: 100%;
      padding: 8px 10px;
      border: 1px solid #CCC;
      border-radius: 4px;
      font-size: 13px;
    }

    .enviar-modal {
      background-color: #008080;
      color: #fff;
      padding: 10px;
      border: none;
      border-radius: 4px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 8px;
    }

    .enviar-modal:hover {
      background-color: #006B6B;
    }

    .btn-accion {
      display: inline-block;
      padding: 6px 10px;
      border: none;
      background: none;
      cursor: pointer;
      text-decoration: none;
      color: #006666;
      font-size: 16px;
    }

    .btn-accion:hover {
      color: #004d4d;
    }

    .btn-editar i {
      font-size: 18px;
    }

    .modal-editar {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.6);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }

    .modal-editar .modal-contenido {
      background: #fff;
      border-radius: 8px;
      width: 90%;
      max-width: 420px;
      padding: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      position: relative;
      animation: fadeInUp 0.25s ease-out;
      font-family: 'Roboto', sans-serif;
    }

    .modal-editar .modal-contenido h3 {
      margin-bottom: 15px;
      font-size: 20px;
      font-weight: 600;
      color: #096B68;
      text-align: center;
    }

    .modal-editar .modal-contenido .cerrar {
      position: absolute;
      top: 12px;
      right: 12px;
      background: transparent;
      border: none;
      font-size: 18px;
      color: #CC1A1A;
      cursor: pointer;
    }

    .modal-editar input[type="text"],
    .modal-editar input[type="number"],
    .modal-editar select {
      width: 100%;
      padding: 8px 10px;
      border: 1px solid #CCC;
      border-radius: 4px;
      font-size: 13px;
      margin-bottom: 10px;
    }

    .modal-editar label {
      font-weight: 600;
      color: #096B68;
      font-size: 14px;
    }

    .modal-editar .enviar-modal {
      background-color: #008080;
      color: #fff;
      padding: 10px;
      border: none;
      border-radius: 4px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 8px;
    }

    .modal-editar .enviar-modal:hover {
      background-color: #006B6B;
    }

    @keyframes fadeInUp {
      from { transform: translateY(20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
  </style>
</head>
<body>
  <?php include 'menu.php' ?>

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

  <table class="tabla-pacientes" id="tablaPacientes">
    <thead>
  <tr>
    <th>Nombre Titular:</th>
    <th>Nombre Paciente:</th>
    <th>Área de consulta:</th>
    <th>Apoyo/Pago:</th>
    <th>Acciones:</th>
  </tr>
</thead>

    <tbody>
  <?php if (empty($pacientes)): ?>
    <tr>
      <td colspan="5" style="text-align:center">No se encontraron pacientes.</td>
    </tr>
  <?php endif; ?>
  <?php foreach ($pacientes as $paciente): ?>
    <tr>
      <td><?= htmlspecialchars($paciente['t_nombre'].' '.$paciente['t_paterno'].' '.$paciente['t_materno']) ?></td>
      <td><?= htmlspecialchars($paciente['nombre'].' '.$paciente['a_paterno'].' '.$paciente['a_materno']) ?></td>
      <td><span class="resaltado-azul"><?= htmlspecialchars($paciente['tipo_consulta']) ?></span></td>
      <td><?= htmlspecialchars($paciente['pago']) ?></td>
<td>
  <button class="btn-accion btn-editar"
    data-id="<?= (int) $paciente['pk_consulta'] ?>"
    data-area="<?= htmlspecialchars($paciente['tipo_consulta'], ENT_QUOTES, 'UTF-8') ?>"
    data-pago="<?= htmlspecialchars($paciente['pago'], ENT_QUOTES, 'UTF-8') ?>"
    data-nombre="<?= htmlspecialchars($paciente['nombre'], ENT_QUOTES, 'UTF-8') ?>"
    data-paterno="<?= htmlspecialchars($paciente['a_paterno'], ENT_QUOTES, 'UTF-8') ?>"
    data-materno="<?= htmlspecialchars($paciente['a_materno'], ENT_QUOTES, 'UTF-8') ?>"
    data-nombre-t="<?= htmlspecialchars($paciente['t_nombre'], ENT_QUOTES, 'UTF-8') ?>"
    data-paterno-t="<?= htmlspecialchars($paciente['t_paterno'], ENT_QUOTES, 'UTF-8') ?>"
    data-materno-t="<?= htmlspecialchars($paciente['t_materno'], ENT_QUOTES, 'UTF-8') ?>"
    onclick="abrirModalEditarDesdeAttr(this)">
    <i class="fas fa-pen-to-square"></i>
  </button>
</td>

    </tr>
  <?php endforeach; ?>
</tbody>

  </table>

  <!-- Modal -->
  <div id="modalFormulario">
    <div class="modal-contenido">
      <button class="cerrar" onclick="cerrarModal()" title="Cerrar"><i class="fas fa-times"></i></button>
      <h3>Registrar Consulta</h3>

      <form id="formControlP">
        <label>Parentesco:</label>
        <select id="opciones" name="parentesco" onchange="cambiarCampos()">
          <option value="">-- Selecciona el Parentesco --</option>
          <option value="ESPOSO/A">Esposa/o</option>
          <option value="HIJA">Hija</option>
          <option value="HIJO">Hijo</option>
          <option value="MISMA PERSONA">Misma persona</option>
        </select>

        
        <div id="camposTitular">
          <label>Nombre Acompañante:</label>
          <input type="text" name="nombre_t" id="nombre_t" placeholder="Nombre">
          <input type="text" name="paterno_t" id="paterno_t" placeholder="Apellido Paterno">
          <input type="text" name="materno_t" id="materno_t" placeholder="Apellido Materno">
        </div>

        <div id="camposPaciente">
          <label>Nombre Paciente:</label>
          <input type="text" name="nombre_p" id="nombre_p" placeholder="Nombre">
          <input type="text" name="paterno_p" id="paterno_p" placeholder="Apellido Paterno">
          <input type="text" name="materno_p" id="materno_p" placeholder="Apellido Materno">
        </div>

        <label>Área de consulta:</label>
        <!-- <input type="text" name="area" class="resaltado-azul" placeholder="Área de consulta"> -->
        <select name="area" class="resaltado-azul">
          <option value="">-- Selecciona un Área de Consulta --</option>
          <option value="DENTAL">Dental</option>
          <option value="CONSULTA MÉDICA">Consulta Médica</option>
        </select>

        <label>Apoyo/Pago:</label>
        <input type="number" min="0" name="apoyo" placeholder="Apoyo">

        <button type="submit" class="enviar-modal">Enviar Datos</button>
      </form>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    function mostrarModal() {
      document.getElementById('modalFormulario').style.display = 'flex';
    }

    function cerrarModal() {
      document.getElementById('modalFormulario').style.display = 'none';
      document.getElementById('formControlP').reset();
      document.getElementById('camposPaciente').style.display = 'block';
    }

    function cambiarCampos() {
      const parentesco = document.getElementById('opciones').value;
      const camposTitular = document.getElementById('camposTitular');

      if (parentesco === "MISMA PERSONA") {
        camposTitular.style.display = "none";

        // document.getElementById('nombre_p').value = document.getElementById('nombre_t').value;
        // document.getElementById('paterno_p').value = document.getElementById('paterno_t').value;
        // document.getElementById('materno_p').value = document.getElementById('materno_t').value;
      } else {
        camposTitular.style.display = "block";
        document.getElementById('nombre_t').value = "";
        document.getElementById('paterno_t').value = "";
        document.getElementById('materno_t').value = "";
      }
    }

    document.getElementById('buscador').addEventListener('keyup', function () {
      const filtro = this.value.toLowerCase();
      const filas = document.querySelectorAll('#tablaPacientes tbody tr');

      filas.forEach(fila => {
        const nombreTitular = fila.cells[0].textContent.toLowerCase();
        const nombrePaciente = fila.cells[1].textContent.toLowerCase();
        const consulta = fila.cells[2].textContent.toLowerCase();

        const coincide = nombreTitular.includes(filtro) || nombrePaciente.includes(filtro) || consulta.includes(filtro);
        fila.style.display = coincide ? '' : 'none';
      });
    });
  </script>

<div id="modalEditar" class="modal-editar" style="display:none;">
  <div class="modal-contenido">
    <button class="cerrar" onclick="cerrarModalEditar()" title="Cerrar"><i class="fas fa-times"></i></button>
    <h3>Editar Consulta</h3>

    <form id="formEditarConsulta">
      <input type="hidden" name="id_consulta" id="edit_id_consulta">

      <!-- CAMPOS PACIENTE -->
<div id="grupoPaciente">
  <label>Nombre del paciente:</label>
  <input type="text" name="nombre_p" id="edit_nombre_p" placeholder="Nombre">

  <label>Apellido paterno:</label>
  <input type="text" name="paterno_p" id="edit_paterno_p" placeholder="Apellido paterno">

  <label>Apellido materno:</label>
  <input type="text" name="materno_p" id="edit_materno_p" placeholder="Apellido materno">
</div>

<!-- CAMPOS TITULAR -->
<div id="grupoTitular">
  <label>Nombre del titular:</label>
  <input type="text" name="nombre_t" id="edit_nombre_t" placeholder="Nombre titular">

  <label>Apellido paterno titular:</label>
  <input type="text" name="paterno_t" id="edit_paterno_t" placeholder="Apellido paterno">

  <label>Apellido materno titular:</label>
  <input type="text" name="materno_t" id="edit_materno_t" placeholder="Apellido materno">
</div>


      <label>Área de consulta:</label>
      <select name="area" id="edit_area">
        <option value="DENTAL">Dental</option>
        <option value="CONSULTA MÉDICA">Consulta Médica</option>
      </select>

      <label>Apoyo/Pago:</label>
      <input type="number" name="pago" id="edit_pago" min="0">

      <button type="submit" class="enviar-modal">Guardar Cambios</button>
    </form>
  </div>
</div>




  <script src="js/control_pacientes.js"></script>

  <footer>
    Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo. 
    <a href="aviso_privacidad.php">Aviso de privacidad</a>
  </footer>
</body>
</html>
