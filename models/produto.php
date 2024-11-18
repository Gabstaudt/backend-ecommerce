<?php
class Produto {
    private $conn;
    private $table_name = "Produtos";

    public $id_produto;
    public $nome;
    public $descricao;
    public $preco;
    public $quantidade_estoque;
    public $categoria_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listarTodos() {
        $query = "SELECT p.*, c.nome AS categoria_nome FROM " . $this->table_name . " p
                  LEFT JOIN Categorias c ON p.categoria_id = c.id_categoria";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET nome=:nome, descricao=:descricao, preco=:preco,
                      quantidade_estoque=:quantidade_estoque, categoria_id=:categoria_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":quantidade_estoque", $this->quantidade_estoque);
        $stmt->bindParam(":categoria_id", $this->categoria_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
