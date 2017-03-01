<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample(){
        //$this->actingAs(User::find(5))->get('/user')->assertStatus(200); //sin browser
        $this->browse(function ($first, $second) {
            $first->loginAs(User::find(5))
                  ->visit('/')->assertSee('Usuarios');
        });
            }
}



/*
con browser
$this->browse(function (Browser $browser) {
$browser->loginAs(User::find(5))->visit('/user');

//from complete
$browser->visit('/login')
        ->type('username',$user->username)
        ->type('password',$user->password)
        ->press('submit')
        ->assertSee('Usuarios');
});




*/