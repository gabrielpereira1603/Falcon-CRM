<?php

namespace app\controllers;

use app\models\RelatorioModel;

class RelatorioController extends RelatorioModel
{
    public function obterDadosRelatorio() {

        $codfuncionario = $_GET['codfuncionario'];
        // echo $codfuncionario;

        $relatorioModel = new RelatorioModel();
        $relatorio = $relatorioModel->buscarDadosRelatorio($codfuncionario );

        header('Content-Type: application/json');
        echo  json_encode($relatorio);

    }

    public function filtroRelatorio() 
    {
        session_start();
        $horaInicio = isset($_POST['horarioInicio']) ? $_POST['horarioInicio'] : '';
        $horaFim = isset($_POST['horarioFim']) ? $_POST['horarioFim'] : '';
        $data_atendimento = isset($_POST['data']) ? $_POST['data'] : '';
        $codfuncionario = $_POST['codfuncionario'];
    
        $relatorioModel = new RelatorioModel();
        $relatorio = $relatorioModel->relatorioPersonalizado($horaInicio, $horaFim, $data_atendimento, $codfuncionario);
        
        $_SESSION['dados-relatorio'] =  $relatorio;
    
        if($relatorio) {
            $_SESSION['success_message'] = 'Relatório gerado com sucesso!';
            header("Location: ?router=Site/resultadoRelatorio");
        } else {
            $_SESSION['error_admin'] = 'Dados inválidos';
            header("Location:?router=Site/relatorio");
        }
    }
    
    
}