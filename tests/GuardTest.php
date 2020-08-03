<?php

namespace Vhnh\Kindergarten\Tests;

use Illuminate\Support\Facades\Route;
use Vhnh\Kindergarten\AuthorizationException;

class GuardTest extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware(['web', 'kindergarten'])->get('guard', function () {
            return 'OK';
        });
    }

    protected function getPackageProviders($app)
    {
        return ['Vhnh\Kindergarten\ServiceProvider'];
    }

    /** @test */
    public function it_checks_if_the_user_has_its_age_veridfied()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);

        $this->get('/guard');
    }

    /** @test */
    public function it_authorizes_users_if_the_age_has_been_verified()
    {
        $this->withSession(['verified_age' => true])->get('/guard')->assertOk();

        $this->withSession(['verified_age' => null])->get('/guard')->assertStatus(403);
        $this->withSession(['verified_age' => false])->get('/guard')->assertStatus(403);
    }

    /**
     * @test
     * @dataProvider crawlerAgentsProvider
     */
    public function it_authorizes_crawlers($agent)
    {
        $this->get('/guard', ['HTTP_USER_AGENT' => $agent])->assertOk();
    }

    public function crawlerAgentsProvider()
    {
        return [
            ['Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'],
            ['Mozilla/5.0 (compatible; Bingbot/2.0; +http://www.bing.com/bingbot.htm)'],
            ['Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)'],
            ['DuckDuckBot/1.0; (+http://duckduckgo.com/duckduckbot.html)'],
            ['facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)'],
        ];
    }
}
