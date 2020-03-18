<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="order-box">
                    <img :src="product.image" :alt="product.name">
                    <h2 class="title">{{product.name}}</h2>
                    <p class="small-text text-muted float-left">$ {{product.price}}</p>
                    <p class="small-text text-muted float-right">Available Units: {{product.units}}</p>
                    <br>
                    <hr>
                    <label class="row">
                        <span class="col-md-2 float-left">Quantity: </span><input type="number" name="units" min="1" :max="product.units" class="col-md-2 float-left" v-model="quantity" @change="checkUnits">
                    </label>
                </div>
                <div>
                    <div v-if="!isLoggedIn">
                        <h2>You need to login to continue</h2>
                        <button class="col-md-4 btn btn-primary float-left" @click="login">Login</button>
                        <button class="col-md-4 btn btn-danger float-right" @click="register">Create an account</button>
                    </div>
                    <!--if user is logged in-->
                    <div v-if="isLoggedIn">
                        <div class="row">
                            <label for="address" class="col-md-3 col-form-label">Delivery Address</label>
                            <div class="col-md-9">
                                <input id="address" type="text" class="form-control" v-model="address" required>
                            </div>
                        </div>
                    </div>
                    <br>
                    <p v-if="feedback" class="feedback">{{feedback}}</p>
                    <button class="col-md-4 btn btn-sm btn-success float-right" v-if="isLoggedIn" @click="placeOrder">Continue</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:'Checkout',
    props: ['pid'] ,
    data() {
        return {
            product: [] ,
            quantity: 1 ,
            isLoggedIn: null,
            address: '' , 
            feedback: null
        }
    } , 
    created() {
        //fetch data from products api
        axios
        .get('/products/' + this.pid)
        .then(response => {
            this.product = response.data;

            // get the user based on local Storage token
            if (localStorage.getItem('bigStore.jwt') !== null) 
            {
                this.user = JSON.parse(localStorage.getItem('bigStore.user'));
                axios.defaults.headers.common['Content-Type'] = 'application/json';
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('bigStore.jwt');
            }
        });
    } ,
    mounted() {
        this.isLoggedIn = localStorage.getItem('bigStore.jwt') !== null
    } ,
    methods : {
        checkUnits(e) {
            // check if the user is requesting more than the available units
            if (this.quantity > this.product.units) 
            {
                this.quantity = this.product.units;
                return this.feedback =  `There is currently only ${this.product.units} units available at the moment`;
            }
            this.feedback = null;
        } ,
        login() {
            this.$router.push({name: 'login', query: {nextUrl: this.$route.fullPath}})
        } ,
        register() {
            this.$router.push({name: 'register', query: {nextUrl: this.$route.fullPath}})
        } ,
        placeOrder(e) {
            if (this.address !== '') 
            {
                this.feedback = null;
                //sent to orders api  and store it
                axios.post(`orders` , {
                    address:this.address , 
                    quantity:this.quantity,
                    product_id:this.pid
                })
                .then(response => {
                    //route to confirmation page
                    this.$router.push({name: 'confirmation'});
                })
            }
            else
            {
                this.feedback = 'Please key in a valid Delivery address';
            }
        }
    }
   
}
</script>
<style scoped>
    .small-text { 
        font-size: 18px;
     }
    .order-box { 
        border: 1px solid #cccccc; 
        padding: 10px 15px; 
    }
    .title { 
        font-size: 36px;
    }
    .feedback {
        color: red;
    }
</style>