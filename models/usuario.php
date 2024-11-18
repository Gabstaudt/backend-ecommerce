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

    public function listarTodos() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " SET nome=:nome, email=:email, senha=:senha, telefone=:telefone, endereco=:endereco";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":senha", $this->senha);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":endereco", $this->endereco);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
