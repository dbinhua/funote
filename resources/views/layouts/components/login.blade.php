@if(Auth::guest())
<div class="ui mini modal" @error('email') style="display: block"@enderror>
    <i class="close icon"></i>
    <div class="five wide column">
        <div class="ui padded segment">
            <div class="content">
                <h3 style="text-align: center">登录</h3>

                <div class="ui divider"></div>

                @error('email')
                <div class="ui message error" id="login-error">
                    <i class="icon info"></i> {{ $message }}
                </div>
                @else
                <div class="ui message warning">
                    <i class="icon info"></i> 本站暂不开放注册哦～
                </div>
                @enderror

                <form class="ui form" role="form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="field @error('email') error @enderror">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" name="email" placeholder="请输入注册邮箱" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" placeholder="请输入密码" value="">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="remember">
                            <label>保持我的登录状态</label>
                        </div>
                    </div>

                    <button class="ui blue icon button fluid"> 登录 </button>
                    <div style="margin-top: 1rem;text-align: right">
                            <a href="#" target="_blank">
                                忘记密码?
                            </a>
                            <!--                        <a class="btn btn-link " href="https://learnku.com/auth/register" target="_blank">-->
                            <!--                            注册-->
                            <!--                        </a>-->
                        </div>

                    <div class="ui horizontal divider fs-tiny text-mute">
                            第三方账号登录
                        </div>
                    <a class="ui red fluid button" href="{{ route('weibo.login', ['refer' => \Illuminate\Support\Facades\URL::current()]) }}"><i class="weibo icon"></i> 微博 </a>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.ui.form').form({
            inline: true,
            fields: {
                email : {
                    rules: [
                        {
                            type: 'empty',
                            prompt: '邮箱不能为空'
                        },
                        {
                            type: 'email',
                            prompt: '请输入正确的邮箱'
                        }
                    ]
                },
                password : {
                    rules: [
                        {
                            type: 'empty',
                            prompt: '密码不能为空'
                        },
                        {
                            type: 'minLength[6]',
                            prompt: '密码至少6位'
                        }
                    ]
                }
            }
        });

        if($('#login-error').length){
            $('.ui.mini.modal').modal({
                blurring: true
            }).modal('show');
        }
    });

    function login() {
        $('.ui.mini.modal').modal({
            blurring: true
        }).modal('show');
    }
    // $(".anchor").bind("click touch",function(){
    //     $('html,body').animate({scrollTop: ($($(this).attr('href')).offset().top )},800);
    // });
</script>
@endif
<script type="text/javascript">
    function logout() {
        $('#logout-form').submit();
    }
</script>
