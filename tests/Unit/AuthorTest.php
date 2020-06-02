<?php

namespace Tests\Unit;

use App\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

/**
 * to jest test nizszego poziomu niz feature
 * napisalismy go, poniewaz nie przechodzil test z dodawaniem 
 * ksiazki z imieniem authors, ale bez jego daty urodzin
 * test nie pokazal, w ktorym miejsu jest problem, wiec pokrylismy testami
 * nizszego poziomu klase author, zeby znalezc winopwajce
 */

    /** @test */
    public function only_name_is_required_to_create_author()
    {
        Author::firstOrCreate([
            'name' => 'John Doe'
        ]);

        $this->assertCount(1, Author::all());
    }
}
