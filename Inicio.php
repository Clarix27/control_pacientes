<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Menú Principal - Control de Pacientes</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/estilo_inicio.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="page">
    
    <div class="logo">
      <img src="img/logo_dif.jpeg" alt="Logo DIF" style="height: 70px; margin-left: 20px; margin-top: 10px;">
    </div>

    <div class="navbar">
      CONTROL DE PACIENTES DIF
      <div class="icono-config">
        <!-- Se elimina href directo para activar el modal con onclick -->
        <a href="#" onclick="mostrarModalCerrarSesion(); return false;" title="Cerrar sesión">
          <img src="img/ingresar.png" alt="Cerrar sesión" style="height: 35px;">
        </a>
      </div>
    </div>      

    <div class="center-content">
      <div class="menu">
        <div class="menu-item" onclick="location.href='Registro_titular.php'" style="cursor: pointer;">
          <i class="fas fa-user-plus"></i>
          <p>Agregar Titular</p>
        </div>
        <div class="menu-item" onclick="location.href='Lista_titulares.php'" style="cursor: pointer;">
          <i class="fas fa-users"></i>
          <p>Lista De Titulares DIF</p>
        </div>
        <div class="menu-item" onclick="location.href='Expedientes.php'" style="cursor: pointer;">
          <i class="fas fa-folder-open"></i>
          <p>Expedientes</p>
        </div>
        <div class="menu-item" onclick="location.href='Control_pacientes.php'" style="cursor: pointer;">
          <i class="fas fa-desktop"></i>
          <p>Control De Pacientes</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de confirmación de cierre de sesión -->
  <div id="modalCerrarSesion">
    <div class="modal-contenido">
      <p>¿Estás seguro que deseas cerrar sesión?</p>
      <button class="confirmar" onclick="cerrarSesion()">Sí, cerrar sesión</button>
      <button class="cancelar" onclick="ocultarModalCerrarSesion()">Cancelar</button>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    function mostrarModalCerrarSesion() {
      document.getElementById('modalCerrarSesion').style.display = 'flex';
    }

    function ocultarModalCerrarSesion() {
      document.getElementById('modalCerrarSesion').style.display = 'none';
    }

    function cerrarSesion() {
      window.location.href = 'logout.php';
    }
  </script>
</body>
</html>