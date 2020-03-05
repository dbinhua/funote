c_ws = new WebSocket(count_ws);

c_ws.onerror = function (event) {};

c_ws.onopen = function (event){
    //心跳检测
    var send_data = {'type': 99};
    setInterval(function () {c_ws.send(JSON.stringify(send_data))},40000);
    Message();
};

function Message(){
    c_ws.onmessage = function (event) {
        var serv_data = JSON.parse(event.data);

        switch (serv_data.code) {
            case 200:  //服务器连接成功
                fd = serv_data.fd;
                var new_user = {'type': 1, 'fd': fd, 'user_id': user_id};
                c_ws.send(JSON.stringify(new_user));
                break;

            case 1:
                users_count = serv_data.users_count;
                pages_count = serv_data.pages_count;
                $('#users_count').text('当前在线人数:' + users_count);
                $('#pages_count').text('当前打开页面数:' + pages_count);
                break;
        }
    };
}

var fd = 0;
var users_count = 0;
var pages_count = 0;
