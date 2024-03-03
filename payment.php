<?php 
include 'php/barcode.php';
    
$generator = new barcode_generator();
$format = 'PNG';
$symbology = 'qr';
$data = 'https://www.facebook.com/Junjie.Gregory/';
$option = 'qrcode';
$generator->output_image($format, $symbology, $data, $options);