<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='<?= base_url();?>assets/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
<link href='<?= base_url();?>assets/fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='<?= base_url();?>assets/fullcalendar/lib/moment.min.js'></script>
<script src='<?= base_url();?>assets/fullcalendar/lib/jquery.min.js'></script>
<script src='<?= base_url();?>assets/fullcalendar/fullcalendar.min.js'></script>
<script src='<?= base_url();?>assets/fullcalendar/locale/es.js'></script>
<script>

  $(document).ready(function() {

  	$.post(baseurl+"calendario/getMarcacion",
		//{txtdirectorio:text},
				function(data){
				//	alert(data);
				// var obj = JSON.parse(data);
				
				// var output='';
				// $.each(obj, function(i,item){
					
				// 	output+=
				// 	'<tr>'+
				// 		'<td>'+item.codigo +'</td>'+
				// 		'<td>'+item.descripcion +'</td>'+
				// 	'</tr>';

				// });
				// $('#tblcatalogo tbody').html(output);
		

	    $('#calendar').fullCalendar({
	      header: {
	        left: 'prev,next today',
	        center: 'title',
	        right: 'month,basicWeek,basicDay'
	      },
	      defaultDate: Date(),
	      navLinks: true, // can click day/week names to navigate views
	      editable: false,
	      eventLimit: true, // allow "more" link when too many events
	      events: $.parseJSON(data)
	    });
	 });

  // 	$.post(baseurl+"calendario/getData",
		// //{txtdirectorio:text},
		// 		function(data){
		// 			alert(data);
  
	 // });

  });

</script>
<style>

  body {
    margin: 40px 10px;
    padding: 0;
    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

</style>
</head>
<body>

  <div id='calendar'></div>
  <script type="text/javascript">
      var baseurl= "<?= base_url(); ?>";
    </script>

</body>
</html>
