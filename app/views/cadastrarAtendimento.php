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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                            <label for="telefone" class="form-label">*Telefone Discado:</label>
                            <input type="number" class="form-control" id="telefone" name="telefone" placeholder="(00) 9 0000-0000" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nomeCliente" class="form-label">Nome do cliente:</label>
                            <input type="text" class="form-control" id="nomeCliente" name="nomeCliente" placeholder="...">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3" id="cursoNegociadoContainer">
                            <label for="browser" class="form-label">Curso negociado: 
                                <a href="#" title="Clique para adicionar um novo curso ao atendimento" id="adicionarCurso"><i class="bi bi-plus-circle-fill"></i></a>
                            </label>
                            <select class="form-control" id="cursoNegociado" name="browser[]">
                                <option value="">Selecione o curso</option>
                                <?php foreach ($buscarCursos as $curso): ?>
                                    <option value="<?php echo $curso['nome_curso']; ?>"><?php echo $curso['nome_curso']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-1">
                        <label for="cursoNegociado" class="form-label">*Tipo Atendimento:</label>
                        <div class="mb-3">
                            <?php foreach ($buscarTipoAtendimento as $tipo): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="<?php echo $tipo['nome_tipo']; ?>" value="<?php echo $tipo['codtipo_atendimento']; ?>" name="tipo_atendimento[]" required>
                                    <label class="form-check-label" for="<?php echo $tipo['nome_tipo']; ?>"><?php echo $tipo['nome_tipo']; ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="horario-inicio" class="form-label">*Início do atendimento:</label>
                            <input type="time" class="form-control" id="horario-inicio" name="horarioInicio" placeholder="..." readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="horario-fim" class="form-label">*Fim do atendimento:</label>
                            <input type="time" class="form-control" id="horario-fim" name="horarioFim" placeholder="..." required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="agendarRetorno" class="form-label">Agendar Retorno: (Opcional)</label>
                                <div class="mb-6">
                                    <input type="datetime-local" class="form-control" id="agendarRetorno" name="agendarRetorno">
                                </div>
                                <label for="obs" class="form-label mt-3">Os campos que estão marcados com *, são campos obrigatorios</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição do atendimento:</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <button class="btn btn-danger mb-2 w-100" style="margin-top: 5px;" type="button" onclick="limparCookiesEFormulario('excluir')" name="excluir">Calcelar Atendimento</button>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <button class="btn btn-warning mb-2 w-100" style="margin-top: 5px;" type="submit"  name="finalizar">Finalizar Atendimento</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <!-- Bloco para mostrar os tipos de atendimento -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tipos de Atendimento</h5>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($contarAtendimento as $atendimento): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?php echo $atendimento['nome_tipo']; ?>
                                        <span class="badge bg-primary rounded-pill"><?php echo $atendimento['total_atendimentos_tipo']; ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Bloco para mostrar os atendimentos do dia atual -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Atendimentos do Dia Atual</h5>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($contarAtendimentoDiaAtual as $atendimentoDiaAtual): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?php echo $atendimentoDiaAtual['nome_tipo']; ?>
                                        <span class="badge bg-primary rounded-pill"><?php echo $atendimentoDiaAtual['total_atendimentos_tipo']; ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script>
            $(document).ready(function() {
                var cursoCounter = 0; // Contador para atribuir nomes únicos aos selects de curso

                $('#adicionarCurso').click(function(e) {
                    e.preventDefault();
                    cursoCounter++; // Incrementa o contador para cada novo select de curso adicionado
                    var selectHtml = '<div class="mb-3"><select class="form-control mt-2" name="browser[]' + cursoCounter + '"><option value="">Selecione o curso</option><?php foreach ($buscarCursos as $curso): ?><option value="<?php echo $curso['nome_curso']; ?>"><?php echo $curso['nome_curso']; ?></option><?php endforeach; ?></select><button class="btn btn-danger btn-sm limparSelect mt-2">Limpar</button></div>';
                    $('#cursoNegociadoContainer').append(selectHtml);
                });

                $(document).on('click', '.limparSelect', function() {
                    $(this).prev('select').remove();
                    $(this).remove();
                });
            });
        </script>

        <script src="config/js/jquery.min.js"></script>
        <script src="config/js/popper.js"></script>
        <script src="config/js/bootstrap.min.js"></script>
        <script src="config/js/main.js"></script>
        <script src="config/js/cadastroAtendimento.js"></script>
    </body>
</html>