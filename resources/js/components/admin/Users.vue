<template>
    <div>
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Joined</td>
                    <td>Total Orders</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user,index) in users" :key="index">
                    <td>{{index+=1}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <!--using vue moment-->
                    <td>{{user.created_at | moment("dddd, MMMM Do YYYY")}}</td>
                    <td>{{user.orders.length}}</td>
                </tr>
            </tbody>
        </table>        
    </div>
</template>
<script>
export default {
    name: 'Users',
    data() {
        return {
            users: null
        }
    } , 
    created() {
        axios.get('/users')
        .then(response => {
           this.users = response.data;
        })
    }
}
</script>