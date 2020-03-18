import Vue from 'vue';
import VueRouter from 'vue-router';
import VueMoment from 'vue-moment';

Vue.use(VueRouter);
Vue.use(VueMoment);

import About from './components/About';
import Admin from './components/Admin';
import App from './components/App';
import Checkout from './components/Checkout';
import Confirmation from './components/Confirmation';
import Home from './components/Home';
import Login from './components/Login';
import Register from './components/Register';
import SingleProduct from './components/SingleProduct';
import UserBoard from './components/UserBoard';


//Testing
import Test from './components/Test';
import Search from './components/Search';
import Base from './components/admin/main-base-layout';
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        } , 
        {
            path: '/about',
            name: 'about',
            component: About ,
            meta : {
                requiresAuth: true , 
                is_admin: true
            }
        } , 
        {
            path: '/login',
            name: 'login',
            component: Login
        } , 
        {
            path: '/register',
            name: 'register',
            component: Register
        } , 
        {
            path: '/product/:id',
            name: 'single-products',
            component: SingleProduct
        } , 
        {
            path: '/confirmation',
            name: 'confirmation',
            component: Confirmation
        } , 
        {
            //to access this route , example http://localhost:5001/checkout?pid=1
            path: '/checkout',
            name: 'checkout',
            component: Checkout,
            props: (route)=>({ pid: route.query.pid })
        } , 
        {
            //testing
            path: '/test/:name',
            name: 'test',
            component: Test,
            props: true
        } , 
        {
            //testing
            //example: http://localhost:5001/search?q=vue
            path: '/search', 
            component: Search, 
            props: (route) => ({ query: route.query.q })
        } , 
        {
            path: '/dashboard', 
            name: 'userboard',
            component: UserBoard, 
            meta : {
                requiresAuth: true,
                is_user: true
            }
        } , 
        {
            path: '/admin/:page' ,
            name: 'admin-pages',
            component: Admin , 
            props: true , 
            meta : {
                requiresAuth: true,
                is_admin: true
            }
        } , 
        {
            path: '/admin' ,
            name: 'admin' ,
            component: Admin,
            meta : {
                requiresAuth: true,
                is_admin: true
            }
        } ,
        {
            path: '/main-base' ,
            name: 'main-base' ,
            component: Base,
        }

    ],
});

// router.beforeEach((to , from ,next) => {
    
//     if (to.matched.some(record => record.meta.requiresAuth)) 
//     {
//         //if requires authentication proceed with first level checking
//         if (localStorage.getItem('bigStore.jwt') === null) 
//         {
//             //that means user is not authenticated
//             // redirect to login page
//             next({
//                 path: '/login',
//                 params: { nextUrl: to.fullPath }
//             });
//         }
//         else
//         {
//             //proceeding with second level checking to check if user is admin or regular user
//             let user = JSON.parse(localStorage.getItem('bigStore.user'));
//             //if user is admin
//             if (to.matched.some(record => record.meta.is_admin)) 
//             {
//                 if (user.is_admin === 1) 
//                 {
//                     //if user is admin , proceed
//                     next();
//                 }
//                 else
//                 {
//                     //if user is regular user, proceed to user dashboard
//                     next({name: 'userboard'});
//                 }
//             }
//             // if user is a regular user
//             else if(to.matched.some(record => record.meta.is_user))
//             {
//                 if (user.is_admin === 0) 
//                 {
//                     //if user is NOT AN admin , proceed
//                     next();
//                 }
//                 else
//                 {
//                     //if user is regular user, proceed to user dashboard
//                     next({name: 'admin'});
//                 }
//             }
//             next();
//         }
//     }
//     else
//     {
//         next();
//     }
// });

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) 
    {
        if (localStorage.getItem('bigStore.jwt') == null) 
        {
            next({
                path: '/login',
                //storing the path that the user requested before login
                query: { nextUrl: to.fullPath }
            });
        } 
        else 
        {
            let user = JSON.parse(localStorage.getItem('bigStore.user'));
            if (to.matched.some(record => record.meta.is_admin)) 
            {
                if (user.is_admin == 1) 
                {
                    next();
                }
                else 
                {
                    next({ name: 'userboard' });
                }
            }
            else if (to.matched.some(record => record.meta.is_user)) 
            {
                if (user.is_admin == 0) 
                {
                    next();
                }
                else 
                {
                    console.log('user is an admin');
                    next({ name: 'admin' });
                }
            }
            next();
        }
    } 
    else 
    {
        next();
    }
});

//remove the navigation duplication error
const originalPush = VueRouter.prototype.push;
VueRouter.prototype.push = function push(location) {
  return originalPush.call(this, location).catch(err => err);
}

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
