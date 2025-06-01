<?php
class Conexion {
    public static function conectar() {
        $host = 'localhost';
        $dbname = 'banco_proxy';
        $user = 'postgres';
        $pass = '1323';

        try {
            return new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
