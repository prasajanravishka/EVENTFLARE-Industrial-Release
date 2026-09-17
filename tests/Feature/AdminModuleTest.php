<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\EventType;
use App\Models\Rating;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminModuleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_buyer_cannot_access_admin_dashboard(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);

        $response = $this->actingAs($buyer)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_executive_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Executive Command Center');
        $response->assertSee('Marketplace Network');
        $response->assertSee('Gross Managed Volume');
        $response->assertSee('monthlyBookingsChart');
        $response->assertSee('statusDonutChart');
        $response->assertSee('Category Demand');
    }

    public function test_admin_can_view_and_update_booking_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $booking = Booking::first();

        // View Bookings
        $viewRes = $this->actingAs($admin)->get('/admin/bookings');
        $viewRes->assertStatus(200);
        $viewRes->assertSee('Event Reservations Ledger');

        // Update status
        $statusRes = $this->actingAs($admin)->patch("/admin/bookings/{$booking->BookingID}/status", [
            'status' => 'confirmed',
        ]);
        $statusRes->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'BookingID' => $booking->BookingID,
            'status' => 'confirmed',
        ]);
    }

    public function test_admin_can_view_booking_details_dossier_with_stages(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $booking = Booking::first();

        $response = $this->actingAs($admin)->get("/admin/bookings/{$booking->BookingID}");
        $response->assertStatus(200);
        $response->assertSee('Reservation #' . $booking->BookingID);
        $response->assertSee('Stage 1: Submitted');
        $response->assertSee('Stage 2: Confirmed');
        $response->assertSee('Stage 3: In Progress');
        $response->assertSee('Stage 4: Completed');
        $response->assertSee('Final Stage');

        // Test quick advance transition to completed
        $advanceRes = $this->actingAs($admin)->patch("/admin/bookings/{$booking->BookingID}/status", [
            'status' => 'completed',
        ]);
        $advanceRes->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'BookingID' => $booking->BookingID,
            'status' => 'completed',
        ]);
    }

    public function test_admin_can_view_and_manage_clients(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create(['role' => 'buyer', 'username' => 'testclient99']);

        // Test basic index view
        $viewRes = $this->actingAs($admin)->get('/admin/users');
        $viewRes->assertStatus(200);
        $viewRes->assertSee('testclient99');
        $viewRes->assertSee('Registered Clients');

        // Test activity filter
        $activeRes = $this->actingAs($admin)->get('/admin/users?activity=inactive&sort=most_bookings');
        $activeRes->assertStatus(200);
        $activeRes->assertSee('testclient99');

        $delRes = $this->actingAs($admin)->delete("/admin/users/{$client->id}");
        $delRes->assertRedirect();
        $this->assertDatabaseMissing('users', [
            'id' => $client->id,
        ]);
    }

    public function test_admin_can_view_and_create_suppliers(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $viewRes = $this->actingAs($admin)->get('/admin/suppliers');
        $viewRes->assertStatus(200);
        $viewRes->assertSee('Vendor Directory');
        $viewRes->assertSee('Onboard New Supplier');

        $createRes = $this->actingAs($admin)->post('/admin/suppliers', [
            'username' => 'newvendor99',
            'fullname' => 'Sunil Perera',
            'email' => 'sunil.perera@gmail.com',
            'password' => 'secret123',
            'business_name' => 'Sunil Floral Artists',
            'category' => 'Florist & Stage Decor',
            'contact_phone' => '+94 77 123 7890',
            'location' => 'Galle, Southern Province',
        ]);

        $createRes->assertRedirect();
        $this->assertDatabaseHas('users', [
            'username' => 'newvendor99',
            'role' => 'supplier',
        ]);
        $this->assertDatabaseHas('suppliers', [
            'business_name' => 'Sunil Floral Artists',
            'location' => 'Galle, Southern Province',
        ]);
    }

    public function test_admin_can_onboard_supplier_with_accredited_services(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $service = \App\Models\Service::first();

        $createRes = $this->actingAs($admin)->post('/admin/suppliers', [
            'username' => 'servicevendor',
            'fullname' => 'Nimal Jayawardena',
            'email' => 'nimal.jay@gmail.com',
            'password' => 'secret123',
            'business_name' => 'Nimal Cinematic Studio',
            'category' => 'Photography & Cinematography',
            'contact_phone' => '+94 71 999 8888',
            'location' => 'Kandy, Central Province',
            'services' => [$service->service_id],
        ]);

        $createRes->assertRedirect();
        $supplier = Supplier::where('business_name', 'Nimal Cinematic Studio')->firstOrFail();
        $this->assertDatabaseHas('supplier_services', [
            'supplier_id' => $supplier->id,
            'service_id' => $service->service_id,
        ]);
    }

    public function test_admin_can_update_supplier_and_sync_services(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $supplier = Supplier::first();
        $service = \App\Models\Service::first();

        $updateRes = $this->actingAs($admin)->put("/admin/suppliers/{$supplier->id}", [
            'business_name' => 'Updated Business Name',
            'fullname' => 'Updated Owner Name',
            'category' => 'Updated Category',
            'contact_phone' => '+94 77 555 4444',
            'location' => 'Colombo 03',
            'services' => [$service->service_id],
        ]);

        $updateRes->assertRedirect();
        $this->assertDatabaseHas('suppliers', [
            'id' => $supplier->id,
            'business_name' => 'Updated Business Name',
        ]);
        $this->assertDatabaseHas('supplier_services', [
            'supplier_id' => $supplier->id,
            'service_id' => $service->service_id,
        ]);
    }

    public function test_admin_can_delete_supplier(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'supplier']);
        $supplier = Supplier::create([
            'user_id' => $user->id,
            'business_name' => 'Supplier To Remove',
            'category' => 'Temporary',
            'contact_phone' => '+94 77 000 0000',
            'location' => 'Negombo',
        ]);

        $delRes = $this->actingAs($admin)->delete("/admin/suppliers/{$supplier->id}");
        $delRes->assertRedirect();

        $this->assertDatabaseMissing('suppliers', [
            'id' => $supplier->id,
        ]);
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_admin_can_moderate_ratings(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $rating = Rating::first();

        $viewRes = $this->actingAs($admin)->get('/admin/ratings');
        $viewRes->assertStatus(200);
        $viewRes->assertSee('Customer Endorsements');

        // Toggle status
        $toggleRes = $this->actingAs($admin)->patch("/admin/ratings/{$rating->id}/toggle");
        $toggleRes->assertRedirect();
        $newStatus = ($rating->admin_status === 'approved') ? 'hidden' : 'approved';
        $this->assertDatabaseHas('ratings', [
            'id' => $rating->id,
            'admin_status' => $newStatus,
        ]);
    }

    public function test_admin_can_manage_event_types_and_services(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $viewRes = $this->actingAs($admin)->get('/admin/event-types');
        $viewRes->assertStatus(200);
        $viewRes->assertSee('Services Catalog');

        // Create Category
        $catRes = $this->actingAs($admin)->post('/admin/event-types', [
            'type_name' => 'Corporate Gala Awards',
            'description' => 'Annual corporate award ceremonies and banquets',
            'is_active' => 1,
        ]);
        $catRes->assertRedirect();
        $this->assertDatabaseHas('event_types', [
            'type_name' => 'Corporate Gala Awards',
        ]);

        $newType = EventType::where('type_name', 'Corporate Gala Awards')->first();

        // Create Service
        $srvRes = $this->actingAs($admin)->post('/admin/services', [
            'event_type_id' => $newType->event_type_id,
            'service_name' => 'Award Statuette Design & Production',
            'priority_rank' => 1,
            'typical_capacity' => 200,
            'notes' => 'Custom engraved crystal trophies',
            'is_required' => 1,
        ]);
        $srvRes->assertRedirect();
        $this->assertDatabaseHas('services', [
            'service_name' => 'Award Statuette Design & Production',
            'event_type_id' => $newType->event_type_id,
            'typical_capacity' => 200,
            'notes' => 'Custom engraved crystal trophies',
        ]);

        $newService = Service::where('service_name', 'Award Statuette Design & Production')->first();

        // 1. Update Category with Image File Upload
        Storage::fake('public');
        $fakeImage = UploadedFile::fake()->image('gala_banner.jpg', 800, 600);

        $updateCatRes = $this->actingAs($admin)->put("/admin/event-types/{$newType->event_type_id}", [
            'type_name' => 'Corporate Gala Awards Night',
            'description' => 'Updated annual corporate ceremony',
            'image' => $fakeImage,
            'is_active' => 1,
        ]);
        $updateCatRes->assertRedirect();

        $updatedType = EventType::find($newType->event_type_id);
        $this->assertEquals('Corporate Gala Awards Night', $updatedType->type_name);
        $this->assertNotNull($updatedType->image_url);
        $this->assertStringStartsWith('/storage/event_types/images/', $updatedType->image_url);

        // 2. Toggle Category Active/Archived status
        $toggleRes = $this->actingAs($admin)->patch("/admin/event-types/{$newType->event_type_id}/toggle");
        $toggleRes->assertRedirect();
        $this->assertDatabaseHas('event_types', [
            'event_type_id' => $newType->event_type_id,
            'is_active' => false,
        ]);

        // 3. Update Service with Capacity & Notes
        $updateSrvRes = $this->actingAs($admin)->put("/admin/services/{$newService->service_id}", [
            'event_type_id' => $newType->event_type_id,
            'service_name' => 'Award Statuette & Trophies Pro',
            'priority_rank' => 2,
            'typical_capacity' => 350,
            'notes' => 'Lead time 4 weeks required',
            'is_required' => 0,
        ]);
        $updateSrvRes->assertRedirect();
        $this->assertDatabaseHas('services', [
            'service_id' => $newService->service_id,
            'service_name' => 'Award Statuette & Trophies Pro',
            'priority_rank' => 2,
            'typical_capacity' => 350,
            'notes' => 'Lead time 4 weeks required',
            'is_required' => false,
        ]);

        // 4. Delete Service
        $delSrvRes = $this->actingAs($admin)->delete("/admin/services/{$newService->service_id}");
        $delSrvRes->assertRedirect();
        $this->assertDatabaseMissing('services', [
            'service_id' => $newService->service_id,
        ]);

        // 5. Safeguard: Attempt to delete category with existing bookings (e.g. Weddings)
        $weddingType = EventType::where('type_name', 'Weddings')->first();
        if ($weddingType) {
            $delWeddingRes = $this->actingAs($admin)->delete("/admin/event-types/{$weddingType->event_type_id}");
            $delWeddingRes->assertSessionHas('error');
            $this->assertDatabaseHas('event_types', [
                'event_type_id' => $weddingType->event_type_id,
            ]);
        }

        // 6. Delete clean unused Category
        $delCatRes = $this->actingAs($admin)->delete("/admin/event-types/{$newType->event_type_id}");
        $delCatRes->assertRedirect();
        $this->assertDatabaseMissing('event_types', [
            'event_type_id' => $newType->event_type_id,
        ]);
    }

    public function test_admin_can_quick_assign_and_remove_supplier_for_service(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $service = Service::first();
        $supplier = Supplier::first();

        // 1. Quick Accredit / Assign
        $assignRes = $this->actingAs($admin)->post("/admin/services/{$service->service_id}/quick-assign", [
            'supplier_id' => $supplier->id,
        ]);
        $assignRes->assertRedirect();
        $this->assertDatabaseHas('supplier_services', [
            'service_id' => $service->service_id,
            'supplier_id' => $supplier->id,
        ]);

        // 2. Remove Accreditation
        $removeRes = $this->actingAs($admin)->delete("/admin/services/{$service->service_id}/suppliers/{$supplier->id}");
        $removeRes->assertRedirect();
        $this->assertDatabaseMissing('supplier_services', [
            'service_id' => $service->service_id,
            'supplier_id' => $supplier->id,
        ]);
    }

    public function test_event_types_catalog_displays_shortages_and_vendor_metrics(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/event-types');
        $response->assertStatus(200);
        $response->assertSee('Supply Shortages Only');
        $response->assertSee('All Services');
        $response->assertSee('Supply Health');
        $response->assertSee('Accredited Service Pipeline');
    }

    public function test_admin_can_view_budgets_ledger(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $viewRes = $this->actingAs($admin)->get('/admin/budgets');
        $viewRes->assertStatus(200);
        $viewRes->assertSee('Catering Budget Ledger');
    }

    public function test_admin_can_moderate_contact_messages(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $msg = ContactMessage::create([
            'firstname' => 'Ruwan',
            'lastname' => 'Fernando',
            'email' => 'ruwan@example.com',
            'phone' => '+94 77 444 3333',
            'message' => 'Inquiring about corporate banquet packages.',
            'is_read' => false,
        ]);

        $viewRes = $this->actingAs($admin)->get('/admin/messages');
        $viewRes->assertStatus(200);
        $viewRes->assertSee('ruwan@example.com');

        // Toggle Read
        $toggleRes = $this->actingAs($admin)->patch("/admin/messages/{$msg->id}/toggle");
        $toggleRes->assertRedirect();
        $this->assertDatabaseHas('contact_messages', [
            'id' => $msg->id,
            'is_read' => true,
        ]);
    }

    public function test_admin_can_provision_new_staff(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $viewRes = $this->actingAs($admin)->get('/admin/staff');
        $viewRes->assertStatus(200);
        $viewRes->assertSee('Active Administrators');

        $provRes = $this->actingAs($admin)->post('/admin/staff', [
            'username' => 'newadmin_operator',
            'fullname' => 'Kamal Gunaratne',
            'email' => 'kamal.operator@eventflare.lk',
            'password' => 'supersecret123',
            'password_confirmation' => 'supersecret123',
        ]);

        $provRes->assertRedirect();
        $this->assertDatabaseHas('users', [
            'username' => 'newadmin_operator',
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_manage_portfolio_case_studies(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // 1. View Portfolio Index
        $viewRes = $this->actingAs($admin)->get('/admin/portfolio');
        $viewRes->assertStatus(200);
        $viewRes->assertSee('Portfolio & Case Studies');
        $viewRes->assertSee('Total Executed');

        // 2. Create Case Study
        $createRes = $this->actingAs($admin)->post('/admin/portfolio', [
            'title' => 'Test Coastal Gala Celebration',
            'category_tag' => 'wedding',
            'category_label' => 'Royal Weddings',
            'venue' => 'Lighthouse Hotel, Galle',
            'event_date' => 'December 20, 2026',
            'guests_count' => 200,
            'image_url' => 'assets/images/weding.jpg',
            'summary' => 'A wonderful coastal wedding celebration in Galle.',
            'quote' => 'Truly extraordinary event management!',
            'client_name' => 'John & Mary',
            'services_input' => "Decor: Floral Studio\nCatering: Galle Banquet",
            'is_featured_home' => '1',
            'is_active' => '1',
        ]);
        $createRes->assertRedirect();

        $this->assertDatabaseHas('case_studies', [
            'title' => 'Test Coastal Gala Celebration',
            'venue' => 'Lighthouse Hotel, Galle',
            'client_name' => 'John & Mary',
        ]);

        $created = \App\Models\CaseStudy::where('title', 'Test Coastal Gala Celebration')->first();

        // 3. Toggle featured
        $toggleFeatRes = $this->actingAs($admin)->patch("/admin/portfolio/{$created->id}/toggle-featured");
        $toggleFeatRes->assertRedirect();
        $this->assertFalse($created->fresh()->is_featured_home);

        // 4. Update Case Study
        $updateRes = $this->actingAs($admin)->put("/admin/portfolio/{$created->id}", [
            'title' => 'Updated Coastal Gala Celebration',
            'category_tag' => 'wedding',
            'venue' => 'Updated Venue, Galle',
            'guests_count' => 250,
            'summary' => 'Updated summary description.',
            'is_featured_home' => '1',
            'is_active' => '1',
        ]);
        $updateRes->assertRedirect();
        $this->assertDatabaseHas('case_studies', [
            'id' => $created->id,
            'title' => 'Updated Coastal Gala Celebration',
            'venue' => 'Updated Venue, Galle',
        ]);

        // 5. Delete Case Study
        $delRes = $this->actingAs($admin)->delete("/admin/portfolio/{$created->id}");
        $delRes->assertRedirect();
        $this->assertDatabaseMissing('case_studies', [
            'id' => $created->id,
        ]);
    }

    public function test_admin_can_autofill_portfolio_case_study_from_completed_booking(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create(['role' => 'buyer', 'fullname' => 'Kasun & Sandani Perera']);

        // 1. Create a completed booking with ratings
        $booking = Booking::create([
            'BookingID' => 'BKG-TEST9999',
            'user_id' => $client->id,
            'user_name' => 'Kasun & Sandani Perera',
            'EventType' => 'Weddings',
            'Place' => 'Shangri-La Ballroom, Colombo',
            'NumberOfGuests' => 350,
            'EventDate' => '2026-11-15',
            'DayNight' => 'evening',
            'FoodPreferences' => 'Sri Lankan & Western Buffet',
            'ExtraDetails' => 'Floral poruwa with live saxophone ensemble.',
            'status' => 'completed',
        ]);

        $supplier = Supplier::first();
        $service = Service::first();

        // Add service delivered item
        \App\Models\BookingService::create([
            'booking_id' => $booking->BookingID,
            'service_id' => $service->service_id,
            'supplier_id' => $supplier->id,
            'assigned_cost' => 120000,
            'status' => 'confirmed',
        ]);

        // Add review rating
        Rating::create([
            'user_id' => $client->id,
            'booking_id' => $booking->BookingID,
            'supplier_id' => $supplier->id,
            'rating' => 5,
            'review_title' => 'Unforgettable Fairy Tale Wedding',
            'review_text' => 'EVENTFLARE coordinated every single supplier flawlessly. Our guests were mesmerized!',
        ]);

        // 2. Non-admin cannot fetch booking data
        $guestRes = $this->getJson("/admin/portfolio/booking-data/{$booking->BookingID}");
        $guestRes->assertStatus(401);

        // 3. Admin fetches verified booking data for 1-click auto-fill
        $dataRes = $this->actingAs($admin)->getJson("/admin/portfolio/booking-data/{$booking->BookingID}");
        $dataRes->assertStatus(200);
        $dataRes->assertJson([
            'success' => true,
            'booking_id' => 'BKG-TEST9999',
            'client_name' => 'Kasun & Sandani Perera',
            'category_tag' => 'wedding',
            'category_label' => 'Royal Weddings',
            'venue' => 'Shangri-La Ballroom, Colombo',
            'guests_count' => 350,
            'quote' => 'EVENTFLARE coordinated every single supplier flawlessly. Our guests were mesmerized!',
        ]);

        // 4. Admin creates case study linking the booking ID
        $createRes = $this->actingAs($admin)->post('/admin/portfolio', [
            'booking_id' => $booking->BookingID,
            'title' => 'Kasun & Sandani’s Royal Ballroom Wedding',
            'category_tag' => 'wedding',
            'category_label' => 'Royal Weddings',
            'venue' => 'Shangri-La Ballroom, Colombo',
            'event_date' => 'November 15, 2026',
            'guests_count' => 350,
            'tagline' => 'Evening Grandeur & Floral Poruwa',
            'image_url' => 'assets/images/weding.jpg',
            'summary' => 'An authentic royal wedding for 350 guests at Shangri-La Ballroom, Colombo.',
            'quote' => 'EVENTFLARE coordinated every single supplier flawlessly. Our guests were mesmerized!',
            'client_name' => 'Kasun & Sandani Perera',
            'services_input' => "Decor: Lotus Floral Design\nCatering: Shangri-La Banquets",
            'is_featured_home' => '1',
            'is_active' => '1',
        ]);
        $createRes->assertRedirect();

        $this->assertDatabaseHas('case_studies', [
            'booking_id' => 'BKG-TEST9999',
            'title' => 'Kasun & Sandani’s Royal Ballroom Wedding',
            'venue' => 'Shangri-La Ballroom, Colombo',
            'client_name' => 'Kasun & Sandani Perera',
        ]);

        // 5. Verify Model Relationships
        $caseStudy = \App\Models\CaseStudy::where('booking_id', 'BKG-TEST9999')->first();
        $this->assertNotNull($caseStudy);
        $this->assertEquals($booking->BookingID, $caseStudy->booking->BookingID);
        $this->assertEquals($caseStudy->id, $booking->fresh()->caseStudy->id);

        // 6. Verify Booking Show view displays "In Portfolio" badge
        $bookingShowRes = $this->actingAs($admin)->get("/admin/bookings/{$booking->BookingID}");
        $bookingShowRes->assertStatus(200);
        $bookingShowRes->assertSee('In Portfolio');
    }
}

