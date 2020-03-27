@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
{{--                        <div class="text-center form-group icon-div">--}}
{{--                            <form class="image-form">--}}
{{--                            <input type="file" class="upload_image" name="profile_image" style="display:none">--}}
{{--                            </form>--}}
{{--                            <button class="rounded-circle profile_image btn" width="100" height="100"><img src="{{ $profile_image }}" class="round-circle" width="100" height="100"></button>--}}
{{--                            <i class="fas fa-camera"></i>--}}
{{--                        </div>--}}
                        <form method="POST" action="{{'/user/'.$user_id}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                                <div class="form-group row">
                                    <label for="Profile Image" class="col-md-4 col-form-label text-md-right">Profile Image</label>
                                    <input type="file" name="profile_image" class="@error('profile_image') is-invalid @enderror" autocomplete="profile_image" value="{{$profile_image}}">

                                    @error('profile_image')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                    <div class="col-md-6">
                                        <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus value="{{$name}}">

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="screen_name" class="col-md-4 col-form-label text-md-right">Account Name</label>

                                    <div class="col-md-6">
                                        <input id="screen_name" type="screen_name" class="form-control @error('screen_name') is-invalid @enderror" name="screen_name" value="{{$screen_name}}">

                                        @error('screen_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"  required autocomplete="email" autofocus value="{{$email}}">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary submit-button">変更する</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
