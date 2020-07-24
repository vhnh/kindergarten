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
}
