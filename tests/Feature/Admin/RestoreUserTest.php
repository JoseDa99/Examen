<?php

namespace Tests\Feature\Admin;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RestoreUserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function it_completely_restore_a_user()
    {
        $this->withExceptionHandling();
        $user = factory(User::class)->create([
            'deleted_at' => null,
        ]);

        $this->get('usuarios/' . $user->id . '/papelera')
            ->assertRedirect('usuarios/papelera');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'deleted_at' => null,
        ]);
        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'deleted_at' => null,
        ]);

    }
}
