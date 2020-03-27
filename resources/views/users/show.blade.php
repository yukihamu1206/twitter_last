@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-3">
                <div class="card">
                    <div class="d-inline-flex">
                        <div class="p-3 d-flex flex-column">
                            <img src="{{ $profile_image }}" class="rounded-circle" width="100" height="100">
                            <div class="mt-3 d-flex flex-column">
                                <h4 class="mb-0 font-weight-bold">{{ $name }}</h4>
                                <span class="text-secondary">{{ $screen_name }}</span>
                            </div>
                        </div>
                        <div class="p-3 d-flex flex-column justify-content-between">
                            <div class="d-flex">
                                <div>
                                    @if ($user->id === $login_user->id)
                                        <a href="{{url('user/'.$user->id.'/edit')}}" class="btn btn-primary">プロフィールを編集する</a>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="p-2 d-flex flex-column align-items-center">
                                    <p class="font-weight-bold">ツイート数</p>
                                    <span>{{ $tweet_count }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (isset($lists))
                @foreach ($lists as $list)
                    <div class="col-md-8 mb-3">
                        <div class="card">
                            <div class="card-haeder p-3 w-100 d-flex">
                                <img src="{{ $list['profile_image'] }}" class="rounded-circle" width="50" height="50">
                                <div class="ml-2 d-flex flex-column flex-grow-1">
                                    <p class="mb-0">{{ $list['name'] }}</p>
                                    <a href="{{ url('users/' .$list['user_id']) }}" class="text-secondary">{{ $list['screen_name'] }}</a>
                                </div>
                                <div class="d-flex justify-content-end flex-grow-1">
                                    <p class="mb-0 text-secondary">{{ $list['created_at'] }}</p>
                                </div>
                            </div>
                            <div class="card-body">
                                {{ $list['text'] }}
                            </div>
                            <div class="card-footer py-1 d-flex justify-content-end bg-white">
                                @if ($list['user_id'] === $login_user->id)
                                    <div class="dropdown mr-3 d-flex align-items-center">
                                        <a href="{{'user/'.$list['user_id'].'/edit'}}" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-fw"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a href="{{ url('tweet/' .$list['id'] .'/edit') }}" class="dropdown-item">編集</a>
                                        </div>
                                    </div>
                                @endif
                                <div class="d-flex align-items-center">
                                    <button type="button" class="btn p-0 border-0 text-primary submit_button" data-tweet="{{ $list['tweet_id'] }}"> <i class="{{ $list['user_favorite'] ? 'fas' : 'far' }} fa-heart fa-fw" data-favorite="{{optional($list['user_favorite'])->id}}"></i></button>
                                    <p class="mb-0 text-secondary favorite_count">{{ $list['favorite_count'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="my-4 d-flex justify-content-center">
            {{ $lists->links() }}
        </div>
    </div>

    <script>

        $(function(){
            $('.submit_button').click(function(){
                let button = $(this);
                let i = $(this).children('i');
                let favorite_count = button.parent().find('p');
                let tweet_id = button.data('tweet');
                if(i.hasClass('far')){
                    $.ajax({
                        url:'/api/favorite',
                        data: {
                            tweet_id: tweet_id
                        },
                        type:'POST',
                    }).done(function(data){
                        if(data['result']){
                            i.removeClass('far');
                            i.addClass('fas');
                            i.data('favorite',data['user_favorite_id']);
                            favorite_count.text(data['favorite_count']);
                        }else{
                            console.log('error');
                        }
                    });
                }else{
                    let favorite_id = button.children('i').data('favorite');
                    $.ajax({
                        url: '/api/favorite/' + favorite_id,
                        type: 'DELETE',
                    }).done(function(data){
                        if(data['result']){
                            i.removeClass('fas');
                            i.addClass('far');
                            i.data('favorite',"");
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


