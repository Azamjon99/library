<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookCheckoutTest extends TestCase
{
use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */


        /** @test */
        public function a_book_can_be_checked_out_by_signed_user()
        {
            $this->withoutExceptionHandling();
            $book = Book::factory()->create();
            /** @var User */
            $user =User::factory()->create();
            $this->actingAs($user)->post('/checkout/' . $book->id);
            $this->assertCount(1, Reservation::all());
            $this->assertEquals($user->id, Reservation::first()->user_id);
            $this->assertEquals($book->id, Reservation::first()->book_id);
            $this->assertEquals(now(), Reservation::first()->check_out_at);
        }
        /** @test */
        public function only_signed_users_can_check_out()
        {

            $book = Book::factory()->create();
            /** @var User */
            $user =User::factory()->create();
            $this->post('/checkout/' . $book->id)->assertRedirect('/login');
            $this->assertCount(0, Reservation::all());

        }
        public function only_real_books_can_be_checked_out()
        {
            /** @var User */
            $user =User::factory()->create();
            $this->actingAs($user)->post('/checkout/123' )->assertStatus(404);
            $this->assertCount(0, Reservation::all());
        }
        /** @test */
        public function a_book_can_be_checked_in_by_signed_user()
        {
            $this->withoutExceptionHandling();
            $book = Book::factory()->create();
            /** @var User */
            $user =User::factory()->create();
            $this->actingAs($user)->post('/checkout/' . $book->id);
            $this->actingAs($user)->post('/checkin/' . $book->id);
            $this->assertCount(1, Reservation::all());
            $this->assertEquals($user->id, Reservation::first()->user_id);
            $this->assertEquals($book->id, Reservation::first()->book_id);
            $this->assertEquals(now(), Reservation::first()->check_in_at);
            $this->assertEquals(now(), Reservation::first()->check_out_at);
        }

        /** @test */
        public function only_signed_users_can_check_in()
        {

            $book = Book::factory()->create();
            /** @var User */
            $user =User::factory()->create();
            $this->post('/checkout/' . $book->id)->assertRedirect('/login');
            $this->post('/checkin/' . $book->id)->assertRedirect('/login');
            $this->assertCount(0, Reservation::all());

        }

        /** @test */
        public function a_404_is_thrown_if_a_book_is_not_checked()
        {
            $this->withoutExceptionHandling();
            $book = Book::factory()->create();
            /** @var User */
            $user =User::factory()->create();
            $this->actingAs($user)->post('/checkin/' . $book->id)->assertStatus(404);
            $this->assertCount(0, Reservation::all());

        }
    }
