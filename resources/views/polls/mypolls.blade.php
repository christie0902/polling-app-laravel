@extends('layouts.home', [
    'current_page' => 'mypolls'
])

@section('content')
@if($mypolls->isNotEmpty())
    <div class="poll-container">
        @foreach($mypolls as $poll)
            <div class="poll">
                <h2>{{$poll->title}}</h2>
                <p>{{$poll->description}}</p>
                <p>Question: {{$poll->user->question}}</p>
                <div class="options">
                    @foreach($poll->options as $option)
                        <div class="checkbox">
                            <li> {{$option->value}}</li>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('poll.edit', $poll->id) }}" style="font-weight:bold; margin-left:5px;">Edit</a>
        
            </div>
        @endforeach
    </div>
    @endif
@endsection