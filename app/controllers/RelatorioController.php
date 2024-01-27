<?php

namespace app\controllers;

use app\models\RelatorioModel;

class RelatorioController extends RelatorioModel
{
    public function obterDadosRelatorio() {

        $relatorioModel = new RelatorioModel();
        $relatorio = $relatorioModel->buscarDadosRelatorio();

        header('Content-Type: application/json');
        echo  json_encode($relatorio);

    }
}