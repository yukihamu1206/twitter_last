@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
                @foreach ($lists as $list)
                    <div class="col-md-8 mb-3">
                        <div class="card">
                            <div class="card-haeder p-3 w-100 d-flex">
                                <img src="{{ $list['profile_image'] }}" class="rounded-circle" width="50" height="50">
                                <div class="d-flex" style="padding-left:10px">
                                    <p class="mb-0" style="padding-right:10px">{{ $list['name'] }}</p>
                                    <a href="{{ url('users/' .$list['user_id']) }}" class="text-secondary">{{ $list['screen_name'] }}</a>
                                </div>
                                <div class="d-flex justify-content-end flex-grow-1">
                                    <p class="mb-0 text-secondary">{{ $list['created_at'] }}</p>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! nl2br(e($list['text'])) !!}
                            </div>
                            <div class="card-footer py-1 d-flex justify-content-end bg-white">
                                <div class="d-flex align-items-center">
                                    <button type="button" class="btn p-0 border-0 text-primary submit_button" data-tweet="{{ $list['tweet_id'] }}"><i class="far fa-heart fa-fw" data-favorite="{{optional($list['user_favorite'])->id}}"></i></button>
                                    <p class="mb-0 text-secondary">{{ $list['favorite_count'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        <div class="my-4 d-flex justify-content-center">
            {{ $lists->links() }}
        </div>
    </div>

    <script>
        $(function(){
            $('.submit_button').click(function(){
                let button = $(this);
                let favorite = $()


            })
        })
    </script>
@endsection
