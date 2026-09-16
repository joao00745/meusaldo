<?php

include "header.php";
include "conexaoBD.php";


if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {

    header("Location: formlogin.php");
    exit();

}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: formAnuncio.php");
    exit();

}

if (!isset($_SESSION['idUsuario'])) {

    header("Location: formlogin.php");
    exit();

}

$idUsuario = (int) $_SESSION['idUsuario'];


$nomeProduto = trim($_POST['nomeProduto'] ?? '');

$estoqueProduto = trim($_POST['estoqueProduto'] ?? '');

$categoriaAnuncio = trim($_POST['categoriaAnuncio'] ?? '');

$valorCustoAnuncio = trim($_POST['valorCustoAnuncio'] ?? '');

$valorAnuncio = trim($_POST['valorAnuncio'] ?? '');



$erros = array();


if ($nomeProduto === '') {

    $erros[] = "O nome do produto é obrigatório.";

}

elseif (mb_strlen($nomeProduto) > 30) {

    $erros[] = "O nome do produto pode ter no máximo 30 caracteres.";

}


if ($estoqueProduto === '') {

    $erros[] = "O estoque é obrigatório.";

}

elseif (!filter_var($estoqueProduto, FILTER_VALIDATE_INT) &&
        $estoqueProduto !== '0') {

    $erros[] = "O estoque deve ser um número inteiro.";

}

else {

    $estoqueProduto = (int) $estoqueProduto;

    if ($estoqueProduto < 0) {

        $erros[] = "O estoque não pode ser negativo.";

    }

}


if ($categoriaAnuncio === '') {

    $erros[] = "A categoria é obrigatória.";

}

elseif (mb_strlen($categoriaAnuncio) > 50) {

    $erros[] = "A categoria pode ter no máximo 50 caracteres.";

}



// CONVERTE VALORES
// Exemplo: 50,00 -> 50.00

$valorCustoAnuncio = str_replace('.', '', $valorCustoAnuncio);

$valorCustoAnuncio = str_replace(',', '.', $valorCustoAnuncio);


$valorAnuncio = str_replace('.', '', $valorAnuncio);

$valorAnuncio = str_replace(',', '.', $valorAnuncio);



if ($valorCustoAnuncio === '') {

    $erros[] = "O valor de custo é obrigatório.";

}

elseif (!is_numeric($valorCustoAnuncio)) {

    $erros[] = "O valor de custo deve ser um número válido.";

}

elseif ((float)$valorCustoAnuncio < 0) {

    $erros[] = "O valor de custo não pode ser negativo.";

}




if ($valorAnuncio === '') {

    $erros[] = "O valor de venda é obrigatório.";

}

elseif (!is_numeric($valorAnuncio)) {

    $erros[] = "O valor de venda deve ser um número válido.";

}

elseif ((float)$valorAnuncio < 0) {

    $erros[] = "O valor de venda não pode ser negativo.";

}




if (!empty($erros)) {

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Erro - MeuSaldo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="css/styles.css"
          rel="stylesheet">

</head>

<body class="bg-primary">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-6">

                <div class="card shadow-lg border-0 rounded-lg mt-5">

                    <div class="card-header">

                        <h3 class="text-center my-4">
                            Erro no cadastro
                        </h3>

                    </div>

                    <div class="card-body">

                        <?php

                        foreach ($erros as $erro) {

                            echo "

                            <div class='alert alert-warning'>

                                " . htmlspecialchars($erro) . "

                            </div>

                            ";

                        }

                        ?>

                        <a href="formAnuncio.php"
                           class="btn btn-primary w-100">

                            Voltar para o cadastro

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>

<?php

    exit();

}




$valorCustoAnuncio = (float) $valorCustoAnuncio;

$valorAnuncio = (float) $valorAnuncio;



$sql = "INSERT INTO anuncios
        (
            Usuarios_idUsuario,
            nomeProduto,
            estoqueProduto,
            categoriaAnuncio,
            valorCustoAnuncio,
            valorAnuncio
        )
        VALUES (?, ?, ?, ?, ?, ?)";


$stmt = mysqli_prepare($conn, $sql);



if (!$stmt) {

    die(
        "Erro ao preparar o cadastro: "
        . mysqli_error($conn)
    );

}




mysqli_stmt_bind_param(
    $stmt,
    "isissd",
    $idUsuario,
    $nomeProduto,
    $estoqueProduto,
    $categoriaAnuncio,
    $valorCustoAnuncio,
    $valorAnuncio
);




if (mysqli_stmt_execute($stmt)) {


    // Fecha o comando

    mysqli_stmt_close($stmt);


    // Fecha a conexão

    mysqli_close($conn);


    // CADASTRO REALIZADO
    // Volta para a Home

    header("Location: index.php?cadastro=sucesso");

    exit();


}


// ERRO NO INSERT

$erroBanco = mysqli_stmt_error($stmt);

mysqli_stmt_close($stmt);

mysqli_close($conn);

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Erro - MeuSaldo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="css/styles.css"
          rel="stylesheet">

</head>

<body class="bg-primary">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-6">

                <div class="card shadow-lg border-0 rounded-lg mt-5">

                    <div class="card-header">

                        <h3 class="text-center my-4">
                            Erro ao cadastrar
                        </h3>

                    </div>

                    <div class="card-body">

                        <div class="alert alert-danger">

                            Não foi possível cadastrar o produto
                            no banco de dados.

                        </div>

                        <a href="formAnuncio.php"
                           class="btn btn-primary w-100">

                            Voltar para o cadastro

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>