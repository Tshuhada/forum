@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9">
          @if (!$topics->count())
              <p class="lead">Maaf! Topik Saat Ini Tidak Ada</p>
          @endif

          @foreach ($topics as $topic)
              <div class="media">
                <a href="" class="pull-left">
                  <img src="{{ $topic->user->getAvatar() }}" alt="{{ $topic->user->username }}" class="media-object img-circle">
                </a>
                <div class="media-body">
                  <div class="media-heading"><a href="/topics/{{ $topic->slug}}">{{ $topic->title }}</a></div>
                  <p>{{ $topic->created_at->diffForHumans() }} By <a href="#">{{ $topic->user->getNameOrUsername() }}</a></p>
                </div>
              </div>
          @endforeach
        </div>
    </div>
@endsection
