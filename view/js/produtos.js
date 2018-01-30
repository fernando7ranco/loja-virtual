$(document).ready(function () {
	
   $('#paginalizacao a').click(function () {
		var num = $(this).text();
		
		var pn = window.location.pathname.split('/').pop();
		pn = pn.replace(/&pag=([0-9])$/i, '');
		
		window.location.href = pn + '&pag='+ num;
	
	});
	
});