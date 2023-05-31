@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar', ['title' => 'About'])
    <div class="card d-inline-flex p-3 mt-8">
        <div class = "card-body">
            <a href="javascript:;" class="card-title h4 d-block text-darker">
            Thoth 2.0
            </a> 
            <div class = "card">
                <div class = "card-body">
                    <a href="javascript:;" class="card-title h5 d-block text-darker">
                    About the Tool:
                    </a> 
                    <p>Thoth is a powerful tool to support collaborative systematic reviews. Developed as a multi-platform solution, Thoth aims to automate important parts of the systematic review process, facilitating and streamlining the work of researchers and professionals involved in this type of study.</p>
                </div>
            </div>
        </div>
        <div class = "card-body">
            <div class = "card">
                <div class = "card-body">
                    <a href="javascript:;" class="card-title h5 d-block text-darker">
                    New features:
                    </a> 
                    <ul>
                        <li>Recover password</li>
                        <li>Bug Databases</li>
                        <li>New interface</li>
                        <li>New framework</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class = "card-body">
            <div class = "card">
                <div class = "card-body">
                    <a href="javascript:;" class="card-title h5 d-block text-darker">
                    Development
                    </a> 
                    <p>Thoth was created by undergraduate students in Software Engineering, maintained and updated by students and professors of the Graduate Program in Software Engineering - PPGES at the Federal University of Pampa (UNIPAMPA).</p>
                </div>
            </div>
        </div>
        <div class = "card-body">
            <div class = "card">
                <div class = "card-body">
                    <a href="javascript:;" class="card-title h5 d-block text-darker">
                    Open Source Project
                    </a> 
                    <a class="nav-link d-flex align-items-center me-2"
                        href="https://github.com/Thoth2023/thoth2.0/blob/main/LICENSE">
                        MIT license
                    </a>
                    <a href="javascript:;" class="card-title h6 d-block text-darker">
                    Technologies used:
                    </a> 
                    <ul>
                        <li >PHP Language</li>
                        <li >MySQL</li>
                        <li >Git</li>
                        <li >Laravel Framework</li>
                        <li >Docker</li>
                        <li >Bootstrap</li>
                        <li >Migrations</li>
                        <li >PHPSpreadSheet</li>
                        <li >League/CSV</li>
                        <li >PHPUnit</li>
                        <li >JavaScript</li>
                        <li >Git Actions</li>
                    </ul>
                </div>
            </div>
        </div>
    @include('layouts.footers.guest.footer')
    </div>
    @endsection