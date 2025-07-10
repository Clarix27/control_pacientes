<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Error 404 - Página no encontrada</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
  font-family: 'Poppins', sans-serif;
  background: #fff;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

main {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
}


    .navbar {
  background-color: #b1071e; /* Color similar al de la imagen */
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 25px; 
  font-family: 'Poppins', sans-serif;
  font-weight: 800;
  color: #ffffff;
  text-transform: uppercase;
  letter-spacing: 1px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  margin-top: 5px;
}

/* Logotipo DIF a la izquierda (fuera si lo deseas con posición absoluta) */
.navbar .logo {
  display: flex;
  align-items: center;
  font-weight: bold;
  font-size: 20px;
  color: white;
}
/* Icono engranaje a la derecha */
.navbar .icono-config {
  margin-left: 20px;
  cursor: pointer;
}
.icono-config img {
  cursor: pointer;
  transition: transform 0.2s;
  filter: brightness(0) invert(1); 
}

.icono-config img:hover {
  transform: scale(1.1);
}

.contenido-error {
  text-align: center;
  padding: 50px 20px;
  max-width: 700px;
}



.contenido-error h3 {
  font-size: 48px;
  color: #CC1A1A;
  margin-bottom: 20px;
  font-weight: 800;
  text-transform: uppercase;
}


.contenido-error p {
  font-size: 16px;
  color: #444;
  margin-bottom: 25px;
}

.btn-volver {
  display: inline-block;
  background-color: #008080;
  color: white;
  padding: 10px 20px;
  border-radius: 8px;
  font-weight: bold;
  text-decoration: none;
  transition: background-color 0.3s ease;
}

.btn-volver:hover {
  background-color: #006666;
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
  </style>
</head>
<body>

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

  <main>
  <div class="contenido-error">
    <h3>Error 404 - Página no encontrada</h3>
    <p>La página que estás intentando acceder no existe o ha sido movida. Por favor verifica la URL o vuelve al menú principal.</p>
    <a href="Inicio.php" class="btn-volver">Volver al inicio</a>
  </div>
</main>



  <footer>
    Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo. 
    <a href="aviso_privacidad.php">Aviso de privacidad</a>
  </footer>

</body>
</html>
