<?php
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../models/Categoria.php';

$database = new Database();
$db = $database->getConnection();
$categoria = new Categoria($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $categoria->listarTodas();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($categorias);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $categoria->nome = $data->nome;

    if ($categoria->criar()) {
        echo json_encode(["mensagem" => "Categoria criada com sucesso!"]);
    } else {
        echo json_encode(["mensagem" => "Erro ao criar categoria."]);
    }
}
?>
