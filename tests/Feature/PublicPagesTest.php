<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\EventType;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\SupplierListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_home_page_can_be_rendered(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('EVENTFLARE');
    }

    public function test_about_page_can_be_rendered(): void
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('About EVENTFLARE');
    }

    public function test_events_overview_can_be_rendered(): void
    {
        $response = $this->get('/events');
        $response->assertStatus(200);
        $response->assertSee('Choose Your Event Category');
    }

    public function test_wedding_showcase_can_be_rendered(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/events/weddings');
        $response->assertStatus(200);
        $response->assertSee('Royal Poruwa Ceremonies');
    }

    public function test_dj_parties_showcase_can_be_rendered(): void
    {
        $response = $this->get('/events/dj-parties');
        $response->assertStatus(200);
        $response->assertSee('DJ Parties & Intelligent Stage Production', false);
    }

    public function test_birthdays_showcase_can_be_rendered(): void
    {
        $response = $this->get('/events/birthdays');
        $response->assertStatus(200);
        $response->assertSee('Birthdays & Jubilee Celebrations', false);
    }

    public function test_hotels_showcase_can_be_rendered(): void
    {
        $response = $this->get('/events/hotel-venues');
        $response->assertStatus(200);
        $response->assertSee('Five-Star Hotel Venues');
    }

    public function test_get_together_showcase_can_be_rendered(): void
    {
        $response = $this->get('/events/get-together');
        $response->assertStatus(200);
        $response->assertSee('Social Mixers, Batch Parties & Lawn BBQs', false);
    }

    public function test_food_calculator_can_be_rendered(): void
    {
        $response = $this->get('/food-calculator');
        $response->assertStatus(200);
        $response->assertSee('Catering Cost Intelligence');
    }

    public function test_food_calculator_can_calculate_budget(): void
    {
        $response = $this->post('/food-calculator', [
            'total_budget' => 2000000,
            'food_budget' => 1000000,
            'buffet_quantity' => 200,
            'buffet_price' => 3500,
            'beverages_quantity' => 200,
            'beverages_price' => 500,
            'desserts_quantity' => 200,
            'desserts_price' => 400,
            'snacks_quantity' => 100,
            'snacks_price' => 250,
        ]);

        $response->assertStatus(200);
        $response->assertSee('Cost Breakdown');
    }

    public function test_contact_form_submits_successfully(): void
    {
        $response = $this->post('/contact', [
            'firstname' => 'Kavindu',
            'lastname'  => 'Silva',
            'email'     => 'kavindu.silva@gmail.com',
            'phone'     => '+94 77 123 4567',
            'message'   => 'Inquiring about booking wedding decor packages for December 2026.',
        ]);

        $response->assertRedirect(url('/#contact'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'kavindu.silva@gmail.com',
            'firstname' => 'Kavindu',
        ]);
    }
}