<?php

include "conexaoBD.php";

$id = $_GET['id'];

$sql = "DELETE FROM Anuncios
        WHERE idAnuncio = $id";

$resultado = mysqli_query($conn, $sql);

if ($resultado) {
    header("Location: listaProdutos.php");
    exit;
} else {
    echo "Erro ao remover produto: " . mysqli_error($conn);
}

?>