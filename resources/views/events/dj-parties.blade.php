@extends('layouts.eventflare')

@section('title', $config['page_title'] ?? 'DJ Parties, Club Raves & Audio-Visual Production — EVENTFLARE')

@section('content')
    @include('events.showcase-template')
@endsection