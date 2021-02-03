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

    <!-- using font-awesome (free/solid) icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/solid.css" integrity="sha384-r/k8YTFqmlOaqRkZuSiE9trsrDXkh07mRaoGBMoDcmA58OHILZPsk29i2BsFng1B" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/fontawesome.css" integrity="sha384-4aon80D8rXCGx9ayDt85LbyUHeMWd3UiBaWliBlJ53yzm9hqN21A+o1pqoyK04h+" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    
</head>
<body>
    

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container-fluid">
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav list-unstyled">
                      
                        <li class="nav-item dropdown">
                            <a  class="nav-link" href="/"><i class="fas fa-clinic-medical" style=color:red></i> Home
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Profiles
                            </a>

                            <ul class="dropdown-content">

                                <li class="dropdown-item btn btn-warning btn-sm"><a href="{{URL::route('member')}}"><i class="fas fa-user" ></i>  Patients</a></li>
                            
                                <li class="dropdown-item btn btn-warning btn-sm"><a href="{{URL::route('mydoc')}}"><i class="fas fa-user-md"></i>  Doctors</a></li>

                                <li class="dropdown-item btn btn-warning btn-sm"><a href="{{URL::route('myfam')}}"><i class="fas fa-users"></i>  Family History</a></li>
                            
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Health Records
                            </a>

                            <ul class="dropdown-content">
                    
                                
                                <li class="dropdown-item btn btn-warning btn-sm"><a href="{{URL::route('myimaging')}}"><i class="fas fa-x-ray"></i>Imaging</a></li> 
                                <li class="dropdown-item btn btn-warning btn-sm"><a href="{{URL::route('myshots')}}"><i class="fas fa-syringe"></i>Immunizations</a></li>

                                <li class="dropdown-item btn btn-warning btn-sm"><a href="{{URL::route('mylab')}}"><i class="fas fa-vials"></i>Lab Tests</a></li>  


                                <li class="dropdown-item btn btn-warning btn-sm"><a href="{{URL::route('mymeds')}}"><i class="fas fa-prescription"></i>Medications</a></li>

                                <li class="dropdown-item btn btn-warning btn-sm"><a href="{{URL::route('mysurgery')}}"><i class="fas fa-procedures"></i>Surgeries/Procedures</a></li>

                                <li class="dropdown-item btn btn-warning btn-sm"><a href="{{URL::route('wellness')}}"><i class="fas fa-stethoscope"></i>Wellness Visits</a></li>
                            </ul>
                        </li>
                            
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav list-unstyled navbar-right">
                           
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link " href="#" style="position:relative; top:0px; right:0px" 
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> Help
                            </a>

                            <div class="dropdown-content" aria-labelledby="navbarDropdown">
                                <button class="dropdown-item btn btn-warning btn-sm" id="myBtn" data-toggle="modal" 
                                data-target="#myModal">About</button>
                            </div>                
                        
                        </li>

                    </ul>  
                </div>                                 
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">About MyHealth (Version {{ env('APP_VER') }})</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    
                                    <div class="col-md-3">
                                        <p> <h5> MyHealth Features:
                                    </div>
                                    <div class="col-md-6">
                                        <p>Profiles with Patient, Doctor and Family History tracking</p>
                                        <p>Imaging health records with doctor filter</p>
                                        <p>Immunization health records with patient/date/vaccine smart search & sorting</p>
                                        <p>Lab Test health records with patient/date/component smart search & sorting</p>
                                        <p>Medication history</p>
                                        <p>Surgery & Procedure health records with doctor filter</p>
                                        <p>Wellness health records with patient/date/doctor/specialty smart search & sorting </p>
                                        <br></br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <p> <h5> Build Resources:
                                    </div>
                                    <div class="col-md-9">
                                        <p>Laravel=> {{ App::Version()}}</p>
                                        <p>{!! get_package_json2('bootstrap')!!}</p>
                                        <p>{!! get_package_json2('jquery')!!}</p>
                                        <p>{!! get_package_json2('laravel-mix')!!}</p>
                                        <p>{!! get_package_json2('vue')!!}</p>
                                        <p>{!! php_ver() !!}</p>
                                        <p>FontAwesome=> v.5.7.1</p>
                                        {!! mysql_db_ver() !!}
                                        <br></br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <p> <h5> Credits:
                                    </div>
                                    <div class="col-md-9">
                                        <p>Stackoverflow.com</p>
                                        <p>AppDividend.com</p>
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
                                        <p>weblesson.info</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
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
