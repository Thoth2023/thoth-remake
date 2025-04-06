<?php

return [
    'conducting' => [
        'title' => 'Condução'
    ],
    'header' => [
        'overview' => 'Visão Geral',
        'import_studies' => 'Importar Estudos',
        'study_selection' => 'Seleção de Estudos',
        'quality_assessment' => 'Avaliação de Qualidade',
        'snowballing' => 'Estudos Snowballing',
        'data_extraction' => 'Extração de Dados',
    ],
    'check' => [
        'domain' => 'Dados de "Domínio" não cadastrados para este projeto de revisão.',
        'language' => 'Dados de "Linguagem" não cadastrados para este projeto de revisão.',
        'study-types' => 'Dados de "Tipos de Estudo" não cadastrados para este projeto de revisão.',
        'research-questions' => 'Dados de "Questões de Pesquisa" não cadastrados para este projeto de revisão.',
        'databases' => 'Dados de "Base de Dados" não cadastrados para este projeto de revisão.',
        'term' => 'Dados de "Termos de busca" em String de Busca não cadastrados para este projeto de revisão.',
        'search-strategy' => 'Dados de "Estratégia de busca" não cadastrados para este projeto de revisão.',
        'criteria' => 'Dados de "Critérios de Inclusão ou Exclusão" não cadastrados para este projeto de revisão.',
        'general-score' => 'Dados de "Pontuação Geral/Intervalos" em Avaliação de Qualidade não cadastrados para este projeto de revisão.',
        'cutoff' => 'Dados de "Pontuação Mínima para Aprovação" não cadastrados ou "pontuação geral" está vazio para este projeto de revisão. ',
        'score-min' => 'Existem perguntas com "Pontuação de Qualidade Mínima para Aprovação" não definido para este projeto de revisão.',
        'question-qa' => 'Dados de "Questões de Qualidade" não cadastrados ou "Pontuação Mínima para Aprovação" não definido para este projeto de revisão.',
        'score-qa' => 'Dados de "Pontuação de Qualidade" não cadastrados para este projeto de revisão.',
        'data-extraction' => 'Dados de "Questões de Extração de dados" não cadastrados para este projeto de revisão.',
        'option-extraction' => 'Não há "Opções" cadastradas para as questões de extração de dados deste projeto de revisão.'
    ],

    'study-selection' => [
        'title' => 'Seleção de Estudos',
        'help' => [
            'content' => 'A seleção de estudos é uma fase crucial da revisão sistemática, na qual o autor analisa o título, resumo e palavras-chave de cada estudo, avaliando-os conforme as regras dos critérios de inclusão e exclusão estabelecidos no planejamento da revisão. Com base nesses critérios, o status de cada estudo será automaticamente alterado. No entanto, o pesquisador tem a opção de definir o status manualmente, mas, ao fazer isso, o sistema não registrará quais critérios foram considerados na avaliação.
            <br/><br/>
            <h6>Encontrar Duplicados</h6>
            <p>Temos duas opções para assinalar os papers como duplicados: </p>
            <ul><li>1- Os estudos com as informações  de "Título, Ano e Autores" podem ser assinalados como duplicados todos de uma vez; </li>
            <li>2- Os estudos com apenas alguma informação parecida, pode ser analisada individualmente. </li></ul>
            <h6>Avaliação por Pares (Decisão em grupo)</h6>
            <p>Caso realize a avaliação com 2 ou mais pesquisadores, e <b>haja alguma discordância</b> no resultado da mesma, irão aparecer as seguintes informações na tela:</p>
            <ul><li><div class="badge bg-warning text-white" role="button" title="Resolver Conflitos">
                <i class="fa-solid fa-file-circle-exclamation"></i> Resolver
            </div> | Será necessário tomar uma decisão final em grupo.</li>
            <li><div class="badge bg-light text-dark" role="button"  title="Conflitos Resolvidos">
                <i class="fa-solid fa-check-circle"></i> OK
            </div>| Decisão em grupo já confirmada.</li></ul>
            <p>Obs.: Se a revisão não conter Avaliação por Pares, estas opções não irão aparecer.</p>
            '
        ],
        'tasks' => 'Complete essas tarefas para avançar',
        'papers' => [
            'empty' => 'Nenhum Paper foi adicionado ainda.',
            'no-results' => 'Nenhum resultado encontrado.'
        ],
        'table' => [
            'id' => 'ID',
            'title' => 'Título',
            'acceptance-criteria' => 'Critério de Aceitação',
            'rejection-criteria' => 'Critério de Rejeição',
            'status' => 'Status',
            'database' => 'Base de Dados',
            'actions' => 'Ações',
        ],
        'buttons' => [
            'csv' => 'Exportar CSV',
            'xml' => 'Exportar XML',
            'pdf' => 'Exportar PDF',
            'print' => 'Imprimir',
            'duplicates' => 'Encontrar Duplicados',
            'filter' => 'Filtrar',
            'filter-by' => 'Filtrar por',
            'select-database' => 'Mostrar todos as Bases',
            'select-status' => 'Mostrar todos Status...',
            'search-papers' => 'Buscar estudos...',
        ],
        'modal' => [
            'author' => 'Autor',
            'year' => 'Ano',
            'database' => 'Base de Dados',
            'status-selection' => 'Status da Seleção',
            'abstract' => 'Resumo',
            'keywords' => 'Palavras-chave',
            'rejected' => 'Rejeitado',
            'paper-conflict' => 'Resolver Conflitos: Decisão em Grupo - Critério de I/E',
            'paper-conflict-note' => 'Nota/Justificativa',
            'paper-conflict-writer' => 'Escreva sua nota/justificativa...',
            'sucess-decision' => 'Decisão em Grupo salva com sucesso.',
            'error-status' => 'Selecione sua Decisão Final',
            'last-confirmation' => 'Confirmado por',
            'confirmation-date' => 'em',
            'table' => [
                'select' => 'Selecionar',
                'description' => 'Descrição',
                'type' => 'Tipo',
                'inclusion' => 'Inclusão',
                'exclusion' => 'Exclusão',
                'conflicts-members' => 'Avaliação do Membro',
                'conflicts-criteria' => 'Critério I/E Selecionado',
                'conflicts-status' => 'Status da avaliação',
            ],
            'option' => [
                'select' => 'Selecione uma opção',
                'remove' => 'Remover',
                'accepted' => 'Aceito',
                'rejected' => 'Rejeitado',
                'duplicated' => 'Duplicado',
                'unclassified' => 'Unclassified',
                'final-decision' => 'Decisão final do grupo sobre o paper?',
            ],
            'save' => 'Salvar',
            'update' => 'Atualizar',
            'confirm' => 'Confirmar',
            'close' => 'Fechar',
            'error' => 'Erro',
            'success' => 'Sucesso',
        ],
        'status' => [
            'duplicate' => 'Duplicado',
            'removed' => 'Removido',
            'unclassified' => 'Não Classificado',
            'included' => 'Incluído',
            'approved' => 'Aprovado',
            'rejected' => 'Rejeitado',
            'accepted' => 'Aceito'
        ],
        'count' => [
            'toasts' => [
                'no-databases' => 'Nenhuma base de dados encontrada para este projeto.',
                'no-papers' => 'Nenhum paper importado para este projeto.',
                'data-refresh' => 'Dados atualizados com sucesso',
            ],
        ],
        'duplicates' => [
            'title' => 'Revisão de papers Duplicados',
            'no-duplicates' => 'Não foram encontrados papers Duplicados.',
            'confirm-duplicate' => 'Paper marcado como duplicado.',
            'erro-find-paper' => 'Erro: Paper não encontrado.',
            'marked-unclassified' => 'Paper marcado como não classificado.',
            'analyse-all' => 'Todos os papers Duplicados foram analisados.',
            'duplicates-all' => "Todos os papers com Autor/Ano/Titulo iguais marcados como Duplicados",
            'unique-papers' => 'papers possivelmente duplicados para análise individual listados abaixo. ',
            'exact-duplicate-count' => 'papers com <b>Título/Ano/Autores</b> exatamente idênticos como duplicados.',
            'button-mark-all' => 'Marcar os :count como Duplicados',
            'table-title' => 'Título',
            'table-year' => 'Ano',
            'table-database' => 'Base de Dados',
            'table-duplicate' => 'Duplicado',
            'table-duplicate-yes' => 'SIM',
            'table-duplicate-no' => 'NÃO',

        ],
        'toasts' => [
            'denied' => 'Um visualizador não pode editar a seleção de estudos',
        ]

    ],
    'snowballing' => [
        'title' => 'Snowballing',
        'help' => [
            'content' => 'O snowballing envolve buscar recursivamente referências relevantes citadas na literatura recuperada e adicioná-las aos resultados da
            pesquisa. Snowballing é uma abordagem alternativa para descobrir evidências adicionais que não foram recuperadas através da pesquisa convencional.
            A eficácia do snowballing torna-o uma prática recomendada em revisões sistemáticas.
            <br/><br/>
            <h6>Encontrando Referências (Snowballing)</h6>
             <p>As referências são buscadas via <b>API "CrossRef"</b>.</p>
            <ul><li><b>Para Trás</b> | O primeiro passo é examinar a lista de referências e excluir os artigos que não atendem aos critérios básicos, como, por exemplo, idioma, ano de publicação
             e tipo de publicação (se considerar apenas artigos revisados por pares). Verificar/investigar onde e como esse estudo é referenciado;</li>
            <li><b>Para Frente</b> | se refere à identificação de novos artigos com base naqueles que citam o artigo que está sendo examinado</li></ul>

            <i class="fa-solid fa-users"></i> | Paper aceito em Avaliação por Pares (Decisão do Grupo) na etapa anterior.
            <p>Obs.: Se a revisão não conter Avaliação por Pares, este ícone não irá aparecer.</p>
            '
        ],
        'tasks' => 'Complete essas tarefas para avançar',
        'papers' => [
            'empty' => 'Nenhum artigo foi adicionado ainda.',
            'no-results' => 'Nenhum resultado encontrado.'
        ],
        'table' => [
            'id' => 'ID',
            'title' => 'Título',
            'status' => 'Status',
            'database' => 'Base de Dados',
            'actions' => 'Ações',
            'year' => 'Ano',
        ],
        'buttons' => [
            'csv' => 'Exportar CSV',
            'xml' => 'Exportar XML',
            'pdf' => 'Exportar PDF',
            'print' => 'Imprimir',
            'duplicates' => 'Encontrar Duplicados',
            'filter' => 'Filtrar',
            'filter-by' => 'Filtrar por',
            'select-database' => 'Mostrar todas as Bases de Dados',
            'select-status' => 'Mostrar todos os Status...',
            'select-type' => 'Mostrar todos os Tipos...',
            'search-papers' => 'Pesquisar artigos...',
        ],
        'modal' => [
            'author' => 'Autor',
            'year' => 'Ano',
            'database' => 'Base de Dados',
            'status-snowballing' => 'Status Snowballing',
            'abstract' => 'Resumo',
            'keywords' => 'Palavras-chave',
            'rejected' => 'Rejeitado',
            'table' => [
                'select' => 'Selecionar',
                'description' => 'Descrição',
                'type' => 'Tipo',
            ],
            'option' => [
                'select' => 'Selecione uma opção',
                'remove' => 'Remover',
                'accepted' => 'Aceito',
                'rejected' => 'Rejeitado',
                'duplicated' => 'Duplicado',
                'unclassified' => 'Não Classificado',
            ],
            'save' => 'Salvar',
            'close' => 'Fechar',
        ],
        'status' => [
            'duplicate' => 'Duplicado',
            'removed' => 'Removido',
            'unclassified' => 'Não Classificado',
            'included' => 'Incluído',
            'approved' => 'Aprovado',
            'rejected' => 'Rejeitado',
            'accepted' => 'Aceito'
        ],
        'count' => [
            'toasts' => [
                'no-databases' => 'Nenhuma base de dados encontrada para este projeto.',
                'no-papers' => 'Nenhum artigo importado para este projeto.',
                'data-refresh' => 'Dados atualizados com sucesso',
            ]
        ]
    ],


    'progress_bar' => [
        'title' => 'Progresso de Extração de Dados',
        'progress_title' => 'Progresso'
    ],

    'search' => [
        'title' => 'Pesquisa',
        'placeholder' => 'Selecione um Estudo',
        'add' => 'Add Novo Estudo',
        'help' => [
            'title' => 'Pesquisa',
            'content' => '',
        ],
    ],

    'table' => [
        'id' => 'ID',
        'title' => 'Titulo',
        'author' => 'Autor',
        'year' => 'Ano',
        'data_base' => 'Banco de Dados',
        'status' => 'Status',
    ],

    'status_extraction' => [
        'title' => 'Status da Extração',
        'no_extraction' => 'Não Extraido',
        'extracted' => 'Extraido',
        'removed' => 'Removido',
    ],

    'feedback' => [
        'done' => 'Status atualizado para Done.',
        'removed' => 'Estudo removido com sucesso.',
    ],

    'questions_table' => [
        'title' => 'Detalhes do Estudo',
    ],

    'import-studies' => [
        'title' => 'Importar estudos',
        'form' => [
            'database' => 'Base de dados',
            'selected-database' => 'Selecionar a base de dados',
            'upload' => 'Escolher arquivo',
            'add' =>  'Adicionar arquivo',
            'delete' => 'Deletar'
        ],
        'help' => [
            'content' => 'Insira Arquivos no Formato ".bib" ou ".csv" e faça a importação de arquivos de acordo com a base inserida no planejamento<br>
                     <ul>
                     <li><b>Obs.:</b> Se você deseja realizar <b>"Avaliação por Pares"</b>, é necessário convidar os pesquisadores  e adicionar ao projeto antes de importar os estudos (papers)</li>
                     <li>Para adicionar pesquisadores, navegue até <b>"Meus Projetos->Colaboradores"</b></li>
                     </ul>'
        ],
        'table' => [
            'database' => 'Base de dados',

            'studies-imported' => 'Estudos importados',
            'actions' => 'Ações',
            'file' => 'Arquivo',
            'files-uploaded' => 'Arquivos carregados',
            'no-files' => 'Nenhum arquivo carregado para esta base de dados.',
            'delete' => 'Deletar',
        ],
        'livewire' => [
            'logs' => [
                'database_associated_papers_imported' => 'Papers associados à base de dados importados',
                'deleted_file_and_papers' => 'Arquivo e :count papers associados excluídos',
            ],
            'selectedDatabase' => [
                'value' => [
                    'required' => 'O campo da base de dados é obrigatório.',
                    'exists' => 'A base de dados selecionada não existe.',
                ],
            ],
            'file' => [
                'required' => 'O campo de descrição é obrigatório.',
                'mimes' => 'O arquivo deve ser do tipo: bib, csv, txt.',
                'max' => 'O tamanho do arquivo não deve exceder 10MB.',
            ],
            'toasts' => [
                'file_uploaded_success' => 'Arquivo carregado com sucesso. Papers foram inseridos e o total será atualizado em instantes em tela.',
                'file_upload_error' => 'Ocorreu um erro ao importar papers. ERRO: :message',
                'project_database_not_found' => 'Base de dados do projeto não encontrada.',
                'file_deleted_success' => 'Arquivo excluído com sucesso. :count papers associados também foram excluídos.',
                'file_delete_error' => 'Ocorreu um erro ao excluir o arquivo: :message',
                'file_already_exists' => 'Um arquivo com este nome já foi adicionado nesta Base de Dados. Evite duplicações!',
                'denied' => 'Um visualizador não pode adicionar ou excluir papers.',
            ],
        ],

    ],

    'quality-assessment' => [
        'title' => 'Avaliação de Qualidade',
        'help' => [
            'content' => 'A Avaliação de Qualidade é uma fase importante, nessa etapa os pesquisadores deverão ler o estudo completo e responder as questões de qualidade que foram
                   planejadas para esta revisão. De acordo com as respostas assinaladas, a "Pontuação, Score Geral e o Status" desta avaliação são atualizados.
            <br/><br/>
            <h6>Avaliação por Pares (Decisão em grupo)</h6>
            <p>Caso realize a avaliação com 2 ou mais pesquisadores, e <b>haja alguma discordância</b> no resultado da mesma, irão aparecer as seguintes informações na tela:</p>
            <ul><li><div class="badge bg-warning text-white" role="button" title="Resolver Conflitos">
                <i class="fa-solid fa-file-circle-exclamation"></i> Resolver
            </div> | Será necessário tomar uma decisão final em grupo.</li>
            <li><div class="badge bg-light text-dark" role="button"  title="Conflitos Resolvidos">
                <i class="fa-solid fa-check-circle"></i> OK
            </div> | Decisão em grupo já confirmada.</li>
            <li><i class="fa-solid fa-users"></i> | Paper aceito em Avaliação por Pares (Decisão do Grupo) na etapa anterior.</li></ul>
            <p>Obs.: Se a revisão não conter Avaliação por Pares, estas opções não irão aparecer.</p>
            '
        ],
        'tasks' => 'Complete essas tarefas para avançar',
        'papers' => [
            'empty' => 'Nenhum Paper foi adicionado ainda.',
            'no-results' => 'Nenhum resultado encontrado.'
        ],
        'table' => [
            'id' => 'ID',
            'title' => 'Título',
            'acceptance-criteria' => 'Critério de Aceitação',
            'rejection-criteria' => 'Critério de Rejeição',
            'status' => 'Status',
            'database' => 'Base de Dados',
            'actions' => 'Ações',
            'general-score' => 'Pontuação Geral',
            'score' => 'Pontuação',
        ],
        'buttons' => [
            'csv' => 'Exportar CSV',
            'xml' => 'Exportar XML',
            'pdf' => 'Exportar PDF',
            'print' => 'Imprimir',
            'duplicates' => 'Encontrar Duplicados',
            'filter' => 'Filtrar',
            'filter-by' => 'Filtrar por',
            'select-database' => 'Mostrar todos as Bases',
            'select-status' => 'Mostrar todos Status...',
            'search-papers' => 'Buscar estudos...',
        ],
        'modal' => [
            'author' => 'Autor',
            'year' => 'Ano',
            'database' => 'Base de Dados',
            'status-quality' => 'Status de Qualidade',
            'quality-questions' => 'Questões de Qualidade',
            'abstract' => 'Resumo',
            'keywords' => 'Palavras-chave',
            'rejected' => 'Rejeitado',
            'select-score' => 'Selecione...',
            'quality-score' => 'Pontuação',
            'quality-description' => 'Qualidade',
            'table' => [
                'select' => 'Selecionar',
                'description' => 'Descrição',
                'score' => 'Pontuação',
                'min-to-app' => 'Mínimo para<br/> Aprovar',
            ],
            'option' => [
                'select' => 'Selecione uma opção',
                'remove' => 'Remover',
                'accepted' => 'Aceito',
                'rejected' => 'Rejeitado',
                'duplicated' => 'Duplicado',
                'unclassified' => 'Não Classificado',
            ],
            'save' => 'Salvar',
            'close' => 'Fechar',
        ],
        'resolve' => [
            'author' => 'Autor',
            'year' => 'Ano',
            'database' => 'Base de Dados',
            'status-selection' => 'Status da Seleção',
            'abstract' => 'Resumo',
            'keywords' => 'Palavras-chave',
            'rejected' => 'Rejeitado',
            'paper-conflict' => 'Resolver Conflitos: Decisão em Grupo - QA',
            'paper-conflict-note' => 'Nota/Justificativa',
            'paper-conflict-writer' => 'Escreva sua nota/justificativa...',
            'success-decision' => 'Decisão em Grupo salva com sucesso.',
            'resolved-decision' => 'Aceito em Avaliação por Pares (Decisão do Grupo) na etapa anterior.',
            'error-status' => 'Selecione sua Decisão Final',
            'last-confirmation' => 'Confirmado por',
            'confirmation-date' => 'em',
            'table' => [
                'select' => 'Selecionar',
                'description' => 'Descrição',
                'type' => 'Tipo',
                'inclusion' => 'Inclusão',
                'exclusion' => 'Exclusão',
                'conflicts-members' => 'Avaliação do Membro',
                'conflicts-qa' => 'Pontuação/ Avaliação Geral',
                'conflicts-status' => 'Status da avaliação',
            ],
            'option' => [
                'select' => 'Selecione uma opção',
                'remove' => 'Remover',
                'accepted' => 'Aceito',
                'rejected' => 'Rejeitado',
                'duplicated' => 'Duplicado',
                'unclassified' => 'Unclassified',
                'final-decision' => 'Decisão final do grupo sobre o paper?',
            ],
            'save' => 'Salvar',
            'update' => 'Atualizar',
            'confirm' => 'Confirmar',
            'close' => 'Fechar',
            'error' => 'Erro',
            'success' => 'Sucesso',
        ],
        'status' => [
            'duplicate' => 'Duplicado',
            'removed' => 'Removido',
            'unclassified' => 'Não Classificado',
            'included' => 'Incluído',
            'approved' => 'Aprovado',
            'rejected' => 'Rejeitado',
            'accepted' => 'Aceito'
        ],
        'count' => [
            'toasts' => [
                'no-databases' => 'Nenhuma base de dados encontrada para este projeto.',
                'no-papers' => 'Nenhum paper importado para este projeto.',
                'data-refresh' => 'Dados atualizados com sucesso',
            ],
        ],

    ],

    'data-extraction' => [
        'title' => 'Extração de Dados',
        'help' => [
            'content' => 'A Extração de Dados é a última fase da revisão. Nessa etapa os pesquisadores após ler o estudo completo, deverão extrair as informações
                  que respondam as questões de extração planejadas. Após a concluída é necessário assinalar a extração como finalizada, para cada estudo,
                  para assim estas informações constarem nos relatórios existentes.
            <br/><br/>
            <h6>Avaliação por Pares (Decisão em grupo)</h6>
            <p>Caso realize a avaliação com 2 ou mais pesquisadores, e <b>haja alguma discordância</b> no resultado da mesma, irão aparecer as seguintes informações na tela:</p>
            <ul><li><i class="fa-solid fa-users"></i> | Paper aceito em Avaliação por Pares (Decisão do Grupo) na etapa anterior.</li></ul>
            <p>Obs.: Se a revisão não conter Avaliação por Pares, este ícone não irá aparecer.</p>
            '
        ],
        'tasks' => 'Complete essas tarefas para avançar',
        'papers' => [
            'empty' => 'Nenhum artigo foi adicionado ainda.',
            'no-results' => 'Nenhum resultado encontrado.'
        ],
        'table' => [
            'id' => 'ID',
            'title' => 'Título',
            'status' => 'Status',
            'database' => 'Base de Dados',
            'actions' => 'Ações',
            'year' => 'Ano',
        ],
        'buttons' => [
            'csv' => 'Exportar CSV',
            'xml' => 'Exportar XML',
            'pdf' => 'Exportar PDF',
            'print' => 'Imprimir',
            'duplicates' => 'Encontrar Duplicados',
            'filter' => 'Filtrar',
            'filter-by' => 'Filtrar por',
            'select-database' => 'Mostrar todas as Bases de Dados',
            'select-status' => 'Mostrar todos os Status...',
            'search-papers' => 'Pesquisar artigos...',
        ],
        'modal' => [
            'author' => 'Autor',
            'year' => 'Ano',
            'database' => 'Base de Dados',
            'status-extraction' => 'Status da Extração',
            'abstract' => 'Resumo',
            'keywords' => 'Palavras-chave',
            'table' => [
                'select' => 'Selecionar',
                'description' => 'Descrição',
                'type' => 'Tipo',
            ],
            'option' => [
                'select' => 'Selecione uma opção',
                'removed' => 'Remover',
                'done' => 'Concluído',
                'to_do' => 'A fazer',
                'to do' => 'A fazer',
                'unclassified' => 'Não Classificado',
            ],
            'save' => 'Salvar',
            'close' => 'Fechar',
        ],
        'status' => [
            'done' => 'Concluído',
            'removed' => 'Removido',
            'to do' => 'A Fazer',
            'to_do' => 'A Fazer',
        ],
        'count' => [
            'toasts' => [
                'no-databases' => 'Nenhuma base de dados encontrada para este projeto.',
                'no-papers' => 'Nenhum artigo importado para este projeto.',
                'data-refresh' => 'Dados atualizados com sucesso',
            ]
        ]
    ],


];
