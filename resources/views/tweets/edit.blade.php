@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-3 tweet_edit">
                <div class="card">
                    <div class="card-haeder p-3 w-100 d-flex">
                        <img src="{{ $profile_image }}" class="rounded-circle" width="50" height="50">
                        <div class="d-flex" style="padding-left:10px">
                            <p class="mb-0" style="padding-right:10px">{{ $name }}</p>
                            <p class="text-secondary">{{ $screen_name }}</p>
                        </div>
                        <div class="d-flex justify-content-end flex-grow-1">
                            <p class="mb-0 text-secondary">{{ $created_at }}</p>
                        </div>
                    </div>
                    <div class="card-body tweet_text">
                        {!! nl2br(e($text)) !!}
                    </div>
                    <div class="card-footer py-1 d-flex justify-content-end bg-white">
                        <div class="d-flex align-items-center">
                            <i class="far fa-heart fa-fw btn p-0 border-0 text-primary"></i>
                            <p class="mb-0 text-secondary">{{ $favorite_count }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9 tweet_edit">
                <div class="card">
                    <div class="card-header">ツイート編集</div>

                    <div class="card-body">
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <span role="alert">
                                    <strong class="error_message alert-danger"></strong>
                                </span>
                                <textarea class="form-control" name="text" required autocomplete="text" rows="4">{{ $text }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-right">
                                <p class="mb-4 text-danger">140文字以内</p>
                                <button type="button" class="btn btn-danger delete_button">
                                    削除する
                                </button>
                                <button type="button" class="btn btn-primary update_button" data-tweet="{{$tweet_id}}">
                                    更新する
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center delete_confirm" style="display: none">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">ツイート削除確認</div>

                    <div class="card-body">
                        <div class="form-group row mb-0 text-center">
                            <div class="col-md-12 text-center">
                                <p>ツイートを削除しますか？</p>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-danger cancel_button">
                                    キャンセル
                                </button>
                                <button type="button" class="btn btn-primary delete_confirm_button" data-tweet="{{$tweet_id}}">
                                    削除する
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center after_update" style="display: none">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">ツイート更新完了</div>

                    <div class="card-body">
                        <div class="form-group row mb-0 text-center">
                            <div class="col-md-12 text-center">
                                <p>ツイートの更新が完了しました</p>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <a href="/" class="btn btn-primary submit-button">一覧へ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center update_failed" style="display: none">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">ツイート更新失敗</div>

                    <div class="card-body">
                        <div class="form-group row mb-0 text-center">
                            <div class="col-md-12 text-center">
                                <p>ツイートの更新に失敗しました</p>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <a href="{{ url('tweet/'.$tweet_id.'/edit') }}" class="btn btn-primary submit-button">編集画面へ戻る</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center after_delete" style="display: none">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">ツイート削除完了</div>

                    <div class="card-body">
                        <div class="form-group row mb-0 text-center">
                            <div class="col-md-12 text-center">
                                <p>ツイートを削除しました</p>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <a href="#" class="btn btn-primary submit-button">プロフィールへ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center delete_failed" style="display: none">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">ツイート削除失敗</div>

                    <div class="card-body">
                        <div class="form-group row mb-0 text-center">
                            <div class="col-md-12 text-center">
                                <p>ツイートの削除に失敗しました</p>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <a href="{{ url('tweet/'.$tweet_id.'/edit') }}" class="btn btn-primary submit-button">編集画面に戻る</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(function(){
            $('.delete_button').click(function(){
                $('.delete_confirm').css({'display': 'block'});
                $('.tweet_edit').css({'display': 'none'});

                $('.cancel_button').click(function(){
                    $('.delete_confirm').css({'display': 'none'});
                    $('.tweet_edit').css({'display': 'block'});
                });

                $('.delete_confirm_button').click(function(){
                    let tweet_id = $(this).data('tweet');
                    let api_token = "{{ $api_token }}";
                    $.ajax({
                        url:'/api/tweet/' + tweet_id ,
                        type:'DELETE',
                        data:{
                            api_token: api_token
                        }
                    }).done(function(){
                        $('.delete_confirm').css({'display': 'none'});
                        $('.after_delete').css({'display': 'block'});

                    }).fail(function () {
                        $('.delete_confirm').css({'display': 'none'});
                        $('.delete_failed').css({'display': 'block'});
                    });
                });
            });

            $('.update_button').click(function(){
                let text = $('.form-control').val();
                let tweet_id = $(this).data('tweet');
                let api_token = "{{ $api_token }}";
                $.ajax({
                    url:'/api/tweet/' + tweet_id,
                    data:{
                        text:text,
                        api_token:api_token
                    },
                    type:'PUT'
                }).done(function(data){
                    if(data['result']===true){
                        $('.tweet_edit').css({'display': 'none'});
                        $('.after_update').css({'display': 'block'});
                    }else　if(data['result'] === false){
                        $('.error_message').text(data['errors']['text']);
                    }
                }).fail(function(){
                    $('.tweet_edit').css({'display': 'none'});
                    $('.update_failed').css({'display': 'block'});
                });
            });
        });
    </script>

@endsection
