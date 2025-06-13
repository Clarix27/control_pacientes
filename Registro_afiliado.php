
<!DOCTYPE html> 
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro de Paciente - DIF Escuinapa</title>
  <link rel="stylesheet" href="css/estilo_reg_titular.css">
  <link rel="stylesheet" href="css/alerta_titular.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/menu.css">
  <style>
    
  </style>
</head>

<body>
<?php include 'menu.php'?>

  <!-- BOTÓN REGRESAR -->
  <div style="margin: 15px 0 0 20px;">
    <a href="Historial_titular.php?id=<?= urlencode($fila['pk_titular']) ?>" class="back-button" title="Regresar">
      <i class="fas fa-arrow-left"></i>
      <span class="back-text">Regresar</span>
    </a>
  </div>

  <!-- FORMULARIO -->
  <div class="main-content">
    <div class="form-container">
      <h2 class="form-title">Registro del afiliado</h2>
      <form id="formTitular">
        <div class="form-row">
          <div class="form-group">
            <input type="text" name="nombre" placeholder="Nombre" required>
          </div>
          <div class="form-group">
            <input type="text" name="apaterno" placeholder="Apellido paterno" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <input type="text" name="amaterno" placeholder="Apellido materno">
          </div>
          <div class="form-group">
            <input type="text" name="edad" placeholder="Edad" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <input type="text" name="sexo" placeholder="Sexo">
          </div>
          <div class="form-group">
            <input type="text" name="parentesco" placeholder="Parentesco">
          </div>
        </div>

        <button type="submit" class="submit-btn">Enviar</button>
      </form>
    </div>
  </div>

  <script src="js/.js"></script>
</body>
</html>


