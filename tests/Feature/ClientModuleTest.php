<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\EventType;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientModuleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_guest_cannot_access_client_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_buyer_can_view_client_dashboard_with_metrics(): void
    {
        $user = User::factory()->create(['role' => 'buyer']);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Customer Command Center');
        $response->assertSee('Active Bookings');
        $response->assertSee(route('events.index'));
        $response->assertSee('New Reservation');
    }

    public function test_buyer_can_view_booking_creation_form(): void
    {
        $user = User::factory()->create(['role' => 'buyer']);

        $response = $this->actingAs($user)->get('/book?event=Weddings');
        $response->assertStatus(200);
        $response->assertSee('Book Your Celebration');
        $response->assertSee('Planning a Royal Wedding?');
    }

    public function test_buyer_can_create_a_booking(): void
    {
        $user = User::factory()->create(['role' => 'buyer']);

        $response = $this->actingAs($user)->post('/book', [
            'EventType' => 'Weddings',
            'Place' => 'Cinnamon Grand Colombo',
            'NumberOfGuests' => 250,
            'EventDate' => now()->addDays(30)->format('Y-m-d'),
            'DayNight' => 'Night',
            'FoodPreferences' => 'High price',
            'ExtraDetails' => 'Traditional Poruwa setup with oil lamp ceremony.',
            'equipment' => 'Ceremonial Poruwa & Ambient LED lighting',
        ]);

        $response->assertRedirect('/my-bookings');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'EventType' => 'Weddings',
            'Place' => 'Cinnamon Grand Colombo',
            'NumberOfGuests' => 250,
            'status' => 'pending',
        ]);
    }

    public function test_buyer_can_view_their_bookings_list(): void
    {
        $user = User::factory()->create(['role' => 'buyer']);

        $booking = Booking::create([
            'BookingID' => 'BKG-TEST01',
            'user_id' => $user->id,
            'user_name' => $user->username,
            'EventType' => 'Birthdays',
            'Place' => 'Galle Face Hotel',
            'NumberOfGuests' => 50,
            'EventDate' => now()->addDays(15)->format('Y-m-d'),
            'DayNight' => 'Night',
            'FoodPreferences' => 'Middle price',
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($user)->get('/my-bookings');
        $response->assertStatus(200);
        $response->assertSee('BKG-TEST01');
        $response->assertSee('Galle Face Hotel');
    }

    public function test_buyer_can_view_single_booking_details(): void
    {
        $user = User::factory()->create(['role' => 'buyer']);

        $booking = Booking::create([
            'BookingID' => 'BKG-DETAILS01',
            'user_id' => $user->id,
            'user_name' => $user->username,
            'EventType' => 'DJ Party',
            'Place' => 'Waters Edge Battaramulla',
            'NumberOfGuests' => 120,
            'EventDate' => now()->addDays(20)->format('Y-m-d'),
            'DayNight' => 'Night',
            'FoodPreferences' => 'Low Price',
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($user)->get('/my-bookings/BKG-DETAILS01');
        $response->assertStatus(200);
        $response->assertSee('Reservation #BKG-DETAILS01');
        $response->assertSee('Waters Edge Battaramulla');
    }

    public function test_buyer_can_download_booking_pdf(): void
    {
        $user = User::factory()->create(['role' => 'buyer']);

        $booking = Booking::create([
            'BookingID' => 'BKG-PDF001',
            'user_id' => $user->id,
            'user_name' => $user->username,
            'EventType' => 'Weddings',
            'Place' => 'Kingsbury Colombo',
            'NumberOfGuests' => 200,
            'EventDate' => now()->addDays(45)->format('Y-m-d'),
            'DayNight' => 'Day',
            'FoodPreferences' => 'High price',
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($user)->get('/my-bookings/BKG-PDF001/pdf');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_buyer_can_submit_supplier_rating(): void
    {
        $user = User::factory()->create(['role' => 'buyer']);
        $supplier = Supplier::first();

        $booking = Booking::create([
            'BookingID' => 'BKG-REV001',
            'user_id' => $user->id,
            'user_name' => $user->username,
            'EventType' => 'Weddings',
            'Place' => 'Hilton Colombo',
            'NumberOfGuests' => 150,
            'EventDate' => now()->addDays(5)->format('Y-m-d'),
            'DayNight' => 'Night',
            'FoodPreferences' => 'High price',
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($user)->post('/ratings', [
            'booking_id' => 'BKG-REV001',
            'supplier_id' => $supplier->id,
            'rating' => 5,
            'review_title' => 'Brilliant Floral Arrangements',
            'review_text' => 'Outstanding punctuality, fresh lotus and roses, seamless coordination.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('ratings', [
            'booking_id' => 'BKG-REV001',
            'user_id' => $user->id,
            'supplier_id' => $supplier->id,
            'rating' => 5,
            'review_title' => 'Brilliant Floral Arrangements',
        ]);
    }
}
