<footer class="footer mt-2 ">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-end">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="copyright text-center text-sm text-muted text-lg-start">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>,
                    Thoth :: Tool for SLR
                </div>
            </div>
            <div class="col-lg-6">
                <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                    <li class="nav-item">
                        <a href="{{ route('help') }}" class="nav-link text-muted">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('about') }}" class="nav-link text-muted">{{ translationFooter('about_us') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('terms') }}" class="nav-link text-muted">{{ TranslationHome('terms_and_conditions') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="https://www.lesse.com.br" class="nav-link pe-0 text-muted" target="_blank">Lesse</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
