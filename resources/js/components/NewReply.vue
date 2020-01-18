<template>
    
        <article class="media">
  <figure class="media-left">
    <p class="image is-64x64">
      <img src="https://bulma.io/images/placeholders/128x128.png">
    </p>
  </figure>
  <div class="media-content">
    <div class="field">
      <p class="control">
        <textarea class="textarea" placeholder="Add a comment..." v-model="message"></textarea>
      </p>
    </div>
    <nav class="level">
      <div class="level-left">
        <div class="level-item">
          <a class="button is-info">Submit</a>
           
        </div>
          <div class="level-item">
          <a class="button is-info" @click="raise_cancel_event">Cancel</a>
           
        </div>
      </div>
   


    </nav>
  </div>
</article>
</template>
<script>
export default {
    data(){
        return {
            message:''
        }
    },
    methods:{
        raise_cancel_event(){
            this.$emit('close_new_reply');
        }
    }
}
</script>