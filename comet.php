<?php
// session_start();

switch($_POST['mode']){
	case 'ini' :
		$_SESSION['stop'] = 0;
		$arrData = getArrData();
		$arrData = json_encode($arrData);
		echo $arrData;

		break;

	case 'chkUpd' :
		$file = file_get_contents('./test.txt');
		$endTime = time() + 30;

		while(1){
			if($file != file_get_contents('./test.txt')){
				$arrData = getArrData();
				$arrData = json_encode($arrData);

				echo $arrData;
				break;
				// echo nl2br(htmlspecialchars(file_get_contents('./test.txt'), ENT_QUOTES));
				// }
			}elseif($endTime < time()){
				$arrData = getArrData();
				$arrData = json_encode($arrData);
				echo $arrData;
				break;
			}
			sleep(0.5);
}

break;

case 'write' :
	file_put_contents('./test.txt', $_POST['txt']."\n", FILE_APPEND|LOCK_EX);

	break;

case 'sset' :
	$arrData = getArrData();
	if(empty($arrData['deck']) || !empty($arrData['shield']) || '0' != $arrData['turn']){
		exit;
	}
	$arrDeck = explode2(',', $arrData['deck']);
	$arrShield = $arrDeck;
	$arrDeck = array_splice($arrShield, 5);

	$arrData['deck'] = implode(',', $arrDeck);
	$arrData['shield'] = implode(',', $arrShield);
	writeArrData($arrData);

	break;

case 'drow' :
	$arrData = getArrData();
	if(empty($arrData['deck'])){
		exit;
	}
	$arrDeck = explode2(',', $arrData['deck']);
	$arrHand = explode2(',', $arrData['hand']);
	$top = array_shift($arrDeck);
	array_push($arrHand, $top);
	$arrData['deck'] = implode(',', $arrDeck);
	$arrData['hand'] = implode(',', $arrHand);
	writeArrData($arrData);

	break;

case 'shuffle' :

	$arrData = getArrData();
	if(empty($arrData['deck'])){
		exit;
	}
	$arrDeck = explode2(',', $arrData['deck']);
	shuffle($arrDeck);
	$arrData['deck'] = implode(',', $arrDeck);
	writeArrData($arrData);

	break;

case 'reset' :
	$arrData = getArrData();
	$arrDeck = explode2(',', $arrData['deck']);
	$arrHand = explode2(',', $arrData['hand']);
	$arrShield = explode2(',', $arrData['shield']);
	$arrDeck = array_merge($arrDeck, $arrHand, $arrShield);

	$arrData['deck'] = implode(',', $arrDeck);
	$arrData['hand'] = '';
	$arrData['shield'] = '';
	writeArrData($arrData);

	break;

case 'stop' :
	$_SESSION['stop'] = 1;

	break;

default:
	break;
}
if(!empty($_POST['mode'])){
	exit;
}

function getArrData(){
	$file = file_get_contents('./test.txt');
	$arrLine = explode("\n", $file);
	foreach($arrLine as $line){
		$arrData = explode('=', $line);
		if(!empty($arrData[0])){
			$arrRetData[$arrData[0]] = $arrData[1];
		}
	}
	return $arrRetData;
}

function writeArrData($arrData){
	$file = '';
	foreach($arrData as $key => $val){
		$file .= $key . '=' . $val . "\n";
	}
	file_put_contents('./test.txt', $file, LOCK_EX);
}

function explode2($delimiter, $str){
	$arrReturn = explode($delimiter, $str);
	$arrReturn = array_filter($arrReturn);
	return $arrReturn;
}

?>