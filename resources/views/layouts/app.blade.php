<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'My Health') }}</title>

    <!-- Scripts -->
    <!--<script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> 

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" media="all" rel="stylesheet" type="text/css" />
    
</head>
<body>
    

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container-fluid">
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav">
                        
                            <li class="nav-item dropdown">
                                <a  class = "nav-link" href="/" style='font-size: 12px; color:darkred'><i class="fas fa-clinic-medical" style=color:red></i>
                                    Home
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style='font-size: 12px; color:darkred'>
                                    Views
                                </a>

                                <ul class="dropdown-menu">

                                   <li class="dropdown-item btn btn-info" ><a href="{{URL::route('member')}}"><i class="fas fa-user-friends"></i>  Patients</a></li>
                                
                                
                                   <li class="dropdown-item btn btn-info"><a href="{{URL::route('mydoc')}}"><i class="fas fa-user-md"></i>  Doctors</a></li>
                                
                                   <li class="dropdown-item btn btn-info"><a href="{{URL::route('wellness')}}"><i class="fas fa-stethoscope"></i>  Wellness Visits</a></li>

                                   <li class="dropdown-item btn btn-info"><a href="{{URL::route('mylabs')}}"><i class="fas fa-vials"></i>  LabTest</a></li>
                                
                                   <li class="dropdown-item btn btn-info"><a href="{{URL::route('mysurgery')}}"><i class="fas fa-procedures"></i>  Surgeries</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style='font-size: 12px; color:darkred'>
                                    Reports</a>
                            <ul class="dropdown-menu">

                                   <li class="dropdown-item btn btn-info"><a href="">Patients  <i class="fas fa-tools"></i></a></li>
                                    <li class="dropdown-item btn btn-info"><a href="">Doctors  <i class="fas fa-tools"></i></a></li>
                                    <li class="dropdown-item btn btn-info"><a href="">Wellness  <i class="fas fa-tools"></i></a></li>
                                    <li class="dropdown-item btn btn-info"><a href="">Labs  <i class="fas fa-tools"></i></a></li>
                                    <li class="dropdown-item btn btn-info"><a href="">Surgeries  <i class="fas fa-tools"></i></a></li>

                            </ul>
                            </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav navbar-right">
                            

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style='font-size: 12px; color:darkred'>
                                    Help
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                   <button class="dropdown-item btn btn-info" id="myBtn" data-toggle="modal" data-target="#myModal" >About</button>
                                </div>                
                            
                            </li>

                                                        
                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">About MyHealth</h4>
                                  </div>
                                  <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p> <h5> Features:
                                            </div>
                                            <div class="col-md-9">
                                                <p>CRUD with delete confirmation</p>
                                                <p>Search/Filter algorithm</p>
                                                <p>Help Modal</p>
                                                <p>Dynamic drop-down menu</p>
                                                <p>Laravel Pagination</p>
                                                <p>FontAwesome Icons</p>
                                                <br></br>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p> <h5> Build Resources:
                                            </div>
                                            <div class="col-md-9">
                                                <p>Linux Mint v.19</p>
                                                <p>Laravel 5.8</p>
                                                <p>Bootstrap v.3.3.6 (blade)</p>
                                                <p>Bootstrap v.4.0.0</p>
                                                <p>MySql V.14.14 Distrib 5.7.22</p>
                                                <p>FontAwesome v.5.7.1</p>
                                                <p>php v.7.1.3</p>
                                                <p>jquery v.3.2</p>
                                                <p>vue v.2.5.17</p>
                                                <br></br>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p> <h5> Credits:
                                            </div>
                                            <div class="col-md-9">
                                                <p>Stackoverflow.com</p>
                                                <p>AppDividen.com</p>
                                                <p>Medium.com</p>
                                                <p>LaravelDocs</p>
                                                <p>itsolutionstuff.com</p>
                                                <p>ministackoverflow.com</p>
                                                <p>laravel-news.com</p>
                                                <p>easylaravelbook.com</p>
                                                <p>auth0.com</p>
                                                <p>snipe.net</p>
                                                <p>codexworld.com</p>
                                                <p>tutorialspoint.com</p>
                                                <p>incoder.com</p>
                                                <p>laravelcode.com</p>
                                            </div>
                                        </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>                 
                    </ul>
                </div>
            </div>
        </nav>
        <div class=container style=color:blue>
            <h2> My Health </h2>
        </div>
        <main >
            @yield('content')
        </main>

    </div>
       <script>
    // Get the modal
        var modal = document.getElementById('myModal');

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
          modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
          modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        }
    </script>
</body>
</html>
