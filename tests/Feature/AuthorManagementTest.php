<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
/** @test */
    public function an_author_can_be_created()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/authors', [
            'name'=>'Author name',
            'dob'=>'02/13/1999'
        ]);
        $author = Author::all();
        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob );
        $author = Author::first();
        $this->assertEquals('02/13/1999',$author->first()->dob->format('m/d/Y') );
        $response->assertRedirect($author->path());
    }
}
