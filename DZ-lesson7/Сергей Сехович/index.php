<?php

function __autoload($classname) {
	// C_Articles
	if ($classname[0] . $classname[1] == 'C_') {
		include_once("controller/$classname.php");
	}

	// M_Articles
	if ($classname[0] . $classname[1] == 'M_') {
		include_once("model/$classname.php");
	}
}

$action = 'action_';
//$action .= (isset($_GET['act'])||isset($_GET['id'])) ? $_GET['act'] : 'index';
if (isset($_GET['act'])) {
	$action .=$_GET['act'];
	if (isset($_GET['id'])) {
		$id =$_GET['id'];
	}
}
else{
	$action .='all';
}
//var_dump($action);
/*var_dump($_GET['id']);
var_dump($_GET['c']);

*/
$c = isset($_GET['с']) ? $_GET['с'] : '';

	switch ($c) {
		case 'articles':
			$controller = new C_Articles();
			break;
		
		default:
			$controller = new C_Articles();
			break;
	}



$controller->Request($action);

