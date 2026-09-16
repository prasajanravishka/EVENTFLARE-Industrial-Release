<x-mail::message>
# Booking Status Update

Dear **{{ $booking->user->full_name ?? $booking->user->username }}**,

Your booking **#{{ $booking->BookingID }}** for **{{ $booking->event_type_name }}** has been updated to:

<x-mail::panel>
### New Status: {{ strtoupper($booking->status) }}
@if($oldStatus)
*(Previous status: {{ strtoupper($oldStatus) }})*
@endif
</x-mail::panel>

* **Event Date**: {{ \Carbon\Carbon::parse($booking->EventDate)->format('F j, Y') }}
* **Location**: {{ $booking->location ?? 'To be confirmed' }}
* **Expected Attendance**: {{ number_format($booking->Guest_count) }} guests

<x-mail::button :url="route('bookings.show', $booking->BookingID)">
Review Updated Reservation
</x-mail::button>

If you have questions or need assistance regarding your event coordination, our support team is available 24/7.

Regards,<br>
The {{ config('app.name') }} Team
</x-mail::message>
