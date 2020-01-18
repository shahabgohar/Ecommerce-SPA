<template>
    <div>
    <section class="hero  is-large" v-if="">
        <div class="hero-head has-text-centered" >
            <div class="title">
                Sign In
            </div>
        </div>
        <div class="hero-body" style="padding-top: 5%;">
            <div class="container">

                <div class="field" v-if="!this.$store.getters.CheckUserLogIn">
                    <label class="label">Email</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-success" type="text" v-model="email" placeholder="Text input" required>
                        <span class="icon is-small is-left">
      <i class="fas fa-user"></i>
    </span>
                        <span class="icon is-small is-right">
      <i class="fas fa-check"></i>
    </span>
                <div class="field">
                    <label class="label">Password</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-success" type="password" v-model="password" placeholder="Text input" required>
                        <span class="icon is-small is-left">
      <i class="fas fa-user"></i>
    </span>
                        <span class="icon is-small is-right">
      <i class="fas fa-check"></i>
    </span>
                    </div>
                </div>

                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link" @click="SignIn">Submit</button>
                    </div>
                    <div class="control">
                        <button class="button is-link is-light">Cancel</button>
                    </div>
                </div>

                        <div class="field">
                            <div class="control">
                                <a href="#" @click="LoadForgot">Forgot Password !</a>
                            </div>
                            <div class="control">
                                <label class="content">
                                    {{Error}}
                                </label>
                            </div>
                        </div>

            </div>
        </div>
                <div class="title" v-if="$store.getters.CheckUserLogIn">
                    You are Successfully Logged In
                </div>
            </div>
        </div>
    </section>
        <Forgot-password-component v-if="forgot" @hideresetcomponent="makeforgot"></Forgot-password-component>
    </div>
</template>

<script>
    import ForgotPasswordComponent from "./ForgotPasswordComponent";
    export default {
        name: "SignInComponent",
        data(){
            return{
                email:null,
                password:null,
                loggedin:false,
                forgot:false,
                Error:null
            }
        },
        components:{ForgotPasswordComponent}
        ,
        methods:{
            SignIn() {
                event.preventDefault();
                let response = function (res) {

                    this.password=null;
                    console.log('here');
                    console.log(res);
                    document.cookie = "token=" + res.data.token;
                    this.$store.dispatch('LogIn',{
                        mesg: res.data.token
                    })
                    this.$emit('userloggedin')
                }
                let error = function (err) {
                    this.password=null
                    console.log(err);
                    alert("email/password is wrong");
                }
                    response = response.bind(this);
                    error = error.bind(this);

                axios.post('/api/SignIn', {
                    email: this.email,
                    password: this.password
                }).then(response).catch(error)
            }
            ,
            LoadForgot(){
                event.preventDefault();
                this.forgot=true;
            },
            makeforgot(){
                this.forgot=false;
            }
        }
    }
</script>

<style scoped>

</style>
