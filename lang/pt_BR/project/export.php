<?php

return [

    'export' => 'Exportar Conteúdos',
    'header' => [
        'latex' => [
            'title' => 'Conteúdo Latex',
            'help-content' => '
<p>Este recurso permite exportar os dados do sistema no formato <strong>LaTeX</strong>, amplamente utilizado para criar documentos técnicos e científicos de alta qualidade.</p>

<p><strong>Como funciona:</strong></p>
<ul>
    <li>Selecione as opções desejadas, como <em>Planning</em>, <em>Import Studies</em> ou <em>Quality Assessment</em>.</li>
    <li>O sistema gerará automaticamente o conteúdo correspondente no formato LaTeX com base nas informações cadastradas no projeto.</li>
    <li>O texto gerado será exibido no editor abaixo, onde você poderá visualizar e editar o conteúdo manualmente, se necessário.</li>
</ul>

<p><strong>Exportação para o Overleaf:</strong></p>
<p>Ao clicar no botão <em>Novo projeto em Overleaf</em>, o sistema compacta o conteúdo gerado em um arquivo ZIP e redireciona você para um novo projeto no Overleaf, uma plataforma online para edição colaborativa de documentos LaTeX.</p>

<p><em>Nota:</em> Para que a integração com o Overleaf funcione, você precisa estar logado na plataforma ou realizar o login ao ser redirecionado.</p>

<p>Este recurso facilita a criação, organização e edição de documentos relacionados ao projeto, integrando as informações do sistema de maneira prática e eficiente.</p>
',
        ],
        'bibtex' => [
            'title' => 'Referências BibTex',
            'help-content' => '<div>
    <p>
        O sistema permite a exportação de referências bibliográficas no formato BibTeX, que é amplamente utilizado em gerenciadores de referências e na produção de artigos acadêmicos.
        Com essa funcionalidade, você pode gerar, visualizar e baixar as referências relacionadas ao seu projeto, de acordo com a seleção desejada.
    </p>

    <h5>Opções disponíveis:</h5>
    <ul>
        <li>
            <strong>Study Selection:</strong> Gera as referências apenas para os estudos selecionados, cujo status de seleção seja
            <code>Aceito</code>. Essas referências são extraídas com base nos critérios definidos no seu projeto.
        </li>
        <li>
            <strong>Quality Assessment:</strong> Gera as referências para os estudos que passaram pela avaliação de qualidade
            <code>Aceito</code>.
        </li>
        <li>
            <strong>Snowballing:</strong> No momento, esta opção exibe um texto indicando que ainda não existem dados disponíveis para a geração de referências nesta modalidade.
        </li>
    </ul>

    <h5>Como funciona:</h5>
    <ul>
        <li>Selecione uma das opções disponíveis no painel utilizando os botões de rádio.</li>
        <li>As referências serão geradas automaticamente no campo de texto abaixo, no formato BibTeX.</li>
        <li>Caso não haja dados para a opção selecionada, uma mensagem será exibida no campo de texto indicando que não há informações disponíveis.</li>
        <li>Depois que as referências forem geradas, você pode baixá-las clicando no botão de download.</li>
    </ul>

    <h5>Observações:</h5>
    <ul>
        <li>O formato BibTeX é compatível com ferramentas como LaTeX, Overleaf, e gerenciadores de referências como Mendeley, Zotero e JabRef.</li>
        <li>Certifique-se de que as informações do seu projeto estejam completas para garantir a exportação correta das referências.</li>
    </ul>
</div>',
            'enter_description' => 'Selecione as opções para gerar as referências...',
        ],
    ],
    'button'=>[
        'overleaf'=>'Novo Projeto em Overleaf',
        'bibtex-download'=> 'Download das Referências BibTex',
        'copy-latex'=>'Copiar LaTex',
    ]
];
