<?php
require 'azure.php';

$image_url="https://cutecats.com/wp-content/uploads/2015/03/lily_5-515x276.jpg";
$azure=new Computer_Vision();
$image_description=$azure->image($image_url);
echo $image_description;
?>