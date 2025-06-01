<?php
require_once 'Proxy.php';

class Cliente {
    private $proxy;
    private $titular;
    private $monto;
    private $accion;

    public function __construct($request) {
        $this->proxy = new Proxy();
        $this->titular = trim($request['titular'] ?? '');
        $this->monto = floatval($request['monto'] ?? 0);
        $this->accion = $request['accion'] ?? null;
    }

    public function ejecutar() {
        if (empty($this->titular)) return "";

        switch ($this->accion) {
            case 'ver':
                return $this->proxy->verSaldo($this->titular);
            case 'depositar':
                return $this->proxy->depositar($this->titular, $this->monto);
            case 'retirar':
                return $this->proxy->retirar($this->titular, $this->monto);
            default:
                return "";
        }
    }
}
