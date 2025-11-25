<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $project->title }}</title>

    {{-- CSS DO MODAL, AJUSTADO PARA PDF --}}
    <style>
        /* ===== GRID Bootstrap-like para PDF ===== */
        .row {
            display: block;
            clear: both;
            width: 100%;
        }

        [class^="col-"] {
            float: left;
            box-sizing: border-box;
            padding: 6px;
        }

        /* colunas com compensação de padding (100% total) */
        .col-12 { width: 100%; }
        .col-8  { width: 66.4%; }
        .col-6  { width: 49.2%; }
        .col-4  { width: 32.8%; }

        /* ===== CARDS / BOXES ===== */
        .card, .protocol-box {
            background: #f9fafb;
            border: 1px solid #e3e6ea;
            border-radius: 8px;
            padding: 10px 12px;
            margin-bottom: 12px;
            page-break-inside: avoid;
        }

        h6 {
            text-transform: uppercase;
            font-weight: 700;
            color: #344767;
            margin: 0 0 6px;
        }

        /* ===== TABLES ===== */
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            page-break-inside: avoid;
        }

        .table th, .table td {
            border: 1px solid #e3e6ea;
            padding: 6px 8px;
            vertical-align: top;
        }

        .table thead {
            background: #f9fafb;
            font-weight: 700;
            color: #344767;
        }

        /* ===== TYPO & UTILITY ===== */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.45;
            color: #101828;
            margin: 10px 18px;
        }

        .text-muted { color: #777; }
        .small { font-size: 11px; }
        .text-break {
            word-break: break-word;
            white-space: normal;
        }

        ul {
            margin: 0;
            padding-left: 16px;
        }

        .protocol-text p { margin: 0 0 6px; }

        .highlight-approval { background: #d1fae5; }

        /* ===== PAGE BREAK CONTROL ===== */
        .page-break { page-break-after: always; }

        .col-half {
            width: 48%;
            float: left;
            padding: 6px;
            box-sizing: border-box;
        }

    </style>
</head>

<body>
{{-- ===== HEADER PDF ===== --}}
<table width="100%" style="margin-bottom:18px">
    <tr>
        {{-- Logo Thoth --}}
        <td width="25%" style="text-align:left; vertical-align:middle;">
            <table style="border-collapse: collapse;">
                <tr>
                    <td style="vertical-align:middle; padding-right:6px;">
                        <img src="{{ public_path('img/logo.svg') }}"
                             style="height:90px; width:auto;"
                             alt="Thoth Logo">
                    </td>
                    <td style="vertical-align:middle;">
                <span style="font-size:30px;font-weight:700;color:#344767;display:inline-block;">Thoth</span>
                    </td>
                </tr>
            </table>
        </td>


        {{-- Título --}}
        <td width="50%" style="text-align:center;">
            <h3 style="margin:0; font-size:18px; text-transform:uppercase;">
                {{ __('project/public_protocol.public_protocol') }}
            </h3>
        </td>

        {{-- QR Code --}}
        <td width="25%" style="text-align:center;">
            <img src="{{ $qrCodeSvgBase64 }}" width="80" alt="QR Code Thoth">
            <div style="font-size:9px; color:#555;">thoth-slr.com</div>
        </td>
    </tr>
</table>
<hr style="border:0; border-top:1px solid #e3e6ea; margin:8px 0 18px;">

{{-- 1. INFO --}}
@include('livewire.projects.public.pdf.info')

{{-- 2. OVERVIEW --}}
@include('livewire.projects.public.pdf.overview')

{{-- 3. SEARCH STRATEGY --}}
@include('livewire.projects.public.pdf.search_strategy')

{{-- 4. RESEARCH QUESTIONS --}}
@include('livewire.projects.public.pdf.research_questions')

{{-- 5. CRITERIA --}}
@include('livewire.projects.public.pdf.criterias')

{{-- 6. TERMS & GENERIC STRING --}}
@include('livewire.projects.public.pdf.terms')

{{-- 7. QUALITY --}}
@include('livewire.projects.public.pdf.quality')

{{-- 8. EXTRACTION --}}
@include('livewire.projects.public.pdf.extraction')

</body>
</html>
