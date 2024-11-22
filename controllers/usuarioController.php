<?php
// Configurar os cabeçalhos para resposta em JSON
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Incluir os arquivos necessários
include_once __DIR__ . '/../config/database.php'; // Caminho correto para o arquivo database.php
include_once __DIR__ . '/../models/usuario.php';  // Caminho correto para o modelo Usuario.php

// Criar instâncias para conexão com o banco e modelo
$database = new Database();
$db = $database->getConnection();
$usuario = new Usuario($db);

// Verificar o método da requisição
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Método GET: Listar todos os usuários
    $stmt = $usuario->listarTodos();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($usuarios)) {
        echo json_encode($usuarios);
    } else {
        http_response_code(404); // Nenhum usuário encontrado
        echo json_encode(["mensagem" => "Nenhum usuário encontrado."]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Método POST: Criar um novo usuário
    $data = json_decode(file_get_contents("php://input"), true);

    // Validar os dados obrigatórios
    if (!empty($data['nome']) && !empty($data['email']) && !empty($data['senha'])) {
        // Preencher os dados do objeto Usuario
        $usuario->nome = $data['nome'];
        $usuario->email = $data['email'];
        $usuario->senha = password_hash($data['senha'], PASSWORD_DEFAULT); // Armazenar senha com hash
        $usuario->telefone = $data['telefone'] ?? null;
        $usuario->endereco = $data['endereco'] ?? null;

        // Tentar criar o usuário no banco de dados
        if ($usuario->criar()) {
            http_response_code(201); // Sucesso: Created
            echo json_encode(["mensagem" => "Usuário criado com sucesso!"]);
        } else {
            http_response_code(500); // Erro no servidor
            echo json_encode(["mensagem" => "Erro ao criar usuário."]);
        }
    } else {
        http_response_code(400); // Requisição inválida
        echo json_encode(["mensagem" => "Dados obrigatórios não fornecidos."]);
    }
} else {
    // Método não permitido
    http_response_code(405); // Method Not Allowed
    echo json_encode(["mensagem" => "Método não permitido."]);
}
?>
