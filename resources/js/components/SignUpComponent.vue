<template>
    <section class="hero  is-large">
        <div class="hero-head has-text-centered">
            <div class="title">
                Sign Up
            </div>
        </div>
        <div style="padding-top: 5%;" v-bind:class="['hero-body',{'handle-bottom':Success}]">
            <div class="container">
                <form v-if="!$store.getters.CheckUserLogIn" method="POST">
                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control">
                            <input class="input" type="text" placeholder="Enter your Name" v-model="Name">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control has-icons-left has-icons-right">
                            <input class="input is-danger" type="email" placeholder="example@email.com" v-model="Email">
                            <span class="icon is-small is-left">
      <i class="fas fa-envelope"></i>
    </span>
                            <span class="icon is-small is-right">
      <i class="fas fa-exclamation-triangle"></i>
    </span>
                        </div>
                        <p class="help is-danger">This email is invalid</p>
                    </div>

                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input class="input" type="password" placeholder="Choose Your Password" v-model="Password">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Enter Your Password Again</label>
                        <div class="control">
                            <input class="input" type="password" placeholder="Re-Enter Your Password "
                                   v-model="VerifyPassword">
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox" v-model="Terms">
                                By clicking this box you will be agree to our terms & conditions
                            </label>
                        </div>
                    </div>

                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-link" @click="SignUpUser">Sign Up</button>
                        </div>

                        <div class="control">
                            <button class="button is-link is-light">Cancel</button>
                        </div>
                        <br>
                        <div class="control">
                            <label class="content">
                                {{Error}}
                            </label>
                        </div>
                    </div>
                </form>
                <div class="title" v-if="$store.getters.CheckUserLogIn">
                    You Are Successfully Logged In
                </div>
                <div>

                </div>
            </div>


        </div>
    </section>
</template>

<script>

import {mapMutations,mapState,mapGetters} from 'vuex';

    export default {
        name: "SignUpComponent",

        data() {
            return {
                Name: null,
                Email: null,
                Password: null,
                VerifyPassword: null,
                Terms: null,
                Success: false,
                styles: '',
                Error: null,
            }
        },
        methods: {
            SignUpUser() {
                event.preventDefault();
                var response = function (resp) {
                    console.log(resp.data.token);
                    this.Success = true;

                    document.cookie = "token=" + resp.data.token;
                    this.$store.dispatch('LogIn',{
                        mesg: resp.data.token
                    })
                    this.MakeUserNull();
                    this.$emit('userloggedin');

                }
                var error = function (error) {
                  console.log(error.response);
                    if ('errors' in error.response.data) {
                        this.Error = error.response.data.errors;
                    } else {

                        console.log(error.response.data);
                        let errors = Object.values(error.response.data.errors);
                        let errorMessage = '';
                        for (let i = 0; i < errors.length; i++) {
                            errorMessage += errors[i];
                            errorMessage += '\n';
                        }
                        this.Error = errorMessage;
                        console.log(errorMessage);

                    }
                }

                response = response.bind(this);
                error = error.bind(this);
                if(this.VerifyPassword==this.Password)
                {
                    axios.post('/api/SignUp', {
                        Name: this.Name,
                        Email: this.Email,
                        Password: this.Password,
                        Terms: this.Terms
                    }).then(response).catch(error);
                }else{
                    alert('passwords doesnot match')
                }

            },
            MakeUserNull()
            {
                this.Email=null;
                this.Password=null;
                    this.VerifyPassword=null;
                    this.Name=null;
                    this.Terms=false;
            }
        }
    }
</script>

<style scoped>

</style>
