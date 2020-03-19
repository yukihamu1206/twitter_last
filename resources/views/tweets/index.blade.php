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
                                    <button type="button" class="btn p-0 border-0 text-primary submit_button" data-tweet="{{ $list['tweet_id'] }}"><i class="{{ $list['user_favorite'] ? 'fas' : 'far' }} fa-heart fa-fw" data-favorite="{{optional($list['user_favorite'])->id}}"></i></button>
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
                let i = button.children('i');
                let favorite_count = button.parent().find('p');
                let tweet_id = button.data('tweet');
                if(i.hasClass('far')) {
                    $.ajax({
                        url:'http://localhost/api/favorite',
                        type:'POST',
                        data:{
                            tweet_id:tweet_id
                        }
                    }).done(function(data){
                        if(data['result']){
                            i.removeClass('far');
                            i.addClass('fas');
                            i.data('favorite',data['user_favorite'] );
                            favorite_count.text(data['favorite_count']);
                        }else{
                            console.log('error');
                        }
                    });
                }else{
                    let favorite_id = i.data('favorite');
                    $.ajax({
                        url:'http://localhost/api/favorite/' + favorite_id,
                        type:'DELETE',
                        data: {
                            tweet_id: tweet_id,
                            favorite_id: favorite_id
                        }
                    }).done(function(data){
                        if(data['result']){
                            i.removeClass('fas');
                            i.addClass('far');
                            i.data('favorite','');
                            i.data('favorite','');
                            favorite_count.text(data['favorite_count']);
                        }else{
                            console.log('error');
                        }
                    });

                }


            });
        });

    </script>

@endsection
