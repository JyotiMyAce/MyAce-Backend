@extends('layout.base')

@section('master')
    <div class="container-scroller">
        <div class="main-wrapper">
            <!-- partial -->

            @if (!\Route::is('admin-login'))
                @include('layout.include.header')
                @include('layout.include.sidebar')
            @endif
            @yield('content')
        </div>
        <!-- main-panel ends -->
    </div>
@endsection
