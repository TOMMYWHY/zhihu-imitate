@extends('layouts.app')
@section('content')
@include('vendor.ueditor.assets')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        create a question
                    </div>
                    <div class="panel-body">

                        <form action="{{route('questions.store')}}" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group" >
                                <input  type="text" name="title" class="form-control  {{ $errors->has('title') ? 'is-invalid' : '' }} " placeholder="title" value="{{ old('title') }}">

                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <!-- 编辑器容器 -->
                            <div class="form-group {{ $errors->has('body') ? 'is-invalid' : '' }} ">
                                <script id="container" name="body" type="text/plain">
                                    {!!  old('body') !!}
                                </script>


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


<!-- 实例化编辑器 -->
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
    });
</script>

<!-- 编辑器容器 -->
<script id="container" name="content" type="text/plain"></script>



@endsection()