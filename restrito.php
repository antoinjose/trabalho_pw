<?php
session_start();
if (!isset($_SESSION['usuario_email']) && !isset($_SESSION['usuario_senha'])) {
    header('Location: index.php');
    exit();
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial SAE</title>
</head>
<body>
    <h1>Acesso Restrito</h1>
</body>
</html>