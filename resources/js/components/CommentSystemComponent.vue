<template>
<div class="">
    <item-comments @Show_Reply_Box='launchReply'></item-comments>
    <new-reply v-if="reply_request" @close_new_reply="closeReply"></new-reply>
    
</div>
<!-- <div>
   
    <prevComments ref="childprev" @launchnewreply="launchReply"></prevComments>
     <prevComments ref="childprev" @launchnewreply="launchReply"></prevComments>
      <prevComments ref="childprev" @launchnewreply="launchReply"></prevComments>
  
    <reply v-if="reply_request"></reply>
    <button @click="show_refs"></button>
    </div> -->

</template>
<script>
import NewReply from './NewReply';
import ItemComments from './ItemComments';
export default {
    components: {NewReply:NewReply,ItemComments:ItemComments},
    data(){
        return {
        pre_message: this.$refs,
        reply_request: false
        }
    },
    methods:{
        launchReply(){
            this.reply_request=true;
            
           console.log(this.$refs.childprev)
        },
        closeReply(){
            this.reply_request=false;
        },
        show_refs()
        {
            console.log(this.pre_message);
        }
    },
    mounted:function(){
      
         const axios=require('axios');
            axios.defaults.headers.common={'X-Requested-With' : 'XMLHttpRequest',
            'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')};
            
             axios.get('/comments').then((response) =>{this.pre_message=response.data; 
             console.log(response.data);
             
             for ( var i in this.pre_message)
             {
                 console.log(i);
                 console.log(this.pre_message[i]);
             }
             }).catch((error) => { console.log(error) });
              
    },

}
</script>