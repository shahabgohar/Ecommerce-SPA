<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
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

                                    <h3 class="card-title">DataTable with default features</h3>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Order Id</th>
                                            <th>Buyer</th>
                                            <th>Seller Id</th>
                                            <th>Product Name</th>
                                            <th>Product Id</th>
                                            <th>Quantity</th>
                                            <th>Delivery Adress</th>
                                            <th>Delivery Status</th>
                                            <th>Order Placed</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for = "(order,index) in orders" v-bind:key="index">
                                        <td> {{order.id }}</td>
                                            <td>{{order.BuyerName}}</td>
                                            <td>{{order.SalePerson}}</td>
                                            <td>{{order.ProductName}}</td>
                                            <td>{{order.ProductID}}</td>
                                            <td>{{order.quantity}}</td>
                                            <td>{{order.adress}}</td>
                                            <td>{{order.IsDeleivered}}</td>
                                            <td>{{order.created_at}}</td>
                                        </tr>

                                        </tbody>

                                    </table>
                                    <!-- pagination -->
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item">
                                                <a class="page-link" v-bind:ref="prev_page_url" @click="Prev" >Previous</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" v-bind:ref="next_page_url" @click="Next" >Next</a>
                                            </li>
                                        </ul>
                                    </nav>

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
        name: "OrderTableComponent.vue",
        data(){
            return {
                orders:null,
                next_page_url:null,
                prev_page_url:null,
            }
        }
        ,
        mounted() {
            let reponse = function(res){
                console.log(res);
                this.orders=res.data[0].data
                this.next_page_url=res.data[0].next_page_url;
                this.prev_page_url=res.data[0].prev_page_url;
            }
            reponse=reponse.bind(this);
            let error = function(err){
                console.log(err);
            }
            error=error.bind(this);
            axios.post('api/user/order',{token:this.$store.getters.getToken}).then(reponse).catch(error);
        },
        methods:{
            Prev(){
                let reponse = function(res){
                    console.log(res);
                    this.orders=res.data[0].data
                    this.next_page_url=res.data[0].next_page_url;
                    this.prev_page_url=res.data[0].prev_page_url;
                }
                reponse=reponse.bind(this);
                let error = function(err){
                    console.log(err);
                }
                error=error.bind(this);
                axios.post(this.prev_page_url,{token:this.$store.getters.getToken}).then(reponse).catch(error);
            },
            Next(){
                let reponse = function(res){
                    console.log(res);
                    this.orders=res.data[0].data
                    this.next_page_url=res.data[0].next_page_url;
                    this.prev_page_url=res.data[0].prev_page_url;
                }
                reponse=reponse.bind(this);
                let error = function(err){
                    console.log(err);
                }
                error=error.bind(this);
                axios.post(this.next_page_url,{token:this.$store.getters.getToken}).then(reponse).catch(error);
            }
        }
    }
</script>

<style scoped>

</style>
