<template>
    <div>
    <section class="hero  is-large">
        <div class="hero-head has-text-centered" >
            <div class="title">
               Enter your email
            </div>
        </div>
        <div class="hero-body" style="padding-top: 5%;">
            <div class="container">

                <div class="field">
                    <label class="label">Email</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-success" type="text" v-model="email" placeholder="Enter your Email" required>
                        <span class="icon is-small is-left">
      <i class="fas fa-user"></i>
    </span>
                        <span class="icon is-small is-right">
      <i class="fas fa-check"></i>
    </span>

                        <div class="field is-grouped">
                            <div class="control">
                                <button class="button is-link" @click = "SendResetEmail">Submit</button>
                            </div>
                            <div class="control">
                                <button class="button is-link" @click = "SignIn">Sign In</button>
                            </div>
                        </div>
                        <div class="field" v-if="emailsendresponse">
                            <label>if this email is registered with your account then you will receive the email and if you wanna try again then submit the email again</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    </div>
</template>

<script>
    export default {
        name: "ForgotPasswordComponent",
        data(){
            return {
                email:null,
                emailsendresponse:false
            }
        },
        methods:{
            SendResetEmail()
            {
                event.preventDefault();
                let response = function (resp){
                    console.log(resp);
                    this.emailsendresponse=true;
                }
                response=response.bind(this);
                let error = function (err){
                    console.log(err);
                }
                error=error.bind(this);
                axios.post('api/password/reset',{
                    email:this.email
                }).then(response).catch(error);

            },
            SignIn(){
                event.preventDefault();
                this.$emit('hideresetcomponent')
            }
        }
    }
</script>

<style scoped>

</style>
