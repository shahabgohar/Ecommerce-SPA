<template>
 <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">

                <h3 class="card-title">Responsive Hover Table</h3>
                 <h3 class="card-title" style="padding-left:30px;"><a href="" @click="ShowNewCategory">Add New Category</a> </h3>
                  <h3 class="card-title" style="padding-left:30px;"><a href="" @click="RefreshList">Refresh Table</a> </h3>

                  <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" @click="SearchWatch" v-on:keyup.enter="SearchThroughList" v-model="SearchInput" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Category</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                  <p v-if="shouldPrint">
                    <tr v-for="(category,index) in CategoriesList" v-bind:key="index">
                      <td>{{category.id}}</td>
                      <td>{{category.category_name}}</td>
                      <td> <a href="" @click="EditCategoryClicked(category)"> <i class="fas fa-edit"></i></a></td>
                      <td><a href="" @click="Deletethis(category.id)"> <i class="fas fa-trash-alt"></i></a></td>
                    </tr>
                  </p>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
</template>
<script>
export default {
   props:['refresh']
  ,data(){
    return {
      CategoriesList:null,
      TempCategoriesList:null,
      UserSeenCategoryList:null,
      SearchInput:null,
      UserTyped:false,
      SearchBarFocused:false,
        shouldPrint:null,
    }
  },
watch:{
  SearchInput:function(){
    if(this.SearchInput.length==0)
    {
      this.CategoriesList=this.TempCategoriesList;
    }
  },
   refresh:function()
   {
       if(this.refresh==true)
       {
           var response=function(respons){
               console.log(response);
               this.CategoriesList=respons.data.categories;

           };
           var error=function(error){
               console.log(error);
           }
           window.axios('/Categories').then(response.bind(this)).catch(error);
       }
   }
}


  , mounted:function(){
    // response will run on the successfull completion of the function
    var response=function(respons){
        console.log(respons);
        if(respons.data.categories.length!=0){
            this.shouldPrint=true;
            this.CategoriesList=respons.data.categories;
        }else{
            this.shouldPrint=false;
        }


    };
    var error=function(error){
      console.log(error);
    }
    window.axios('/Categories').then(response.bind(this)).catch(error);
   },
   methods:{
     EditCategoryClicked(cat_index){
       event.preventDefault();
       this.$emit('EditCategoryEvent',cat_index);

     },
     Deletethis(cat_index)
     {
       event.preventDefault();
      // this.CategoriesList=this.CategoriesList.filter(function(category){
      //   return category.id!=cat_index;
      // });
         var response=function(respons){
             console.log(respons);
             var response=function(respons){
                 this.CategoriesList=respons.data.categories;

             };
             var error=function(error){
                 console.log(error);
             }
             window.axios('/Categories').then(response.bind(this)).catch(error);

         };
         var error=function(error){
             console.log(error);
         }
         response=response.bind(this);
         error=error.bind(this);
         axios.post('api/RemoveCategory',{
             id:cat_index
         }).then(response).catch(error);

     },
     ShowNewCategory(){
       event.preventDefault();
       this.$emit('ShowNewCategory');
     },
     SearchWatch(){
      this.SearchBarFocused=true;
     },
     SearchThroughList(){
       if(this.SearchBarFocused)
       {
          this.TempCategoriesList=this.CategoriesList;
         let Search=function(Category){

           return Category.category_name==this.SearchInput;

         };
         Search=Search.bind(this);
       this.CategoriesList=this.CategoriesList.filter(Search);
       }

     }
     ,
       RefreshList(){
         event.preventDefault();
           var response=function(respons){
               this.CategoriesList=respons.data.categories;

           }
           var error=function(error){
               console.log(error);
           }
           window.axios('/Categories').then(response.bind(this)).catch(error);
       }
   },

}
</script>
