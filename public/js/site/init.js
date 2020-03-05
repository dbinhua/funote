var protocolStr = document.location.protocol;

if (protocolStr == 'http:'){
    chat_ws = 'ws://127.0.0.1:9501';       //聊天专用
    count_ws = 'ws://127.0.0.1:9502';  //统计专用
}else if(protocolStr == 'https:'){
    chat_ws = "wss://" + document.location.hostname + "/wss";
    count_ws = 'wss://' + document.location.hostname + '/count_wss';
}
