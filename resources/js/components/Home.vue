<template>
    <div>
        <div class="container-fluid hero-section d-flex align-content-center justify-content-center flex-wrap ml-auto">
            <h2 class="title">Just a laravel/Vue Store</h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 product-box" v-for="(product,index) in products" :key="index">
                            <router-link :to="{ path: '/product/'+product.id}">
                                <img :src="product.image" :alt="product.name">
                                <h5>
                                    <span>{{product.name}}</span>
                                    <span class="small-text text-muted">$ {{product.price}}</span>
                                </h5>
                                <button class="col-md-4 btn btn-sm btn-primary float-right">Buy Now</button>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name:'Home',
        data(){
            return {
                products : []
            }
        },
        mounted(){
            // Fetch the products from /products
            axios
            .get('/products')
            .then(response => this.products = response.data)      
        }
    }
</script>
<style scoped>
.small-text {
    font-size: 14px;
}
.product-box {
    border: 1px solid #cccccc;
    padding: 10px 15px;
}
.hero-section {
    height: 30vh;
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