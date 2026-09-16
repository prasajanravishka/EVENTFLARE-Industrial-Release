<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Supplier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupplierAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;
    public Supplier $supplier;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, Supplier $supplier)
    {
        $this->booking = $booking;
        $this->supplier = $supplier;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "EVENTFLARE: New Event Opportunity - Booking #{$this->booking->BookingID}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.suppliers.assigned',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
