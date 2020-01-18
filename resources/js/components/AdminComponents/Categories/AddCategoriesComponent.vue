<template>
<div class="card" >
    <div class="card-header">
   Edit Category
  </div>

       <div class="card-body">
                  <div class="card-body">
              <form>
  <div class="form-group">
    <label for="exampleInputEmail1">Category Name</label>
    <input type="" v-bind:class="[{'is-invalid': !Progress},FormClass]" v-model="category" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Categories">

  </div>
  <button type="submit" @click="AddCategory" class="btn btn-primary">Add Categories</button>
    <button type="submit" @click="CloseCategory" class="btn btn-danger">Cancel</button>
</form>
</div>
       </div>
</div>
</template>
<script lang="ts">
export default {
data(){
  return{
    FormClass:'form-control',
    category:null,
    Progress:false,

  };
}
  ,
watch:{
  category:function(){
    if(this.category==null){
      this.errorClass='is-invalid'
    }
  }
}
  ,
    mounted:function(){

    },
    methods:{
      CloseCategory(){
        event.preventDefault();
        this.$emit('CloseAddCategoryComponent');
      }

      ,AddCategory(){
          this.$toast("Add Category",{
             timeout:2000,
             position:"top-left"
          });

        event.preventDefault();
        let respose = function(res){
            this.$emit('NewCategoryAdded');

            if(this.Progress===true){
                console.log('category has been submitted');
            }else{
                console.log('failed to add the category');
                this.Progress=false;
                this.errorClass='is-invalid';
            }
        }
        respose=respose.bind(this);
        let error = function (err) {
            console.log(err);

        }

       if(this.category.toString().length==0)
       {
         this.Progress=false;
       }else{
         this.Progress=true;
         axios.post('/api/AddCategories',{
          category:this.category
        }).then(respose).catch(error);
       }

      }
    }
}
</script>
