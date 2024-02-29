@extends('layouts.home', [
    'current_page' => 'home'
])

@section('content')
<h1 class="welcome">WELCOME

    @auth
       BACK {{ auth()->user()->name }}
    @endauth

    TO OUR POLLS</h1>
    <p>You can create your polls, manage them and join other polls!</p>

    @auth
    <a href="{{ route('poll.edit') }}" class="create-poll-link">CREATE POLL</a>
    @endauth

    @if($polls->isNotEmpty())
    <div class="poll-container">
        @foreach($polls as $poll)
        
        <div class="poll">
            <form action="{{ route('polls.respond', ['poll_id'=>$poll->id]) }}" method="POST">
                    @csrf
                <h2>{{$poll->title}}</h2>
                <p>{{$poll->description}}</p>
                <p>Creator: {{$poll->user->name}}</p>
                <p>Question: {{$poll->question}}</p>
                <div class="options">
                    @foreach($poll->options as $option)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="options[]" value="{{$option->id}}"> {{$option->value}}
                            </label>
                        </div>
                    @endforeach
                </div>
                <button class="btn-primary">Submit</button>
            </form>
            @if(auth()->id() == $poll->user_id)
            <a href="{{ route('poll.edit', $poll->id) }}" style="font-weight:bold; margin-left:5px;">Edit</a>
            @endif
        </div>
       
        
        @endforeach
    </div>
    @endif

@endsection