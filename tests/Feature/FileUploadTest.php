<?php

namespace Tests\Feature;

use App\Models\EventType;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\SupplierListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_supplier_can_upload_brand_logo(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'supplier']);
        $supplier = Supplier::create([
            'user_id' => $user->id,
            'business_name' => 'Royal Stage Creators',
            'category' => 'Stage Decor',
            'contact_phone' => '+94 77 111 2233',
            'location' => 'Kandy',
        ]);

        $file = UploadedFile::fake()->image('brand_logo.png', 300, 300);

        $response = $this->actingAs($user)->put('/supplier/profile', [
            'business_name' => 'Royal Stage Creators',
            'category' => 'Stage Decor',
            'contact_phone' => '+94 77 111 2233',
            'location' => 'Kandy',
            'logo' => $file,
        ]);

        $response->assertRedirect('/supplier/profile');

        $supplier->refresh();
        $this->assertNotNull($supplier->logo_url);
        $this->assertStringStartsWith('/storage/suppliers/logos/', $supplier->logo_url);

        $relativePath = str_replace('/storage/', '', $supplier->logo_url);
        Storage::disk('public')->assertExists($relativePath);
    }

    public function test_supplier_can_upload_listing_feature_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'supplier']);
        $supplier = Supplier::create([
            'user_id' => $user->id,
            'business_name' => 'Lanka DJ Sounds',
            'category' => 'Audio / Visual',
            'contact_phone' => '+94 71 444 5566',
            'location' => 'Colombo',
        ]);

        $eventType = EventType::first();
        $service = Service::where('event_type_id', $eventType->event_type_id)->first();

        $image = UploadedFile::fake()->image('dj_rig.jpg', 600, 400);

        $response = $this->actingAs($user)->post('/supplier/listings', [
            'service_id' => $service->service_id,
            'title' => 'Concert Grade Pioneer DDJ Rig',
            'price' => 75000,
            'price_type' => 'per_day',
            'capacity' => 400,
            'status' => 'active',
            'description' => 'Full digital console with twin subwoofers and laser lighting.',
            'image' => $image,
        ]);

        $response->assertRedirect('/supplier/listings');

        $listing = SupplierListing::where('title', 'Concert Grade Pioneer DDJ Rig')->first();
        $this->assertNotNull($listing);
        $this->assertNotNull($listing->image_url);
        $this->assertStringStartsWith('/storage/listings/images/', $listing->image_url);

        $relativePath = str_replace('/storage/', '', $listing->image_url);
        Storage::disk('public')->assertExists($relativePath);
    }
}

