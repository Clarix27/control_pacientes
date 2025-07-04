<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consulta con Receta</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      font-family: Arial, sans-serif;
      background: #fff;
    }

    .titulo-container-subtle {
      background: #008080;
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
      color: white;
    }

    .back-button {
    color: #333;
    font-size: 18px;
    font-weight: bold;
    text-decoration: none;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    transition: color 0.3s ease;
  }

  .back-button:hover {
    color: #cc1a1a;
    text-shadow: 1px 1px 3px rgba(204, 26, 26, 0.6);
  }

  .back-text {
    font-size: 18px;  
    font-weight: normal;
  }


    .contenedor-consultas {
      width: 100%;
      padding: 40px 20px 0 20px;
    }

    .tarjeta-consulta {
  background-color: #eee;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  padding: 30px 30px 25px 30px;
  margin-bottom: 30px;
  position: relative;
}


    .fecha-etiqueta {
      position: absolute;
      top: -12px;
      left: 10px;
      background: #6ec1e4;
      color: #000;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
      font-weight: bold;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px 40px;
      font-size: 15px;
      color: #333;
    }

    .tarjeton {
      color: #cc1a1a;
      font-weight: bold;
    }

    .btn-agregar {
      background-color: #f39c12;
      padding: 8px 14px;
      border-radius: 6px;
      color: #000;
      font-weight: bold;
      text-decoration: none;
      box-shadow: 1px 1px 2px rgba(0,0,0,0.2);
      transition: all 0.2s ease-in-out;
      display: inline-block;
      margin-top: 15px;
    }

    .btn-agregar:hover {
      background-color: #e67e22;
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

    .filter-right {
    display: flex;
    align-items: center;
    margin-top: 10px;
  }

  .search-box {
    display: flex;
    align-items: center;
    background: white;
    border-radius: 30px;
    padding: 5px 10px;
  }

  .search-box input {
    border: none;
    outline: none;
    padding: 5px 10px;
    font-size: 14px;
    border-radius: 30px;
  }

  .search-box i {
    color: black;
    margin-right: 5px;
  }

  .content {
    padding: 30px;
  }

  .filter {
    background: #eee;
    padding: 15px 20px;
    margin-bottom: 30px;
    border-radius: 10px;
    font-size: 16px;
  }

  .filter label {
    font-weight: bold;
  }

  .filter select {
    margin-left: 10px;
    padding: 5px 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
  }

  .buscador-container {
  margin-top: 25px;
  display: flex;
  justify-content: flex-end;
  padding: 0 25px;
}

.buscador-box {
  display: flex;
  align-items: center;
  background: #f5f5f5;
  border-radius: 30px;
  padding: 8px 16px;
  width: 300px;
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
}

.buscador-box input {
  border: none;
  outline: none;
  background: transparent;
  padding: 6px 10px;
  font-size: 15px;
  width: 100%;
}

.buscador-box i {
  color: #555;
  font-size: 16px;
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

.search-box {
  display: flex;
  align-items: center;
  background: white;
  border-radius: 30px;
  padding: 5px 10px;
  border: 1px solid #ccc;
}

.search-box input {
  border: none;
  outline: none;
  padding: 5px 10px;
  font-size: 14px;
  border-radius: 30px;
  width: 200px;
}

.search-box i {
  color: #666;
  margin-right: 5px;
}

.contenedor-consultas-multicolumna {
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* Solo 2 columnas */
  gap: 30px 40px;
  max-width: 1400px;
  margin: 0 auto;
  padding: 40px 30px 60px 30px;
}



  </style>
</head>
<body>

<?php include 'menu.php'?>

  <div style="margin: 15px 0 0 20px;">
    <a href="Lista_titulares.php?id=<?=urlencode($pk_titular)?>" class="back-button" title="Regresar">
      <i class="fas fa-arrow-left"></i>
      <span class="back-text">Regresar</span>
    </a>
  </div>

<!-- Simulación de inclusión del menú -->
<div  class="titulo-container-subtle">
    <h2 style= "text-align: center; margin-top: 20px;" class="titulo-pagina">LISTA GENERAL</h2>
  </div>

  <div class="registro-container" style="margin-top: 10px;">
  <div class="registro-fila">
    <div class="search-box">
      <i class="fas fa-search"></i>
      <input id="buscador" type="text" placeholder="Buscar paciente...">
    </div>
  </div>
</div>

<div class="contenedor-consultas-multicolumna">
  <!-- Tarjeta 1 -->
  <div class="tarjeta-consulta">
    <div class="fecha-etiqueta">24/06/2025</div>
    <div style="font-size: 15px; color: #333; display: flex; flex-direction: column; gap: 10px;">
      <div><strong>Paciente:</strong> Clara Juliana Estrada Peraza</div>
      <div><strong>Tarjetón:</strong> <span class="tarjeton">000123456</span></div>
      <div><strong>Área de Consulta:</strong> Psicología</div>
      <div style="background: #fff; padding: 10px; border-left: 4px solid #129990; border-radius: 6px; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-capsules" style="color: #129990;"></i>
        <div><strong>Receta:</strong> - Hialuronato de Sodio / Trehalosa
  (0.15%)          (3%)
  1 gota cada 12 horas

- Hialuronato de Sodio 0.05mg/mL (Colirumpost)
  1 gota cada 24 horas</div>
      </div>
    </div>
  </div>

  <!-- Tarjeta 2 -->
  <div class="tarjeta-consulta">
    <div class="fecha-etiqueta">24/06/2025</div>
    <div style="font-size: 15px; color: #333; display: flex; flex-direction: column; gap: 10px;">
      <div><strong>Paciente:</strong> Clara Juliana Estrada Peraza</div>
      <div><strong>Tarjetón:</strong> <span class="tarjeton">000123456</span></div>
      <div><strong>Área de Consulta:</strong> Psicología</div>
      <div style="background: #fff; padding: 10px; border-left: 4px solid #129990; border-radius: 6px; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-capsules" style="color: #129990;"></i>
        <div><strong>Receta:</strong> Sertralina 50mg</div>
      </div>
    </div>
  </div>

  <!-- Puedes seguir agregando más tarjetas aquí -->
   <div class="tarjeta-consulta">
    <div class="fecha-etiqueta">24/06/2025</div>
    <div style="font-size: 15px; color: #333; display: flex; flex-direction: column; gap: 10px;">
      <div><strong>Paciente:</strong> Clara Juliana Estrada Peraza</div>
      <div><strong>Tarjetón:</strong> <span class="tarjeton">000123456</span></div>
      <div><strong>Área de Consulta:</strong> Psicología</div>
      <div style="background: #fff; padding: 10px; border-left: 4px solid #129990; border-radius: 6px; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-capsules" style="color: #129990;"></i>
        <div><strong>Receta:</strong> Sertralina 50mg</div>
      </div>
    </div>
  </div>

  <div class="tarjeta-consulta">
    <div class="fecha-etiqueta">24/06/2025</div>
    <div style="font-size: 15px; color: #333; display: flex; flex-direction: column; gap: 10px;">
      <div><strong>Paciente:</strong> Clara Juliana Estrada Peraza</div>
      <div><strong>Tarjetón:</strong> <span class="tarjeton">000123456</span></div>
      <div><strong>Área de Consulta:</strong> Psicología</div>
      <div style="background: #fff; padding: 10px; border-left: 4px solid #129990; border-radius: 6px; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-capsules" style="color: #129990;"></i>
        <div><strong>Receta:</strong> Sertralina 50mg</div>
      </div>
    </div>
  </div>

  <div class="tarjeta-consulta">
    <div class="fecha-etiqueta">24/06/2025</div>
    <div style="font-size: 15px; color: #333; display: flex; flex-direction: column; gap: 10px;">
      <div><strong>Paciente:</strong> Clara Juliana Estrada Peraza</div>
      <div><strong>Tarjetón:</strong> <span class="tarjeton">000123456</span></div>
      <div><strong>Área de Consulta:</strong> Psicología</div>
      <div style="background: #fff; padding: 10px; border-left: 4px solid #129990; border-radius: 6px; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-capsules" style="color: #129990;"></i>
        <div><strong>Receta:</strong> Sertralina 50mg</div>
      </div>
    </div>
  </div>

  <div class="tarjeta-consulta">
    <div class="fecha-etiqueta">24/06/2025</div>
    <div style="font-size: 15px; color: #333; display: flex; flex-direction: column; gap: 10px;">
      <div><strong>Paciente:</strong> Clara Juliana Estrada Peraza</div>
      <div><strong>Tarjetón:</strong> <span class="tarjeton">000123456</span></div>
      <div><strong>Área de Consulta:</strong> Psicología</div>
      <div style="background: #fff; padding: 10px; border-left: 4px solid #129990; border-radius: 6px; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-capsules" style="color: #129990;"></i>
        <div><strong>Receta:</strong> Sertralina 50mg</div>
      </div>
    </div>
  </div>
</div>




<footer>
  Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo. 
  <a href="#">Aviso de privacidad</a>
</footer>

</body>
</html>
