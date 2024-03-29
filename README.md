# Biblioteca PHP para integrar sistemas com a PIXPDV

## Porque PIXPDV?

Por ser uma transferência eletrônica instantânea, em ambiente seguro, o PIXPDV se alinha ao ritmo do comércio e negócios em geral. Não há necessidade de esperar o próximo dia útil ou a próxima janela de horário para receber um pagamento. O PIXPDV funciona 24 horas, 7 dias por semana. Os custos são menores e há facilidade na integração com a conciliação de pagamentos. O PIXPDV na prática tem o mesmo efeito do pagamento em dinheiro (em espécie).

## Instale a Biblioteca PIXPDV:
<pre>composer require pixpdv/pixpdv-php:dev-main</pre>
## Segue exemplo abaixo:
<pre>

    include "vendor/autoload.php";

    use PIXPDV\PIXPDV;

    $pixpdv = new PIXPDV("cnpj", "token", "secret", true); // true para produção e false para homologação

    echo json_encode($pixpdv->statusToken());
    echo json_encode($pixpdv->QRDinamico(2.50, 5, "Teste"));

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

    echo json_encode($pixpdv->QRCobranca(2.50, "30/08/2023", 30, "Cobrança Teste", $pagador, $juros, $multa, $desconto));
    echo json_encode($pixpdv->QRCodeStatus("E7D557E5-E518-406E-9541-2FF4B5312A44"));
    echo json_encode($pixpdv->QRRefund("E7D557E5-E518-406E-9541-2FF4B5312A44"));
    // echo json_encode($pixpdv->resumo("01082023", "26082023", "emissao"));
    echo json_encode($pixpdv->saldo());
    echo json_encode($pixpdv->Retirada(0.25));
    echo json_encode($pixpdv->extrato("01082023", "26082023"));

</pre>
