@props(['activePage' => 'dashboard', 'title' => 'Admin Console - EVENTFLARE'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-dashboard.css') }}">

    @stack('styles')
</head>
<body class="dashboard-body">
    <!-- Admin Sidebar Component -->
    <x-admin-sidebar :activePage="$activePage" />

    <!-- Main Content Stage -->
    <main class="dashboard-content">
        <x-flash-message />

        {{ $slot ?? '' }}
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
