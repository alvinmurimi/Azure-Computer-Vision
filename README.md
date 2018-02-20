# Azure-Computer-Vision
A PHP wrapper for Microsoft Azure computer vision

Usage:

Image Recognition

<?php
require 'azure.php';

$image_url="";
$azure=new Computer_Vision();
$image_description=$azure->image($image_url);
echo $image_description;
?>

Celebrity Pics Recognition

<?php
require 'azure.php';

$image_url="";
$azure=new Computer_Vision();
$image_description=$azure->celeb($image_url);
echo $image_description;
?>

Optical Character Recognition

<?php
require 'azure.php';

$image_url="";
$azure=new Computer_Vision();
$image_description=$azure->ocr($image_url);
echo $image_description;
?>

Landmarks Recognition

<?php
require 'azure.php';

$image_url="";
$azure=new Computer_Vision();
$image_description=$azure->landmarks($image_url);
echo $image_description;
?>
