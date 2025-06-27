@extends('layout.base')
@section('master')
    <div class="container-scroller">
        @php
            $auth = auth()->user();
        @endphp
        <div class="main-wrapper">
            <!-- partial -->
            @include('layout.include.header')
            @include('layout.include.sidebar')
            @yield('content')
        </div>
        <!-- main-panel ends -->
    </div>
@endsection
