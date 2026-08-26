<?php include "header.php"; include "conexaoBD.php"; 

//DESPESA

$sqlDespesa = "SELECT SUM(valorCustoAnuncio) AS despesaTotal
               FROM Anuncios
               WHERE Usuarios_idUsuario = $idUsuario";

$resultadoDespesa = mysqli_query($conn, $sqlDespesa);

if (!$resultadoDespesa) {
    die("Erro ao consultar despesas: " . mysqli_error($conn));
}

$dadosDespesa = mysqli_fetch_assoc($resultadoDespesa);
$despesaTotal = $dadosDespesa['despesaTotal'] ?? 0;

$somadespesaTotal = $despesaTotal * $estoqueTotal;

//RECEITA

$sqlReceita = "SELECT SUM(valorAnuncio) AS receitaTotal
               FROM Anuncios
               WHERE Usuarios_idUsuario = $idUsuario";

$resultadoReceita = mysqli_query($conn, $sqlReceita);

if (!$resultadoReceita) {
    die("Erro ao consultar receitas: " . mysqli_error($conn));
}

$dadosReceita = mysqli_fetch_assoc($resultadoReceita);
$receitaTotal = $dadosReceita['receitaTotal'] ?? 0;

//LUCRO TOTAL
$lucroTotal = $receitaTotal - $despesaTotal;

?>
<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <meta name="description" content="" />

    <meta name="author" content="" />

    <title>MeuSaldo</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css"
          rel="stylesheet" />

    <link href="css/styles.css"
          rel="stylesheet" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"
            crossorigin="anonymous"></script>

</head>


<body class="sb-nav-fixed">


<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

    <a class="navbar-brand ps-3"
       href="index.php">

        MeuSaldo

    </a>


    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0"
            id="sidebarToggle"
            href="#!">

        <i class="fas fa-bars"></i>

    </button>


    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

        <div class="input-group">

            <input class="form-control"
                   type="text"
                   placeholder="Pesquisar..."
                   aria-label="Pesquisar" />

            <button class="btn btn-primary"
                    id="btnNavbarSearch"
                    type="button">

                <i class="fas fa-search"></i>

            </button>

        </div>

    </form>

    <?php
        if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
            echo"
            <ul class='navbar-nav ms-auto ms-md-0 me-3 me-lg-4'>

                <li class='nav-item dropdown'>

                    <a class='nav-link '
                    id='navbarDropdown'
                    href='#'
                    role='button'
                    data-bs-toggle=dropdown'
                    aria-expanded='false'>
                        <i class='fas fa-user fa-fw'></i>

                    </a>
        ";
        }
        else{
            echo"
            <ul class='navbar-nav ms-auto ms-md-0 me-3 me-lg-4'>
                <li class='nav-item dropdown'>

                    <a class='nav-link'
                    id='navbarDropdown'
                    href='formLogin.php'
                    role='button'
                    data-bs-toggle=dropdown'
                    aria-expanded='false'>

                        <i class='fas fa-user fa-fw'></i>
                        Login

                    </a>
            </ul>
            ";
        }
    ?>

</nav>



<div id="layoutSidenav">
    <div id="layoutSidenav_nav">

        <nav class="sb-sidenav accordion sb-sidenav-dark"
             id="sidenavAccordion">


            <div class="sb-sidenav-menu">

                <div class="nav">


                    <div class="sb-sidenav-menu-heading">

                        MeuSaldo

                    </div>
                    <a class="nav-link"
                       href="index.php">

                        <div class="sb-nav-link-icon">

                            <i class="fas fa-home"></i>

                        </div>

                        Início

                    </a>
                    <?php
                        if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
                        echo"
                            <a class='nav-link'
                            href='formAnuncio.php'>

                                <div class='sb-nav-link-icon'>

                                    <i class='fas fa-plus'></i>

                                </div>

                                Criar anúncio

                            </a>

                            <a class='nav-link'
                            href='listaProdutos.php'>

                                <div class='sb-nav-link-icon'>

                                    <i class='fas fa-box'></i>

                                </div>

                                Produtos

                            </a>

                            <a class='nav-link'
                            href='movimentacao.php'>

                                <div class='sb-nav-link-icon'>

                                    $

                                </div>

                                Movimentação

                            </a>


                            <a class='nav-link'
                            href='logout.php'>

                                <div class='sb-nav-link-icon'>

                                    <i class='fas fa-sign-out-alt'></i>

                                </div>

                                Sair

                            </a>
                            ";
                        }
                        else{
                            echo"
                            <a class='nav-link'
                            href='formLogin.php'>

                                <div class='sb-nav-link-icon'>

                                    <i class='fas fa-sign-out-alt'></i>

                                </div>

                                Login

                            </a>
                            ";
                        
                        }
                    ?>


                </div>

            </div>


            <div class="sb-sidenav-footer">

                <div class="small">

                    Usuário conectado:

                </div>

                <?php
                
                if (isset($primeiroNome)) {

                    echo htmlspecialchars($primeiroNome);

                } else {

                    echo "Nenhum usuário conectado";

                }

                ?>

            </div>


        </nav>

    </div>

    <div id="layoutSidenav_content">


        <main>


            <div class="container-fluid px-4">



                <h1 class="mt-4">

                    MeuSaldo

                </h1>


                <ol class="breadcrumb mb-4">

                    <li class="breadcrumb-item active">

                        Início

                    </li>

                </ol>

                <div class="row">
                    <div class="col-xl-4 col-md-6">

                        <div class="card bg-danger text-white mb-4">

                            <div class="card-body">

                                <h5>

                                    Despesa Total

                                </h5>

                                <h2>

                                    <?php
                                    echo " R$ - $despesaTotal";

                                    ?>

                                </h2>

                            </div>


                            <div class="card-footer d-flex align-items-center justify-content-between">

                                <span>

                                    Custos

                                </span>

                                <i class="fas fa-box"></i>

                            </div>

                        </div>

                    </div>


                    <div class="col-xl-4 col-md-6">

                        <div class="card bg-primary text-white mb-4">

                            <div class="card-body">

                                <h5>

                                    Receita Total

                                </h5>

                                <h2>

                                    <?php

                                    echo "R$ + $receitaTotal";

                                    ?>

                                </h2>

                            </div>


                            <div class="card-footer d-flex align-items-center justify-content-between">

                                <span>

                                    Ganhos Brutos

                                </span>

                                <i class="fas fa-warehouse"></i>

                            </div>

                        </div>

                    </div>

                    <div class="col-xl-4 col-md-6">

                        <div class="card bg-success text-white mb-4">

                            <div class="card-body">

                                <h5>

                                    Lucro Total

                                </h5>

                                <h2>

                                    <?php

                                    echo "R$ $lucroTotal";

                                    ?>

                                </h2>

                            </div>


                            <div class="card-footer d-flex align-items-center justify-content-between">

                                <span>

                                    Lucro Líquido

                                </span>

                                <i class="fas fa-tags"></i>

                            </div>

                        </div>

                    </div>


                </div>