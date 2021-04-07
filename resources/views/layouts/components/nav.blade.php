<nav class="ui borderless menu top stackable" style="margin-bottom: 32px;height: 54px;">
    <div class="ui container">
        <div class="ui inline dropdown nav">
            <a href="{{ route('index') }}">
                <img class="ui avatar image"  src="{{ asset('images/logo.png') }}">
                <span class="text"><b>Funote</b></span>
            </a>

        </div>

        <a href="{{ route('index') }}" class="item secondary">工作笔记</a>
        <a href="{{ route('chat') }}" class="item secondary">聊天室</a>
        {{--                        <div class="ui simple item dropdown stackable secondary">--}}
        {{--                            IT风向标  <i class="dropdown icon"></i>--}}

        {{--                            <div class="ui menu stackable">--}}
        {{--                                <a href="#" class="item">--}}
        {{--                                    <i class="icon home"></i> 测试分类--}}
        {{--                                </a>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}

        {{--                        <form class="ui fluid search item secondary" action="#" method="GET">--}}
        {{--                            <div class="ui icon input">--}}
        {{--                                <input class="prompt" name="q" type="text" placeholder="搜索" autocomplete="off">--}}
        {{--                                <i class="search icon"></i>--}}
        {{--                            </div>--}}
        {{--                            <div id="search-result"></div>--}}
        {{--                        </form>--}}

        <div class="right menu stackable secondary">
            @auth
                <div class="ui simple item dropdown stackable nav-dropdown">
                    @if(strpos($userInfo->avatar, 'http') === false)
                        <img class="ui avatar image" src="{{ asset($userInfo->avatar) }}">
                    @else
                        <img class="ui avatar image" src="{{ $userInfo->avatar }}">
                    @endif
                    {{ Auth::user()->name }}  <i class="dropdown icon"></i>
                    <div class="ui menu stackable">
                        <a href="{{ route('user', Auth::user()->id) }}" class="item">
                            <i class="icon user"></i> 个人中心
                        </a>

                        @if(Auth::user()->rank == \App\Models\User\UserRank::SUPERVISOR)
                            <a href="{{ route('article.create-page') }}" class="item">
                                <i class="icon pencil alternate"></i> 新建文章
                            </a>
                            <a href="{{ route('article.manage') }}" class="item">
                                <i class="icon wrench"></i> 管理中心
                            </a>
                        @endif

                        <a  class="item no-pjax" onclick="logout()" data-method="POST">
                            <i class="icon sign out"></i> 退出登录
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <div class="item">
                    <a onclick="login()" href="javascript:;"><i class="icon sign in"></i> 登录 </a>
                </div>
            @endauth
        </div>

    </div>
</nav>
