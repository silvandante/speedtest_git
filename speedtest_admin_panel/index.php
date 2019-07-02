<?php
  $pdo = new PDO('mysql:host=localhost;dbname=speedtest', "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if (isset($_GET['tabela'])) {
    try {
      $qryConfig = $pdo->query("SELECT * FROM config WHERE id=2");   
      $qryCurrentConnection = $qryConfig->fetch(PDO::FETCH_ASSOC);
      echo json_encode($qryCurrentConnection);
    }catch(Exception $e) {
      echo 'alert(Exception -> )'.$e->getMessage();
    }
    exit();
   }

  if (isset($_POST['insert_config'])) {
    $intervaloTempo = $_POST['intervalo'];
    $maxServer = $_POST['maxServer'];
    $servidorEspecifico = $_POST['serverURL'];

       $intervalQry = $pdo->query("SELECT * FROM config WHERE id=2");   
          $qryConfig = $intervalQry->fetch(PDO::FETCH_ASSOC);
          $configJson = json_encode($qryConfig);
          $config = json_decode($configJson);

    try {

      if (empty($intervaloTempo)){
          $intervaloTempo = $config->intervalo;
           
      }

      if ($maxServer == ""){
        $maxServer = $config->max_server;
      }

      if ($servidorEspecifico==""){
        $servidorEspecifico=$config->url;
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

  
    } catch(PDOException $e) {
      echo 'ErrorAQUIE: ' . $e->getMessage();
    }
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Speedtest - Dashboard</title>
  <link href="css/bootoast.css" rel="stylesheet" type="text/css">
  <!-- Custom fonts for this template-->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.html">Speedtest Dashboard</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fa fa-bar-chart"></i>
    </button>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" id="openConfig" href="index.php">
          <i class="fa fa-gear"></i>
          <span>Configuração</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="openConnections" href="conexoes.php">
          <i class="fa fa-wifi"></i>
          <span>Conexões</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="openCharts" href="charts.php">
          <i class="fa fa-area-chart"></i>
          <span>Relatórios</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.html">
          <i class="fa fa-code"></i>
          <span>Sobre</span></a>
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Configuração Speedtest</li>
        </ol>

        <!-- Icon Cards-->
        <div class="row">
          <div class="col-xl-4 col-sm-6 mb-4">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-clock-o"></i>
                </div>
                <div class="mr-5">Intervalo de tempo</div>
              </div>
              <div class="card-footer text-white clearfix small z-1">
                <span class="float-left">É o intervalo de tempo em que o speedtest vai se repetir, sistematizado em milissegundos. Exemplo: 300000ms vai repetir o speedtest de 5 em 5 minutos. O input deve ser apenas o valor número de milissegundos. Min: 5000ms(5s)/Max: 86400000ms(24h)<br>ATENÇÃO: um intervalo menor que 1 minuto pode causar gargalo na rede</span>
                <span class="float-right">
                  <i class="fa fa-clock-o"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-6 mb-4">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-database"></i>
                </div>
                <div class="mr-5">Nº máximo de servidores</div>
              </div>
              <div class="card-footer text-white clearfix small z-1">
                <span class="float-left">É o número máximo de servidores em que o speedtest vai realizar seus testes. O input deve ser em valor numérico.</span>
                <span class="float-right">
                  <i class="fa fa-database"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-6 mb-4">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-database"></i>
                </div>
                <div class="mr-5">Servidor específico (URL)</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">Servidor específico significa realizar o speedtest com uma lista de servidores específicos, trocando dados de teste apenas com ele. O input deve ser a URL do servidor que se deseja.</span>
                <span class="float-right">
                  <i class="fa fa-database"></i>
                </span>
              </a>
            </div>
          </div>
        </div>
        <div class="row">
        <div class="col-xl-6 col-sm-6">
        <!-- Area Chart Example-->
        <div class="card mb-3">
           <div class="card-header">Configuração Speedtest</div>
      <div class="card-body">
        <form method="POST" id="insert_config">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-12">
                <div class="form-label-group">
                  <input type="number" min="5000" max="86400000"  name="intervaloTempo" id="intervaloTempo" class="form-control" placeholder="Intervalo de tempo" autocomplete="off">
                  <label for="intervaloTempo">Intervalo de tempo</label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
              <div class="col-md-6">
                <div class="form-label-group">
                  <input type="text" id="maxServer" class="form-control" name="maxServer" placeholder="Máx Server" autocomplete="off">
                  <label for="maxServer">Nº máximo de servidores</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-label-group">
                  <input type="text" id="servidorEspecifico" name="servidorEspecifico" class="form-control" placeholder="URL" autocomplete="off">
                  <label for="servidorEspecifico">Servidor específico (URL)</label>
                </div>
              </div>
            </div>
              <br>
              <br>
            <a style="color:white;" id="save_btn" class="btn btn-primary btn-block" >Salvar alterações 
                <span>
                  <i class="fa fa-save"></i>
                </span></a>
          </div>
          
        </form>
        
      </div>
    </div>
      <div class="col-xl-6 col-sm-6">
         <div class="card mb-3">
           <div class="card-header">Configuração Atual Speedtest</div>
      <div class="card-body">

            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Intervalo de Tempo (ms)</th>
                    <th>Nº Máx de Servidores</th>
                    <th>Servidor Específico (URL)</th>
                    <th>Última alteração</th>
                  </tr>
                </thead>
                <tbody id="config_atual" name="config_atual" class="config_atual">
               
              </tbody>
              </table>
      </div>
       <a class="btn btn-primary btn-block" href="#">Restaurar Configuração Padrão
        <span>
                  <i class="fa fa-gears"></i>
                </span></a>
       </a>
    </div>
  </div>
</div>
      </div>
    </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Speedtest 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <script src="js/bootoast.js"></script>
  <script>
    $(document).ready(function(){
      function loadConfig() {
        $('.config_atual').empty();
        $.ajax({
                url: 'index.php',
                type: 'GET',
                data: {
                  "tabela": 1
                },
                success: function(response){

                  var config = JSON.parse(response); 

                  $tableline = $('.config_atual').append("<tr></tr>");
                  $tableline.append("<td id='current_intervalo_table'>"+config.intervalo+"</td>");

                  if (config.max_server!=null){
                    $tableline.append("<td id='current_maxserver_table'>"+config.max_server+"</td>");
                  } else {
                    $tableline.append("<td id='current_maxserver_table'>PADRÃO</td>");
                  }

                  $tableline.append("<td id='current_url_table'>"+config.url+"</td>");
                  
                  $tableline.append("<td>"+config.ultima_alteracao+"</td>")

                }
        });

      }

      
      document.getElementById("save_btn").addEventListener("click", update_config);

      loadConfig();

      function update_config(){

        var intervalo =  document.getElementById("intervaloTempo").value;
        var maxServer =  document.getElementById("maxServer").value
        var serverURL =  document.getElementById("servidorEspecifico").value;

        if(isEmpty(intervalo) && isEmpty(maxServer)&& isEmpty(serverURL)){
          bootoast.toast({
                    message: 'Preencha pelo menos um campo.',
                    type: 'danger'
                  });
        } else {
            //alert(isEmpty(intervalo));
        $.ajax({
                url: 'index.php',
                type: 'POST',
                data: {
                  "insert_config": 1,
                  "intervalo": intervalo,
                  "maxServer": maxServer,
                  "serverURL": serverURL
                },
                success: function(response){
                    
                  bootoast.toast({
                    message: 'Configuração atualiza com sucesso.',
                    type: 'success'
                  });

                  loadConfig();
                }
              });
      }
      }


    });

    function isEmpty(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}
  </script>

</body>

</html>
