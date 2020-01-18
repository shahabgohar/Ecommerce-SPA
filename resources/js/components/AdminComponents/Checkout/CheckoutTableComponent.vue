<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Remove</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(checkout,index) in CheckOutList" v-bind:key="index">
                            <td>{{checkout.id}}</td>
                            <td>{{checkout.ProductName}}</td>
                            <td>{{checkout.quantity}}</td>
                            <td>{{checkout.ProductPrice*checkout.quantity}}</td>
                            <td><a href="" @click="Deletethis(checkout.id)"> <i class="fas fa-trash-alt"></i></a></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                CheckOutList:null
            }
        }
        , mounted:function(){
            console.log("Check out component table has been mounted");
        this.Refresh();
        },
        methods:{
            Refresh()
            {
                // response will run on the successfull completion of the function
                var response=function(respons){
                    console.log(respons);
                    this.CheckOutList=respons.data;
                    this.$store.dispatch('SetCheckout',{mesg:this.CheckOutList});

                };
                var error=function(error){
                    console.log(error);
                }
                window.axios.post('/api/checkout/index',{token:this.$store.getters.getToken}).then(response.bind(this)).catch(error);
            },
            Deletethis(value)
            {
                event.preventDefault();
                let response = function(res){
                    this.Refresh();
                    console.log(res);
                }
                response=response.bind(this);
                let error = function(err)
                {
                    console.log(err);
                }
                error=error.bind(this);
                axios.post('api/delete/checkout',{
                id:value,
                    token:this.$store.getters.getToken
                }).then(response).catch(error)

            },

        }
    }
</script>
