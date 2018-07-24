<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

  <!-- Manifest -->
  <link rel="manifest" href="{{ asset('manifest.json') }}">

  <!-- Theme color -->
  <meta name="theme-color" content="#3367D6"/>

  <meta name="description" content="A hadith library maintained by users."/>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script type="text/javascript">
    // Check that service workers are registered
    if ('serviceWorker' in navigator) {
      // Use the window load event to keep the page load performant
      window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js');
      });
    }
    </script>

    <noscript>
      Your browser does not support JavaScript! You need Javascript enabled to use this app
    </noscript>

</head>
<body>
    <div id="vue-app">


            <router-view>

            </router-view>




    </div>
    <!--script src="{{-- mix('js/bundle.js') --}}"></script-->

</body>
</html>
