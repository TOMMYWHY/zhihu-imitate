@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{$question->title}}
                        @foreach($question->topics as $topic)
                            <a  href="/topic/{{$topic->id}}" class="topic_a pull-right">{{$topic->name}}</a>
                        @endforeach
                    </div>

                    <div class="card-body">
                        {!! $question->body !!}
                    </div>
                    <div class="actions">
                        @if(Auth::check()&&Auth::user()->owns($question))
                        <span class="edit"><a class="btn btn-success" href="/questions/{{$question->id}}/edit">edit</a></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection()