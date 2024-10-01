<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quality Assessment</title>
    <style>
        /* Garantir a consistência da tabela no PDF */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid #dee2e6; /* Border do Bootstrap */
            text-align: left;
        }
        th {
            background-color: #f8f9fa; /* Header com cor padrão do Argon/Bootstrap */
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Linhas pares com uma cor diferente */
        }
        /* Garantir que as larguras das colunas sejam consistentes */
        .col-id { width: 7%; }
        .col-title { width: 38%; }
        .col-generalScore { width: 15%; }
        .col-score { width: 20%; }
        .col-status { width: 10%; }
        .col-peer-review { width: 10%; }
    </style>
</head>
<body>
<h3 style="text-align: center; font-size: 18px;">Quality Assessment | Researcher: {{ $papers->first()->firstname }} {{ $papers->first()->lastname}} </h3>

<table class="table table-bordered">
    <thead>
    <tr style="background-color: #333; color: white; font-weight: bold;">
        <th class="col-id">ID</th>
        <th class="col-title">Title</th>
        <th class="col-generalScore">General Score</th>
        <th class="col-score">Score</th>
        <th class="col-status">Status</th>
        <th class="col-peer-review">Peer Review</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($papers as $paper)
        <tr>
            <td class="col-id">{{ $paper->id_paper }}</td>
            <td class="col-title">{{ $paper->title }}</td>
            <td class="col-generalScore">{{ $paper->general_score ?? 'N/A' }}</td>
            <td class="col-score">{{ $paper->score ?? 'N/A' }}</td>
            <td class="col-status">{{ $paper->status_description ?? 'N/A' }}</td>
            <td class="col-peer-review">
                @if ($paper->new_status_paper == 1)
                    Accepted
                @elseif ($paper->new_status_paper == 2)
                    Rejected
                @else
                    N/A
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
