<?php
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../models/ItensPedido.php';

$database = new Database();
$db = $database->getConnection();
$itensPedido = new ItensPedido($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $itensPedido->pedido_id = $data->pedido_id;
    $itensPedido->produto_id = $data->produto_id;
    $itensPedido->quantidade = $data->quantidade;
    $itensPedido->preco_unitario = $data->preco_unitario;

    if ($itensPedido->adicionarItem()) {
        echo json_encode(["mensagem" => "Item adicionado ao pedido com sucesso!"]);
    } else {
        echo json_encode(["mensagem" => "Erro ao adicionar item ao pedido."]);
    }
}
?>
