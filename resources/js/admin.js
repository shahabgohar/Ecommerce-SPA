require('./bootstrap');
import {store} from "./src/admin/store";
import CKEditor from '../../node_modules/@ckeditor/ckeditor5-vue';
import Toast from '../../node_modules/vue-toastification';
import "../../node_modules/vue-toastification/dist/index.css";
import VuePageTransition from '../../node_modules/vue-page-transition';
import OrderTableComponent from "./components/AdminComponents/Orders/OrderTableComponent";
const options={};
window.Vue = require('vue');
Vue.use(VueRouter);
Vue.use(VuePageTransition);
Vue.use(CKEditor);
Vue.use(Toast,options);
// Vue.component('admin-comp',require('./components//AdminComponents/AdminNavigationComponent.vue').default);
import AdminNavigationComponent from './components/AdminComponents/AdminNavigationComponent';
import AdminAsideComponent from './components//AdminComponents/AdminAsideComponent';
import MainCategory from './components/AdminComponents/Categories/MainCategory';
import VueRouter from 'vue-router';
import MainItem from './components/AdminComponents/itemComponents/MainItem';
import MainCheckout from "./components/AdminComponents/Checkout/MainCheckout";
import Dashboard from './components/AdminComponents/Dashboard';
import UsersComponent from "./components/AdminComponents/UsersComponent";
const routes=[
    {
        path:'/categories',component:MainCategory
    },
    {
        path:'/items',component:MainItem
    },
    {
        path:'/checkout',component:MainCheckout
    },
    {
        path:'/dashboard',component:Dashboard
    },
    {
        path:'/users',component:UsersComponent
    },
    {
        path:'/orders',component:OrderTableComponent,
    }


    ];
    const router= new VueRouter({
        mode:'history',
        routes
    });
new Vue({
    router,
    el:'#app',
    store,
    components:{AdminNavigationComponent,AdminAsideComponent,MainCategory}
    ,
    data:{
        name:'shahab',
        admin:false,
        token:null,
    },
    mounted:function(){
         this.token = this.RetreiveToken();
         this.$store.dispatch('SetToken',{
             mesg:this.token
         });
        let response = function(res)
        {
            console.log(res);
            this.admin=res.data.admin;
            this.$store.dispatch('ChangeAdminState',{
                mesg:this.admin
            })
            if(this.admin)
            {
                this.$router.push('/categories');
            }
            if(!this.admin){
                this.$router.push('/checkout');
            }
        }
        let error = function(err)
        {

        }
        response=response.bind(this);
        error=error.bind(this);
        axios.post('http://127.0.0.1:8000/api/admin',{
            token:this.token
        }).then(response).catch(error);
        console.log('cookie ======> '+cookie)
       // this.$router.push({path:'/categories'});


    },
    methods:{
        RetreiveToken()
        {
            //get all cookies
            var cookies_all=document.cookie.split(';')
            //the final cookie
            var cookies=null
            //check if there are more than one cookies
            if(cookies_all.length >1)
            {
                //if there are more than one cookies
                for(let i=0;i<cookies_all.length;i++)
                {
                    var temp = cookies_all[i].trim();
                     temp = cookies_all[i].split('=');
                    if(temp[0].trim()=='token')
                    {
                        cookies=temp[1];
                        break;
                    }
                }
                return cookies;

            }else{
                //now get the first cookie
                cookies=cookies_all.split('=')[1]
                return cookies;
            }
        }
    }
});

