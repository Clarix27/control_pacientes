<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro de Consulta - DIF Escuinapa</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
  <link rel="stylesheet" href="css/menu.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f2f2f2;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .main-content {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px 15px;
    }

    .form-container {
      background: #008080;
      padding: 25px 30px;
      border-radius: 12px;
      width: 100%;
      max-width: 700px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .form-title {
      text-align: center;
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 25px;
      color: #f2f2f2;
    }

    .form-row {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 15px;
    }

    .form-group {
      flex: 1;
    }

    input[type="text"],
    select {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
      background-color: #fdfdfd;
      box-shadow: inset 1px 1px 3px rgba(0,0,0,0.1);
      transition: border-color 0.3s;
    }

    input[type="text"]:focus,
    select:focus {
      border-color: #129990;
      outline: none;
    }

    .submit-btn {
      background-color: #00b844;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      margin-top: 15px;
      width: 100%;
      transition: background-color 0.3s ease;
    }

    .submit-btn:hover {
      background-color: #00a085;
    }

    .back-button {
      color: #333;
      font-size: 18px;
      font-weight: bold;
      text-decoration: none;
      margin: 20px;
      display: inline-block;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
      transition: color 0.3s ease;
    }

    .back-button:hover {
      color: #cc1a1a;
    }

    .back-text {
      font-weight: normal;
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

        .full-width {
  width: 100%;
}
.smaller-btn {
  width: 200px;
  margin: 20px auto 0;
  display: block;
}

  </style>
</head>

<body>
  <?php include 'menu.php' ?>

  <!-- BOTÓN REGRESAR -->
  <div>
    <a href="Historial_titular.php?id=<?=urlencode($id_titular)?>" class="back-button">
      <i class="fas fa-arrow-left"></i> <span class="back-text">Regresar</span>
    </a>
  </div>

  <!-- FORMULARIO CON DISEÑO UNIFICADO -->
  <div class="main-content">
    <div class="form-container">
      <h2 class="form-title">Registro de Consulta</h2>
      <form action="registro_consulta.php" method="POST">
        <div class="form-row">
          <div class="form-group">
            <input type="text" name="nombre" placeholder="Nombre del Paciente" required>
          </div>
          <div class="form-group">
            <input type="text" name="apellido_paterno" placeholder="Apellido Paterno" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <input type="text" name="apellido_materno" placeholder="Apellido Materno" required>
          </div>
          <div class="form-group">
            <input type="text" name="tarjeton" placeholder="Tarjetón (Ej. 231-C)" required>
          </div>
        </div>

        <div class="form-row" style="justify-content: center;">
  <div class="form-group" style="max-width: 48%;">
    <input type="text" name="area" placeholder="Área de Consulta (Ej. Dental)" required>
  </div>
</div>




<button type="submit" class="submit-btn smaller-btn">Registrar</button>

      </form>
    </div>
  </div>

  <footer>
    Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo.
    <a href="aviso_privacidad.php">Aviso de privacidad</a>
  </footer>
</body>
</html>
