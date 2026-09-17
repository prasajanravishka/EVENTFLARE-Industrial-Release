@extends('layouts.eventflare')

@section('title', $config['page_title'] ?? 'Five-Star Hotel Venues & Galas — EVENTFLARE')

@section('content')
    @include('events.showcase-template')
@endsection