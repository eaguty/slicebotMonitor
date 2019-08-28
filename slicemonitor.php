<?php
include("slicebotClass.php");

$slice=new slicebot();

exec("hostname", $infoServer);

foreach ($infoServer as $servidor) {
	$server=$servidor;
}
exec("pgrep -a python",$procesos);
foreach ($procesos as $process) {
	//echo $process."\n";
	$datos=explode(" ", $process);
	$pid=$datos[0];
	$cuenta=$datos[3];
	$slice->pid=$pid;
	$slice->server=$server;
	$slice->cuenta=$cuenta;
	$slice->guardarActivo($pid,$server,$cuenta);
}



?>