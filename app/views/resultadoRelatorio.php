<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="config\images\LOGOTIPO-WHITE-PNG.png" type="image/x-icon">
        <title>Falcon CRM</title>
        <link rel="stylesheet" href="config/css/resultadoRelatorio.css">
        <link rel="stylesheet" href="config/css/style.css">
        <link rel="stylesheet" href="config/node_modules/bootstrap/dist/css/bootstrap.min.css">
        <script src="config/js/alerts"></script>
        <script src="https://unpkg.com/pdf-lib@1.4.0"></script>
        <script src="https://unpkg.com/downloadjs@1.4.7"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/pdf-lib@1.4.0/dist/pdf-lib.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    </head>
    <body>
        <div class="wrapper d-flex align-items-stretch">
            <?php include("cabecario.php");?>
            <?php if (isset($_SESSION['error_message'])): ?>
                <script>
                    showErrorAlert('<?php echo $_SESSION['error_message']; ?>');
                </script>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['success_message'])): ?>
                <script>
                    showSucessoAlert('<?php echo $_SESSION['success_message']; ?>');
                </script>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <?php
                if (isset($_SESSION['dados-relatorio'])) {
                    $dados = $_SESSION['dados-relatorio'];

                    if (!empty($dados)) { ?>
                    <div class="table-responsive">
                        <table id="tabela-manutencao" class="display">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome do Funcionario</th>
                                    <th>Nome do Cliente</th>
                                    <th>Telefone do Cliente</th>
                                    <th>Data do Atendimento</th>
                                    <th>Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dados as $relatorio) {
                                    echo '
                                    <tr>
                                        <td>' . $relatorio['codatendimento'] . '</td>
                                        <td>' . $relatorio['nome_funcionario'] . '</td>
                                        <td>' . $relatorio['nome_cliente'] . '</td>
                                        <td>' . $relatorio['telefone_cliente'] . '</td>
                                        <td>' . $relatorio['data_atendimento'] . '</td>
                                        <td>' . $relatorio['descricao_atendimento'] . '</td>
                                    </tr>';
                                }?>
                            </tbody>
                        </table>
                        <div class="d-grid gap-2 mt-4">
                            <button id="gerarPDF" class="btn btn-primary" type="button">Gerar Relatório em PDF</button>
                        </div>
                    </div>
            <?php
                    }
                }
            ?>
        <script>
            $(document).ready(function () {
                $("#tabela-manutencao").DataTable();
            });
            
        </script>
        
        <script src="config/js/jquery.min.js"></script>
        <script src="config/js/popper.js"></script>
        <script src="config/js/bootstrap.min.js"></script>
        <script src="config/js/main.js"></script>
        <script src="config/js/relatorio.js"></script>
        <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>