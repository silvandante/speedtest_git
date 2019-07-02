<?php
  $pdo = new PDO('mysql:host=localhost;dbname=speedtest', "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}

    if (isset($_GET['tabela'])) {
    try {
      $qryLista_ = $pdo->query("SELECT * FROM isp_ip_name_table");    

      while($resultado = $qryLista_->fetch(PDO::FETCH_ASSOC)){
          $vetor[] = $resultado; 
      }    

      //echo json_encode($vetor);
      echo json_encode(utf8ize($vetor));

    }catch(Exception $e) {
      echo 'alert(Exception -> )'.$e->getMessage();

    }
    exit();
   }

  if (isset($_GET['get_days'])) {
    try {
      $qryLista = $pdo->query("SELECT DISTINCT YEAR(date) AS 'year', LPAD(MONTH(date), 2, '0') AS 'month',  LPAD(DAY(date), 2, '0') AS 'day' FROM speedtesttable WHERE isp_ip_name_id=".$_GET['id']." ORDER BY YEAR DESC, MONTH DESC, DAY DESC");    

   

      while($resultado = $qryLista->fetch(PDO::FETCH_ASSOC)){
          $vetor[] = $resultado; 
      }    
      echo json_encode(utf8ize($vetor));


    }catch(Exception $e) {
      echo 'alert(Exception -> )'.$e->getMessage();

    }
    exit();
   }

  if (isset($_GET['get_months'])) {
    try {
      $qryLista = $pdo->query("SELECT DISTINCT YEAR(date) AS 'year',  LPAD(MONTH(date), 2, '0') AS 'month' FROM speedtesttable Where isp_ip_name_id =".$_GET['id']." ORDER BY YEAR DESC,MONTH DESC");    

      while($resultado = $qryLista->fetch(PDO::FETCH_ASSOC)){
          $vetor[] = $resultado; 
      }    
      echo json_encode(utf8ize($vetor));
    }catch(Exception $e) {
      echo 'alert(Exception -> )'.$e->getMessage();

    }
    exit();
   }

   if (isset($_GET['generate_chart_day'])) {
    $day = $_GET['day'];
    $id = $_GET['id'];
    $isp = $_GET['isp'];
    $ip = $_GET['ip'];
    $name = $_GET['name'];

    try {
      $qryLista = $pdo->query("SELECT download,upload,time FROM speedtesttable WHERE isp_ip_name_id=".$id." AND date='".$day."'");    

      $qryPacote = $pdo->query("SELECT * FROM isp_ip_name_table WHERE id=".$id);  
      //$qryPacote = $pdo->query("SELECT * FROM isp_ip_name WHERE id='".$id."'");  

      $pacote = $qryPacote->fetch(PDO::FETCH_ASSOC);
      
      while($resultado = $qryLista->fetch(PDO::FETCH_ASSOC)){
          $vetor[] = $resultado;
      }
      
      $vetor2[] = $pacote;

      $json[] = array("pacote" => $pacote );
      $json[] = array("speedtests" => $vetor );
      echo json_encode(utf8ize($json));
      //echo json_decode($qryPacote->fetch(PDO::FETCH_ASSOC));
    }catch(Exception $e) {
      echo 'alert(Exception -> )'.$e->getMessage();

    }
    exit();
   }

   if (isset($_GET['generate_chart_month'])) {
    $month = $_GET['month'];
    $id = $_GET['id'];
    $isp = $_GET['isp'];
    $ip = $_GET['ip'];
    $name = $_GET['name'];

    try {
      $qryLista = $pdo->query("SELECT download,upload,date FROM speedtesttable WHERE date>=('".$month."'-INTERVAL 1 MONTH) AND isp_ip_name_id='".$id."'");    

      $qryPacote = $pdo->query("SELECT * FROM isp_ip_name_table WHERE id=".$id);  
     
      $pacote = $qryPacote->fetch(PDO::FETCH_ASSOC);
      
      while($resultado = $qryLista->fetch(PDO::FETCH_ASSOC)){
          $vetor[] = $resultado;
      }
      
      $vetor2[] = $pacote;

      $json[] = array("pacote" => $pacote );
      $json[] = array("speedtests" => $vetor );
      echo json_encode(utf8ize($json));
      //echo json_decode($qryPacote->fetch(PDO::FETCH_ASSOC));
    }catch(Exception $e) {
      echo 'alert(Exception -> )'.$e->getMessage();

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

  <title>Speedtest - Relatórios</title>

  <link href="css/bootoast.css" rel="stylesheet" type="text/css">
  <!-- Custom fonts for this template-->
  <link href="vendor\font-awesome-4.7.0\css\font-awesome.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.php">Speedtest Dashboard</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fa fa-bar-chart"></i>
    </button>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item ">
        <a class="nav-link"  id="openConfig" href="index.php">
          <i class="fa fa-gear"></i>
          <span>Configuração</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="openConnections" href="conexoes.php">
          <i class="fa fa-wifi"></i>
          <span>Conexões</span></a>
      </li>
      <li class="nav-item active">
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
          <li class="breadcrumb-item active">Relatórios</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row">
       <div class="col-xl-6 col-sm-6">
         <div class="card mb-3">
           <div class="card-header">Lista de Conexões</div>
      <div class="card-body scroll">

            <div class="table-responsive">
              <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>ISP</th>
                    <th>IP</th>
                    <th>Nome da conexão</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody id='tabela' class="tabela" name="tabela">
                </tbody>
              </table>
      </div>
    </div>
  </div>

</div>
          <div class="col-xl-6 col-sm-6 mb-6">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-area-chart"></i>
                </div>
                <div class="mr-5"><h1>Gerar Relatório

                </div>
              </div>
              <form method="post" action="add_connection_name.php">
              <div class="card-footer text-white clearfix small z-1">
                <div class="input-group mb-3">
                  <input class="form-control id_connection" id="id_connection" type="hidden">
                 
                </div>
                <div class="input-group mb-3">
                  <input class="form-control isp_connection" autocomplete="off" id="isp_connection" type="text" placeholder="ISP" disabled>
                 
                </div>
                 <div class="input-group mb-3">
                  <input class="form-control ip_connection" autocomplete="off" id="ip_connection" type="text" placeholder="IP" disabled>
                 
                </div>
                <div class="input-group mb-3">
                  <input type="text" class="form-control name_connection" autocomplete="off" id="name_connection" placeholder="Nome da conexão" disabled>
                </div>
                <div class="row">

                <div class="col-sm-6 col-xl-6 col-md-6">
                  <div class="input-group mb-3">
                    <select class="custom-select" id="dropdown_day">
                      <option selected>Selecionar dia</option>
                    </select>
                  </div>
                <a class="btn btn-light btn-block diario_btn" style="color:black;">Gerar relatório diário
                <span>
                    <i class="fa fa-calendar-o"></i>
                  </span>
                </a>
              </div>
              <div class="col-sm-6 col-xl-6 col-md-6">
                <div class="input-group mb-3">
                    <select class="custom-select" id="dropdown_month">
                      <option selected>Selecionar mês</option>
                    </select>
                  </div>
                 <a class="btn btn-light btn-block mensal_btn" style="color:black;">Gerar relatório mensal
                <span>
                    <i class="fa fa-calendar"></i>
                  </span>
                </a>
                </div>
                </div>

                </form>
                <br>
                <span class="float-left">Aqui você gerar gráficos diários e mensais de cada conexão escolhida. Escolha a conexão clicando no ícone do olho da conexão desejada na tabela de conexões ao lado.</span>
                <span class="float-right">
                  <i class="fa fa-area-chart"></i>
                </span>
              </div>
              
            </div>



      </div>

          <div class="col-xl-12 col-sm-12 mb-12 relatorio_" id="relatorio_" style="margin-top:20px;">
          
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

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
 <script src="vendor/bootoast.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

  <script>


    $(document).ready(function(){
      $('.mensal_btn').click(function(){
        var month = $('#dropdown_month option:selected').val();
        var id = $('#id_connection').val();
        var isp = $('#isp_connection').val();
        var ip = $('#ip_connection').val();
        var name = $('#name_connection').val(); 
         // alert(month);
        if (id!=""){
          if (month!="Selecionar dia"){
            $.ajax({
                                url: 'charts.php',
                                type: 'GET',
                                data: {
                                "generate_chart_month": 1,
                                'month': month,
                                'id': id,
                                'isp': isp,
                                'ip': ip,
                                'name': name
                                },
                                success: function(response){
                                 alert(response);

                                   $('.relatorio_').empty();
                                  $('.relatorio_').append("<div class='card-header'><i class='fas fa-chart-area'></i>Relatório Gerado (em megas)</div><div class='card-body relatorio'><h1 class='local_relatorio'>Local do relatório</h1><h2 class='infos'>Informações sobre o local e o relatório</h2><canvas id='chart' style='width: 100%; height: 65vh; background: #222; border: 1px solid #555652; margin-top: 10px;'></canvas></div><div class='card-footer small text-muted date'>Nenhum gráfico gerado ainda.</div><button class='btn btn-primary downloadPdf' id='downloadPdf' name='downloadPdf'>Download PDF</button>");   

                                  $('.downloadPdf').click(function() {

                                    var cv= ($('#chart')[0]).toDataURL("image/jpeg");
                                    var printDoc = new jsPDF();
                                 
                                    printDoc.fromHTML($('.relatorio_').get(0), 8, 8, {'width': 180});
                                    printDoc.addImage(cv,'jpeg',8,200,195,75);
                                    printDoc.autoPrint();
                                    printDoc.output("dataurlnewwindow");
                                  });

                                  var json = JSON.parse(response);

                                  var conexao_ = json[0];
                                  var conexao = conexao_["pacote"];
                                  var speedtests_ = json[1];
                                  var speedtests = speedtests_["speedtests"];

                                  var download = [];
                                  var upload = [];
                                  var date = [];
                                  var total = 0;
                                  var per_download_0= [];
                                  var per_download_1= [];
                                  var total_per_download = 0;

                                  for(var speedtest in speedtests) {
                                    download.push(speedtests[speedtest].download)
                                    upload.push(speedtests[speedtest].upload)
                                    date.push(speedtests[speedtest].date);

                                    if (conexao.pacote != 0 ){
                                      per_download_0.push(speedtests[speedtest].download/conexao.pacote);

                                      per_download_1.push(per_download_0[speedtest]*100);
                                    }

                                  }
                                  if (conexao.pacote != 0 ){
                                  per_download_1.forEach((percentage, item) => total_per_download = total_per_download + percentage);

                                  var total_percentage = total_per_download/per_download_1.length;
                                  } else {
                                    total_percentage = "Nenhum pacote cadastrado.";
                                  }


                                var d = new Date();

                                var month = d.getMonth()+1;
                                var day = d.getDate();
                                var year = d.getYear() +1900;

                                $(".date").text("Gráfico gerado em: "+day+"/"+month+"/"+year+" | Os dados desse gráfico podem variar de acordo com o tamanho do intervalo de sua execução. Os períodos em que seu computador não esteve conectado a internet estão fora desse gráfico, pois ele só realiza o speedtest quando você está online na internet. Para ter um resultado preciso realize o teste por no mínimo 10 em 10 minutos durante 24 horas.");

                                $(".local_relatorio").text(name);



                                if (conexao.pacote!=0){
                                var obj = $(".infos").text("Relatório gerado automaticamente pelo Speedtest.\nPacote contratado: "+conexao.pacote+" mb\nISP: "+isp+"\nIP: "+ip+"\nPorcentagem diária média: "+total_percentage.toFixed(2)+"%");
                                } else {
                                  var obj = $(".infos").text("Relatório gerado automaticamente pelo Speedtest.\nPacote contratado: NÃO CADASTRADO\nISP: "+isp+"\nIP: "+ip+"\nPorcentagem diária média: "+total_percentage);
                                }
                                obj.html(obj.html().replace(/\n/g,'<br/>'));

                                                                  $(function () {
                                                                         var ctx = document.getElementById("chart");
 

          var myChart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: date,
                  showXLabels: 31 ,
                  datasets: 
                  [{
                      label: 'Download',
                      data: download,
                      backgroundColor: 'transparent',
                      borderColor:'rgba(255,99,132)',
                      borderWidth: 3
                  },

                  {
                    label: 'Upload',
                      data: upload,
                      backgroundColor: 'transparent',
                      borderColor:'rgba(0,255,255)',
                      borderWidth: 3  
                  }
                  ]
              },
           
              options: {
                  scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
                  tooltips:{mode: 'index'},
                  legend:{display: true, position: 'top', labels: {fontColor: 'rgb(255,255,255)', fontSize: 16}}
              }
          });
                                  });

                       
                                }
         });

$('html,body').animate({
        scrollTop: $(".relatorio_").offset().top},
        'slow');

          } else {
            bootoast.toast({
              message: 'Selecione um dia para gerar relatório.',
              type: 'danger'
            });
           }
       
      } else {

          bootoast.toast({
            message: 'Nenhuma conexão selecionada.',
            type: 'danger'
          });
        
      }
      
    });

$('.diario_btn').click(function(){
        var day = $('#dropdown_day option:selected').val();
        var id = $('#id_connection').val();
        var isp = $('#isp_connection').val();
        var ip = $('#ip_connection').val();
        var name = $('#name_connection').val(); 

        if (id!=""){
          if (day!="Selecionar dia"){
            $.ajax({
                                url: 'charts.php',
                                type: 'GET',
                                data: {
                                "generate_chart_day": 1,
                                'day': day,
                                'id': id,
                                'isp': isp,
                                'ip': ip,
                                'name': name
                                },
                                success: function(response){
                                   $('.relatorio_').empty();
                                  $('.relatorio_').append("<div class='card-header'><i class='fas fa-chart-area'></i>Relatório Gerado (em megas)</div><div class='card-body relatorio'><h1 class='local_relatorio'>Local do relatório</h1><h2 class='infos'>Informações sobre o local e o relatório</h2><canvas id='chart' style='width: 100%; height: 65vh; background: #222; border: 1px solid #555652; margin-top: 10px;'></canvas></div><div class='card-footer small text-muted date'>Nenhum gráfico gerado ainda.</div><button class='btn btn-primary downloadPdf' id='downloadPdf' name='downloadPdf'>Download PDF</button>");   

                                  $('.downloadPdf').click(function() {

                                    var cv= ($('#chart')[0]).toDataURL("image/jpeg");
                                    var printDoc = new jsPDF();
                                 
                                    printDoc.fromHTML($('.relatorio_').get(0), 8, 8, {'width': 180});
                                    printDoc.addImage(cv,'jpeg',8,200,195,75);
                                    printDoc.autoPrint();
                                    printDoc.output("dataurlnewwindow");
                                  });

                                  var json = JSON.parse(response);

                                  var conexao_ = json[0];
                                  var conexao = conexao_["pacote"];
                                  var speedtests_ = json[1];
                                  var speedtests = speedtests_["speedtests"];

                                  var download = [];
                                  var upload = [];
                                  var time = [];
                                  var total = 0;
                                  var per_download_0= [];
                                  var per_download_1= [];
                                  var total_per_download = 0;

                                  for(var speedtest in speedtests) {
                                    download.push(speedtests[speedtest].download)
                                    upload.push(speedtests[speedtest].upload)
                                    time.push(speedtests[speedtest].time);

                                    if (conexao.pacote != 0 ){
                                      per_download_0.push(speedtests[speedtest].download/conexao.pacote);

                                      per_download_1.push(per_download_0[speedtest]*100);
                                    }

                                  }
                                  if (conexao.pacote != 0 ){
                                  per_download_1.forEach((percentage, item) => total_per_download = total_per_download + percentage);

                                  var total_percentage = total_per_download/per_download_1.length;
                                  } else {
                                    total_percentage = "Nenhum pacote cadastrado.";
                                  }


                                var d = new Date();

                                var month = d.getMonth()+1;
                                var day = d.getDate();
                                var year = d.getYear() +1900;

                                $(".date").text("Gráfico gerado em: "+day+"/"+month+"/"+year+" | Os dados desse gráfico podem variar de acordo com o tamanho do intervalo de sua execução. Os períodos em que seu computador não esteve conectado a internet estão fora desse gráfico, pois ele só realiza o speedtest quando você está online na internet. Para ter um resultado preciso realize o teste por no mínimo 10 em 10 minutos durante 24 horas.");

                                $(".local_relatorio").text(name);



                                if (conexao.pacote!=0){
                                var obj = $(".infos").text("Relatório gerado automaticamente pelo Speedtest.\nPacote contratado: "+conexao.pacote+" mb\nISP: "+isp+"\nIP: "+ip+"\nPorcentagem diária média: "+total_percentage.toFixed(2)+"%");
                                } else {
                                  var obj = $(".infos").text("Relatório gerado automaticamente pelo Speedtest.\nPacote contratado: NÃO CADASTRADO\nISP: "+isp+"\nIP: "+ip+"\nPorcentagem diária média: "+total_percentage);
                                }
                                obj.html(obj.html().replace(/\n/g,'<br/>'));

                                                                  $(function () {
                                                                         var ctx = document.getElementById("chart");
 

          var myChart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: time,
                  datasets: 
                  [{
                      label: 'Download',
                      data: download,
                      backgroundColor: 'transparent',
                      borderColor:'rgba(255,99,132)',
                      borderWidth: 3
                  },

                  {
                    label: 'Upload',
                      data: upload,
                      backgroundColor: 'transparent',
                      borderColor:'rgba(0,255,255)',
                      borderWidth: 3  
                  }
                  ]
              },
           
              options: {
                  scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
                  tooltips:{mode: 'index'},
                  legend:{display: true, position: 'top', labels: {fontColor: 'rgb(255,255,255)', fontSize: 16}}
              }
          });
                                  });

                       
                                }
         });

$('html,body').animate({
        scrollTop: $(".relatorio_").offset().top},
        'slow');

          } else {
            bootoast.toast({
              message: 'Selecione um mês para gerar relatório.',
              type: 'danger'
            });
           }
       
      } else {

          bootoast.toast({
            message: 'Nenhuma conexão selecionada.',
            type: 'danger'
          });
        
      }
      
    });


      clearAll();
      function loadtable() {
           $('.tabela').empty();
                $.ajax({
                url: 'charts.php',
                type: 'GET',

                data: {
                  "tabela": 1
                },
                success: function(response){

                  var isp_ip_name_table = JSON.parse(response);
                  
                  for(var conexao in isp_ip_name_table) {
                    $table =  $('.tabela').append("<tr id='item"+isp_ip_name_table[conexao].id+"'></tr>");
                    $("#item"+isp_ip_name_table[conexao].id).append("<th>"+isp_ip_name_table[conexao].id+"</th>");
                    $("#item"+isp_ip_name_table[conexao].id).append("<th>"+isp_ip_name_table[conexao].isp+"</th>");
                    $("#item"+isp_ip_name_table[conexao].id).append("<th>"+isp_ip_name_table[conexao].ip+"</th>");
                    $("#item"+isp_ip_name_table[conexao].id).append("<th>"+isp_ip_name_table[conexao].name+"</th>");
                    $("#item"+isp_ip_name_table[conexao].id).append("<th><button type='button' class='btn btn_get_this' id='edit_"+isp_ip_name_table[conexao].isp+"_"+isp_ip_name_table[conexao].ip+"_"+isp_ip_name_table[conexao].name+"_"+isp_ip_name_table[conexao].id+"'><span class='fa fa-eye'></span></button</th>");
                  }


                    $('.btn_get_this').click(function(){
                      var el = this;
                      var id = this.id;
                      var splitid = id.split("_");
                      $('.id_connection').val(splitid[4]); 
                      $('.ip_connection').val(splitid[2]); 
                      $('.isp_connection').removeAttr('placeholder');
                      $('.isp_connection').val(splitid[1]); 
                      $('.ip_connection').removeAttr('placeholder');
                      $('.ip_connection').val(splitid[2]); 
                      $('.name_connection').removeAttr('placeholder');
                      $('.name_connection').val(splitid[3]); 
                      $("#dropdown_day").empty();
                      $("#dropdown_month").empty()

                       $.ajax({
                                url: 'charts.php',
                                type: 'GET',
                                data: {
                                'get_days': 1,
                                'id': splitid[4]
                                },
                                success: function(response){

                                  var days = JSON.parse(response);

                                  for(var day in days) {
                                    $('#dropdown_day').append("<option value='"+days[day].year+"-"+days[day].month+"-"+days[day].day+"'>"+days[day].day+"/"+days[day].month+"/"+days[day].year+"</option>");
                                  }
                                  
                                }
                              });
                       $.ajax({
                                url: 'charts.php',
                                type: 'GET',
                                data: {
                                'get_months': 1,
                                'id': splitid[4]
                                },
                                success: function(response){
                                  //alert(response);
                                  var dates = JSON.parse(response);

                                  for(var date in dates) {
                                    $('#dropdown_month').append("<option value='"+dates[date].year+"-"+dates[date].month+"-01'>"+dates[date].month+"/"+dates[date].year+"</option>");
                                  }
                                  
                                }
                              });
  
                    });

                      $('.btn_diario').click(function(){
                        var el = this;
                        var id_ = this.id;
                        var splitid = id_.split("_");
                        var id=splitid[4];

                        $.ajax({
                                url: 'conexoes.php',
                                type: 'GET',
                                data: {
                                'chart': 1,
                                'id': id
                                },
                                success: function(response){
                                  alert(response);
                                }
                              });

                      });

                       $('.delete_btn').click(function(){
                        var el = this;
                        var id_ = this.id;
                        var splitid = id_.split("_");
                        var id=splitid[4];
                        var result = confirm("APAGAR CONEXÃO\nIsso apagará todos os registros e relatórios sobre essa conexão.\nDeseja continuar?"); 
                            if (result == true) { 
                              $.ajax({
                                url: 'conexoes.php',
                                type: 'GET',
                                data: {
                                'delete': 1,
                                'id': id
                                },
                                success: function(response){
                                  clearAll();
                                  loadtable();
                                }
                              });
                            } 
                      });

                }
              });
            
            
      }

      loadtable();

      $('.clean_btn').click(function(){
       clearAll();
       
      });

      function clearAll() {
        $('.id_connection').val(""); 
         $('.ip_connection').val(""); 

        $('.isp_connection').val(""); 
        $('.isp_connection').attr("placeholder", "ISP");


        $('.ip_connection').val(""); 
        $('.ip_connection').attr("placeholder", "IP");

        $('.name_connection').val(""); 
        $('.name_connection').attr("placeholder","Nome da conexão");

      }


  
    });


</script>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-bar-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>


        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
   

</body>

</html>
