<?php

namespace Tests\Feature;

use App\Models\EventType;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\SupplierListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketplaceSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_marketplace_page_can_be_rendered(): void
    {
        $response = $this->get('/marketplace');
        $response->assertStatus(200);
        $response->assertSee('Find Verified Packages');
        $response->assertSee('Event Artists');
        $response->assertSee('Keyword Search');
    }

    public function test_marketplace_filters_by_keyword(): void
    {
        $user = User::factory()->create(['role' => 'supplier']);
        $supplier = Supplier::create([
            'user_id' => $user->id,
            'business_name' => 'Royal Heritage Poruwa Ltd',
            'category' => 'Traditional Poruwa',
            'contact_phone' => '+94 77 999 1122',
            'location' => 'Kandy, Central Province',
        ]);

        $service = Service::first();

        SupplierListing::create([
            'supplier_id' => $supplier->id,
            'service_id' => $service->service_id,
            'title' => 'Ancient Kandyan Royal Poruwa Structure',
            'price' => 180000,
            'price_type' => 'total_package',
            'status' => 'active',
            'description' => 'Carved mahogany wood with pure brass oil lamps.',
        ]);

        $res = $this->get('/marketplace?q=Kandyan');
        $res->assertStatus(200);
        $res->assertSee('Ancient Kandyan Royal Poruwa Structure');
        $res->assertSee('Royal Heritage Poruwa Ltd');
    }

    public function test_marketplace_filters_by_price_range(): void
    {
        $user = User::factory()->create(['role' => 'supplier']);
        $supplier = Supplier::create([
            'user_id' => $user->id,
            'business_name' => 'Colombo Budget Audio',
            'category' => 'Sound Equipment',
            'contact_phone' => '+94 71 888 7766',
            'location' => 'Colombo',
        ]);

        $service = Service::first();

        SupplierListing::create([
            'supplier_id' => $supplier->id,
            'service_id' => $service->service_id,
            'title' => 'Budget Acoustic PA Set',
            'price' => 35000,
            'price_type' => 'per_day',
            'status' => 'active',
            'description' => 'Two powered speakers and a wireless mic for small gatherings.',
        ]);

        SupplierListing::create([
            'supplier_id' => $supplier->id,
            'service_id' => $service->service_id,
            'title' => 'Stadium Arena Line Array Rig',
            'price' => 450000,
            'price_type' => 'per_day',
            'status' => 'active',
            'description' => '24 box concert line array system.',
        ]);

        // Filter min=20000, max=50000
        $res = $this->get('/marketplace?min_price=20000&max_price=50000');
        $res->assertStatus(200);
        $res->assertSee('Budget Acoustic PA Set');
        $res->assertDontSee('Stadium Arena Line Array Rig');
    }
}

