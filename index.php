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
			year: y,
			month: m,
			events: {
				url: 'json.php',
				data: function() { // a function that returns an object
					// dayRender: function (date, cell) { 
						// cell.css("background-color", "red"); 	
					// }
					
					return 1;
				}
			}
			eventBorderColor: 'black', 
			eventMouseover: function(event, jsEvent, view) { 
				$(jsEvent.target).attr('title', event.info); 
				$(this).css('border-color', 'red'); 
			},
			eventMouseout: function(event) { 
				$(this).css('border-color', 'black');
			},
			dayRender: function (date, cell) { 
				cell.css("background-color", "red"); 	
			} 
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