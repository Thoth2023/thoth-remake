@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-EW1W7Jea6l9mZq7r8w4g+Lj/h5gPflAPeR4x6WVNOe4atK8OeGWeR7hQYdj4k8ntQF6ZfXKgKJVlWGfTNvCHhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .form-check {
            display: inline-block;
            margin-right: 10px;
        }
        .form-check-input {
            width: 20px;
            /* largura */
            height: 20px;
            /* altura */
        }
        .form-check-label {
            font-size: 15px;
            /* tamanho da fonte */
            margin-top: 5px
        }
        .copy-icon-container {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 40px;
            height: 40px;
            background-color: #007bff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .copy-icon {
            color: white;
            font-size: 24px;
            /* Tamanho do ícone */
            cursor: pointer;
        }
    </style>
    @stack('styles')
    @include('layouts.navbars.auth.topnav', ['title' => 'Export'])
    <div class="row mt-4 mx-4">
        @include('project.components.project-header', ['project' => $project, 'activePage' => 'export'])
        <div class="container-fluid py-4">
            <div class="container-fluid py-4">
                @livewire('export.export')
               
        </div>
        @include('layouts.footers.auth.footer')
    </div>
    </div>
@endsection


