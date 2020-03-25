@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center form-group icon-div">
                            <form class="image-form">
                            <input type="file" class="upload_image" name="profile_image" style="display:none">
                            </form>
                            <button class="rounded-circle profile_image btn" width="100" height="100"><img src="{{ $profile_image }}" class="round-circle" width="100" height="100"></button>
                            <i class="fas fa-camera"></i>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Account Name</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary submit-button">変更する</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function(){
            $('.profile_image').click(function(){
                $('.upload_image').click();
                return false;
            });

            $('.upload_image').change(function(){
                let profile_image = new FormData($('.image_form').get(0));
                let api_token = "{{ $api_token }}";
                let user_id = "{{$user_id}}";

                $.ajax({
                    url:'/api/user/' + user_id,
                    type:'PUT',
                    data:{
                        api_token:api_token,
                        profile_image:profile_image
                    },
                    processData: false,
                    contentType: false,
                });
            });
        });

    </script>


@endsection
