<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" v-model="name" required autofocus>
                                    </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" v-model="password_confirmation" required>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <p class="feedback" v-if="feedback">{{feedback}}</p>
                                    <button type="submit" class="btn btn-primary" @click="handleSubmit">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Register' ,
    props: ['nextUrl'],
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            feedback: null
        }
    } ,
    methods: {
        handleSubmit(e) {
            e.preventDefault();
             if (this.password !== this.password_confirmation || this.password.length <= 0) {
                this.password = ""
                this.password_confirmation = ""
                this.feedback = 'Passwords Do Not Match'
                return;
            }
            else
            {
                this.feedback = null;
                let name = this.name;
                let email = this.email;
                let password =  this.password;
                let c_password = this.password_confirmation;

                //post to api/register
                axios
                .post('/register' , {name , email , password , c_password})
                .then(response => {
                    let data = response.data;
                    let user = data.user;
                    let token = data.token;

                    //set user and token to localStorage
                    localStorage.setItem('bigStore.user' , JSON.stringify(user));
                    localStorage.setItem('bigStore.jwt' , token);

                    if (localStorage.getItem('bigStore.jwt') !== null) 
                    {
                        //pass back to parent logged In event
                        this.$emit('loggedIn');
                        if (this.$route.query.nextUrl !== undefined) 
                        {
                            this.$router.push(this.$route.query.nextUrl);
                        }
                        else
                        {
                            if (this.$router.path !== '/') 
                            {
                                this.$router.push({name:'home'});
                            }
                        }
                    }
                })
                
            }
        }
    }
}
</script>
<style scoped>
.feedback {
    color: red;
}
</style>