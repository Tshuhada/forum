<?php

namespace App\Http\Controllers;
use Auth;
use App\Channel;
use App\Topic;
use App\Http\Requests\TopicRequest;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function create()
    {
        $channels = Channel::all();

        return view ('topics.create', compact('channels'));
    }

    public function store(TopicRequest $request)
    {
        Auth::user()->topics()->create([
            'title' => $request->title,
            'slug' => str_slug($request->title),
            'channel_id' => $request->channel,
            'body' => $request->body,
        ]);

        $request->session()->flash('status', 'Topik Anda Telah Dibuat');
        return back();
    }

    public function index()
    {
        $topics = Topic::latest()->get();
        return view('topics.index', compact('topics'));
    }

    public function show($slug)
    {
        $topic = Topic::whereSlug($slug)->first();
        if (!$topic) {
            return redirect()->to('/topics');
        }
        return view('topics.show', compact('topic'));
    }

    public function edit($slug)
    {
        $topic = Topic::whereSlug($slug)->first();
        if (!$topic) {
            return redirect()->to('/topics');
        }
        if (Auth::user()->id == $topic->user_id) {
            $channels = Channel::all();
            return view('topics.edit', compact('topic', 'channels'));
        }else{
            return redirect()->to("/topics/{$slug}");
        }
    }

    public function update(Request $request, $slug)
    {
        $topic = Topic::whereSlug($slug)->first();
        if (!$topic) {
            return redirect()->to('/topics');
        }
        $slug = str_slug($topic->title);
        if ($request->user()->id == $topic->user_id) {
            $this->validate($request, [
              'title' => 'required|max:255|min:3|unique:topics,title,' . $topic->id,
              'body' => 'required',
              'channel' => 'required'
            ]);
            $topic->update([
              'title' => $request->title,
              'slug' => $slug,
              'body' => $request->body,
              'channel_id' => $request->channel,
            ]);
            $request->session()->flash('status', 'Topik Anda Telah Diperbarui');
            return redirect()->to("/topics/" . $slug);
        } else {
            $request->session()->flash('status', 'Maaf Ini Bukan Topik Anda');
            return redirect()->to('/topics');
        }
    }
}
