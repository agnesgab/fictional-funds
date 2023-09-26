import { createRouter, createWebHistory} from "vue-router";

import Home from '../components/Home.vue';
import AccountShow from '../components/Accounts/AccountShow.vue';
import TransactionIndex from '../components/Transactions/TransactionIndex.vue';
import TransactionCreate from '../components/Transactions/TransactionCreate.vue';
import UserShow from '../components/Users/UserShow.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/users',
        name: 'user.show',
        component: UserShow
    },
    {
        path: '/accounts',
        name: 'account.show',
        component: AccountShow,
    },
    {
        path: '/transactions',
        name: 'transaction.index',
        component: TransactionIndex
    },
    {
        path: '/new-transaction',
        name: 'transaction.new',
        component: TransactionCreate
    },
]

export default createRouter({
    history: createWebHistory(),
    routes
})
