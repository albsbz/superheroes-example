<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Superhero;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class SuperheroTest extends TestCase
{
    use RefreshDatabase;
    /**
     *
     *
     * @return void
     */

    public function testCreateSuperhero()
    {
        $superhero = Superhero::factory()->make()->attributesToArray();
        $response = $this->post('/api/superheroes/', $superhero);
        $response->assertStatus(204);
    }
    public function testReadSuperhero()
    {
        $superhero = Superhero::factory()->create();
        $response = $this->get('/api/superheroes/' . $superhero->id);
        $response->assertStatus(200)->assertJson([
            'id' => $superhero->id,
        ]);
    }

    public function testUpdateSuperhero()
    {
        $superhero = Superhero::factory()->create();
        $newSuperhero = Superhero::factory()->make()->attributesToArray();
        $response = $this->put('/api/superheroes/' . $superhero->id, $newSuperhero);
        $response->assertStatus(200)->assertJson($newSuperhero);
    }
    public function testDeleteSuperhero()
    {
        $superhero = Superhero::factory()->create();
        $response = $this->delete('/api/superheroes/' . $superhero->id);
        $response->assertStatus(204);
        $find = Superhero::where('id', $superhero->id)->first();
        $this->assertNull($find);
    }
}
