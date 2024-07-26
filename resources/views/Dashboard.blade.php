<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-md bg-white shadow-lg bsb-navbar bsb-navbar-hover bsb-navbar-caret">
        <div class="container">
            <a class="navbar-brand" href="#">
                <strong>Employee Dashboard</strong>
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
                        <a class="nav-link " href="{{route('show.comments.emp')}}" id="" role="button"
                            aria-expanded="false">Comments</a>
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
                                        @php
                                            $isAccepted = \App\Models\User_Task::where('task_id', $st->id)->exists();
                                        @endphp
                                        <div class="col">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <h5 class="card-titgetle">{{$st->getEmpTask[0]->title}}</h5>
                                                    <span class="badge bg-secondary">Last Date: {{$st->getEmpTask[0]->due_date}}</span>
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text fw-bolder">
                                                    <p class="fw-bolder">Description :</p>
                                                    {{$st->getEmpTask[0]->description}}
                                                    </p>


                                                    <p class="fw-bolder">Current Status:</p>


                                                    <div class="progress mb-3" role="progressbar" aria-label="Success example"
                                                        aria-valuenow="{{$st->getEmpTask[0]->status}}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                        <div class="progress-bar bg-success"
                                                            style="width:   {{$st->getEmpTask[0]->status}}%">
                                                            {{$st->getEmpTask[0]->status}}%
                                                        </div>
                                                    </div>



                                                    <p class="fw-bolder">Update Status:</p>
                                                    <div class="row gy-3 overflow-hidden ">
                                                        <div class="col-8">
                                                            <div class="form-floating mb-3 ">


                                                                <div>
                                                                    <form div.col
                                                                        action="{{route('update.task.status', $st->getEmpTask[0]->id)}}"
                                                                        method="post">
                                                                        @csrf
                                                                        <input type="text"
                                                                            class="form-control  @error('status') is-invalid @enderror"
                                                                            name="status" id="status" value="" placeholder="status">
                                                                        @error('status')
                                                                            <p class="invalid-feedback">{{$message}}</p>
                                                                        @enderror

                                                                        <button type="submit" class="btn btn-success mt-3"> Update
                                                                        </button>

                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <button type="button" class="btn btn-primary " data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop">
                                                        Comment
                                                    </button>
                                                </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add a Comment</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <form action="{{route('add.comments')}}" method="post">
                                                                    @csrf
                                                                    <div class="row gy-3 overflow-hidden">
                                                                        <div class="col-12">
                                                                            <div class="form-floating mb-3">
                                                                                <input type="text"
                                                                                    class="form-control @error('comments') is-invalid @enderror"
                                                                                    name="comments" id="title" value=""
                                                                                    placeholder="comments">
                                                                                <label for="comments" class="form-label">Add
                                                                                    Comments</label>
                                                                                @error('comments')
                                                                                    <p class="invalid-feedback">{{$message}}</p>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="d-grid">
                                                                            <button class="btn bsb-btn-xl btn-primary py-3"
                                                                                type="submit">Comments</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
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