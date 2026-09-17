@extends('layouts.eventflare')

@section('title', $config['page_title'] ?? 'Birthdays & Milestone Celebrations — EVENTFLARE')

@section('content')
    @include('events.showcase-template')
@endsection