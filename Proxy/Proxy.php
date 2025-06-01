<?php
require_once 'ServiceInterface.php';
require_once 'Service.php';

class Proxy implements ServiceInterface {
    private $realService;

    public function __construct() {
        $this->realService = new Service();     //AQUÍ
    }

    public function verSaldo($titular) {
        if ($this->checkAccess($titular)) {
            echo "🔍 Consultando saldo de $titular...<br>";
            $saldo = $this->realService->verSaldo($titular);
            $this->log("Consultó saldo: $titular");

            return $saldo !== null
                ? "💰 Saldo actual de $titular: Bs " . number_format($saldo, 2)
                : "❌ Cuenta no encontrada.";
        }

        echo "❌ Acceso denegado.<br>";
        return "❌ Acceso denegado.";
    }

    public function depositar($titular, $monto) {
        if (!$this->checkAccess($titular)) {
            echo "❌ Acceso denegado.<br>";
            return "❌ Acceso denegado.";
        }

        if ($monto <= 0) {
            echo "⚠️ Monto inválido: Bs $monto<br>";
            return "⚠️ Monto inválido: Bs $monto";
        }

        echo "💸 Procesando depósito...<br>";
        sleep(1);
        $this->realService->depositar($titular, $monto);
        $this->log("Depósito exitoso: $titular -> Bs $monto");

        $nuevoSaldo = $this->realService->verSaldo($titular);

        return "✅ Se depositaron Bs $monto a la cuenta de $titular.<br>💰 Saldo actual: Bs " . number_format($nuevoSaldo, 2);
    }

    public function retirar($titular, $monto) {
        if (!$this->checkAccess($titular)) {
            echo "❌ Acceso denegado.<br>";
            return "❌ Acceso denegado.";
        }

        if ($monto <= 0) {
            echo "⚠️ Monto inválido: Bs $monto<br>";
            return "⚠️ Monto inválido: Bs $monto";
        }

        $saldoActual = $this->realService->verSaldo($titular);
        if ($saldoActual === null) {
            echo "❌ Cuenta no encontrada.<br>";
            return "❌ Cuenta no encontrada.";
        }

        if ($monto > $saldoActual) {
            echo "⛔ No se puede retirar Bs $monto. Saldo disponible: Bs " . number_format($saldoActual, 2) . "<br>";
            $this->log("Intento fallido de retiro: $titular quiso Bs $monto, saldo Bs $saldoActual");
            return "⛔ No se puede retirar Bs $monto. Saldo disponible: Bs " . number_format($saldoActual, 2);
        }

        echo "🏧 Procesando retiro...<br>";
        sleep(1);
        $this->realService->retirar($titular, $monto);
        $this->log("Retiro exitoso: $titular -> Bs $monto");

        $nuevoSaldo = $this->realService->verSaldo($titular);

        return "✅ Se retiraron Bs $monto de la cuenta de $titular.<br>💰 Saldo actual: Bs " . number_format($nuevoSaldo, 2);
    }

    private function checkAccess($titular) {
        return !empty($titular);
    }

    private function log($mensaje) {
        $timestamp = date("Y-m-d H:i:s");
        file_put_contents("log.txt", "[$timestamp] $mensaje\n", FILE_APPEND);
    }
}
