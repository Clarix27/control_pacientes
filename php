<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: Arial, sans-serif;
    background: #fff;
  }

  .registro-container {
    background-color: #D9D9D9;
    border-radius: 10px;
    padding: 15px 20px;
    margin: 20px;
  }

  .registro-fila {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    gap: 20px;
    flex-wrap: wrap;
  }

  .registro-fila label {
    font-weight: bold;
    margin-right: 10px;
  }

  .registro-fila select {
    padding: 6px 10px;
    border-radius: 6px;
    border: 1px solid #aaa;
    min-width: 180px;
  }

  .boton-registrar {
    background-color: #a4e0e6;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .boton-registrar:hover {
    background-color: #89cfd6;
  }

  .tabla-pacientes {
    width: 90%;
    margin: 30px auto;
    border-collapse: collapse;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
    font-size: 15px;
  }

  .tabla-pacientes th {
    background-color: #BCB8B8;
    padding: 12px;
    text-align: center;
    color: #333;
  }

  .tabla-pacientes td {
    background-color: #D9D9D9;
    padding: 10px;
    text-align: center;
  }

  h2 {
    text-align: center;
    font-size: 22px;
    margin-top: 40px;
    color: #2c3e50;
  }

  .boton-rojo {
    display: block;
    margin: 25px auto;
    padding: 10px 25px;
    background-color: #cc1a1a;
    color: white;
    font-weight: bold;
    font-size: 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .boton-rojo:hover {
    background-color: #b01212;
  }

  .back-button {
    color: #cc1a1a;
    font-size: 16px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: box-shadow 0.3s ease;
    font-weight: bold;
    padding: 6px 10px;
    border-radius: 6px;
  }

  .back-button:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
  }

  .back-text {
    font-size: 18px;
    font-weight: normal;
  }

  .titulo-pagina {
    font-size: 28px;
    font-weight: bold;
    color: #333;
  }

  .titulo-container-subtle {
    background: #9CD8D9;
    border-left: 8px solid #CC1A1A;
    padding: 2px 5px;
    margin: 20px 0 10px 0;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
  }

  .titulo-container-subtle h2 {
    margin: 0;
    font-size: 21px;
    font-weight: 600;
    text-align: center;
    color: #2c3e50;
  }

  .titulo-registro {
    font-size: 20px;
    font-weight: 600;
    color: #2c3e50;
    text-align: left;
    margin: 0;
    padding: 0 0 10px 0;
  }
</style>
<body>
  <?php include 'menu.php'?>

  <div style="margin: 15px 0 0 20px;">
    <a href="lista_titulares.php" class="back-button" title="Regresar">
      <i class="fas fa-arrow-left"></i>
      <span class="back-text">Regresar</span>
    </a>
  </div>

  <div class="titulo-container-subtle">
    <h2 style="text-align: center; margin-top: 20px;" class="titulo-pagina">CONTROL DE PACIENTES</h2>
  </div>

  <div class="registro-container">
    <h2 class="titulo-registro">Registro De Pacientes:</h2>
    <div class="registro-fila">
      <div>
        <label for="filtro_area">Filtrar por área:</label>
        <select name="filtro_area" id="filtro_area">
          <option value="">Todas</option>
          <option value="DENTAL">DENTAL</option>
          <option value="MEDICA">MÉDICA</option>
          <option value="PSICOLOGICA">PSICOLÓGICA</option>
        </select>
      </div>
      <button class="boton-registrar">REGISTRAR</button>
    </div>
  </div>

  <h2>Tabla de pacientes</h2>
  <table class="tabla-pacientes">
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
      <tr>
        <td>Jose Guadalupe Llamas Padilla</td>
        <td>Jose Guadalupe Llamas Padilla</td>
        <td class="resaltado">231–C</td>
        <td><span class="resaltado-azul">DENTAL</span></td>
        <td>DIF</td>
        <td>Apoyo DIF</td>
      </tr>
    </tbody>
  </table>

  <button class="boton-rojo">REGISTRAR</button>

</body>
</html>
