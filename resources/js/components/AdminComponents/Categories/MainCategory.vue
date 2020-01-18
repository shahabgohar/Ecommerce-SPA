<template>

 <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Shopping Site</li>
            </ol>
          </div>
        </div>
      </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col">
            <div class="card">
            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Products</h3>
              </div>
                <vue-page-transition name="fade-in-right">
          <category-table-component :refresh="RefreshTable" :CategoryTableUpdated="refreshresponse" @EditCategoryEvent="ShowEdit" @ShowNewCategory="ShowNew"></category-table-component>
                </vue-page-transition>
            </div>
          </div>
          </div>
          </div>
          <div class="row">
          <div class="col">
              <vue-page-transition name="fade-in-right">
      <edit-category-component v-if="ShowEditCategory" @CategoryEditComp="CloseEditComp" :EditCategoryDetails="EditCategoryDetails" @CloseEditCategory="CloseEditComp" ></edit-category-component>
              </vue-page-transition>
              <vue-page-transition name="fade-in-right">
      <add-new-category-component v-if="ShowNewCategory" @refreshTable="RefreshTable" @CloseAddCategoryComponent="ClsoeNewCategory" @NewCategoryAdded="CategoryAdded" ></add-new-category-component>
              </vue-page-transition>
       </div>
        </div>
      </div>
    </div>
  </div>
 </div>
</template>
<script>
import CategoryTableComponent from './CategoriesTableComponent';
import EditCategoryComponent from './EditCategoryComponent';
import AddNewCategoryComponent from './AddCategoriesComponent';
export default {
    components:{CategoryTableComponent,EditCategoryComponent,AddNewCategoryComponent},
    data(){
        return {
            ShowEditCategory:false,
            ShowNewCategory:false,
            EditCategoryDetails:null,
            RefreshTable:false
        };
    },
    mounted() {

    }
    ,
    methods:{
        ShowNew(index){
            this.ShowNewCategory=true;
            this.ShowEditCategory=false;
        },
        ShowEdit(cat_index){
            this.EditCategoryDetails=cat_index;
            this.ShowEditCategory=true;
            this.ShowNewCategory=false;
        },
        ClsoeNewCategory(){
          this.ShowNewCategory=false;
        },
        CloseEditComp(){
          this.ShowEditCategory=false;
        },
        CategoryAdded()
        {
            this.RefreshTable=true;
            this.ShowNewCategory=false;
        },
        refreshresponse(){
            this.RefreshTable=false;
        },


    }
}
</script>
