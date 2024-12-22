<?php
include '../db_config.php';

// Obtendo o ID diretamente da URL usando filter_input
$id_produto = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

echo "ID do produto: $id_produto\n"; // Exibe o ID

// Verificando se o ID é válido
if ($id_produto === false) {
    $id_produto = 0; // Definir como 0 caso o ID não seja válido
}

// Consultar no banco
$sql = "SELECT textoInsta, textoTiktok, textoYoutube FROM legendas WHERE produto_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_produto);
$stmt->execute();
$stmt->bind_result($textoInsta, $textoTiktok, $textoYoutube);
$stmt->fetch();
$stmt->close();

// Array associativo para substituições de [emojis] por emojis reais
$emojis = [
    '/\[' . preg_quote('sparkles', '/') . '\]/' => '✨',
    '/\[' . preg_quote('link', '/') . '\]/' => '🔗',
    '/\[' . preg_quote('notes', '/') . '\]/' => '📋',
];

// Usando preg_replace com delimitadores válidos
$textoInsta = preg_replace(array_keys($emojis), array_values($emojis), $textoInsta);
$textoTiktok = preg_replace(array_keys($emojis), array_values($emojis), $textoTiktok);
$textoYoutube = preg_replace(array_keys($emojis), array_values($emojis), $textoYoutube);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legendas do Produto</title>
    <style>
        .textbox-container {
            margin-bottom: 15px;
        }
        .copy-button {
            cursor: pointer;
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<?php if ($id_produto > 0): ?>
    <h1>Legendas para o Produto ID: <?php echo $id_produto; ?></h1>
    
    <div class="textbox-container">
        <textarea id="textoInsta" rows="4" cols="50" readonly><?php echo htmlspecialchars($textoInsta); ?></textarea>
        <button class="copy-button" onclick="copyToClipboard('textoInsta')">Copiar</button>
    </div>
    
    <div class="textbox-container">
        <textarea id="textoTiktok" rows="4" cols="50" readonly><?php echo htmlspecialchars($textoTiktok); ?></textarea>
        <button class="copy-button" onclick="copyToClipboard('textoTiktok')">Copiar</button>
    </div>
    
    <div class="textbox-container">
        <textarea id="textoYoutube" rows="4" cols="50" readonly><?php echo htmlspecialchars($textoYoutube); ?></textarea>
        <button class="copy-button" onclick="copyToClipboard('textoYoutube')">Copiar</button>
    </div>

<?php else: ?>
    <p>Produto não encontrado.</p>
<?php endif; ?>

<script>
    function copyToClipboard(id) {
        var textArea = document.getElementById(id);
        textArea.select();
        document.execCommand('copy');
        alert('Texto copiado para a área de transferência!');
    }
</script>

</body>
</html>

<?php $conn->close(); ?>
