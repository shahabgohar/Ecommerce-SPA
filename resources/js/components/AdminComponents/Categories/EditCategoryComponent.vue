<template>
<div class="card" >
    <div class="card-header">
   Edit Category
  </div>

       <div class="card-body">
              <form class="form-group" style="background-color:white;">
  <div class="form-group">
    <label for="exampleInputEmail1">Category Name</label>
    <input type="text" ref="cat" class="form-control" v-model="EditCategoryDetails.category_name" aria-describedby="emailHelp" placeholder="Enter Categories">

  </div>
  <button type="submit" @click="SaveChanges" v-on:keyup.enter="SaveChanges" class="btn btn-primary">Save changes</button>
   <button type="submit" @click="CLoseEditCategory"  class="btn btn-danger">Cancel</button>
</form>
</div>
</div>
</template>
<script>
export default {
  props:['EditCategoryDetails'],
  data(){
    return {
      category_index:null,
        EditCategory:null,
    };
  },
  mounted:function(){
    this.category_index=this.$route.params.index;
    this.$refs.cat.focus();

  },
  methods:{
    CLoseEditCategory(){
      event.preventDefault();
      this.$emit('CloseEditCategory');
    },
    SaveChanges(){
        event.preventDefault();

        let response= function(res){
            console.log(res);
            this.$emit('CategoryEditComp')
        }
        response=response.bind(this);
        let error= function(err)
        {
            console.log(err);
        }
        error=error.bind(this);

        axios.post('api/EditCategory',{
            id:this.EditCategoryDetails.id,
            name:this.EditCategoryDetails.category_name,
        }).then(response).catch(error);

       this.$toast("Changes Saved",{
           timeout:2000,

       });
      this.$emit('CloseEditCategory');
    }
  }
}
</script>
