<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
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
</style>
<body>
    <div style="margin: 15px 0 0 20px;">
  <a href="javascript:history.back()" class="back-button" title="Regresar">
    <i class="fas fa-arrow-left"></i>
    <span class="back-text">Regresar</span>
  </a>
</div>
</body>
</html>