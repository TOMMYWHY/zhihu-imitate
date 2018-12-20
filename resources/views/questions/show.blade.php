@extends('layouts.app')
@section('content')
    @include('vendor.ueditor.assets')

    <div  class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{$question->title}}
                        @foreach($question->topics as $topic)
                            <a href="/topic/{{$topic->id}}" class="topic_a pull-right">{{$topic->name}}</a>

                        @endforeach
                    </div>

                    <div class="card-body">
                        {!! $question->body !!}
                    </div>
                    <div class="actions">
                        @if(Auth::check()&&Auth::user()->owns($question))
                            <span class="edit"><a class="btn btn-success"
                                                  href="/questions/{{$question->id}}/edit">edit</a></span>
                            <form method="post" class="delete-form" action="/questions/{{$question->id}}">
                                {{method_field('delete')}}
                                {{csrf_field()}}
                                <button class="btn btn-danger">
                                    DETETE
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-default">
                    <div class="card-heading question-follow">
                        <h2>{{$question->followers_count}}</h2>
                        <span> Followers</span>
                    </div>
                    <div class="card-body">

                        <question-follow-button  question="{{$question->id}}" user="{{Auth::id()}}">

                        </question-follow-button>
                        <a href="#editor" class="btn btn-primary">ceate your answers</a>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <hr>
        <br>

        <div class="row justify-content-center">
            {{--answers--}}
            <div class="col-md-8 col-md-offset-1">
                <div class="card">
                    <div class="card-header">

                        Answer Counts: {{$question->answers_count}}

                    </div>

                    <div class="card-body">
                        @foreach($question->answers as $answer)
                            <div class="media">
                                <div class="media-left">
                                    <a href="">
                                        <img width="48px" src="{{$answer->user->avatar}}"
                                             alt="{{$answer->user->name}}">{{$answer->user->name}}
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="/questions/{{$answer->id}}">
                                            {!!$answer->body  !!}
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        @endforeach


                        <hr>


                        @if(Auth::check())

                            <form action="/questions/{{$question->id}}/answer" method="post">
                            {!! csrf_field() !!}

                            <!-- 编辑器容器 -->
                                <div class="form-group {{ $errors->has('body') ? 'is-invalid' : '' }} ">
                                    <label for="body">Answer</label>
                                    <script id="container" name="body" type="text/plain">{!!  old('body') !!}</script>
                                </div>
                                @if ($errors->has('body'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                                <button class="btn btn-success pull-right" type="submit">submit your answer</button>

                            </form>
                        @else
                            <a href="{{url('login')}}" class="btn btn-success btn-block"> Login</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-default">
                    <div class="card-heading question-follow">
                        <h5>About User</h5>
                    </div>
                    <div class="card-body">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="img-thumbnail" src="{{$question->user->avatar}}" alt="">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="">
                                        {{$question->user->name}}
                                    </a>
                                </h4>
                            </div>
                            <div class="user-statics">
                                <div class="statics-item text-center">
                                    <div class="statics-text">Question</div>
                                    <div class="statics-count">{{$question->user->questions_count}}</div>

                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">Answer</div>
                                    <div class="statics-count">{{$question->user->answers_count}}</div>

                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">Question</div>
                                    <div class="statics-count">{{$question->user->followers_count}}</div>

                                </div>

                            </div>

                        </div>
                       {{-- <user-follow-button  user="{{$question->user->id}}">
                        </user-follow-button>--}}
                        <a href="#editor" class="btn btn-primary pull-right">send a message</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{--@section('js')--}}
    <script type="application/javascript" src="//code.jquery.com/jquery.js"></script>
    <script type="application/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


    <!-- 实例化编辑器 -->
    <script type="text/javascript">

        // app({
        //     methods: {
        //         say: function (message) {
        //             alert(message)
        //         }
        //     },
        // });



        var ue = UE.getEditor('container', {
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft', 'justifycenter', 'justifyright', 'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode: true,
            wordCount: false,
            imagePopup: false,
            autotypeset: {indent: true, imageBlockLine: 'center'}
        });
        ue.ready(function () {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
    {{--@endsection--}}

    <style>
        #container {
            height: 40vh;
        }
    </style>



@endsection()