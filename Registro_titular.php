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

  <?php include 'regresar.php'?>


  <!-- FORMULARIO -->
  <div class="main-content">
    <div class="form-container">
      <h2 class="form-title">Registro de titular</h2>
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
            <input type="text" name="puesto" placeholder="Puesto" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <input type="text" name="calle" placeholder="Calle">
          </div>
          <div class="form-group">
            <input type="text" name="num_casa" placeholder="Número de casa">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <input type="text" name="colonia" placeholder="Colonia">
          </div>
          <div class="form-group">
            <input type="text" name="municipio" placeholder="Municipio">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group" style="width: 100%;">
            <input type="text" name="direccion" placeholder="Dirección">
          </div>
        </div>

        <div class="form-group">
          <select name="categoria" required>
            <option value="" disabled selected>CATEGORÍA</option>
            <option value="confianza">Confianza</option>
            <option value="sindicalizado">Sindicalizado</option>
            <option value="seguridad">Seguridad Pública</option>
          </select>
        </div>

        <button type="submit" class="submit-btn">Enviar</button>
      </form>
    </div>
  </div>

  <script src="js/registro_titular.js"></script>
</body>
</html>
