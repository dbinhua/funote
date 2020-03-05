<template>
    <div class="container">
        <div class="login">
            <div class="login-header">
                <h2 style="text-align:center">欢迎登录</h2>
            </div>
            <div class="form-con">
                <Form ref="loginForm" :model="loginForm" :rules="rule">
                    <FormItem prop="user">
                        <Input type="text" v-model="loginForm.user" placeholder="请输入用户名" size="large">
                            <Icon type="ios-person-outline" slot="prefix"></Icon>
                        </Input>
                    </FormItem>
                    <FormItem prop="password">
                        <Input type="password" v-model="loginForm.password" placeholder="请输入密码" size="large">
                            <Icon type="ios-lock-outline" slot="prefix"></Icon>
                        </Input>
                    </FormItem>
                    <FormItem>
                        <Button type="primary" @click="handleSubmit('loginForm')" long size="large">登录</Button>
                    </FormItem>
                </Form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                loginForm: {
                    user: '',
                    password: ''
                },
                rule: {
                    user: [
                        { required: true, message: '账号不能为空', trigger: 'blur' }
                    ],
                    password: [
                        { required: true, message: '密码不能为空', trigger: 'blur' },
                        { type: 'string', min: 6, message: '密码不能少于6位', trigger: 'blur' }
                    ]
                }
            }
        },
        methods: {
            handleSubmit(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$Message.success('Success!');
                    } else {
                        this.$Message.error('Fail!');
                    }
                })
            }
        }
    }
</script>

<style scoped>
    html, body {
        margin:0;
        padding:0;
        height: 100%;
    }
    .container {
        height:100%;
        width:100%;
        position:fixed;
        background-image: url('../../assets/image/background.svg');
        background-repeat: no-repeat;
        background-position: 50%;
        background-size: 100%;
    }
    .login{
        width: 384px;
        margin: 50px auto;
    }
    .login-header{
        margin: 150px 0 25px 0;
    }
</style>
