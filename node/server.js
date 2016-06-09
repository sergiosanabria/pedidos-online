var server = require('http').createServer();
var io = require('socket.io')(server);
var mysql = require('mysql');
var MySQLEvents = require('mysql-events');
var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;





//Add a connect listener
io.on('connection', function (client) {
    console.log('client connected mati sela');
});


//Add a disconnect listener
io.on('disconnect', function (client) {
    console.log('client disconnected');
});

//
//setInterval(function () {
//    ajaxDatos('http://fundacionpim.com.ar/radar-cultural-backend/api/noticias');
//
//
//}, 3000);

/*Evento en base de datos*/
const MYSQL_DATABASE = "pedidosonline";


var dsn = {
    host: 'localhost',
    user: 'root',
    password: 'root',
    database: MYSQL_DATABASE
};


var mysqlEventWatcher = MySQLEvents(dsn);

var watcher = mysqlEventWatcher.add(
    'pedidosonline.pedido_cabecera',
    function (oldRow, newRow) {
        //row inserted
        //if (oldRow === null) {
        //    //insert code goes here
        //}
        //
        ////row deleted
        //if (newRow === null) {
        //    //delete code goes here
        //}
        //
        ////row updated
        //if (oldRow !== null && newRow !== null) {
        //    //update code goes here
        //}

        if (oldRow === null || (oldRow !== null && newRow !== null)) {
            ajaxDatos('http://fundacionpim.com.ar/radar-cultural-backend/api/noticias');
        }


    },
    'Active'
);



//Defining port
server.listen(5000);

function ajaxDatos(url) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            io.emit('envio', {data: xhttp.responseText});
            console.log(xhttp.responseText);
        }else{
            return false;
        }
    };
    xhttp.open("GET", url, true);
    xhttp.send();
}