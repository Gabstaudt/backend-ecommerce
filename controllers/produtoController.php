<?php
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../models/Produto.php';

$database = new Database();
$db = $database->getConnection();
$produto = new Produto($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $produto->listarTodos();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($produtos);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $produto->nome = $data->nome;
    $produto->descricao = $data->descricao;
    $produto->preco = $data->preco;
    $produto->quantidade_estoque = $data->quantidade_estoque;
    $produto->categoria_id = $data->categoria_id;

    if ($produto->criar()) {
        echo json_encode(["mensagem" => "Produto criado com sucesso!"]);
    } else {
        echo json_encode(["mensagem" => "Erro ao criar produto."]);
    }
}
?>
