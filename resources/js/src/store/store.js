//initializing the vuex and telling the vue to use it

import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
//creating and exporting the vuexstore object now
//now changing the property with the help of the mutation
//i order to look at the state of the property using the getters
 export const store = new Vuex.Store({
    state:{
        flavour:'',
        token:'',
        IsLogIn:false,
        VisitLogInPage:false
    },
    mutations:{
        'change'(state,flavor){
            state.flavour=flavor.mesg;
        },
        'set'(state,token)
        {
            state.token=token.mesg;
            if(state.token != null)
                state.IsLogIn=true;
            else
                state.IsLogIn=false;
        },
        'logout'(state)
        {
            state.token=null;
            state.IsLogIn=false;
        },
        'footer'(state,value){
            state.VisitLogInPage=value.mesg
        }

    },
     actions:{
        ChangeFlavour:({commit},payload)=>{
            commit('change',payload);
        },
         LogIn:({commit},token)=>{
            commit('set',token);
         },
         LogOut({commit})
         {
             commit('logout');
         },
         footersetup({commit},payload)
         {
             commit('footer',payload);
         }
         ,
     }
     ,
    getters:{
            getFlavour:state => {
                return state.flavour;
            },
        getToken:state => {
                return state.token;
        },
        CheckUserLogIn:state => {
                return state.IsLogIn;
        },
        GetToken:state => {
                return state.token;
        },
        CheckoutUrl:state => {
                return 'http://127.0.0.1:8000/admin/?token='+state.token;
        },
        GetUserToken:state => {
                return state.token;
        },
        getfooter:state => {
                return state.VisitLogInPage;
        },

    }
});

