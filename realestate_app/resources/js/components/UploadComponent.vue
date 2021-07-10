<template>
    <div>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group files text-center " ref="fileform">
                <input type="file" ref="file" multiple="multiple">
                <span id="val"></span>
                <a class="btn btn-primary" @click.prevent="submitFiles()">Upload</a>
            </div>
        </form>

        <progress max="100" style="width:100%" :value.prop="uploadPercentage" v-if="uploading"></progress>


        <div style="margin-top:25px;" class="container">
            <div class="">
                <div class="row">

                    <div class="card h-100 border-0 shadow" style="width:32%; margin:5px;"  v-for="(image,index) in images" :key="index">
                        <img class="card-img-top img-fluid" :src="'/images/'+image.image" alt="Card image cap">
                        <div class="card-body">
                            <p class="card-text">
                                <a class="btn btn-danger">Delete</a>
                            </p>
                        </div>
                    </div>



                </div>
            </div>
        </div>


    </div>
</template>

<script>
export default {
    props:['album_id'],
    data() {
        return {
            uploadPercentage:'',
            uploading:false,
            images:[]
        }
    },
    mounted() {
        this.getImage()
    },

    methods: {
        submitFiles()
        {
            /*
            const config = {
                headers:{
                    "content-type":"multipart/form-data"
                }
            }
            */

            let formData = new FormData();
            for(var i= 0; i<this.$refs.file.files.length; i++ )
            {
                let file = this.$refs.file.files[i];
                formData.append('files['+i+']', file);
                formData.append('album_id', this.album_id);
            }

            this.uploading = true;
            this.$refs.value = "";

            axios.post('/uploadImage/',formData,{
                headers:{
                    "content-type":"multipart/form-data"
                },
                onUploadProgress:function(progressEvent)
                {
                    this.uploadPercentage = parseInt(Math.round((progressEvent.loaded*100)/progressEvent.total));
                }.bind(this)

            }).then((resposne)=>{

                this.getImage();

                //sweetalert


                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Your images have been uploaded and saved',
                showConfirmButton: true,
                timer: 5000
                })

                //sweet alert end



            }).catch((error)=>{
                console.log(error);
            })
        },
        getImage()
        {
            axios.get('/getimages/').then((response)=>{
                this.images = response.data;
            }).catch((error)=>{
                console.log("error:" + error);
            });
        }
    },
}
</script>
