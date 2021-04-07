<style>
    .text-orange {color: #F2711C;}
    .text-grey {color: #767676;}
</style>
<div class="left ui rail" style="left: -90px;top: 0;width: 66px;">
    <div class="ui sticky">
        <div class="ui mini vertical labeled icon menu" style="width: 66px;">
            <a class="item my-popup @if($action === 'create') active @endif" data-content="新建文章" data-position="right center" href="{{ route('article.create-page') }}">
                <i class="edit icon @if($action === 'create') orange @else grey @endif"></i>
                @if($action === 'create')
                    <b class="text-orange">新建</b>
                @else
                    <span class="text-grey">新建</span>
                @endif
            </a>
            <a class="item my-popup @if($action === 'manage') active @endif" data-content="管理文章" data-position="right center" href="{{ route('article.manage') }}">
                <i class="book icon @if($action === 'manage') orange @else grey @endif"></i>
                @if($action === 'manage')
                    <b class="text-orange">管理</b>
                @else
                    <span class="text-grey">管理</span>
                @endif
            </a>
        </div>
    </div>
</div>
