<?php
class Usuario {
    private $conn;
    private $table_name = "Usuarios";

    public $id_usuario;
    public $nome;
    public $email;
    public $senha;
    public $telefone;
    public $endereco;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para criar um novo usuário
    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " (nome, email, senha, telefone, endereco)
                  VALUES (:nome, :email, :senha, :telefone, :endereco)";

        $stmt = $this->conn->prepare($query);

        // Vincular os valores
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':senha', $this->senha);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':endereco', $this->endereco);

        // Tentar executar a query
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Método para listar todos os usuários
    public function listarTodos() {
        $query = "SELECT id_usuario, nome, email, telefone, endereco FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
?>
