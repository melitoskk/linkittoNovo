<?php
include 'db_config.php';

$response = [];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"));
        $productId = isset($data->id_produto) ? filter_var($data->id_produto, FILTER_SANITIZE_NUMBER_INT) : null;
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $productId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    } else {
        $productId = null;
    }

    if (!$productId) {
        throw new Exception('ID do produto inválido.');
    }

    // Consulta SQL com LEFT JOIN
    $sql = "
        SELECT 
            p.*, 
            l.nome AS loja_nome, 
            l.link AS loja_link, 
            l.imagem AS loja_imagem
        FROM 
            produtos p
        LEFT JOIN 
            lojas l 
        ON 
            p.loja_produto_id = l.id
        WHERE 
            p.id_produto = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception('Erro na preparação da consulta: ' . $conn->error);
    }

    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response = $result->fetch_assoc();
    } else {
        $response['error'] = 'Produto não encontrado ou sem loja associada.';
    }

    $stmt->close();
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
} finally {
    $conn->close();
}

// Retornar JSON
echo json_encode($response);
?>
