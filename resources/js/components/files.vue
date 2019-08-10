<template>
    <div>
        <div class="form-group">
            <label for="file">
                My files
            </label>
            <input type="file" class="form-control" id="file" @change="onFileChange" multiple>
        </div>
        <div class="form-group">
            <div class="row" v-for="(file,i) in showfiles.file_name" :key="i">
                <div class="col-md-6">
                    <div class="progress" style="height:5px">
                        <div class="progress-bar" role="progressbar" :style="'width:' +showfiles.file_progress[i]+ '%;'" :aria-valuenow="showfiles.file_progress[i]" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    {{showfiles.file_progress[i]}}%
                </div>
                <div class="col-md-6">
                    {{file}}
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-secondary" @click="uploadFile">Upload</button>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                files:[],
                showfiles:{
                    file_name:[],
                    file_progress:[],
                    upload_res:[]
                }
            }
        },
        mounted() {

        },
        methods:{
            onFileChange(e){
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length){return;}
                this.files = files;
                for (let i = 0; i < this.files.length; i++) {
                    this.showfiles.file_name.push(files[i].name);
                    this.showfiles.file_progress.push(0);
                }
            },
            uploadFile(){
                for (let i = 0; i < this.files.length; i++) {
                    const fd = new FormData();
                    fd.append('file',this.files[i],this.files[i].name);
                    fd.append('_token',document.querySelector('meta[name=csrf-token]').content);
                    axios.post('/file-upload',fd,{
                        onUploadProgress:uploadEvent=>{
                            let mydata = Math.round(uploadEvent.loaded/uploadEvent.total)*100;
                        }
                    })
                        .then(res=>{
                            console.log(res.data)
                        })
                        .catch(e=>{console.log(e)});

                }
            }
        }
    }
</script>
