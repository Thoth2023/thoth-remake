<!-- resources/views/faq/faq.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Super Administração</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
         
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                Dashboard
                            </a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link" href="#">
                                Ajustar o FAQ
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </nav>
            
           
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <form role="form" method="POST" action="{{ route('faq.perform') }}">
                        @csrf
                        @method('post')
                        <div class="flex flex-col mb-3">
                            <input type="question" name="question" class="form-control form-control-lg"
                                placeholder="" aria-label="question">
                            @error('question')
                                <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div class="flex flex-col mb-3">
                            <input type="declaration" name="declaration" class="form-control form-control-lg"
                                placeholder="">
                            @error('declaration')
                                <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                            @enderror
                        </div>
                        
                        <div class="text-center">
                            <button type="submit"
                                class="btn btn-lg btn-dark btn-lg w-100 mt-4 mb-0"></button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
