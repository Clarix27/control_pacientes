<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

    .tabla-expediente {
  width: 95%;
  margin: 30px auto;
  font-family: 'Poppins', sans-serif;
}

.tabla-expediente table {
  width: 100%;
  border-collapse: collapse;
  text-align: center;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.tabla-expediente th {
  background-color: #bcb8b8;
  padding: 12px;
  font-weight: bold;
  border: 1px solid #666;
}

.tabla-expediente td {
  background-color: #d9d9d9;
  padding: 10px;
  border: 1px solid #999;
}

.rojo {
  color: #c80000;
  font-weight: bold;
}

.area {
  font-weight: bold;
  padding: 4px 10px;
  border-radius: 4px;
  display: inline-block;
}

.area.celeste {
  background-color: #9CD8D9;
}

.back-button {
  color: #333;
  font-size: 30px; 
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: color 0.3s ease;
}

.back-button:hover {
  color: #000;
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

<div  class="titulo-container-subtle">
    <h2 style= "text-align: center; margin-top: 20px;" class="titulo-pagina">EXPEDIENTE SELECCIONADO</h2>
    </div>

    <div class="tabla-expediente">
  <table>
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
        <td class="rojo">231–C</td>
        <td><span class="area celeste">DENTAL</span></td>
        <td>DIF</td>
        <td>Apoyo DIF</td>
      </tr>
      <tr>
        <td>Jose Guadalupe Llamas Padilla</td>
        <td>Jose Guadalupe Llamas Padilla</td>
        <td class="rojo">231–C</td>
        <td><span class="area celeste">DENTAL</span></td>
        <td>DIF</td>
        <td>Apoyo DIF</td>
      </tr>
      <tr>
        <td>Jose Guadalupe Llamas Padilla</td>
        <td>Jose Guadalupe Llamas Padilla</td>
        <td class="rojo">231–C</td>
        <td><span class="area celeste">DENTAL</span></td>
        <td>DIF</td>
        <td>Apoyo DIF</td>
      </tr>
      <tr>
        <td>Jose Guadalupe Llamas Padilla</td>
        <td>Jose Guadalupe Llamas Padilla</td>
        <td class="rojo">231–C</td>
        <td><span class="area celeste">DENTAL</span></td>
        <td>DIF</td>
        <td>Apoyo DIF</td>
      </tr>
    </tbody>
  </table>
</div>

</body>
</html>


