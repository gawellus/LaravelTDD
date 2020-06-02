<?php

namespace Tests\Unit;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function author_id_is_saved()
    {
        Book::create([
            'title' => 'Cool Title',
            'author_id' => 1
        ]);

        $this->assertCount(1, Book::all());
    }
}
