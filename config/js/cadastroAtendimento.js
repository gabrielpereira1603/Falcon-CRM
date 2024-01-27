
    // Função para salvar os dados nos cookies
    function salvarDadosNosCookies() {
        var nomeCliente = document.getElementById('nomeCliente').value;
        var telefone = document.getElementById('telefone').value;
        var cursoNegociado = document.getElementById('cursoNegociado').value;
        var horarioInicio = document.getElementById('horario-inicio').value;
        var horarioFim = document.getElementById('horario-fim').value;
        var descricao = document.getElementById('descricao').value;
        var lembrete = document.getElementById('observacoes').value;

        document.cookie = 'nomeCliente=' + nomeCliente;
        document.cookie = 'telefone=' + telefone;
        document.cookie = 'cursoNegociado=' + cursoNegociado;
        document.cookie = 'horarioInicio=' + horarioInicio;
        document.cookie = 'horarioFim=' + horarioFim;
        document.cookie = 'descricao=' + descricao;
        document.cookie = 'lembrete=' + lembrete;
    }

    // Função para carregar os dados dos cookies quando a página é carregada
    window.onload = function() {
        var cookies = document.cookie.split(';');
        cookies.forEach(function(cookie) {
            var partes = cookie.split('=');
            var nome = partes[0].trim();
            var valor = partes[1];
            if (nome === 'nomeCliente') {
                document.getElementById('nomeCliente').value = valor;
            } else if (nome === 'telefone') {
                document.getElementById('telefone').value = valor;
            } else if (nome === 'cursoNegociado') {
                document.getElementById('cursoNegociado').value = valor;
            } else if (nome === 'horarioInicio') {
                document.getElementById('horario-inicio').value = valor;
            } else if (nome === 'horarioFim') {
                document.getElementById('horario-fim').value = valor;
            } else if (nome === 'descricao') {
                document.getElementById('descricao').value = valor;
            } else if (nome === 'lembrete') {
                document.getElementById('observacoes').value = valor;
            }
        });
    }

    function limparCookiesEFormulario(botaoClicado) {
        // Limpar os cookies
        var cookies = document.cookie.split(';');
        cookies.forEach(function(cookie) {
            var partes = cookie.split('=');
            var nome = partes[0].trim();
            document.cookie = nome + '=;expires=Thu, 01 Jan 1970 00:00:00 GMT';
        });
    
        // Limpar os campos do formulário
        document.getElementById('nomeCliente').value = '';
        document.getElementById('telefone').value = '';
        document.getElementById('cursoNegociado').value = '';
        document.getElementById('horario-inicio').value = '';
        document.getElementById('horario-fim').value = '';
        document.getElementById('descricao').value = '';
        document.getElementById('observacoes').value = '';
    
        // Exibir mensagem de acordo com o botão clicado
        if (botaoClicado === 'excluir') {
            // Exibir alerta de exclusão
            Swal.fire({
                position: "center",
                icon: "success",
                title: "O atendimento foi excluído",
                showConfirmButton: false,
                timer: 1500
            });
        } else if (botaoClicado === 'finalizar') {
            // Exibir alerta de finalização
            Swal.fire({
                position: "center",
                icon: "success",
                title: "O atendimento foi finalizado",
                showConfirmButton: false,
                timer: 1500
            });
        }
    }
    

    // Chamar a função de salvar os dados nos cookies sempre que houver uma mudança nos campos do formulário
    document.getElementById('nomeCliente').addEventListener('input', salvarDadosNosCookies);
    document.getElementById('telefone').addEventListener('input', salvarDadosNosCookies);
    document.getElementById('cursoNegociado').addEventListener('input', salvarDadosNosCookies);
    document.getElementById('horario-inicio').addEventListener('input', salvarDadosNosCookies);
    document.getElementById('horario-fim').addEventListener('input', salvarDadosNosCookies);
    document.getElementById('descricao').addEventListener('input', salvarDadosNosCookies);
    document.getElementById('observacoes').addEventListener('input', salvarDadosNosCookies);
