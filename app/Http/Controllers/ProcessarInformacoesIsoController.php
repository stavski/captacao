<?php

namespace App\Http\Controllers;

use App\Models\Iso;

class ProcessarInformacoesIsoController extends Controller
{
    public function index($code, $response)
    {
        $codigos   = json_decode($code);
        $resultado = [];

        if (null == $codigos) {
            return $this->processar($code, $response);
        }

        foreach ($codigos as $codigo) {
            $resultado[] = $this->processar($codigo, $response);
        }   

        return $resultado;
    }

    public function processar($code, $response)
    {
        $tabelas = explode('wikitable', $response);
        $tbody   = explode('<tbody>', $tabelas[1]);
        $trs     = explode('<tr>', $tbody[1]);

        unset($trs[0]);
        unset($trs[1]);

        $tipoDeBusca = 'code';
        $listaDeIsos = [];

        foreach ($trs as $tr) {
            $provisorio = [];
            $tds        = explode('<td>', $tr);
            $tds        = str_replace("\n", '', $tds);

            $tds = array_filter($tds, function ($value) {
                return !empty($value) || $value === 0;
            });

            $provisorio['code']    = str_replace("</td>", '', $tds[1]);
            $provisorio['number']  = str_replace("</td>", '', $tds[2]);
            $provisorio['decimal'] = str_replace("</td>", '', $tds[3]);

            // Pega o nome da moeda dentro do href
            preg_match_all("/<a.*?>(.*?)<\/a\>/", $tds[4], $moeda);
            $provisorio['currency']         = $moeda[1][0] ?? '';

            // Pega os locais dentro do href
            preg_match_all("/<a.*?>(.*?)<\/a\>/", $tds[5], $nomesLocais);

            for ($i = 0; $i < count($nomesLocais[1]); $i++) {
                $arrayLocalProvisorio['location'] = $nomesLocais[1][$i] ?? '';

                // Pega o icon dentro do src
                preg_match_all("/src=\"(.*?)\"/", $tds[5], $icon);
                $arrayLocalProvisorio['icon'] = $icon[1][$i] ?? '';

                // Armazena tudo no array provisorio
                $provisorio['currency_locations'][] = $arrayLocalProvisorio;
            }

            // Armazena no array final.
            $listaDeIsos[] = $provisorio;
        }

        // Verifica se o tipo de busca é código ou número
        if (is_numeric($code)) {
            $tipoDeBusca = 'number';
        }

        // Verifica se o código informado bate com algum do array.
        $indice = array_search(strtoupper($code), array_column($listaDeIsos, $tipoDeBusca));
        
        if (0 === $indice || $indice > 0) {
            // Salva as informações no banco de dados.
            $salvarProcessamento = new Iso();
            $salvarProcessamento->salvarBusca($listaDeIsos[$indice]);

            return $listaDeIsos[$indice];
        }
    }
}
