<?php
include '../db_config.php';

session_start();

// Verificar se o usuário está logado, se não estiver, redireciona para o login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redireciona para a página de login
    exit();
}

// Função para verificar se a loja já existe
function verificarLojaExistente($conn, $nome_loja)
{
    $sql = "SELECT id FROM lojas WHERE nome = '$nome_loja'";
    return $conn->query($sql)->num_rows > 0;
}

// Função para criar loja
function criarLoja($conn, $nome_loja, $imagem_loja, $link_loja)
{
    $sql = "INSERT INTO lojas (nome, link, imagem) VALUES ('$nome_loja', '$link_loja', '$imagem_loja')";
    return $conn->query($sql);
}

// Função para criar produto
function criarProduto($conn, $categoria_id_produto, $nome_produto, $id_produto, $link_produto, $imagem_produto, $descricao_produto, $loja_produto_id)
{
    $sql = "INSERT INTO produtos (categoria_id, nome_produto, id_produto, link_produto, imagem_produto, descricao, loja_produto_id) 
            VALUES ('$categoria_id_produto', '$nome_produto', '$id_produto', '$link_produto', '$imagem_produto', '$descricao_produto', '$loja_produto_id')";
    return $conn->query($sql);
}

// Função para verificar se o produto existe
function verificarProdutoExistente($conn, $id_produto)
{
    $sql = "SELECT id FROM produtos WHERE id_produto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_produto);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

// Conexão com o banco de dados
$servername = $env_ip;
$username = $env_user;
$password = $env_password;
$dbname = $env_db; // Nome do banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem = $_FILES['imagem'];

        // Diretório onde as imagens serão armazenadas
        $diretorio_upload = 'uploads/';

        // Verificar se o diretório existe
        if (!is_dir($diretorio_upload)) {
            mkdir($diretorio_upload, 0777, true); // Cria a pasta se não existir
        }

        // Obter a extensão do arquivo
        $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);

        // Gerar um nome único para o arquivo
        $nome_imagem = uniqid('img_', true) . '.' . $extensao;

        // Caminho completo para o arquivo
        $caminho_imagem = $diretorio_upload . $nome_imagem;

        // Mover o arquivo para o diretório de uploads
        if (move_uploaded_file($imagem['tmp_name'], $caminho_imagem)) {
            // Gerar a URL para a imagem
            $url_imagem = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $caminho_imagem;

            // Exibir a URL para o usuário copiar
            $exibir_url = "<input type='text' value='" . $url_imagem . "' readonly>";
        } else {
            $exibir_url = "Erro ao fazer upload da imagem. Tente novamente.";
        }
    } else {
        $exibir_url = "Por favor, selecione uma imagem para fazer o upload.";
    }

    // Criar Produto
    if (isset($_POST['criar_produto']) && !empty($_POST['categoria_produto_id']) && !empty($_POST['id_produto']) && !empty($_POST['loja_produto_id'])) {
        $categoria_id_produto = $_POST['categoria_produto_id'];
        $nome_produto = $_POST['nome_produto'];
        $id_produto = $_POST['id_produto'];
        $link_produto = $_POST['link_produto'];
        $imagem_produto = $_POST['imagem_produto'];
        $loja_produto_id = $_POST['loja_produto_id'];
        $descricao_produto = $_POST['descricao_produto']; // Novo campo de descrição

        if (verificarProdutoExistente($conn, $id_produto)) {
            echo "Produto já existe!";
        } else {
            if (criarProduto($conn, $categoria_id_produto, $nome_produto, $id_produto, $link_produto, $imagem_produto, $descricao_produto, $loja_produto_id)) {
                echo "Produto criado com sucesso!";
            } else {
                echo "Erro ao criar produto: " . $conn->error;
            }
        }
    }

}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Resetando margens e padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Estilos gerais para a página */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            height: 100vh;
            /* Define a altura da página para preencher a tela */
            display: flex;
            flex-direction: column;
            /* Centraliza os elementos verticalmente */
            justify-content: flex-start;
            padding: 20px;
            margin: 0;
            /* Remove qualquer margem externa */
        }

        /* Container principal para os formulários */
        .container {
            display: flex;
            flex-direction: column;
            /* Formulários em coluna em telas menores */
            align-items: center;
            /* Centraliza os formulários */
            gap: 20px;
            /* Espaçamento entre os formulários */
            max-width: 600px;
            /* Limita a largura total para telas pequenas */
            width: 100%;
        }

        /* Estilos para os formulários */
        form {
            background-color: #c2c2c2;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            box-sizing: border-box;
            /* Garante que o padding não afete o tamanho total */
        }

        /* Títulos dos formulários */
        h2 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #000000;
        }

        /* Labels e campos de entrada */
        label {
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
            color: #555;
        }

        input[type="text"],
        input[type="url"],
        select {
            width: calc(100% - 20px);
            /* Ajusta o campo para ocupar quase toda a largura */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="text"]:focus,
        input[type="url"]:focus,
        select:focus {
            border-color: #0056b3;
            outline: none;
        }

        /* Botão */
        button {
            background-color: #0056b3;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #004085;
        }

        /* Responsividade para telas menores */
        @media (max-width: 768px) {
            .container {
                align-items: center;
                /* Garante que os formulários fiquem centralizados */
            }

            form {
                width: 100%;
                /* Cada formulário ocupará 100% da largura em telas pequenas */
            }
        }
    </style>
     <script>
        function gerarIdUnico() {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "gerar_id.php", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById("id_produto").value = xhr.responseText;
                } else {
                    alert("Erro ao gerar ID. Tente novamente.");
                }
            };
            xhr.send();
        }
    </script>
</head>

<body>

    <hr>

    <!-- Formulário para Criar Produto -->

    <div class="upload-container">
        <form method="POST" enctype="multipart/form-data">
            <div class="imagem-url">
                <?php
                if (isset($exibir_url)) {
                    echo $exibir_url;
                }
                ?>
            </div>
            <h2>Upload de Imagem</h2>
            <label for="imagem">Escolha ou arraste a imagem para o upload:</label>
            <input type="file" name="imagem" id="imagem" required><br><br>

            <button type="submit" name="upload_imagem">Enviar Imagem</button>
        </form>
    </div>

    <hr>

    <form method="POST">
        <h2>Criar Produto</h2>
        <label for="categoria_produto_id">Categoria:</label>
        <select id="categoria_produto_id" name="categoria_produto_id" required>
            <option value="">Selecione uma categoria</option>
            <?php
            // Exibir categorias
            $resultCategorias = $conn->query("SELECT id, nome FROM categorias");
            while ($row = $resultCategorias->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
            }
            ?>
        </select><br><br>

        <label for="nome_produto">Nome do Produto:</label>
        <input type="text" id="nome_produto" name="nome_produto" required><br><br>

        <label for="id_produto">ID do Produto:</label>
        <div style="display: flex; gap: 10px;">
            <input type="text" id="id_produto" name="id_produto" required readonly>
            <button type="button" onclick="gerarIdUnico()">Gerar</button>
        </div><br><br>

        <label for="imagem_produto">Imagem do Produto:</label>
        <input type="url" id="imagem_produto" name="imagem_produto" required><br><br>

        <label for="link_produto">Link do Produto:</label>
        <input type="url" id="link_produto" name="link_produto" required><br><br>

        <label for="descricao_produto">Descrição do Produto:</label>
        <textarea id="descricao_produto" name="descricao_produto" rows="4" required></textarea><br><br>


        <!-- Dropdown para selecionar a loja -->
        <label for="loja_produto_id">Loja:</label>
        <select id="loja_produto_id" name="loja_produto_id" required>
            <option value="">Selecione uma loja</option>
            <?php
            // Exibir lojas na dropdown
            $resultLojas = $conn->query("SELECT id, nome FROM lojas");
            while ($row = $resultLojas->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
            }
            ?>
        </select><br><br>

        <button type="submit" name="criar_produto">Criar Produto</button>
    </form>

</body>

</html>