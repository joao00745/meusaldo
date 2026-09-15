<?php

session_start();

include "conexaoBD.php";

$idUsuario = $_SESSION['idUsuario'];

if (!isset($_POST['idAnuncio']) || !isset($_POST['quantidade'])) {
    die("Dados da venda não foram enviados.");
}

$idAnuncio = $_POST['idAnuncio'];
$quantidade = $_POST['quantidade'];

if ($quantidade <= 0) {
    die("Quantidade inválida.");
}


// Busca o produto
$sql = "SELECT estoqueProduto, valorAnuncio, valorCustoAnuncio
        FROM Anuncios
        WHERE idAnuncio = ?
        AND Usuarios_idUsuario = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ii", $idAnuncio, $idUsuario);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

$produto = mysqli_fetch_assoc($resultado);


// Verifica se o produto existe
if (!$produto) {
    die("Produto não encontrado.");
}


$estoque = $produto['estoqueProduto'];
$valorAnuncio = $produto['valorAnuncio'];
$valorCustoAnuncio = $produto['valorCustoAnuncio'];


// Verifica se existe estoque suficiente
if ($quantidade > $estoque) {
    die("Você não possui essa quantidade em estoque.");
}


// Calcula o lucro da venda
session_start();

$lucroVenda = $lucroVenda + $lucroTotalVenda;
$lucroTotalVenda = ($valorAnuncio - $valorCustoAnuncio) * $quantidade;

$_SESSION['lucroVenda'] = $lucroVenda;

// Registra a venda
$sqlVenda = "INSERT INTO Vendas
             (Anuncios_idAnuncios, quantidadeVendida)
             VALUES (?, ?)";

$stmtVenda = mysqli_prepare($conn, $sqlVenda);

mysqli_stmt_bind_param(
    $stmtVenda,
    "ii",
    $idAnuncio,
    $quantidade
);

mysqli_stmt_execute($stmtVenda);


// Diminui o estoque
$sqlEstoque = "UPDATE Anuncios
               SET estoqueProduto = estoqueProduto - ?
               WHERE idAnuncio = ?
               AND Usuarios_idUsuario = ?";

$stmtEstoque = mysqli_prepare($conn, $sqlEstoque);

mysqli_stmt_bind_param(
    $stmtEstoque,
    "iii",
    $quantidade,
    $idAnuncio,
    $idUsuario
);

mysqli_stmt_execute($stmtEstoque);


// Volta para a página de produtos
header("Location: movimentacao.php");
exit;

?>