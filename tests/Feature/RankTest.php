<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RankTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetRanks()
    {
        $game = factory('App\Game')->create();
        $rank = factory('App\Rank')->create([
            'game_id' => $game->id,
        ]);

        $response = $this->get('/api/games/'. $game->id .'/ranks');

        $response->assertStatus(200);

        $this->assertDatabaseHas('ranks', [
            'name' => $rank->name,
            'image' => $rank->image,
            'game_id' => $game->id,
        ]);

        $response->assertJsonFragment([
            'name' => $rank->name,
            'image' => $rank->image,
            'game_id' => $game->id,
        ]);
    }

    public function testGetRank()
    {
        $game = factory('App\Game')->create();
        $rank = factory('App\Rank')->create([
            'name' => "Rank test",
            'image' => 'https://imagetest.com/image.png',
            'game_id' => $game->id,
        ]);

        $response = $this->get('/api/games/'. $game->id .'/ranks/'. $rank->id);

        $response->assertStatus(200);

        $this->assertDatabaseHas('ranks', [
            'name' => "Rank test",
            'image' => 'https://imagetest.com/image.png',
            'game_id' => $game->id,
        ]);

        $response->assertJsonFragment([
            'name' => "Rank test",
            'image' => 'https://imagetest.com/image.png',
            'game_id' => $game->id,
        ]);
    }

    public function testCreateRankWithoutImage()
    {
        $game = factory('App\Game')->create();

        $response = $this->post('/api/games/'. $game->id .'/ranks', [
            'name' => "Rank test",
            'game_id' => $game->id,
        ]);

        $this->assertDatabaseHas('ranks', [
            'name' => "Rank test",
            'game_id' => $game->id,
        ]);

        $response->assertJsonFragment([
            'name' => "Rank test",
            'game_id' => $game->id,
        ]);
    }

    public function testCreateRankWithImage()
    {
        $game = factory('App\Game')->create();

        $response = $this->post('/api/games/'. $game->id .'/ranks', [
            'name' => "Rank test",
            'image' => 'https://imagetest.com/image.png',
            'game_id' => $game->id,
        ]);

        $this->assertDatabaseHas('ranks', [
            'name' => "Rank test",
            'image' => 'https://imagetest.com/image.png',
            'game_id' => $game->id,
        ]);

        $response->assertJsonFragment([
            'name' => "Rank test",
            'image' => 'https://imagetest.com/image.png',
            'game_id' => $game->id,
        ]);
    }

    public function testUpdateRankWithoutImage()
    {
        $game = factory('App\Game')->create();
        $rank = factory('App\Rank')->create([
            'game_id' => $game->id,
        ]);

        $response = $this->put('/api/games/'. $game->id .'/ranks/'. $rank->id, [
            'name' => "Rank test update",
            'game_id' => $game->id,
        ]);

        $this->assertDatabaseHas('ranks', [
            'name' => "Rank test update",
            'game_id' => $game->id,
        ]);

        $response->assertJsonFragment([
            'name' => "Rank test update",
            'game_id' => $game->id,
        ]);
    }

    public function testUpdateRankWithImage()
    {
        $game = factory('App\Game')->create();
        $rank = factory('App\Rank')->create([
            'game_id' => $game->id,
        ]);

        $response = $this->put('/api/games/'. $game->id .'/ranks/'. $rank->id, [
            'name' => "Rank test update",
            'image' => 'https://imagetest.com/imageupdate.png',
            'game_id' => $game->id,
        ]);

        $this->assertDatabaseHas('ranks', [
            'name' => "Rank test update",
            'image' => 'https://imagetest.com/imageupdate.png',
            'game_id' => $game->id,
        ]);

        $response->assertJsonFragment([
            'name' => "Rank test update",
            'image' => 'https://imagetest.com/imageupdate.png',
            'game_id' => $game->id,
        ]);
    }

    public function testDeletRank()
    {
        $game = factory('App\Game')->create();
        $rank = factory('App\Rank')->create([
            'game_id' => $game->id,
        ]);

        $response = $this->delete('/api/games/'. $game->id .'/ranks/'. $rank->id);

        $this->assertDatabaseMissing('ranks', [
            'name' => $rank->name,
            'image' => $rank->image,
            'game_id' => $game->id,
        ]);

        $response->assertJsonFragment([
            'message' => "Success",
        ]);
    }
}
