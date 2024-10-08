<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard : Upload Excel Files</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-md bg-white shadow-lg bsb-navbar bsb-navbar-hover bsb-navbar-caret">
        <div class="container">
            <a class="navbar-brand" href="#">
                <strong>Admin Dashboard</strong>
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





                        <a class="nav-link " href="{{route('admin.dashboard')}}" id="" role="button"
                            aria-expanded="false">Go to Dashboard</a>

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




        <div class="card border-0 shadow my-5">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h3 class="h5 pt-2">Upload Files</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error')}}
                        </div>
                    @endif
                    <form action="{{route('upload.excel') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input class="form-control" name="excelFile" id="formFileSm" type="file">
                                </div>
                                @error('excelFile')
                                    <p class="invalid-feedback">You may need to select table</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select @error('table_type') is-invalid @enderror"
                                        name="table_type" id="table_type">
                                        <option value="">Select Table</option>
                                        <option value="clients">Client</option>
                                        <option value="projects">Project</option>
                                        <option value="task">Task</option>
                                    </select>
                                    <label for="table_type" class="form-label">Select Table </label>
                                    @error('table_type')
                                        <p class="invalid-feedback">You may need to select table</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="input-group-append  ms-5">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container my-4 row-cols-1-lg-1">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4">
                </div>
            </div>
        </div>



        <div class="card border-0 shadow my-5 ">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h3 class="h5 pt-2">Pending Files </h3>
            </div>
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Uploaded_time</th>
                        <th scope="col">Stored_path</th>
                        <th scope="col">Table_type</th>
                        <th scope="col">status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($excelData as $c)
                        <tr>
                            <th scope="row">{{$c->id}}</th>
                            <th scope="row">{{$c->uploaded_time}}</th>
                            <th scope="row">{{$c->stored_path}}</th>
                            <th scope="row">{{$c->table_type}}</th>
                            <th scope="row">{{$c->status}}</th>
                            <th>
                                @if ($c->status == 'Failed')
                                    <a href="{{route('show.error', $c->id)}}">View Error</a>
                                @endif
                            </th>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            <div class="container my-4 row-cols-1-lg-1">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4">

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>