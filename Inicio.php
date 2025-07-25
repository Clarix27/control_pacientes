<?php
  session_start();
  // Verificar si el usuario ha iniciado sesión
  if (!isset($_SESSION['pk_usuario'])) {
    // Redirigir a la página de login si no está autenticado
    echo("<script>window.location.assign('Login.html');</script>");
    exit();
  }
?>
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
        <a href="#" onclick="mostrarModalCerrarSesion(); return false;" title="Cerrar sesión">
          <img src="img/ingresar.png" alt="Cerrar sesión" style="height: 35px;">
        </a>
      </div>
    </div>      

    <div class="center-content">
      <div class="menu">
        <div class="menu-item" onclick="location.href='Registro_titular.php'" style="cursor: pointer;">
          <i style=" filter: brightness(0) invert(1);" class="fas fa-user-plus"></i>
          <p style=" filter: brightness(0) invert(1);">Agregar Titular</p>
        </div>
        <div class="menu-item" onclick="location.href='Lista_titulares.php'" style="cursor: pointer;">
          <i style=" filter: brightness(0) invert(1);" class="fas fa-users"></i>
          <p style=" filter: brightness(0) invert(1);">Titulares DIF</p>
        </div>
        <div class="menu-item" onclick="location.href='Expedientes.php'" style="cursor: pointer;">
          <i style=" filter: brightness(0) invert(1);" class="fas fa-folder-open"></i>
          <p style=" filter: brightness(0) invert(1);">Expedientes</p>
        </div>
        <div class="menu-item" onclick="location.href='Control_pacientes.php'" style="cursor: pointer;">
          <i style=" filter: brightness(0) invert(1);" class="fas fa-desktop"></i>
          <p style=" filter: brightness(0) invert(1);" >Control De Pacientes</p>
        </div>
      </div>
    </div>
  </div>

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

    <footer>
    Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo. 
    <a href="aviso_privacidad.php">Aviso de privacidad</a>
  </footer>
</body>
</html>