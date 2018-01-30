$(function () {
	
    function textoInput(input, texto) {
        $(input).parent('p').append("<a id='textoInput' >" + texto + "</a>");
    };

    $('#cadastro input[placeholder]').focusout(function () {
        $(this).parent('p').find("#textoInput").remove();
    });

    function erro(thiss) {
        $(thiss).siblings('img').remove();
        $(thiss).parent('p').append("<img id='cf' src='img/icones/error.png'>");
    } 
	
	function load(thiss) {
        $(thiss).siblings('img').remove();
        $(thiss).parent('p').append("<img id='cf' src='img/icones/load.png'>");
    }
    function valido(thiss) {
        $(thiss).siblings('img').remove();
        $(thiss).parent('p').append("<img id='cf' src='img/icones/ok.png'>");
    }
	
	
   var regex = {
		nome: function(n){
			var r = /^([a-z A-Z\u00C0-\u00FF]){3,50}$/;
			return r.test(n);
		},
		cpf: function(t){
			var r = /^((\d{3})\.(\d{3})\.(\d{3})\-(\d{2})){1,14}$/;
			return r.test(t);
		},
		rg: function(t){
			var r = /^(\d){10}$/;
			return r.test(t);
		},
		cep: function(c){
			var r = /^(\d){8}$/;
			return r.test(c);
		},
		endereco: function(e){
			var r = /^([a-z A-Z\u00C0-\u00FF](\d{1,6})?){5,80}$/;
			return r.test(e);
		},	
		bairro: function(b){
			var r = /^([a-z A-Z\u00C0-\u00FF]){5,50}$/;
			return r.test(b);
		},
		estado: function(b){
			var r = /^([A-Z]){2}$/;
			return r.test(b);
		},
		telefone: function(t){
			var r = /^(\(\d{2}\)\s\d{4,5}-\d{4}){1,15}$/;
			return r.test(t);
		},
		email: function(e){
			var r = /(^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)){1,80}$/;
			return r.test(e);
		},
		senha: function(s){
			var r = /^([a-zA-Z0-9]){6,16}$/;
			return r.test(s);
		}
	};
	
	$('#cadastro input[name=nome]').keyup(function(){
		var thiss = $(this);
		thiss.val(thiss.val().replace(/ /g,' '));
		var nome = thiss.val().trim();
		
		if(regex.nome(nome))
			valido(this);
        else
            erro(this);
	}).focus(function () {
        textoInput(this, 'campo nome, somente letra de A-Z e espaços, de 3 à 50 caracteres');
    });
	
	$('#cadastro input[name=cpf]').keyup(function(){
	
		var cpf = $(this).val();
		cpf = cpf.replace(/[^\d]{1,}/g,'').replace(/(\d{3})(\d{3})(\d{3})(\d{2})$/,"$1.$2.$3-$4");
		$(this).val(cpf);
		
		if(regex.cpf(cpf))
			valido(this);
        else
            erro(this);
	}).focus(function () {
        textoInput(this, 'campo cpf, somente numeros 0-9, 11 caracteres');
    });
	
	$('#cadastro input[name=rg]').keyup(function(){
	
		var rg = $(this).val();
		rg = rg.replace(/[^\d]{1,}/g,'');
		$(this).val(rg);
		
		if(regex.rg(rg))
			valido(this);
        else
            erro(this);
	}).focus(function () {
        textoInput(this, 'campo cpf, somente numeros 0-9, 11 caracteres');
    });
	
	$('#cadastro input[name=cep]').keyup(function(){
		var thiss = $(this);
		var cep = $(this).val();
		
		if(regex.cep(cep) || cep.length == 0)
			valido(this);
        else
			erro(this);
	}).focus(function () {
        textoInput(this, 'campo cep, somente numeros de 0-9, 8 caracteres');
    }).keydown(function(event){
		
		if(event.keyCode == 13){
			var thiss = $(this);
			var cep = thiss.val();
			
			if(regex.cep(cep)){
				
				load(thiss)
				//Consulta o webservice viacep.com.br/
				$.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?",function(dados){
					
					if(!("erro" in dados)){
						$("#cadastro input[name=endereco]").val(dados.logradouro);
						$("#cadastro input[name=bairro]").val(dados.bairro);
						$("#cadastro select[name=estado] option[value="+dados.uf+"]").attr("selected","'selected'");
						valido("#cadastro input[name=endereco],#cadastro input[name=bairro],#cadastro select[name=estado]");
						$('input[name=cep]').removeClass();
					}else{
						alert("CEP não encontrado.");
						erro(thiss)
						$("#cadastro input[name=endereco],#cadastro input[name=bairro]").val('').siblings('img').remove();
						$("#cadastro select[name=estado]").siblings('img').remove();
						$("#cadastro select[name=estado] option").removeAttr('selected');
					}
					
				}).fail(function() {
					alert("erro no sistema, CEP não encontrado.");
					erro(thiss)
					$("#cadastro input[name=endereco],#cadastro input[name=bairro]").val('').siblings('img').remove();
					$("#cadastro select[name=estado]").siblings('img').remove();
					$("#cadastro select[name=estado] option").removeAttr('selected');
				});
			}else
				erro(thiss);
		}
	});
	
	$('#cadastro input[name=endereco]').keyup(function(){
		var endereco = $(this).val();
		
		if(regex.endereco(endereco))
			valido(this);
		else
			erro(this);
	}).focus(function () {
        textoInput(this, 'campo endereço, limite de 80 caracteres');
	});
	
	$('#cadastro input[name=bairro]').keyup(function(){
		var bairro = $(this).val();
		
		if(regex.bairro(bairro))
			valido(this);
		else
			erro(this);
	}).focus(function () {
        textoInput(this, 'campo bairro, limite de 50 caracteres');
	});	
	
	$('#cadastro select[name=estado]').change(function(){
	
		var estado = $(this).val();
		
		if(regex.estado(estado))
			valido(this);
		else
			erro(this);
	});	
	
	$('input[name=telefone]').keyup(function(){
		
		var thiss = $(this);
		var tel = $(this).val();
		tel = tel.replace(/[^\d]{1,}/g,'').replace(/(\d{2})(\d{4,5})(\d{4})/g,"($1) $2-$3");
		thiss.val(tel);

		if(regex.telefone(tel))
			valido(this);
		else
			erro(this);
		
	}).focus(function () {
        textoInput(this, 'campo telefone , somente numeros de 0-9, 11 caracteres');
	});
	
    $('#cadastro input[name=email]').keyup(function () {
        
        var email = $(this).val();

        if (regex.email(email))
            valido(this);
        else
            erro(this);

    }).focus(function () {
        textoInput(this, 'insira um email valido, é necessario uma email ativo para validação de conta, limite de 80 caracteres');
    });

    $('#cadastro input[name=senha1]').keyup(function () {
     
        var senha = $(this).val();

        if (regex.senha(senha))
            valido(this);
        else
            erro(this);

        thiis = $('#cadastro input[name=senha2]');
        var senha2 = thiis.val();

        if (regex.senha(senha) && senha == senha2)
            valido(thiis[0]);
        else
            erro(thiis[0]);

    }).focus(function () {
        textoInput(this, 'somente letras de [A-Z] e numeros de [0-9], de 6 á 16 caracteres');
    });

    $('#cadastro input[name=senha2]').keyup(function () {
       
        var senha1 = $('#cadastro input[name=senha1]').val();
        var senha2 = $(this).val();

        if (regex.senha(senha2) && senha1 == senha2)
            valido(this);
        else
            erro(this);
        
    }).focus(function () {
        textoInput(this, 'confirme sua senha, deve ser igual sua senha anterior');
    });

    $('#cadastro #vsenha').click(function () {

        if ($(this).is(':checked'))
            $('#cadastro input[name^=senha]').attr('type', 'text');
        else
            $('#cadastro input[name^=senha]').attr('type', 'password');
    });

    function getDadosCadastro() {

        return {
            nome: $('#cadastro input[name=nome]').val(),
            cpf: $('#cadastro input[name=cpf]').val(),
            rg: $('#cadastro input[name=rg]').val(),
            cep: $('#cadastro input[name=cep]').val(),
            endereco: $('#cadastro input[name=endereco]').val(),
            bairro: $('#cadastro input[name=bairro]').val(),
            estado: $('#cadastro select[name=estado] option:selected').val(),
            telefone: $('#cadastro input[name=telefone]').val(),
            email: $('#cadastro input[name=email]').val(),
            senha1: $('#cadastro input[name=senha1]').val(),
            senha2: $('#cadastro input[name=senha2]').val()
        };
    };

    function valErro() {

        var dados = getDadosCadastro();

        if (!regex.nome(dados.nome)) {
            erro('#cadastro input[name=nome]');
        }
        if (!regex.cpf(dados.cpf)) {
            erro('#cadastro input[name=cpf]');
        }
        if (!regex.rg(dados.rg)) {
            erro('#cadastro input[name=rg]');
        }
        if (!regex.cep(dados.cep)) {
            erro('#cadastro input[name=cep]');
        }
		if (!regex.endereco(dados.endereco)) {
            erro('#cadastro input[name=endereco]');
        }
        if (!regex.bairro(dados.bairro)) {
            erro('#cadastro input[name=bairro]');
        }
        if (!regex.estado(dados.estado)) {
            erro('#cadastro select[name=estado]');
        }
        if (!regex.telefone(dados.telefone) ){
            erro('#cadastro input[name=telefone]');
        } 
		if (!regex.email(dados.email)) {
            erro('#cadastro input[name=email]');
        }
		if (!regex.senha(dados.senha1)) {
            erro('#cadastro input[name=senha1]');
        }
        if (!regex.senha(dados.senha2)) {
            erro('#cadastro input[name=senha2]');
        }
        if (dados.senha1 != dados.senha2) {
            erro('#cadastro input[name=senha1]');
        }
    };

    $('#cadastro #fazerCadastro').click(function () {
        var dados = getDadosCadastro();
		
        if (
			regex.nome(dados.nome) && 
			regex.cpf(dados.cpf) && 
			regex.rg(dados.rg) && 
			regex.cep(dados.cep) && 
			regex.endereco(dados.endereco) && 
			regex.bairro(dados.bairro) && 
			regex.estado(dados.estado) && 
			regex.telefone(dados.telefone) && 
			regex.email(dados.email) && 
			regex.senha(dados.senha1) && 
			regex.senha(dados.senha2) && 
			dados.senha1 == dados.senha2
		) {
            $.ajax({
                url: '',
                method: 'POST',
                data: {
                    efetuarCadastro: true,
                    dados:dados
                }
            }).done(function (re) {
				var retorno = re.trim();
				$('header').html(re)
				if( retorno == 'validacao'){
					alert('vereficque seu dados');
					valErro();
				}else if( retorno == 'cpf'){
					alert('seu cpf ja possui cadastro em nosso sistema');
					erro('#cadastro input[name=cpf]');
				}else if( retorno == 'rg'){
					alert('seu rg ja possui cadastro em nosso sistema');
					erro('#cadastro input[name=rg]');
				}else if( retorno == 'email'){
					alert('seu email ja possui cadastro em nosso sistema');
					erro('#cadastro input[name=email]');
				}else if( retorno == 'inserir')
					alert('erro no sistema não foi possivel efetuar seu cadastro tente novamente por favor!');
				else if(retorno > 0){
					var html = '<div style="margin:15% auto">'+
						'<h2>Para ativar sua conta em nosso site, acesse seu email para poder confirmar seu cadastro.</h2>'+
						'<h3> o email de verificação é valido por 2 horas <h3>'+
						'<h4>não recebeu nenhum email ? <button id="reenviarEmail" value="'+retorno+'">reenviar</button><h4>'+
						'</div>';
						
					$('#cadastro').html(html);
				}
               
            });
        } else
            valErro();
    });
	
	$("#cadastro").delegate("#reenviarEmail","click",function(){
		var tis = $(this);
		var reenvio  = tis.attr('value');
		tis.text('enviando ...');
		
		$.ajax({
			url: '',
			method: 'POST',
			data: {
				reenviarEmail: true,
				reenvio:reenvio
			}
		}).done(function (re) {
			tis.text('reenviar');
			alert(re)
		})
	});
});