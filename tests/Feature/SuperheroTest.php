<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Superhero;
use Illuminate\Foundation\Testing\RefreshDatabase;



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
    public function testCreateSuperheroWithEmptyNickname()
    {
        $superhero = Superhero::factory()->make();
        $superhero->nickname = null;
        $response = $this->json('POST', '/api/superheroes/', $superhero->attributesToArray());
        $response->assertStatus(422);
    }
    public function testCreateSuperheroWithEmptyRealname()
    {
        $superhero = Superhero::factory()->make();
        $superhero->real_name = null;
        $response = $this->json('POST', '/api/superheroes/', $superhero->attributesToArray());
        $response->assertStatus(422);
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
    public function testUpdateNonexistingSuperhero()
    {

        $newSuperhero = Superhero::factory()->make()->attributesToArray();
        $response = $this->json('PUT', '/api/superheroes/' . 999999999999999, $newSuperhero);
        $response->assertStatus(400);
    }
    public function testUpdateSuperheroWithEmptyNickname()
    {
        $superhero = Superhero::factory()->create();
        $newSuperhero = Superhero::factory()->make();
        $newSuperhero->real_name = null;
        $response = $this->json('PUT', '/api/superheroes/' . $superhero->id, $newSuperhero->attributesToArray());
        $response->assertStatus(422);
    }
    public function testUpdateSuperheroWithEmptyRealname()
    {
        $superhero = Superhero::factory()->create();
        $newSuperhero = Superhero::factory()->make();
        $newSuperhero->real_name = null;
        $response = $this->json('PUT', '/api/superheroes/' . $superhero->id, $newSuperhero->attributesToArray());
        $response->assertStatus(422);
    }
    public function testDeleteSuperhero()
    {
        $superhero = Superhero::factory()->create();
        $response = $this->delete('/api/superheroes/' . $superhero->id);
        $response->assertStatus(204);
        $find = Superhero::where('id', $superhero->id)->first();
        $this->assertNull($find);
    }
    public function testDeleteNonexistingSuperhero()
    {
        $response = $this->delete('/api/superheroes/' . 999999999999999);
        $response->assertStatus(400);
    }
}
