@extends('layouts.app')



@section('content')

    <script>
        $(function(){
            $('.submit-button').click(function(){
                var token = "{{ $token }}";
                var tweet = $('.form-control').serialize();
                $.ajax({
                    url: 'http://localhost/api/post_tweet?api_token=' + token,
                    type: 'POST',
                    data: tweet,
                }).done(function(tweet){
                    if(tweet){
                        $('.before_tweet').css({'display':'none'});
                        $('.after_tweet').css({'display':'block'});
                    }else{
                        $('.failed_tweet').css({'display':'block'});
                    }
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
                                    <textarea class="form-control @error('text') is-invalid @enderror" name="text" required autocomplete="text" rows="4">{{ old('text') }}</textarea>

                                    @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
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
                                <button type="button" class="btn btn-primary submit-button">
                                    タイムラインをみる
                                </button>
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
                                <button type="button" class="btn btn-primary submit-button">
                                    投稿画面に戻る
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

