<?php

namespace App\Http\Controllers;

use App\Http\Requests\IsoRequest;
use Exception;
use Illuminate\Http\Request;

class BuscarInformacoesIsoController extends Controller
{
    protected $url = "https://pt.wikipedia.org/wiki/ISO_4217";

    public function index(IsoRequest $request)
    {
        try {
            // Inicializa a biblioteca cURL
            $ch = curl_init();

            // Define as configurações da requisição
            curl_setopt_array($ch, [
                CURLOPT_URL            => $this->url,

                // Informa que deseja capturar o retorno
                CURLOPT_RETURNTRANSFER => true,

                // Permite o redirecionamento
                CURLOPT_FOLLOWLOCATION => true,

                // Informa que o tipo da requisição é POST
                CURLOPT_POST           => false,

                /*
                * Habilita a escrita de Cookies
                *(É obrigatório para alguns sites)
                */
                CURLOPT_COOKIEJAR      => 'cookies.txt',

                /* Desabilita a verificação do SSL,
                * caso você possua, pode deixar habilitado
                */
                CURLOPT_SSL_VERIFYPEER => false,
            ]);

            // Executa a requisição e captura o retorno
            $response = curl_exec($ch);

            // Captura eventuais erros
            $error    = curl_error($ch);

            // Captura a informação da requisição
            $info     = curl_getinfo($ch);

            $httpCode = !empty(curl_getinfo($ch, CURLINFO_HTTP_CODE)) ? $info['http_code'] : 402;

            // Fecha a conexão
            curl_close($ch);

            if ($error) {
                return response()->json(['errors' => ['code' => [$error]]], $httpCode, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }

            $processarInformacoes = new ProcessarInformacoesIsoController();

            return response()->json(['códigos'=> $processarInformacoes->index($request->code, $response)], 200);

        } catch (Exception $e) {
            return response()->json(['errors' => ['code' => ["Ocorreu um erro ao executar a busca"]]], 500, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);

        }
    }
}
