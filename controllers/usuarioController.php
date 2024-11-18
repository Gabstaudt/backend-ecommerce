<?php
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../models/Usuario.php';

$database = new Database();
$db = $database->getConnection();
$usuario = new Usuario($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $usuario->listarTodos();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($usuarios);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $usuario->nome = $data->nome;
    $usuario->email = $data->email;
    $usuario->senha = $data->senha;
    $usuario->telefone = $data->telefone;
    $usuario->endereco = $data->endereco;

    if ($usuario->criar()) {
        echo json_encode(["mensagem" => "Usuário criado com sucesso!"]);
    } else {
        echo json_encode(["mensagem" => "Erro ao criar usuário."]);
    }
}
?>
