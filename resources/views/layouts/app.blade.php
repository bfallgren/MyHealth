<!doctype html>
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

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script>

        <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

        <link href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css" rel="stylesheet" type="text/css" />
        <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>

        <!-- added for datatable export -->

        <script src= "https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"> </script>
        <script src= "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"> </script>
        <script src= "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"> </script>
        <script src= "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"> </script>
        <script src= "https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"> </script>
        <script src= "https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"> </script>
        
        <!-- added for sweetalert2 export -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
    
        <div id="app">
            <nav class="navbar navbar-light navbar-laravel">
                <div class="container-fluid">

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav list-unstyled">

                            <li class="nav-item dropdown">
                                <a  class="nav-link" href="/"><i class="fas fa-clinic-medical" style=color:red></i> Home
                                </a>
                            </li>
                            <!-- Authentication Links -->
                            @guest

                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Health Records
                                    </a>

                                    <ul class="dropdown-content" >


                                        <li class="dropdown-item btn btn-warning btn-sm"><a href="{{URL::route('myimaging')}}"><i class="fas fa-x-ray"></i>Imaging</a></li>       

                                        <li class="dropdown-item btn btn-warning btn-sm"><a href="{{URL::route('mylab')}}"><i class="fas fa-vials"></i>Lab Tests</a></li>

                                        <li class="dropdown-item btn btn-warning btn-sm"><a href="{{URL::route('mymeds')}}"><i class="fas fa-prescription"></i>Medications</a></li>

                                        <li class="dropdown-item btn btn-warning btn-sm"><a href="{{URL::route('mysurgery')}}"><i class="fas fa-procedures"></i>Surgeries/Procedures</a></li>

                                        <li class="dropdown-item btn btn-warning btn-sm"><a href="{{URL::route('myshots')}}"><i class="fas fa-syringe"></i>Vaccines</a></li>
                                        
                                        <li class="dropdown-item btn btn-warning btn-sm"><a href="{{URL::route('wellness')}}"><i class="fas fa-stethoscope"></i>Wellness Visits</a></li>
                                    
                                    
                                    </ul>
                                </li>
                            @endguest
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav list-unstyled navbar-right">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                            
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Templates
                                    </a>

                                    <ul class="dropdown-content">

                                        <li class="dropdown-item btn btn-warning btn-sm"><a href="{{URL::route('template')}}"><i class="fas fa-user-md" ></i>Labs</a></li>

                                    </ul>
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
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-content" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item btn btn-warning btn-sm" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link " href="#" style="position:relative; top:0px; right:10px"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> Help
                                    </a>

                                    <div class="dropdown-content text-right">
                                        <button class="dropdown-item btn btn-warning btn-sm" id="myBtn" data-toggle="modal"
                                        data-target="#aboutModal">About</button>
                                        <button class="dropdown-item btn btn-warning btn-sm" id="myBtn" data-toggle="modal"
                                        data-target="#buildModal">Build Info</button>
                                        <button class="dropdown-item btn btn-warning btn-sm" id="myBtn" data-toggle="modal"
                                        data-target="#creditModal">Credits</button>
                                        <button class="dropdown-item btn btn-warning btn-sm" id="myBtn" data-toggle="modal"
                                        data-target="#feedbkModal">Feedback</button>
                                        <button class="dropdown-item btn btn-warning btn-sm" id="myBtn" data-toggle="modal"
                                        data-target="#startModal">Getting Started</button>
                                        <button class="dropdown-item btn btn-warning btn-sm" id="myBtn" data-toggle="modal"
                                        data-target="#rel_notesModal">Release Notes</button>
                                    </div>

                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Modal -->
            <div class="modal fade" id="aboutModal" tabindex="-1" role="dialog" aria-labelledby="aboutModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="aboutModalLabel">About MyHealth (Version {{ env('APP_VER') }})</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-3">
                                    <p> <h5> MyHealth Features:
                                </div>
                                <div class="col-md-6">
                                    <p>Profiles with Patient, Doctor and Family History tracking</p>
                                    <p>Lab Templates for bulk inserts of Lab records</p>
                                    <p>Imaging health records</p>
                                    <p>Immunization health records</p>
                                    <p>Lab Test health records </p>
                                    <p>Medication history</p>
                                    <p>Surgery & Procedure health records</p>
                                    <p>Wellness health records </p>
                                    <p>All screens include search, sort, pagination and export functions</p>
                                        <br></br>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="buildModal" tabindex="-1" role="dialog" aria-labelledby="buildModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="buildModalLabel">MyHealth Build Resources (Version {{ env('APP_VER') }})</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">

                                <div class="col-md-9">
                                    <p>Laravel=> {{ App::Version()}}</p>
                                    <p>{!! get_package_json2('bootstrap')!!}</p>
                                    <p>{!! get_package_json2('jquery')!!}</p>
                                    <p>{!! get_package_json2('laravel-mix')!!}</p>
                                    <p>{!! get_package_json2('vue')!!}</p>
                                    <p>{!! php_ver() !!}</p>
                                    <p>FontAwesome=> v.5.7.1</p>
                                    <p> {!! mysql_db_ver() !!}</p>
                                    <br></br>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="creditModal" tabindex="-1" role="dialog" aria-labelledby="creditModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="creditModalLabel">MyHealth Credits</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">
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

            <div class="modal fade" id="feedbkModal" tabindex="-1" role="dialog" aria-labelledby="feedbkModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="feedbkModalLabel">MyHealth Feedback</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p> <h3> Please send feedback to: rjfallgren@gmail.com
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="startModal" tabindex="-1" role="dialog" aria-labelledby="startModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="startModalLabel">Getting started with MyHealth</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-3">
                                    <p> <h5> Using MyHealth:
                                </div>
                                <div class="col-md-9">
                                    <p>Create at least one doctor profile record including your primary doctor</p>
                                    <p>Create a patient profile record (only one)</p>
                                    <p>Enter additional profile or health records as needed</p>
                                    <p>When using export functions, be sure to filter your results as the export will only use the current screen results</p>
                                    <p>On Lab Results page, mark 'comment' column with 'abnormal' text, to highlight glasses icon in red</p>
                                    <p>When using Lab Templates, search on template name (Lipid, Comp Meta Panel, CBC, etc.), then Select or Select All, then Add</p>
                                    <br></br>
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

        <div class="modal fade" id="rel_notesModal" tabindex="-1" role="dialog" aria-labelledby="buildModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="buildModalLabel">MyHealth Release Notes</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">

                                <div class="col-md-12">
                                    <p>{!! print_rel_notes()!!}</p>
                                    <br></br>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        <div class=container style=color:blue>
            <h2> My Health </h2>
        </div>
        <main >
            @yield('content')
        </main>


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
