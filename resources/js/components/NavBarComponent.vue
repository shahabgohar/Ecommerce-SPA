<template>
 <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
          <a class="navbar-item" href="https://bulma.io">
            <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
          </a>

          <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
          </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
          <div class="navbar-start">
            <a class="navbar-item" @click="ShowMainCmponent">
              Home
            </a>
              <a class="navbar-item" v-bind:href="this.$store.getters.CheckoutUrl" >
                  Checkout
              </a>

              <div class="navbar-dropdown">
                <a class="navbar-item">
                  About
                </a>

                <a class="navbar-item">
                  Contact
                </a>
                <hr class="navbar-divider">
                <a class="navbar-item">
                  Report an issue
                </a>
              </div>
            </div>
          </div>

          <div class="navbar-end">
            <div class="navbar-item" v-if="!$store.getters.CheckUserLogIn">
              <div class="buttons">
                            <span class="button is-primary modal-button" data-target="modal-fadeInScale" @click="ShowSignUp">SignUp</span>
                <a class="button is-light" @click="ShowLogIn">
                  Log in
                </a>
              </div>
            </div>
              <div class="navbar-item" v-if="$store.getters.CheckUserLogIn">
                  <a class="button is-light" @click="LogOutUser">
                      Logout
                  </a>
              </div>
          </div>

      </nav>

</template>
<script>

    export default {
        props:['loggedin'],
    data() {
        return{
            url:null,
            token:null,
        }
        },
        mounted() {
        this.token =this.RetreiveToken();
        console.log("here")
        console.log(this.token);
            if(this.token!=null)
            {
                if(this.token!='')
                {
                    this.$store.dispatch('LogIn',{
                        mesg:this.token
                    })
                }

            }
        }
        ,
        methods:{
            SetFooter(value)
            {
                this.$store.dispatch('footersetup',{
                    mesg:value
                })
            },
                ShowSignUp(){
                    event.preventDefault();
                  this.SetFooter(true);
                    this.$emit("showsignupcomponent")
                },
                    ShowLogIn(){
                    event.preventDefault();
                        this.SetFooter(true);
                    this.$emit("closesignupcommentshowlogin");
                    },
                    ShowMainCmponent()
                    {
                        this.SetFooter(false);
                        event.preventDefault();
                        this.$router.push('/');
                        this.$emit("showmaincomponent")
                    },
                    LogOutUser(){
                    event.preventDefault();
                    document.cookie="token=";

                    this.$store.dispatch('LogOut');
                    },
            RetreiveToken()
            {
                //get all cookies
                var cookies_all=document.cookie.split(';');
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

    }
</script>
