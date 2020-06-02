<?php

namespace Tests\Feature;

use App\Author;
use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testBookCanBeAdded()
    {
        $response = $this->post('/books', $this->data());

        $book = Book::first();
        
        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->path());
    }

    public function testTitleIsRequired() {
        
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Victor'
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function testAuthorIsRequired() {
        
        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');
    }
    /**
     * anotacja pozwala na dowolne nazwy testow, bez tefgo kazdy musi zaczynac sie od test*
     */
    /** @test */
    public function a_book_can_be_updated() {

        //pokazuje wszystkie bledy po drodze, bez tego nie wiadomo co sie stalo przed assert
        //$this->withoutExceptionHandling();

        $response = $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->patch('/books/'. $book->id, [
            'title' => 'New Title',
            'author_id' => 'New Author'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        // id 2, poniewaz utqworzylismy nowego authora w linie 60
        $this->assertEquals(2, Book::first()->author_id);
        $response->assertRedirect($book->fresh()->path());

    }

    /** @test */
    public function a_book_can_be_deleted() {
        $response = $this->post('/books', $this->data());
        $book = Book::first();

        //w tym miejscu  moglibysmy dac 
        //$this->assertCount(1, Book::all());
        //ale sprawdzamy to samo w 1 tescie, wiec nie musimy (sa 2 szkoly na to)

        $response = $this->delete('/books/'. $book->id);

        $this->assertCount(0, Book::all());

        //walidacja przekierowania po usuniecu ksiazki
        $response->assertRedirect('/books');
    }

    /** @test */
    public function a_new_author_is_autimatically_added()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Cool Book Title',
            'author_id' => 'Victor'
        ]);

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    public function data()
    {
        return [
            'title' => 'Cool Book Title',
            'author_id' => 'Victor'
        ];
    }
}
