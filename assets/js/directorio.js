$('#txtBuscarDirectorio').keyup(function(){

	var text=$('#txtBuscarDirectorio').val();



	$.post(baseurl+"directorio/getDirectorio",
		{txtdirectorio:text},
		function(data){
				//console.log(data);
				var obj = JSON.parse(data);
				
				var output='';

				$.each(obj, function(i,item){
					
					output+=
					'<tr>'+
						'<td style="text-align:center">'+item.anexo +'</td>'+
						'<td>'+item.area +'</td>'+
						'<td>'+item.ambiente +'</td>'+
						'<td style="text-align:center">'+item.sector +'</td>'+
						'<td style="text-align:center">'+item.senalitica +'</td>'+
					'</tr>';

				});
					$('#tbldirectorio').html(
						    '<table id="tbldirectorio" class="table table-bordered">'+
						    '<tr>'+
			                  '<th style="text-align:center">ANEXO</th>'+
			                  '<th style="text-align:center">UPSS/UPS/AREA</th>'+
			                  '<th style="text-align:center">AMBIENTE</th>'+
			                  '<th style="text-align:center">SECTOR</th>'+
			                  '<th style="text-align:center">SEÑALITICA</th>'+
			                 
			                '</tr>' + output
					);
				//$('#tbldirectorio tbody').html(output);
		});
});