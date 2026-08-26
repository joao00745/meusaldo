<?php
    error_reporting(0); //Desabilita alertas de erros de execução
    session_start(); //Inicia uma sessão

    //Configura o fuso horário para America/São Paulo
    date_default_timezone_set('America/Sao_Paulo');

    //Verifica se há sessão ativa
    if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
        //Armazena em variáveis PHP os dados do $_SESSION[]
        $idUsuario    = $_SESSION['idUsuario'];
        $nomeUsuario  = $_SESSION['nomeUsuario'];
        $emailUsuario = $_SESSION['emailUsuario'];
        $nivelUsuario = $_SESSION['nivelUsuario'];

        $nomeCompleto = explode(' ', $nomeUsuario);
        $primeiroNome = $nomeCompleto[0];

    }

    
    


   
?>
