<?php
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../models/Pedido.php';

$database = new Database();
$db = $database->getConnection();
$pedido = new Pedido($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $usuario_id = $_GET['usuario_id'] ?? null;

    if ($usuario_id) {
        $stmt = $pedido->listarPorUsuario($usuario_id);
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($pedidos);
    } else {
        echo json_encode(["mensagem" => "Parâmetro 'usuario_id' é obrigatório."]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $pedido->usuario_id = $data->usuario_id;
    $pedido->status = $data->status;

    if ($pedido->criar()) {
        echo json_encode(["mensagem" => "Pedido criado com sucesso!"]);
    } else {
        echo json_encode(["mensagem" => "Erro ao criar pedido."]);
    }
}
?>
