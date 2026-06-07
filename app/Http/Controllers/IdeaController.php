<?php

namespace App\Http\Controllers;

use App\IdeaStatus;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Enum;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the status from query parameters
        $status = $request->query("status");
        $ideas = [];

        // Check if user is a normal user then show only his ideas otherwise show all ideas
        if (Auth::user()->name == "admin") {
            // Fetch all ideas
            $ideas = Idea::all();
        } else {
            // Fetch ideas for the authenticated user
            $ideas = Auth::user()->ideas()->latest()->get();
        }

        // Fetch ideas based on the status using match expression and 
        $ideas = match ($status) {
            IdeaStatus::PENDING->value => Auth::user()->ideas()->where("status", IdeaStatus::PENDING->value)->latest()->get(),
            IdeaStatus::INPROGRESS->value => Auth::user()->ideas()->where("status", IdeaStatus::INPROGRESS->value)->latest()->get(),
            IdeaStatus::COMPLETED->value => Auth::user()->ideas()->where("status", IdeaStatus::COMPLETED->value)->latest()->get(),
            default => $ideas,
        };

        // show every status how much ideas have as count beside of status name
        // Here also check if user is a normal user then show only his ideas count otherwise show all ideas count
        $statusCounts = [
            IdeaStatus::PENDING->value => Auth::user()->ideas()->where("status", IdeaStatus::PENDING->value)->count(),
            IdeaStatus::INPROGRESS->value => Auth::user()->ideas()->where("status", IdeaStatus::INPROGRESS->value)->count(),
            IdeaStatus::COMPLETED->value => Auth::user()->ideas()->where("status", IdeaStatus::COMPLETED->value)->count(),
            "all" => Auth::user()->name == "admin" ? Idea::all()->count() : Auth::user()->ideas()->count(),
        ];

        return view("idea.index", compact("ideas", "status", "statusCounts"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "description" => "required",
            "status" => ["required", new Enum(IdeaStatus::class)],
            "links" => "nullable|array",
            "links.*" => "nullable|url",
            "steps" => "nullable|array",
            "steps.*.description" => "nullable|string|max:255",
            "image" => "nullable|image|max:2048", // Validate image file
        ], [
            "links.*.url" => "Each link must be a valid URL",
            "steps.array" => "Steps must be an array",
        ]);

        // Store the image with a unique name and save only the filename in the database.
        $imagePath = null;
        if ($request->hasFile("image")) {
            $image = $request->file("image");
            $imageName = time() . "_" . $image->getClientOriginalName();
            $image->storeAs("frontend/images/ideas", $imageName, 'public');
            $imagePath = $imageName;
        }


        $idea = Auth::user()->ideas()->create([
            "title" => $request->title,
            "description" => $request->description,
            "status" => $request->status,
            "links" => $request->links ?? [],
            "image_path" => $imagePath,
        ]);

        $steps = collect($request->steps ?? [])
            ->filter(fn ($step) => filled($step["description"] ?? null))
            ->map(fn ($step) => ["description" => $step["description"]]);

        $idea->steps()->createMany($steps);
       
        return redirect()->route("idea.index")->with("success", "Idea created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        Gate::authorize("modify", $idea);
        
        return view("idea.show", compact("idea"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Idea $idea)
    {
        Gate::authorize("modify", $idea);

        $request->validate([
            "title" => "required",
            "description" => "required",
            "status" => ["required", new Enum(IdeaStatus::class)],
            "links" => "nullable|array",
            "links.*" => "nullable|url",
            "steps" => "nullable|array",
            "steps.*.id" => "nullable|integer",
            "steps.*.description" => "nullable|string|max:255",
            "image" => "nullable|image|max:2048",
        ], [
            "links.*.url" => "Each link must be a valid URL",
            "steps.array" => "Steps must be an array",
        ]);

        $imagePath = $idea->image_path;
        if ($request->hasFile("image")) {
            Storage::disk('public')->delete("frontend/images/ideas/" . $idea->image_path);
            $image = $request->file("image");
            $imageName = time() . "_" . $image->getClientOriginalName();
            $image->storeAs("frontend/images/ideas", $imageName, 'public');
            $imagePath = $imageName;
        }

        $idea->update([
            "title" => $request->title,
            "description" => $request->description,
            "status" => $request->status,
            "links" => $request->links ?? [],
            "image_path" => $imagePath,
        ]);

        $steps = collect($request->steps ?? [])
            ->filter(fn ($step) => filled($step["description"] ?? null));

        $stepIds = $steps
            ->pluck("id")
            ->filter()
            ->all();

        $idea->steps()
            ->whereNotIn("id", $stepIds)
            ->delete();

        $steps->each(function ($step) use ($idea) {
            if (! empty($step["id"])) {
                $idea->steps()
                    ->where("id", $step["id"])
                    ->update(["description" => $step["description"]]);

                return;
            }

            $idea->steps()->create([
                "description" => $step["description"],
            ]);
        });

        return redirect()->route("idea.show", $idea)->with("success", "Idea updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        $idea->delete();
        return redirect()->route("idea.index")->with("success", "Idea deleted successfully");
    }
}
