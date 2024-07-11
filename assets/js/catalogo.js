$('#txtBuscarCatalogo').keyup(function(){

	var text=$('#txtBuscarCatalogo').val();

	var lt=$('#txtBuscarCatalogo').val().length;
	if(lt >=3){
	$.post(baseurl+"cie10/getCatalogo",
		{txtdirectorio:text},
		function(data){
				//console.log(data);
				var obj = JSON.parse(data);
				
				var output='';
				$.each(obj, function(i,item){
					
					output+=
					'<tr>'+
						'<td>'+item.codigo +'</td>'+
						'<td>'+item.descripcion +'</td>'+
					'</tr>';

				});
				$('#tblcatalogo tbody').html(output);
		});
	}
});