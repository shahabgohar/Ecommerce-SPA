
require('./UserBootstrap');
import {store} from "./src/store/store";
import Toast from '../../node_modules/vue-toastification';
import VuePageTransition from '../../node_modules/vue-page-transition';
import Vuex from 'vuex';
window.Vue = require('vue');
Vue.use(Vuex);
Vue.use(VueRouter);
Vue.use(VuePageTransition);
const options={};
Vue.use(Toast,options);
Vue.component('navbar',require('./components/NavBarComponent.vue').default);
Vue.component('footercomp',require('./components/FooterComponent.vue').default);
import MianComponent from './components/MianComponent';
import CommentSystemComponent from './components/CommentSystemComponent';

import VueRouter from 'vue-router';
import Item from './components/Item';
const routes=[

{
    path:'/product/:item',
    name:'product',
    component:Item
},

];

const router= new VueRouter({
    mode:'history',
    routes
});
import SignUpComponent from "./components/SignUpComponent";
import SignInComponent from "./components/SignInComponent";
const app = new Vue({
    router,
    store,
    el: '#apps',
    data:{
        SignUp:false,
        LogIn:false,
        userlog:false,
        token:null,
    },
    components:{MianComponent:MianComponent,ItemComp:Item,SignUpComponent,SignInComponent},
    mounted:function()
    {

        // let resposne=function(res)
        // {
        //     if(res.data.auth==true)
        //     {
        //         this.userlog=true;
        //     }else{
        //         this.userlog=false;
        //     }
        // }
        // resposne=resposne.bind(this);
        // let error = function(err){
        //     this.userlog=false;
        // }
        // error=error.bind(this);
        // if(this.token!=null)
        // {
        //     axios.post('/api/VerifyToken',{
        //         token:this.token
        //     }).then(resposne).catch(error);
        // }

    }
    ,watch:{
        $route:function(prev,next){

            if(this.$route.path == '/')
            {
                this.$refs.maincomp.ProductPage=false;
            }else{
                this.$refs.maincomp.ProductPage=true;
            }
        }
    },
    computed:{
        MainComponentDisplay(){
            if(this.SignUp)
            {
                return false;
            }
            if(this.LogIn)
            {
                return false;
            }
            return true;
        }
    },
    methods:{
        ShowSignUp()
        {
            event.preventDefault();
            this.SignUp=true;
            this.LogIn=false;
        },
        ShowLogIn(){
            this.SignUp=false;
            this.LogIn=true;
        },
        CloseSignUpShowLogIn()
        {
            event.preventDefault();
            this.SignUp=false;
            this.LogIn=true;
        },
        ShowMain()
        {
            event.preventDefault();
            this.SignUp=false;
            this.LogIn=false;
        },
        responselogged()
        {
            this.userlog=true;
        },
        UserSignIn()
        {
            this.userlog=true;
        }


    }
});





