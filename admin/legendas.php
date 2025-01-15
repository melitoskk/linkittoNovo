<?php
include '../db_config.php';

// Obtendo o ID diretamente da URL usando filter_input
$id_produto = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Verificando se o ID é válido
if ($id_produto === false) {
    $id_produto = 0; // Definir como 0 caso o ID não seja válido
}

// Consultar produto no banco de dados
$sql = "SELECT nome_produto, id_produto, descricao FROM produtos WHERE id_produto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_produto);
$stmt->execute();
$stmt->bind_result($nome_produto, $id_produto, $descricao);
$stmt->fetch();
$stmt->close();

// Consultar templates no banco de dados
$sql_templates = "SELECT plataforma, template FROM legendas_templates";
$result_templates = $conn->query($sql_templates);

$templates = [];
while ($row = $result_templates->fetch_assoc()) {
    $templates[$row['plataforma']] = $row['template'];
}

// Substituir placeholders no template
function preencherTemplate($template, $dados) {
    foreach ($dados as $chave => $valor) {
        $template = str_replace("{" . $chave . "}", $valor, $template);
    }
    return $template;
}

// Preencher dados do produto
$dados_produto = [
    'nome_produto' => $nome_produto,
    'id_produto' => $id_produto,
    'descricao_produto' => $descricao
];

// Gerar textos para cada plataforma
$textoInsta = isset($templates['Instagram']) ? preencherTemplate($templates['Instagram'], $dados_produto) : '';
$textoTiktok = isset($templates['TikTok']) ? preencherTemplate($templates['TikTok'], $dados_produto) : '';
$textoYoutube = isset($templates['YouTube']) ? preencherTemplate($templates['YouTube'], $dados_produto) : '';

$emojis = [
    '/\[' . preg_quote('sparkles', '/') . '\]/' => '✨',
    '/\[' . preg_quote('link', '/') . '\]/' => '🔗',
    '/\[' . preg_quote('notes', '/') . '\]/' => '📋',
];

// Usando preg_replace com delimitadores válidos
$textoInsta = preg_replace(array_keys($emojis), array_values($emojis), $textoInsta);
$textoTiktok = preg_replace(array_keys($emojis), array_values($emojis), $textoTiktok);
$textoYoutube = preg_replace(array_keys($emojis), array_values($emojis), $textoYoutube);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legendas para Redes Sociais</title>
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
    <h1>Legendas para o Produto ID: <?php echo htmlspecialchars($id_produto); ?></h1>
    
    <p>Insta</p>
    <div class="textbox-container">
        <textarea id="textoInsta" rows="4" cols="50" readonly><?php echo htmlspecialchars($textoInsta); ?></textarea>
        <button class="copy-button" onclick="copyToClipboard('textoInsta')">Copiar</button>
    </div>
    
    <p>TikTok</p>
    <div class="textbox-container">
        <textarea id="textoTiktok" rows="4" cols="50" readonly><?php echo htmlspecialchars($textoTiktok); ?></textarea>
        <button class="copy-button" onclick="copyToClipboard('textoTiktok')">Copiar</button>
    </div>
    
    <p>YouTube</p>
    <div class="textbox-container">
        <textarea id="textoYoutube" rows="4" cols="50" readonly><?php echo htmlspecialchars($textoYoutube); ?></textarea>
        <button class="copy-button" onclick="copyToClipboard('textoYoutube')">Copiar</button>
    </div>

    <script>
        function copyToClipboard(id) {
            var textArea = document.getElementById(id);
            textArea.select();
            document.execCommand('copy');
            alert('Texto copiado para a área de transferência!');
        }
    </script>

<?php else: ?>
    <p>Produto não encontrado. Por favor, verifique o número do produto e tente novamente.</p>
<?php endif; ?>

</body>
</html>
