<x-mail::message>
# New Client Booking Assignment

Hello **{{ $supplier->business_name }}**,

Great news! An event planner has selected your services or an administrator has assigned your accredited team to support a booking:

* **Booking Reference**: `#{{ $booking->BookingID }}`
* **Event Type**: {{ $booking->event_type_name }}
* **Event Date**: {{ \Carbon\Carbon::parse($booking->EventDate)->format('l, F j, Y') }}
* **Guest Headcount**: {{ number_format($booking->Guest_count) }} people
* **Venue Location**: {{ $booking->location ?? 'To be coordinated' }}

<x-mail::button :url="route('supplier.dashboard')">
View Supplier Dashboard
</x-mail::button>

Please log in to your vendor command portal to review specifications, coordinate logistics, and contact the client or event administrator if necessary.

Thank you for delivering excellence on EVENTFLARE!

Warm regards,<br>
The {{ config('app.name') }} Supplier Relations Desk
</x-mail::message>
