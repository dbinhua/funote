function attach_bar(data, display){
    arr = ['<div class="right_content" style="display:',display,'" id="right-content-',data.id,'"><div style="max-height: 33%" id="cd_model-',data.id,'"><span class="right-title">群公告</span><div class="right-model-content" style="border-bottom: 1px solid rgb(230, 229, 230);"><p>',data.group_bulletin,'</p></div></div><div class="group_member_container" id="group_member_container-',data.id,'"><span class="right-title">群成员(',data.members_count,')</span><div id="group_member_parent" class="right-model-content"><ul class="group_member" id="group_member-',data.id,'"></ul></div></div></div>'];
    return arr.join('');
}

function group_member(data){
    arr = ['<ol><i class="black genderless icon"></i>',data.name,'</ol>'];
    return arr.join('');
}

function at_content(data){
    arr = ['<div class="at-block ui center floated raised segment" id="at-block-',data.id,'" style="display:none"><ul class="group_member" id="at-block-member-',data.id,'"></ul></div>'];
    return arr.join('');
}

function at_content_member(data){
    arr = ['<ol onclick="choose(\'',data.name,'\')"><a href="javascript:void(0)">',data.name,'</a></ol>'];
    return arr.join('');
}

function chatlists_new(data,is_none,index){
    var arr = [];
    if (index == 0){
        arr = ['<div class="conv-lists chat-active" id="conv-lists-',data.id,'" style="border-bottom: #eeeeee .5px solid;display:',is_none,'" onclick="selectTarget(\'conv-lists-',data.id,'\',',data.id,')"><div class="list-item conv-item context-menu conv-item-company"><i class="iconfont icon-delete-conv tipper-attached"></i><div class="avatar-wrap"><div class="group-avatar"><div><img class="ui rounded mini image" src=" ../../images/img01.jpg"></div></div></div><div class="conv-item-content"><div class="title-wrap info"><div class="name-wrap"><p class="name">',data.title,'</p></div><span class="time">上午 10:29</span></div></div></div></div>'];
    }else{
        arr = ['<div class="conv-lists" id="conv-lists-',data.id,'" style="border-bottom: #eeeeee .5px solid;display:',is_none,'" onclick="selectTarget(\'conv-lists-',data.id,'\',',data.id,')"><div class="list-item conv-item context-menu conv-item-company"><i class="iconfont icon-delete-conv tipper-attached"></i><div class="avatar-wrap"><div class="group-avatar"><div><img class="ui rounded mini image" src="../../images/img01.jpg"></div></div></div><div class="conv-item-content"><div class="title-wrap info"><div class="name-wrap"><p class="name">',data.title,'</p></div><span class="time">上午 10:29</span></div></div></div></div>'];
    }
    return arr.join('');
}

function chatlists(roomid,is_none){
    arr = [ '<div class="msg-items" id="chatLineHolder-'+roomid+'" style="display:',is_none,'"></div>'];
    return arr.join('');
}

function render(template,params){
    var arr = [];
    switch(template){
        case 'mymessage':
            arr = [
                '<div style="display: block;" class="msg-box"><div class="chat-item me"><div class="clearfix"><div class="avatar"><div class="normal user-avatar" style="background-image: url(',params.avatar,');"></div></div><div class="msg-bubble-box"><div class="msg-bubble-area"><div><div class="msg-bubble"><pre class="text" style="color: #566573">', params.newmessage,'</pre></div></div></div></div></div></div></div>'
            ];
        break;

        case 'chatLine':
            arr = [
                '<div style="display: block;" class="msg-box"><div class="chat-item not-me"><div class="chat-profile-info clearfix"><span class="profile-wrp"><span class="name clearfix"><span class="name-text">',params.name,'</span></span></span><span class="chat-time">',params.time,'</span></div><div class="clearfix"><div class="avatar"><div class="normal user-avatar" onclick="chat.remind(this)" fd="',params.fd,'" uname="',params.name,'" style="background-image: url(\'',params.avatar,'\');"></div></div><div class="msg-bubble-box"><div class="msg-bubble-area"><div class="msg-bubble"><pre class="text">',params.newmessage,'</pre></div></div></div></div></div></div>'
            ];
        break;
        
        case 'newlogin':
            arr = [
                '<div class="chat-status chat-system-notice">',params.name,'&nbsp;加入群聊</div>'
            ];
            break;
        case 'at':
            arr = [
                '<div class="chat-status chat-system-notice">',params.name,'&nbsp;@了你</div>'
            ];
            break;
        case 'logout':
            arr = [
                '<div class="chat-status chat-system-notice">',params.name,'&nbsp;退出了群聊</div>'
            ];
            break;
        case 'my':
            arr = [
                '<div class="big-52 with-border user-avatar" uid="',params.fd,'" title="',params.name,'" style="background-image: url(',params.avatar,');"></div>'
            ];
            break;
        case 'rooms':
            arr = [
                '<li class="menu-item ',params.selected,'" roomid="',params.roomid,'" onclick="chat.changeRoom(this)">',params.roomname,'<span id="message-',params.roomid,'">0</span></li>'
            ];
            break;
    }
    return arr.join('');
}
