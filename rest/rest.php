<?php
$request_parts = explode('/', $_GET['param']); // array('users', 'show', 'abc')
include('connect.php');

print_r($request_parts);
$output = get_data_from_db(); //Do your processing here
                              //You can outsource to other files via an include/require
?>
