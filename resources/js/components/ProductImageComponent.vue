<template>
    <div>
    <div class="slideshow-container">

        <figure  ref="image" v-bind:class="[ImageClass]">
            <img v-bind:src="CurrentImage" class="AnimateRight">
        </figure>

        <a class="prev" @click="prev">&#10094;</a>
        <a class="next" @click="next" >&#10095;</a>

    </div>
    <br>

    <div style="text-align:center">
        <span class="dot"></span>
    </div>
</div>
</template>

<script>

export default {

    data(){
        return {
            ImageClass:"image",
            FadeInClass:"AnimateRight",
            ImageNumbers:3,
            Image:null,
            CurrentImage:null,
            CurrentImageCount:0
        }
    },
    mounted() {

        let response = function(result){
            this.Image=result.data.image;
            this.ImageNumbers=result.data.image.length;
            console.log(this.Image[0]);
            console.log(this.Image[0]);
            this.CurrentImage=this.Image[0];

            this.CurrentImageCount=0;
        };
        response=response.bind(this);
        window.axios.get('/ProductImage').then(response).catch(function(error){
            console.log(error)
        });

    },

    methods:{
        next(){

            if(this.CurrentImageCount <this.ImageNumbers)
            {
                console.log('i am next');
                this.CurrentImageCount++;
                this.CurrentImage=this.Image[this.CurrentImageCount];
                this.FadeInClass="";
                this.FadeInClass="AnimateRight";

            }

        },
        prev(){
            if(this.CurrentImageCount>0)
            {
                this.CurrentImageCount--;
                this.CurrentImage=this.Image[this.CurrentImageCount];
            }
        }
    }

}

</script>

