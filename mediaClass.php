<?php

include("conexion.php");


class media{
	public $pid;
	public $name;
	public $fecha;
	public $fechaCreado;
	public $estado;
	public $server;

	public function guardarActivo($pid, $name, $fecha, $fechaCreado, $server, $cuenta){
	//public function guardarActivo(){

		$conexion = new Conexion();
		$conn=$conexion->conectarse();
		$ban=false;
		$estado="activo";

		$sql = $conn->prepare("INSERT INTO media (pid, name, fecha, fechaCreado, estado, server, cuenta) VALUES (:pid, :name, :fecha, :fechaCreado, :estado, :server, :cuenta)");
		$sql->bindParam(':pid', $pid);
		$sql->bindParam(':name', $name);
		$sql->bindParam(':fecha', $fecha);
		$sql->bindParam(':fechaCreado', $fechaCreado);
		$sql->bindParam(':estado', $estado);
		$sql->bindParam(':server', $server);
		$sql->bindParam(':cuenta', $cuenta);


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
		$sql = $conn->prepare("SELECT * FROM media where pid = '$pid' AND server='$server'");
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

	public function listarMedia($server){
		$conexion = new Conexion();
		$conn=$conexion->conectarse();
		$sql = $conn->prepare("SELECT * FROM media where estado= 'activo' AND server='$server'");
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

	public function updateFecha($pid, $fecha){
		$conexion = new Conexion();
		$conn=$conexion->conectarse();
		//"UPDATE MyGuests SET lastname='Doe' WHERE id=2";
		$sql = $conn->prepare("UPDATE media SET estado = 'activo', fecha = '$fecha' where pid = '$pid'");
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
		$sql = $conn->prepare("UPDATE media SET estado = 'inactivo', fecha = '$fecha' where pid = '$pid'");
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
}

?>