<!DOCTYPE html>
<html lang="pt-BR">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="config\images\LOGOTIPO-WHITE-PNG.png" type="image/x-icon">
        <title>Falcon CRM</title>
        <link rel="stylesheet" href="config/css/relatorio.css">
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
                    if (empty($dados)) { ?>
                        <script>
                            Swal.fire({
                                icon: 'info',
                                title: 'Nenhum resultado encontrado',
                                text: 'Sua pesquisa não retornou nenhum resultado.',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        </script>
                <?php
                    }
                    unset($_SESSION['dados-relatorio']);
                }
            ?>

            <div class="container">
                <h3>Gerar Relatório Personalizado</h3>
                <form action="?router=RelatorioController/filtroRelatorio" method="post" onsubmit="exibirRelatorio()">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="data">Data:</label>
                            <input type="date" class="form-control" id="data" name="data">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="horarioInicio">Horário de Início:</label>
                            <input type="time" class="form-control" id="horarioInicio" name="horarioInicio">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="horarioFim">Horário de Fim:</label>
                            <input type="time" class="form-control" id="horarioFim" name="horarioFim">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-warning btn-block"> Gerar Relatório Personalizado</button>
                            <input type="hidden" name="codfuncionario" value="<?php echo $_SESSION['codfuncionario']; ?>">
                        </div>
                    </div>
                </form>   
            </div>
            
            <div class="container">
                <h3>Relatório Diário</h3>       
                <?php foreach ($buscarRelatorio as $atendimento): ?>
                    <div class="atendimento">
                        <p><strong>Nome do Cliente:</strong> <?php echo $atendimento['nome_cliente']; ?></p>
                        <p><strong>Telefone:</strong> <?php echo $atendimento['telefone_cliente']; ?></p>
                        <p><strong>Curso Negociado:</strong> <?php echo $atendimento['cursos_relacionados']; ?></p>
                        <p><strong>Descrição do Atendimento:</strong> <?php echo $atendimento['descricao_atendimento']; ?></p>
                    </div>
                <?php endforeach; ?>
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="createPdf()" class="btn btn-warning btn-block">Baixar Relatório</button>
                        <?php $codfuncionario = $_SESSION['codfuncionario'];?>
                    </div>
                </div>
            </div>
        </div>

        <script>
         async function createPdf() {
            const doc = new PDFDocument();

            // Adiciona os dados ao documento
            const tableHeaders = ['Nome do Cliente', 'Telefone', 'Curso Negociado', 'Descrição do Atendimento'];

            // Posição inicial na página
            let y = 50;

            // Adiciona o título do relatório
            doc.fontSize(20).text('Relatório Diário', { align: 'center' });
            y += 50;

            // Adiciona a tabela de dados
            doc.table({
                headers: tableHeaders,
                rows: buscarRelatorio.map(atendimento => [
                    atendimento.nome_cliente,
                    atendimento.telefone_cliente,
                    atendimento.cursos_relacionados,
                    atendimento.descricao_atendimento
                ])
            });

            // Finaliza e baixa o PDF
            doc.end();

            // Obtém os bytes do PDF e cria um objeto Blob
            const pdfBytes = await doc.save();
            const pdfBlob = new Blob([pdfBytes], { type: 'application/pdf' });

            // Cria um link temporário para fazer o download do PDF
            const downloadLink = document.createElement('a');
            downloadLink.href = URL.createObjectURL(pdfBlob);
            downloadLink.download = 'relatorio.pdf';
            downloadLink.click();
        }

        </script>   

        <script src="config/js/jquery.min.js"></script>
        <script src="config/js/popper.js"></script>
        <script src="config/js/bootstrap.min.js"></script>
        <script src="config/js/main.js"></script>
        <script src="config/js/relatorio.js"></script>

    </body>
</html>