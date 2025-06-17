<?php
    // conexion.php

    // 1) Define primero tus constantes de configuración (si no las tienes ya en otro archivo):
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'dif');
    define('DB_USER', 'root');
    define('DB_PASS', '');

    // 2) Clase Conexion usando singleton
    class Conexion
    {
        // Aquí se guardará la única instancia de PDO
        private static $instance = null;

        // Constructor privado para evitar instanciación directa
        private function __construct() {}

        // Evita clonación
        private function __clone() {}

        // Evita unserialize
        public function __wakeup() {}

        /**
         * Devuelve la instancia única de PDO.
         * Si aún no existe, la crea con charset UTF-8 y opciones recomendadas.
         *
         * @return PDO
         */
        public static function getPDO(): PDO
        {
            if (self::$instance === null) {
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
                $opts = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    // (opcional) cualquier otra opción que necesites
                ];
                try {
                    self::$instance = new PDO($dsn, DB_USER, DB_PASS, $opts);
                } catch (PDOException $e) {
                    // Si la conexión falla, puedes lanzar excepción o devolver un JSON de error.
                    // Aquí simplemente detenemos el script mostrando el mensaje:
                    die("Error de conexión: " . $e->getMessage());
                }
            }
            return self::$instance;
        }
    }
?>