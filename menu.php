<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/menu.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <title>Document</title>
</head>
<body>

  <div class="logo">
    <img src="img/logo_dif.jpeg" alt="Logo DIF" style="height: 70px; margin-left: 20px; margin-top: 10px;">
  </div>

  <div class="navbar">
    CONTROL DE PACIENTES DIF
    <div class="navbar-section navbar-center">
      <a href="Inicio.php">Inicio</a>
      <a href="Registro_titular.php">Agregar Titular</a>
      <a href="Lista_titulares.php">Lista de Titulares</a>
      <a href="Expedientes.php">Expedientes</a>
      <a href="Control_pacientes.php">Control de Pacientes</a>
    </div>
    <div class="icono-config">
      <a href="#" onclick="mostrarModalCerrarSesion(); return false;" title="Cerrar sesión">
        <img src="img/ingresar.png" alt="Cerrar sesión" style="height: 35px;">
      </a>
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
