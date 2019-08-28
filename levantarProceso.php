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
	//echo $id."\n";
	exec("ps ".$id, $ps);
	$res= sizeof($ps);
	$ps=null;
	if($res>=2){
		//echo "Proceso Activo\n";
		$cuentas=$slice->buscarCuenta($id, $server);
			foreach ($cuentas as $key => $cuenta) {
				echo $cuenta."\n";
				$nombreCuenta=explode(".", $cuenta);
				echo "/home/videoonline/uplynk_slicer/./slicebot ".$cuenta." > /home/videoonline/uplynk_slicer/logs/".$nombreCuenta[0].$fechaLog.".log &";
			}
	}
	


}


?>