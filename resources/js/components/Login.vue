<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password" required>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <p class="feedback" v-if="feedback">{{feedback}}</p>
                                    <button type="submit" class="btn btn-primary" @click="handleSubmit">
                                        Login
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
    name: 'Login',
    data() {
        return {
            email: '',
            password: '',
            feedback: null
        }
    } ,
    mounted() {
        
    } ,
    methods: {
        handleSubmit(e) {
            e.preventDefault();
            let password = this.password;
            let email = this.email;
            if (email !== '' && password !== '') 
            {
                this.feedback = null;
                if (password.length > 0) 
                {
                    this.feedback = null;
                    axios
                    .post('/login' , {email , password})
                    .then(response => {
                        let data = response.data.response;
                        if (data !== 'unauthorized') 
                        {
                            this.feedback = null;
                            let user = data.user;
                            let is_admin = user.is_admin;
                            
                            // set local storage items
                            localStorage.setItem('bigStore.user' , JSON.stringify(user));
                            localStorage.setItem('bigStore.jwt' ,  data.token);

                            // get jwt token , if jwt token not null then it is login
                            if (localStorage.getItem('bigStore.jwt') !== null) 
                            {
                                //pass back to parent logged In event
                                this.$emit('loggedIn');
                                // Check if the user was sent to the login page from another page, then send the user to that page
                                if (this.$route.query.nextUrl !== undefined) 
                                {
                                    this.$router.push(this.$route.query.nextUrl);
                                }
                                else
                                {
                                    //if user came in directly 
                                    // if user is admin send him to admin dashboard
                                    // if user is regular user send him to user dashboard
                                    console.log('there');
                                    this.$router.push((is_admin == 1 ? 'admin' : 'dashboard'));
                                }
                            }

                        }
                        else
                        {
                            this.feedback = 'Incorrect login credentials';
                        }
                    })
                }
                else
                {
                    this.feedback = 'Please key in a password';
                }
            }
            else
            {
                this.feedback = 'Please enter password and email';
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