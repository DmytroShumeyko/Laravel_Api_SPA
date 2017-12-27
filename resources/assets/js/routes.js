import Vue from 'vue'
import VueRouter from 'vue-router';

Vue.use(VueRouter);

let routes = [
    {
        path: `/`,
        component: require('./views/Dashboard'),
    },
    {
        path: '/company/:id',
        name: 'company',
        component: require('./views/Company'),
        props: true
    },
    {
        path: '/products',
        component: require('./views/Products')
    },
    {
        path: '/product/:id',
        name: 'product',
        component: require('./views/Product'),
        props: true
    },
    {
        path: '/vendors',
        component: require('./views/Vendors')
    },
    {
        path: '/vendor/:id',
        name: 'vendor',
        component: require('./views/Vendor'),
        props: true
    },
    {
        path: '/sales',
        component: require('./views/Sales')
    },
    {
        path: '/sale/:id',
        name: 'sale',
        component: require('./views/Sale'),
        props: true
    },
    {
        path: '/orders',
        component: require('./views/Orders')
    },
    {
        path: '/order/:id',
        name: 'order',
        component: require('./views/Order'),
        props: true
    },
    {
        path: '/users/:id',
        name: 'users',
        component: require('./views/User'),
        props: true
    },
];

const router = new VueRouter({
    routes,
    mode: 'history',
    scrollBehavior: function (to, from, savedPosition) {
        if (to.hash) {
            return {selector: to.hash}
        } else {
            return {x: 0, y: 0}
        }
    },


});

export default router