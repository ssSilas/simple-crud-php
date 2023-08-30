<?php
// test conection -> mysql -h 127.0.0.1 -P 9906 -u user -p
$host = '127.0.0.1';
$db = 'simple-crud-db';
$user = 'user';
$password = 'userpwd';
$port = '9906'; 

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db";
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>

