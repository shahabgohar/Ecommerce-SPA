<template>
<div>
    <div>
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong>Admin, Inc.</strong><br>
                795 Folsom Ave, Suite 600<br>
                San Francisco, CA 94107<br>
                Phone: (804) 123-5432<br>
                Email: info@almasaeedstudio.com
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            To
            <address>
                <strong>John Doe</strong><br>
                795 Folsom Ave, Suite 600<br>
                San Francisco, CA 94107<br>
                Phone: (555) 539-1037<br>
                Email: john.doe@example.com
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Invoice #007612</b><br>
            <br>
            <b>Order ID:</b> 4F3S8J<br>
            <b>Payment Due:</b> 2/22/2014<br>
            <b>Account:</b> 968-34567
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Qty</th>
                    <th>Product</th>
                    <th>Serial #</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for ="(check,index) in checkout" v-bind:key="index">
                    <td>{{check.quantity}}</td>
                    <td>{{check.Item_Name}}</td>
                    <td>{{check.ProductId}}</td>
                    <td>{{check.quantity*check.price}} RS</td>
                </tr>

                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-6">
            <p class="lead">Payment Methods:</p>
            <img src="" alt="Visa">
            <img src="" alt="Mastercard">
            <img src="" alt="American Express">
            <img src="" alt="Paypal">
        </div>
        <!-- /.col -->
        <div class="col-6">
            <p class="lead">Amount Due 2/22/2014</p>

            <div class="table-responsive">
                <table class="table">

                    <tr>
                        <th>Total:</th>
                        <td>{{calculateAmount}} RS</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
    </div>

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-12">
            <button type="button"  class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                Payment
            </button>
        </div>
    </div>
</div>
    <!-- /.invoice -->
</template>

<script>
    export default {
        props:['adress'],
        name: "InvoiceComponent",
        data()
        {
            return{
                    ShowPayForm:false,
                checkout:null
            }
        },
        mounted() {
            let response = function(res){
                this.checkout=res.data;
            }
            response=response.bind(this);
            let error = function(err){
                console.log(err);
            }
            error=error.bind(this);
            axios.post('api/checkout/invoice',{
                id:1
            }).then(response).catch(error);
        }
        ,
        computed:{
          calculateAmount(){
              let total=0;
              for(let i=0;i<this.checkout.length;i++){
                  total+=this.checkout[i].price
              }
              return total;
          }
        },
        methods:{

        }

    }
</script>

<style scoped>

</style>
