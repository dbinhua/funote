import Main from '../components/main/main'

export const routes = [
    {
        path: '/',
        name: 'home',
        meta: {
            title: 'Funote后台管理系统'
        },
        component: () => import('../components/main/main')
    },
    {
        path: '/login',
        name: 'login',
        meta: {
            title: '登录'
        },
        component: () => import('../views/login/login')
    },
]
