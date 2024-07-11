

$('#btnBuscarPublicacion').click(function(){

	$('#tblPublicaciones').html(
			'<table id="tblPublicaciones" class="table table-bordered">'+
			'<tr>'+
                  '<th style="width: 10px">#</th>'+
                  '<th>Categoria</th>'+
                  '<th>Titulo</th>'+
                  '<th>Resumen</th>'+
                  '<th>Fecha</th>'+
                  '<th style="width: 40px">imagen</th>'+
             '</tr>'
      );

	$.post(baseurl+"cpublicacion/getPubliPanelList",
		function(data){
			var p= JSON.parse(data);
			$.each(p,function(i,item){
				$('#tblPublicaciones').append(
					'<tr>'+
						'<td>1</td>'+
						'<td>'+item.descripcion+'</td>'+
						'<td>'+item.titulo+'</td>'+
						'<td>'+item.resumen+'</td>'+
						'<td>'+item.fechaPublicacion+'</td>'+
						'<td>'+item.imagen+'</td>'+
					'</tr>'


					);
			});

		});
});

//listar tabla

$.post(baseurl+"cpublicacion/getPubliPanel",
		{estado:1},
		function(data){
			var obj= JSON.parse(data);
			var output='';
			$.each(obj,function(i,item){
					output+=
					'<tr>'+
						'<td>1</td>'+
						'<td>'+item.descripcion+'</td>'+
						'<td>'+item.titulo+'</td>'+
						'<td>'+item.resumen+'</td>'+
						'<td>'+item.fechaPublicacion+'</td>'+
						'<td>'+item.imagen+'</td>'+
					'</tr>'
					});
				$('#tblPublicaciones tbody').append(output);
		});

$('#txtBuscarPublicacion').keyup(function(){

	//$('#txtBuscado')=$('#txtBuscarPublicacion').val();

		$('#tblPublicaciones').html(
			'<table id="tblPublicaciones" class="table table-bordered">'+
			'<tr>'+
                  '<th style="width: 10px">#</th>'+
                  '<th>Categoria</th>'+
                  '<th>Titulo</th>'+
                  '<th>Resumen</th>'+
                  '<th>Fecha</th>'+
                  '<th style="width: 40px">imagen</th>'+
             '</tr>'
      );

	var txtBuscar = ($('#txtBuscarPublicacion').val());

	$.post(baseurl+"cpublicacion/getPubliPanel",
		{estado:'1',texto:txtBuscar},
		function(data){
			var obj= JSON.parse(data);
			var output='';
			$.each(obj,function(i,item){
					output+=
					'<tr>'+
						'<td>1</td>'+
						'<td>'+item.descripcion+'</td>'+
						'<td>'+item.titulo+'</td>'+
						'<td>'+item.resumen+'</td>'+
						'<td>'+item.fechaPublicacion+'</td>'+
						'<td>'+item.imagen+'</td>'+
					'</tr>'
					});
				$('#tblPublicaciones tbody').append(output);
		});
});

