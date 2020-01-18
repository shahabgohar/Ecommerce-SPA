<template>
<div>
    <div class="tabs is-centered">
  <ul>
    <li v-bind:class="{'is-active':isComments}" @click="CommentsActivated"><a >Comments</a></li>
      <li v-bind:class="{'is-active':isDescription}"  @click="DescriptionActivated"><a>Description</a></li>
  </ul>
</div>
    <vue-page-transition name="fade-in-right">
    <comment-system-component v-if="isComments"></comment-system-component>
    </vue-page-transition>
    <vue-page-transition name="fade-in-right">
    <item-description v-bind:desc="description" v-if="isDescription"></item-description>
    </vue-page-transition>
</div>
</template>
<script>

    import CommentSystemComponent from "./CommentSystemComponent";
    import ItemDescription from './ItemDescriptionComponent';
export default {
    props:['description'],
    mounted:function(){
        this.isDescription=true;
    },
    data(){
        return{
                    isComments:null,
                    isDescription:null
        }
    },
    components:{
      CommentSystemComponent,
        ItemDescription
    },
    methods:{
        LoadComp(){
            event.preventDefault();
            this.$router.push('/product/ItemDescription');
        },
        CommentsActivated(){
            event.preventDefault();
            this.isComments=true;
            this.isDescription=false;
        },
        DescriptionActivated(){
            event.preventDefault();
            this.isComments=false;
            this.isDescription=true;
        }
    }

}
</script>
