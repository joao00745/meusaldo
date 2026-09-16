<?php

session_start();
include "conexaoBD.php";

$idUsuario = $_SESSION['idUsuario'];

$idVenda = $_POST['idVenda'];


// Pega qual produto foi vendido e quantas unidades
$sql = "SELECT Anuncios_idAnuncios, quantidadeVendida
        FROM Vendas
        WHERE idVenda = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $idVenda);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$venda = mysqli_fetch_assoc($resultado);

if (!$venda) {
    die("Venda não encontrada.");
}

$idAnuncio = $venda['Anuncios_idAnuncios'];
$quantidadeVendida = $venda['quantidadeVendida'];


// Devolve o produto para o estoque
$sql = "UPDATE Anuncios
        SET estoqueProduto = estoqueProduto + ?
        WHERE idAnuncio = ?
        AND Usuarios_idUsuario = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "iii",
    $quantidadeVendida,
    $idAnuncio,
    $idUsuario
);

mysqli_stmt_execute($stmt);


// Apaga somente o registro da venda
$sql = "DELETE FROM Vendas
        WHERE idVenda = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $idVenda);
mysqli_stmt_execute($stmt);


header("Location: movimentacao.php");
exit;

?>