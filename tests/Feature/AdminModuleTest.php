<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\EventType;
use App\Models\Rating;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $response->assertSee('Executive Overview');
        $response->assertSee('Total Users');
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

    public function test_admin_can_view_and_manage_clients(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create(['role' => 'buyer', 'username' => 'testclient99']);

        $viewRes = $this->actingAs($admin)->get('/admin/users');
        $viewRes->assertStatus(200);
        $viewRes->assertSee('testclient99');

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
            'is_required' => 1,
        ]);
        $srvRes->assertRedirect();
        $this->assertDatabaseHas('services', [
            'service_name' => 'Award Statuette Design & Production',
            'event_type_id' => $newType->event_type_id,
        ]);
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
}
