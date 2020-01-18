<template>
  <div class="tabs is-centered">
            <ul v-for="(category) in CategoriesList" v-bind:key="category.id">
              <li v-bind:class="{'is-active': 'category.IsSelcted'}" @click="FireNext(category.id)"><a>{{category.category_name}}</a></li>
            </ul>
          </div>
</template>
<script>



    export default {
        data() {
            return {
                CategoriesList: null,
                SelectedCategoryId: null
            }

        },
        mounted() {
            var respose = function (response) {
                console.log(response);
                this.CategoriesList = response.data.categories;
                for (let i = 0; i < this.CategoriesList.length; i++) {
                    if (i == 0)
                        this.CategoriesList[i].IsSelected = true;
                    else
                        this.CategoriesList[i].IsSelected = false;
                }
                this.SelectedCategoryId = this.CategoriesList[0].id;
                this.$emit('CategoryLoaded',this.SelectedCategoryId);
            }
            respose = respose.bind(this);
            axios.get('/Categories').then(respose).catch(function (error) {
                console.log(error);
            });
        },
        methods: {
            MakeActiveOrNot(id) {
                console.log(id);
                let SomeCategory = this.CategoriesList.find(function (Ids) {

                    return Ids.id == id;
                });
                    console.log(SomeCategory.id);
                for(let i=0;i<this.CategoriesList.length;i++)
                {
                    if(this.CategoriesList[i].id==SomeCategory.id)
                    {
                        this.CategoriesList[i].IsSelected=true;
                        console.log(this.CategoriesList[i].IsSelected);
                    }else{
                        this.CategoriesList[i].IsSelected=false;
                    }
                }

            },
            FireNext(id){
                this.$emit('LoadNext',id);
            }
        }
    }
</script>
