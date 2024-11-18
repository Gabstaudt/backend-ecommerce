<?php
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../models/Carrinho.php';

$database = new Database();
$db = $database->getConnection();
$carrinho = new Carrinho($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $carrinho->usuario_id = $data->usuario_id;

    if ($carrinho->criar()) {
        echo json_encode(["mensagem" => "Carrinho criado com sucesso!"]);
    } else {
        echo json_encode(["mensagem" => "Erro ao criar carrinho."]);
    }
}
?>
