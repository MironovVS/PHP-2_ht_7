<?php
function clear_string($cl_str){
$cl_str=strip_tags($cl_str);
$cl_str=mysqli_escape_string(getDbConnect(), $cl_str);
$cl_str=trim($cl_str);

return $cl_str;
}

function maxsite_str_word($text, $counttext = 10, $sep = ' ') {
    $words = explode($sep, $text);
    if ( count($words) > $counttext )
        $text = join($sep, array_slice($words, 0, $counttext));
    return $text;
}

function clear_article($text){
  $text  = preg_replace('| +|', ' ', $text);
  $order = array("\r\n", "\n", "\r","&amp;","&quot;","&#039;","&lt;","&gt;","\\","quot;");
  $text  =str_replace($order,' ', $text);
 //$text = htmlspecialchars($text);

  return $text;  
}
function total_rows_base(){
	$sql="SELECT count(*) FROM `article`";
  	$result = mysqli_query(getDbConnect(), $sql);
  	$row=mysqli_fetch_row($result);
	$total_rows=$row[0];
	return $total_rows;
}
