<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Team Leader Dashboard</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-md bg-white shadow-lg bsb-navbar bsb-navbar-hover bsb-navbar-caret">
        <div class="container">
            <a class="navbar-brand" href="#">
                <strong> Leader dashboard</strong>
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

                        <a class="nav-link " href="{{route('teamLeader.showMembers')}}" id="" role="button"
                            aria-expanded="false">Your Team</a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#!" id="accountDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">Hello,
                                {{Auth()->user()->name}}</a>
                            <ul class="dropdown-menu border-0 shadow bsb-zoomIn" aria-labelledby="accountDropdown">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
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

                                    <p class="card-text fw-bolder">
                                    <p class="fw-bolder">Description :</p>
                                    {{$st->description}}
                                    {{$st->id}}
                                    </p>

                                    <p class="card-text">
                                    <p class="fw-bolder d-inline">Team Leader:</p>
                                    <h6 class="d-inline">{{$st->teamLeaderName[0]->name}}</h6>
                                    </p>

                                    <p class="fw-bolder">Status:</p>
                                    <div class="progress mb-4" role="progressbar" aria-label="Success example" aria-valuenow="{{$st->status}}"
                                                        aria-valuemin="0" aria-valuemax="100">
                                                        <div class="progress-bar bg-success" style="width :20%">
                                                        {{$st->status}}%</div>
                                                    </div>


                                    <!-- Modal  to assign task to emp-->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop{{$st->id}}">
                                        Assign
                                    </button>

                                    <div class="modal fade" id="staticBackdrop{{$st->id}}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Assigning to
                                                        Employee</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('assign.emp', $st->id)}}" method="post">
                                                        @csrf
                                                        <div class="row gy-3 overflow-hidden">
                                                            <div class="col-12">
                                                                <div class="form-floating mb-3">
                                                                    <input type="text"
                                                                        class="form-control @error('title') is-invalid @enderror"
                                                                        name="title" id="title" value="{{$st->title}}"
                                                                        disabled placeholder="title">
                                                                    <label for="title" class="form-label">title</label>
                                                                    @error('title')
                                                                        <p class="invalid-feedback">{{$message}}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-floating mb-3">
                                                                    <textarea style="height: 100px"
                                                                        class="form-control @error('description') is-invalid @enderror"
                                                                        name="description" id="description" rows="3"
                                                                        placeholder="description"
                                                                        disabled>{{$st->description}}</textarea>
                                                                    <label for="address"
                                                                        class="form-label">description</label>
                                                                    @error('description')
                                                                        <p class="invalid-feedback">{{ $message }}/>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-floating mb-3">
                                                                    <select
                                                                        class="form-select @error('emp_id') is-invalid @enderror"
                                                                        name="emp_id" id="category_id">
                                                                        <option value="">Employee</option>
                                                                        @foreach ($mem as $c)
                                                                            <option value="{{$c->id}}">{{$c->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <label for="emp_id" class="form-label">Select Employee
                                                                    </label>
                                                                    @error('emp_id')
                                                                        <p class="invalid-feedback">{{ $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="d-grid">
                                                                    <button class="btn bsb-btn-xl btn-primary py-3"
                                                                        type="submit">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <a class="btn btn-outline-primary "
                                    href="{{route('show.leader.task.comments',$st->id)}}">Comments</a>


                                  
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