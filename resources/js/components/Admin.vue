<template>
    <div>
        <div class="container-fluid hero-section d-flex align-content-center justify-content-center flex-wrap ml-auto">
            <h2 class="title">Admin Dashboard</h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <ul class="admin-ul">
                        <li class="active">
                            <button class="btn" @click="setComponent('main')">
                                Dashboard
                            </button>
                        </li>
                        <li>
                            <button class="btn" @click="setComponent('orders')">Orders</button>
                        </li>
                        <li>
                            <button class="btn" @click="setComponent('users')">Users</button>
                        </li>
                        <li>
                            <button class="btn" @click="setComponent('products')">Products</button>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <!--dynamic component for switching between components-->
                    <keep-alive>
                        <component :is="activeComponent"></component>
                    </keep-alive>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Main from './admin/Main';
import Users from './admin/Users';
import Products from './admin/Products';
import Orders from './admin/Orders';
export default {
    name: 'Admin' ,
    data() {
        return {
            activeComponent:null,
            user: null
        }
    } ,
    components : {
        Main , 
        Users ,
        Products , 
        Orders
    } ,
    methods : {
        // how to set components within a page
        // example if user clicks user button, user component loads within the same page
        setComponent(value) {
            switch (value) {
                case 'users':
                    this.activeComponent =  Users;
                    this.$router.push({name: 'admin-pages', params: {page: 'users'}});
                    break;
                case 'orders':
                    this.activeComponent =  Orders;
                    this.$router.push({name: 'admin-pages', params: {page: 'orders'}});
                    break;
                case 'products':
                    this.activeComponent =  Products;
                    this.$router.push({name: 'admin-pages', params: {page: 'products'}});
                    break;
                default:
                    this.activeComponent =  Main;
                    this.$router.push({name: 'admin'});
                    break;
            }
        }
    } , 
    created() {
        this.setComponent(this.$route.params.page);
        //save the user
        this.user = JSON.parse(localStorage.getItem('bigStore.user'));
        // avoid authorization error
         axios.defaults.headers.common['Content-Type'] = 'application/json'
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('bigStore.jwt')
    }
}
</script>
<style scoped>
.admin-ul {
    list-style: none;
}
.hero-section { 
    height: 20vh; 
    background: #ababab; 
    align-items: center; 
    margin-bottom: 20px; 
    margin-top: -20px; 
}
.title { 
    font-size: 60px; 
    color: #ffffff; 
}
</style>