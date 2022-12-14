<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationsTest extends TestCase
{
use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

      /** @test */
      public function a_book_can_be_checked(){
        $book =Book::factory()->create();
        $user =User::factory()->create();
        $book->checkout($user);
        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->check_out_at);
    }
      /** @test */
    public function book_can_be_returned()
    {
        $book =Book::factory()->create();
        $user =User::factory()->create();
        $book->checkout($user);
        $book->checkin($user);
        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertNotNull( Reservation::first()->check_in_at);
        $this->assertEquals(now(), Reservation::first()->check_in_at);

    }

    //if not checked out then exception

       /** @test */
       public function if_not_checked_out()
       {
           $this->expectException(Exception::class);
           $book =Book::factory()->create();
           $user =User::factory()->create();
           $book->checkin($user);


       }
    // user can check out twice

    /** @test */
    public function user_can_check_out()
    {
        $book =Book::factory()->create();
        $user =User::factory()->create();
        $book->checkout($user);
        $book->checkin($user);
        $book->checkout($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::find(2)->user_id);
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertNull( Reservation::find(2)->check_in_at);
        $this->assertEquals(now(), Reservation::find(2)->check_out_at);

        $book->checkin($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::find(2)->user_id);
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertNotNull( Reservation::find(2)->check_in_at);
        $this->assertEquals(now(), Reservation::find(2)->check_in_at);
    }
}
