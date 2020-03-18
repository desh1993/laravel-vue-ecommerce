<template>
    <div>
        <div class="container-fluid hero-section d-flex align-content-center justify-content-center flex-wrap ml-auto">
            <h2 class="title">All your orders</h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <div class="row">
                        <div class="col-md-4 product-box" v-for="(order,index) in orders" :key="index">
                            <img :src="order.product.image" :alt="order.product.name">
                            <h5>
                                <span>{{order.product.name}}</span>
                                <span class="small-text text-muted">${{order.product.price}}</span>
                            </h5>
                            <hr>
                            <span class="small-text text-muted">
                                Quantity: {{order.quantity}}
                                <span class="float-right">
                                    Shipped: {{order.is_delivered === 1 ? 'Shipped' : 'Not Delivered'}}
                                </span>
                            </span>
                            <br><br>
                            <p>
                                <strong>Delivery Address:</strong><br>
                                {{order.address}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            orders: [],
            user:{},
        }
    } ,
    created() {
        // get all the orders based on this user
        this.user = JSON.parse( localStorage.getItem('bigStore.user'));
        // to prevent {"message":"Unauthenticated."} error message
        axios.defaults.headers.common['Content-Type'] = 'application/json'
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('bigStore.jwt')

        let id = this.user.id;
        axios
        .get(`users/${id}/orders`)
        .then(response => {
            this.orders = response.data;
            console.log(this.orders);
        });
    }
}
</script>
<style scoped>

</style>