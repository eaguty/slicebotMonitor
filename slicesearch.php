<?php
include("slicebotClass.php");

$slice=new slicebot();

exec("hostname", $infoServer);

foreach ($infoServer as $servidor) {
	$server=$servidor;
}
$fecha=date("Y-m-d H:i:s");

exec("pgrep -a python",$procesos);
foreach ($procesos as $process) {
	//echo $process."\n";
	$datos=explode(" ", $process);
	$pid=$datos[0];
	$cuenta=$datos[3];
	$busqueda=$slice->buscarPID($server, $pid);
	if($busqueda){
		echo "pid encontrado: ".$pid."\n";
		$actualizado=$slice->updateFecha($pid,$fecha);
		if($actualizado){
			echo "Proceso Actualizado.\n";
		}
		else{
			echo "Proceso no actualizado.\n";
		}

	}
	else{
		echo "pid No encontrado: ".$pid."\n";	
		$slice->guardarActivo($pid,$server,$cuenta, $fecha);
	}

}

// Formato de la fecha y hora 2019-08-02 06:27:30



?>