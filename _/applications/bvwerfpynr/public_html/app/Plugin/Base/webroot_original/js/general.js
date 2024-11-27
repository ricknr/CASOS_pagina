$(function () {
	$('select.tiene-subopciones').change(function(){
		
		var _this = $(this);
		var valor = _this.val();
		$.getJSON('/' + _this.data('modelo') + '/get_' + _this.data('opciones') + '/'+valor,function(data){
			if (data.code == 100) {
				var select = '.' +  _this.data('opciones') + '-opciones';
				$(select).html('').append('')
				$.each(data.data, function(k, v){
					$(select).append('<option value="'+k+'">'+v+'</option>')
				})				
			}else{
				alert(data.msg)
			}
		});
	});
	
	//$( ".datepicker" ).datepicker();
});