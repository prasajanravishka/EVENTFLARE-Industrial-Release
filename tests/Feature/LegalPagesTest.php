<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_terms_of_service_page_can_be_rendered(): void
    {
        $response = $this->get('/terms');
        $response->assertStatus(200);
        $response->assertSee('Terms of Service');
        $response->assertSee('Democratic Socialist Republic of Sri Lanka');
        $response->assertSee('Limitation of Liability');
    }

    public function test_privacy_policy_page_can_be_rendered_with_pdpa_compliance(): void
    {
        $response = $this->get('/privacy');
        $response->assertStatus(200);
        $response->assertSee('Privacy Policy');
        $response->assertSee('Personal Data Protection Act');
        $response->assertSee('Data Protection Officer');
        $response->assertSee('dpo@eventflare.lk');
    }

    public function test_cookie_consent_banner_and_footer_rendered_on_pages(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('cookieConsentBanner');
        $response->assertSee('Sri Lanka Personal Data Protection Act');
        $response->assertSee('All Rights Reserved');
    }
}

