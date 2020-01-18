<template>
    <div>
           <div class="tabs is-centered">
            <ul>
              <li class="is-active"><a>Product Category</a></li>
            </ul>
          </div>
           <div class="container">
         <div class="columns">
                <!-- categories -->

            <div class="column is-7">
                    <div class="card">

<!--                          <product-image></product-image>-->
                        <carousel data-index="0" :adjustableHeight="false" :per-page="1"  :mouse-drag="true">
                            <slide v-for="(img,index) in Images" v-bind:key="index">

                                <img v-bind:src="`data:image/png;base64,${img}`">
                            </slide>

                        </carousel>

                          </div>
            </div>

            <div class="column">
                    <div class="card">
                                <div class="media-content">
                                  <p class="title">{{this.product.Item_Name}}</p>
                                  <p class="subtitle is-6">@johnsmith</p>
                                </div>



                              <div class="content">
                                  <p class="title is-4">Price : {{this.product.Price}} </p>
                                  <p class="title is-4">Quantity Available: {{quantity}} </p>
                                  <div class="dropdown is-hoverable">
                                      <div class="dropdown-trigger">
                                          <button class="button" aria-haspopup="true" aria-controls="dropdown-menu4">
                                              <span v-if="quantity ==!null">Choose Quantity</span>
                                              <span v-if="quantity !=null">{{this.product.quantity}}</span>
                                              <span class="icon is-small">
        <i class="fas fa-angle-down" aria-hidden="true"></i>
      </span>
                                          </button>
                                      </div>
                                      <div class="dropdown-menu" id="dropdown-menu4" role="menu">
                                          <div class="dropdown-content">
                                              <div class="dropdown-item" v-for = "i in this.product.quantity">
                                                    <a @click="ChooseQuantity(i)">{{i}}</a>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <p class="title is-4">Price : {{price}}</p>
                                  <a class="button is-success" v-if="this.$store.getters.CheckUserLogIn" @click="Purchase(product,quantity)">Purchase</a>

                                  <br>
                                  <br>

                              </div>
                              </div>
                            </div>


<!--             Item Quantity -->


                          </div>
                          </div>



            <item-detail-component v-bind:description="desc"></item-detail-component>

            </div>


</template>

<script>

//import ProductImageComponent from './ProductImageComponent';
import ItemDetailComponent from './ItemDetailComponent';
import {Carousel,Slide} from '../../../node_modules/vue-carousel';
import StarRating from '../../../node_modules/vue-dynamic-star-rating';
export default {
    data()
    {
        return{
            product:null,
            productId:null,
            is_clicked:false,

            Images:null,
            desc:null,
            quantity:0,
            prevquantity:0,
            nextquantity:0,
            choosequantity:0,
            price:0
        }
    },
 mounted() {
         this.productId=this.$route.params.item;
        // console.log(this.product);
        // this.desc=this.product.Description;
        var response= function(res)
        {
           this.product = res.data.product;
            console.log(this.product)
           this.desc=res.data.product.Description;
           this.Images=this.product.images;
           this.quantity=this.product.quantity;

        }
        response=response.bind(this);
        axios.post('/api/home/item',{
            id:this.productId
        }).then(response).catch(function (error) {
            console.log(error);
        });

 }
    ,components:{ItemDetailComponent,Carousel,Slide,StarRating},
watch:{
  $route(to,from){
    console.log(to);
    console.log(from);
  }
},
    methods:{
        ChooseQuantity(val){
            event.preventDefault();
            if(this.prevquantity!=val) {
                if (this.prevquantity == 0)
                    this.prevquantity = val
                else {
                    let temp = this.prevquantity - val;
                    val = val + temp;
                }
                this.price = val * this.product.Price;
                this.product.quantity = this.product.quantity - val;
                this.choosequantity = val;
            }
        },
        Purchase(product,quan){
            event.preventDefault();
            console.log(product+" "+quan);
            if(this.quantity != null){
                let response=function(res){
                    this.quantity=this.quantity-res.data.quantity;
                }
                response=response.bind(this);
                let error = function(err){
                    console.log(err);
                }
                error =error.bind(this);
                axios.post('http://127.0.0.1:8000/api/checkout',{
                    id:this.$store.getters.GetUserToken,
                    productid:this.product.id,
                    quantity:this.choosequantity
                }).then(response).catch(error);
            }
        }
    }
}
</script>
