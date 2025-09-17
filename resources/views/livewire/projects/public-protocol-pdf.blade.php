<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $project->title }}</title>
    <style>
        @charset "UTF-8";
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .section {
            margin-bottom: 2rem;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .no-data {
            text-align: center;
            padding: 1rem;
            color: #666;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
<div class="section">
    <h1 class="section-title">{{ $project->title }}</h1>
    <p><strong>{{ __('project/public_protocol.description') }}:</strong> {{ $project->description }}</p>
    <p><strong>{{ __('project/public_protocol.objectives') }}:</strong> {{ $project->objectives }}</p>
    <p><strong>{{ __('project/public_protocol.created_by') }}:</strong> {{ $project->created_by }}</p>
    <p><strong>{{ __('project/public_protocol.start_date') }}:</strong> {{ $project->start_date }}</p>
    <p><strong>{{ __('project/public_protocol.end_date') }}:</strong> {{ $project->end_date }}</p>
</div>

<div class="section page-break">
    <h2 class="section-title">{{ __('project/public_protocol.research_questions') }}</h2>
    @if($project->researchQuestions)
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('project/public_protocol.description') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($project->researchQuestions as $question)
                <tr>
                    <td>{{ $question->id_research_question }}</td>
                    <td>{{ $question->description }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">{{ __('project/public_protocol.no_research_questions_defined') }}</div>
    @endif
</div>

<!-- dai add aqui o que quiser que tenha mais no pdf -->
</body>
</html>
