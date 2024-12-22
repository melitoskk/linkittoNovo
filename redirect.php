<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecionamento com Barra de Progresso</title>
    <style>
        body {
            margin: 0;
            font-family: Montserrat, sans-serif;
            background: linear-gradient(45deg, #252b2f, #0e031b);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100vh;
        }

        .loading {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            margin: 25px;
        }

        .loading img {
            width: 150px;
            height: 150px;
            transform-origin: center;
        }

        .rotating-image {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .progress-bar-container {
            border-radius: 10px;
            width: 80%;
            background-color: rgb(143, 143, 143);
            height: 10px;
            margin-top: 20px;
        }

        .progress-bar {
            border-radius: 10px;
            width: 0;
            height: 100%;
            background-color: rgb(216, 216, 216);
            transition: width 2s ease-in-out;
            /* Ajuste da duração da transição */
        }

        .main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 80%;
            height: calc(100vh - 90px);
            color: white;
            margin-left: auto;
            margin-right: auto;
        }

        .footer {
            text-align: center;
            color: white;
            width: 100%;
            margin-top: 20px;
        }

        #thx {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    <script>
        function completeRedirect() {
            const progressBar = document.getElementById('progress-bar');
            let currentWidth = 0;

            function incrementProgress() {
                if (currentWidth < 100) {
                    currentWidth += 10;
                    updateProgress(currentWidth);
                    setTimeout(incrementProgress, 200); // Incrementa progress com intervalos curtos
                } else {
                    setTimeout(() => {
                        window.location.href = progressBar.dataset.url;
                    }, 1000); // Aguarde 1 segundo após o progresso atingir 100%
                }
            }

            incrementProgress();
        }

        function updateProgress(percent) {
            const progressBar = document.getElementById('progress-bar');
            progressBar.style.width = percent + '%';
        }
    </script>

</head>

<body>

    <div class="main">
        <h1>Ótima escolha!</h1>
        <div class="loading rotating-image">
            <img src="./img/loading.png" alt="Carregando..." />
        </div>
        <div class="progress-bar-container">
            <div id="progress-bar" class="progress-bar" data-url=""></div>
        </div>
        <h2>Aguenta aí</h2>
        <p>Estamos redirecionando você para a página do produto...</p>
        <p id='thx'>Muito obrigado!</p>
    </div>

    <?php
    include 'db_config.php';

    if (isset($_GET['produto']) && !empty($_GET['produto'])) {
        $id_produto = intval($_GET['produto']);

        echo "<script>updateProgress(0);</script>";

        $sql = "SELECT link_produto, clicks FROM produtos WHERE id_produto = $id_produto";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $link_produto = $row['link_produto'];
            $clicks = $row['clicks'];

            // Incrementar o valor de clicks
            $clicks++;

            // Atualizar o número de clicks no banco de dados
            $updateSql = "UPDATE produtos SET clicks = $clicks WHERE id_produto = $id_produto";
            $conn->query($updateSql);

            echo "<script>updateProgress(100);</script>";

            // Passa o link_produto para a variável data-url do progresso
            echo "<script>document.getElementById('progress-bar').dataset.url = '$link_produto';</script>";

            // Agora chama a função para redirecionamento após o progresso atingir 100%
            echo "<script>completeRedirect();</script>"; // Chamada da função definida
        } else {
            echo "<script>updateProgress(0);</script>";
            echo "<p>Produto não encontrado.</p>";
        }

        $conn->close();
    } else {
        echo "<script>updateProgress(0);</script>";
        echo "<p>ID do produto não fornecido ou inválido.</p>";
    }
    ?>

</body>

</html>