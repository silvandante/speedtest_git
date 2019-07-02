var speedTest = require('speedtest-net');

var mysql = require('mysql');
const notifier = require('node-notifier');

var opn = require('opn');

const connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : '',
  database : 'speedtest'
});

connection.connect(function(err){
  if(err) return console.log(err);
  console.log('conectou ao banco de dados!\n');
});

   notifier.on('click', function(notifierObject, options) {
                      console.log("clicou na notificação");
                      opn('http://localhost/speedtest_admin/conexoes.php');
                    });

function speedtest() {
  console.log("chamou speedtest()\n");
  var response;

  //console.log("conexao atual:"+getCurrentConnection()); 

  connection.query('select * from config', function (err, rows, fields) {
    if (err) throw err;

    result = rows[0];

    response = result;

    console.log(response);

    if (response.max_server == 0){

      if (response.url == ""){
        var test = speedTest({maxTime: response.intervalo});


        test.on('data', data => {
          console.log(data);

          //console.log(getCurrentConnection(data.client.isp,data.client.ip));

         getISP_IP_NAME_ID_byISP_IP(data.client.isp,data.client.ip, function(this_isp_ip_name) {
            getIsp_Ip_Name_Id_OfCurrentConnection(this_isp_ip_name, function(current_isp_ip_name) {
              if (this_isp_ip_name!=current_isp_ip_name){
                getLocalNameById(this_isp_ip_name,function(name_current){
                updateCurrentConnection(this_isp_ip_name);
                console.log("current_connection_name: "+name_current);

                if(name_current=="SEM NOME"){
                  notifier.notify(
                    {
                      title: "SPEEDTEST",
                      message: "CONEXÃO SEM NOME, clique aqui para nomear",
                      sound: true, // Case Sensitive string for location of sound file, or use one of macOS' native sounds (see below)
                      icon: 'Terminal Icon', // Absolute Path to Triggering Icon
                      contentImage: void 0, // Absolute Path to Attached Image (Content Image)
                      open: void 0, // URL to open on Click
                      wait: true, // Wait for User Action against Notification or times out. Same as timeout = 5 seconds

                      // New in latest version. See `example/macInput.js` for usage
                      timeout: 5, // Takes precedence over wait if both are defined.
                      closeLabel: void 0, // String. Label for cancel button
                      actions: void 0, // String | Array<String>. Action label or list of labels in case of dropdown
                      dropdownLabel: void 0, // String. Label to be used if multiple actions
                      reply: false // Boolean. If notification should take input. Value passed as third argument in callback and event emitter.
                    },
                    function(error, response, metadata) {
                      console.log("enviou notificao");
                      //opn('http://localhost/speedtest_admin/conexoes.php');

                    }
                  );
                } else {

                   notifier.notify(
                    {
                      title: "SPEEDTEST",
                      message: "Você está em "+name_current,
                      sound: true, // Case Sensitive string for location of sound file, or use one of macOS' native sounds (see below)
                      icon: 'Terminal Icon', // Absolute Path to Triggering Icon
                      contentImage: void 0, // Absolute Path to Attached Image (Content Image)
                      open: void 0, // URL to open on Click
                      wait: false, // Wait for User Action against Notification or times out. Same as timeout = 5 seconds

                      // New in latest version. See `example/macInput.js` for usage
                      timeout: 5, // Takes precedence over wait if both are defined.
                      closeLabel: void 0, // String. Label for cancel button
                      actions: void 0, // String | Array<String>. Action label or list of labels in case of dropdown
                      dropdownLabel: void 0, // String. Label to be used if multiple actions
                      reply: false // Boolean. If notification should take input. Value passed as third argument in callback and event emitter.
                    },
                    function(error, response, metadata) {

                     // console.log(response, metadata);
                      console.log("enviou notificao");
                    }
                  );


          
                }
                });

              }
            });

         });

          addQueryToDB(data);
          speedtest();
        });

        test.on('error', err => {
          console.error("erro detectado: ");
          speedtest();
        });
      } else {
        var test = speedTest({maxTime: response.intervalo, serversURL: response.url});

        test.on('data', data => {
          console.log(data);

          //console.log(getCurrentConnection(data.client.isp,data.client.ip));

         getISP_IP_NAME_ID_byISP_IP(data.client.isp,data.client.ip, function(this_isp_ip_name) {
            getIsp_Ip_Name_Id_OfCurrentConnection(this_isp_ip_name, function(current_isp_ip_name) {
              if (this_isp_ip_name!=current_isp_ip_name){
                getLocalNameById(this_isp_ip_name,function(name_current){
                updateCurrentConnection(this_isp_ip_name);
                console.log("current_connection_name: "+name_current);

                if(name_current=="SEM NOME"){
                  notifier.notify(
                    {
                      title: "SPEEDTEST",
                      message: "CONEXÃO SEM NOME, clique aqui para nomear",
                      sound: true, // Case Sensitive string for location of sound file, or use one of macOS' native sounds (see below)
                      icon: 'Terminal Icon', // Absolute Path to Triggering Icon
                      contentImage: void 0, // Absolute Path to Attached Image (Content Image)
                      open: void 0, // URL to open on Click
                      wait: true, // Wait for User Action against Notification or times out. Same as timeout = 5 seconds

                      // New in latest version. See `example/macInput.js` for usage
                      timeout: 5, // Takes precedence over wait if both are defined.
                      closeLabel: void 0, // String. Label for cancel button
                      actions: void 0, // String | Array<String>. Action label or list of labels in case of dropdown
                      dropdownLabel: void 0, // String. Label to be used if multiple actions
                      reply: false // Boolean. If notification should take input. Value passed as third argument in callback and event emitter.
                    },
                    function(error, response, metadata) {
                      console.log("enviou notificao");
                      //opn('http://localhost/speedtest_admin/conexoes.php');

                    }
                  );
                } else {

                   notifier.notify(
                    {
                      title: "SPEEDTEST",
                      message: "Você está em "+name_current,
                      sound: true, // Case Sensitive string for location of sound file, or use one of macOS' native sounds (see below)
                      icon: 'Terminal Icon', // Absolute Path to Triggering Icon
                      contentImage: void 0, // Absolute Path to Attached Image (Content Image)
                      open: void 0, // URL to open on Click
                      wait: false, // Wait for User Action against Notification or times out. Same as timeout = 5 seconds

                      // New in latest version. See `example/macInput.js` for usage
                      timeout: 5, // Takes precedence over wait if both are defined.
                      closeLabel: void 0, // String. Label for cancel button
                      actions: void 0, // String | Array<String>. Action label or list of labels in case of dropdown
                      dropdownLabel: void 0, // String. Label to be used if multiple actions
                      reply: false // Boolean. If notification should take input. Value passed as third argument in callback and event emitter.
                    },
                    function(error, response, metadata) {

                     // console.log(response, metadata);
                      console.log("enviou notificao");
                    }
                  );


          
                }
                });

              }
            });

         });

          addQueryToDB(data);
          speedtest();
        });

        test.on('error', err => {
          console.error("erro detectado: ");
          speedtest();
        });
      }

    } else {
      if (response.url == ""){
        var test = speedTest({maxTime: response.intervalo, maxServers: response.max_server});

       test.on('data', data => {
          console.log(data);

          //console.log(getCurrentConnection(data.client.isp,data.client.ip));

         getISP_IP_NAME_ID_byISP_IP(data.client.isp,data.client.ip, function(this_isp_ip_name) {
            getIsp_Ip_Name_Id_OfCurrentConnection(this_isp_ip_name, function(current_isp_ip_name) {
              if (this_isp_ip_name!=current_isp_ip_name){
                getLocalNameById(this_isp_ip_name,function(name_current){
                updateCurrentConnection(this_isp_ip_name);
                console.log("current_connection_name: "+name_current);

                if(name_current=="SEM NOME"){
                  notifier.notify(
                    {
                      title: "SPEEDTEST",
                      message: "CONEXÃO SEM NOME, clique aqui para nomear",
                      sound: true, // Case Sensitive string for location of sound file, or use one of macOS' native sounds (see below)
                      icon: 'Terminal Icon', // Absolute Path to Triggering Icon
                      contentImage: void 0, // Absolute Path to Attached Image (Content Image)
                      open: void 0, // URL to open on Click
                      wait: true, // Wait for User Action against Notification or times out. Same as timeout = 5 seconds

                      // New in latest version. See `example/macInput.js` for usage
                      timeout: 5, // Takes precedence over wait if both are defined.
                      closeLabel: void 0, // String. Label for cancel button
                      actions: void 0, // String | Array<String>. Action label or list of labels in case of dropdown
                      dropdownLabel: void 0, // String. Label to be used if multiple actions
                      reply: false // Boolean. If notification should take input. Value passed as third argument in callback and event emitter.
                    },
                    function(error, response, metadata) {
                      console.log("enviou notificao");
                      //opn('http://localhost/speedtest_admin/conexoes.php');

                    }
                  );
                } else {

                   notifier.notify(
                    {
                      title: "SPEEDTEST",
                      message: "Você está em "+name_current,
                      sound: true, // Case Sensitive string for location of sound file, or use one of macOS' native sounds (see below)
                      icon: 'Terminal Icon', // Absolute Path to Triggering Icon
                      contentImage: void 0, // Absolute Path to Attached Image (Content Image)
                      open: void 0, // URL to open on Click
                      wait: false, // Wait for User Action against Notification or times out. Same as timeout = 5 seconds

                      // New in latest version. See `example/macInput.js` for usage
                      timeout: 5, // Takes precedence over wait if both are defined.
                      closeLabel: void 0, // String. Label for cancel button
                      actions: void 0, // String | Array<String>. Action label or list of labels in case of dropdown
                      dropdownLabel: void 0, // String. Label to be used if multiple actions
                      reply: false // Boolean. If notification should take input. Value passed as third argument in callback and event emitter.
                    },
                    function(error, response, metadata) {

                     // console.log(response, metadata);
                      console.log("enviou notificao");
                    }
                  );


          
                }
                });

              }
            });

         });

          addQueryToDB(data);
          speedtest();
        });

        test.on('error', err => {
          console.error("erro detectado: ");
          speedtest();
        });
      } else {
        var test = speedTest({maxTime: response.intervalo, maxServers: response.max_server,serversURL: response.url});

       test.on('data', data => {
          console.log(data);

          //console.log(getCurrentConnection(data.client.isp,data.client.ip));

         getISP_IP_NAME_ID_byISP_IP(data.client.isp,data.client.ip, function(this_isp_ip_name) {
            getIsp_Ip_Name_Id_OfCurrentConnection(this_isp_ip_name, function(current_isp_ip_name) {
              if (this_isp_ip_name!=current_isp_ip_name){
                getLocalNameById(this_isp_ip_name,function(name_current){
                updateCurrentConnection(this_isp_ip_name);
                console.log("current_connection_name: "+name_current);

                if(name_current=="SEM NOME"){
                  notifier.notify(
                    {
                      title: "SPEEDTEST",
                      message: "CONEXÃO SEM NOME, clique aqui para nomear",
                      sound: true, // Case Sensitive string for location of sound file, or use one of macOS' native sounds (see below)
                      icon: 'Terminal Icon', // Absolute Path to Triggering Icon
                      contentImage: void 0, // Absolute Path to Attached Image (Content Image)
                      open: void 0, // URL to open on Click
                      wait: true, // Wait for User Action against Notification or times out. Same as timeout = 5 seconds

                      // New in latest version. See `example/macInput.js` for usage
                      timeout: 5, // Takes precedence over wait if both are defined.
                      closeLabel: void 0, // String. Label for cancel button
                      actions: void 0, // String | Array<String>. Action label or list of labels in case of dropdown
                      dropdownLabel: void 0, // String. Label to be used if multiple actions
                      reply: false // Boolean. If notification should take input. Value passed as third argument in callback and event emitter.
                    },
                    function(error, response, metadata) {
                      console.log("enviou notificao");
                      //opn('http://localhost/speedtest_admin/conexoes.php');

                    }
                  );
                } else {

                   notifier.notify(
                    {
                      title: "SPEEDTEST",
                      message: "Você está em "+name_current,
                      sound: true, // Case Sensitive string for location of sound file, or use one of macOS' native sounds (see below)
                      icon: 'Terminal Icon', // Absolute Path to Triggering Icon
                      contentImage: void 0, // Absolute Path to Attached Image (Content Image)
                      open: void 0, // URL to open on Click
                      wait: false, // Wait for User Action against Notification or times out. Same as timeout = 5 seconds

                      // New in latest version. See `example/macInput.js` for usage
                      timeout: 5, // Takes precedence over wait if both are defined.
                      closeLabel: void 0, // String. Label for cancel button
                      actions: void 0, // String | Array<String>. Action label or list of labels in case of dropdown
                      dropdownLabel: void 0, // String. Label to be used if multiple actions
                      reply: false // Boolean. If notification should take input. Value passed as third argument in callback and event emitter.
                    },
                    function(error, response, metadata) {

                     // console.log(response, metadata);
                      console.log("enviou notificao");
                    }
                  );


          
                }
                });

              }
            });

         });

          addQueryToDB(data);
          speedtest();
        });

        test.on('error', err => {
          console.error("erro detectado: ");
          speedtest();
        });
      }
    }

   
  }); 

}

speedtest();

function addQueryToDB(data){
  var isp = data.client.isp;
  var ip = data.client.ip;
  var download = data.speeds.download;
  var upload = data.speeds.upload;
  var ping = data.server.ping;
  var date = getDate();
  var time = getTime();

  get_just_ISP_IP_NAME_ID_byISP_IP(isp,ip, function (this_isp_ip_name_id){
      connection.query(`INSERT INTO speedtesttable(ip, isp, download, upload, ping, date, time, isp_ip_name_id) 
    VALUES('${ip}','${isp}','${download}','${upload}','${ping}','${date}','${time}','${this_isp_ip_name_id}')`);
  console.log('added to db!\n');
  });


}



function getLocalName(isp,ip,callback){
  connection.query(`SELECT name FROM isp_ip_name_table WHERE isp='${isp}' AND ip='${ip}'`, (err,rows) => {
      if (err) {
        console.log(err);
      }
      callback(rows[0].name);
    });
}

function getLocalNameById(id,callback){

  console.log("id_getlocalnamebyid():"+id);

  connection.query(`SELECT name FROM isp_ip_name_table WHERE id='${id}'`, (err,rows) => {
      if (err) {
        console.log(err);
      }
      callback(rows[0].name);
    });
}

function getIsp_Ip_Name_Id_OfCurrentConnection(this_isp_ip_name,callback){
  connection.query(`SELECT isp_ip_name FROM current_connection WHERE id=1`, (err,rows) => {
      if (err) {
        console.log(err);
      }
      if (rows[0].isp_ip_name == ""){
        updateCurrentConnection(this_isp_ip_name);
        callback(this_isp_ip_name);
      } else {
        callback(rows[0].isp_ip_name);
      }
      //console.log("current_isp_connection:"+rows[0].isp_ip_name);
    });
}

function getISPbyID(id,callback){
 connection.query(`SELECT isp FROM isp_ip_name_table WHERE id='${id}'`, (err,rows) => {
      if (err) {
        console.log(err);
      }
      callback(null,rows[0].isp);
      //return rows[0].isp;
      //console.log("current_isp_connection:"+rows[0].isp_ip_name);
    });
}

function getIPbyID(id){
 connection.query(`SELECT ip FROM isp_ip_name_table WHERE id='${id}'`, (err,rows) => {
      if (err) {
        console.log(err);
      }
      return rows[0].ip;
      //console.log("current_isp_connection:"+rows[0].isp_ip_name);
    });
}

function getISP_IP_NAME_ID_byISP_IP(isp,ip,callback){
 connection.query(`SELECT id FROM isp_ip_name_table WHERE isp='${isp}' AND ip='${ip}'`, (err,rows) => {

      if (err) {
        console.log(err);
      }
      if (!isEmptyObject(rows)){
        callback(rows[0].id);
      } else {
        connection.query(`INSERT INTO isp_ip_name_table(name, isp, ip, pacote)
        VALUES('SEM NOME','${isp}','${ip}','0')`, function(err,result){
           if (err) throw err;
           console.log('conexao add ao isp_ip_name_table!\n');
           callback(result.insertId);
        });
      }
      //console.log("current_isp_connection:"+rows[0].isp_ip_name);
    });
}

function get_just_ISP_IP_NAME_ID_byISP_IP(isp,ip,callback){
 connection.query(`SELECT id FROM isp_ip_name_table WHERE isp='${isp}' AND ip='${ip}'`, (err,rows) => {
      if (err) {
        console.log(err);
      }
      if (!isEmptyObject(rows)){
        callback(rows[0].id);
      }
      //console.log("current_isp_connection:"+rows[0].isp_ip_name);
    });
}

function getDate() {

    var date = new Date();

    var year = date.getFullYear();

    var month = date.getMonth() + 1;
    month = (month < 10 ? "0" : "") + month;

    var day  = date.getDate();
    day = (day < 10 ? "0" : "") + day;

    return year + "-" + month + "-" + day;

}

function getTime() {

    var date = new Date();

    var hour = date.getHours();
    hour = (hour < 10 ? "0" : "") + hour;

    var min  = date.getMinutes();
    min = (min < 10 ? "0" : "") + min;

    var sec  = date.getSeconds();
    sec = (sec < 10 ? "0" : "") + sec;

    return hour + ":" + min + ":" + sec;

}

function updateCurrentConnection(isp_ip_name_of_current_connection) {
  connection.query(
    'UPDATE current_connection SET isp_ip_name = ? Where ID = ?',
    [isp_ip_name_of_current_connection, 1],
    (err, result) => {
      if (err) throw err;
      }
  );
}

function isEmptyObject(obj) {
  for (var key in obj) {
    if (Object.prototype.hasOwnProperty.call(obj, key)) {
      return false;
    }
  }
  return true;
}
