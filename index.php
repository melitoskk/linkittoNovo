<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linkitto</title>
    <style>
        body {
            margin: 0;
            font-family: Montserrat, sans-serif;
            background: linear-gradient(45deg, #252b2f, #0e031b);
            display: flex;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
        }

        .header {
            position: absolute;
            top: 38%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: top 0.3s ease;
        }

        .loading {
            position: absolute;
            top: 12%;
            left: 43%;
            transform: translate(-50%, 0);
            z-index: 999;
        }

        .loading img {
            width: 50px;
            height: 50px;
        }

        .rotating-image {
            animation: spin 0.5s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .greetings {
            margin-bottom: 10px;
            text-align: center;
            color: white;
        }

        .greetings img {
            width: 200px;
            height: auto;
            margin-bottom: 10px;
        }

        .greetings h1,
        .greetings p {
            margin: 5px 0;
        }

        label {
            font-size: 14px;
        }

        .textbox-container {
            position: relative;
            width: 80%;
            margin: 0 auto;
        }

        .textbox {
            width: 100%;
            height: 30px;
            padding: 20px;
            padding-right: 40px;
            /* Espaço extra para o ícone */
            font-size: 16px;
            border-radius: 20px;
            box-sizing: border-box;
        }

        .icon {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            font-size: 26px;
            color: gray;
            cursor: pointer;
            user-select: none;
            transition: color 0.3s, opacity 0.3s;
        }

        .icon:hover {
            color: black;
        }

        .icon.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .icon.visible {
            opacity: 1;
            pointer-events: auto;
        }

        .main {
            display: flex;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .content {
            color: white;
            width: 80%;
            margin-top: 100px;
        }

        .status {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            font-weight: 500;
            font-size: 1.2rem;
        }

        .status .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .error .dot {
            background-color: red;
        }

        .error {
            color: red;
        }

        .success .dot {
            background-color: lime;
        }

        .success {
            color: lime;
        }

        .product-card {
            background-color: white;
            color: black;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            padding: 15px;
            width: 100%;
            text-align: left;
            box-sizing: border-box;
        }

        .product-card img {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 0 8px 1px rgba(0, 0, 0, 0.2);
        }

        .product-details {
            margin: 5px 0;
        }

        .product-title {
            font-size: 1.5rem;
            color: black;
        }

        .product-number {
            color: gray;
            font-size: 1.2rem;
        }

        .product-desc {
            color: black;
            font-size: 1rem;
            margin-top: 5px;
        }

        .product-button {
            display: block;
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
            font-weight: bold;
            transition: transform 0.3s ease-in-out;
        }

        .product-button:hover {
            background-color: #0056b3;
        }

        .disclaimer {
            text-align: center;
            font-size: 0.8rem;
            margin-top: 5px;
            color: gray;
            width: 100%;
            box-sizing: border-box;
        }

        .disclaimer a {
            color: #007bff;
            text-decoration: none;
        }

        .disclaimer a:hover {
            text-decoration: underline;
            color: #0056b3;
        }


        @media (min-width: 768px) {
            .header {
                width: 85%;
            }

            .loading {
                position: absolute;
                top: 12%;
                left: 47%;
                transform: translate(-50%, 0);
                z-index: 999;
            }

            .content {
                color: white;
                width: 60%;
                margin-top: 100px;
            }

            .product-card {
                display: flex;
                background-color: white;
                color: black;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                padding: 15px;
                width: 95%;
                text-align: left;
                box-sizing: content-box
            }

            .product-card img {
                width: 50%;
                object-fit: cover;
                border-radius: 8px;
            }

            .product-details {
                width: 50%;
                padding-left: 15px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            .product-title {
                font-size: 2.5rem;
                color: black;
                text-align: left;
                display: flex;
                justify-content: space-between;
                /* Adicionado */
            }

            .product-number {
                color: gray;
                font-size: 2rem;
            }

            .product-desc {
                color: black;
                font-size: 1.6rem;
                text-align: left;
            }

            .button-disclaimer-container {
                display: flex;
                flex-direction: column;
                /* Alinha os elementos um acima do outro */
                align-items: flex-start;
                /* Alinha os elementos à esquerda, caso necessário */
                width: 100%;
            }

            .product-button {
                padding: 20px;
                font-size: 1.8rem;
            }

            .disclaimer {
                font-size: 1.2rem;
                margin: 0;
                /* Remove a margem padrão do disclaimer */
            }

            .disclaimer a {
                color: #007bff;
                text-decoration: none;
            }

            .disclaimer a:hover {
                text-decoration: underline;
                color: #0056b3;
            }
        }

        .hidden {
            display: none;
        }

        .missing {
            color: gray;
            font-style: italic;
        }
    </style>
    <link rel="icon" href="./img/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

</head>

<body>

    <div class="header" id="header">
        <div class="greetings" id="greetings">
            <img src="./img/logo.png" alt="">
            <h1>Boas-Vindas!</h1>
            <label for="textbox">Insira aqui o número do produto que deseja:</label>
        </div>
        <div class="textbox-container">
            <input type="number" id="textbox" class="textbox" placeholder="Insira o número aqui" oninput="toggleIcon()">
            <i id="searchIcon" class="fas fa-search icon visible" style="pointer-events: none;"></i>
            <i id="clearIcon" class="fas fa-times icon hidden" onclick="clearTextbox()"></i>
        </div>
    </div>

    <div class="loading hidden rotating-image" id="loading">
        <img src="./img/loading.png" alt="Carregando..." />
    </div>

    <div class="main" id="main">
        <div class="content" id="content">
            <div class="status error hidden">
                <div class="dot"></div>
                <span>Verifique o número</span>
            </div>

            <div class="status success hidden">
                <div class="dot"></div>
                <span>Produto encontrado!</span>
            </div>

            <div id="product-card" class="product-card hidden">
                <img id="product-image" class="product-image" src="./img/cinza.png" alt="Imagem Produto">
                <div id="product-details" class="product-details">
                    <div style="display: flex; flex-direction: column;">
                        <strong id="product-title" class="product-title"></strong>
                        <span id="product-number" class="product-number"></span>
                    </div>
                    <p id="product-desc" class="product-desc"></p>
                    <div id="button-disclaimer-container" class="button-disclaimer-container">
                        <div id="product-disclaimer" class="product-disclaimer">Você comprará por <a id="shop-link"
                                class="shop-link" href="#" target="_blank"></a></div>
                        <a id="product-button" class="product-button" href="/redirect.php?1234">Ver Produto</a>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script>
        const textbox = document.getElementById('textbox');
        const header = document.getElementById('header');
        const successStatus = document.querySelector('.status.success');
        const errorStatus = document.querySelector('.status.error');
        const greetings = document.getElementById('greetings');
        const loading = document.getElementById('loading');

        let debounceTimeout;

        const productCard = document.getElementById('product-card');
        const productImage = document.getElementById('product-image');
        const productTitle = document.getElementById('product-title');
        const productNumber = document.getElementById('product-number');
        const productDesc = document.getElementById('product-desc');
        const productButton = document.getElementById('product-button');
        const shopLink = document.getElementById('shop-link');

        const imgReserva = './img/cinza.png'

        document.addEventListener('DOMContentLoaded', () => {
            checkUrl();
        });

        function checkUrl() {
            const path = window.location.pathname;
            const id = path.split('/')[1]; // Extrair o número após o primeiro '/'

            if (id) {
                textbox.value = id;
                searchUI();
                textbox.focus(); // Garante que o cabeçalho suba
                toggleIcon();
                fetchProduct(id); // Buscar diretamente o produto       
            } else {
                resetUI(); // Reseta para o estado inicial
            }
        }

        function resetUI() {
            console.log("rodou")
            successStatus.classList.add('hidden');
            errorStatus.classList.add('hidden');
            productCard.classList.add('hidden');
            loading.classList.add('hidden');
            textbox.value = '';
            header.style.top = '38%'; // Retorna o header para o centro
            greetings.classList.remove('hidden'); // Exibe novamente a mensagem inicial

            // Adicionar estado inicial no histórico
            if (window.location.pathname !== '/') {
                history.pushState(null, '', '/');
            }
        }

        function searchUI() {
            header.style.top = '7%';
            greetings.classList.add('hidden');
            setTimeout(() => {
                textbox.scrollIntoView({ behavior: "smooth", block: "center" });
            }, 100); // Aguarda o teclado abrir
        }

        function fetchProduct(id) {
            successStatus.classList.add('hidden');
            errorStatus.classList.add('hidden');
            productCard.classList.add('hidden');
            loading.classList.remove('hidden');
            // Verifica novamente se a textbox está vazia antes de atualizar a UI
            if (textbox.value.trim() === '') {
                resetUI();
                return;
            }

            fetch(`searchproduct.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (textbox.value.trim() === '') {
                        resetUI();
                        return;
                    }
                    if (data.nome_produto) {
                        updateUIWithProduct(data);
                        if (window.location.pathname !== `/${id}`) {
                            history.pushState({ id }, '', `/${id}`);
                        }
                    } else {
                        loading.classList.add('hidden');
                        errorStatus.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar produto:', error);
                    loading.classList.add('hidden');
                });
        }

        function updateUIWithProduct(data) {
            async function changeData() {
                const imageLoaded = new Promise((resolve) => {
                    productImage.onload = resolve; // Resolve quando a imagem carrega
                    productImage.onerror = () => {
                        productImage.src = imgReserva; // Define imagem reserva em caso de erro
                        resolve(); // Ainda assim resolve para continuar o fluxo
                    };
                });

                // Configura a imagem do produto
                productImage.src = data.imagem_produto || imgReserva;
                await imageLoaded; // Aguarda o carregamento da imagem

                // Atualizar texto do produto
                productTitle.textContent = data.nome_produto;
                productNumber.textContent = `N°${data.id_produto}`;

                // Atualizar descrição do produto
                if (data.descricao) {
                    productDesc.textContent = data.descricao;
                    productDesc.classList.remove("missing");
                } else {
                    productDesc.textContent = "Sem descrição ainda";
                    productDesc.classList.add("missing");
                }

                // Atualizar links
                shopLink.innerText = data.loja_nome;
                shopLink.href = data.loja_link;
                productButton.href = `/redirect.php?produto=${data.id_produto}`;
            }

            changeData().then(() => {
                // Exibir card e atualizar UI após carregar a imagem e os dados
                searchUI();
                loading.classList.add('hidden');
                successStatus.classList.remove('hidden');
                productCard.classList.remove('hidden');
            });
        }


        textbox.addEventListener('input', () => {
            toggleIcon();
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                const text = textbox.value.trim();
                if (text) fetchProduct(text);
            }, 500);
            if (textbox.value.trim() === '') {
                resetUI();
            } else {
                searchUI();
            }
        });

        window.addEventListener('popstate', function (event) {
            if (event.state && event.state.id) {
                fetchProduct(event.state.id); // Busca o produto do histórico
            } else {
                resetUI(); // Reseta para a página inicial
            }
        });

        function toggleIcon() {
            const textbox = document.getElementById('textbox');
            const searchIcon = document.getElementById('searchIcon');
            const clearIcon = document.getElementById('clearIcon');

            if (textbox.value.trim() === '') {
                searchIcon.classList.remove('hidden');
                searchIcon.classList.add('visible');

                clearIcon.classList.remove('visible');
                clearIcon.classList.add('hidden');
            } else {
                searchIcon.classList.remove('visible');
                searchIcon.classList.add('hidden');

                clearIcon.classList.remove('hidden');
                clearIcon.classList.add('visible');
            }
        }

        function clearTextbox() {
            const textbox = document.getElementById('textbox');
            textbox.value = '';
            toggleIcon(); // Atualiza os ícones
            resetUI();
            textbox.focus();
        }

    </script>



</body>

</html>