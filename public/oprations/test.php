<?php
header('Content-Type: application/json');

$data = ["name" => "mb", "age" => 25];

echo json_encode($data);
?>