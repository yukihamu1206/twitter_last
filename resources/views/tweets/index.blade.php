@extends('layouts.app')

@section('content')

    <script>
        $(function(){
            $.ajax({
                url: 'http://localhost/api/get_timeline',
                type:'GET',
            }).done(function(data){
                if(data['lists']){
                    // 要素数を取得
                    var length = Object.keys(data['lists']).length;
                    for( i = 1; i < length; i++){

                    }

                }else{
                    console.log('false');
                }
            });
        });
    </script>

    <div class="container">
        <div class="row justify-content-center">
                    <div class="col-md-8 mb-3">
                        <div class="card">
                            <div class="card-haeder p-3 w-100 d-flex">
                                <img src="" class="rounded-circle" width="50" height="50">
                                <div class="ml-2 d-flex flex-column">
                                    <p class="mb-0"></p>
                                    <a href="{{ url('users/' .$timeline->user->id) }}" class="text-secondary">{{ $timeline->user->screen_name }}</a>
                                </div>
                                <div class="d-flex justify-content-end flex-grow-1">
                                    <p class="mb-0 text-secondary">{{ $timeline->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! nl2br(e($timeline->text)) !!}
                            </div>
                            <div class="card-footer py-1 d-flex justify-content-end bg-white">
                                @if ($timeline->user->id === Auth::user()->id)
                                    <div class="dropdown mr-3 d-flex align-items-center">
                                        <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-fw"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <form method="POST" action="{{ url('tweets/' .$timeline->id) }}" class="mb-0">
                                                @csrf
                                                @method('DELETE')

                                                <a href="{{ url('tweets/' .$timeline->id .'/edit') }}" class="dropdown-item">編集</a>
                                                <button type="submit" class="dropdown-item del-btn">削除</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                                <div class="mr-3 d-flex align-items-center">
                                    <a href="{{ url('tweets/' .$timeline->id) }}"><i class="far fa-comment fa-fw"></i></a>
                                    <p class="mb-0 text-secondary">{{ count($timeline->comments) }}</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <button type="" class="btn p-0 border-0 text-primary"><i class="far fa-heart fa-fw"></i></button>
                                    <p class="mb-0 text-secondary">{{ count($timeline->favorites) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="my-4 d-flex justify-content-center">
            {{ $timelines->links() }}
        </div>
    </div>
@endsection
