@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="panel panel-default">
      <div class="panel-heading">{{ $topic->title }} - (<a href="#">{{ $topic->channel->name }}</a>)</div>
        <div class="panel-body">
          {{ $topic->body }}
        </div>
      </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">{{ $topic->user->getNameOrUsername() }}</div>
        <div class="panel-body">
          {{ $topic->created_at->diffForHumans() }}
          @if (Auth::check())
              @if ($topic->user_id == Auth::user()->id)
                  <a href="{{ route('topics.edit', $topic->slug) }}">Edit Topik</a>
              @endif
          @endif
        </div>
    </div>
  </div>
</div>
@endsection
