<?php
$host = 'db'; 
$dbname = 'sistemasae';
$username = 'admin'; 
$password = '1234';  

try {
    // IMPORTANTE: Altere de 'mysql:host=localhost' para 'mysql:host=db'
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
