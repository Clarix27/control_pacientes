<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Expedientes</title>
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

      .expedientes-container {
    width: 90%;
    margin: 40px auto;
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .expediente-item {
    background-color: #D9D9D9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 25px;
    border-radius: 6px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    font-family: 'Poppins', sans-serif;
    font-size: 18px;
    font-weight: 500;
  }

  .expediente-info {
    display: flex;
    align-items: center;
    gap: 15px;
  }

  .icon-left {
    font-size: 28px;
  }

  .icon-right {
    font-size: 24px;
    cursor: pointer;
    transition: transform 0.2s ease;
  }

  .icon-right:hover {
    transform: scale(1.1);
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
</style>
<body>
  <?php include 'menu.php'?>

  <div style="margin: 15px 0 0 20px;">
    <a href="Inicio.html" class="back-button" title="Regresar">
      <i class="fas fa-arrow-left"></i>
      <span class="back-text">Regresar</span>
    </a>
  </div>

  <div  class="titulo-container-subtle">
      <h2 style= "text-align: center; margin-top: 20px;" class="titulo-pagina">EXPEDIENTES</h2>
  </div>

  <div class="expedientes-container">
    <div class="expediente-item">
      <div class="expediente-info">
        <i class="fas fa-archive icon-left"></i>
        <span>Expediente 1 – Abril</span>
      </div>
      <i class="fas fa-cloud-download-alt icon-right"></i>
    </div>

    <div class="expediente-item">
      <div class="expediente-info">
        <i class="fas fa-archive icon-left"></i>
        <span>Expediente 2 – Mayo</span>
      </div>
      <i class="fas fa-cloud-download-alt icon-right"></i>
    </div>

    <div class="expediente-item">
      <div class="expediente-info">
        <i class="fas fa-archive icon-left"></i>
        <span>Expediente 3 – Junio</span>
      </div>
      <i class="fas fa-cloud-download-alt icon-right"></i>
    </div>
  </div>

</body>
</html>


