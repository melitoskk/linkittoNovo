<?php
include './db_config.php';

// Obtendo o ID do produto
$id_produto = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id_produto) {
    // Incrementar o valor de 'searchs'
    $sql = "UPDATE produtos SET searchs = searchs + 1 WHERE id_produto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_produto);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'ID inválido']);
}

$conn->close();
?>
