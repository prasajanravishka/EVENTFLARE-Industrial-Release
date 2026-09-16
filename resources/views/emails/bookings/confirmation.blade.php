<x-mail::message>
# Booking Confirmation

Dear **{{ $booking->user->full_name ?? $booking->user->username }}**,

Thank you for choosing **EVENTFLARE** to curate your special occasion! We have successfully registered your booking and our event coordinating team is reviewing the specifications.

### Reservation Summary
* **Booking Reference**: `#{{ $booking->BookingID }}`
* **Event Type**: {{ $booking->event_type_name }}
* **Scheduled Date**: {{ \Carbon\Carbon::parse($booking->EventDate)->format('F j, Y') }}
* **Guests Expected**: {{ number_format($booking->Guest_count) }} people
* **Venue Location**: {{ $booking->location ?? 'To be specified' }}
* **Current Status**: **{{ strtoupper($booking->status) }}**

<x-mail::button :url="route('bookings.show', $booking->BookingID)">
View Full Booking Dossier
</x-mail::button>

If you need to make any alterations to your guest numbers or services schedule, you can manage your reservation directly through your client portal or contact our concierge desk.

Best regards,<br>
The {{ config('app.name') }} Operations Team
</x-mail::message>
