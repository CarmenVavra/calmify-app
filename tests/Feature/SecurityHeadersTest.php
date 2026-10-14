<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    use RefreshDatabase;

    public function test_content_security_policy_allows_only_nonced_scripts(): void
    {
        $response = $this->get(route('home'));

        $policy = (string) $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString("default-src 'self'", $policy);
        $this->assertStringContainsString("frame-ancestors 'none'", $policy);
        $this->assertMatchesRegularExpression("/script-src 'self' 'nonce-[A-Za-z0-9]+'/", $policy);

        preg_match("/'nonce-([A-Za-z0-9]+)'/", $policy, $matches);
        $response->assertSee('<script nonce="'.$matches[1].'">', false);
    }

    public function test_nonce_changes_per_request(): void
    {
        $first = $this->get(route('home'))->headers->get('Content-Security-Policy');
        $second = $this->get(route('home'))->headers->get('Content-Security-Policy');

        $this->assertNotSame($first, $second);
    }

    public function test_hsts_is_only_sent_over_https(): void
    {
        $this->get('http://localhost/')->assertHeaderMissing('Strict-Transport-Security');

        $this->get('https://localhost/')
            ->assertHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
    }
}
