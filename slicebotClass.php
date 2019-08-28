<?php
include("conexion.php");

class slicebot{
	public $pid;
	public $server;
	public $cuenta;
	public $estado;
	public $activo;

	public function guardarActivo($pid, $server, $cuenta,$fecha){
	//public function guardarActivo(){

		$conexion = new Conexion();
		$conn=$conexion->conectarse();
		$ban=false;
		$estado="activo";
		$activo="true";

		$sql = $conn->prepare("INSERT INTO slicebot (pid, server, cuenta, estado, activo, fechaCreado) VALUES (:pid,:server, :cuenta, :estado, :activo, :fechaCreado)");
		$sql->bindParam(':pid', $pid);
		$sql->bindParam(':server', $server);
		$sql->bindParam(':cuenta', $cuenta);
		$sql->bindParam(':estado', $estado);
		$sql->bindParam(':activo', $activo);
		$sql->bindParam(':fechaCreado', $fecha);

		try {

			$sql->execute();
			$ban=true;
			
		}catch(PDOException $e){

	    	echo "Connection failed: " . $e->getMessage()."\n";
	    }

	    if($ban){
			echo "Proceso ".$pid." actualizados.\n";
		}
		$conn=null;
	}

	public function buscarPID($server, $pid){

		$conexion = new Conexion();
		$conn=$conexion->conectarse();
		$sql = $conn->prepare("SELECT * FROM slicebot where pid = '$pid' AND server='$server'");
		$ban=false;
		try {
			$sql->execute();
			$result = $sql->fetchAll();
			foreach ($result as $value) {
				$ban=true;
			}
			//print_r($result);
			
		}catch(PDOException $e){

	    	echo "Connection failed: " . $e->getMessage()."\n";
	    }
	    
	    return $ban;
	}

	public function listarProcesos($server){
		$conexion = new Conexion();
		$conn=$conexion->conectarse();
		$sql = $conn->prepare("SELECT * FROM slicebot where estado= 'activo' AND server='$server'");
		$i=0;
		$ids = array();
		try {
			$sql->execute();
			$result = $sql->fetchAll();
			foreach ($result as $value) {
				$ids[$i]=$value['pid'];
				$i++;
			}
			
		}catch(PDOException $e){

	    	echo "Connection failed: " . $e->getMessage()."\n";
	    }
	    
	    return $ids;
	}

	public function obtenerDuracion($pid){
		$conexion = new Conexion();
		$conn=$conexion->conectarse();
		$sql = $conn->prepare("SELECT fechaCreado FROM slicebot where pid = '$pid'");
		try {
			$sql->execute();
			$result = $sql->fetchAll();
			foreach ($result as $value) {
				$fecha=$value['fechaCreado'];
			}
			
		}catch(PDOException $e){

	    	echo "Connection failed: " . $e->getMessage()."\n";
	    }

	    $datetime1 = new DateTime($fecha);
		$datetime2 = new DateTime("now");
		$interval = $datetime1->diff($datetime2);
		$duracion = self::get_format($interval);
		//echo $interval->format('%R%a días');

		//echo get_format($interval)."\n";
	    
	    return $duracion;
	    
	    //echo $result;
	}

	

	public function updateFecha($pid, $fecha){
		$conexion = new Conexion();
		$conn=$conexion->conectarse();

		//"UPDATE MyGuests SET lastname='Doe' WHERE id=2";

		//Obtener duracion

		$duracion=self::obtenerDuracion($pid);

		$sql = $conn->prepare("UPDATE slicebot SET estado = 'activo', fecha = '$fecha' , duracion = '$duracion' where pid = '$pid'");
		$ban=false;
		try {

			$sql->execute();
			$ban=true;
			
		}catch(PDOException $e){

	    	echo "Connection failed: " . $e->getMessage()."\n";
	    }
	    
	    return $ban;
	}

	public function desactivarPid($pid, $fecha){
		$conexion = new Conexion();
		$conn=$conexion->conectarse();
		//"UPDATE MyGuests SET lastname='Doe' WHERE id=2";
		$sql = $conn->prepare("UPDATE slicebot SET estado = 'inactivo', fecha = '$fecha' where pid = '$pid'");
		$ban=false;
		try {

			$sql->execute();
			$ban=true;
			
		}catch(PDOException $e){

	    	echo "Connection failed: " . $e->getMessage()."\n";
	    }
	    
	    return $ban;
	}


	public function buscarCuenta($pid, $server){
		$conexion = new Conexion();
		$conn=$conexion->conectarse();
		$sql = $conn->prepare("SELECT * FROM slicebot where pid= '$pid' AND server='$server'");
		$i=0;
		$cuentas = array();
		try {
			$sql->execute();
			$result = $sql->fetchAll();
			foreach ($result as $value) {
				$cuentas[$i]=$value['cuenta'];
				$i++;
			}
			
		}catch(PDOException $e){

	    	echo "Connection failed: " . $e->getMessage()."\n";
	    }
	    
	    return $cuentas;
	}

	function get_format($df) {

	    $str = '';
	    $str .= ($df->invert == 1) ? ' - ' : '';
	    if ($df->y > 0) {
	        // years
	        $str .= ($df->y > 1) ? $df->y . ' Anios ' : $df->y . ' Anio ';
	    } 
	    if ($df->m > 0) {
	        // month
	        $str .= ($df->m > 1) ? $df->m . ' Meses ' : $df->m . ' Mes ';
	    } 
	    if ($df->d > 0) {
	        // days
	        $str .= ($df->d > 1) ? $df->d . ' Dias ' : $df->d . ' Dia ';
	    } 
	    if ($df->h > 0) {
	        // hours
	        $str .= ($df->h > 1) ? $df->h . ' Horas ' : $df->h . ' Horas ';
	    } 
	    if ($df->i > 0) {
	        // minutes
	        $str .= ($df->i > 1) ? $df->i . ' Minutos ' : $df->i . ' Minuto ';
	    } 
	    if ($df->s > 0) {
	        // seconds
	        $str .= ($df->s > 1) ? $df->s . ' Segundos ' : $df->s . ' Segundo ';
	    }

	    return $str;
	}
}

?>