<?php include "header.php" ?>

<?php
    //Verifica se o método de envio do formAnuncio é POST
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //Cria variáveis para armazenar as informações passadas pelo $_POST[]
        $nomeProduto = $estoqueProduto = $categoriaAnuncio = $valorCustoAnuncio = $valorAnuncio = "";

        //Variável booleana para controle de erros de preenchimento
        $erroPreenchimento = false;


        //Validação do campo nomeProduto
        //Utiliza a função empty() para verificar se o $_POST["nomeProduto"] está vazio
        if(empty($_POST["nomeProduto"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>TÍTULO DO ANÚNCIO</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            $nomeProduto = filtrar_entrada($_POST["nomeProduto"]);
        }

        //Validação do campo estoqueProduto
        //Utiliza a função empty() para verificar se o $_POST["estoqueProduto"] está vazio
        if(empty($_POST["estoqueProduto"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>ESTOQUE DO PRODUTO</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            $estoqueProduto = filtrar_entrada($_POST["estoqueProduto"]);
        }

        //Validação do campo categoriaAnuncio
        //Utiliza a função empty() para verificar se o $_POST["categoriaAnuncio"] está vazio
        if(empty($_POST["categoriaAnuncio"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>CATEGORIA</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            $categoriaAnuncio = filtrar_entrada($_POST["categoriaAnuncio"]);
        }

         //Validação do campo valorCustoAnuncio
        //Utiliza a função empty() para verificar se o $_POST["valorCustoAnuncio"] está vazio
        if(empty($_POST["valorCustoAnuncio"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>VALOR DE CUSTO DO PRODUTO</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            $valorCustoAnuncio = filtrar_entrada($_POST["valorCustoAnuncio"]);
        }
        //Validação do campo valorAnuncio
        //Utiliza a função empty() para verificar se o $_POST["valorAnuncio"] está vazio
        if(empty($_POST["valorAnuncio"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>VALOR DO ANÚNCIO</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            $valorAnuncio = filtrar_entrada($_POST["valorAnuncio"]);
        }

        //Verifica se não há erros de preenchimento ou erros de upload da foto
        if(!$erroPreenchimento && !$erroUpload){

            //Cria uma variável para armazenar a QUERY que realiza a inserção de dados do Usuário na tabela Anuncios
            $inserirAnuncio = "INSERT INTO Anuncios (Usuarios_idUsuario, nomeProduto, estoqueProduto, categoriaAnuncio, valorAnuncio, valorCustoAnuncio)
                            VALUES ($idUsuario, '$nomeProduto', '$estoqueProduto', '$categoriaAnuncio', '$valorCustoAnuncio', '$valorAnuncio')";

            //Inclui o arquivo de conexão com o Banco de Dados
            include "conexaoBD.php";

            //A função mysqli_connect() executa a QUERY no BD
            //Se conseguir executar a QUERY, exibe alerta de sucesso e a tabela com os dados cadastrados
            if(mysqli_query($conn, $inserirAnuncio)){

            }
            else{
                echo "<div class='alert alert-danger text-center'>Erro ao tentar cadastrar <strong>USUÁRIO</strong> no banco de dados $database!</div>";
            }
        }


    }
    else{
        //Usa a função header() para redirecionar o usuário para o formAnuncio.php
        header("location:formAnuncio.php");
    }

    //Função para filtrar entrada de dados
    function filtrar_entrada($dado){
        $dado = trim($dado); //Remove espaços desnecessários
        $dado = stripslashes($dado); //Remove barras invertidas
        $dado = htmlspecialchars($dado); //Converte caracteres especiais em entidades HTML

        //Após filtrado, o dado é retornado
        return($dado);
    }
?>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - MeuSaldo</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-primary">
    
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Produto Cadastrado com sucesso!</h3></div>
                                    <div class="card-body">
                                        <form action="listaProdutos.php" method="POST">
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary w-100" href="formLogin.php">
                                                    Ver Produtos
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
</body>
</html>