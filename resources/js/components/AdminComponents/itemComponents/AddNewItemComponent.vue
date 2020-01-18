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
                    {{message}}

            </div>
            <!-- /.card-body -->

            <div class="card-footer" v-if="!ShowUpload">
                <button type="submit" @click="ItemAddition" class="btn btn-primary">Submit</button>
            </div>
            <div class="card-footer" v-if="!ShowUpload">
                <button type="submit" @click="Close" class="btn btn-primary">Cancel</button>
            </div>

<!--show after above-->
            <div >
                <div class="card-body">
            <div class="form-group" >
                <div class="input-group">
                    <my-upload field="image" v-model="show"  :width="400" :height="400" img-format="png" @crop-success="cropSuccess" @crop-upload-success="cropUploadSuccess" @crop-upload-fail="cropUploadFail"
                    url="http://127.0.0.1:8000/api/items/image/" :lang-type="lang" :params="params">

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
    import Uploader from '../../../../../node_modules/vux-uploader-component';
import ClassicEditor from '../../../../../node_modules/@ckeditor/ckeditor5-build-classic';
import myUpload from '../../../../../node_modules/vue-image-crop-upload';
export default {
    data(){
        return{
            show:false,
            message:'',
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
            }
            ,
            imgDataUrl:'',
            quantity:null,
            name:null,
            fileList:[],
            price:null,
            remoteUrl:'',
            CategoryId:null,
            ChoosenCategory:'Category',
            ShowUpload:false,
            ItemId:null,
            autoUpload:false,
            Upload:'Upload Image',
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
        }
    },
    components:{
        myUpload
    },
    watch:{
        editorData:function()
        {
            console.log(typeof this.editorData);
            console.log(this.editorData);
        }
    },
    methods: {
        SetCategoryId(id, value) {
            event.preventDefault();
            this.ChoosenCategory = value;
            this.CategoryId = id;
        },
        preventDefault() {
            event.preventDefault();
        },
        ItemAddition() {
            var code = 0;
            event.preventDefault();
            console.log(window.csrf_token);
            this.ShowUpload = true;
            console.log(this.editorData);
            //success response
            let responsne = function (res) {
                console.log(res);
                this.ItemId = res.data.item;
                this.remoteUrl = 'http://127.0.0.1:8000/api/items/image/';
                this.params.item=this.ItemId;
                this.params.token=this.$store.getters.getToken,
                this.ShowUpload = true;
            }
            responsne = responsne.bind(this);
            let error = function (err) {
                this.ShowUpload=false;
                  this.message=err.data.message;
            }
            error = error.bind(this);
            axios.post('/api/new/Item', {
                name: this.name,
                price: this.price,
                category: this.CategoryId,
                quantity: this.quantity,
                description: this.editorData,
                token:this.$store.getters.getToken,
            }).catch(error).then(responsne);
            //  this.$emit("CloseAddItemCompoenent");
        },
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
        Close(){
            event.preventDefault();
            this.$emit('CloseAddNewItemComp')
        }
    },
    mounted() {
        console.log(this);
        let response=function(resp)
        {
            this.CategoriesList=resp.data.categories;
        }
        response=response.bind(this);
        axios.get('/Categories').then(response).catch(function(error){ console.log(error);});
    }
}
</script>
