<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     *
     */

      /** @test */
    public function a_book_can_be_added_to_the_library(){
        $response = $this->post('/books', ['title'=>'Book title', 'author'=>'victor']);
        $response->assertStatus(200);
        $this->assertCount(1, Book::all());
    }
        /** @test */
    public function a_title_required(){
        $response = $this->post('/books', ['title'=>'', 'author'=>'victor']);
        $response->assertSessionHasErrors('title');
    }
       /** @test */
    public function a_author_required(){
        $response = $this->post('/books', ['title'=>'book', 'author'=>'']);
        $response->assertSessionHasErrors('author');
    }
      /** @test */
    public function a_book_can_be_updated(){
        $this->withoutExceptionHandling();
        $response = $this->post('/books', ['title'=>'Book title', 'author'=>'New author']);
        $book = Book::first();
        $response = $this->patch('/books/' . $book->id, ['title'=>'New title', 'author'=>'New author']);
        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals('New author', Book::first()->author);
    }
}
