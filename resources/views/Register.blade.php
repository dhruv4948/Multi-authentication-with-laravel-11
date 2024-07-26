

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
                            <form action="{{route('account.processRegistration')}}" method="post">
                             @csrf

                                <div class="row gy-3 overflow-hidden">

                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                name="name" id="name" value="" placeholder="name">
                                            <label for="name" class="form-label">Name</label>
                                            @error('name')
                                                <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                                name="email" value="{{old('email')}}" id="email"
                                                placeholder="name@example.com">
                                            <label for="email" class="form-label">Email</label>
                                            @error('email')
                                                <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="number"
                                                class="form-control @error('number') is-invalid @enderror" name="number"
                                                id="number" value="" placeholder="Contact Number ">
                                            <label for="number" class="form-label">Contact Number</label>
                                            @error('password')
                                                <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control @error('dob') is-invalid @enderror"
                                                name="dob" id="dob" value="" placeholder="dob">
                                            <label for="dob" class="form-label">Date of Birth</label>
                                            @error('dob')
                                                <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input @error('gender') is-invalid @enderror"
                                                    type="radio" name="gender" id="male" value="male">
                                                <label class="form-check-label" for="male">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input @error('gender') is-invalid @enderror"
                                                    type="radio" name="gender" id="female" value="female">
                                                <label class="form-check-label" for="female">Female</label>
                                            </div>
                                            @error('gender')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <select class="form-select @error('city') is-invalid @enderror"
                                                name="education" id="city">
                                                <option value="">Select Education</option>
                                                <option value="post_graduate">Post-Graduate</option>
                                                <option value="graduate">Graduate</option>
                                                <option value="12">12</option>
                                                <option value="10">10</option>
                                            </select>
                                            <label for="city" class="form-label">Educaction </label>
                                            @error('city')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input @error('skills') is-invalid @enderror"
                                                    type="checkbox" name="skills[]" id="html" value="html">
                                                <label class="form-check-label" for="html">HTML</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input @error('skills') is-invalid @enderror"
                                                    type="checkbox" name="skills[]" id="css" value="css">
                                                <label class="form-check-label" for="css">CSS</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input @error('skills') is-invalid @enderror"
                                                    type="checkbox" name="skills[]" id="javascript" value="javascript">
                                                <label class="form-check-label" for="javascript">JavaScript</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input @error('skills') is-invalid @enderror"
                                                    type="checkbox" name="skills[]" id="php" value="php">
                                                <label class="form-check-label" for="php">PHP</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input @error('skills') is-invalid @enderror"
                                                    type="checkbox" name="skills[]" id="python" value="python">
                                                <label class="form-check-label" for="python">Python</label>
                                            </div>
                                            @error('skills')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control @error('address') is-invalid @enderror"
                                                name="address" id="address" rows="3" placeholder="Address"></textarea>
                                            <label for="address" class="form-label">Address</label>
                                            @error('address')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <select class="form-select @error('city') is-invalid @enderror" name="city"
                                                id="city">
                                                <option value="">Select City</option>
                                                <option value="new-york">New York</option>
                                                <option value="london">London</option>
                                                <option value="paris">Paris</option>
                                                <option value="tokyo">Tokyo</option>
                                                <option value="sydney">Sydney</option>
                                            </select>
                                            <label for="city" class="form-label">City</label>
                                            @error('city')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <select class="form-select @error('city') is-invalid @enderror"
                                                name="country" id="country">
                                                <option value="">Select Country</option>
                                                <option value="India">India</option>
                                                <option value="USA">USA</option>
                                                <option value="Russia">Russia</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Germany">Germany</option>
                                            </select>
                                            <label for="city" class="form-label">Country</label>
                                            @error('city')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control @error('password') is-invalid  @enderror" name="password" id="password" value="" placeholder="Password" >
                                                <label for="password" class="form-label">Password</label>
                                                @error('password')
                                                    <p class="invalid-feedback">{{$message}}</p>
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