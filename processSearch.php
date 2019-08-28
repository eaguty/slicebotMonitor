<?php
include("slicebotClass.php");

$slice=new slicebot();

exec("hostname", $infoServer);

foreach ($infoServer as $servidor) {
	$server=$servidor;
}
$fecha=date("Y-m-d H:i:s");
$fechaLog=date("YmdHis");

$ids=$slice->listarProcesos($server);
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
			
			$cuentas=$slice->buscarCuenta($id, $server);
			foreach ($cuentas as $key => $cuenta) {
				echo $cuenta."\n";
				$nombreCuenta=explode(".", $cuenta);
				$instruccion="";
				if($nombreCuenta[0] == "azteca")
				{
					//$instruccion= "./slicebot azteca.cfg >/dev/null 2>&1 &";
					$instruccion='sh /home/videoonline/uplynk_slicer/start_azteca.sh >>/var/www/html/uplynk/logAzteca.log 2>&1 &';
				}
				if($nombreCuenta[0] == "deportes")
				{
					$instruccion='sh /home/videoonline/uplynk_slicer/start_deportes.sh >>/var/www/html/uplynk/logDeportes.log 2>&1 &';
				}
				if($nombreCuenta[0] == "noticias")
				{
					$instruccion='sh /home/videoonline/uplynk_slicer/start_noticias.sh >>/var/www/html/uplynk/logNoticias.log 2>&1 &';
				}
				if($nombreCuenta[0] == "adn40")
				{
					$instruccion='sh /home/videoonline/uplynk_slicer/start_adn40.sh >>/var/www/html/uplynk/logAdn40.log 2>&1 &';
				}
				echo $instruccion."\n";
				exec($instruccion, $respuesta);
				print_r($respuesta);

			}
		$desactivado=$slice->desactivarPid($id, $fecha);
		if($desactivado){
			echo "PID: ".$id." desactivado\n";
		}
		else{
			echo "falla en desactivacion del pid: ".$id."\n";
		}
	}
}

?>