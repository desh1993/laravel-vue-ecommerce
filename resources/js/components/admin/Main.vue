<template>
    <div class="row">
        <div class="col-md-4 product-box d-flex align-content-center justify-content-center flex-wrap big-text">
            <a href='/admin/orders'>Orders ({{orders.length}})</a>
        </div>
        <hr>
        <div class="col-md-4 product-box d-flex align-content-center justify-content-center flex-wrap big-text">
            <a href='/admin/products'>Products ({{products.length}})</a>
        </div>
        <div class="col-md-4 product-box d-flex align-content-center justify-content-center flex-wrap big-text">
            <a href='/admin/users'>Users ({{users.length}})</a>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Main',
    data() {
        return {
            orders: [] ,
            products: [] ,
            users: [] , 
            user: null
        }
    } ,
    mounted() {
        axios.get('/orders').then(response => {
            this.orders = response.data;
        });
        axios.get('/products').then(response => {
            this.products = response.data;
        })
        axios.get('/users').then(response => {
            this.users = response.data;
        })
    }
}
</script>
<style scoped>

.big-text { 
    font-size: 28px; 
}

.product-box { 
    border: 1px solid #cccccc; 
    padding: 10px 15px; 
    height: 20vh 
}
</style>