<?php
// Command process
session_start();

$input = strtoupper(strip_tags($_REQUEST['command']));

if(!empty($input)){
	$command = getCommand($input);

	if($command){
		switch( $command[0] ){
			case 'PLACE':
				$coord = validateCoord($command);
				if(!$coord){
					$return['msg'] = error('place');
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
				$return['msg'] = error('command');
				break;
		}
	}else{
		$return['msg'] = error('command');
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

// function to validate coordinate within table
function validateTable($x, $y){
	return ( $x >= 0 && $x < 5 && $y >= 0 && $y < 5 );
}

function place($x, $y, $facing){
	$direction = ['NORTH', 'SOUTH', 'WEST', 'EAST'];
	// validate x,y within table
	if( validateTable($x, $y) ){
		// validate facing direction within selection
		if( in_array($facing, $direction) ){
			// set robot position in session
			$_SESSION['robot'] =  ['x' => $x, 'y' => $y, 'facing' => $facing];
			$msg = 'YOU HAD PLACED YOUR ROBOT !';
		}else{
			$msg = error('direction');
		}
	}else{
		$msg = error('out');
	}
	return $msg;
}

// function to move the robot 1 step forward to it's facing direction
function move(){
	if(isset($_SESSION['robot'])){
		$reset = $_SESSION['robot'];

		switch($_SESSION['robot']['facing']){
			case 'NORTH' : $_SESSION['robot']['y'] += 1;
			break;
			case 'SOUTH' : $_SESSION['robot']['y'] -= 1;
			break;
			case 'EAST' : $_SESSION['robot']['x'] += 1;
			break;
			case 'WEST' : $_SESSION['robot']['x'] -= 1;
			break;
			default: error('direction');
			break;
		}

		if( !validateTable( $_SESSION['robot']['x'],  $_SESSION['robot']['y']) ){
			$_SESSION['robot'] = $reset;
		}
		return (  $_SESSION['robot'] !== $reset ? 'YOUR ROBOT HAS MADE A MOVE FORWARD' : error('out') );
	}else{
		return error('noRobot');
	}
}

// function to turn the robot direction to it's left
function left(){
	if(isset($_SESSION['robot'])){
		switch($_SESSION['robot']['facing']){
			case 'NORTH' : $_SESSION['robot']['facing'] = 'WEST';
			break;
			case 'SOUTH' :$_SESSION['robot']['facing'] = 'EAST';
			break;
			case 'EAST' : $_SESSION['robot']['facing'] = 'NORTH';
			break;
			case 'WEST' : $_SESSION['robot']['facing'] = 'SOUTH';
			break;
			default: error('direction');
			break;
		}
		return 'YOUR ROBOT HAS MADE A LEFT TURN';
	}else{
		return error('noRobot');
	}
}

// function to turn the robot direction to it's right
function right(){
	if(isset($_SESSION['robot'])){
		switch($_SESSION['robot']['facing']){
			case 'NORTH' : $_SESSION['robot']['facing'] = 'EAST';
			break;
			case 'SOUTH' :$_SESSION['robot']['facing'] = 'WEST';
			break;
			case 'EAST' : $_SESSION['robot']['facing'] = 'SOUTH';
			break;
			case 'WEST' : $_SESSION['robot']['facing'] = 'NORTH';
			break;
			default: error('direction');
			break;
		}
		return 'YOUR ROBOT HAS MADE A RIGHT TURN';
	}else{
		return error('noRobot');
	}
}

function report(){
	return ( isset($_SESSION['robot']) ? implode(', ', $_SESSION['robot']) : error('noRobot') );
}

// function to set all type of error message
function error($type = 'default'){
	$msg = [
		'command' => 'INVALID COMMAND. THE VALID COMMAND ARE PLACE | MOVE | LEFT | RIGHT | REPORT. PLEASE TRY AGAIN.',
		'place' => 'INVALID COMMAND. THE VALID OPTION FOR PLACE COMMAND ARE [ PLACE X-COORD,Y-COORD,DIRECTION ]. PLEASE TRY AGAIN.',
		'direction' => 'INVALID COMMAND. THE VALID DIRECTION ARE NORTH | SOUTH | WEST | EAST. PLEASE TRY AGAIN.',
		'out' => 'OUT OF TABLE. COMMAND CANCELLED.',
		'noRobot' => 'NO ROBOT FOUND ON THE TABLE',
		'default' => 'INVALID ACTION !'
	];
	return $msg[$type];
}

?>