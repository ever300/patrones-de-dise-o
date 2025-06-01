<?php
require_once 'ClienteProxy.php';

$cliente = new Cliente($_POST);
$mensaje = $cliente->ejecutar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Banco Proxy PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h2 class="text-center mb-4">🏦 Banco Proxy (Patrón de Diseño)</h2>
            <form method="POST" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Titular:</label>
                    <input type="text" name="titular" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Monto:</label>
                    <input type="number" step="0.01" name="monto" class="form-control">
                </div>
                <div class="col-12 text-center">
                    <button name="accion" value="ver" class="btn btn-info">Ver saldo</button>
                    <button name="accion" value="depositar" class="btn btn-success">Depositar</button>
                    <button name="accion" value="retirar" class="btn btn-danger">Retirar</button>
                </div>
            </form>

            <?php if ($mensaje): ?>
                <?php
                    $clase = 'alert-primary';
                    if (str_starts_with($mensaje, '✅') || str_starts_with($mensaje, '💰')) {
                        $clase = 'alert-success';
                    } elseif (
                        str_starts_with($mensaje, '❌') ||
                        str_starts_with($mensaje, '⛔') ||
                        str_starts_with($mensaje, '⚠️')
                    ) {
                        $clase = 'alert-danger';
                    }
                ?>
                <div class="alert <?= $clase ?> mt-4 text-center">
                    <?= $mensaje ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
