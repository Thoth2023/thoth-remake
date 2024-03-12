@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar', ['title' => 'Home'])
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg">
        <span class="mask bg-gradient-faded-dark opacity-5"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-5">About Us</h1>
                    <p class="text-lead text-white">Use these awesome forms to login or create new account in your
                        project for free.</p>
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
                            <a href="javascript:" class="card-title h5 d-block text-darker">
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
                    <div class="card-body pt-2">
                        <a href="javascript:" class="card-title h5 d-block text-darker">
                            Development
                        </a>
                        <p>Thoth was created by undergraduate students in Software Engineering, maintained and updated by
                            students and professors of the Graduate Program in Software Engineering - PPGES at the Federal
                            University of Pampa (UNIPAMPA).</p>

                    </div>
                    <div class="card-body pt-2">
                        <a href="javascript:" class="card-title h5 d-block text-darker">
                            Open Source Project
                        </a>
                        <a class="nav-link d-flex align-items-center me-2"
                            href="https://github.com/Thoth2023/thoth2.0/blob/main/LICENSE">
                            MIT license
                        </a>
                        <a href="javascript:" class="card-title h6 d-block text-darker">
                            Technologies used:
                        </a>
                        <ul>
                            <li>PHP Language</li>
                            <li>MySQL</li>
                            <li>Git</li>
                            <li>Laravel Framework</li>
                            <li>Docker</li>
                            <li>Bootstrap</li>
                            <li>Migrations</li>
                            <li>PHPSpreadSheet</li>
                            <li>League/CSV</li>
                            <li>PHPUnit</li>
                            <li>JavaScript</li>
                            <li>Git Actions</li>
                        </ul>
                    </div>

                    <div class="card-body pt-2">
                        <a href="javascript:" class="card-title h5 d-block text-darker">
                            About the Tool:
                        </a>
                        <p>Thoth is a powerful tool to support collaborative systematic reviews. Developed as a
                            multi-platform solution, Thoth aims to automate important parts of the systematic review
                            process, facilitating and streamlining the work of researchers and professionals involved in
                            this type of study.</p>

                        <img src="/img/about/AboutTool.PNG" class="img-fluid" alt="Imagem">

                        <a href="javascript:" class="card-title h6 d-block text-darker">
                            Cross-platform, collaborative tool
                        </a>
                        <p>Thoth was designed to work on different platforms, such as computers, tablets and smartphones,
                            allowing users to work collaboratively in a shared virtual environment. This characteristic
                            makes it possible for several investigators to work simultaneously, sharing information and
                            collaborating in real time.</p>

                        <a href="javascript:" class="card-title h6 d-block text-darker">
                            Automate parts of the process
                        </a>
                        <p>Thoth aims to automate several steps of the systematic review process, reducing the need for
                            manual work and minimizing errors. Some of the automated functionality includes generating
                            search strings, managing studies in the selection and quality steps, generating data for use in
                            jobs, and creating charts and tables that represent the steps of import, selection, quality, and
                            extraction.</p>

                        <a href="javascript:" class="card-title h6 d-block text-darker">
                            Search string generation
                        </a>
                        <p>One of the crucial tasks in the systematic review is the definition of appropriate search terms
                            to locate relevant studies. Thoth is capable of automatically generating search strings based on
                            user-defined criteria, helping to obtain more accurate and comprehensive results.</p>

                        <a href="javascript:" class="card-title h6 d-block text-darker">
                            Management of studies in the selection stage
                        </a>
                        <p>During the selection stage, where studies are evaluated for their relevance to the review, Thoth
                            offers features to facilitate the management of these studies. Users can import studies into the
                            tool, organize them and perform screening based on predefined criteria, making the process more
                            efficient and traceable.</p>

                        <a href="javascript:" class="card-title h6 d-block text-darker">
                            Management of studies in the quality stage
                        </a>
                        <p>After the initial selection of studies, it is essential to carry out an assessment of the
                            methodological quality of each included study. Thoth assists in this task, allowing users to
                            manage and evaluate selected studies, ensuring the integrity and reliability of the data used in
                            the review.</p>

                        <a href="javascript:" class="card-title h6 d-block text-darker">
                            Generating data for use in jobs
                        </a>
                        <p>Thoth is capable of generating structured and organized data from selected studies, which can be
                            directly used in scientific work or in the production of reports. This functionality saves
                            researchers time and effort by providing information ready for analysis and interpretation.</p>

                        <a href="javascript:" class="card-title h6 d-block text-darker">
                            Generation of graphs and tables
                        </a>
                        <p>To clearly and objectively visualize the progress and results of the systematic review stages,
                            Thoth offers the automatic generation of graphs and tables. These visual representations allow
                            for quick analysis and a better understanding of the current state of the job.</p>

                        <a href="javascript:" class="card-title h6 d-block text-darker">
                            Report generation
                        </a>
                        <p>In addition to generating graphs and tables, Thoth also provides the creation of detailed reports
                            on the steps of import, selection, quality and extraction of studies. These reports provide a
                            complete overview of the systematic review process, including information about the criteria
                            used, included and excluded studies, quality assessment, and extracted data. These reports can
                            be exported in different formats, such as PDF or Word, making it easy to communicate the results
                            and share them with colleagues and supervisors.</p>
                        <p>In summary, Thoth is a powerful tool that aims to optimize activities related to collaborative
                            systematic reviews. With automation features, search string generation, study management, data
                            generation, graphs, tables and reports, Thoth provides greater efficiency, accuracy and
                            collaboration in the systematic review process. By simplifying complex tasks and providing
                            visual insights and comprehensive reporting, Thoth contributes to the production of
                            high-quality, evidence-based research.</p>
                        <p>To better understand the functionalities developed, each of them will be explained in the
                            following items.</p>
                        <ul>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Multiple Member Management
                                </a>
                                <p>It is possible to add several members to an RS with different levels and manage them.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Manage Projects
                                </a>
                                <p>The project administrator has the possibility to edit and delete the project.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Activity View
                                </a>
                                <p>The user is shown all member activity records for a given project.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Progress Display
                                </a>
                                <p>The user has the option of viewing the progress of his project at each stage of the SR,
                                    thus allowing greater control over it.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Protocol Management
                                </a>
                                <p>The researchers of a project have the possibility to add, delete, edit and visualize all
                                    the information referring to the protocol of a certain SR.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Study Import
                                </a>
                                <p>Researchers import studies into RS through bib or csv files for a given database, being
                                    able to exclude the files included.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Selection of Studies
                                </a>
                                <p>The selection of studies according to the criteria is carried out individually by each
                                    member of the project.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Checking for Duplicate Studies
                                </a>
                                <p>Each researcher can use this feature to find duplicate studies within the files that
                                    he/she has added to the project.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Selection Ranking Information
                                </a>
                                <p>The user is presented with the quantity and percentage of each status in the selection
                                    step.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Study information visualization
                                </a>
                                <p>The researcher can look at the information from the studies to help with their selection.
                                </p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Status for each Member
                                </a>
                                <p>The reviewer is presented with the percentage of each status in the selection stage
                                    referring to each researcher in the project.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Conflicts in Selection
                                </a>
                                <p>The reviewer is presented with all conflicts generated by divergences in the status of a
                                    study classified by two or more researchers.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Resolution of Conflicts in Selection
                                </a>
                                <p>The reviewer has the possibility to view the comments left by the researchers in each
                                    study and this can help him to decide which status the study fits.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Quality Assessment of Studies
                                </a>
                                <p>Researchers have the possibility to evaluate each study in relation to quality issues.
                                </p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Quality Conflicts
                                </a>
                                <p>The reviewer is presented with all conflicts generated by differences in the quality
                                    status of a study classified by two or more researchers.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Data extraction
                                </a>
                                <p>Researchers have the possibility to answer the extraction questions for each study, thus
                                    being able to extract data to answer the quality questions.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Report
                                </a>
                                <p>It is exposed to graphic users with the information of each stage of the project, making
                                    it possible to export and edit them.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Export to Latex
                                </a>
                                <p>Project data can be exported to a latex file, enabling the creation of other studies to
                                    disseminate the results.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Export to BibTex
                                </a>
                                <p>Studies can be exported in BibTex format to be used as a reference in other studies.</p>
                            </li>
                            <li>
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    Improvement of Search Strings
                                </a>
                                <p>This function was developed by other members of the research group, called StringImprover
                                    2 , being a web service based on web-sockets. The choice of web-sockets was made
                                    considering the need for the tool to provide updates on the progress of string
                                    generation, as the search can take a long time. In order to use it, the client must send
                                    the keywords, which will be used in the creation of strings and evaluation of articles,
                                    and a group of ideal articles. These ideal documents are articles that the researcher
                                    considered and deemed relevant, so they will be used as a reference to evaluate the
                                    articles found in the search.</p>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
