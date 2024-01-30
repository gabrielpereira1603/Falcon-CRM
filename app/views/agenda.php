<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="config\images\LOGOTIPO-WHITE-PNG.png" type="image/x-icon">
        <title>Falcon CRM</title>
        <link rel="stylesheet" href="config/css/agenda.css">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="config/css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <script src="config/js/alerts"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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

            <div class="principal">
                <h1>Agenda de Tarefas</h1>
                <div class="agenda">
                    <?php foreach ($atendimentos as $atendimento): ?>
                        <div class="lembrete-card">
                            <div class="lembrete-content">
                                <h3 class="cliente-nome"><?php echo $atendimento['nome_cliente']; ?></h3>
                                <p class="cliente-numero"><?php echo $atendimento['telefone_cliente']; ?></p>
                                <p class="lembrete-texto">Curso: <?php echo $atendimento['curso_negociado']; ?></p>
                                <p class="lembrete-texto">Lembrete: <?php echo $atendimento['lembrete']; ?></p>
                            </div>
                            <form action="?router=AgendaController/deleteLembrete" method="POST" class="lembrete-actions">
                                <button class="btn btn-primary btn-editar" data-bs-toggle="modal" data-bs-target="#popupEditar">Editar</button>
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="modal fade" id="editarLembreteModal" tabindex="-1" aria-labelledby="editarLembreteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarLembreteModalLabel">Editar Lembrete</h5>
                            <button type="button" class="btn-close btn-cancelar" data-bs-dismiss="modal" aria-label="Fechar"><i class="bi bi-x-square-fill"></i></button>
                        </div>
                        <div class="modal-body">
                            <form action="?router=AgendaController/editLembrete" id="formEditarLembrete" method="POST">
                                <div class="mb-3">
                                    <label for="editarNomeCliente" class="form-label">Nome do Cliente</label>
                                    <input type="text" class="form-control" id="editarNomeCliente">
                                </div>
                                <div class="mb-3">
                                    <label for="editarTelefoneCliente" class="form-label">Telefone do Cliente</label>
                                    <input type="text" class="form-control" id="editarTelefoneCliente">
                                </div>
                                <div class="mb-3">
                                    <label for="editarCursoNegociado" class="form-label">Curso Negociado</label>
                                    <input type="text" class="form-control" id="editarCursoNegociado">
                                </div>
                                <div class="mb-3">
                                    <label for="editarLembrete" class="form-label">Lembrete</label>
                                    <input type="text" class="form-control" id="editarLembrete">
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success " id="salvarEdicao">Salvar</button>
                                </div>
                                        
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    // Adiciona um ouvinte de evento para o botão de editar em cada lembrete
                    $('.btn-editar').on('click', function () {
                        // Obtenha os dados do lembrete associado ao botão clicado
                        var nomeCliente = $(this).closest('.lembrete-card').find('.cliente-nome').text().trim();
                        var telefoneCliente = $(this).closest('.lembrete-card').find('.cliente-numero').text().trim();
                        var cursoNegociado = $(this).closest('.lembrete-card').find('.lembrete-texto:nth-child(3)').text().trim().replace('Curso: ', '');
                        var lembrete = $(this).closest('.lembrete-card').find('.lembrete-texto:nth-child(4)').text().trim().replace('Lembrete: ', '');

                        // Preenche os campos do formulário de edição do lembrete
                        $('#editarNomeCliente').val(nomeCliente);
                        $('#editarTelefoneCliente').val(telefoneCliente);
                        $('#editarCursoNegociado').val(cursoNegociado);
                        $('#editarLembrete').val(lembrete);

                        // Abre o modal de edição do lembrete
                        $('#editarLembreteModal').modal('show');
                    });

                    // Adiciona um ouvinte de evento para o botão de salvar no modal de edição
                    $('#salvarEdicao').on('click', function () {
                        // Obtenha os dados editados do formulário
                        var novoNomeCliente = $('#editarNomeCliente').val();
                        var novoTelefoneCliente = $('#editarTelefoneCliente').val();
                        var novoCursoNegociado = $('#editarCursoNegociado').val();
                        var novoLembrete = $('#editarLembrete').val();

                        // Faça o que for necessário para salvar as alterações do lembrete

                        // Fecha o modal após salvar as alterações
                        $('#editarLembreteModal').modal('hide');
                    });

                    $(document).ready(function () {
                        // Adiciona um ouvinte de evento para o botão "Cancelar"
                        $('.btn-cancelar').on('click', function () {
                            $('#editarLembreteModal').modal('hide'); // Fecha o modal
                        });
                    });
                });
            </script>

        </div>

        <script src="config/js/jquery.min.js"></script>
        <script src="config/js/popper.js"></script>
        <script src="config/js/bootstrap.min.js"></script>
        <script src="config/js/main.js"></script>
    </body>
</html>