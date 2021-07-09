<template>
    <div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!--body-->
                <form @submit.prevent="updateAlbum" method="POST" action="" enctype="multipart/form-data">

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-left">Album Name</label>
                        <div class="col-md-12">
                            <input id="name" type="text" class="form-control" name="name" autocomplete="name" v-model="editrecord.name" required autofocus>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-left">Description</label>

                        <div class="col-md-12">
                            <textarea id="description"  class="form-control" name="description"  v-model="editrecord.description"></textarea>

                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="category" class="col-md-4 col-form-label text-md-left">Category</label>

                        <div class="col-md-12">
                            <select id="category"  class="form-control" name="category" v-model="editrecord.category_id"  >
                                <option value="">Select Category</option>
                                <option v-for="(category, index) in categories" :key="index" :value="category.id" >
                                    {{category.name}}
                                </option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="image" class="col-md-4 col-form-label text-md-left"></label>

                        <div class="col-md-12">
                            <input id="image" type="file"  class="form-control" name="image" v-on:change="onImageChange">
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <button id="submit" type="submit"  class="btn btn-dark" name="submit">Save</button>
                        </div>
                    </div>
                </form>


                <!--body end-->
            </div>
            <!--
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            -->
            </div>
        </div>
        </div>

    </div>
</template>

<script>
export default {
    props:["editrecord"],
    data() {
        return {
            categories:[],
            $image:''
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
        updateAlbum()
        {

           const config = {
                headers:{
                    "content-type":"multipart/form-data"
                }
            }
            let formData = new FormData();
            formData.append('image', this.image);
            formData.append('name', this.editrecord.name);
            formData.append('description', this.editrecord.description);
            formData.append('category', this.editrecord.category_id);

            formData.append('_method', 'put');

            axios.post('/albums/'+this.editrecord.id+'/edit', formData,config).then((response)=>{
                $('#exampleModal').modal('hide');
                this.$emit('recordUpdated', response);

                //sweetalert


                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Your album has been saved',
                showConfirmButton: true,
                timer: 5000
                })

                //sweet alert end



            }).catch((error)=>{
                console.log(error);
            })


        },
        onImageChange(e)
        {
            console.log(e)
            this.image = e.target.files[0];
        },
    },
}
</script>
