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
<?php include "header.php" ?>
<?php
    //Verifica se o método de envio do formUsuario é POST
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //Cria variáveis para armazenar as informações passadas pelo $_POST[]
        $nomeUsuario = $emailUsuario = $senhaUsuario = $confirmarSenhaUsuario = "";

        //Variável booleana para controle de erros de preenchimento
        $erroPreenchimento = false;

        //Validação do campo nomeUsuario
        //Utiliza a função empty() para verificar se o $_POST["nomeUsuario"] está vazio
        if(empty($_POST["nomeUsuario"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            $nomeUsuario = filtrar_entrada($_POST["nomeUsuario"]);

            //Utiliza a função preg_match() para verificar se há apenas letras no nomeUsuario
            if(!preg_match('/^[\p{L} ]+$/u', $nomeUsuario)){
                echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> deve conter apenas letras!</div>";
                $erroPreenchimento = true;
            }
        }


        //Validação do campo emailUsuario
        //Utiliza a função empty() para verificar se o $_POST["emailUsuario"] está vazio
        if(empty($_POST["emailUsuario"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>EMAIL</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            $emailUsuario = filtrar_entrada($_POST["emailUsuario"]);
        }

        //Validação do campo senhaUsuario
        //Utiliza a função empty() para verificar se o $_POST["senhaUsuario"] está vazio
        if(empty($_POST["senhaUsuario"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>SENHA</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            //Usa a função md5() para criptografar a $senhaUsuario 
            $senhaUsuario = (filtrar_entrada($_POST["senhaUsuario"]));
        }

        //Validação do campo confirmarSenhaUsuario
        //Utiliza a função empty() para verificar se o $_POST["confirmarSenhaUsuario"] está vazio
        if(empty($_POST["confirmarSenhaUsuario"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>CONFIRMAR SENHA</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            $confirmarSenhaUsuario = (filtrar_entrada($_POST["confirmarSenhaUsuario"]));

            //Verifica se a $senhaUsuario e $confirmarSenha usuário são diferentes
            if($senhaUsuario != $confirmarSenhaUsuario){
                echo "<div class='alert alert-warning text-center'>As <strong>SENHAS</strong> informadas são diferentes!</div>";
                $erroPreenchimento = true;
            }
        }

        if(!$erroPreenchimento && !$erroUpload){
            //Cria uma variável para armazenar a QUERY que realiza a inserção de dados do Usuário na tabela Usuarios
            $inserirUsuario = "INSERT INTO Usuarios (nomeUsuario, emailUsuario, senhaUsuario, confirmarSenhaUsuario)
                                            VALUES ('$nomeUsuario', '$emailUsuario', '$senhaUsuario', '$confirmarSenhaUsuario')";

            //Inclui o arquivo de conexão com o Banco de Dados
            include "conexaoBD.php";

            
            //A função mysqli_connect() executa a QUERY no BD
            //Se conseguir executar a QUERY, exibe alerta de sucesso e a tabela com os dados cadastradosif(mysqli_query($conn, $inserirUsuario)){


            if(mysqli_query($conn, $inserirUsuario)){
                echo"
                <div id='layoutAuthentication'>
                <div id='layoutAuthentication_content'>
                    <main>
                        <div class='container'>
                            <div class='row justify-content-center'>
                                <div class='col-lg-5'>
                                    <div class='card shadow-lg border-0 rounded-lg mt-5'>
                                        <div class='card-header'><h3 class='text-center font-weight-light my-4'>Cadastro realizado com sucesso!</h3></div>
                                        <div class='card-body'>
                                            <form action='formLogin.php' method='POST'>
                                                <div class='d-flex align-items-center justify-content-between mt-4 mb-0'>
                                                    <button type='submit' class='btn btn-primary w-100' href='formLogin.php'>
                                                        Fazer Login
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
                ";
                }
            else{
                echo "
                <div id='layoutAuthentication'>
                <div id='layoutAuthentication_content'>
                    <main>
                        <div class='container'>
                            <div class='row justify-content-center'>
                                <div class='col-lg-5'>
                                    <div class='card shadow-lg border-0 rounded-lg mt-5'>
                                        <div class='card-header'><h3 class='text-center font-weight-light my-4'>Cadastro realizado com sucesso!</h3></div>
                                        <div class='card-body'>
                                            <form action='formLogin.php' method='POST'>
                                                <div class='d-flex align-items-center justify-content-between mt-4 mb-0'>
                                                    <button type='submit' class='btn btn-primary w-100' href='formUsuario.php'>
                                                        Tentar Novamente
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>";
            }
            }
    
        else{
            //Usa a função header() para redirecionar o usuário para o formUsuario.php
            echo "
                <div id='layoutAuthentication'>
                <div id='layoutAuthentication_content'>
                    <main>
                        <div class='container'>
                            <div class='row justify-content-center'>
                                <div class='col-lg-5'>
                                    <div class='card shadow-lg border-0 rounded-lg mt-5'>
                                        <div class='card-header'><h3 class='text-center font-weight-light my-4'>Não Foi Possível Realizar o Cadastro</h3></div>
                                        <div class='card-body'>
                                            <form action='formLogin.php' method='POST'>
                                                <div class='d-flex align-items-center justify-content-between mt-4 mb-0'>
                                                    <button type='submit' class='btn btn-primary w-100' href='formUsuario.php'>
                                                        Tentar Novamente
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>";
        }
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
</body>
</html>
