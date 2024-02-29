@extends('layouts.home', [
    'current_page' => 'edit'
])

@section('content')
    @if (Session::has('success_message'))
        <div class="alert alert-success">
            {{ Session::get('success_message') }}
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="poll-form">
        <h1>{{ isset($poll->id) ? 'Edit Poll' : 'Create Poll' }}</h1>
        <form method="POST" action="{{ isset($poll->id) ? route('polls.update', $poll->id) : route('polls.store') }}">
            @csrf
            @if(isset($poll->id))
                @method('PUT')
            @endif

            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="{{ old('title', $poll->title ?? '') }}" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description">{{ old('description', $poll->description ?? '') }}</textarea>

            <label for="question">Question:</label>
            <textarea name="question" id="question">{{ old('question', $poll->question ?? '') }}</textarea>

            <fieldset>
                <legend>Options</legend>
                <div id="options-container">
                    @forelse($poll->options ?? [] as $index => $option)
                        <div class="option">
                            <input type="text" name="options[]" value="{{ $option->value }}" required>
                        </div>
                    @empty
                        <div class="option">
                            <input type="text" name="options[]" value="" placeholder="Option 1" required>
                        </div>
                    @endforelse
                </div>
                <button type="button" id="add-option">Add Option</button>
            </fieldset>

            <button type="submit">{{ isset($poll->id) ? 'Update' : 'Create' }}</button>
        </form>
    </div>

<script>
    document.getElementById('add-option').addEventListener('click', function() {
        const container = document.getElementById('options-container');
        const option = document.createElement('div');
        option.className = 'option';
        option.innerHTML = '<input type="text" name="options[]" value="" required>';
        container.appendChild(option);
    });
</script>
@endsection