<?php

namespace Tests\Feature;

use App\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function author_can_be_created()
    {
        $this->post('/authors', $this->data());

        $author = Author::all();

        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->birth);
        $this->assertEquals('1988/14/05', $author->first()->birth->format('Y/d/m'));
    }

    /** @test */
    public function name_is_required()
    {
        $response = $this->post('/authors', array_merge($this->data(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function birth_is_required()
    {
        $response = $this->post('/authors', array_merge($this->data(), ['birth' => '']));

        $response->assertSessionHasErrors('birth');
    }

    private function data()
    {
        return [
            'name' => 'Author Name',
            'birth' => '05/14/1988'
        ];
    }
}
