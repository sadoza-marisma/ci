@extends ('quasar')
@section('cuerpo')
    <q-page class="q-ma-md">
        <div class="text-h1">Información</div>
        <div>
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <template v-if='loading' style="text-align:center">
                    <q-spinner color="primary" size="3em" :thickness="10" />
                </template>
                <div class="col-12">
                    <q-input clearable outlined v-model="state.f.nombre" label="Nombre"
                        :error="typeof state.errors.nombre !== 'undefined'" :error-message="state.errors.nombre"
                        hint="Su nombre completo">

                    </q-input>

                </div>
                <div class="row mt-3">
                    <div class="col-4">
                        <q-btn label="Submit" type="submit" color="primary" />
                    </div>
                    <div class="col-4">
                        <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
                    </div>
                </div>

            </q-form>
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
