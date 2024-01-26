<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="config\images\LOGOTIPO-WHITE-PNG.png" type="image/x-icon">
        <title>Falcon CRM</title>
        <link rel="stylesheet" href="config/css/cadastrarAtendimento.css">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="config/css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </head>
    <body>
        <div class="wrapper d-flex align-items-stretch">
            <?php include("cabecario.php");?>
            <div>
                <h3>Cadastrar atendimento</h3>
            </div>
            
            <section class="cadastro">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nomeCliente" class="form-label">Nome do cliente:</label>
                            <input type="text" class="form-control" id="nomeCliente" placeholder="...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone:</label>
                            <input type="tel" class="form-control" id="telefone" placeholder="(00) 9 0000-0000">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cursoNegociado" class="form-label">Curso negociado:</label>
                            <input type="text" class="form-control" id="cursoNegociado" placeholder="...">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="horario-inicio" class="form-label">Início do atendimento:</label>
                            <input type="time" class="form-control" id="horario-inicio" placeholder="...">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="horario-fim" class="form-label">Fim do atendimento:</label>
                            <input type="time" class="form-control" id="horario-fim" placeholder="...">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição do atendimento:</label>
                            <textarea class="form-control" id="descricao" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="lembrete" class="form-label">Lembretes:</label>
                            <textarea class="form-control" id="observacoes" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-warning" style="margin-top: 10px;" type="button" onclick="limparCookies()">Finalizar Atendimento</button>
                    <button class="btn btn-warning ml-2" style="margin-top: 10px;" type="button" onclick="limparCookies()">Finalizar Atendimento</button>
                </div>

            </section>

        </div>


        <script src="config/js/jquery.min.js"></script>
        <script src="config/js/popper.js"></script>
        <script src="config/js/bootstrap.min.js"></script>
        <script src="config/js/main.js"></script>
        <script src="config/js/cadastroAtendimento.js"></script>
    </body>
</html>