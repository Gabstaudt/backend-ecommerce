<?php
// Configurações de cabeçalhos para respostas JSON
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

// Incluir a conexão com o banco e o modelo Usuario
include_once './config/database.php';
include_once './models/usuario.php';

// Criar a instância do banco de dados e do modelo
$database = new Database();
$db = $database->getConnection();
$usuario = new Usuario($db);

// Verificar o método da requisição
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Listar todos os usuários
    $stmt = $usuario->listarTodos();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($usuarios)) {
        echo json_encode($usuarios);
    } else {
        http_response_code(404); // Nenhum usuário encontrado
        echo json_encode(["mensagem" => "Nenhum usuário encontrado."]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Criar um novo usuário
    $data = json_decode(file_get_contents("php://input"), true);

    // Validar dados obrigatórios
    if (!empty($data['nome']) && !empty($data['email']) && !empty($data['senha'])) {
        $usuario->nome = $data['nome'];
        $usuario->email = $data['email'];
        $usuario->senha = password_hash($data['senha'], PASSWORD_DEFAULT); // Hash seguro
        $usuario->telefone = $data['telefone'] ?? null;
        $usuario->endereco = $data['endereco'] ?? null;

        if ($usuario->criar()) {
            http_response_code(201); // Criado com sucesso
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
    http_response_code(405);
    echo json_encode(["mensagem" => "Método não permitido."]);
}
?>
