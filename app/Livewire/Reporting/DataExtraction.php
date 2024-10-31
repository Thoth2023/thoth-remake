<?php

namespace App\Livewire\Reporting;

use App\Models\Project\Planning\DataExtraction\Question;
use App\Models\Project\Planning\DataExtraction\EvaluationExOp;
use App\Models\Project\Planning\DataExtraction\EvaluationExTxt;
use App\Models\Project\Planning\DataExtraction\Option;

use Livewire\Component;
use Illuminate\Support\Str;

class DataExtraction extends Component
{
    public $currentProject;

    public function mount()
    {
        // Obtém o ID do projeto a partir da URL
        $projectId = request()->segment(2);
        $this->currentProject = $projectId;
    }

    public function getWordCloudData()
    {
        // Pega as questões do projeto atual
        $questions = Question::where('id_project', $this->currentProject)->get();

        $words = [];

        foreach ($questions as $question) {
            if ($question->type == 1) { // Tipo texto
                $textResponses = EvaluationExTxt::where('id_qe', $question->id_de)->pluck('text');

                foreach ($textResponses as $response) {
                    // Removendo tags HTML do texto
                    $cleanText = strip_tags($response);
                    $cleanText = Str::words($cleanText, 1000, '');

                    // Dividindo o texto em palavras e agregando para a wordcloud
                    $wordList = preg_split('/[\s,.]+/', $cleanText);
                    foreach ($wordList as $word) {
                        $words[] = strtolower($word); // Armazena em lowercase para evitar duplicatas
                    }
                }
            } elseif (in_array($question->type, [2, 3])) {
                // Tipo opção
                $optionResponses = EvaluationExOp::where('id_qe', $question->id_de)
                    ->pluck('id_option');

                foreach ($optionResponses as $optionId) {
                    if ($optionId) {
                        // Busca a descrição da opção
                        $optionDescription = Option::where('id_option', $optionId)->value('description');
                        if ($optionDescription) {
                            $words[] = strtolower($optionDescription);
                        }
                    }
                }
            }
        }

        // Contagem das palavras
        $wordCounts = array_count_values($words);
        $wordCloudData = [];
        foreach ($wordCounts as $word => $count) {
            if (strlen($word) > 2) { // Ignorando palavras muito curtas
                $wordCloudData[] = ['name' => $word, 'weight' => $count];
            }
        }

        return $wordCloudData;
    }

    public function getPackedBubbleData()
    {
        $questions = Question::where('id_project', $this->currentProject)->get();
        $seriesData = [];

        foreach ($questions as $question) {
            $questionData = [
                'name' => $question->description,
                'data' => []
            ];

            $responsesCount = [];

            if ($question->type == 1) { // Respostas textuais
                $textResponses = EvaluationExTxt::where('id_qe', $question->id_de)->pluck('text');

                foreach ($textResponses as $response) {
                    $cleanText = strip_tags($response);
                    $cleanText = strtolower($cleanText); // Considerar todas as respostas em lowercase para evitar duplicatas sensíveis a maiúsculas

                    if (isset($responsesCount[$cleanText])) {
                        $responsesCount[$cleanText]++; // Incrementa o contador se a resposta já existir
                    } else {
                        $responsesCount[$cleanText] = 1; // Inicializa o contador
                    }
                }
            } elseif (in_array($question->type, [2, 3])) { // Respostas por opção
                $optionResponses = EvaluationExOp::where('id_qe', $question->id_de)->pluck('id_option');

                foreach ($optionResponses as $optionId) {
                    if ($optionId) {
                        $optionDescription = strtolower(Option::where('id_option', $optionId)->value('description'));

                        if (isset($responsesCount[$optionDescription])) {
                            $responsesCount[$optionDescription]++;
                        } else {
                            $responsesCount[$optionDescription] = 1;
                        }
                    }
                }
            }

            // Formata as respostas para o gráfico
            foreach ($responsesCount as $response => $count) {
                $questionData['data'][] = [
                    'name' => $response,
                    'value' => $count // O valor agora reflete o número de vezes que a resposta apareceu
                ];
            }

            // Adiciona as questões com respostas
            if (!empty($questionData['data'])) {
                $seriesData[] = $questionData;
            }
        }

        return $seriesData;
    }

    public function getRadarChartData()
    {
        $questions = Question::where('id_project', $this->currentProject)->get();
        $categories = [];
        $data = [];

        foreach ($questions as $question) {
            $categories[] = $question->description;

            if ($question->type == 1) { // Tipo texto
                $responseCount = EvaluationExTxt::where('id_qe', $question->id_de)->count();
                $data[] = $responseCount;
            } elseif (in_array($question->type, [2, 3])) { // Tipo opção
                $responseCount = EvaluationExOp::where('id_qe', $question->id_de)->count();
                $data[] = $responseCount;
            }
        }

        return [
            'categories' => $categories,
            'data' => $data
        ];
    }

   /* public function getBarChartData()
    {
        // Obtém todas as questões do projeto atual
        $questions = Question::where('id_project', $this->currentProject)->get();

        $barChartData = [
            'categories' => [], // Aqui vamos agrupar as categorias Ano, Database, Funcionalidades
            'series' => []      // Dados de respostas para cada questão
        ];

        foreach ($questions as $question) {
            // Adiciona a descrição da questão como categoria (Ano, Database, Funcionalidades)
            $barChartData['categories'][] = $question->description;

            // Inicializa a contagem de respostas para cada questão
            $responsesCount = [];

            // **Para respostas textuais (type == 1)**, buscar na tabela evaluation_ex_txt
            if ($question->type == 1) {
                $textResponses = EvaluationExTxt::where('id_qe', $question->id_de)->pluck('text');

                foreach ($textResponses as $response) {
                    $cleanText = strtolower(strip_tags($response)); // Normaliza o texto

                    // Agrupa e conta as respostas duplicadas
                    if (isset($responsesCount[$cleanText])) {
                        $responsesCount[$cleanText]++;
                    } else {
                        $responsesCount[$cleanText] = 1;
                    }
                }
            }

            // **Para respostas baseadas em opções (type == 2 ou 3)**, buscar na tabela evaluation_ex_op
            if (in_array($question->type, [2, 3])) {
                $optionResponses = EvaluationExOp::where('id_qe', $question->id_de)->pluck('id_option');

                foreach ($optionResponses as $optionId) {
                    if ($optionId) {
                        // Pega a descrição da opção
                        $optionDescription = strtolower(Option::where('id_option', $optionId)->value('description'));

                        // Agrupa e conta as respostas duplicadas
                        if (isset($responsesCount[$optionDescription])) {
                            $responsesCount[$optionDescription]++;
                        } else {
                            $responsesCount[$optionDescription] = 1;
                        }
                    }
                }
            }

            // Monta os dados da questão atual para o gráfico
            $responseData = [];
            foreach ($responsesCount as $response => $count) {
                $responseData[] = [
                    'name' => ucfirst($response), // Nome da resposta (ex: "2020", "IEEE", etc.)
                    'y' => $count                 // Número de ocorrências
                ];
            }

            // Adiciona a série de dados dessa questão ao gráfico
            $barChartData['series'][] = [
                'name' => $question->description, // Nome da questão (ex: "Ano", "Database")
                'data' => $responseData           // Dados das respostas agrupadas e contadas
            ];
        }

        // Retorna os dados do gráfico para o frontend
        return $barChartData;
    }*/

    public function render()
    {
        return view('livewire.reporting.data-extraction', [
            'wordCloudData' => json_encode($this->getWordCloudData()),
            'packedBubbleData' => json_encode($this->getPackedBubbleData()),
            'radarChartData' => json_encode($this->getRadarChartData()),
            //'barChartData' => json_encode($this->getBarChartData()),
        ]);
    }

}
