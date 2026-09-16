<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_supplier_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/supplier/register');

        $response->assertStatus(200);
    }

    public function test_new_suppliers_can_register(): void
    {
        $response = $this->post('/supplier/register', [
            'business_name' => 'Lumina AV Rigging',
            'category' => 'Audio/Visual (A/V)',
            'fullname' => 'Dinesh Fonseka',
            'username' => 'lumina_av',
            'email' => 'dinesh@luminaav.lk',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $this->assertAuthenticated();

        $user = User::where('username', 'lumina_av')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->isSupplier());

        $supplier = Supplier::where('user_id', $user->id)->first();
        $this->assertNotNull($supplier);
        $this->assertSame('Lumina AV Rigging', $supplier->business_name);
    }
}