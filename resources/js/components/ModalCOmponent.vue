<template>
    <div class="modal" :class='apply'>
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Add a new Contact</p>
      <button class="delete" aria-label="close" @click='close'></button>
    </header>
    <section class="modal-card-body">
      <!-- Content ... -->
      <div class="field">
  <label class="label">Name</label>
  <div class="control">
    <input class="input"  type="text" placeholder="e.g Alex Smith" v-model="list.name">
    <span v-if="is_error"   style="color:red;" > {{error_name}} </span>
  </div>
</div>

<div class="field">
  <label class="label">Email</label>
  <div class="control">
    <input class="input" type="email"   placeholder="e.g. alexsmith@gmail.com" v-model="list.email">
    <span v-if="is_error" style="color:red;"> {{error_email}} </span>
  </div>
</div>
<div class="field">
  <label class="label">Number</label>
  <div class="control">
    <input class="input"  placeholder="e.g. alexsmith@gmail.com" v-model="list.contact">
    <span v-if="is_error"  style="color:red;"> {{error_contact}} </span>
  </div>
</div>
    </section>
    <footer class="modal-card-foot">
      <button class="button is-success" @click='save'>Add New Contact</button>
      <button class="button" @click='close'>Cancel</button>
    </footer>
  </div>
</div>
</template>
<script>
// v-model directive is used for two way binding see docs
export default {
    props:['apply'],
      data(){
        return {
            list:{
                name:'',
                contact: '',
                email: ''
            },
            error_name:'',
            error_email:'',
            error_contact:'',
            is_error:false,
        };
    },
  
    methods:{
    close(){
        this.$emit('closemodal')
    },
    save(){
            console.log(this.$data.list.name);
            const axios=require('axios');
            axios.defaults.headers.common={'X-Requested-With' : 'XMLHttpRequest',
            'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')};
    axios.post('/phonebook',this.$data.list)
  .then((response) => {
    this.close();
  }
  ).catch(
    // use es6 the latest javascript
     (error) => {
    this.is_error=true;
    let error_object=error.response.data.errors;
    if('email' in error_object)
    {
      this.error_email=error_object.email[0];
    }
    if('contact' in error_object)
    {
      this.error_contact=error_object.contact[0];
    }
    if('name' in error_object)
    {
      this.error_name=error_object.contact[0];
    }
  });
        }
    }
}
</script>