<footer class="footer mt-2 ">
    <!-- Início do rodapé com uma margem superior (mt-2) -->

    <div class="container-fluid">
        <!-- Container que ocupa toda a largura da tela, usado para agrupar o conteúdo interno -->

        <div class="row align-items-center justify-content-lg-end">
            <!-- Linha com alinhamento vertical ao centro (align-items-center)
                 e alinhamento horizontal à direita em telas grandes (justify-content-lg-end) -->

            <div class="col-lg-6 mb-lg-0 mb-4">
                <!-- Coluna que ocupa metade da largura em telas grandes (col-lg-6)
                     com margem inferior apenas em telas pequenas (mb-4), removida em telas grandes (mb-lg-0) -->

                <div class="copyright text-center text-sm text-muted text-lg-start">
                    <!-- Texto centralizado em telas pequenas, alinhado à esquerda em telas grandes,
                         com tamanho pequeno e cor de texto esmaecida (text-muted) -->
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>,
                    <!-- Script JavaScript que insere automaticamente o ano atual no rodapé -->
                    Thoth :: Tool for SLR
                    <!-- Nome da aplicação ou sistema exibido no rodapé -->
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Segunda coluna do rodapé, também ocupando metade da largura em telas grandes -->

                <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                    <!-- Lista de navegação com estilo próprio do Bootstrap (nav-footer),
                         centralizada em telas pequenas e alinhada à direita em telas grandes -->

                    <li class="nav-item">
                        <a href="{{ route('help') }}" class="nav-link text-muted">FAQ</a>
                        <!-- Link para a página de ajuda/FAQ, com aparência de texto esmaecido -->
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('about') }}" class="nav-link text-muted">{{ TranslationHome('about_us') }}</a>
                        <!-- Link para a página "Sobre nós", com tradução dinâmica via função __() do Laravel -->
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('terms') }}" class="nav-link text-muted">{{ TranslationHome("terms_and_conditions") }}</a>
                        <!-- Link para os termos e condições, também com tradução dinâmica -->
                    </li>

                    <li class="nav-item">
                        <a href="https://www.lesse.com.br" class="nav-link pe-0 text-muted" target="_blank">Lesse</a>
                        <!-- Link externo para o site da Lesse, abre em nova aba (target="_blank"),
                             sem padding à direita (pe-0) e com texto esmaecido -->
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
