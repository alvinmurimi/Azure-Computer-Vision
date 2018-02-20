<?php
require 'azure.php';

$image_url="";
$azure=new Computer_Vision();
$image_description=$azure->celeb($image_url);
echo $image_description;
?>