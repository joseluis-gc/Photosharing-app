<template>
    <div>

        <form @submit.prevent="createAlbum" method="POST" action="" enctype="multipart/form-data" v-if="!success">

            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-left">Album Name</label>
                <div class="col-md-12">
                    <input id="name" type="text" class="form-control" name="name" v-model="name"  autocomplete="name" autofocus>
                    <span v-if="all_errors.name" :class="['text-danger']">{{all_errors.name[0]}}</span>
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-md-4 col-form-label text-md-left">Description</label>

                <div class="col-md-12">
                    <textarea id="description"  class="form-control" name="description" v-model="description" ></textarea>
                    <span v-if="all_errors.description" :class="['text-danger']">{{all_errors.description[0]}}</span>
                </div>
            </div>


            <div class="form-group row">
                <label for="category" class="col-md-4 col-form-label text-md-left">Category</label>

                <div class="col-md-12">
                    <select id="category"  class="form-control" name="category" v-model="category"  >
                        <option value="">Select Category</option>
                        <option v-for="(category, index) in categories" :key="index" :value="category.id" >
                            {{category.name}}
                        </option>
                    </select>
                    <span v-if="all_errors.category" :class="['text-danger']">{{all_errors.category[0]}}</span>
                </div>
            </div>


            <div class="form-group row">
                <label for="image" class="col-md-4 col-form-label text-md-left"></label>

                <div class="col-md-12">
                    <input id="image" type="file"  class="form-control" name="image" v-on:change="onImageChange" >
                </div>
                <span v-if="all_errors.image" :class="['text-danger']">{{all_errors.image[0]}}</span>

            </div>

             <div class="form-group row">
                <div class="col-md-12">
                    <button id="submit" type="submit"  class="btn btn-dark" name="submit">Save</button>
                </div>
            </div>
        </form>

        <div v-if="success">
            <a :href="'gallery/'+album_id">Album Created</a>
        </div>

    </div>
</template>

<<script>
export default
{
    data()
    {
        return{
            name:'',
            description:'',
            category:'',
            image:'',
            categories:[],
            album_id:'',
            success:false,
            all_errors:[]
        }
    },
    created() {
        this.getCategories()
    },
    methods: {
        getCategories()
        {
            axios.get('/api/categories').then((response)=>{
               this.categories = response.data
            }).catch((error)=>{
                alert('Unable to fetch data.')
            })
        },
        onImageChange(e)
        {
            console.log(e)
            this.image = e.target.files[0];
        },
        createAlbum()
        {
            const config = {
                headers:{
                    "content-type":"multipart/form-data"
                }
            }
            let formData = new FormData();
            formData.append('image', this.image);
            formData.append('name', this.name);
            formData.append('description', this.description);
            formData.append('category', this.category);
            axios.post('/albums/store', formData, config).then((response)=>{

                this.name = '',
                this.image = '',
                this.description = '',
                this.category = '',
                this.album_id = response.data.id

                console.log(response.data.id);
                this.success = true;


            }).catch((error)=>{
                console.log("error");
                this.all_errors = error.response.data.errors
            })
        }
    }
}
</script>
