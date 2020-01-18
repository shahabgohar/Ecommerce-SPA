<template>
<div class="columns">
    <div class="is-11 is-offset-1" style="padding-bottom:5%;width:100%;">
  <tabs-comp v-if="!ProductPage" @CategoryLoaded="SetFirstCategory" @LoadNext="FireNext"></tabs-comp>

<categories-item v-for="(load,index) in loader" v-bind:key="index" :Item="load" v-if="!ProductPage" @ShowItemDetails="ProductsData"></categories-item>

   <div v-if="!ProductPage" class="column is-half is-offset-5">
    <a v-if="NextPage != null" @click="clicke()" >show more</a>
</div>
    <vue-page-transition name="fade-in-right">
        <router-view/>
    </vue-page-transition>
</div>
</div>
</template>
<script>
import CategoriesItems from '../components/CategoriesItems.vue';
import TabsComponent from './TabsComponent';
export default {
    data(){
        return {
        loader:[],      //line 24
        ProductPage:false, //line 25
            CurrentCategory:1, //line 26

            NextPage:null, //lie28
        }
    },
    components:{categoriesItem:CategoriesItems,TabsComp:TabsComponent},
    mounted(){
this.loader=[];

    },

    methods:{
        clicke()
        {
            let response = function(res){
                console.log(res);
                this.loader.push(res.data.items.data);
                this.NextPage=res.data.items.next_page_url;


            }
            response=response.bind(this);
            let error = function(err){
                console.log(err);
            }
            error=error.bind(this);
            console.log(this.NextPage);
            axios.post(this.NextPage,{
                id:this.CurrentCategory
            }).then(response).catch(error);

        },
        ProductsData(){
            this.ProductPage=true;
        },
        SetFirstCategory(value){
            this.CurrentCategory=value;
            let response = function(res){
                console.log(res);
                console.log(res.data.next_page_url);
                this.NextPage=res.data.items.next_page_url;
                this.loader=[];
               this.loader.push(res.data.items.data);

            }
            response=response.bind(this);
            let error = function(err){
                console.log(err);
            }
            error=error.bind(this);
            axios.post('api/home',{
                id:this.CurrentCategory
            }).then(response).catch(error);
        },
        FireNext(id){
            this.loader=[];
            this.SetFirstCategory(id);
        }

    }
}
</script>
