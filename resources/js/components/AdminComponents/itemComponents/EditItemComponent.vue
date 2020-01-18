<template>
    <div>
        <form role="form">
            <div class="card-body" v-if="!ShowUpload">
                <div class="form-group">
                    <label for="">Product Name</label>
                    <input type="text" class="form-control" v-model="name"  placeholder="Enter Product Name">
                </div>

                <div class="form-group">
                    <label for="CategoryItem">Category</label>
                    <div class="dropdown" id="CategoryItem">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            {{ChoosenCategory}}
                        </button>
                        <div class="dropdown-menu">
                            <a v-for="(category,index) in CategoriesList" :key="index" v-text="category.category_name" @click="SetCategoryId(category.id,category.category_name)" class="dropdown-item" href="#"></a>

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input  class="form-control" id="price" type="number" v-model="price" placeholder="Price">
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input  class="form-control" id="quantity" type="number" v-model="quantity" placeholder="Quantity">
                </div>

                <div class="form-group">
                    <label for="">Enter Description</label>
                    <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                    <code>{{editorData}}</code>
                </div>


            </div>
            <!-- /.card-body -->

            <div class="card-footer" v-if="!ShowUpload">
                <button type="submit" @click="ItemAddition" class="btn btn-primary">Submit</button>
            </div>
            <div class="card-footer" v-if="!ShowUpload">
                <button type="submit" @click="CloseEdit" class="btn btn-primary">Cancel</button>
            </div>

            <!--show after above-->
            <div >
                <div class="card-body">
                    <div class="form-group" >
                        <div class="input-group">
                            <my-upload field="image" v-model="show"  :width="400" :height="400" img-format="png" @crop-success="cropSuccess" @crop-upload-success="cropUploadSuccess" @crop-upload-fail="cropUploadFail"
                                       url="http://127.0.0.1:8000/api/items/edit/image/" :lang-type="lang" :params="params">

                            </my-upload>
                            <img :src="imgDataUrl">

                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" @click="UploadImages" class="btn btn-primary">Upload Images</button>
                </div>
            </div>

        </form>
    </div>
</template>

<script>
    import ClassicEditor from '../../../../../node_modules/@ckeditor/ckeditor5-build-classic';
    import myUpload from '../../../../../node_modules/vue-image-crop-upload';
    export default {
        props:['EditCatId'],
        name: "EditItemComponent.vue",
        components:{ClassicEditor,myUpload},
        data(){
            return{
                imgDataUrl:'',
                ShowUpload:false,
                show:false,
                editor: ClassicEditor,
                editorData: null,
                editorConfig: {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' ],
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                        ]
                    }
                },
                CategoriesList:null,
                lang:{
                    en: {
                        hint: 'Click or drag the file here to upload',
                        loading: 'Uploading…',
                        noSupported: 'Browser is not supported, please use IE10+ or other browsers',
                        success: 'Upload success',
                        fail: 'Upload failed',
                        preview: 'Preview',
                        btn: {
                            off: 'Cancel',
                            close: 'Close',
                            back: 'Back',
                            save: 'Save'
                        },
                        error: {
                            onlyImg: 'Image only',
                            outOfSize: 'Image exceeds size limit: ',
                            lowestPx: 'Image\'s size is too low. Expected at least: '
                        }
                    }
                },
                params:{
                    id:null,
                    token:null
                },
                name:null,
                price:null,
                quantity:null,
                ItemId:null,

            }
        },
        mounted() {
            let response = function(res){
                console.log(res);
                this.name=res.data[0].Item_Name;
                this.price=res.data[0].Price;
                this.quantity=res.data[0].quantity;
                this.editorData=res.data[0].Description;
                this.ChoosenCategory=res.data[0].CategoryId;
            }
            response=response.bind(this);
            let error = function(err){
                console.log(err);
            }
            axios.post('/api/edit/item',{
                id:this.EditCatId,
                token:this.$store.getters.getToken
            }).then(response).catch(error);
            let respnse=function(resp)
            {
                this.CategoriesList=resp.data.categories;
            }
            respnse=respnse.bind(this);
            axios.get('/Categories').then(respnse).catch(function(error){ console.log(error);});
        },
        methods:{
            UploadImages() {
                event.preventDefault();
                this.show = true;
            }
            ,
            cropSuccess(imgDataUrl, field) {
                console.log(imgDataUrl);
                console.log(field);
                this.imgDataUrl = imgDataUrl
            },
            cropUploadSuccess(jsonData, field) {
                console.log("upload Success");
                console.log(jsonData);
                console.log(field);

            },
            cropUploadFail(status, field) {
                console.log('-------- upload fail --------');
                console.log(status);
                console.log('field: ' + field);
            },
            CloseEdit(){
                event.preventDefault();
                this.$emit('CloseEditComp');
            },
            ItemAddition(){

                event.preventDefault();
                this.ShowUpload = true;
                console.log(this.editorData);
                //success response
                let responsne = function (res) {
                    console.log(res);
                    this.ItemId = res.data.item;
                    this.remoteUrl = 'http://127.0.0.1:8000/api/items/image/';
                    this.params.item=this.ItemId;
                    this.params.token=this.$store.getToken;
                    this.ShowUpload = true;
                }
                responsne = responsne.bind(this);
                let error = function (err) {

                }
                error = error.bind(this);
                axios.post('/api/save/edit/item', {
                    id:this.EditCatId,
                    name: this.name,
                    price: this.price,
                    category: this.CategoryId,
                    quantity: this.quantity,
                    description: this.editorData,
                    token:this.$store.getters.getToken
                }).catch(error).then(responsne);

                this.ShowUpload=true;
            },

        }
    }
</script>

<style scoped>

</style>
