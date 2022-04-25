@extends ('quasar')

<?php
// https://thewebdev.info/2020/12/05/developing-vue-apps-with-the-quasar-library%E2%80%8A-%E2%80%8Afile-upload-progress/
?>
@section('cuerpo')
    <q-page class="q-ma-md">
        <div class="text-h1">Upload files</div>
        <div class="q-pa-md">
            <q-file :value="files" @input="updateFiles" label="Pick files" outlined multiple :clearable="!isUploading"
                style="max-width: 400px;">
                <template v-slot:file="{ index, file }">
                    <q-chip class="full-width q-my-xs" :removable="isUploading && uploadProgress[index].percent < 1" square>
                        <q-linear-progress class="absolute-full full-height" :value="uploadProgress[index].percent"
                            :color="uploadProgress[index].color" track-color="grey-2">
                        </q-linear-progress>

                        <q-avatar>
                            <q-icon :name="uploadProgress[index].icon"></q-icon>
                        </q-avatar>

                        <div class="ellipsis relative-position">
                            {{ file . name }}
                        </div>

                        <q-tooltip>
                            {{ file . name }}
                        </q-tooltip>
                    </q-chip>
                </template>

                <template v-slot:after v-if="canUpload">
                    <q-btn color="primary" dense icon="cloud_upload" round @click="upload" :disable="!canUpload"
                        :loading="isUploading">
                    </q-btn>
                </template>
            </q-file>
    </q-page>
@endsection

@section('app')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"
        integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="module">
        const api = axios.create({
            baseURL: 'http://localhost/ci/index.php/f'
        })

        const {
            ref,
            reactive,
            createApp,
            onMounted
        } = Vue;
        const {
            useQuasar,
        } = Quasar;

        const app = Vue.createApp({
                    setup() {
                        const state = reactive({
                            files: null,
                            uploadProgress: [],
                            uploading: null,
                            isUploading: false
                        });

                        const loading = ref(false);
                        const $q = useQuasar()

                        function isUploading() {
                            return uploading !== null;
                        }

                        function canUpload() {
                            return files !== null;
                        }

                        function updateFiles(files) {
                            files = files;
                            uploadProgress = (files || []).map((file) => ({
                                error: false,
                                color: "green-1",
                                percent: 0,
                                icon: file.type.indexOf("video/") === 0 ?
                                    "movie" : file.type.indexOf("image/") === 0 ?
                                    "photo" : file.type.indexOf("audio/") === 0 ?
                                    "audiotrack" : "insert_drive_file"
                            }));
                        }

                        function upload() {
                            clearTimeout(uploading);

                            const allDone = uploadProgress.every(
                                (progress) => progress.percent === 1
                            );

                            uploadProgress = uploadProgress.map((progress) => ({
                                ...progress,
                                error: false,
                                color: "green-2",
                                percent: allDone === true ? 0 : progress.percent
                            }))
                            __updateUploadProgress();
                        }

                        function __updateUploadProgress() {
                            let done = true;

                            uploadProgress = uploadProgress.map((progress) => {
                                if (progress.percent === 1 || progress.error === true) {
                                    return progress;
                                }

                                const percent = Math.min(
                                    1,
                                    progress.percent + Math.random() / 10
                                );
                                const error = percent < 1 && Math.random() > 0.95;

                                if (error === false && percent < 1 && done === true) {
                                    done = false;
                                }

                                return {
                                    ...progress,
                                    error,
                                    color: error === true ? "red-2" : "green-2",
                                    percent
                                };
                            });
                        }

                        uploading =
                            done !== true ?
                            setTimeout(this.__updateUploadProgress, 300) :
                            null;

                    })


                app.use(Quasar); Quasar.lang.set(Quasar.lang.es); app.mount('#q-app');
    </script>
@endsection
