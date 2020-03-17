@extends('layouts.app')



@section('content')

    <script>
        $(function(){
            $('.submit-button').click(function(){
                var token = "{{ $token }}";
                var tweet = $('.form-control').val();
<<<<<<< Updated upstream
                if(tweet === ""){
                    $('.error_message').text('空欄はダメだよ');
                }else {
=======
                console.log(tweet);
>>>>>>> Stashed changes
                    $.ajax({
                        url: 'http://localhost/api/post_tweet',
                        type: 'POST',
                        data: { text:tweet, api_token:"{{$token}}"},
                    }).done(function (tweet) {
                        if (tweet) {
                            $('.before_tweet').css({'display': 'none'});
                            $('.after_tweet').css({'display': 'block'});
                        }
                    }).fail(function () {
                        $('.before_tweet').css({'display': 'none'});
                        $('.failed_tweet').css({'display': 'block'});
                    });
                });
             });
    </script>

    <div class="container">
        <div class="row justify-content-center before_tweet">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">ツイート</div>

                    <div class="card-body">
                        <form>
                            @csrf

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <textarea class="form-control" name="text" required autocomplete="text" rows="4">{{ old('text') }}</textarea>


                                    <span role="alert">
                                        <strong class="error_message alert-danger"></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12 text-right">
                                    <p class="mb-4 text-danger">140文字以内</p>
                                    <button type="button" class="btn btn-primary submit-button">
                                        ツイートする
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center after_tweet" style="display: none">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">ツイート完了</div>

                    <div class="card-body">
                        <div class="form-group row mb-0 text-center">
                            <div class="col-md-12 text-center">
                            <p>ツイートの投稿が完了しました</p>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                    <a href="#" class="btn btn-primary submit-button">タイムラインをみる</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center failed_tweet" style="display: none">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">ツイート失敗</div>

                    <div class="card-body">
                        <div class="form-group row mb-0 text-center">
                            <div class="col-md-12 text-center">
                                <p>ツイートの投稿に失敗しました</p>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <a href="/tweet" class="btn btn-primary submit-button">投稿画面に戻る</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

