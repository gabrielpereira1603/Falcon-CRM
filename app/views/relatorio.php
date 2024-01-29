<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="config\images\LOGOTIPO-WHITE-PNG.png" type="image/x-icon">
        <title>Falcon CRM</title>
        <link rel="stylesheet" href="config/css/relatorio.css">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="config/css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <script src="config/js/alerts"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/pdf-lib@1.4.0/dist/pdf-lib.min.js"></script>
        <script src="https://unpkg.com/pdf-lib@1.4.0"></script>
        <script src="https://unpkg.com/downloadjs@1.4.7"></script>
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
                        <p><strong>Curso Negociado:</strong> <?php echo $atendimento['curso_negociado']; ?></p>
                        <p><strong>Descrição do Atendimento:</strong> <?php echo $atendimento['descricao_atendimento']; ?></p>
                        <p><strong>Lembrete:</strong> <?php echo $atendimento['lembrete']; ?></p>
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
            const { PDFDocument, StandardFonts, rgb } = PDFLib;
            var codfuncionario = <?php echo json_encode($codfuncionario); ?>;
            async function createPdf() {
                // Create a new PDFDocument
                const pdfDoc = await PDFDocument.create();

                // Embed the Times Roman font
                const timesRomanFont = await pdfDoc.embedFont(StandardFonts.TimesRoman);

                // Add a blank page to the document
                const page = pdfDoc.addPage();

                // Get the width and height of the page
                const { width, height } = page.getSize();

                let y = height - 50;
                const fontSize = 12;

                // Load and embed the images
                const logoImageBytes = await fetch('https://raw.githubusercontent.com/gabrielpereira1603/Falcon-CRM/main/config/images/LOGOTIPO-BLACK-PNG.png').then(res => res.arrayBuffer());
                const logoEmpresaImageBytes = await fetch('https://raw.githubusercontent.com/gabrielpereira1603/Falcon-CRM/main/config/images/LOGOTIPO-2COR.png').then(res => res.arrayBuffer());

                const logoImage = await pdfDoc.embedPng(logoImageBytes);
                const logoEmpresaImage = await pdfDoc.embedPng(logoEmpresaImageBytes);

                // Draw logoImage at the top left corner
                page.drawImage(logoImage, {
                    x: 50,
                    y: height - 50,
                    width: 50, // Adjust size as needed
                    height: 50, // Adjust size as needed
                });

                // Draw logoEmpresaImage at the top right corner
                page.drawImage(logoEmpresaImage, {
                    x: width - 100,
                    y: height - 50,
                    width: 100, // Adjust size as needed
                    height: 50, // Adjust size as needed
                });

                // Adjust Y position after drawing images
                y -= 60; // Height of the images + some margin

                // Fetch and draw client data
                fetch(`?router=RelatorioController/obterDadosRelatorio&codfuncionario=${codfuncionario}`)
                    .then(response => response.json())
                    .then(jsonResponse => {
                        for (const entry of jsonResponse) {
                            // Draw card for each entry
                            page.drawText(`Nome Cliente: ${entry.nome_cliente}`, {
                                x: 50,
                                y,
                                size: fontSize,
                            });
                            y -= fontSize + 5;

                            page.drawText(`Curso: ${entry.curso_negociado}`, {
                                x: 50,
                                y,
                                size: fontSize,
                            });
                            y -= fontSize + 5;

                            page.drawText(`Telefone: ${entry.telefone_cliente}`, {
                                x: 50,
                                y,
                                size: fontSize,
                            });
                            y -= fontSize + 5;

                            page.drawText(`Descrição Atendimento: ${entry.descricao_atendimento}`, {
                                x: 50,
                                y,
                                size: fontSize,
                            });
                            y -= fontSize + 5;

                            // Add spacing between cards
                            y -= 20; // Adjust as needed
                        }

                    // Serialize the PDFDocument to bytes (a Uint8Array)
                    pdfDoc.save().then(pdfBytes => {
                        // Trigger the browser to download the PDF document
                        download(pdfBytes, "pdf-relatorio", "application/pdf");
                    });
                })
                .catch(error => console.error('Erro ao obter os dados do relatório:', error));
            }
        </script>   

        <script src="config/js/jquery.min.js"></script>
        <script src="config/js/popper.js"></script>
        <script src="config/js/bootstrap.min.js"></script>
        <script src="config/js/main.js"></script>
        <script src="config/js/relatorio.js"></script>

    </body>
</html>