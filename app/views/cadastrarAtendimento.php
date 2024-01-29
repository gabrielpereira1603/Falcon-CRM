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
        <script src="config/js/alerts"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

            <div>
                <h3>Cadastrar atendimento</h3>
            </div>
            
            <form method="POST" action="?router=AtendimentoController/CadastroAtendimento" class="cadastro">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nomeCliente" class="form-label">Nome do cliente:</label>
                            <input type="text" class="form-control" id="nomeCliente" name="nomeCliente" placeholder="..." required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone:</label>
                            <input type="number" class="form-control" id="telefone" name="telefone" placeholder="(00) 9 0000-0000" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cursoNegociado" class="form-label">Curso negociado:</label>
                            <input type="text" class="form-control" id="cursoNegociado" name="cursoNegociado" placeholder="..." required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="horario-inicio" class="form-label">Início do atendimento:</label>
                            <input type="time" class="form-control" id="horario-inicio" name="horarioInicio" placeholder="..." required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="horario-fim" class="form-label">Fim do atendimento:</label>
                            <input type="time" class="form-control" id="horario-fim" name="horarioFim" placeholder="..." required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição do atendimento:</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="lembrete" class="form-label">Lembretes:</label>
                            <textarea class="form-control" id="observacoes" name="lembrete" rows="3" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <button class="btn btn-danger mb-2 w-100" style="margin-top: 5px;" type="button" onclick="limparCookiesEFormulario('excluir')" name="excluir">Excluir Atendimento</button>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <button class="btn btn-warning mb-2 w-100" style="margin-top: 5px;" type="submit"  name="finalizar">Finalizar Atendimento</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <script src="config/js/jquery.min.js"></script>
        <script src="config/js/popper.js"></script>
        <script src="config/js/bootstrap.min.js"></script>
        <script src="config/js/main.js"></script>
        <script src="config/js/cadastroAtendimento.js"></script>
    </body>
</html>