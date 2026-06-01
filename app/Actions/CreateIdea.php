<?php

namespace App\Actions;

use App\IdeaStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class CreateIdea
{
    public function handle(array $attributes, User $user = null)
    {
        $data = collect($attributes)->only([
            "title",
            "desctiption",
            "status",
            "links"
        ]);
    // this a simple comment for addin
        $data->validate([
            "title" => "required",
            "description" => "required",
            "status" => ["required", new Enum(IdeaStatus::class)],
            "links" => "nullable|array",
            "links.*" => "nullable|url",
            "steps" => "nullable|array",
            "steps.*" => "nullable|string|max:255",
            "image" => "nullable|image|max:2048", // Validate image file
            ""
        ], [
            "links.array" => "Links must be an array",
            "links.*.url" => "Each link must be a valid URL",
            "steps.array" => "Steps must be an array",
            "image.image" => "The image must be a valid image file",
            "image.max" => "The image may not be greater than 2048 kilobytes",
        ]);

        $idea = $user->ideas()->create([
            "title" => $data->title,
            "description" => $data->description,
            "status" => $data->status,
            "links" => $data->links ?? [],
        ]);

        // Store the image with a unique name and save only the filename in the database.
        if ($data->hasFile("image")) {
            $image = $data->file("image");
            $imageName = time() . "_" . $image->getClientOriginalName();
            $image->storeAs("frontend/images/ideas", $imageName, 'public');
            $idea->update(["image_path" => $imageName]);
        }

        $steps = collect($data->steps ?? [])
            ->map(fn($step) => ["description" => $step]);
        $idea->steps()->createMany($steps);
    }
}
