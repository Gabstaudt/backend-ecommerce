<?php
class ItensPedido {
    private $conn;
    private $table_name = "ItensPedido";

    public $id_item_pedido;
    public $pedido_id;
    public $produto_id;
    public $quantidade;
    public $preco_unitario;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function adicionarItem() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET pedido_id=:pedido_id, produto_id=:produto_id, quantidade=:quantidade, preco_unitario=:preco_unitario";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":pedido_id", $this->pedido_id);
        $stmt->bindParam(":produto_id", $this->produto_id);
        $stmt->bindParam(":quantidade", $this->quantidade);
        $stmt->bindParam(":preco_unitario", $this->preco_unitario);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
