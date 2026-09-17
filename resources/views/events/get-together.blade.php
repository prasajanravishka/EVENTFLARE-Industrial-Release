@extends('layouts.eventflare')

@section('title', $config['page_title'] ?? 'Social Mixers, Batch Reunions & Lawn BBQs — EVENTFLARE')

@section('content')
    @include('events.showcase-template')
@endsection