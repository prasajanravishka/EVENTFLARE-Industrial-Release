<?php

namespace Tests\Feature;

use App\Mail\BookingConfirmationMail;
use App\Mail\BookingStatusUpdatedMail;
use App\Mail\NewContactInquiryMail;
use App\Mail\SupplierAssignedMail;
use App\Models\Booking;
use App\Models\EventType;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailNotificationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
    public function test_booking_confirmation_email_is_sent_on_new_booking(): void
    {
        Mail::fake();

        $buyer = User::factory()->create([
            'role' => 'buyer',
            'email' => 'client_notify@eventflare.lk',
        ]);

        $response = $this->actingAs($buyer)->post('/book', [
            'EventType' => 'Weddings',
            'Place' => 'Mount Lavinia Hotel',
            'NumberOfGuests' => 150,
            'EventDate' => now()->addDays(40)->format('Y-m-d'),
            'DayNight' => 'Night',
            'FoodPreferences' => 'High price',
            'ExtraDetails' => 'Sea view lawn setup required.',
        ]);

        $response->assertRedirect('/my-bookings');

        Mail::assertSent(BookingConfirmationMail::class, function ($mail) use ($buyer) {
            return $mail->hasTo('client_notify@eventflare.lk') &&
                   $mail->booking->EventType === 'Weddings';
        });
    }

    public function test_booking_status_updated_email_is_sent_to_client(): void
    {
        Mail::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $buyer = User::factory()->create(['role' => 'buyer', 'email' => 'customer_status@eventflare.lk']);

        $booking = Booking::create([
            'BookingID' => 'BK_MAIL_TEST_' . time(),
            'user_id' => $buyer->id,
            'user_name' => $buyer->username,
            'EventType' => 'Birthday',
            'EventDate' => now()->addDays(10)->toDateString(),
            'NumberOfGuests' => 50,
            'Guest_count' => 50,
            'DayNight' => 'Night',
            'FoodPreferences' => 'Medium price',
            'Place' => 'Colombo',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->patch("/admin/bookings/{$booking->BookingID}/status", [
            'status' => 'confirmed',
        ]);

        $response->assertRedirect();

        Mail::assertSent(BookingStatusUpdatedMail::class, function ($mail) use ($buyer, $booking) {
            return $mail->hasTo('customer_status@eventflare.lk') &&
                   $mail->booking->BookingID === $booking->BookingID &&
                   $mail->booking->status === 'confirmed';
        });
    }

    public function test_contact_inquiry_email_is_sent_to_admin(): void
    {
        Mail::fake();

        $response = $this->post('/contact', [
            'firstname' => 'Kasun',
            'lastname' => 'Perera',
            'email' => 'kasun.p@example.com',
            'phone' => '+94771234567',
            'message' => 'We need an urgent quote for a 200-guest wedding.',
        ]);

        $response->assertRedirect();

        Mail::assertSent(NewContactInquiryMail::class, function ($mail) {
            return $mail->contactMessage->email === 'kasun.p@example.com' &&
                   $mail->contactMessage->firstname === 'Kasun';
        });
    }

    public function test_supplier_assigned_email_is_sent(): void
    {
        Mail::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $buyer = User::factory()->create(['role' => 'buyer']);

        $supplierUser = User::factory()->create([
            'role' => 'supplier',
            'email' => 'vendor_assigned@eventflare.lk',
        ]);

        $supplier = Supplier::create([
            'user_id' => $supplierUser->id,
            'business_name' => 'Galle Face Sound & Lights',
            'category' => 'Sound & Lighting',
            'contact_number' => '+94719998877',
            'is_active' => true,
        ]);

        $eventType = EventType::create([
            'type_name' => 'Music Festival',
            'description' => 'Outdoor music concert',
            'is_active' => true,
        ]);

        $service = Service::create([
            'event_type_id' => $eventType->event_type_id,
            'service_name' => 'Stage Audio System',
            'description' => 'Professional line array audio systems',
            'priority_rank' => 1,
            'is_required' => true,
        ]);

        $booking = Booking::create([
            'BookingID' => 'BK_ASSIGN_TEST_' . time(),
            'user_id' => $buyer->id,
            'user_name' => $buyer->username,
            'EventType' => 'Music Festival',
            'EventDate' => now()->addDays(25)->toDateString(),
            'NumberOfGuests' => 500,
            'Guest_count' => 500,
            'DayNight' => 'Day',
            'FoodPreferences' => 'High price',
            'Place' => 'Galle Face Green',
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($admin)->post("/admin/bookings/{$booking->BookingID}/assign", [
            'service_id' => $service->service_id,
            'supplier_id' => $supplier->id,
            'assigned_cost' => 150000.00,
            'custom_notes' => 'Primary stage sound management',
        ]);

        $response->assertRedirect();

        Mail::assertSent(SupplierAssignedMail::class, function ($mail) use ($supplierUser, $booking) {
            return $mail->hasTo($supplierUser->email) &&
                   $mail->booking->BookingID === $booking->BookingID;
        });
    }
}

