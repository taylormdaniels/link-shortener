<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Link;

class LinkTest extends TestCase
{
  use RefreshDatabase;

  public function test_it_shortens_and_redirects(){
    $response = $this->postJson('/api/links', ['url' => 'https://laravel.com']);
    $response->assertCreated()->json('short');

    $slug = Link::first()->slug;
    $this->get("/{$slug}")->assertRedirect('https://laravel.com');

    $this->assertDatabaseCount('clicks', 1);
  }

  public function test_it_allows_custom_slug(){
    $response = $this->postJson('/api/links', [
      'url' => 'https://laravel.com',
      'slug' => 'laravel-docs',
    ]);

    $response->assertCreated()
             ->assertJsonPath('link.slug', 'laravel-docs');
  }

  public function test_it_returns_conflict_when_slug_taken(){
    Link::create(['slug' => 'taken', 'original_url' => 'https://a.com']);

    $response = $this->postJson('/api/links', [
      'url' => 'https://b.com',
      'slug' => 'taken',
    ]);

    $response->assertStatus(409)
             ->assertExactJson(['error' => 'slug_taken']);
  }
}
