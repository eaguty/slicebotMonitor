<?php

include("mediaClass.php");
exec("hostname", $infoServer);

$video = new media();

foreach ($infoServer as $servidor) {
	$server=$servidor;
}
exec("pgrep -a slicer", $procesos);
//$media=explode(" ",$cadena);
$fecha=date("Y-m-d H:i:s");

foreach ($procesos as $process) {
	$media=explode(" ",$process);
	$pid= $media[0];
	if($video->buscarPID($server, $pid)== true)
	{
		$video->updateFecha($pid, $fecha);
	}
	else{
		
		$name = explode("/", $media[2]);
		$nombre	= $name[sizeof($name)-1];
		$cuenta = $name[5];
		echo "pid: ".$pid."\n";
		echo "nombre: ".$nombre."\n";
		$video->guardarActivo($pid, $nombre, $fecha, $fecha, $server, $cuenta);
	}
}

$ids=$video->listarMedia($server);
foreach ($ids as $id) {
	echo $id."\n";
	exec("ps ".$id, $ps);
	$res= sizeof($ps);
	$ps=null;
	if($res>=2){
		echo "Proceso Activo\n";
	}
	else{
		echo "Proceso Inactivo\n";
		$desactivado=$video->desactivarPid($id, $fecha);
		if($desactivado){
			echo "PID: ".$id." desactivado\n";
		}
		else{
			echo "falla en desactivacion del pid: ".$id."\n";
		}
	}
}

?>
