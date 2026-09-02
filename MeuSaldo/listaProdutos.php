<?php

include "header.php";
include "conexaoBD.php";

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: formlogin.php");
    exit();
}

$sql = "SELECT
            idAnuncio,
            nomeProduto,
            estoqueProduto,
            categoriaAnuncio,
            valorCustoAnuncio,
            valorAnuncio
        FROM anuncios
        WHERE Usuarios_idUsuario = ?
        ORDER BY idAnuncio DESC";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $idUsuario
);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Produtos - MeuSaldo</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css"
          rel="stylesheet">

    <link href="css/styles.css"
          rel="stylesheet">

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"
            crossorigin="anonymous"></script>

</head>

<body class="sb-nav-fixed">

<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

    <a class="navbar-brand ps-3"
       href="index.php">

        Início

    </a>

</nav>

<div id="layoutSidenav">

    <div id="layoutSidenav_content">

        <main>

            <div class="container-fluid px-4">

                <h1 class="mt-4">
                    Produtos cadastrados
                </h1>

                <ol class="breadcrumb mb-4">

                    <li class="breadcrumb-item">
                        <a href="index.php">
                            Início
                        </a>
                    </li>

                    <li class="breadcrumb-item active">
                        Produtos
                    </li>

                </ol>

                <div class="card mb-4">

                    <div class="card-header">

                        <i class="fas fa-box me-1"></i>

                        Registros da entidade Anúncio

                    </div>

                    <div class="card-body">

                        <table id="datatablesSimple">

                            <thead>

                                <tr>

                                    <th>Produto</th>
                                    <th>Estoque</th>
                                    <th>Categoria</th>
                                    <th>Custo</th>
                                    <th>Venda</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                if (mysqli_num_rows($resultado) > 0) {

                                    while ($produto = mysqli_fetch_assoc($resultado)) {

                                        echo "<tr>";

                                        echo "<td>" .
                                            htmlspecialchars(
                                                $produto['nomeProduto']
                                            ) .
                                            "</td>";

                                        echo "<td>" .
                                            htmlspecialchars(
                                                $produto['estoqueProduto']
                                            ) .
                                            "</td>";

                                        echo "<td>" .
                                            htmlspecialchars(
                                                $produto['categoriaAnuncio']
                                            ) .
                                            "</td>";

                                        echo "<td>R$ " .
                                            number_format(
                                                $produto['valorCustoAnuncio'],
                                                2,
                                                ',',
                                                '.'
                                            ) .
                                            "</td>";

                                        echo "<td>R$ " .
                                            number_format(
                                                $produto['valorAnuncio'],
                                                2,
                                                ',',
                                                '.'
                                            ) .
                                            "</td>";

                                        echo "</tr>";

                                    }

                                } else {

                                    echo "
                                    <tr>

                                        <td colspan='6'
                                            class='text-center'>

                                            Nenhum produto cadastrado.

                                        </td>

                                    </tr>
                                    ";

                                }

                                ?>

                            </tbody>

                        </table>

                        <div class="mt-3">
                        

                        <form action="adicionarEstoque.php" method="POST">

                        <!--Adicionar Produto-->

                            <label>Escolha o produto:</label>

                                <select name="idAnuncio" required>
                                    <option value="">Selecione um produto</option>

                                    <?php
                                    $sqlProdutos = "SELECT idAnuncio, nomeProduto, estoqueProduto
                                                    FROM Anuncios
                                                    WHERE Usuarios_idUsuario = $idUsuario";

                                    $resultadoProdutos = mysqli_query($conn, $sqlProdutos);

                                    while ($produto = mysqli_fetch_assoc($resultadoProdutos)) {
                                    ?>

                                        <option value="<?php echo $produto['idAnuncio']; ?>">
                                            <?php echo $produto['nomeProduto']; ?>
                                            (Estoque: <?php echo $produto['estoqueProduto']; ?>)
                                        </option>

                                    <?php
                                    }
                                    ?>

                                </select>

                                <label>Quantidade para adicionar:</label>

                                <input type="number"
                                    name="quantidade"
                                    min="1"
                                    required>

                                <button type="submit" class="btn btn-success">
                                    + Adicionar estoque
                                </button>

                        </form>

                        <br>

                        <!--Remover Produto-->

                        <form action="removerEstoque.php" method="POST">

                            <label>Escolha o produto:</label>

                            <select name="idAnuncio" required>
                                <option value="">Selecione um produto</option>

                                <?php
                                $sqlProdutos = "SELECT idAnuncio, nomeProduto, estoqueProduto
                                                FROM Anuncios
                                                WHERE Usuarios_idUsuario = $idUsuario";

                                $resultadoProdutos = mysqli_query($conn, $sqlProdutos);

                                while ($produto = mysqli_fetch_assoc($resultadoProdutos)) {
                                ?>

                                    <option value="<?php echo $produto['idAnuncio']; ?>">
                                        <?php echo $produto['nomeProduto']; ?>
                                        - Estoque: <?php echo $produto['estoqueProduto']; ?>
                                    </option>

                                <?php
                                }
                                ?>

                            </select>


                            <label>Quantidade para remover:</label>

                            <input type="number"
                                name="quantidade"
                                min="1"
                                required>

                            <button type="submit" class="btn btn-danger">
                                Remover estoque
                            </button>

                        </form>

                        <br>

                        <!--Cria o Produto-->

                            <a href="formAnuncio.php"
                               class="btn btn-primary">

                                <i class="fas fa-plus"></i>

                                Criar produto

                            </a>
                        
                        <!--Voltar para a HOME-->

                            <a href="index.php"
                               class="btn btn-secondary">

                                Voltar para Home

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>

<script src="js/scripts.js"></script>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>

<script src="js/datatables-simple-demo.js"></script>

</body>

</html>