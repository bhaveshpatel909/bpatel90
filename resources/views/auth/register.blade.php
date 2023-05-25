@extends('auth.layout.index')
@section('title', 'Register Page')
@section('main')

    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card-register">
                <div class="card-header">
                    <h3>Sign Up</h3>
                    <div class="d-flex justify-content-end social_icon_register">
                        <span><i class="fab fa-facebook-square"></i></span>
                        <span><i class="fab fa-google-plus-square"></i></span>
                        <span><i class="fab fa-twitter-square"></i></span>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @elseif(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <form action="{{ url('register') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Name" name="name">
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Email" name="email">
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="password" class="form-control" placeholder="password" name="password">
                        </div>

                        <div class="form-group text-center">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="male" id="gender" name="gender">
                                <label class="form-check-label text-light mr-4" for="flexCheckDefault">
                                    Male
                                </label>
                                <input class="form-check-input" type="radio" value="female" id="gender" name="gender">
                                <label class="form-check-label text-light" for="flexCheckDefault">
                                    Female
                                </label>
                            </div>
                        </div>

                        <div class="form-group dropdown ">
                            <select name="hobbie[]" id="hobbie" class="form-control">
                                <option value="">Select Hobbies</option>
                                <option value="saab">Saab</option>
                                <option value="mercedes">Mercedes</option>
                                <option value="audi">Audi</option>
                            </select>
                        </div>

                        <div class="form-group dropdown ">
                            <select name="country[]" id="country-dd" class="form-control">
                                <option value="">Select Country</option>
                                @foreach ($countries as $data)
                                    <option value="{{ $data->id }}">
                                        {{ $data->name }}
                                    </option>
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group dropdown ">
                            <select name="state[]" id="state-dd" class="form-control">
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="file" class="form-control" name="avtar">
                        </div>

                        <div class="form-group">
                            <img id="imagefile" name="imagefile" src="">
                        </div>

                        <div class="row align-items-center remember">
                            <input type="checkbox">Remember Me
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Register" class="btn float-right register_btn">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        Don't have an account?<a href="{{ url('login') }}">Sign In</a>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="#">Forgot your password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#country-dd').on('change', function() {
            var idCountry = this.value;
            $("#state-dd").html('');
            $.ajax({
                url: "{{ url('fetch-states') }}",
                type: "POST",
                data: {
                    country_id: idCountry,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    console.log(result);
                    $('#state-dd').html('<option value="">Select State</option>');
                    $.each(result.states, function(key, value) {
                        $("#state-dd").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }
            });
        });
    });
</script>
