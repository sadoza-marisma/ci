<!DOCTYPE html>
<html>
<!--
    WARNING! Make sure that you match all Quasar related
    tags to the same version! (Below it's "@2.6.6")
  -->

<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet"
        type="text/css">
    <link href="https://use.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@^1.0.0/font/bootstrap-icons.css" rel="stylesheet"
        type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/quasar@2.6.6/dist/quasar.css" rel="stylesheet" type="text/css">
</head>

<body>
    <!-- example of injection point where you write your app template -->
    <div id="q-app">
        <q-layout>
            <q-page-container>
                @yield('cuerpo')
            </q-page-container>
        </q-layout>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quasar@2.6.6/dist/quasar.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quasar@2.6.6/dist/lang/es.umd.prod.js"></script>

    @yield('app')

</body>

</html>
