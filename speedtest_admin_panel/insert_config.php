<?php 
 
$intervaloTempo = $_POST['intervaloTempo'];
$maxServer = $_POST['maxServer'];
$servidorEspecifico = $_POST['servidorEspecifico'];


	try {
	  $pdo = new PDO('mysql:host=localhost;dbname=speedtest', "root", "");
	  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	   
	  if ($maxServer == ""){
	  	$maxServer = 0;
	  }
	   date_default_timezone_set('America/Manaus');

	  $stmt = $pdo->prepare("UPDATE config SET intervalo = :intervaloTempo, max_server = :maxServer, url= :servidorEspecifico, ultima_alteracao = :date_ WHERE id=:id");
	  $stmt->execute(array(
	  	':id'=> 2,
	    ':intervaloTempo' => $intervaloTempo,
	    ':maxServer' => $maxServer,
	    ':servidorEspecifico' => $servidorEspecifico,
	    ':date_' => date('d/m/Y h:i:s')
	  ));

	  echo "<script>
	        alert('Configuração alterada');
	        window.location.href='index.php';
	      </script>";  

	} catch(PDOException $e) {
	  echo 'Error: ' . $e->getMessage();
	}


?>

