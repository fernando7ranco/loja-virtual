$(document).ready(function () {

	$('body').delegate('.btProdutoFavorito','click',function(){
		
		var thisBt =  $(this);
		var dados = {
			acao:'ajaxFuncaoProdutoFavorito',
			idProduto: thisBt.attr('value')
		}
		
		$.ajax({
			url: '../model/funcoes/funcoesAjax.php',
			method: 'POST',
			data: dados
		}).done(function(re){
			retorno = parseInt(re);
			
			if(retorno)
				thisBt.find('div').attr('id','foco');
			else
				thisBt.find('div').removeAttr('id');
			
			$('#titleTooltip').remove();
		});
		
	}).delegate('.btProdutoFavorito','mouseover',function(){
		
		if($(this).find('#foco').length == 0)
			var texto = 'adicionar aos favoritos';
		else
			var texto = 'remove dos favoritos';
		
        $('body').append("<span id='titleTooltip'>" + texto + "</span>");
        $('#titleTooltip').fadeIn(555);
		
	}).delegate('.btProdutoFavorito','mouseout',function(){
		$('#titleTooltip').remove();
		
    }).delegate('.btProdutoFavorito','mousemove',function (e) {
		var mousex = e.pageX + 20;
		var mousey = e.pageY + 20;

		$('#titleTooltip').css({top: mousey, left: mousex});
	});

   
});