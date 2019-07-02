<?php 
 
$intervaloTempo = $_POST['intervaloTempo'];
$maxServer = $_POST['maxServer'];
$servidorEspecifico = $_POST['servidorEspecifico'];

$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('speedtest');

$query = "INSERT INTO config (intervalo,max_server, url, ultima_alteracao) VALUES ('$intervaloTempo','$maxServer', '$servidorEspecifico', "+date('d-m-Y H:i:s');+") WHERE id=2";

$insert = mysql_query($query,$connect);

echo "<script type="text/javascript">
        alert("+$insert+");
        window.location.href='index.html';
      </script>";        
?>