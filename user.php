<?php
exec("whoami", $infoServer);
foreach ($infoServer as $servidor) {
	echo $servidor."\n";
}
?>