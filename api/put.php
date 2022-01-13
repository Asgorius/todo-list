<?php
$url = "http://localhost/api/todos/1"; // edit product 1
$data = array('titre' => 'titre curl', 'description' => 'curl description', 'modified' => date('Y-m-d H:i:s'));
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
$response = curl_exec($ch);
var_dump($response);
if (!$response) 
{
    return false;
}
?>