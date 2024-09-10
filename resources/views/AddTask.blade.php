<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Registration</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <section class=" p-3 p-md-4 p-xl-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
                    <div class="card border border-light-subtle rounded-4">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-5">
                                        <h4 class="text-center">Register Here</h4>
                                    </div>
                                </div>
                            </div>
                            <form action="{{route('save.task')}}" method="post">
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

                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

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