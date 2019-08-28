<?php
include("slicebotClass.php");

$slice=new slicebot();
$fecha= $slice->obtenerDuracion('84795');
echo $fecha."\n";



?>