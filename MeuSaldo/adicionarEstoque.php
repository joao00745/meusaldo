
<?php

include "conexaoBD.php";

session_start();

$idUsuario = $_SESSION['idUsuario'];

$idAnuncio = $_POST['idAnuncio'];
$quantidade = $_POST['quantidade'];


// Verifica se a quantidade é válida
if ($quantidade <= 0) {
    die("Quantidade inválida.");
}


// Atualiza somente o produto que pertence ao usuário
$sql = "UPDATE Anuncios
        SET estoqueProduto = estoqueProduto + ?
        WHERE idAnuncio = ?
        AND Usuarios_idUsuario = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "iii",
    $quantidade,
    $idAnuncio,
    $idUsuario
);

mysqli_stmt_execute($stmt);


// Verifica se o produto foi encontrado
if (mysqli_stmt_affected_rows($stmt) > 0) {

    header("Location: listaProdutos.php");
    exit;

} else {

    echo "Não foi possível adicionar o estoque.";

}

?>

