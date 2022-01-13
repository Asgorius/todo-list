<?php
  $url = 'http://localhost/api/todos';
  $data = array('titre' => 'Post titre', 'description' => 'test post', 'modified' => date('Y-m-d H:i:s'));
  $options = array(
    'http' => array(
      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      'method'  => 'POST',
      'content' => http_build_query($data)
    )
  );
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
  if ($result === FALSE) { /* Handle error */ }
  var_dump($result);
?>