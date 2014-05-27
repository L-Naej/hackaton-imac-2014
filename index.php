<!DOCTYPE html>
<html>
<head>
<link href='calendar/fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='calendar/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='calendar/lib/jquery.min.js'></script>
<script src='calendar/lib/jquery-ui.custom.min.js'></script>
<script src='calendar/fullcalendar/fullcalendar.js'></script>

<script href="text/javascript">
	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: true,
			year: y,
			month: m, // August
			events: "json.php",
		});
	});
</script>

<style>

	body {
		margin-top: 40px;
		text-align: center;
		font-size: 14px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		}

	#calendar {
		width: 900px;
		margin: 0 auto;
		}

</style>
</head>

<body>
<?php
echo "salut test: <br />";

echo "<div id='calendar'></div>";

?>
</body>
</html>