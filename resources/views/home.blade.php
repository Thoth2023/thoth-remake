
@extends('layouts/main')

@section('content')
<div id="content">
    <h2 class="title">Thoth</h2>
    <p class="text-content">Systematic reviews are a type of literature review that uses systematic methods to collect secondary data, critically appraise research studies, and synthesize studies. Systematic reviews formulate research questions that are broad or narrow in scope, and identify and synthesize studies that directly relate to the systematic review question.hey are designed to provide a complete, exhaustive summary of current evidence relevant to a research question. Systematic reviews of randomized controlled trials are key to the practice of evidence-based medicine, and a review of existing studies is often quicker and cheaper than embarking on a new study.</p>
    <div id="info">
        <div class="info-content">
            <h2 class="info-title title align-center">
                <span class="material-symbols-outlined">
                    question_mark
                </span>
                Questions
            </h2>
            <p>Defining a question and agreeing an objective method.</p>
        </div>
        <div class="info-content">
            <h2 class="info-title title align-center">
                <span class="material-symbols-outlined">
                    database
                </span>
                Relevant data
            </h2>
            <p>A search for relevant data from research that matches certain criteria. For example, only selecting research that is good quality and answers the defined question.</p>
        </div>
        <div class="info-content">
            <h2 class="info-title title align-center">
                <span class="material-symbols-outlined">
                    done
                </span>
                Quality
            </h2>
            <p>Assess the quality of the data by judging it against criteria identified at the first stage.</p>
        </div>
        <div class="info-content">
            <h2 class="info-title title align-center">
                <span class="material-symbols-outlined">
                    monitoring
                </span>
                Analyse the data
            </h2>
            <p>Analyse and combine the data (using complex statistical methods) which give an overall result from all of the data. Once these stages are complete, the review may be published, disseminated and translated into practice after being adopted as evidence.</p>
        </div>
    </div>
</div>
@endsection