<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin : Add Task</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>


<body class="bg-light">
    <nav class="navbar navbar-expand-md bg-white shadow-lg bsb-navbar bsb-navbar-hover bsb-navbar-caret">
        <div class="container">
            <a class="navbar-brand" href="#">
                <strong>Add task</strong>
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

                    

                        <a class="nav-link " href="{{route('get.teamLeader')}}" id="" role="button"
                            aria-expanded="false">All Users</a>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#!" id="accountDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">Hello,
                                {{Auth::user()->name}}</a>
                            <ul class="dropdown-menu border-0 shadow bsb-zoomIn" aria-labelledby="accountDropdown">
                                <li>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>


    <div class="container d-flex  justify-content-center align-items-center mt-5">
        <div class="card border-0 shadow mt-100">
            <div class="card-header bg-light mt-10">
                <h3 class="h5 pt-2 text-center  ">Upload a File</h3>
            </div>
            <div class="card-body ">


                <div class="mb-3">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{route('upload.excel')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="formFileSm" class="form-label">Upload Your Excel File</label>
                        <input class="form-control form-control-sm" name="excelFile" id="formFileSm" type="file">
                        <button type="submit" class="btn btn-primary btn-sm mt-3">Upload</button>
                    </form>
                    <a href="{{ route('download.excel') }}" class="btn btn-primary btn-sm mt-3">Export to Excel</a>
                </div>
            </div>
        </div>
    </div>






    <section class=" p-3 p-md-4 p-xl-5">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">

                    <div class="card border border-light-subtle rounded-4">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-5">
                                        <h4 class="text-center">Add Task Here </h4>
                                    </div>
                                </div>
                            </div>
                            <form action="{{route('admin.storeTask')}}" method="post">
                                @csrf
                                <div class="row gy-3 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                name="title" id="title" value="" placeholder="title">
                                            <label for="title" class="form-label">title</label>
                                            @error('title')
                                                <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                name="description" id="description" rows="3"
                                                placeholder="description"></textarea>
                                            <label for="address" class="form-label">description</label>
                                            @error('description')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="date"
                                                class="form-control @error('due_date') is-invalid @enderror"
                                                name="due_date" id="due_date" value="" placeholder="due_date">
                                            <label for="dob" class="form-label">Due Date</label>
                                            @error('due_date')
                                                <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <select class="form-select @error('category_id') is-invalid @enderror"
                                                name="category_id[]" id="category_id">
                                                <option value="">Category</option>
                                                @foreach ($cate as $c)
                                                    <option value="{{$c->id}}">{{$c->Title}}</option>
                                                @endforeach
                                            </select>
                                            <label for="category_id" class="form-label">Category </label>
                                            @error('category_id')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <select class="form-select @error('teamLeader') is-invalid @enderror"
                                                name="teamLeader" id="teamLeader">
                                                <option value="">Select Team Leader </option>
                                                @foreach ($leader as $l)
                                                    <option value="{{$l->id}}">{{$l->name}}</option>
                                                @endforeach
                                            </select>
                                            <label for="teamLeader" class="form-label">Team Leader </label>
                                            @error('teamLeader')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <select class="form-select @error('project_id') is-invalid @enderror"
                                                name="project_id" id="project_name">
                                                <option value="">Select Project </option>
                                                @foreach ($project as $p)
                                                    <option value="{{$p->id}}">{{$p->Project_name}}</option>
                                                @endforeach
                                            </select>
                                            <label for="project_id" class="form-label">Project</label>
                                            @error('project_id')
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
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>