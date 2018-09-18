<?php
require('socket1.php');
$service = 245;
$user_id = (int)$_GET['id'];
if( ! $user_id)
{
    die('not valid');
}
$input = '{"username":"vnnplus","password":"vnnplus&friend","viewerId":"'.$user_id.'"}';
$result =  sendMessage1($service, $input);
echo $result;
exit();