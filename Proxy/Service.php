<?php
require_once 'ServiceInterface.php';
require_once 'Conexion.php';

class Service implements ServiceInterface {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }
    
    public function verSaldo($titular) {
        $stmt = $this->db->prepare("SELECT saldo FROM cuentas WHERE titular = :titular");
        $stmt->execute(['titular' => $titular]);
        $row = $stmt->fetch();
        return $row ? $row['saldo'] : null;
    }

    public function depositar($titular, $monto) {
        $stmt = $this->db->prepare("UPDATE cuentas SET saldo = saldo + :monto WHERE titular = :titular");
        $stmt->execute(['monto' => $monto, 'titular' => $titular]);
    }

    public function retirar($titular, $monto) {
        $stmt = $this->db->prepare("SELECT saldo FROM cuentas WHERE titular = :titular");
        $stmt->execute(['titular' => $titular]);
        $row = $stmt->fetch();

        if (!$row || $row['saldo'] < $monto) {
            return; // No se realiza la operación si no hay suficiente saldo
        }

        $stmt = $this->db->prepare("UPDATE cuentas SET saldo = saldo - :monto WHERE titular = :titular");
        $stmt->execute(['monto' => $monto, 'titular' => $titular]);
    }
}

