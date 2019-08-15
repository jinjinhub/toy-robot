<?php
// Command process
$input = strtoupper(strip_tags($_REQUEST['command']));

if(!empty($input)){
	$command = getCommand($input);

	if($command){
		switch( $command[0] ){
			case 'PLACE':
				$coord = validateCoord($command);
				if(!$coord){
					$return['msg'] = 'INVALID DIRECTION';
				}else{
					$return['msg'] = place($coord[0], $coord[1], $coord[2]);
				}
				break;
			case 'MOVE':
				$return['msg'] = move();
				break;
			case 'LEFT':
				$return['msg'] = left();
				break;
			case 'RIGHT':
				$return['msg'] = right();
				break;
			case 'REPORT':
				$return['msg'] = report();
				break;
			default:
				$return['msg'] = 'INVALID COMMAND';
				break;
		}
	}else{
		$return['msg'] = 'INVALID COMMAND';
	}
	
	$return['command'] = $input;
	echo json_encode($return);
}else{
	return false;
}
// END Command process


// function to get and validate command from input
function getCommand($command){
	$result = explode(' ', $command);
	if( sizeof($result) !== 1 ){
		if( sizeof($result) !== 2 || $result[0] !== 'PLACE' ){
			return false;
		}
	}
	return $result;
}

// function to get and validate option after [PLACE] command
function validateCoord($command){
	// must be option given after [PLACE]
	if(sizeof($command) > 1){
		$coord = explode(',', $command[1]);
		// option must be 3 phrase exploded by comma
		if( sizeof($coord) == 3 ){
			// first and second option must be number
			if( is_numeric($coord[0]) && is_numeric($coord[1])){
				return $coord;
			}
		}
	}
	return false;
}

function place($x, $y, $facing){
	return 'YOU HAD PLACED YOUR ROBOT !';
}

function move(){
	return 'YOUR ROBOT HAS MADE A MOVE FORWARD';
}

function left(){
	return 'YOUR ROBOT HAS MADE A LEFT TURN';
}

function right(){
	return 'YOUR ROBOT HAS MADE A RIGHT TURN';
}

function report(){
	return 'REPORT ROBOT';
}

?>