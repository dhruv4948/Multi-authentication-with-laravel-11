<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin: Dashboard</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-md bg-white shadow-lg bsb-navbar bsb-navbar-hover bsb-navbar-caret">
        <div class="container">
            <a class="navbar-brand" href="#">
                <strong>Dashboard</strong>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                </svg>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1">


                    <a class="nav-link " href="{{route('load.excel')}}" id="" role="button"
                            aria-expanded="false">Add Excel </a>


                        <!-- modal component to add a new client -->
                        <a class="nav-link " id="" role="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            data-bs-whatever="@mdo" aria-expanded="false">Add Clients </a>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add a New CLient</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('save.client')}}" method="post">
                                            @csrf
                                            <div class="row gy-3 overflow-hidden">
                                                <div class="col-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="text"
                                                            class="form-control @error('client_name') is-invalid @enderror"
                                                            name="client_name" id="title" value="" placeholder="client">
                                                        <label for="client_name" class="form-label">Client
                                                            Name</label>
                                                        @error('client_name')
                                                            <p class="invalid-feedback">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button class="btn bsb-btn-xl btn-primary py-3"
                                                            type="submit">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a class="nav-link " href="{{route('add.project')}}" id="" role="button"
                            aria-expanded="false">Project </a>

                        <a class="nav-link " href="{{route('admin.addTask')}}" id="" role="button"
                            aria-expanded="false">Add Task </a>


                        <a class="nav-link " href="{{route('get.teamLeader')}}" id="" role="button"
                            aria-expanded="false">All Users</a>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#!" id="accountDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">Hello,
                                {{Auth::user()->name}}</a>
                            <ul class="dropdown-menu border-0 shadow bsb-zoomIn" aria-labelledby="accountDropdown">
                                <li>

                                    <div class="nav-link" role="button" aria-expanded="false">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card border-0 shadow my-5 ">
            <div class="card-header bg-light">
                <h3 class="h5 pt-2">Taskboard</h3>
            </div>

            <div class="container my-4 row-cols-1-lg-1">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4">
                    @foreach ($showTask as $st)
                                      

                                        <div class="col">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between align-items-center">

                                                    <h5 class="card-title">{{$st->title}}</h5>
                                                    <span class="badge bg-secondary">Last Date: {{$st->due_date}}</span>
                                                </div>
                                                <div class="card-body">

                                                    <p class="card-text fw-bolder row-cols-1">
                                                    <p class="fw-bolder">Description :</p>
                                                    {{$st->description}}
                                                    </p>

                                                    <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="{{$st->status}}"
                                                        aria-valuemin="0" aria-valuemax="100">
                                                        <div class="progress-bar bg-success" style="width :{{$st->status}}%">{{$st->status}} %</div>
                                                    </div>

                                                    <p class="card-text">
                                                    <p class="fw-bolder d-inline">Team Leader:</p>
                                                    <h6 class="d-inline">{{$st->teamLeaderName[0]->name}}</h6>
                                                    </p>
                                                    <div class="column">
                                                    </div>

                                                    <a class="btn btn-outline-primary "
                                                        href="{{route('show.admin.task.comments', $st->id)}}">Comments</a>
                                                </div>
                                            </div>
                                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>