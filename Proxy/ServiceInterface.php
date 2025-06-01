<?php
interface ServiceInterface {
    public function verSaldo($titular);
    public function depositar($titular, $monto);
    public function retirar($titular, $monto);
}
