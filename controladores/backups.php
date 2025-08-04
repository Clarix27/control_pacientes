<?php
// backup.php — Respaldo semanal silencioso con rotación y detección de USB

// 1) Parámetros de conexión
$dbHost = 'localhost';
$dbName = 'dif';
$dbUser = 'root';
$dbPass = '';  // deja vacío si no tienes contraseña

// 2) Rutas candidatas en la USB
$usbPaths = [
    'D:\\backups_mysql',
    'E:\\backups_mysql',
    'F:\\backups_mysql',
    'G:\\backups_mysql',
];
$destino = null;
foreach ($usbPaths as $p) {
    if (is_dir($p) && is_writable($p)) {
        $destino = $p;
        break;
    }
}

// 3) Si no hay USB disponible, usamos carpeta local en C:
if (!$destino) {
    $destino = 'C:\\backups_mysql';
}

// 4) Creamos la carpeta de destino si no existe
if (!is_dir($destino) && !mkdir($destino, 0755, true)) {
    exit(1);
}

// 5) Nombre de archivo con timestamp
$fecha   = date('Ymd_His');
$archivo = $destino . DIRECTORY_SEPARATOR . "backup_{$fecha}.sql";

// 6) Preparamos la parte de la contraseña para mysqldump
if ($dbPass !== '') {
    // Sin espacio entre -p y la contraseña
    $passPart = '-p' . $dbPass;
} else {
    // Sin flag -p si no hay contraseña
    $passPart = '';
}

// 7) Ruta al ejecutable mysqldump (ajusta si tu instalación difiere)
$dumpExe = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';

// 8) Construimos el comando
$cmd = sprintf(
    '"%s" -h%s -u%s %s %s > "%s"',
    $dumpExe,
    escapeshellarg($dbHost),
    escapeshellarg($dbUser),
    $passPart,
    escapeshellarg($dbName),
    $archivo
);

// 9) Ejecutamos el dump
exec($cmd, $_, $status);

// 10) Si falla el dump o no se crea el archivo, salimos con error
if ($status !== 0 || !file_exists($archivo)) {
    exit(1);
}

// 11) Rotación: borramos archivos .sql de más de 7 días
$limite = time() - 7 * 24 * 3600;
foreach (glob($destino . DIRECTORY_SEPARATOR . 'backup_*.sql') as $f) {
    if (@filemtime($f) < $limite) {
        @unlink($f);
    }
}

exit(0);
