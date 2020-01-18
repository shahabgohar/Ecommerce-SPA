<template>
     <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Your Items</h1>
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

            <div class="card-header">

              <h3 class="card-title">Your Items</h3>
                <br>
                <a class="nav-item" @click="ShowAddItem">Add New Item for Sale</a>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
               <div class="card-tools">
 </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Item Id</th>
                  <th>Product Name</th>
                  <th>Price</th>
                  <th>Quantity</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for = "(item,index) in TableData" v-bind:key="index">
                  <td>{{item.id}}</td>
                  <td>{{item.Item_Name}}</td>
                  <td>{{item.Price}}</td>
                  <td> {{item.quantity}}</td>
                    <td> <i class="fas fa-edit" @click="EditItem(item.id)"></i></td>
                   <td> <i class="fas fa-trash-alt" @click="DeleteItem(item.id)"></i></td>

                </tr>

                </tbody>

              </table>
<!-- pagination -->
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">
    <li class="page-item">
      <a class="page-link" v-bind:href="previous" @click="LoadPrev">Previous</a>
    </li>
    <li class="page-item">
      <a class="page-link" v-bind:href="Next" @click="LoadNext">Next</a>
    </li>
  </ul>
</nav>
                <vue-page-transition name="fade-in-right">
<add-new-item-component @CloseAddItemCompoenent="CloseAddItem" @CloseAddNewItemComp="CloseAddItem" v-if="DisplayAddItem"></add-new-item-component>
                </vue-page-transition>
                <vue-page-transition name="fade-in-right">
                    <edit-item-component :EditCatId="ItemEdit" @CloseEditComp="CloseEditComp" v-if="ShowEditComp"></edit-item-component>
                           </vue-page-transition>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          </div>
          </div>

      </div>
    </div>
  </div>
 </div>
</template>
<script>
import AddNewItemComponent from './AddNewItemComponent';
import EditItemComponent from "./EditItemComponent";
export default {
 components:{AddNewItemComponent,EditItemComponent},
    data()
    {
        return{
            ItemEdit:null,
            ShowEditComp:false,
            DisplayAddItem:false,
            CurrentPage:null,
            TableData:null,
            Next:null,
            previous:null,

        }
    },
    mounted() {
     this.Fetch();
    }
    ,
    methods:{

     CloseAddItem()
     {
         this.DisplayAddItem=false;
     },
        ShowAddItem()
        {
            this.DisplayAddItem=true;
        },
        Fetch(){
         let response = function(res){
             console.log(res);
             this.Next=res.data.next_page_url;
             this.previous=res.data.last_page_url;
             this.CurrentPage=res.data.current_page;
             this.TableData=res.data.data;
         }
         response=response.bind(this);
         let error = function(err){
             console.log(err);
         }
         error=error.bind(this);
         axios.post('api/items',{
             token:this.$store.getters.getToken
         }).then(response).catch(error);
        },
        LoadNext(){
         event.preventDefault();
            let response = function(res){
                console.log(res);
                this.Next=res.data.next_page_url;
                this.previous=res.data.prev_page_url;
                this.CurrentPage=res.data.current_page;
                this.TableData=res.data.data;
            }
            response=response.bind(this);
            let error = function(err){
                console.log(err);
            }
            error=error.bind(this);
         axios.post(this.Next,{token:this.$store.getters.getToken}).then(response).catch(error)
        },
        LoadPrev(){
            event.preventDefault();
            let response = function(res){
                console.log(res);
                this.Next=res.data.next_page_url;
                this.previous=res.data.prev_page_url;
                this.CurrentPage=res.data.current_page;
                this.TableData=res.data.data;
            }
            response=response.bind(this);
            let error = function(err){
                console.log(err);
            }
            error=error.bind(this);
            axios.post(this.previous,{token:this.$store.getters.getToken}).then(response).catch(error)
        },
        DeleteItem(value){
         event.preventDefault();
         let response = function(res){
             console.log(res)
             this.Fetch();
         }
         let error = function(err){
             console.log(err)
         }
         response=response.bind(this);
         error=error.bind(this);
         axios.post('api/delete/item',{
             id:value,
             token:this.$store.getters.getToken
         }).then(response).catch(error);
        },
        EditItem(value){
         event.preventDefault();
         this.ShowEditComp=true;
         this.ItemEdit=value;
        },
        CloseEditComp(){
         this.ShowEditComp=false;
         this.Fetch();
        }
    }
}
</script>
