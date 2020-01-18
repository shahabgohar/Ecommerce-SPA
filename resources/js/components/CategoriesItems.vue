<template>
<div>
      <div class="columns">
        <div class="column" @click="loadcontent" v-for="(it,index) in Item" v-bind:key="index">
            <div class="card">
                <div class="card-image">
                  <figure class="image is-4by3">
                      <p v-if="it.image == null">
                    <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
                      </p>
                      <p v-if="it.image != null">
                          <img v-bind:src="`data:image/png;base64,${it.image}`"  alt="Placeholder image">
                      </p>
                  </figure>
                </div>
                <div class="card-content">
                  <div class="media">
                    <div class="media-left">
                      <figure class="image is-48x48">
                          <p v-if="it.image == null">
                        <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
                          </p>

                      </figure>
                    </div>
                    <div class="media-content">
                      <p class="title is-4"><router-link :to="{name:'product',params:{item:it.id}}"> {{it.Item_Name}} </router-link> </p>
                      <p class="subtitle is-6">{{it.Price}}</p>
                    </div>
                  </div>

                  <div class="content">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Phasellus nec iaculis mauris. <a>@bulmaio</a>.
                    <a href="#">#css</a> <a href="#">#responsive</a>
                    <br>
                    <time datetime="2016-1-1">{{it.created_at}}</time>
                  </div>
                </div>
              </div>
        </div>



      </div>
</div>
</template>
<script>

export default {
props:['Item'],
  methods:{
    clicked(event){
      event.preventDefault();
      console.log('i am clicked');
    },
    loadcontent(){
      event.preventDefault();
     this.$emit('ShowItemDetails');
    console.log('clicked');
  }
  },

}
</script>
