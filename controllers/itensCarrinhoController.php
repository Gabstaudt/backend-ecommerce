<?php
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../models/ItensCarrinho.php';

$database = new Database();
$db = $database->getConnection();
$itensCarrinho = new ItensCarrinho($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $itensCarrinho->carrinho_id = $data->carrinho_id;
    $itensCarrinho->produto_id = $data->produto_id;
    $itensCarrinho->quantidade = $data->quantidade;

    if ($itensCarrinho->adicionarItem()) {
        echo json_encode(["mensagem" => "Item adicionado ao carrinho!"]);
    } else {
        echo json_encode(["mensagem" => "Erro ao adicionar item ao carrinho."]);
    }
}
?>
