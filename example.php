<?php
require 'azure.php';
$azure = new Computer_Vision();
$image_url = "";

// Comment the part of the code that you don't need

//analyze a normal image
$image = $azure->recognize($image_url,"image");
//analyze a celebrity image
$celebrity = $azure->recognize($image_url,"celebrity");
//analyze a landmark
$landmark = $azure->recognize($image_url,"landmark");
//extract text, OCR
$ocr = $azure->recognize($image_url,"ocr");

echo $image;

echo $celebrity;

echo $landmark;

echo $ocr;
?>