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
        $response->assertSee(route('events.index'));
        $response->assertSee('Plan Your Event');
        $response->assertSee('Executed Celebrations & Case Studies', false);
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
        $response->assertSee('Core Celebration Sectors');
        $response->assertSee('Choose Your Event Category');
        $response->assertDontSee('Executed Celebrations & Case Studies', false);
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

    public function test_all_five_event_showcases_contain_9_steps_and_dossier_modal(): void
    {
        $routes = [
            '/events/weddings'     => ['Royal Poruwa Ceremonies', 'Traditional Poruwa', 'Lotus Floral Elegance'],
            '/events/dj-parties'   => ['DJ Parties & Intelligent Stage Production', 'All Parties (4)', 'Pulse DJ'],
            '/events/birthdays'    => ['Birthdays & Jubilee Celebrations', 'All Celebrations (4)', 'Sweet Symphony'],
            '/events/hotel-venues' => ['Five-Star Hotel Venues & Galas', 'Palatial Ballrooms', 'Grand Horizon'],
            '/events/get-together' => ['Social Mixers, Batch Parties & Lawn BBQs', 'All Gatherings (4)', 'Class of 2012'],
        ];

        foreach ($routes as $route => $expectedTexts) {
            $response = $this->get($route);
            $response->assertStatus(200);

            // Verify 9-step key elements are present in the output
            $response->assertSee('hero-metrics-strip', false);
            $response->assertSee('filter-tabs', false);
            $response->assertSee('case-studies-grid', false);
            $response->assertSee('id="dossierModal"', false);
            $response->assertSee('services-catalog-grid', false);
            $response->assertSee('steps-container', false);
            $response->assertSee('catering-banner', false);
            $response->assertSee('testimonials-grid', false);
            $response->assertSee('final-cta-card', false);

            foreach ($expectedTexts as $text) {
                $response->assertSee($text, false);
            }
        }
    }

    public function test_universal_booking_engine_handles_deep_links_across_all_categories(): void
    {
        $buyer = User::where('role', 'buyer')->first();
        $this->actingAs($buyer);

        // 1. Wedding deep link
        $resWedding = $this->get('/book?event=Weddings&venue=Kingsbury+Victorian+Ballroom&guests=320&style=poruwa');
        $resWedding->assertStatus(200);
        $resWedding->assertSee('Planning a Royal Wedding?');
        $resWedding->assertSee('value="Kingsbury Victorian Ballroom"', false);
        $resWedding->assertSee('value="320"', false);
        $resWedding->assertSee('Preferred Style/Theme: Poruwa');

        // 2. DJ Party deep link
        $resDj = $this->get('/book?event=DJ+Parties&venue=Cinnamon+Lakeside+Rooftop&guests=250&style=rave');
        $resDj->assertStatus(200);
        $resDj->assertSee('Intelligent Sound & Club Visuals Active', false);
        $resDj->assertSee('value="Cinnamon Lakeside Rooftop"', false);
        $resDj->assertSee('value="250"', false);
        $resDj->assertSee('Preferred Style/Theme: Rave');

        // 3. Birthday deep link
        $resBday = $this->get('/book?event=Birthdays&venue=Waters+Edge+Pavilion&guests=80&style=kids');
        $resBday->assertStatus(200);
        $resBday->assertSee('Milestone Birthday Celebration Selected', false);
        $resBday->assertSee('value="Waters Edge Pavilion"', false);
        $resBday->assertSee('value="80"', false);
        $resBday->assertSee('Preferred Style/Theme: Kids');

        // 4. Hotel Venues deep link
        $resHotel = $this->get('/book?event=Hotel+Venues&venue=Shangri-La+Main+Ballroom&guests=220&style=ballroom');
        $resHotel->assertStatus(200);
        $resHotel->assertSee('Five-Star Hotel Venue & Ballroom Coordination', false);
        $resHotel->assertSee('value="Shangri-La Main Ballroom"', false);
        $resHotel->assertSee('value="220"', false);
        $resHotel->assertSee('Preferred Style/Theme: Ballroom');

        // 5. Get Togethers deep link
        $resGtg = $this->get('/book?event=Get+Togethers&venue=CR%26FC+Grounds+Pavilion&guests=200&style=bbq');
        $resGtg->assertStatus(200);
        $resGtg->assertSee('Social Mixer & Lawn BBQ Setup', false);
        $resGtg->assertSee('value="CR&amp;FC Grounds Pavilion"', false);
        $resGtg->assertSee('value="200"', false);
        $resGtg->assertSee('Preferred Style/Theme: Bbq');
    }
}