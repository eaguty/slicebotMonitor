<?php

include('Net/SSH2.php');

$ssh = new Net_SSH2('10.64.17.96');
$ssh->login('verizonusr', 'str34m1ng0nl1n32019..');

$ssh->read('[prompt]');
$ssh->write("sudo cp /var/www/html/uplynk/*.php /home/videoonline/uplynk_slicer/\n");
$ssh->read('Password:');
$ssh->write("str34m1ng0nl1n32019..\n");
echo $ssh->read('[prompt]');
?>