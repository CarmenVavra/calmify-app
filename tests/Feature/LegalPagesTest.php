<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    use RefreshDatabase;

    private const NOTICE = 'Calmify ist kein Medizinprodukt. Die App stellt keine Diagnosen und bietet keine Behandlung.';

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'calmify.legal.name' => 'Alex Muster',
            'calmify.legal.location' => 'Graz, Österreich',
            'calmify.legal.address' => null,
            'calmify.legal.email' => 'hallo@calmify.test',
            'calmify.legal.hoster' => 'Beispiel Hosting GmbH, Wien',
        ]);
    }

    public function test_imprint_shows_the_operator(): void
    {
        $response = $this->get(route('legal.imprint'));

        $response->assertOk();
        $response->assertSee('Offenlegung gemäß § 25 Mediengesetz');
        $response->assertSee('Alex Muster');
        $response->assertSee('Graz, Österreich');
        $response->assertSee('mailto:hallo@calmify.test', false);
    }

    public function test_imprint_prefers_the_full_address_when_given(): void
    {
        config(['calmify.legal.address' => 'Musterweg 1, 8010 Graz']);

        $this->get(route('legal.imprint'))
            ->assertSee('Musterweg 1, 8010 Graz')
            ->assertDontSee('Graz, Österreich');
    }

    public function test_privacy_policy_covers_the_essentials(): void
    {
        $response = $this->get(route('legal.privacy'));

        $response->assertOk();
        $response->assertSee('Alex Muster');
        $response->assertSee('Beispiel Hosting GmbH, Wien');
        $response->assertSee('Übungsprotokolle (Gesundheitsdaten)');
        $response->assertSee('Art. 9 Abs. 2 lit. a');
        $response->assertSee(config('session.cookie'));
        $response->assertSee('calmify_country');
        $response->assertSee('Österreichischen Datenschutzbehörde');
        $response->assertSee('ab 14 Jahren');
    }

    public function test_about_page_shows_notice_terms_and_accessibility(): void
    {
        $response = $this->get(route('legal.about'));

        $response->assertOk();
        $response->assertSee(self::NOTICE);
        $response->assertSee('Hausärztinnen und Hausärzte, Psychotherapeutinnen und Psychotherapeuten sowie die TelefonSeelsorge');
        $response->assertSee('wähle bitte sofort den Notruf 112.');
        $response->assertSee('id="nutzung"', false);
        $response->assertSee('id="barrierefreiheit"', false);
        $response->assertSee('mailto:hallo@calmify.test', false);
    }

    public function test_home_and_sos_show_the_medical_notice(): void
    {
        $this->get(route('home'))
            ->assertSee('Wichtiger Hinweis: Calmify ist kein Medizinprodukt')
            ->assertSee(self::NOTICE);

        $this->get(route('sos'))
            ->assertSee('Wichtiger Hinweis: Calmify ist kein Medizinprodukt')
            ->assertSee(self::NOTICE);
    }

    public function test_every_screen_links_to_the_legal_pages(): void
    {
        foreach (['home', 'sos', 'settings', 'login', 'register', 'legal.about'] as $route) {
            $response = $this->get(route($route));

            $response->assertSee('aria-label="Rechtliches"', false);
            $response->assertSee(route('legal.imprint'));
            $response->assertSee(route('legal.privacy'));
            $response->assertSee(route('legal.about'));
        }
    }

    public function test_current_legal_page_is_marked(): void
    {
        $this->get(route('legal.privacy'))->assertSee('aria-current="page"', false);
    }
}
