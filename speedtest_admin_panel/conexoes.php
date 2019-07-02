<?php
  $pdo = new PDO('mysql:host=localhost;dbname=speedtest', "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



  if (isset($_GET['delete'])) {
    try {
    $id = $_GET['id'];

      $sql = "DELETE FROM isp_ip_name_table WHERE id=" . $id;
      $sql_ = "DELETE FROM speedtesttable WHERE isp_ip_name_id=" . $id;
      $result = $pdo->query($sql);
      $result = $pdo->query($sql_);
    }catch(Exception $e) {
      echo 'alert(Exception -> )'.$e->getMessage();

    }
    exit();
  }
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


    if (isset($_GET['edit_name'])) {
    try {
      $id = $_GET['id'];
      $new_name = $_GET['new_name'];
       $pacote = $_GET['pacote'];
      $qryResponse = $pdo->query("UPDATE isp_ip_name_table SET name='{$new_name}', pacote='{$pacote}' WHERE id='{$id}'");    

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

  <title>Speedtest - Conexões</title>

  <!-- Custom fonts for this template-->
  <link href="vendor\font-awesome-4.7.0\css\font-awesome.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

  <link href="css/bootoast.css" rel="stylesheet" type="text/css">

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
      <li class="nav-item">
        <a class="nav-link" id="openConfig"  href="index.php">
          <i class="fa fa-gear"></i>
          <span>Configuração</span>
        </a>
      </li>
      <li class="nav-item active">
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
        <a class="nav-link" href="about.php">
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
          <li class="breadcrumb-item active">Conexões</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row">
          <div class="col-xl-6 col-sm-6">
         <div class="card mb-3">
           <div class="card-header">Lista de Conexões</div>
      <div class="card-body">

            <div class="table-responsive scroll">
              <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>ISP</th>
                    <th>IP</th>
                    <th>Nome da conexão</th>
                    <th>Pacote (mb)</th>
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
                  <i class="fa fa-edit"></i>
                </div>
                <div class="mr-5"><h1>Nomear conexão</h1></div>
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
                  <input type="text" class="form-control name_connection" autocomplete="off" id="name_connection" placeholder="Nome da conexão">
                </div>
                <div class="input-group mb-3">
                  <input type="text" class="form-control pacote_connection" autocomplete="off" id="pacote_connection" placeholder="Pacote em megabytes">
                </div>
                <div class="row">
                  <div class="col-sm-6 col-xl-6 col-md-6">
                <a class="btn btn-light btn-block save_btn" style="color:black;">Salvar alteração
                <span>
                    <i class="fa fa-edit"></i>
                  </span>
                </a>
              </div>
              <div class="col-sm-6 col-xl-6 col-md-6">
                 <a class="btn btn-light btn-block clean_btn" style="color:black;">Limpar
                <span>
                    <i class="fa fa-undo"></i>
                  </span>
                </a>
                </div>
                </div>

                </form>
                <br>
                <span class="float-left">Aqui você pode nomear uma conexão a partir do ISP e IP detectado automaticamente. Dica: nomeie a conexão de uma forma a lembrar do local a que ele pertence, em pacote, coloque o valor do pacote contratado em megabytes.</span>
                <span class="float-right">
                  <i class="fa fa-calendar-o"></i>
                </span>
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>


    $(document).ready(function(){


      clearAll();
      function loadtable() {
           $('.tabela').empty();
                $.ajax({
                url: 'conexoes.php',
                type: 'GET',
                data: {
                  "tabela": 1
                },
                success: function(response){
                  //alert(response);
                  var json_ = JSON.parse(response);

                  var isp_ip_name_table =json_;
                 
                for(var conexao in isp_ip_name_table) {
                    $table =  $('.tabela').append("<tr id='item"+isp_ip_name_table[conexao].id+"'></tr>");
                    $("#item"+isp_ip_name_table[conexao].id).append("<th>"+isp_ip_name_table[conexao].id+"</th>");
                    $("#item"+isp_ip_name_table[conexao].id).append("<th>"+isp_ip_name_table[conexao].isp+"</th>");
                    $("#item"+isp_ip_name_table[conexao].id).append("<th>"+isp_ip_name_table[conexao].ip+"</th>");
                    $("#item"+isp_ip_name_table[conexao].id).append("<th>"+isp_ip_name_table[conexao].name+"</th>");
                    $("#item"+isp_ip_name_table[conexao].id).append("<th>"+isp_ip_name_table[conexao].pacote+"</th>");
                    $("#item"+isp_ip_name_table[conexao].id).append("<th><button type='button' class='btn edit' id='edit_"+isp_ip_name_table[conexao].isp+"_"+isp_ip_name_table[conexao].ip+"_"+isp_ip_name_table[conexao].name+"_"+isp_ip_name_table[conexao].id+"_"+isp_ip_name_table[conexao].pacote+"'><span class='fa fa-edit'></span></button><button type='button' class='btn delete_btn' id='edit_"+isp_ip_name_table[conexao].isp+"_"+isp_ip_name_table[conexao].ip+"_"+isp_ip_name_table[conexao].name+"_"+isp_ip_name_table[conexao].id+"_"+isp_ip_name_table[conexao].pacote+"'><span class='fa fa-trash'></span></button</th>");
                  }



                        $('.edit').click(function(){
                      var el = this;
                      var id = this.id;
                      var splitid = id.split("_");
                      $('.id_connection').val(splitid[4]); 
                      $('.ip_connection').val(splitid[2]); 
                      $('.isp_connection').removeAttr('placeholder');
                      $('.isp_connection').val(splitid[1]); 
                      $('.ip_connection').removeAttr('placeholder');
                      $('.ip_connection').val(splitid[2]); 
                      $('.name_connection').attr("placeholder",splitid[3]);
                      $('.pacote_connection').attr("placeholder",splitid[5]);
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

       $('.save_btn').click(function(){
         var id = $('#id_connection').val();
         var new_name = $('#name_connection').val();
        var isp = $('#isp_connection').val();
        var ip = $('#ip_connection').val();
        var pacote = $('#pacote_connection').val();
        if (id!=""){
           if (new_name=="" && pacote==""){
          bootoast.toast({
            message: 'Insira um novo nome ou pacote para sua conexão.',
            type: 'danger'
          });
        } else {
          if (new_name==""){
 $.ajax({
                                url: 'conexoes.php',
                                type: 'GET',
                                data: {
                                "edit_name": 1,
                                'new_name': $("#name_connection").attr("placeholder"),
                                'id': id,
                                "pacote": pacote
                                },
                                success: function(response){
                       
                                  clearAll();
                                  loadtable();
                                  bootoast.toast({
                                    message: 'Novo nome de conexão+pacote cadastrado com sucesso.</br>ISP: '+isp+'</br>IP: '+ip+'</br>Nome: '+new_name,
                                    type: 'success'
                                  });
                                }
       
       });
          } else {

            if (pacote==""){
                              $.ajax({
                                url: 'conexoes.php',
                                type: 'GET',
                                data: {
                                "edit_name": 1,
                                'new_name': new_name,
                                'id': id,
                                "pacote": $("#pacote_connection").attr("placeholder")
                                },
                                success: function(response){
                       
                                  clearAll();
                                  loadtable();
                                  bootoast.toast({
                                    message: 'Novo nome de conexão+pacote cadastrado com sucesso.</br>ISP: '+isp+'</br>IP: '+ip+'</br>Nome: '+new_name,
                                    type: 'success'
                                  });
                                }
       
                              });
            } else {
         $.ajax({
                                url: 'conexoes.php',
                                type: 'GET',
                                data: {
                                "edit_name": 1,
                                'new_name': new_name,
                                'id': id,
                                "pacote": pacote
                                },
                                success: function(response){
                       
                                  clearAll();
                                  loadtable();
                                  bootoast.toast({
                                    message: 'Novo nome de conexão+pacote cadastrado com sucesso.</br>ISP: '+isp+'</br>IP: '+ip+'</br>Nome: '+new_name,
                                    type: 'success'
                                  });
                                }
       
       });
       }
       }
       }
      } else {

          bootoast.toast({
            message: 'Nenhuma conexão selecionada.',
            type: 'danger'
          });
        
      }
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


        $('.pacote_connection').val(""); 
        $('.pacote_connection').attr("placeholder","Pacote em megabytes");

      }


  
    });
</script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>
  <script src="js/bootoast.js"></script>
  <!-- Demo scripts for this page-->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-bar-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>
