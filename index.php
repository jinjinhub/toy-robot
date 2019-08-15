<html>
	<head>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
		<script type="text/javascript">
		    $( document ).ready(function() {
		    	$('#game_command_form').submit( function(e){
		    		e.preventDefault();
		    		$.ajax({
		    		    type:'POST',
		    		    url:'gameController.php',
		    		    data:$(this).serialize(),
		    		    dataType:'json',
		    		    success: function(data){
	    		    		$('.game__board').append('<p>>>> '+data['command']+'</p>');
	    		    		$('.game__board').append('<p> '+data['msg']+'</p>');
	    		    		$('#game_command_form')[0].reset();
		    		    },
		    		    error: function() {
		    		        alert('We are sorry! Service temporarily unavailable. Please contact support @ angsuijin@gmail.com.');
		    		    }
		    		});
		        });
		    });
		</script>
	</head>
	<body>
		<div class="game__board"></div>
		<br />
		<form id="game_command_form" name="game_command_form" action="#" method="post">
			Enter Command: <input type="text" name="command" required/>
		</form>
	</body>
</html>