<?php

return [
    'planning' => 'Planejamento',
    'content-helper'=>'<p>
O planejamento do protocolo RSL é a etapa em que você transforma a sua ideia de revisão em um plano estruturado.
Um protocolo bem preenchido reduz viés, torna o estudo reproduzível e facilita o trabalho em equipe.
Recomendamos preencher cada seção na ordem abaixo, pois muitas decisões dependem das anteriores.
</p>
<p>
Use esta lista como um checklist de planejamento antes de iniciar a condução da revisão.
</p>

<ol>
  <li><strong>Domínios:</strong> Defina claramente em quais domínios ou áreas o estudo se insere
(por exemplo, Engenharia de Software, Saúde, Educação). Isso ajuda a manter o foco temático da revisão.</li>

  <li><strong>Idiomas:</strong> Informe os idiomas que serão considerados na revisão.
Lembre-se de alinhar estas escolhas com a equipe e com o escopo do estudo.</li>

  <li><strong>Tipos de Estudo:</strong> Especifique quais tipos de estudos serão incluídos
(por exemplo, estudos empíricos, estudos de caso, surveys, revisões anteriores).</li>

  <li><strong>Palavras-chave:</strong> Cadastre termos ou expressões que representam os conceitos-chave da pesquisa.
Elas serão a base para a construção dos termos de busca e das strings.</li>

  <li><strong>Datas do Projeto:</strong> Indique o período em que a revisão será realizada.
Isto é útil para planejamento de cronograma e para registrar a janela temporal do estudo.</li>

  <li><strong>Questões de Pesquisa:</strong> Formule as perguntas que a revisão pretende responder.
Elas orientam todas as demais decisões de planejamento, seleção e análise.</li>

  <li><strong>Bases de Dados:</strong> Selecione os repositórios de artigos e publicações acadêmicas que serão utilizados
(por exemplo, Scopus, Web of Science, IEEE Xplore).</li>

  <li><strong>Sugerir nova Base de Dados:</strong> Caso alguma base importante para sua área não esteja disponível,
      utilize este recurso para sugerir a inclusão no Thoth.</li>

  <li><strong>Termos de Busca:</strong> A partir dos domínios, palavras-chave e questões de pesquisa,
      defina os termos que serão combinados para recuperar estudos relevantes.</li>

  <li><strong>String de Busca:</strong> Construa as strings combinando termos, operadores booleanos e filtros
      adequados a cada base de dados.</li>

  <li><strong>Estratégia de Busca:</strong> Descreva como as buscas serão conduzidas
(buscas piloto, refinamentos iterativos, combinação de bases, ajustes por base de dados).</li>

  <li><strong>Critérios de Inclusão e Exclusão:</strong> Defina critérios objetivos para decidir
      quais estudos entram ou saem da revisão, considerando título, resumo, texto completo e qualidade.</li>

  <li><strong>Questões de Qualidade:</strong> Cadastre as questões que serão usadas para avaliar a qualidade de cada estudo.
Elas podem ter pesos diferentes de acordo com sua importância.</li>

  <li><strong>Pontuação de Qualidade:</strong> Para cada questão de qualidade, defina as regras de pontuação
(por exemplo, Sim, Parcialmente, Não) e os valores numéricos correspondentes.</li>

  <li><strong>Tabela com as Questões:</strong> Revise a visão consolidada das questões de qualidade e de suas pontuações.
Nesta etapa, ajuste pesos e verifique se todas as questões estão claras e consistentes.</li>

  <li><strong>Intervalos de Pontuação Geral:</strong> Defina faixas de pontuação (por exemplo, Alta, Média, Baixa qualidade)
      que serão usadas para classificar cada estudo ao final da avaliação de qualidade.</li>

  <li><strong>Pontuação Mínima Geral para Aprovação:</strong> Estabeleça a pontuação mínima que um estudo deve atingir
      para ser considerado adequado e seguir para as próximas etapas da revisão.</li>

  <li><strong>Perguntas de Extração de Dados:</strong> Cadastre as perguntas que definem quais informações
      você deseja extrair dos estudos para responder às questões de pesquisa.</li>

  <li><strong>Opções de Perguntas de Extração de Dados:</strong> Para cada pergunta, crie os tipos de resposta
(texto livre, múltipla escolha, numérico etc.) de forma padronizada e fácil de analisar.</li>

  <li><strong>Tabela de Extração:</strong> Revise a visão geral de todas as perguntas de extração.
Utilize esta tela para conferir lacunas, editar itens e garantir que todos os dados necessários serão coletados.</li>
</ol>',
    'button' => [
        'close' => 'Fechar',
    ],
    'placeholder' => [
        'search' => 'Pesquisar...',
    ],
    'overall' => [
        'title' => 'Informações Gerais',
        'no-results' => 'Nenhum resultado encontrado.',
        'domain' => [
            'title' => 'Domínios',
            'description' => 'Descrição',
            'add' => 'Adicionar Domínio',
            'update' => 'Atualizar Domínio',
            'list' => [
                'headers' => [
                    'name' => 'Nome',
                    'description' => 'Descrição',
                    'enter_description' => 'Digite a descrição do domínio',
                    'actions' => 'Ações',
                ],
                'actions' => [
                    'edit' => [
                        'button' => 'Editar',
                        'modal' => [
                            'title' => 'Editar Domínio',
                            'description' => 'Descrição',
                            'cancel' => 'Cancelar',
                            'save' => 'Salvar',
                        ],
                    ],
                    'delete' => [
                        'button' => 'Excluir',
                        'modal' => [
                            'title' => 'Excluir Domínio',
                            'description' => 'Tem certeza de que deseja excluir este domínio?',
                            'cancel' => 'Cancelar',
                            'delete' => 'Excluir',
                        ],
                    ],
                ],
                'empty' => 'Nenhum domínio foi adicionado ainda.',
                'no-results' => 'Nenhum resultado encontrado.',
            ],
            'help' => [
                'title' => 'Domínios',
                'content' => 'Domínios são categorias temáticas ou áreas de assunto que você define para estruturar e categorizar ' .
                    'o conjunto diversificado de fontes de literatura que você encontra durante sua revisão. Cada domínio representa ' .
                    'um aspecto específico ou tópico relacionado à sua pergunta de pesquisa ou área de interesse.
                    <br><strong>Ex.:</strong> Engenharia de Software, Medicina, Ciências da Saúde, etc...',
            ],
            'livewire' => [
                'logs' => [
                    'added' => 'Domínio adicionado',
                    'updated' => 'Domínio atualizado',
                    'deleted' => 'Domínio excluído',
                ],
                'description' => [
                    'required' => 'O campo de descrição é obrigatório.',
                ],
                'toasts' => [
                    'added' => 'Domínio adicionado com sucesso.',
                    'updated' => 'Domínio atualizado com sucesso.',
                    'deleted' => 'Domínio deletado com sucesso.',
                    'duplicate' => 'Domínio duplicado não é permitido.',
                    'denied' => 'Um visualizador não pode adicionar, editar ou excluir domínios.'
                ],
            ]
        ],
        'language' => [
            'title' => 'Idiomas',
            'add' => 'Adicionar Idioma',
            'list' => [
                'select' => [
                    'placeholder' => 'Selecione um Idioma',
                    'validation' => 'O campo de idioma é obrigatório.'
                ],
                'headers' => [
                    'languages' => 'Idiomas',
                    'actions' => 'Ações',
                ],
                'actions' => [
                    'delete' => [
                        'button' => 'Excluir',
                        'tooltip' => 'Excluir Idioma',
                    ],
                ],
                'empty' => 'Nenhum idioma foi adicionado ainda.',
            ],
            'help' => [
                'title' => 'Idiomas',
                'content' => 'Idiomas representam diferentes idiomas nos quais as fontes de literatura são escritas. ' .
                    'Você pode adicionar e gerenciar idiomas para categorizar as fontes com base em sua língua de origem.',
            ],
            'livewire' => [
                'logs' => [
                    'added' => 'Idioma adicionado',
                    'updated' => 'Idioma atualizado',
                    'deleted' => 'Idioma excluído',
                ],
                'language' => [
                    'required' => 'O campo de idioma é obrigatório.',
                    'already_exists' => 'O idioma selecionado já existe neste projeto.',
                ],
                'toasts' => [
                    'added' => 'Idioma adicionado com sucesso.',
                    'deleted' => 'Idioma deletado com sucesso.',
                    'denied' => 'Um visualizador não pode adicionar, editar ou excluir idiomas.',
                ],
            ]
        ],
        'study_type' => [
            'title' => 'Tipos de Estudo',
            'types' => 'Tipos',
            'add' => 'Adicionar Tipo de Estudo',
            'list' => [
                'select' => [
                    'placeholder' => 'Selecione um Tipo de Estudo',
                    'validation' => 'O campo de tipo de estudo é obrigatório.',
                ],
                'headers' => [
                    'types' => 'Tipos',
                    'actions' => 'Ações',
                ],
                'actions' => [
                    'delete' => [
                        'button' => 'Excluir',
                        'tooltip' => 'Excluir Tipo de Estudo',
                    ],
                ],
                'empty' => 'Nenhum tipo de estudo foi adicionado ainda.',
            ],
            'help' => [
                'title' => 'Tipos de Estudo',
                'content' => 'Tipos de estudo representam diferentes categorias ou classificações para os tipos de estudos ' .
                    'incluídos em sua revisão de literatura. Você pode adicionar e gerenciar tipos de estudo para categorizar ' .
                    'as fontes com base na natureza dos estudos realizados.',
            ],
            'livewire' => [
                'study_type' => [
                    'required' => 'O campo de tipo de estudo é obrigatório.',
                    'already_exists' => 'O tipo de estudo selecionado já existe neste projeto.',
                ],
                'logs' => [
                    'added' => 'Tipo de estudo adicionado',
                    'deleted' => 'Tipo de estudo excluído',
                ],
                'toasts' => [
                    'added' => 'Tipo de estudo adicionado com sucesso.',
                    'deleted' => 'Tipo de estudo deletado com sucesso.',
                    'denied' => 'Um visualizador não pode adicionar, editar ou excluir tipos de estudo.'
                ],
            ]
        ],
        'keyword' => [
            'title' => 'Palavras-chave',
            'description' => 'Descrição',
            'enter_description' => 'Digite a descrição da palavra-chave',
            'add' => 'Adicionar Palavra-chave',
            'update' => 'Atualizar Palavra-chave',
            'list' => [
                'headers' => [
                    'description' => 'Descrição',
                    'actions' => 'Ações',
                ],
                'actions' => [
                    'edit' => [
                        'button' => 'Editar',
                        'modal' => [
                            'title' => 'Editar Palavra-chave',
                            'description' => 'Descrição',
                            'cancel' => 'Cancelar',
                            'save' => 'Salvar',
                        ],
                    ],
                    'delete' => [
                        'button' => 'Excluir',
                        'modal' => [
                            'title' => 'Excluir Palavra-chave',
                            'description' => 'Tem certeza de que deseja excluir esta palavra-chave?',
                            'cancel' => 'Cancelar',
                            'delete' => 'Excluir',
                        ],
                    ],
                ],
                'empty' => 'Nenhuma palavra-chave foi adicionada ainda.',
            ],
            'help' => [
                'title' => 'Palavras-chave',
                'content' => '
<p><strong>Palavras-chave</strong> são termos ou expressões que representam os principais conceitos envolvidos no seu estudo. Elas ajudam a orientar a busca nas bases de dados, garantindo que os resultados retornados sejam relevantes para os objetivos da sua Revisão Sistemática da Literatura (RSL).</p>

<p>As palavras-chave também podem ser usadas para organizar, classificar e filtrar estudos, facilitando a identificação de informações alinhadas com o tema pesquisado.</p>

<p>A seguir, alguns exemplos de palavras-chave conforme diferentes áreas de pesquisa:</p>

<ul>
    <li><strong>Engenharia de Software:</strong> "software testing", "agile development", "software metrics", "DevOps", "requirements engineering".</li>
    <li><strong>Ciência da Computação:</strong> "machine learning", "neural networks", "data mining", "cybersecurity", "cloud computing".</li>
    <li><strong>Saúde:</strong> "public health", "diabetes treatment", "mental health", "nutrition", "epidemiology".</li>
    <li><strong>Educação:</strong> "e-learning", "pedagogical strategies", "assessment methods", "inclusive education", "remote learning".</li>
    <li><strong>Administração:</strong> "project management", "leadership", "organizational behavior", "strategic planning", "marketing analysis".</li>
</ul>

<p>Use termos amplos e específicos para aumentar a precisão da sua busca. Se possível, consulte estudos anteriores para identificar palavras-chave frequentemente utilizadas na área.</p>
',
            ],
            'livewire' => [
                'logs' => [
                    'added' => 'Palavra-chave adicionada',
                    'updated' => 'Palavra-chave atualizada',
                    'deleted' => 'Palavra-chave excluída',
                ],
                'description' => [
                    'required' => 'O campo de descrição é obrigatório.',
                ],
                'toasts' => [
                    'added' => 'Palavra-chave adicionada com sucesso.',
                    'updated' => 'Palavra-chave atualizada com sucesso.',
                    'deleted' => 'Palavra-chave deletada com sucesso.',
                    'duplicate' => 'Palavra-chave duplicada não é permitida.',
                    'denied' => 'Um visualizador não pode adicionar, editar ou excluir palavras-chave.',
                ],
            ]
        ],
        'dates' => [
            'title' => 'Datas do Projeto',
            'start_date' => 'Data de Início',
            'end_date' => 'Data de Término',
            'add_date' => 'Salvar Data',
            'help' => [
                'title' => 'Datas do Projeto',
                'content' => 'Defina as datas de início e término do seu projeto para definir o período durante o qual você ' .
                    'realizará sua revisão de literatura. Isso ajudará a acompanhar seu progresso e a ' .
                    'agendar seu trabalho de maneira eficaz.',
            ],
            'livewire' => [
                'logs' => [
                    'added' => 'Datas do projeto adicionadas',
                    'updated' => 'Datas do projeto atualizadas',
                ],
                'date' => [
                    'invalid' => 'A data inválida. Por favor, insira uma data válida.',
                ],
                'start_date' => [
                    'required' => 'O campo de data de início é obrigatório.',
                ],
                'end_date' => [
                    'required' => 'O campo de data de término é obrigatório.',
                    'after' => 'A data de término deve ser posterior à data de início.',
                ],
                'toasts' => [
                    'added' => 'Datas do projeto adicionadas com sucesso.',
                    'updated' => 'Datas do projeto atualizadas com sucesso.',
                    'denied' => 'Um visualizador não pode adicionar, editar ou excluir datas do projeto.'
                ],
            ]
        ],
    ],
    'research-questions' => [
        'title' => 'Questões de Pesquisa',
        'help' => [
            'title' => 'Ajuda para Questões de Pesquisa',
            'content' => '
<p><strong>O que são Questões de Pesquisa?</strong></p>
<p>
Questões de Pesquisa (Research Questions – RQs) são perguntas centrais que orientam toda a Revisão Sistemática da Literatura (RSL).
Elas determinam <em>o que exatamente você deseja investigar</em>, influenciando todas as etapas seguintes: seleção de estudos, critérios, extração de dados, avaliação e síntese.
</p>

<p><strong>Como preencher os campos:</strong></p>

<ul>
<li>
    <strong>ID:</strong>
    Identificador curto e único para cada questão.
    O padrão recomendado é usar um código simples, como <strong>RQ01</strong>, <strong>RQ02</strong>, etc.
    Ele facilita a referência durante a qualidade, extração de dados e relatórios.
</li>

<li>
    <strong>Descrição:</strong>
    Escreva uma pergunta clara, objetiva e focada.
    A descrição deve refletir exatamente o que você deseja responder com sua revisão.
</li>
</ul>

<p><strong>Dicas importantes:</strong></p>
<ul>
<li>Use apenas uma pergunta por linha;</li>
<li>Cadastre uma pergunta por vez;</li>
<li>Certifique-se de que cada questão seja totalmente respondível com evidências dos estudos;</li>
<li>Revise suas questões com o orientador e a equipe para garantir alinhamento conceitual.</li>
</ul>

<p><strong>Exemplos práticos:</strong></p>

<ul>
<li><strong>ID:</strong> RQ01 — <strong>Descrição:</strong> Quais métodos de engenharia de requisitos são utilizados em projetos de grande escala?</li>

<li><strong>ID:</strong> RQ02 — <strong>Descrição:</strong> Quais são as principais limitações relatadas nos estudos sobre testes automatizados?</li>

<li><strong>ID:</strong> RQ03 — <strong>Descrição:</strong> Como a inteligência artificial tem sido aplicada para apoio ao desenvolvimento de software?</li>

<li><strong>ID:</strong> RQ04 — <strong>Descrição:</strong> Quais métricas são usadas para avaliar a qualidade de código em estudos recentes?</li>
</ul>

<p>
Essas questões servirão como guia principal da sua revisão.
Todos os dados coletados durante o processo devem contribuir para respondê-las de forma consistente e fundamentada.
</p>
'
        ],
        'form' => [
            'id' => 'ID',
            'description' => 'Descrição',
            'enter_description' => 'Digite a descrição da questão de pesquisa',
            'add' => 'Adicionar',
            'update' => 'Atualizar'
        ],
        'table' => [
            'id' => 'ID',
            'description' => 'Descrição',
            'actions' => 'Ações',
            'edit' => 'Editar',
            'delete' => 'Excluir',
            'no-questions' => 'Nenhuma questão de pesquisa encontrada.',
            'empty' => 'Este projeto ainda não possui questões de pesquisa'
        ],
        'edit-modal' => [
            'title' => 'Atualização de Questão de Pesquisa',
            'id' => 'ID',
            'description' => 'Descrição',
            'update' => 'Atualizar',
        ],
        'livewire' => [
            'logs' => [
                'added' => 'Questão de Pesquisa adicionada',
                'updated' => 'Questão de Pesquisa atualizada',
                'deleted' => 'Questão de Pesquisa excluída',
            ],
            'description' => [
                'required' => 'O campo de descrição é obrigatório.',
            ],
            'toasts' => [
                'added' => 'Questão de Pesquisa adicionada com sucesso.',
                'updated' => 'Questão de Pesquisa atualizada com sucesso.',
                'deleted' => 'Questão de Pesquisa deletada com sucesso.',
                'denied' => 'Um visualizador não pode adicionar, editar ou excluir questões de pesquisa.'
            ],
        ]
    ],
    'databases' => [
        'title' => 'Base de Dados',
        'help' => [
            'title' => 'Bases de Dados',
            'content' => '
<p><strong>O que são Bases de Dados?</strong></p>
<p>
Bases de dados são plataformas que reúnem artigos acadêmicos, livros científicos, relatórios técnicos e outros materiais de pesquisa.
Elas funcionam como grandes catálogos onde você pode buscar estudos confiáveis usando termos, palavras-chave ou strings de busca.
</p>

<p>
Durante uma Revisão Sistemática da Literatura (RSL), as bases de dados são essenciais, pois garantem que você encontre a maior quantidade possível de estudos relevantes de forma organizada e rastreável.
Cada base possui diferentes coberturas temáticas e tipos de publicações.
</p>

<p><strong>Como escolher as bases ideais?</strong></p>
<ul>
<li>Considere sua área de estudo (ex.: Engenharia de Software, Saúde, Educação, Administração, etc.).</li>
<li>Verifique quais bases são mais reconhecidas na sua área.</li>
<li>Use mais de uma base para evitar perda de estudos importantes.</li>
<li>Escolha bases com boa indexação e histórico de publicações de qualidade.</li>
</ul>

<p><strong>Exemplos de bases de dados:</strong></p>
<ul>
<li><strong>Scopus:</strong> ampla cobertura multidisciplinar, muito usada em pesquisas científicas.</li>
<li><strong>Web of Science:</strong> base altamente reconhecida com estudos de alta qualidade.</li>
<li><strong>IEEE Xplore:</strong> ideal para Computação, Engenharia, Tecnologia e Eletrônica.</li>
<li><strong>ACM Digital Library:</strong> referência em Ciência da Computação.</li>
<li><strong>PubMed:</strong> excelente para pesquisas na área da saúde.</li>
<li><strong>ScienceDirect:</strong> artigos técnicos e científicos de várias áreas.</li>
</ul>

<p><strong>Como usar esta etapa no Thoth 2.0:</strong></p>
<ul>
<li>Selecione as bases de dados que deseja incluir em sua revisão.</li>
<li>Adicione novas bases se sua área exigir outras fontes que não estão na lista.</li>
<li>Remova bases que não são relevantes para o seu tema.</li>
</ul>

<p>
A escolha correta das bases garante uma revisão mais completa, confiável e metodologicamente sólida.
</p>
',
        ],

        'form' => [
            'select-placeholder' => 'Selecione uma Base de Dados',
            'add-button' => 'Adicionar Base de Dados',
        ],
        'table' => [
            'name' => 'Nome',
            'actions' => 'Ações',
            'header' => 'Bases de Dados',
            'remove-button' => 'Remover',
            'no-databases' => 'Nenhuma base de dados encontrado.',
            'empty' => 'Este projeto ainda não possui bases de dados registradas'
        ],
        'suggest-new' => [
            'title' => 'Sugira uma nova Base de Dados',
            'help' => [
                'title' => 'Sugira uma nova Base de Dados',
                'content' => '
<p>Se você deseja utilizar uma base de dados que **ainda não está disponível na lista da Thoth**, você pode sugeri-la para inclusão.
Essa funcionalidade é útil quando sua área de pesquisa utiliza repositórios específicos que não fazem parte da configuração padrão.</p>

<p><strong>Importante:</strong> A base sugerida não ficará imediatamente disponível no sistema.
Ela passará por uma análise dos administradores responsáveis, que avaliam a relevância, acessibilidade e confiabilidade da fonte.</p>

<hr>

<p><strong>Como preencher os campos:</strong></p>

<ul>
<li>
    <strong>Nome da Base de Dados:</strong><br>
    Insira o nome oficial da base de dados que você deseja sugerir.<br>
    Exemplos:
    <ul>
        <li><em>ACM Digital Library</em></li>
        <li><em>PubMed</em></li>
        <li><em>Google Scholar</em></li>
        <li><em>ScienceDirect</em></li>
    </ul>
</li>

<li>
    <strong>Link da Base de Dados:</strong><br>
    Informe a URL principal (página inicial) da base de dados.<br>
    Exemplos:
    <ul>
        <li>https://dl.acm.org/</li>
        <li>https://pubmed.ncbi.nlm.nih.gov/</li>
        <li>https://scholar.google.com/</li>
        <li>https://www.sciencedirect.com/</li>
    </ul>
    O link deve levar diretamente ao repositório, e não a páginas internas ou resultados de busca.
</li>
</ul>

<hr>

<p>Após enviar sua sugestão, aguarde a avaliação da equipe responsável.
Assim que for aprovada, a base de dados será adicionada à lista disponível no ambiente de planejamento.</p>
',
            ],

            'content' => 'Sugira uma nova Base de Dados',
            'name-label' => 'Nome da Base de Dados',
            'enter-name' => 'Digite o nome da Base de Dados',
            'link-label' => 'Link da Base de Dados',
            'enter-link' => 'Digite o link da Base de Dados',
            'submit-button' => 'Enviar sugestão',
        ],
        'errors' => [
            'name' => 'Mensagem de erro para o campo de nome, se necessário.',
        ],
        'livewire' => [
            'logs' => [
                'added' => 'Base de Dados adicionada',
                'suggestion' => 'Base de Dados sugerida.',
                'deleted' => 'Base de Dados excluída',
            ],
            'database' => [
                'required' => 'O campo de base de dados é obrigatório.',
                'required_link' => 'O campo de link é obrigatório.',
                'already_exists' => 'A base de dados selecionada já existe neste projeto.',
                'invalid_link' => 'O link da base de dados é inválido.',
            ],
            'toasts' => [
                'added' => 'Base de Dados adicionada com sucesso.',
                'deleted' => 'Base de Dados deletada com sucesso.',
                'suggested' => 'Sua sugestão foi enviada com sucesso.',
                'denied' => 'Um visualizador não pode adicionar, editar ou excluir bases de dados.',
            ],
        ],
        'database-manager' => [
            'title' => 'Gerenciador de Bases de Dados',
            'description' => 'Aqui você pode gerenciar as sugestões de bases de dados enviadas pelos usuários. Você pode aceitar ou rejeitar sugestões.',
            'table' => [
                'title' => 'Sugestões de Base de Dados',
                'headers' => [
                    'name' => 'Nome',
                    'link' => 'Link',
                    'actions' => 'Ações',
                ],
                'states' => [
                    'approved' => 'Aprovada',
                    'rejected' => 'Recusada',
                    'pending' => 'Pendente',
                    'proposed' => 'Proposta',
                ],
                'actions' => [
                    'accept' => 'Aceitar',
                    'reject' => 'Rejeitar',
                ],
                'empty' => 'Nenhuma sugestão de base de dados encontrada.',
            ],
            'modal' => [
                'approve' => [
                    'title' => 'Aceitar Sugestão',
                    'description' => 'Tem certeza de que deseja aprovar esta sugestão? A sugestão será adicionada a lista de bases de dados',
                    'cancel' => 'Cancelar',
                    'approve' => 'Aprovar',
                ],
                'reject' => [
                    'title' => 'Rejeitar Sugestão de Base de Dados',
                    'description' => 'Tem certeza de que deseja rejeitar esta sugestão?',
                    'cancel' => 'Cancelar',
                    'reject' => 'Rejeitar',
                ],
                'delete' => [
                    'title' => 'Excluir Sugestão de Base de Dados',
                    'description' => 'Tem certeza de que deseja excluir esta sugestão? Esta ação não pode ser desfeita.',
                    'cancel' => 'Cancelar',
                    'delete' => 'Excluir',
                ],
            ],
        ],
    ],
    'search-string' => [
        'generate-all' => 'Gerar todas as strings de busca',
        'title' => 'String de Busca',
        'help' => 'String de busca é uma sequência de termos de pesquisa que você usa para pesquisar fontes de literatura relevantes para sua revisão. Adicione strings de busca para cada base de dados do projeto para refinar sua estratégia de busca e encontrar informações relevantes para sua pesquisa.
        <br>
        <hr>

<p><strong>Como a Thoth monta a String de Busca automaticamente?</strong></p>

<ul>
<li>
    Cada <strong>termo principal</strong> é combinado usando o operador <strong>AND</strong>.
    Ex.:
    <code>(tools) AND (web-based) AND (systematic review)</code>
</li>

<li>
    Cada <strong>sinônimo</strong> dentro de um mesmo termo é combinado usando <strong>OR</strong>.
    Ex.:
    <code>(tools OR "software tools" OR "support tools")</code>
</li>

<li>
    A Thoth gera automaticamente uma string completa no formato ideal para buscas acadêmicas.
</li>
</ul>

<hr>
<p><strong>Exemplo de String Gerada Automática:</strong></p>

<pre>
("systematic review" OR "literature review")
AND
(tools OR "software tools" OR "support tools")
AND
(web-based OR online OR "browser-based")
</pre>

<p>
Essa string será utilizada posteriormente para gerar as consultas em cada base de dados configurada no seu projeto.
</p>

<p><strong>Dicas finais:</strong></p>
<ul>
<li>Cadastre primeiro todos os termos centrais;</li>
<li>Inclua sinônimos amplamente utilizados na literatura;</li>
<li>Use termos no idioma das bases de dados que você pretende consultar (geralmente inglês);</li>
<li>Não é necessário preocupar-se com operadores — a Thoth monta tudo automaticamente.</li>
</ul>
        ',
        'form' => [
            'description' => 'String de Busca Genérica',
            'enter-description' => 'Digite a string de busca genérica',
            'no-database'=> 'Sem base de dados encontrados neste projeto.',
            'add' => 'Adicionar String de Busca',
            'update' => 'Atualizar String de Busca',
            'placeholder' => 'Digite a string de busca',
        ],
        'livewire' => [
            'toasts' => [
                'generated' => 'Strings de Busca geradas com sucesso.',
                'updated-string' => 'String de Busca atualizada com sucesso.',
            ],
        ],
        'term' => [
            'title' => 'Termos',
            'help' => '<p><strong>O que é uma String de Busca?</strong></p>

<p>
A String de Busca é uma fórmula composta por termos, operadores lógicos e sinônimos que você utiliza para
pesquisar estudos nas bases de dados. Ela garante que sua busca seja <em>precisa, completa e reproduzível</em>,
encontrando o maior número possível de estudos relevantes para sua Revisão Sistemática da Literatura (RSL).
</p>

<p>
Ao estruturar corretamente sua string, você reduz viés, evita perder artigos importantes e facilita a
comparação dos resultados entre diferentes bases (IEEE, Scopus, ACM, etc.).
</p>

<hr>

<p><strong>Como preencher os campos exibidos na tela:</strong></p>

<ul>
<li>
    <strong>Termos de Busca:</strong>
    São os conceitos principais da sua pesquisa.
    Exemplo: <em>“tools”</em>, <em>“web-based”</em>, <em>“systematic review”</em>.
</li>

<li>
    <strong>Adicionar Termo:</strong>
    Após digitar o termo principal, clique no botão <strong>“Adicionar Termo”</strong> para registrá-lo na lista.
</li>

<li>
    <strong>Selecione um Termo:</strong>
    Depois de cadastrado, selecione o termo ao qual deseja adicionar sinônimos.
</li>

<li>
    <strong>Sinônimos:</strong>
    Os sinônimos representam variações da mesma ideia.
    Para cada termo principal, você pode cadastrar vários sinônimos.
    Ex.:
    <ul>
        <li>Termo: <em>tools</em> → Sinônimos: <em>software tools</em>, <em>support tools</em></li>
        <li>Termo: <em>web-based</em> → Sinônimos: <em>online</em>, <em>browser-based</em></li>
    </ul>
</li>

<li>
    <strong>Idioma das Sugestões:</strong>
    A Thoth exibe automaticamente sugestões de sinônimos baseadas no idioma escolhido.
    Caso não encontre o sinônimo desejado, você pode adicionar manualmente.
</li>

<li>
    <strong>Botão “+” (Adicionar Sinônimo):</strong>
    Clique para vincular o sinônimo ao termo selecionado.
</li>
</ul>
',
            'form' => [
                'title' => 'Termos de Busca',
                'placeholder' => 'Digite o termo de busca',
                'synonyms' => 'Sinônimos',
                'update' => 'Atualizar Termo de Busca',
                'add' => 'Adicionar Termo',
                'select' => 'Termos de Busca',
                'select-placeholder' => 'Selecione um termo',
                'no-suggestions' => 'Nenhuma sugestão encontrada.',
                'language' => 'Idioma das Sugestões',
            ],
            'table' => [
                'description' => 'Termo de Busca',
                'actions' => 'Ações',
                'empty' => 'Nenhum termo de busca cadastrado',
                'not-found' => 'Nenhum termo de busca encontrado.',
            ],
            'livewire' => [
                'description' => [
                    'required' => 'O campo do termo de busca é obrigatório.',
                ],
                'toasts' => [
                    'added' => 'Termo de Busca adicionado com sucesso.',
                    'updated' => 'Termo de Busca atualizado com sucesso.',
                    'deleted' => 'Termo de Busca deletado com sucesso.',
                    'validation' => 'O termo de busca é inválido. Por favor, insira um termo de busca válido.',
                    'denied' => 'Um visualizador não pode adicionar, editar ou excluir termos de busca.',
                    'synonym' => 'O sinônimo é inválido. Por favor, insira um sinônimo válido.',

                ],
            ]
        ],
        'synonym' => [
            'form' => [
                'title' => 'Sinônimos',
                'placeholder' => 'Digite o sinônimo',
            ]
        ]
    ],
    'search-strategy' => [
        'title' => 'Estratégia de Busca',
        'help' => [
            'title' => 'Ajuda para Estratégia de Busca',
            'content' => "
                        <p>Na fase de planejamento, é necessário determinar e seguir uma estratégia de busca. Esta deve ser desenvolvida em consulta com bibliotecários ou outras pessoas com experiência relevante. As estratégias de busca são geralmente iterativas e se beneficiam de:</p>
                        <ul>
                            <li>Realizar buscas preliminares com o objetivo de identificar revisões sistemáticas existentes e avaliar o volume de estudos potencialmente relevantes.</li>
                            <li>Executar buscas experimentais usando várias combinações de termos de busca derivados da questão de pesquisa.</li>
                            <li>Verificar a cadeia de pesquisa experimental em comparação com listas de estudos primários já conhecidos.</li>
                            <li>Buscar consultas com especialistas na área.</li>
                        </ul>
                        <p>Descreva aqui uma estratégia utilizada para a pesquisa.</p>
                    ",
        ],
        'placeholder' => 'Digite a estratégia de busca',
        'save-button' => 'Salvar',
        'success' => 'Estratégia de busca atualizada com sucesso.',
        'denied' => 'Um visualizador não pode adicionar, editar ou excluir a estratégia de busca.',
    ],
    'criteria' => [
        'title' => 'Critérios de Inclusão/Exclusão',
        'help' => [
            'title' => 'Critérios de Inclusão/Exclusão',
            'content' => '
           <p><strong>O que são Critérios de Inclusão e Exclusão?</strong></p>

<p>
Critérios de Inclusão e Exclusão são regras fundamentais que determinam
<strong>quais estudos serão considerados</strong> na sua Revisão Sistemática da Literatura (RSL)
e quais devem ser descartados.
Eles garantem que a seleção seja <strong>clara, consistente e reproduzível</strong>, evitando vieses
e mantendo a revisão alinhada aos seus objetivos.
</p>

<p><strong>Como preencher os campos:</strong></p>

<ul>
    <li>
        <strong>ID:</strong>
        Use um identificador curto e único para cada critério.
        Para Inclusão utilize o padrão <strong>IC1, IC2, IC3...</strong>
        Para Exclusão utilize <strong>EC1, EC2, EC3...</strong>
        Esses identificadores facilitam a rastreabilidade e a análise posterior.
    </li>

    <li>
        <strong>Descrição:</strong>
        Escreva de forma clara, objetiva e verificável.
        A descrição deve permitir que qualquer pesquisador consiga avaliar um estudo
        da mesma forma, reduzindo ambiguidades.
        <br><em>Exemplos corretos:</em>
        <br>• “O estudo deve apresentar avaliação empírica de uma ferramenta X.”
        <br>• “Artigos duplicados devem ser excluídos.”
    </li>

    <li>
        <strong>Tipo:</strong>
        Escolha se o critério é de <strong>Inclusão</strong> ou <strong>Exclusão</strong>.
        Isso organiza automaticamente a tabela e o processo de seleção.
    </li>
</ul>

<hr>

<p><strong>Critérios de Inclusão (IC):</strong></p>
<p>
São as condições que um estudo <strong>deve obrigatoriamente cumprir</strong> para ser considerado relevante.
Eles delimitam o escopo da revisão e asseguram que apenas os estudos úteis avancem.
</p>

<p><strong>Exemplo:</strong><br>
IC1 — A publicação deve propor uma ferramenta para apoiar o teste de desempenho.
</p>

<hr>

<p><strong>Critérios de Exclusão (EC):</strong></p>
<p>
São condições que indicam que um estudo <strong>não deve ser incluído</strong>, mesmo que atenda critérios de inclusão.
Normalmente são usados para retirar ruídos, duplicações ou estudos fora do escopo.
</p>

<p><strong>Exemplo:</strong><br>
EC1 — Artigos duplicados.
EC2 — O estudo não está disponível em texto completo.
</p>

<hr>

<p><strong>Regra de Inclusão / Exclusão (Importante):</strong></p>

<p>Essa regra define como os critérios devem ser aplicados:</p>

<ul>
    <li>
        <strong>Todos:</strong>
        O estudo deve atender <strong>todos os critérios</strong> selecionados.
        Mais restritivo e garante alta precisão.
    </li>

    <li>
        <strong>Pelo menos:</strong>
        O estudo deve atender <strong>um mínimo</strong> de critérios selecionados.
        Útil para áreas amplas ou critérios complementares.
    </li>

    <li>
        <strong>Qualquer:</strong>
        Se o estudo atender a <strong>qualquer um</strong> dos critérios, ele será marcado.
        Menos restritivo, amplia a sensibilidade da busca.
    </li>
</ul>

<hr>

<p><strong>Dicas práticas para preencher corretamente:</strong></p>

<ul>
    <li>Evite descrições vagas como “estudo relevante”.</li>
    <li>Prefira critérios verificáveis e objetivos.</li>
    <li>Inclua critérios para evitar ruído (ex.: exclusão de artigos de 1 página ou posters).</li>
    <li>Revise os critérios com o orientador para garantir alinhamento.</li>
    <li>Use IDs consistentes para facilitar a extração de dados.</li>
</ul>

<p>
Ao final, seus critérios formarão a base do processo de seleção da revisão, garantindo um procedimento
<strong>transparente, auditável e replicável</strong>.
</p>

            ',
        ],
        'form' => [
            'id' => 'ID',
            'dont-use' => 'Não utilize caracteres especiais',
            'description' => 'Descrição',
            'enter_description' => 'Digite a descrição do critério',
            'type' => 'Tipo',
            'inclusion' => 'Inclusão',
            'exclusion' => 'Exclusão',
            'add' => 'Adicionar Critério',
            'update' => 'Atualizar Critério',
            'select-placeholder' => 'Selecione o Tipo de Critério',
            'select-inclusion' => 'Inclusão',
            'select-exclusion' => 'Exclusão',
        ],
        'inclusion-table' => [
            'title' => 'Critérios de Inclusão',
            'select' => '',
            'id' => 'ID',
            'description' => 'Descrição',
            'rule' => 'Regra de Inclusão',
        ],
        'exclusion-table' => [
            'title' => 'Critérios de Exclusão',
            'select' => '',
            'id' => 'ID',
            'description' => 'Descrição',
            'rule' => 'Regra de Exclusão',
        ],
        'table' => [
            'all' => 'Todos',
            'any' => 'Qualquer',
            'at-least' => 'Pelo menos',
            'empty' => 'Sem critérios cadastrados',
            'actions' => 'Ações',
        ],
        'livewire' => [
            'description' => [
                'required' => 'O campo de descrição é obrigatório.',
            ],
            'criteriaId' => [
                'required' => 'O campo de ID é obrigatório.',
                'regex' => 'O campo de ID deve conter apenas letras e números.',
            ],
            'type' => [
                'required' => 'Selecionar um tipo é obrigatório.',
                'in' => 'Selecione um tipo válido.',
            ],
            'logs' => [
                'added' => 'Critério adicionado',
                'updated' => 'Critério atualizado.',
                'deleted' => 'Critério excluído',
            ],
            'toasts' => [
                'no_criteria'=> 'Nenhum critério encontrado.',
                'added' => 'Critério adicionado com sucesso.',
                'deleted' => 'Critério deletado com sucesso.',
                'updated' => 'Critério atualizado com sucesso.',
                'updated-inclusion' => 'Regra do critério de inclusão atualizada',
                'updated-exclusion' => 'Regra do critério de exclusão atualizada',
                'unique-id' => 'Este ID de critério já está em uso. Por favor, insira um ID de critério único.',
                'denied' => 'Um visualizador não pode adicionar, editar ou excluir critérios de inclusão/exclusão.',
            ],
        ],
        'duplicate_id' => 'O ID fornecido já existe neste projeto.',
        'updated_success' => 'Critério atualizado com sucesso.',
        'not_found' => 'Critério não encontrado.',
        'deleted_success' => 'Critério excluído com sucesso.',
        'preselected_updated' => 'Valor pré-selecionado atualizado com sucesso.',
    ],
    'quality-assessment' => [
        'title' => 'Avaliação de Qualidade',
        'generate-intervals' => 'Gerar intervalos',
        'ranges' => [
            'label-updated' => 'Label atualizada com sucesso.',
            'interval-updated' => 'Intervalo atualizado com sucesso.',
            'deletion-restricted' => 'Não é possível excluir o intervalo ":description". Existem registros/papers associados.',
            'generated' => 'Intervalos gerados com sucesso.',
            'reduction-not-allowed' => 'Não é possível reduzir o número de intervalos pois já existem avaliações em condução para este projeto.',
            'new-label' => 'Intervalo :n',
            'generated-successfully' => 'Intervalos de pontuação atualizados com sucesso.',
        ],
        'qa-table'=>[
            'min-general-score' => 'Pontuação Mínima para Aprovação	',
            ],
        'general-score' => [
            'title' => 'Intervalos de Pontuação Geral',
            'help' => [
                'title' => 'Intervalos de Pontuação Geral',
                'content' => '<p>Os <strong>intervalos de pontuação geral</strong> são usados para classificar a qualidade final de um estudo após a avaliação das questões de qualidade. Eles definem faixas de pontuação (por exemplo: “Muito Pouco”, “Pouco”, “Bom”, “Muito Bom”) e ajudam a identificar rapidamente o nível em que cada estudo se encontra.</p>

<p>A geração dos intervalos é <strong>automática</strong>. O usuário apenas informa <strong>quantos intervalos deseja ter</strong> em sua revisão, e a Thoth cria esses intervalos com base na <strong>soma total dos pesos das questões de qualidade</strong>. Essa soma representa o <strong>máximo possível de pontuação</strong> que um estudo pode alcançar.</p>

<p><strong>Como preencher os campos:</strong></p>

<ul>
    <li>No campo <strong>"Gerar intervalos"</strong>, digite a quantidade de intervalos que deseja (ex.: 4, 5, 6).</li>
    <li>Clique em <strong>"Gerar intervalos"</strong>. O sistema criará automaticamente os intervalos com valores mínimos, máximos e labels padrão.</li>
    <li>Os campos <strong>Mín</strong> e <strong>Label</strong> podem ser editados pelo usuário.</li>
    <li>Os campos <strong>Máx</strong> dos intervalos intermediários e <strong>todos os campos travados</strong> são definidos automaticamente pela Thoth e <strong>não podem ser alterados</strong>.</li>
    <li>O valor <strong>Máx do último intervalo</strong> é sempre igual à <strong>soma total dos pesos</strong> das questões cadastradas — esse valor é obrigatório e não pode ser maior nem menor.</li>
</ul>

<p><strong>Regras importantes:</strong></p>
<ul>
    <li>Se você alterar questões de qualidade (incluindo pesos), verifique novamente os intervalos: a soma dos pesos pode ter mudado.</li>
    <li>Se desejar <strong>reduzir o número de intervalos</strong>, isso só será permitido caso <strong>nenhum estudo tenha sido avaliado</strong> ainda.</li>
    <li>Se desejar <strong>apenas recalcular</strong> os intervalos com base na nova soma dos pesos, basta gerar novamente o mesmo número de intervalos já existentes.</li>
    <li>Se quiser <strong>acrescentar novos intervalos</strong>, informe um número maior (por exemplo, de 4 para 5). O sistema criará apenas os intervalos adicionais.</li>
</ul>

<p><strong>Exemplo:</strong></p>

<table class="table table-bordered table-striped small">
    <thead>
        <tr>
            <th>Mínimo</th>
            <th>Máximo</th>
            <th>Descrição</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>0,01</td>
            <td>1,25</td>
            <td>Muito Pouco</td>
        </tr>
        <tr>
            <td>1,26</td>
            <td>2,5</td>
            <td>Pouco</td>
        </tr>
        <tr>
            <td>2,51</td>
            <td>3,75</td>
            <td>Bom</td>
        </tr>
        <tr>
            <td>3,76</td>
            <td>5</td>
            <td>Muito Bom</td>
        </tr>
    </tbody>
</table>
 ',
            ],
            'start' => 'Digite a Pontuação Mínima',
            'end' => 'Digite a Pontuação Máxima',
            'description' => 'Descrição',
            'placeholder-start' => 'Pontuação Mínima (0.0)',
            'placeholder-end' => 'Pontuação Máxima (0.0)',
            'add' => 'Adicionar Pontuação Geral',
            'update' => 'Atualizar Pontuação Geral',
            'table' => [
                'min' => 'Pontuação Mínima',
                'max' => 'Pontuação Máxima',
                'description' => 'Descrição',
                'action' => 'Ações',
                'no-results' => 'Nenhuma pontuação geral encontrada.',
                'empty' => 'Nenhuma pontuação geral registrada neste projeto.',
            ],
            'livewire' => [
                'logs' => [
                    'added' => 'Pontuação Geral adicionada',
                    'updated' => 'Pontuação Geral atualizada',
                ],
                'start' => [
                    'invalid' => 'O campo de pontuação geral é inválido. Por favor, insira uma pontuação geral válida.',
                    'required' => 'O campo de pontuação geral é inválido. Por favor, insira uma pontuação geral válida.',
                ],
                'end' => [
                    'required' => 'O campo de pontuação geral é obrigatório.',
                    'after' => 'A pontuação máxima deve ser maior que a pontuação mínima.',
                ],
                'description' => [
                    'required' => 'O campo de descrição da pontuação geral é obrigatório.',
                ],
                'toasts' => [
                    'added' => 'Pontuação Geral adicionada com sucesso.',
                    'updated' => 'Pontuação Geral atualizada com sucesso.',
                    'deleted' => 'Pontuação Geral deletada com sucesso.',
                    'denied' => 'Um visualizador não pode adicionar, editar ou excluir pontuações gerais.',
                ],
            ],

        ],
        'question-quality' => [
            'title' => 'Questão de Qualidade',
            'help' => [
                'title' => 'Questão de Qualidade',
                'content' => '
<p>As <strong>Questões de Qualidade</strong> fazem parte da etapa em que você avalia o quão confiáveis e completos são os estudos que farão parte da sua Revisão Sistemática da Literatura (RSL). Elas ajudam a identificar se cada publicação realmente apresenta informações sólidas para responder às suas Questões de Pesquisa.</p>

<p>Mesmo que um estudo atenda aos critérios de inclusão, ele ainda pode ter limitações — e a avaliação de qualidade permite medir o quanto essas limitações afetam sua utilidade na revisão.</p>

<p><strong>Por que a avaliação de qualidade é importante?</strong></p>

<ul>
    <li>Ajuda a identificar estudos mais robustos e confiáveis.</li>
    <li>Reduz o risco de conclusões baseadas em pesquisas fracas ou incompletas.</li>
    <li>Permite dar mais peso aos estudos bem conduzidos.</li>
    <li>Aumenta a transparência e a credibilidade do processo da revisão.</li>
    <li>Facilita análises posteriores e recomendações mais consistentes.</li>
</ul>

<hr>

<p><strong>Como preencher os campos:</strong></p>

<ul>
    <li><strong>ID:</strong> É o identificador único da questão de qualidade.
        O formato mais comum é usar códigos como <strong>QA01</strong>, <strong>QA02</strong>, etc., facilitando a organização durante a avaliação dos estudos.</li>

    <li><strong>Peso:</strong> Indica o quanto essa pergunta influencia na pontuação final do estudo.
        <ul>
            <li><strong>Pesos maiores</strong> = maior importância na avaliação.</li>
            <li><strong>Pesos menores</strong> = influência reduzida.</li>
        </ul>
        Use pesos de forma coerente: perguntas mais críticas devem ter peso maior.</li>

    <li><strong>Descrição:</strong> Escreva a pergunta de qualidade que será feita ao analisar cada estudo.
        Deve ser clara, objetiva e focada em avaliar a confiabilidade ou completude da publicação.</li>
</ul>

<hr>

<p><strong>Dicas importantes:</strong></p>
<ul>
    <li>Evite perguntas vagas — seja direto e específico.</li>
    <li>Cadastre <strong>uma pergunta por vez</strong>.</li>
    <li>Use pesos consistentes com o que realmente importa na sua revisão.</li>
    <li>Reveja as questões com o orientador ou equipe para garantir alinhamento.</li>
</ul>

<hr>

<p><strong>Exemplo:</strong></p>
<ul>
    <li><strong>ID:</strong> QA01</li>
    <li><strong>Peso:</strong> 2</li>
    <li><strong>Descrição:</strong> O estudo apresenta de forma clara o método utilizado para condução da revisão?</li>
</ul>

<p>Essas perguntas serão utilizadas posteriormente, na etapa de Avaliação de Qualidade, onde cada estudo receberá pontuações de acordo com as respostas às questões cadastradas.</p>
',
            ],

            'id' => 'ID',
            'description' => 'Descrição',
            'weight' => 'Peso',
            'add' => 'Adicionar Questão de Qualidade',
            'update' => 'Atualizar Questão de Qualidade',
            'livewire' => [
                'logs' => [
                    'added' => 'Questão de Qualidade adicionada',
                    'updated' => 'Questão de Qualidade atualizada',
                ],
                'id' => [
                    'required' => 'O campo de questão de qualidade é inválido. Por favor, insira uma questão de qualidade válida.',
                ],
                'weight' => [
                    'required' => 'O campo de questão de qualidade é obrigatório.',
                ],
                'description' => [
                    'required' => 'O campo de descrição da questão de qualidade é obrigatório.',
                ],
                'toasts' => [
                    'duplicate_id' => 'Uma questão com este ID já existe.',
                    'added' => 'Questão de Qualidade adicionada com sucesso.',
                    'updated' => 'Questão de Qualidade atualizada com sucesso.',
                    'deleted' => 'Questão de Qualidade deletada com sucesso.',
                    'min_weight' => 'O peso mínimo deve ser maior que 0.',
                ],
            ],

        ],
        'question-score' => [
            'title' => 'Pontuação de Qualidade',
            'select' => [
                'rule' => 'Selecione uma regra'
            ],
            'question' => [
                'title' => 'Questão',
                'placeholder' => 'Selecione uma questão',
            ],
            'help' => [
                'title' => 'Pontuação de Qualidade',
                'content' => '
    <p>A etapa de <strong>Pontuação de Qualidade</strong> permite definir como cada questão de qualidade será avaliada.
    Aqui você cria as <strong>regras de pontuação</strong>, que funcionam como as possíveis respostas para cada questão.</p>

    <p>Cada regra possui:</p>
    <ul>
        <li><strong>Uma questão associada</strong> (selecionada no campo "Questão");</li>
        <li><strong>Uma regra de resposta</strong> (ex.: Sim, Não, Parcialmente);</li>
        <li><strong>Um valor percentual</strong> (0% a 100%) representando a pontuação daquela resposta;</li>
        <li><strong>Uma descrição</strong> explicando claramente quando essa regra deve ser usada.</li>
    </ul>

    <p><strong>Isso significa que você deve cadastrar uma regra por vez para cada questão.</strong><br>
    Ao final, cada questão terá seu conjunto de respostas possíveis e respectivas pontuações.</p>

    <hr>

    <h5><strong>Como preencher os campos:</strong></h5>

    <ul>
        <li>
            <strong>Questão:</strong> Selecione qual questão de qualidade receberá esta regra de pontuação
            (ex.: QA01, QA02...).<br>
            Cada regra sempre pertence a uma única questão.
        </li>

        <li>
            <strong>Regra de Pontuação:</strong> Nome curto da resposta.<br>
            Exemplos comuns:
            <ul>
                <li>Sim</li>
                <li>Parcial</li>
                <li>Não</li>
                <li>Alta Evidência</li>
                <li>Média Evidência</li>
                <li>Baixa Evidência</li>
            </ul>
        </li>

        <li>
            <strong>Pontuação:</strong> Escolha um valor entre 0% e 100% usando o slider.<br>
            Este valor será aplicado quando o avaliador escolher essa resposta.
        </li>

        <li>
            <strong>Descrição:</strong> Explique, em detalhes, quando essa regra deve ser aplicada. <br>
            Exemplo:
            <em>"O estudo apresenta de forma completa a ferramenta analisada, com metodologia clara e validação experimental."</em>
        </li>
    </ul>

    <p>A descrição é muito importante: ela garante que <strong>todos os avaliadores apliquem as regras do mesmo modo</strong>.</p>

    <hr>

    <h5><strong>Exemplo completo</strong></h5>
    <p>Suponha que a questão de qualidade <strong>QA01</strong> seja:</p>
    <p><em>"O estudo apresenta a implementação de uma ferramenta para revisão sistemática da literatura?"</em></p>

    <p>As regras de pontuação poderiam ser:</p>

    <table class="table table-bordered table-striped small table-break-text">
        <thead>
            <tr>
                <th class="w-15">Questão</th>
                <th class="w-15">Regra</th>
                <th class="w-20">Pontuação</th>
                <th class="w-50 break-words">Descrição</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>QA01</td>
                <td><strong>Sim</strong></td>
                <td>100%</td>
                <td>O estudo apresenta claramente a implementação completa da ferramenta, incluindo metodologia e validação.</td>
            </tr>
            <tr>
                <td>QA01</td>
                <td><strong>Parcial*</strong></td>
                <td>50%</td>
                <td>O estudo apresenta a ferramenta, mas não descreve todos os detalhes de implementação ou validação.</td>
            </tr>
            <tr>
                <td>QA01</td>
                <td><strong>Não</strong></td>
                <td>0%</td>
                <td>O estudo não apresenta a implementação de uma ferramenta.</td>
            </tr>
        </tbody>
    </table>

    <p>Repita este processo para <strong>cada questão</strong> de qualidade cadastrada.
    Ao final, você terá uma matriz completa de pontuação para avaliar todos os estudos.</p>
    ',
            ],
            'description' => [
                'title' => 'Descrição',
                'placeholder' => 'Insira a descrição',
            ],
            'id_qa' => [
                'title' => 'Questão de Qualidade',
                'placeholder' => 'Selecione a Questão de Qualidade',
                'no-question-available' => 'Nenhuma questão disponível',
            ],
            'score_rule' => [
                'title' => 'Regra de Pontuação',
                'placeholder' => 'Selecione ou digite a Regra de Pontuação',
                'description'=>'Digite/Explique com uma descrição a regra de pontuação',
                'yes' => 'Sim',
                'partial' => 'Parcial',
                'insufficient' => 'Insuficiente',
                'no' => 'Não',

            ],
            'extra_score_rule' => [
                'title' => 'Regra de Pontuação Extra',
                'placeholder' => 'Insira a Regra de Pontuação Extra',
            ],
            'form' => [
                'select-qa-placeholder' => 'Selecione a Questão de Qualidade',
                'add' => 'Adicionar Pontuação de Qualidade',
                'update' => 'Atualizar Pontuação de Qualidade',
            ],
            'range' => [
                'score' => 'Pontuação',
            ],
            'livewire' => [
                'logs' => [
                    'added' => 'Pontuação de Qualidade adicionada',
                    'updated' => 'Pontuação de Qualidade atualizada',
                ],
                'id' => [
                    'required' => 'Pontuação de Qualidade inválida. Por favor, insira uma pontuação de qualidade válida.',
                ],
                'weight' => [
                    'required' => 'O campo de pontuação de qualidade é obrigatório.',
                ],
                'description' => [
                    'required' => 'O campo de descrição da pontuação de qualidade é obrigatório.',
                ],
                'rule' => [
                    'required' => 'O campo de regra de pontuação é obrigatório.',
                ]
            ],
            'messages' => [
                'unique_score_rule' => 'A regra de pontuação com este valor já existe para esta questão.',
                'score_rule_only_letters' => 'A regra de pontuação só pode conter letras e espaços.',
                'description_only_letters_numbers' => 'A descrição só pode conter letras, números e espaços.',
            ],

            'toasts' => [
                'added' => 'Pontuação de Qualidade adicionada com sucesso.',
                'updated' => 'Pontuação de Qualidade atualizada com sucesso.',
                'deleted' => 'Pontuação de Qualidade deletada com sucesso.',
            ],
        ],

        'min-general-score' => [
            'title' => 'Pontuação Mínima Geral para Aprovação',
            'help-content' => '<p>Após o cadastro das questões de qualidade, a soma dos pesos de todas as questões registradas anteriormente é calculada automaticamente pela Thoth.</p>

<p>Essa soma representa o <strong>limite máximo de pontuação</strong> que um estudo pode alcançar durante a avaliação de qualidade.
Por isso, o <strong>intervalo máximo dos intervalos de pontuação geral</strong> deve sempre <strong>corresponder ao valor da soma total dos pesos</strong>
do projeto. Essa correspondência é essencial para garantir que os cálculos de pontuação e as classificações de qualidade
funcionem corretamente durante a etapa de condução da revisão.</p>

<p><strong>Pontuação Mínima Geral para Aprovação:</strong><br>
Este item define o intervalo de pontuação mínima geral que deve ser considerado como o critério mínimo para aceitar estudos na revisão.</p>

<p><strong>Como isso funciona na prática?</strong><br>
Durante a <strong>etapa de condução da avaliação de qualidade</strong>, cada estudo analisado receberá uma <strong>pontuação total</strong>, calculada com base nas regras e pesos definidos anteriormente.
A função dos <strong>intervalos de pontuação geral</strong> é classificar esse estudo dentro de um nível ou categoria — por exemplo, “Muito Baixa”, “Baixa”, “Moderada” ou “Alta”.</p>

<p>Após identificar em qual intervalo o estudo se enquadra, ele será comparado com o <strong>intervalo mínimo geral configurado</strong>.
Somente estudos cuja pontuação esteja <strong>igual ou acima do intervalo mínimo selecionado</strong> serão <strong>aceitos</strong> e poderão avançar para a próxima etapa da revisão.</p>

<hr>
<p><strong>Exemplo simples:</strong><br>
Se o intervalo mínimo configurado for <strong>Moderado (2.6 – 3.75)</strong> e o estudo avaliado obtiver pontuação equivalente ao intervalo <strong>Pouco (1.26 – 2.5)</strong>, este estudo será <strong>rejeitado</strong> automaticamente.</p>

<p><strong>Atenção — Rejeição por questão individual:</strong><br>
Além do intervalo geral, cada questão de qualidade também possui um <strong>valor mínimo individual</strong> definido pelo pesquisador.
Isso significa que mesmo que o estudo alcance uma <strong>pontuação total superior ao mínimo geral</strong>, ele ainda pode ser <strong>rejeitado</strong> caso não atenda ao mínimo exigido em <strong>qualquer uma das questões específicas</strong>.</p>

<p>Exemplo adicional:<br>
Se a questão <strong>QA02</strong> exige um mínimo de <strong>50%</strong>, mas o estudo obteve apenas <strong>0%</strong> nessa questão, ele poderá ser <strong>rejeitado</strong>, mesmo que sua pontuação total esteja dentro de um intervalo aprovado.
Isso garante que todas as questões consideradas essenciais sejam avaliadas adequadamente.</p>

<hr>

<p><strong>Observação:</strong> Para configurar corretamente esta etapa, primeiro é necessário:
<ul>
    <li>Cadastrar todas as questões de qualidade;</li>
    <li>Definir regras e pontuações para cada questão;</li>
    <li>Gerar os intervalos de pontuação geral;</li>
    <li>Salvar os intervalos no projeto da revisão.</li>
</ul>
Certifique-se também de que o <strong>valor máximo do último intervalo</strong> esteja sempre alinhado à <strong>soma dos pesos das questões</strong>.</p>
',
            'cutoff' => 'Pontuação Mínima Geral',
            'sum' => 'Soma dos Pesos',
            'form' => [
                'select-placeholder' => 'Selecione a Pontuação Geral Mínima para Aprovação',
                'add' => 'Adicionar Pontuação Geral Mínima para Aprovação',
                'update' => 'Atualizar Pontuação Geral Mínima para Aprovação',
                'empty' => 'Nenhuma pontuação geral disponível. Por favor, registre pontuações gerais.',
                'minimal-score' => 'Pontuação mínima atualizada com sucesso',
            ],

            'livewire' => [
                'logs' => [
                    'added' => 'Pontuação Geral Mínima para Aprovação adicionada',
                    'updated' => 'Pontuação Geral Mínima para Aprovação atualizada',
                ],
                'toasts' => [
                    'added' => 'Pontuação Geral Mínima para Aprovação adicionada com sucesso.',
                    'updated' => 'Pontuação Geral Mínima para Aprovação atualizada com sucesso.',
                ],
                'min-general-score' => [
                    'required' => 'O campo de pontuação geral mínima é obrigatório.',
                ],
            ],

        ],
    ],
    'data-extraction' => [
        'title' => 'Extração de Dados',
        'question-form' => [
            'title' => 'Pergunta de Extração de Dados',
            'help' => [
                'title' => 'Ajuda para Formulário de Pergunta de Extração de Dados',
                'content' => '
            <p>Os formulários de extração de dados devem ser projetados para coletar todas as informações necessárias para responder às questões da revisão e aos critérios de qualidade.
            Quando critérios de qualidade forem usados para incluir ou excluir estudos, eles devem ser coletados separadamente.
            Quando forem parte da análise, podem ser extraídos no mesmo formulário.</p>

            <p>Na maioria dos casos, a extração envolve valores numéricos (ex.: número de participantes, efeito do tratamento, intervalos de confiança).
            Esses valores são importantes para sumarizar os estudos primários e executar meta-análises.</p>

            <p>Cada pergunta de extração deve ser definida contendo: ID, descrição e tipo de dado.</p>

            <p><strong>Tipos de dados:</strong></p>
            <ul>
                <li><strong>Texto:</strong> permite ao pesquisador escrever livremente os dados extraídos.</li>
                <li><strong>Lista de Escolha Única:</strong> o pesquisador seleciona apenas uma opção.</li>
                <li><strong>Lista de Múltipla Escolha:</strong> o pesquisador pode selecionar várias opções.</li>
            </ul>

            <h5>Como preencher os campos:</h5>
            <ul>
                <li><strong>ID:</strong> identificador único da pergunta (ex.: "DE1", "DE2").</li>
                <li><strong>Descrição:</strong> explique claramente o que deve ser extraído (ex.: "Quantos participantes o estudo possui?").</li>
                <li><strong>Tipo:</strong> selecione o formato de resposta adequado (Texto, Escolha Única ou Múltipla Escolha).</li>
            </ul>

            <h5>Exemplos de perguntas:</h5>
            <ul>
                <li><strong>Texto:</strong> "Descreva a abordagem utilizada pelo estudo."</li>
                <li><strong>Escolha Única:</strong> "Qual é o tipo de estudo?" (Experimental, Observacional, Survey)</li>
                <li><strong>Múltipla Escolha:</strong> "Quais métricas de avaliação foram utilizadas?" (Precisão, Recall, F1-Score, AUC)</li>
            </ul>
        ',
            ],
            'type-selection'=> [
                'title' => 'Selecione um tipo',

            ],
            'types' => [
                'Text' => 'Texto',
                'Pick One List' => 'Lista de Escolha Única',
                'Multiple Choice List' => 'Lista de Múltipla Escolha',
            ],
            'id' => 'ID',
            'dont-use' => 'Não utilize caracteres especiais',
            'description' => 'Descrição',
            'type' => 'Tipo',
            'add-question' => 'Adicionar Pergunta',
            'edit-question' => 'Editar Pergunta'
        ],
        'option-form' => [
            'title' => 'Opção de Pergunta de Extração de Dados',
            'help' => [
                'title' => 'Ajuda para Formulário de Opção de Extração de Dados',
                'content' => '
        <p>Use este formulário para cadastrar <strong>opções de resposta</strong> para perguntas de extração de dados que utilizam listas.
        As opções permitem padronizar as respostas e facilitam a análise dos dados coletados durante a revisão.</p>

        <h5><strong>Quando é possível adicionar opções?</strong></h5>
        <p>Somente é possível adicionar opções de extração para perguntas cujo tipo seja:</p>
        <ul>
            <li><strong>Lista de Escolha Única (Pick One List)</strong></li>
            <li><strong>Lista de Múltipla Escolha (Multiple Choice List)</strong></li>
        </ul>
        <p>Perguntas do tipo <strong>Texto</strong> não suportam opções, pois o pesquisador deverá escrever livremente a resposta.</p>

        <h5><strong>Como preencher os campos?</strong></h5>
        <ul>
            <li><strong>Pergunta:</strong> selecione a pergunta de extração à qual esta opção pertencerá. Somente perguntas de tipo lista aparecerão nessa seleção.</li>
            <li><strong>Opção:</strong> escreva a opção que será exibida ao usuário no momento da extração dos dados.</li>
        </ul>

        <p>Cada nova opção deve ser cadastrada individualmente. Caso uma pergunta possua várias opções, você deverá adicionar uma por vez.</p>

        <h5><strong>Exemplos:</strong></h5>
        <ul>
            <li><strong>Pergunta:</strong> "Base de Dados" — Tipo: Lista de Escolha Única<br>
                <strong>Opções possíveis:</strong> ACM, IEEE Xplore, Scopus, Web of Science</li>

            <li><strong>Pergunta:</strong> "Quais métricas o estudo utiliza?" — Tipo: Lista de Múltipla Escolha<br>
                <strong>Opções possíveis:</strong> Precisão, Recall, F1-Score, AUC</li>
        </ul>
    ',
            ],
            'question-selection'=> [
                'title' => 'Selecione uma pergunta',

            ],
            'question' => 'Pergunta',
            'option' => 'Opção',
            'add-option' => 'Adicionar Opção',
            'edit-option' => 'Editar Opção'
        ],
        'table' => [
            'header' => [
                'id' => 'ID',
                'description' => 'Descrição',
                'question-type' => 'Tipo de Pergunta',
                'options' => 'Opções',
                'actions' => 'Ações',
            ]
        ],
        'toasts' => [
            'denied' => 'A viewer cannot add, edit or delete data extraction questions.',
        ]
    ]
];
