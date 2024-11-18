<?php
class ItensCarrinho {
    private $conn;
    private $table_name = "ItensCarrinho";

    public $id_item;
    public $carrinho_id;
    public $produto_id;
    public $quantidade;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function adicionarItem() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET carrinho_id=:carrinho_id, produto_id=:produto_id, quantidade=:quantidade";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":carrinho_id", $this->carrinho_id);
        $stmt->bindParam(":produto_id", $this->produto_id);
        $stmt->bindParam(":quantidade", $this->quantidade);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function listarItensPorCarrinho($carrinho_id) {
        $query = "SELECT ic.*, p.nome AS produto_nome, p.preco
                  FROM " . $this->table_name . " ic
                  LEFT JOIN Produtos p ON ic.produto_id = p.id_produto
                  WHERE ic.carrinho_id = :carrinho_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":carrinho_id", $carrinho_id);
        $stmt->execute();
        return $stmt;
    }
}
?>
