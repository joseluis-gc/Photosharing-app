<template>
    <div>
        <table style="border: 0 !important" class="table table-image table-striped table-hover">
            <thead style="border: 0">
                <tr style="border: 0">
                    <th scope="col">SN</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Category</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(album,index) in albums" :key="index">
                    <td >{{index+1}}</td>

                    <td ><img :src="'/album/' + album.image" style="max-width:151px" class="img-fluid img-thumbnail"></td>

                    <td>{{album.name}}</td>

                    <td>{{album.description}}</td>

                    <td>{{album.category.name}}</td>

                    <td>
                        <a :href="'/upload/images/'+album.id" class="btn btn-primary">
                            Upload
                        </a>
                    </td>

                    <td>
                        <button @click.prevent="edit(album.id)" type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModal">
                            Edit
                        </button>
                    </td>

                    <td>
                        <button @click.prevent="deleteRecord(album.id)" type="button" class="btn btn-danger">
                            Delete
                        </button>
                    </td>

                </tr>
            </tbody>
        </table>

        <edit :editrecord="records" @recordUpdated="recordUpdate"></edit>


    </div>
</template>

<script>
export default
{
    data() {
        return {
            albums:[],
            records:[]
        }
    },
    created() {
        axios.get('/getalbums').then((response)=>{
            this.albums = response.data
        }).catch((error)=>{
            console.log(error);
        })
    },
    methods: {
        edit(id){
            axios.get('/api/albums/'+id).then((response)=>{
                this.records = response.data;
            }).catch((error)=>{
                console.log(error);
            });
        },
        recordUpdate(response)
        {
            this.albums =  response.data
        },
        deleteRecord(id)
        {
                //sweetalert
                Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                text: 'You wont be able to get this back.',
                showCancelButton:true,
                confirmButtonColor:'#d33',
                showCancelColor:'#3085d6',
                confirmButtonText: 'Yes, Delete This!'
                }).then((result)=>{
                    if(result.value)
                    {
                        axios.delete('/albums/'+id+'/delete').then((response)=>{
                                //sweetalert
                                Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Your album has been deleted',
                                showConfirmButton: true,
                                timer: 5000
                                })
                                //sweet alert end
                            this.albums = response.data;
                        }).catch((error)=>{
                            console.log(error);
                        })
                    }
                })

                //sweet alert end

        }
    },
}
</script>
