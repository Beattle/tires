<template>
    <div class="root-template">
        <div class="row justify-content-center">
            <div class="col-2">
                <button
                    v-on:click="slide" type="button" id="upload" class="btn btn-secondary">Загрузить из *.xlsx
                </button>
            </div>
            <div class="col-2">
                    <button v-on:click="slide" id="create" class="btn btn-secondary">Создать</button>
            </div>
        </div>
        <div class="form-container upload transition mb-2" ref="fc" :style="{height: slideHeight.upload+'px'}">
            <div class="progress transition">
                <div
                    aria-valuemax="100"
                    aria-valuemin="0"
                    :aria-valuenow="uploadPercentage"
                    class="progress-bar"
                    role="progressbar"
                    :style="{width: uploadPercentage + '%'}"
                >{{uploadPercentage}}%
                </div>
            </div>
            <form v-on:submit.prevent="submitFile">
                <div class="form-group">
                    <input
                        aria-describedby="file"
                        class="form-control"
                        id="file"
                        name="price"
                        ref="file"
                        required
                        type="file"
                        v-on:change="handleFileUpload"
                        @click="$refs.file.value=null"
                    />
                </div>
                <button class="btn btn-primary">Загрузить</button>
            </form>
        </div>
        <div class="form-conainer create transition" ref="ft" :style="{height: slideHeight.create+'px'}">
            <form action="/create" method="post">
                <input type="hidden" name="_token" :value="csrf">
                <div class="form-group" v-for="item in fields">
                    <label :for="item">{{headers[item]}}</label>
                    <input  :id="item" type="text" :name=' item ' class="form-control"/>
                </div>
                <button class="btn btn-primary">Добавить</button>
            </form>
    </div>

    </div>

</template>

<script>
    export default {
        mounted () {
            console.log(this.csrf)
        },
        data () {
            return {
                file: '',
                uploadPercentage: 0,
                slideHeight: {upload:0,create:0},
            }
        },
        props: ['headers', 'fields','csrf'],
        methods: {
            submitFile: function (event) {
                let formData = new FormData();
                formData.append('price', this.file);

                axios.post('/',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        onUploadProgress: (progressEvent) => {
                            this.uploadPercentage = parseInt(
                                Math.round((progressEvent.loaded / progressEvent.total) * 100)
                            );
                        }
                    }
                ).then(function () {

                })
                    .catch(function () {

                    })
            },
            handleFileUpload: function (event) {
                this.file = this.$refs.file.files[0];
                this.uploadPercentage = 0;
            },
            slide: function (e) {
                if(e.target.id === 'upload'){
                    if (this.slideHeight.upload > 0) {
                        this.slideHeight.upload = 0
                        return;
                    }
                    this.slideHeight.upload = this.$refs.fc.scrollHeight
                }
                if(e.target.id === 'create'){
                    if (this.slideHeight.create > 0) {
                        this.slideHeight.create = 0
                        return;
                    }
                    this.slideHeight.create = this.$refs.ft.scrollHeight
                }
            }
        },
    }
</script>
<style>
    .transition {
        overflow: hidden;
        transition: height 400ms ease-out;
    }
</style>
