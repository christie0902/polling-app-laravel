<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\Option;
use App\Models\PollResponse;

class PollController extends Controller
{
    public function displayAll()
    {
        $polls = Poll::with(['options', 'user'])->get();
        return view('homepage', compact('polls'));
    }

    public function edit($id = null)
    {
        if ($id) {
            $poll = Poll::with('options')->findOrFail($id);
        } else {
            $poll = new Poll;
        }
    
        return view('polls.edit', compact('poll'));
    }




    public function save( Request $request, $id = null)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'question' => 'required',
            'options' => 'required|array',
            'options.*' => 'required|string|max:255',
        ], [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'description.string' => 'The description must be a string.',
            'question.required' => 'The question field is required.',
            'options.required' => 'You must provide at least one option.',
            'options.array' => 'The options must be provided in an array.',
            'options.*.required' => 'Each option must have a value.',
            'options.*.string' => 'Each option must be a string.',
            'options.*.max' => 'Each option may not be greater than 255 characters.',
        ]);

        $data = $request->all();

        $poll = null;

        $poll = $id ? Poll::findOrFail($id) : new Poll;
        
        $poll->title = $data['title'];
        $poll->description = $data['description'];
        $poll->question =  $data['question'];
        $poll->user_id = auth()->id();
        $poll->save();

        // Remove all existing options if editing an existing poll
        if($id) {
            $poll->options()->delete();
        }

        foreach ($data['options'] as $optionValue) {
            $poll->options()->create(['value' => $optionValue]);
        }

        session()->flash('success_message', 'Poll data saved');

        return redirect()->back()->with('success_message', 'Poll data saved');
    }

    public function myPolls()
    {   
        $user_id = auth()->id();
        $mypolls = Poll::with(['options', 'user'])->where('user_id', $user_id)->get();
        return view('polls.mypolls', compact('mypolls'));
    }

    public function respond(Request $request, $pollId)
    {
        $user = auth()->user();

        $options = $request->input('options');

        foreach ($options as $optionId) {
            PollResponse::create([
                'user_id' => $user->id,
                'poll_id' => $pollId,
                'option_id' => $optionId,
            ]);
        }

        return redirect()->route('home')->with('success_message', 'Response submitted successfully.');
    }

    public function results($pollId)
    {
        $poll = Poll::with('options.responses')->findOrFail($pollId);
        
        $results = [];
        foreach ($poll->options as $option) {
            $results[$option->id] = [
                'value' => $option->value,
                'count' => $option->responses->count(),
            ];
        }
        
        return view('polls.results', compact('poll', 'results'));
    }

    // public function hasResponded($id = null)
    // {
    // $poll = Poll::with('options.responses')->findOrFail($id);
    // $userId = auth()->id();
    
    // $hasResponded = false;
    // foreach ($poll->options as $option) {
    //     if ($option->responses()->where('user_id', $userId)->exists()) {
    //         $hasResponded = true;
    //         break; 
    //     }
    // }

    // return view('polls.edit', compact('poll', 'hasResponded'));
    // }
}
