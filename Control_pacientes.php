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



  <table class="tabla-pacientes" id="tablaPacientes">

    <thead>
      <tr>,
        <th>Nombre Titular:</th>
        <th>Nombre Paciente:</th>
        <th>Área de consulta:</th>
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
         
          <td>
            <span class="resaltado-azul">
              <?= htmlspecialchars($paciente['tipo_consulta'], ENT_QUOTES, 'UTF-8') ?>
            </span>
          </td>
         
          <td><?= htmlspecialchars($paciente['pago'],   ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
 <style>
  /* --- Estilos profesionales para el modal --- */
  #modalFormulario {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
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
    padding: 20px 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    position: relative;
    animation: fadeInUp 0.25s ease-out;
    font-family: 'Roboto', sans-serif;
  }

  @keyframes fadeInUp {
    from { transform: translateY(20px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
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
    transition: color 0.2s;
  }

  .modal-contenido .cerrar:hover {
    color: #A00F12;
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
    transition: border-color 0.2s;
  }

  #formControlP input:focus,
  #formControlP select:focus {
    outline: none;
    border-color: #129990;
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
    transition: background-color 0.2s;
    margin-top: 8px;
  }

  .enviar-modal:hover {
    background-color: #006B6B;
  }
</style>

  <div id="modalFormulario">
  <div class="modal-contenido">
    <button class="cerrar" onclick="cerrarModal()" title="Cerrar">
      <i class="fas fa-times"></i>
    </button>
      <h3>Registrar Consulta</h3>

    <form id="formControlP">
      <label>Nombre Titular:</label>
      <input type="text" name="nombre_t" placeholder="Nombre">
      <input type="text" name="paterno_t" placeholder="Apellido paterno">
      <input type="text" name="materno_t" placeholder="Apellido materno">

      <label>Nombre Paciente:</label>
      <input type="text" name="nombre_p" placeholder="Nombre">
      <input type="text" name="paterno_p" placeholder="Apellido paterno">
      <input type="text" name="materno_p" placeholder="Apellido materno">

        <label>Área de consulta:</label>
        <input type="text" name="area" class="resaltado-azul" placeholder="Área de consulta">

       <label>Apoyo/Pago:</label>
        <input type="number" min="0" name="apoyo" placeholder="Apoyo">

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
      document.getElementById('formControlP').reset();  // ← agrega esto
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

    <footer>
    Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo. 
    <a href="aviso_privacidad.php">Aviso de privacidad</a>
  </footer>
</body>
</html>