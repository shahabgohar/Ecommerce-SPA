//initializing the vuex and telling the vue to use it

import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
//creating and exporting the vuexstore object now
//now changing the property with the help of the mutation
//i order to look at the state of the property using the getters
export const store = new Vuex.Store({
  state:{
      UserAdmin:false,
      Token:null,
      UserLogged:true,
      Checkout:[],
      adress:null,
  },
    mutations: {
        'set'(state, admin) {
            if(state.Token!=null)
            state.UserAdmin = admin.mesg;
            },
        'setToken'(state,token)
        {
            state.Token=token.mesg
            state.UserLogged=true
        },
        'checkout'(state,checkout)
        {
            state.Checkout=checkout.mesg;
        },
        'setadress'(state,adress)
        {
            state.adress=adress.mesg;
        }
    },
        actions:{
      ChangeAdminState:({commit},payload)=>
     {
         commit('set',payload)
        },
            SetToken:({commit},payload)=>{
          commit('setToken',payload);
            },
           SetCheckout:({commit},payload)=>{
          commit('checkout',payload);

           },
            CreateOrder:({commit,state})=>{
          console.log(state.Checkout[0].id);
          var ids= new Array();
          for(let i=0;i<state.Checkout.length;i++)
             {
            ids.push(state.Checkout[i].id);
             }
          let response = function(res){
              console.log(res);
          }
          let error = function(err){
              console.log(err);
          }
          response=response.bind(this);
          error=error.bind(this);
          window.axios.post('/api/submit/order',{
            token:state.Token,
              CheckoutId:ids,
              adress:state.adress
          }).then(response).catch(error);
            },
            setadress:({commit},payload)=>{
          commit('setadress',payload);
            }

      },
    getters:{
      getAdminStatus:state => {
          return state.UserAdmin;
      },
        getToken:state => {
          return state.Token;
        },
        UserLoggedIn:state =>{
          return state.UserLogged
},
        GetCheckout:state => {
          return state.Checkout;
        },
        CheckoutCount:state => {
          return state.Checkout.length>0 ? true :false;
        }
    }

});

