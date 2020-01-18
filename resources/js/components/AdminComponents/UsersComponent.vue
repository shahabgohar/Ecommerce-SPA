<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Reset Password</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Shopping Site</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="card">

                                <div class="card-header">

                                    <h3 class="card-title">Reset Your Password</h3>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">

                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Previos Password</label>
                                            <input type="password" class="form-control" v-model="prev" id="exampleInputPassword1" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="examplePassword1">New Password</label>
                                            <input type="password" class="form-control" v-model="update" id="examplePassword1" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="examplePassword">Confirm New Password</label>
                                            <input type="password" class="form-control" v-model="confirm" id="examplePassword" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-primary" @click="Change">Change Password</button>
                                        {{error}}

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
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
                prev: null,
                update: null,
                confirm: null,
                error:null
            }
        },
        mounted() {

        },
        methods:{
            Change(){
                event.preventDefault();
                let response = function (res){
                    console.log(res)
                    alert("password reset success")
                }
                let error = function(err){
                    console.log(err);
                    alert("Failed to reset your password")
                }
                response=response.bind(this);
                error=error.bind(this);
                if(this.update==this.confirm) {

                    axios.post('api/user/change/password', {
                        token: this.$store.getters.getToken,
                        password:this.update,
                    }).then(response).catch(error);
                }
            }
        }
    }
</script>

<style scoped>

</style>
