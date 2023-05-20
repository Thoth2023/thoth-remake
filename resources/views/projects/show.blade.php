@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Error'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="alert alert-warning" role="alert">
            This page is currently under construction.
        </div>
    </div>
</div>

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6>JSON Response</h6>
            </div>
            <div class="card-body">
                <pre><code>
                    {{ json_encode($project, JSON_PRETTY_PRINT) }}
                </code></pre>
            </div>
        </div>
    </div>
</div>
@endsection
