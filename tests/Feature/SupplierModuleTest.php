<?php

namespace Tests\Feature;

use App\Models\EventType;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\SupplierListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierModuleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_guest_cannot_access_supplier_dashboard(): void
    {
        $response = $this->get('/supplier/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_buyer_cannot_access_supplier_dashboard(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);

        $response = $this->actingAs($buyer)->get('/supplier/dashboard');
        $response->assertStatus(403);
    }

    public function test_supplier_can_access_dashboard_with_metrics(): void
    {
        $user = User::factory()->create(['role' => 'supplier']);
        $supplier = Supplier::create([
            'user_id' => $user->id,
            'business_name' => 'Lanka Sound Masters',
            'category' => 'Pro Audio & DJ',
            'contact_phone' => '+94 77 999 8888',
            'location' => 'Colombo 03',
        ]);

        $response = $this->actingAs($user)->get('/supplier/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Lanka Sound Masters');
        $response->assertSee('Supplier Command Center');
    }

    public function test_supplier_can_view_and_update_profile(): void
    {
        $user = User::factory()->create(['role' => 'supplier']);
        $supplier = Supplier::create([
            'user_id' => $user->id,
            'business_name' => 'Old Name Ent',
            'category' => 'General Event Services',
            'contact_phone' => '+94 11 222 3333',
            'location' => 'Kandy',
        ]);

        $response = $this->actingAs($user)->get('/supplier/profile');
        $response->assertStatus(200);
        $response->assertSee('Supplier Business Profile');

        $service = Service::first();

        $updateResponse = $this->actingAs($user)->put('/supplier/profile', [
            'business_name' => 'Royal Stage Decorators',
            'category' => 'Floral & Poruwa Masters',
            'description' => 'Over 15 years crafting luxury wedding settings.',
            'contact_phone' => '+94 71 555 4444',
            'location' => 'Colombo, Western Province',
            'services' => [$service->service_id],
        ]);

        $updateResponse->assertRedirect('/supplier/profile');
        $updateResponse->assertSessionHas('success');

        $this->assertDatabaseHas('suppliers', [
            'user_id' => $user->id,
            'business_name' => 'Royal Stage Decorators',
            'location' => 'Colombo, Western Province',
        ]);

        $this->assertDatabaseHas('supplier_services', [
            'supplier_id' => $supplier->id,
            'service_id' => $service->service_id,
        ]);
    }

    public function test_supplier_can_manage_package_listings(): void
    {
        $user = User::factory()->create(['role' => 'supplier']);
        $supplier = Supplier::create([
            'user_id' => $user->id,
            'business_name' => 'Pearl Sound Engineering',
            'category' => 'Pro Audio & Staging',
            'contact_phone' => '+94 77 111 2222',
            'location' => 'Negombo',
        ]);

        $service = Service::first();
        $supplier->services()->attach($service->service_id);

        // 1. View Listings
        $viewRes = $this->actingAs($user)->get('/supplier/listings');
        $viewRes->assertStatus(200);
        $viewRes->assertSee('New Package Listing');

        // 2. Create Listing
        $createRes = $this->actingAs($user)->post('/supplier/listings', [
            'service_id' => $service->service_id,
            'title' => 'Concert Stage Audio Stack',
            'description' => 'Complete 20kW line array audio rig with subwoofers.',
            'price' => 250000,
            'price_type' => 'total_package',
            'capacity' => 1000,
            'status' => 'active',
        ]);

        $createRes->assertRedirect('/supplier/listings');
        $this->assertDatabaseHas('supplier_listings', [
            'supplier_id' => $supplier->id,
            'title' => 'Concert Stage Audio Stack',
            'price' => 250000,
        ]);

        $listing = SupplierListing::where('supplier_id', $supplier->id)->first();

        // 3. Toggle Status
        $toggleRes = $this->actingAs($user)->patch("/supplier/listings/{$listing->listing_id}/toggle");
        $toggleRes->assertRedirect('/supplier/listings');
        $this->assertDatabaseHas('supplier_listings', [
            'listing_id' => $listing->listing_id,
            'status' => 'inactive',
        ]);

        // 4. Update Listing
        $updateRes = $this->actingAs($user)->put("/supplier/listings/{$listing->listing_id}", [
            'service_id' => $service->service_id,
            'title' => 'Concert Stage Audio Stack - Pro Edition',
            'description' => 'Complete line array audio rig with 4 wireless mics.',
            'price' => 280000,
            'price_type' => 'total_package',
            'capacity' => 1200,
            'status' => 'active',
        ]);
        $updateRes->assertRedirect('/supplier/listings');
        $this->assertDatabaseHas('supplier_listings', [
            'listing_id' => $listing->listing_id,
            'title' => 'Concert Stage Audio Stack - Pro Edition',
            'price' => 280000,
        ]);

        // 5. Delete Listing
        $deleteRes = $this->actingAs($user)->delete("/supplier/listings/{$listing->listing_id}");
        $deleteRes->assertRedirect('/supplier/listings');
        $this->assertDatabaseMissing('supplier_listings', [
            'listing_id' => $listing->listing_id,
        ]);
    }
}
