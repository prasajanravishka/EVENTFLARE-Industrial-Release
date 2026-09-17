<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\BookingService;
use App\Models\PlatformFeedback;
use App\Models\Rating;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CustomerFeedbackTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_client_can_submit_multi_criteria_feedback_with_photos(): void
    {
        $buyer = User::where('role', 'buyer')->first();
        $supplier = Supplier::first();
        $service = Service::first();

        // Create booking belonging to this buyer
        $booking = Booking::create([
            'BookingID' => 'BKG-WED-TEST-001',
            'user_id' => $buyer->id,
            'user_name' => $buyer->username,
            'EventType' => 'Weddings',
            'EventDate' => now()->addDays(14)->toDateString(),
            'Place' => 'Shangri-La Colombo',
            'NumberOfGuests' => 150,
            'DayNight' => 'Night',
            'FoodPreferences' => 'Middle price',
            'status' => 'confirmed',
        ]);

        BookingService::create([
            'booking_id' => $booking->BookingID,
            'service_id' => $service->service_id,
            'supplier_id' => $supplier->id,
            'assigned_cost' => 120000.00,
            'status' => 'confirmed',
        ]);

        $this->actingAs($buyer);

        $fakePhoto = UploadedFile::fake()->image('wedding_stage.jpg', 800, 600);

        $response = $this->post(route('ratings.store'), [
            'booking_id' => $booking->BookingID,
            'supplier_id' => $supplier->id,
            'rating' => 5,
            'rating_quality' => 5,
            'rating_punctuality' => 4,
            'rating_communication' => 5,
            'rating_value' => 5,
            'review_title' => 'Spectacular Floral Decor & Poruwa Setup!',
            'review_text' => 'The floral arrangements exceeded all expectations. Everything was on time and communicated flawlessly.',
            'photos' => [$fakePhoto],
        ]);

        $response->assertSessionHas('success');

        $rating = Rating::where('booking_id', $booking->BookingID)
            ->where('supplier_id', $supplier->id)
            ->first();

        $this->assertNotNull($rating);
        $this->assertEquals(5, $rating->rating);
        $this->assertEquals(5, $rating->rating_quality);
        $this->assertEquals(4, $rating->rating_punctuality);
        $this->assertEquals(5, $rating->rating_communication);
        $this->assertEquals(5, $rating->rating_value);
        $this->assertEquals('Spectacular Floral Decor & Poruwa Setup!', $rating->review_title);
        $this->assertIsArray($rating->photos);
        $this->assertCount(1, $rating->photos);
        $this->assertStringContainsString('assets/images/reviews/', $rating->photos[0]);
    }

    public function test_client_can_submit_platform_feedback_and_nps(): void
    {
        $buyer = User::where('role', 'buyer')->first();
        $this->actingAs($buyer);

        $response = $this->post(route('platform-feedback.store'), [
            'nps_score' => 10,
            'platform_rating' => 5,
            'category' => 'booking_wizard',
            'comments' => 'The 4-stage interactive booking wizard with real-time LKR telemetry is absolutely world-class.',
            'booking_id' => 'BKG-WED-TEST-001',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('platform_feedback', [
            'user_id' => $buyer->id,
            'nps_score' => 10,
            'platform_rating' => 5,
            'category' => 'booking_wizard',
        ]);
    }

    public function test_supplier_can_submit_official_reply_to_client_review(): void
    {
        $buyer = User::where('role', 'buyer')->first();
        $supplier = Supplier::first();
        $supplierUser = User::find($supplier->user_id);

        $booking = Booking::create([
            'BookingID' => 'BKG-WED-TEST-002',
            'user_id' => $buyer->id,
            'user_name' => $buyer->username,
            'EventType' => 'Weddings',
            'EventDate' => now()->toDateString(),
            'Place' => 'Kingsbury Ballroom',
            'NumberOfGuests' => 200,
            'DayNight' => 'Night',
            'FoodPreferences' => 'Luxury',
            'status' => 'confirmed',
        ]);

        $rating = Rating::create([
            'booking_id' => $booking->BookingID,
            'user_id' => $buyer->id,
            'supplier_id' => $supplier->id,
            'rating' => 5,
            'rating_quality' => 5,
            'rating_punctuality' => 5,
            'rating_communication' => 5,
            'rating_value' => 5,
            'review_title' => 'Unbelievable Experience',
            'review_text' => 'The lighting and ambiance created a fairytale wedding.',
            'admin_status' => 'approved',
        ]);

        $this->actingAs($supplierUser);

        $response = $this->post(route('supplier.ratings.reply', $rating->id), [
            'supplier_reply' => 'Thank you so much Kasun & Dilhani! It was a true honor curating your special celebration.',
        ]);

        $response->assertSessionHas('success');

        $rating->refresh();
        $this->assertEquals('Thank you so much Kasun & Dilhani! It was a true honor curating your special celebration.', $rating->supplier_reply);
        $this->assertNotNull($rating->supplier_replied_at);
    }

    public function test_unauthorized_supplier_cannot_reply_to_other_supplier_review(): void
    {
        $buyer = User::where('role', 'buyer')->first();
        $supplier1 = Supplier::first();
        
        // Find or create second supplier
        $supplier2User = User::factory()->create(['role' => 'supplier']);
        $supplier2 = Supplier::create([
            'user_id' => $supplier2User->id,
            'business_name' => 'Second Supplier Sound Co',
            'category' => 'DJ Parties',
            'city' => 'Colombo',
            'is_verified' => true,
        ]);

        $booking = Booking::create([
            'BookingID' => 'BKG-WED-TEST-003',
            'user_id' => $buyer->id,
            'user_name' => $buyer->username,
            'EventType' => 'Weddings',
            'EventDate' => now()->toDateString(),
            'Place' => 'Cinnamon Grand',
            'NumberOfGuests' => 100,
            'DayNight' => 'Day',
            'FoodPreferences' => 'Middle price',
            'status' => 'confirmed',
        ]);

        $rating = Rating::create([
            'booking_id' => $booking->BookingID,
            'user_id' => $buyer->id,
            'supplier_id' => $supplier1->id,
            'rating' => 4,
            'review_title' => 'Good work',
            'admin_status' => 'approved',
        ]);

        // Second supplier attempts to reply to supplier1's review
        $this->actingAs($supplier2User);

        $response = $this->post(route('supplier.ratings.reply', $rating->id), [
            'supplier_reply' => 'Unauthorized reply attempt',
        ]);

        $response->assertStatus(403);
    }

    public function test_client_dashboard_displays_pending_review_spotlight_banner(): void
    {
        $buyer = User::where('role', 'buyer')->first();
        $supplier = Supplier::first();
        $service = Service::first();

        $booking = Booking::create([
            'BookingID' => 'BKG-WED-TEST-004',
            'user_id' => $buyer->id,
            'user_name' => $buyer->username,
            'EventType' => 'Weddings',
            'EventDate' => now()->subDays(2)->toDateString(),
            'Place' => 'Shangri-La Colombo',
            'NumberOfGuests' => 180,
            'DayNight' => 'Night',
            'FoodPreferences' => 'Middle price',
            'status' => 'confirmed',
        ]);

        BookingService::create([
            'booking_id' => $booking->BookingID,
            'service_id' => $service->service_id,
            'supplier_id' => $supplier->id,
            'assigned_cost' => 150000.00,
            'status' => 'confirmed',
        ]);

        $this->actingAs($buyer);

        $response = $this->get(route('client.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Celebration Feedback Opportunity');
        $response->assertSee('Leave Feedback & Photos', false);
        $response->assertSee($supplier->business_name);
    }
}
