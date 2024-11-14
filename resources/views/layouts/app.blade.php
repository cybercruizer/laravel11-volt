<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    @vite('resources/sass/app.scss')

    <!-- Scripts -->
    @vite('resources/js/app.js')
    
    <script src="{{asset('jquery.min.js')}}"></script>

    <link href="{{asset('vendor/datatables-2.0.8/dataTables.bootstrap5.css')}}" rel="stylesheet">

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> -->
    <script src="{{asset('vendor/datatables-2.0.8/dataTables.js')}}"></script>
    <script src="{{asset('vendor/datatables-2.0.8/dataTables.bootstrap5.js')}}"></script>
    @stack('js-header')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .input-group>.select2-container--bootstrap-5 {
            width: auto;
            flex: 1 1 auto;
        }

        .input-group>.select2-container--bootstrap-5 .select2-selection--single {
            height: 100%;
            line-height: inherit;
            padding: 0.5rem 1rem;
        }

        @media print {
            body {
                margin: 0 !important;
                /* Remove margin */
            }
            div {
                margin: 0 !important;
            }
            .content {
                margin: 0 !important;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    @include('layouts.nav')
    @include('layouts.sidenav')
    <main class="content">
        @include('sweetalert::alert')
        {{-- TopBar --}}
        @include('layouts.topbar')
        <div class="main py-2">
            <div class="card">
                @yield('content')
            </div>
        </div>
        {{-- Footer --}}
        @include('layouts.footer')
    </main>
    @yield('scripts')
</body>

</html>
