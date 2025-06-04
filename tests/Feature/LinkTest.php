<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Link;

class LinkTest extends TestCase
{
  public function test_it_shortens_and_redirects(){
    $response = $this->postJson('/api/links', ['url' => 'https://laravel.com']);
    $response->assertCreated()->json('short');

    $code = Link::first()->code;
    $this->get("/{$code}")->assertRedirect('https://laravel.com');

    $this->assertDatabaseCount('clicks', 1);
  }
}
