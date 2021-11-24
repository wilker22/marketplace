<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>MarketPlace WTech</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="margin-bottom: 40px">
        <div class="container-fluid">
          <a class="navbar-brand" href="{{route('home')}}">Marketplace</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
            @auth
            
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->route()->named('admin.stores*')) active @endif" aria-current="page" href="{{ route('admin.stores.index')}}">Lojas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->route()->named('admin.products*')) active @endif" href="{{ route('admin.products.index')}}">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->route()->named('admin.categories*')) active @endif" href="{{ route('admin.categories.index')}}">Categorias</a>
                    </li>
                                
                </ul>
                <div class="d-flex">
                    <ul class="navbar-nav mr-auto">
                        
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="event.preventDefault(); document.querySelector('form.logout').submit()">Sair</a>
                            <form action="{{route('logout')}}" class="logout" method="post">
                                @csrf
                            </form>
                        </li>

                        <li class="nav-item">
                            <span class="nav-link">{{ auth()->user()->name }}</span>
                        </li>
                    </ul>
                
                </div>
            
            @endauth

          </div>
        </div>
      </nav>

    <div class="container">
        @include('flash::message')
        @yield('content')
    </div>


    <!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>