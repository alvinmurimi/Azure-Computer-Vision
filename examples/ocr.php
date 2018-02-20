<?php
require 'azure.php';

$image_url="";
$azure=new Computer_Vision();
$image_description=$azure->ocr($image_url);
echo $image_description;
?>
