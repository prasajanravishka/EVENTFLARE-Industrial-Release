@extends('layouts.eventflare')

@section('title', $config['page_title'] ?? 'Royal Weddings & Poruwa Ceremonies — EVENTFLARE')

@section('content')
    @include('events.showcase-template')
@endsection