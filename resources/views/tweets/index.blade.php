@extends('layouts.app')

@section('content')

    <script>
        $(function(){
            $.ajax({
                url: 'http://localhost/api/get_timeline',
                type:'GET',
            }).done(function(data){
                var length = Object.keys(data['lists']).length;
                console.log(length);
                if(data['lists']){
                    for(n = 0; n < length; n++){
                        var template = $($('#template').html());
                        $('.justify-content-center').append(template);
                        $('.profile_image').attr('src','storage/profile_image/' + data['lists'][n].profile_image);
                        $('.user_name').text(data['lists'][n].name);
                        $('.screen_name').text(data['lists'][n].screen_name);
                        $('.created_at').text(data['lists'][n].created_at);
                        $('.text').text(data['lists'][n].text);
                    }
                }else{
                    console.log('false');
                }
            });
        });
    </script>

    <div class="container">
        <div class="row justify-content-center">
            <template id="template">
                <div class="col-md-8 mb-3">
                    <div class="card">
                        <div class="card-header p-3 w-100 d-flex">
                            <img src="" class="rounded-circle profile_image" width="50" height="50">
                            <div class="ml-2 d-flex flex-column">
                                <p class="mb-0 user_name"></p>
                                <a href="" class="text-secondary screen_name"></a>
                            </div>
                            <div class="d-flex justify-content-end flex-grow-1">
                                <p class="mb-0 text-secondary created_at"></p>
                            </div>
                        </div>
                        <div class="card-body text">
                        </div>
                        <div class="card-footer py-1 d-flex justify-content-end bg-white">
{{--                            @if ($timeline->user->id === Auth::user()->id)--}}
{{--                                <div class="dropdown mr-3 d-flex align-items-center">--}}
{{--                                    <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                        <i class="fas fa-ellipsis-v fa-fw"></i>--}}
{{--                                    </a>--}}
{{--                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">--}}
{{--                                        <form method="POST" action="{{ url('tweets/' .$timeline->id) }}" class="mb-0">--}}
{{--                                            @csrf--}}
{{--                                            @method('DELETE')--}}

{{--                                            <a href="{{ url('tweets/' .$timeline->id .'/edit') }}" class="dropdown-item">編集</a>--}}
{{--                                            <button type="submit" class="dropdown-item del-btn">削除</button>--}}
{{--                                        </form>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
                            <div class="mr-3 d-flex align-items-center">
                                <a href="#"><i class="far fa-comment fa-fw"></i></a>
                                <p class="mb-0 text-secondary"></p>
                            </div>
                            <div class="d-flex align-items-center">
                                <button type="" class="btn p-0 border-0 text-primary"><i class="far fa-heart fa-fw"></i></button>
                                <p class="mb-0 text-secondary"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <div class="my-4 d-flex justify-content-center">
{{--            {{ $timelines->links() }}--}}
        </div>
    </div>
@endsection
