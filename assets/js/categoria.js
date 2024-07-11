
$.post(baseurl+"categoria/getCat",
	{
		"estado":1
	},
	function (data){
		var c = JSON.parse(data);
		$.each(c,function(i,item){
			$('#cboCat').append('<option value="'+ item.idCategoria+'">'+ item.descripcion+'</option>');
		});
		
	});

