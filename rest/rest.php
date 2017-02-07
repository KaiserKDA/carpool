<?php
$request_parts = explode('/', $_SERVER['REQUEST_URI']); // array('users', 'show', 'abc')
include('connect.php');

$output = get_data_from_db(); //Do your processing here
                              //You can outsource to other files via an include/require
$file_type = $_GET['type'];
//Output based on request
switch($file_type) {
    case 'json':
        echo json_encode($output);
        break;
    case 'xml':
        echo xml_encode($output); //This isn't a real function, but you can make one
        break;
    default:
        echo $output;
}
?>
