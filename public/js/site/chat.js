$(document).ready(function(){
    initWebSocket();
});

var timestamp = (Date.parse(new Date())) / 1000;
var selected_chat_dom_id = '';        //当前选中的会话DOM id
var userinfo = $('#userinfo').val() ? JSON.parse($('#userinfo').val()) : null;
var data = {
    fd: 0,          //当前客户端fd
    current_chat_id: '',    //当前所在会话id
    user_id: userinfo ? userinfo.id : 0,      //用户uid
    name: userinfo ? userinfo.name : '游客' + timestamp,   //用户名
    avatar: userinfo ? userinfo.avatar : '../../images/default_face.png'    //头像
};

function initWebSocket(){
    ws = new WebSocket(chat_ws);
    wsError();
    wsOpen();
    wsMessage();
    wsClose();
}

function wsError() {
    ws.onerror = function (event) {

    };
}

function wsOpen() {
    ws.onopen = function (event){
        //心跳检测
        var send_data = {"type": 99};
        setInterval(function () {ws.send(JSON.stringify(send_data))},40000);

        //对未登录且没有提示过的用户给出提示
        var tip_flag = getCookie("TIP_GUEST_TO_LOGIN");
        if (data.user_id == 0 && !tip_flag){
            $('.ui.basic.modal').modal('show');
            setCookie("TIP_GUEST_TO_LOGIN", 1);
        }
    };
}

//处理消息
function wsMessage() {
    ws.onmessage = function (event) {
        var serv_data = JSON.parse(event.data);

        switch(serv_data.code){
            case 200:  //服务器连接成功
                initChat(serv_data.chat_list);     //初始化会话列表 & 聊天窗口
                data.fd = serv_data.fd;
                data.current_chat_id = serv_data.chat_list[0].id;    //第一个会话的chatID
                var new_user = {"type": 1, "fd": data.fd, "chat_id": data.current_chat_id, "user_id": data.user_id, "name": data.name};
                ws.send(JSON.stringify(new_user));
                break;

            case 1:  //广播用户上线消息
                initChat(serv_data.chat_list, false);
                addChatLine('newlogin', serv_data.userinfo);
                break;

            case 2:
                serv_data.msginfo.avatar = data.avatar;
                if(serv_data.own){
                    addChatLine('mymessage', serv_data.msginfo);
                    $("#chattext").val('');
                }else{
                    addChatLine('chatLine', serv_data.msginfo, serv_data.msginfo.chat_id);
                    if(serv_data.remains){
                        for(var i = 0; i < serv_data.remains.length; i++){
                            if(data.fd == serv_data.remains[i].fd){
                                addChatLine('at', serv_data.msginfo);
                            }
                        }
                    }

                    //增加消息
                    // chat.showMsgCount(d.data.roomid,'show');
                }
                break;

            case 3:
                initChat(serv_data.chat_list, false);
                addChatLine('logout', serv_data.userinfo, serv_data.userinfo.chat_id);
                break;
        }
    }
}

//退出聊天
function wsClose() {

}

//发送消息
function sendMessage(){
    var message = $('#chattext').val();
    if(message.length == 0) return false;

    var json = {"type": 2,"name": data.name, "newmessage": message, "c": "text", "fd": "", "chat_id": data.current_chat_id};
    ws.send(JSON.stringify(json));
    return true;
}

//发送按钮 & 换行操作
$('#chattext').keydown(function (event) {
    $('#at-block-' + data.current_chat_id).css('display','none');
    if (event.ctrlKey && event.keyCode == 13) {
        $('#chattext').val($('#chattext').val() +  "\r\n");
    }else if(event.keyCode == 13){
        event.preventDefault();     //避免回车换行
        sendMessage();
    }else if (event.key == '@'){  //展示这个列表一定要在keydown事件中判断，不能在keyup事件中判断，否则有几率会失败！
        $('#at-block-' + data.current_chat_id).css('display','block');
    }
});

$('#chattext').focus(function () {
    $('#at-block-' + data.current_chat_id).css('display','none');  //@好友列表消失
    $(".faceDiv").css("display","none");                          //表情列表消失
});

function choose(name){
    $('#at-block-' + data.current_chat_id).css('display','none');
    $('#chattext').val($('#chattext').val() + name + ' ');
    $('#chattext').focus();
}

function addChatLine(element,serv_data, chat_id = ''){
    var markup = render(element,serv_data);
    if (chat_id != ''){
        $("#chatLineHolder-" + chat_id).append(markup);
    }else{
        $("#chatLineHolder-" + data.current_chat_id).append(markup);
    }
    scrollDiv('chat-lists');
}

function scrollDiv(element){
    var mai = document.getElementById(element);
    mai.scrollTop = mai.scrollHeight + 100;    //通过设置滚动高度
}

//处理选中会话时的逻辑
function selectTarget(elementId,targetId) {
    $("#"+selected_chat_dom_id).removeClass('chat-active');
    $("#"+elementId).addClass('chat-active');

    $("#chat-lists").children().css("display","none");
    $("#chatLineHolder-" + targetId).css('display',"block");

    $("#right-content-" + data.current_chat_id).css('display',"none");
    $("#right-content-" + targetId).css('display',"block");

    selected_chat_dom_id = elementId;
    data.current_chat_id = targetId;
}

function initChat(data, init_chat_content = true) {
    var chat_lists = [];            //会话列表
    var chat_content_lists = [];    //聊天内容窗口

    var attach_bar_lists = [];      //右侧附加信息条
    var member_lists = [];          //群组成员

    var at_div_lists = [];          //at选择群成员的div列表
    var at_member_lists = [];       //at的群成员列表

    if(data.length){
        var display = 'none';
        for(var i = 0; i < data.length; i++){
            if(i == 0){
                selected_chat_dom_id = 'conv-lists-' + data[i].id;
                display = 'block';                  //默认公开第一个聊天记录
            }

            if (members = data[i].group_members){
                data[i].members_count = members.length;
            }

            //初始化会话列表
            chat_lists.push(chatlists_new(data[i],'block',i));

            //初始化聊天窗口
            if (init_chat_content){
                chat_content_lists.push(chatlists(data[i].id,display));
            }

            //初始化右侧附加信息栏(只有群组会话才需要展示)、@好友容器列表
            if (data[i].type == 2){
                attach_bar_lists.push(attach_bar(data[i],display));
                at_div_lists.push(at_content(data[i]));
            }

            display = 'none';
        }

        if (init_chat_content){
            $("#chat-lists").html(chat_content_lists.join(''));
        }
        $("#lists").html(chat_lists.join(''));
        $("#attach_lists").html(attach_bar_lists.join(''));
        $('#at-content').html(at_div_lists.join(''));

        //填充群成员列表 & @好友列表
        for(var i = 0; i < data.length; i++){
            if (data[i].type == 2){
                for (var j = 0; j < data[i].group_members.length; j++){
                    member_lists.push(group_member(data[i].group_members[j]));
                    at_member_lists.push(at_content_member(data[i].group_members[j]));
                }
            }
            $('#group_member-' + data[i].id).html(member_lists.join(''));
            $('#at-block-member-' + data[i].id).html(at_member_lists.join(''));
        }
    }
}

$(".emotion_btn").click(function(){
    $(".faceDiv").css("display","block");
});

$(".faceDiv>img").click(function(){
    insertAtCursor($("#chattext")[0],"["+$(this).attr("value")+"]");
});

function insertAtCursor(myField, myValue) {
    if (document.selection) {
        myField.focus();
        sel = document.selection.createRange();
        sel.text = myValue;
        sel.select();
    } else if (myField.selectionStart || myField.selectionStart == "0") {
        var startPos = myField.selectionStart;
        var endPos = myField.selectionEnd;
        var restoreTop = myField.scrollTop;
        myField.value = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos, myField.value.length);
        if (restoreTop > 0) {
            myField.scrollTop = restoreTop;
        }
        myField.focus();
        myField.selectionStart = startPos + myValue.length;
        myField.selectionEnd = startPos + myValue.length;
    } else {
        myField.value += myValue;
        myField.focus();
    }
    $(".faceDiv").css("display","none");
}
