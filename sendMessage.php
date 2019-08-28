<?php

include("telegram.php");

$telegram=new Telegram();
$token = "933407943:AAH_mUF4qFeqp1b8hec9XXPvhEfyEScH2Mg";
$chatid = "@videoOnlineTVA";
$resultado=$telegram->sendMessage($chatid, "Mensaje Automatico", $token);
echo($resultado);

?>
