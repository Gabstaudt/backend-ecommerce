<?php
try {
    $host = "sql10.freesqldatabase.com";
    $dbname = "sql10745247";
    $username = "sql10745247";
    $password = "ixt9KzvwaW";

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "Conexão com o banco de dados bem-sucedida!";
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>
