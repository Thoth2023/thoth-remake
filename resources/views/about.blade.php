@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar', ['title' => 'About'])
    <div class="card d-inline-flex p-2 mt-8">
        <div class = "card-body">
             <h2>Thoth 2.0</h2>
            <div class = "card">
                <div class = "card-body">
                    <h4>About the Tool:</h4>
                    <p>Thoth is a powerful tool to support collaborative systematic reviews. Developed as a multi-platform solution, Thoth aims to automate important parts of the systematic review process, facilitating and streamlining the work of researchers and professionals involved in this type of study.</p>
                </div>
            </div>
        </div>
        <div class = "card-body">
            <div class = "card">
                <div class = "card-body">
                    <h4>New features</h4>
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
                    <h4>Development</h4>
                    <p>Thoth was created by undergraduate students in Software Engineering, maintained and updated by students and professors of the Graduate Program in Software Engineering - PPGES at the Federal University of Pampa (UNIPAMPA).</p>
                </div>
            </div>
        </div>
        <div class = "card-body">
            <div class = "card">
                <div class = "card-body">
                    <h4>Open Source Project</h4>
                    <a class="nav-link d-flex align-items-center me-2 active"
                        href="https://github.com/Thoth2023/thoth2.0/blob/main/LICENSE">
                        MIT license
                    </a>
                    <h6>Technologies used:</h6>
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