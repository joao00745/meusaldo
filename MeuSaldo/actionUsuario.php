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
            $senhaUsuario = md5(filtrar_entrada($_POST["senhaUsuario"]));
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
            $confirmarSenhaUsuario = md5(filtrar_entrada($_POST["confirmarSenhaUsuario"]));

            //Verifica se a $senhaUsuario e $confirmarSenha usuário são diferentes
            if($senhaUsuario != $confirmarSenhaUsuario){
                echo "<div class='alert alert-warning text-center'>As <strong>SENHAS</strong> informadas são diferentes!</div>";
                $erroPreenchimento = true;
            }
        }


            //Cria uma variável para armazenar a QUERY que realiza a inserção de dados do Usuário na tabela Usuarios
            $inserirUsuario = "INSERT INTO Usuarios (nomeUsuario, emailUsuario, senhaUsuario, confirmarSenhaUsuario)
                                            VALUES ('$nomeUsuario', '$emailUsuario', '$senhaUsuario', '$confirmarSenhaUsuario')";

            //Inclui o arquivo de conexão com o Banco de Dados
            include "conexaoBD.php";

            //A função mysqli_connect() executa a QUERY no BD
            //Se conseguir executar a QUERY, exibe alerta de sucesso e a tabela com os dados cadastrados
            if(mysqli_query($conn, $inserirUsuario)){

                echo "<div class='alert alert-success text-center'>Os dados do <strong>USUÁRIO</strong> foram cadastrados com sucesso!</div>";
                echo "
                    <div class='container mt-3 mb-3'>
                        <table class='table'>
                            <tr>
                                <th>NOME</th>
                                <td>$nomeUsuario</td>
                            </tr>
                            <tr>
                                <th>EMAIL</th>
                                <td>$emailUsuario</td>
                            </tr>
                            <tr>
                                <th>SENHA</th>
                                <td>$senhaUsuario</td>
                            </tr>
                            <tr>
                                <th>CONFIRMAR SENHA</th>
                                <td>$confirmarSenhaUsuario</td>
                            </tr>
                        </table>
                    </div>
                ";
            }
            else{
                echo "<div class='alert alert-danger text-center'>Erro ao tentar cadastrar <strong>USUÁRIO</strong> no banco de dados $database!</div>";
            }
        }


    
        else{
            //Usa a função header() para redirecionar o usuário para o formUsuario.php
            header("location:formUsuario.php");
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