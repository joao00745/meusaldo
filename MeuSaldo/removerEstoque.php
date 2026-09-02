<?php

include "conexaoBD.php";

session_start();

$idUsuario = $_SESSION['idUsuario'];

if (!isset($_POST['idAnuncio']) || !isset($_POST['quantidade'])) {
    die("Acesse esta página pelo formulário.");
}

$idAnuncio = $_POST['idAnuncio'];
$quantidade = $_POST['quantidade'];

if ($quantidade <= 0) {
    die("Quantidade inválida.");
}

$sql = "UPDATE Anuncios
        SET estoqueProduto = estoqueProduto - ?
        WHERE idAnuncio = ?
        AND Usuarios_idUsuario = ?
        AND estoqueProduto >= ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "iiii",
    $quantidade,
    $idAnuncio,
    $idUsuario,
    $quantidade
);

mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {

    header("Location: listaProdutos.php");
    exit;

} else {

    echo "Não foi possível remover essa quantidade do estoque.";

}

?>