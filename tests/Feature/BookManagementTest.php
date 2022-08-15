<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
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
        $response = $this->post('/books',$this->createData() );
        $this->assertCount(1, Book::all());
        $book = Book::first();
        $response->assertRedirect($book->path());

    }
        /** @test */
    public function a_title_required(){
        $response = $this->post('/books', array_merge($this->createData(), ['title'=>'']) );
        $response->assertSessionHasErrors('title');
    }
       /** @test */
    public function a_author_required(){
        $response = $this->post('/books',array_merge($this->createData(), ['author_id'=>'']));
        $response->assertSessionHasErrors('author_id');
    }
      /** @test */
    public function a_book_can_be_updated(){
        $this->withoutExceptionHandling();

        $response = $this->post('/books', $this->createData());
        $book = Book::first();
        $response = $this->patch($book->path(), $this->createData());
        $this->assertEquals('Book title', Book::first()->title);
        $this->assertEquals(1, Book::first()->author_id);
        $response->assertRedirect($book->fresh()->path());

    }


    /** @test */
    public function a_book_can_be_deleted()
    {
        $response = $this->post('/books',$this->createData());
        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response = $this->delete($book->path());
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
    /** @test */

    public function a_new_author_automaticely_added()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', $this->createData());
        $book = Book::first();
        $author = Author::first();
        $this->assertCount(1, Author::all());
        $this->assertEquals($author->id, $book->author_id);


    }
    private function createData() : array
    {
        return ['title'=>'Book title', 'author_id'=>1];

    }
}
