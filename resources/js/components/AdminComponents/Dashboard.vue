<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{orders}}</h3>

                                <p>New Orders</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer" @click="LoadOrders">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{categories}}<sup style="font-size: 20px"></sup></h3>

                                <p>Categories</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer"  @click="category">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{users}}</h3>

                                <p>User Registrations</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer" @click="User">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{items}}</h3>

                                <p>Items</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer" @click="Items">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>

            </div>
        </section>
    </div>

</template>

<script>
    export default {
        name: "Dashboard.vue",
        data(){
            return {
                items:'No Items',
                orders:'no orders',
                users:'no users',
                visitors:'no visitors',
                categories:'no categories',
            }
        },
        mounted(){
            let response = function(res){
                console.log(res);
                console.log(res.data.dashboard[0][0].items);
                this.items=res.data.dashboard[0][0].items;
                this.categories=res.data.dashboard[1][0].categories;
                this.users=res.data.dashboard[2][0].users;
                this.orders=res.data.dashboard[3][0].orders;

            }
            response=response.bind(this);
            let error = function(err){
                console.log(err);
            }
            error = error.bind(this);
            axios.post('api/dashboard',{token:this.$store.getters.GetToken}).then(response).catch(error);
        }
        ,
        methods:{
            Items(){
                event.preventDefault();
                this.$router.push('/items');
            },
            User(){
                event.preventDefault();
                this.$router.push('/users');
            },
            category(){
                event.preventDefault();
                if(this.$store.getters.getAdminStatus)
                this.$router.push('/categories');
            },
            LoadOrders(){
                event.preventDefault();
                this.$router.push('/orders');
            }
        }
    }
</script>

<style scoped>

</style>
