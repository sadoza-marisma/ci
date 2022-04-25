@extends ('quasar')
@section('cuerpo')
    <q-page class="q-ma-md">
        <div class="text-h1">Upload files</div>
        <div>

            <div class="q-pa-md">
                <div class="q-gutter-sm row items-start">
                    <q-uploader url="http://localhost:4444/upload" label="Individual upload" multiple
                        style="max-width: 300px" />

                    <q-uploader url="http://localhost:4444/upload" label="Batch upload" multiple batch
                        style="max-width: 300px" />
                </div>
            </div>

        </div>
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
                    f: {
                        nombre: '',
                        numero: 0,
                        fecha: '',
                    },
                    accept: false,
                    errors: {}
                });

                const loading = ref(false);
                const $q = useQuasar()

                function onSubmit() {
                    /*
                        if (state.accept !== true) {
                            $q.notify({
                                color: 'red-5',
                                textColor: 'white',
                                icon: 'warning',
                                message: 'You need to accept the license and terms first'
                            })
                            return;
                        }*/
                    loading.value = true;

                    const config = {
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    }

                    //console.log("Datos formulario [" + state.f.nombre + "]");
                    console.log(state.f)
                    api.post('/store', URLEncodedParams(state.f), config)
                        .then((response) => {
                            const data = response.data;
                            console.log(data)
                            if (!data.error) {
                                $q.notify({
                                    color: 'green-4',
                                    textColor: 'white',
                                    icon: 'cloud_done',
                                    message: 'Submitted'
                                })
                            } else {
                                state.errors = data.errors;
                                console.log(state);
                            }
                        })
                        .catch((error, data) => {
                            $q.notify({
                                color: 'negative',
                                position: 'top',
                                message: "No se han podido obtener los datos \n " + error,
                                icon: 'report_problem'
                            })
                        })
                        .finally(() => {
                            loading.value = false
                        })


                }

                function onReset() {
                    state.f.nombre = null
                    state.f.numero = null
                    state.f.fecha = null;
                    state.accept = false
                    state.errors = {}
                    console.log('Fin reset--')
                }

                function URLEncodedParams(fields) {
                    const params = new URLSearchParams()
                    for (const key in fields) {
                        params.append(`${key}`, `${fields[key]}`);
                    }
                    return params;
                }
                return {
                    state: state,
                    loading: loading,
                    onSubmit: onSubmit,
                    onReset: onReset

                }
            }
        })


        app.use(Quasar);
        Quasar.lang.set(Quasar.lang.es);
        app.mount('#q-app');
    </script>
@endsection
