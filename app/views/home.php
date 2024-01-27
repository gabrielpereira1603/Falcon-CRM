<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="config\images\LOGOTIPO-WHITE-PNG.png" type="image/x-icon">
        <title>Falcon CRM</title>
        <link rel="stylesheet" href="config/css/home.css">
        <link rel="stylesheet" href="config/node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="config/css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </head>

    <body>
        <div class="wrapper d-flex align-items-stretch">
            <?php include("cabecario.php");?>
                <div class="pricipal">
                    <h1>Olá Millene</h1>
                    <section class="m-5">
                        <div class="container-fluid cadastro d-flex align-items-center justify-content-between">
                            <div>
                                <h1 class="d-flex align-items-center">
                                <i class="bi bi-person-add"></i><a class="ms-2"> Atendimento</a>
                                </h1>
                            </div>
                            <div>
                                <a href="?router=Site/cadastrarAtendimento" class="btn btn-warning">Cadastrar</a>
                            </div>
                        </div>
                    </section>

                    <section class="m-5">
                        <div class="container-fluid cadastro d-flex align-items-center justify-content-between">
                            <div>
                                <h1 class="d-flex align-items-center">
                                <i class="bi bi-calendar-check"></i> <a class="ms-2"> Agenda</a>
                                </h1>
                            </div>
                            <div>
                                <a href="?router=Site/agenda" class="btn btn-warning">Vizualizar</a>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>


    

        <script src="config/js/jquery.min.js"></script>
        <script src="config/js/popper.js"></script>
        <script src="config/js/bootstrap.min.js"></script>
        <script src="config/js/main.js"></script>
    </body>
</html>