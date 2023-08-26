<?php

namespace PIXPDV;

class PIXPDV {
    private $homologacao;
    private $cnpj;
    private $token;
    private $secret;
    private $instacia;

    public function __construct($cnpj, $token, $secret, $homologacao = true) {
        $this->homologacao = $homologacao;
        $this->cnpj = $this->homologacao === false ? $cnpj : '00641418000188';
        $this->token = $this->homologacao === false ? $token : 'tk-ezI0OTgwMzRDLUE1MzctNDM3QS1CQTk0LUZFODlFMEE0MzIyNn0';
        $this->secret = $this->homologacao === false ? $secret : 'sk-e0JBNTFGRTY0LTczMkYtNDYxNC1CQ0Q1LUI0OTVDODgxOTUwRX0';

        $this->instacia = curl_init();
        curl_setopt($this->instacia, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->instacia, CURLOPT_POST, 1);
        curl_setopt($this->instacia,CURLOPT_ENCODING, '');
        curl_setopt($this->instacia,CURLOPT_MAXREDIRS, 10);
        curl_setopt($this->instacia,CURLOPT_TIMEOUT, 0);
        curl_setopt($this->instacia,CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->instacia,CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($this->instacia,CURLOPT_USERAGENT, 'PHP');
    }

    public function statusToken() {
        $body = json_encode(["cnpj" => $this->cnpj]);
        $headers = [
            'Content-Type: application/json',
            'Json-Hash: ' . $this->gerarHmac($body),
            'Authorization: Basic ' . base64_encode($this->cnpj . ':' . $this->token)
        ];

        curl_setopt($this->instacia,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->instacia, CURLOPT_URL, $this->homologacao === false ? "https://pixpdv.com.br/api/v1/statustoken" : "https://pixpdv.com.br/api-h/v1/statustoken");
        curl_setopt($this->instacia, CURLOPT_POSTFIELDS, $body);
        curl_setopt($this->instacia, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($this->instacia);

        return json_decode($response, true);
    }

    public function gerarQRDinamico($valor, $minutos, $msg, $imagem = false) {
        $body = json_encode([
            "valor" => $valor,
            "minutos" => $minutos,
            "mensagem" => $msg,
            "imagem" => $imagem
        ]);

        $headers = [
            'Content-Type: application/json',
            'Json-Hash: ' . $this->gerarHmac($body),
            'Authorization: Basic ' . base64_encode($this->cnpj . ':' . $this->token)
        ];

        curl_setopt($this->instacia,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->instacia, CURLOPT_URL, $this->homologacao === false ? "https://pixpdv.com.br/api/v1/qrdinamico" : "https://pixpdv.com.br/api-h/v1/qrdinamico");
        curl_setopt($this->instacia, CURLOPT_POSTFIELDS, $body);
        curl_setopt($this->instacia, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($this->instacia);
        if ($response === false) {
            return curl_error($this->instacia);
        }

        return json_decode($response, true);
    }

    public function gerarQRCobranca(string $valor, string $vencimento, int $expira, string $msg, array $pagador, array $juros, array $multa, array $desconto, bool $img = false, string $documento = "") {
        $body = json_encode([
            "valor" => $valor,
            "vencimento" => $vencimento,
            "expira" => $expira,
            "mensagem" => $msg,
            "imagem" => $img,
            "documento" => $documento,
            "pagador" => $pagador,
            "juros" => $juros,
            "multa" => $multa,
            "desconto" => $desconto
        ]);

        $headers = [
            'Content-Type: application/json',
            'Json-Hash: ' . $this->gerarHmac($body),
            'Authorization: Basic ' . base64_encode($this->cnpj . ':' . $this->token)
        ];

        curl_setopt($this->instacia,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->instacia, CURLOPT_URL, $this->homologacao === false ? "https://pixpdv.com.br/api/v1/qrcobranca" : "https://pixpdv.com.br/api-h/v1/qrcobranca");
        curl_setopt($this->instacia, CURLOPT_POSTFIELDS, $body);
        curl_setopt($this->instacia, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($this->instacia);
        if ($response === false) {
            return curl_error($this->instacia);
        }

        return json_decode($response, true);
    }

    public function statusQRCode(string $qrcodeid) {
        $headers = [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($this->cnpj . ':' . $this->token)
        ];

        curl_setopt($this->instacia,CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($this->instacia, CURLOPT_URL, $this->homologacao === false ? "https://pixpdv.com.br/api/v1/qrstatus?qrcodeid=" . $qrcodeid : "https://pixpdv.com.br/api-h/v1/qrstatus?qrcodeid=" . $qrcodeid);
        curl_setopt($this->instacia, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($this->instacia);
        if ($response === false) {
            return curl_error($this->instacia);
        }

        return json_decode($response, true);
    }

    public function devolverPagamento(string $qrcodeid) {
        $body = json_encode(["qrcodeid" => $qrcodeid]);

        $headers = [
            'Content-Type: application/json',
            'Json-Hash: ' . $this->gerarHmac($body),
            'Authorization: Basic ' . base64_encode($this->cnpj . ':' . $this->token)
        ];

        curl_setopt($this->instacia,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->instacia, CURLOPT_URL, $this->homologacao === false ? "https://pixpdv.com.br/api/v1/qrrefund" : "https://pixpdv.com.br/api-h/v1/qrrefund");
        curl_setopt($this->instacia, CURLOPT_POSTFIELDS, $body);
        curl_setopt($this->instacia, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($this->instacia);
        if ($response === false) {
            return curl_error($this->instacia);
        }

        return json_decode($response, true);
    }

    public function resumo(string $inicio, string $fim, string $tipo) {
        $headers = [
            'Authorization: Basic ' . base64_encode($this->cnpj . ':' . $this->token)
        ];

        curl_setopt($this->instacia,CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($this->instacia, CURLOPT_URL, $this->homologacao === false ? "https://pixpdv.com.br/api/v1/qrresumo?inicio=$inicio&fim=$fim&tipo=$tipo" : "https://pixpdv.com.br/api-h/v1/qrresumo?inicio=$inicio&fim=$fim&tipo=$tipo");
        curl_setopt($this->instacia, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($this->instacia);
        if ($response === false) {
            return curl_error($this->instacia);
        }

        return json_decode($response, true);
    }

    public function saldo() {
        $headers = [
            'Authorization: Basic ' . base64_encode($this->cnpj . ':' . $this->token)
        ];

        curl_setopt($this->instacia,CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($this->instacia, CURLOPT_URL, $this->homologacao === false ? "https://pixpdv.com.br/api/v1/saldo" : "https://pixpdv.com.br/api-h/v1/saldo");
        curl_setopt($this->instacia, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($this->instacia);
        if ($response === false) {
            return curl_error($this->instacia);
        }

        return json_decode($response, true);
    }

    public function retirarSaldo(float $valor) {
        $body = json_encode(["valor" => $valor]);

        $headers = [
            'Content-Type: application/json',
            'Json-Hash: ' . $this->gerarHmac($body),
            'Authorization: Basic ' . base64_encode($this->cnpj . ':' . $this->token)
        ];

        curl_setopt($this->instacia,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->instacia, CURLOPT_URL, $this->homologacao === false ? "https://pixpdv.com.br/api/v1/retirada" : "https://pixpdv.com.br/api-h/v1/retirada");
        curl_setopt($this->instacia, CURLOPT_POSTFIELDS, $body);
        curl_setopt($this->instacia, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($this->instacia);
        if ($response === false) {
            return curl_error($this->instacia);
        }

        return json_decode($response, true);
    }

    public function extrato(string $inicio, string $fim) {
        $headers = [
            'Authorization: Basic ' . base64_encode($this->cnpj . ':' . $this->token)
        ];

        curl_setopt($this->instacia,CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($this->instacia, CURLOPT_URL, $this->homologacao === false ? "https://pixpdv.com.br/api/v1/extrato?inicio=$inicio&fim=$fim" : "https://pixpdv.com.br/api-h/v1/extrato?inicio=$inicio&fim=$fim");
        curl_setopt($this->instacia, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($this->instacia);
        if ($response === false) {
            return curl_error($this->instacia);
        }

        return json_decode($response, true);
    }

    private function gerarHmac($body) {
        $hmac = hash_hmac('sha256', $body, $this->secret);
        return $hmac;
    }

    public function __destruct() {
        curl_close($this->instacia);
    }
}

?>
