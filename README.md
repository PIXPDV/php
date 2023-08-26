# Biblioteca PHP para integrar sistemas com a PIXPDV

Segue exemplo abaixo:
<pre>
    
<?php

    // INSTALE A BIBLIOTECA COM composer require pixpdv/pixpdv-php:dev-main

    include "vendor/autoload.php";

    use PIXPDV\PIXPDV;

    $pixpdv = new PIXPDV("", "", "");

    echo json_encode($pixpdv->statusToken());
    echo json_encode($pixpdv->gerarQRDinamico(2.50, 5, "Teste"));

    // Objeto pagador
    $pagador = [
        "nome" => "Jose Nilton Pace",
        "fantasia" => "",
        "cpf_cnpj" => "12345678901",
        "endereco" => "Rua Emilio Bertoni, 1645",
        "bairro" => "Vila Totoli",
        "cidade" => "Franca",
        "estado" => "SP",
        "cep" => "14409108",
        "email" => "demo@jnp.com.br",
        "telefone" => "(16) 3727-5688"
    ];

    // Objeto juros
    $juros = [
        "tipo" => 3,
        "valor" => 10
    ];

    // Objeto multa
    $multa = [
        "tipo" => 2,
        "valor" => 5
    ];

    // Objeto desconto
    $desconto = [
        "tipo" => 2,
        "valor" => 10,
        "data" => "27/08/2023"
    ];

    echo json_encode($pixpdv->gerarQRCobranca(2.50, "30/08/2023", 30, "Cobrança Teste", $pagador, $juros, $multa, $desconto));
    echo json_encode($pixpdv->statusQRCode("E7D557E5-E518-406E-9541-2FF4B5312A44"));
    echo json_encode($pixpdv->devolverPagamento("E7D557E5-E518-406E-9541-2FF4B5312A44"));
    // echo json_encode($pixpdv->resumo("01082023", "26082023", "emissao"));
    echo json_encode($pixpdv->saldo());
    echo json_encode($pixpdv->retirarSaldo(0.25));
    echo json_encode($pixpdv->extrato("01082023", "26082023"));


?>
</pre>
