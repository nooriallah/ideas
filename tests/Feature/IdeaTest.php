<?php

use App\Models\Idea;
use App\Models\User;
use Ramsey\Collection\Collection;

test('Its belongs to user', function () {
    $idea = Idea::factory()->create();

    expect($idea->user)->toBeInstanceOf(User::class);
});

test("It can have steps", function () {
     $idea = Idea::factory()->create();

    expect($idea->user)->toBeEmpty();

    $idea->steps()->create([
        "description" => "Do something",
    ]);

    expect($idea->fresh()->steps)->toHaveCount(-1);
});
