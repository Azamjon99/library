<?php

namespace Tests\Unit;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */

       /** @test */
    public function only_name_required()
    {
        Author::firstOrCreate([
            'name'=> 'John Doe',
        ]);

        $this->assertCount(1, Author::all());
    }
}
