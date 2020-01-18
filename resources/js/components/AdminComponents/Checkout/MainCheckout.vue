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
                <div class="container-fluid">alp
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card">
                                    <div class="card-header border-0">
                                        <h3 class="card-title">Checkout</h3>
                                    </div>
                                    <vue-page-transition name="fade-in-right">
                                    <checkout-table-component v-if="!ShowInvoiceComponent"></checkout-table-component>
                                    </vue-page-transition>
                                    <vue-page-transition name="fade-in-right">
                                    <invoice-component v-if="ShowInvoiceComponent" :adress="adress" @ShowPaymentForm="ShowPayment"></invoice-component>
                                    </vue-page-transition>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col text-center">
                            <label for="adress" v-if="showadress">Mailing Adress</label>
                            <input type="text" v-if="showadress" class="form-control" id="adress" v-model="adress" aria-describedby="emailHelp" placeholder="Enter adress">
                            <button @click="ShowInvoice" class="btn btn-default" v-if="this.$store.getters.CheckoutCount>0"  v-text="ButtonChange" >CheckOut</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import CheckoutTableComponent from './CheckoutTableComponent';
    import InvoiceComponent from "./InvoiceComponent";

    export default {
        components:{CheckoutTableComponent,InvoiceComponent},
        data(){
            return {
                ShowInvoiceComponent:false,
                choice:0,
                ButtonChange:"Checkout",
                ShowPayForm:false,
                adress:null,
                showadress:false,
                CheckoutCount:false,
            };
        },
        methods:{
    ShowInvoice()
    {
        event.preventDefault();
       switch (this.choice) {
           case 0:{
               this.ShowInvoiceComponent=false;
               this.showadress=true;
               this.ButtonChange="Submit Order";
               this.choice=1;
               break;
           }
           case 1:{
               if(this.adress!=null) {
                   this.showadress=false;
                   this.ButtonChange="Submit Order";
                   this.choice=2;
               }else{
                   alert("shipping adress cannot be null");
               }
               break;
           }
           case 2:{
               this.$store.dispatch('setadress',{mesg:this.adress})
              this.$store.dispatch('CreateOrder');
               this.choice=0;
               break;
           }


       }
    },
            ShowPayment()
                {
                    this.ShowInvoiceComponent=false;
                    this.ShowPayForm=true;
                },
                ClosePaymentForm()
                {
                    this.ShowPayForm=false;
                }
            }

    }
    </script>
