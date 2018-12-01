@extends('layouts.app')
@section('content')

    {{--由于 插件不支持bootstrap4 只能先加载3 在加载4 进行覆盖--}}
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                <div class="panel panel-defa11ult">
                    <div class="panel-heading">
                        create a question
                    </div>
                    <div class="panel-body">

                        <form action=" /questions/{{$question->id}}" method="post">
                            {{method_field('patch')}}
                            {!! csrf_field() !!}
                            <div class="form-group" >
                                <label for="title">title</label>
                                <input  type="text" name="title" class="form-control  {{ $errors->has('title') ? 'is-invalid' : '' }} " placeholder="title" value="{{ $question->title }}">

                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <select name="topics[]" class="js-example-placeholder-multiple js-data-example-ajax form-control" name="states[]" multiple="multiple">
                                    @foreach($question->topics as $topic)
                                        <option value="{{$topic->id}}" selected>{{$topic->name}}</option>
                                    @endforeach
                                    {{--<option value="WY">Wyoming</option>--}}
                                </select>
                            </div>

                            <!-- 编辑器容器 -->
                            <div class="form-group {{ $errors->has('body') ? 'is-invalid' : '' }} " >
                                <label for="body">Description</label>
                                <script id="container"   name="body" type="text/plain" >{!!  $question->body !!}</script>
                            </div>


                            @if ($errors->has('body'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                            @endif
                            <button class="btn btn-success pull-right" type="submit">submit</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    {{--@section('js')--}}
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container',{
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode:true,
            wordCount:false,
            imagePopup:false,
            autotypeset:{ indent: true,imageBlockLine: 'center' }
        });
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });


        $(document).ready(function() {
            // $('.js-example-basic-multiple').select2();
            $(".js-example-placeholder-multiple").select2({

                tags: true,

                placeholder: 'relevant  topics',

                minimumInputLength: 2,

                ajax: {

                    url: '/api/topics',

                    dataType: 'json',

                    delay: 250,

                    data: function (params) {

                        return {

                            q: params.term

                        };

                    },

                    processResults: function (data, params) {
                        console.log(data);
                        return {

                            results: data

                        };

                    },

                    cache: true

                },

                templateResult: formatTopic,

                templateSelection: formatTopicSelection,

                escapeMarkup: function (markup) { return markup; }

            });
        });

        function formatTopic (topic) {

            return "<div class='select2-result-repository clearfix'>" +

            "<div class='select2-result-repository__meta'>" +

            "<div class='select2-result-repository__title'>" +

            topic.name ? topic.name : "Laravel"   +

                "</div></div></div>";

        }


        function formatTopicSelection (topic) {

            return topic.name || topic.text;

        }

    </script>
    {{--@endsection--}}

    <style>
        #container{
            height: 40vh;
        }
    </style>

@endsection