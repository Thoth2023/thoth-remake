@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar', ['title' => 'Home'])
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
         style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg'); background-position: top;">
        <span class="mask bg-gradient-faded-warning opacity-5"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-5">FAQ</h1>
                    <p class="text-lead text-white">Here are 10 questions for an FAQ based on the provided text.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="mt-lg-n12 mt-md-n13 mt-n12 justify-content-center">

                <div class="card d-inline-flex p-3 mt-8">
                    <div class="card-body pt-2">
                            <a href="javascript:;" class="card-title h4 d-block text-darker">
                            Thoth 2.0
                            </a>
                            <div class="card-body pt-2">
                                    <a href="javascript:" class="card-title h4 d-block text-darker">
                                        Common Questions:
                                    </a>
                                </div>
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item1">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <a href="javascript:" class="card-title h5 d-block text-darker">
                                            What is Thoth?
                                            </a>
                                        </button>
                                    </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                            Thoth is a powerful tool to support collaborative systematic reviews. It is a multi-platform solution developed to automate important parts of the systematic review process, facilitating and streamlining the work of researchers and professionals involved in this type of study.
                                            </div>
                                        </div>
                                </div>
                                <div class="accordion-item2">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <a href="javascript:" class="card-title h5 d-block text-darker">
                                            What are the main features of Thoth?
                                            </a>
                                        </button>
                                    </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                            Thoth's main functionalities include: automated generation of search strings, management of studies in the selection and quality stages, generation of data for use in scientific works, generation of graphs and tables, creation of detailed reports and collaboration between team members .
                                            </div>
                                        </div>
                                </div>
                                <div class="accordion-item3">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <a href="javascript:" class="card-title h5 d-block text-darker">
                                            What technologies were used in the development of Thoth?
                                            </a>
                                        </button>
                                    </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                            Thoth was developed using the following technologies: PHP Language, MySQL, Git, Laravel Framework, Docker, Bootstrap, Migrations, PHPSpreadSheet, League/CSV, PHPUnit, JavaScript and Git Actions.
                                            </div>
                                        </div>
                                </div>
                                <div class="accordion-item4">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            <a href="javascript:" class="card-title h5 d-block text-darker">
                                            Who are responsible for the development and maintenance of Thoth?
                                            </a>
                                        </button>
                                    </h2>
                                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                            Thoth was created by undergraduate Software Engineering students and is maintained and updated by students and professors from the Graduate Program in Software Engineering (PPGES) at the Federal University of Pampa (UNIPAMPA).
                                            </div>
                                        </div>
                                </div>
                                <div class="accordion-item5">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            <a href="javascript:" class="card-title h5 d-block text-darker">
                                            Is Thoth an open source tool? What license is used?
                                            </a>
                                        </button>
                                    </h2>
                                        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                            Yes, Thoth is an open source project. It is licensed under the MIT License, which allows its use, modification and distribution freely, as long as the copyright and original license are maintained.
                                            </div>
                                        </div>
                                </div>
                                <div class="accordion-item6">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                            <a href="javascript:" class="card-title h5 d-block text-darker">
                                            Is Thoth a cross-platform tool? What devices does it support?
                                            </a>
                                        </button>
                                    </h2>
                                        <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                            Yes, Thoth is designed to work on different platforms such as computers, tablets and smartphones. This allows users to work collaboratively in a shared virtual environment, regardless of the device used.
                                            </div>
                                        </div>
                                </div>
                                <div class="accordion-item7">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                            <a href="javascript:" class="card-title h5 d-block text-darker">
                                            How does Thoth automate parts of the systematic review process?
                                            </a>
                                        </button>
                                    </h2>
                                        <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                            Thoth automates many steps of the systematic review process, reducing the need for manual work and minimizing errors. It generates search strings, manages studies in the selection and quality steps, generates structured data, creates charts and tables, and produces detailed reports on the process steps.
                                            </div>
                                        </div>
                                </div>
                                <div class="accordion-item8">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                            <a href="javascript:" class="card-title h5 d-block text-darker">
                                            What are the study management functionalities offered by Thoth?
                                            </a>
                                        </button>
                                    </h2>
                                        <div id="collapseEight" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                            Thoth offers functionality for importing studies, selecting studies based on criteria, checking duplicate studies, viewing study information, assessing study quality and resolving conflicts generated by classification differences.
                                            </div>
                                        </div>
                                </div>
                                <div class="accordion-item9">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                            <a href="javascript:" class="card-title h5 d-block text-darker">
                                            How does Thoth generate structured and organized data for use in scientific work?
                                            </a>
                                        </button>
                                    </h2>
                                        <div id="collapseNine" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                            Thoth is capable of extracting relevant data from selected studies, allowing researchers to answer extraction questions. These data are then organized and structured, ready to be used in scientific work, facilitating the analysis and interpretation of the results obtained.
                                            </div>
                                        </div>
                                </div>
                                <div class="accordion-item10">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                            <a href="javascript:" class="card-title h5 d-block text-darker">
                                            Does Thoth offer the generation of graphs, tables and reports? How can these results be shared?
                                            </a>
                                        </button>
                                    </h2>
                                        <div id="collapseTen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                            Yes, Thoth offers automatic generation of graphs, tables and reports. These visual representations help to clearly and objectively visualize the progress and results of the systematic review steps. Results can be shared by exporting reports in different formats, such as PDF or Word, facilitating the communication of results with colleagues and supervisors.
                                            </div>
                                        </div>
                                </div>
                            </div>



                </div>

            </div>
        </div>

@endsection
