(function($) {
    teste = function() {
        var ativo = $("#ativo option:selected");
        var preco = $("#preco");
        var quantidade = $("#quantidade");
        var taxasTotal = $("#taxas_total")
        var table = $("#teste-ativos-conteudo");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
            }
        });

        $.ajax({
            url: "/purchases/adicionaAtivos",
            type: "POST",
            data: {
                ativoId: ativo.val(),
                ativoNome: ativo.text(),
                preco: preco.val(),
                quantidade: quantidade.val(),
                taxaTotal: taxasTotal.val()
            },
            dataType: "json"
        }).done(function(resposta) {
            if(resposta.sucesso === true) {
                $("#ativo").prop('selectedIndex', 0);
                preco.val("");
                quantidade.val("");
                $("#resposta").hide();
                table.html(resposta.msg);
            } else {
                $("#resposta").html(resposta.msg);
                $("#resposta").show();
            }
        }).fail(function(jqXHR, textStatus){
            console.log("Falhou: "+ textStatus);
        }).always(function(){
            console.log("Completou!!!");
        });
    };
  })(jQuery);