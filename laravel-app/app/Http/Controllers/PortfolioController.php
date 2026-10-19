<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{

    // Display the portfolio using the user's selected template.
    public function dashboard(Request $request)
    {
        $portfolio = $request->user()
            ->portfolio()
            ->with([
                'education',
                'skills',
                'projects',
                'experiences',
            ])
            ->first();

        if (!$portfolio) {
            return redirect()->route('portfolio.create');
        }

        $template = in_array(
            $portfolio->selected_template,
            ['simple', 'modern', 'creative'],
            true
        ) ? $portfolio->selected_template : 'simple';

        return view(
            'portfolio.templates.' . $template,
            compact('portfolio')
        );
    }


    // Display the logged-in user's portfolio management page.
    public function manage(Request $request)
    {
        $portfolio = $request->user()
            ->portfolio()
            ->first();

        return view('portfolio.manage', compact('portfolio'));
    }

    // Display the edit form with the user's saved information.
    public function edit(Request $request)
    {
        $portfolio = $request->user()
            ->portfolio()
            ->with([
                'education',
                'skills',
                'projects',
                'experiences',
            ])
            ->firstOrFail();

        return view('portfolio.edit', compact('portfolio'));
    }

    // Update the existing portfolio and related information.
    public function update(Request $request)
    {
        $portfolio = $request->user()
            ->portfolio()
            ->firstOrFail();

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],

            'profile_picture' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'email' => ['required', 'email', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'about_me' => ['nullable', 'string'],

            'website_url' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],

            'selected_template' => [
                'required',
                'in:simple,modern,creative',
            ],

            'education' => ['nullable', 'array'],
            'education.*.school' => ['nullable', 'string', 'max:255'],
            'education.*.course_program' => ['nullable', 'string', 'max:255'],
            'education.*.year' => ['nullable', 'string', 'max:50'],

            'skills' => ['nullable', 'array'],
            'skills.*.skill_name' => ['nullable', 'string', 'max:255'],

            'projects' => ['nullable', 'array'],
            'projects.*.title' => ['nullable', 'string', 'max:255'],
            'projects.*.description' => ['nullable', 'string'],
            'projects.*.link' => ['nullable', 'url', 'max:255'],

            'experiences' => ['nullable', 'array'],
            'experiences.*.organization' => [
                'nullable', 'string', 'max:255',
            ],
            'experiences.*.position' => [
                'nullable', 'string', 'max:255',
            ],
            'experiences.*.description' => ['nullable', 'string'],
        ]);

        // Preserve the current profile picture unless a new one is uploaded.
        $oldProfilePicturePath = $portfolio->profile_picture_path;
        $profilePicturePath = $oldProfilePicturePath;

        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request
                ->file('profile_picture')
                ->store('profile-pictures', 'public');
        }

        // Update the portfolio and its related entries together.
        DB::transaction(function () use (
            $portfolio,
            $validated,
            $profilePicturePath
        ) {
            $portfolio->update([
                'full_name' => $validated['full_name'],
                'profile_picture_path' => $profilePicturePath,
                'email' => $validated['email'],
                'contact_number' => $validated['contact_number'] ?? null,
                'address' => $validated['address'] ?? null,
                'about_me' => $validated['about_me'] ?? null,
                'website_url' => $validated['website_url'] ?? null,
                'facebook_url' => $validated['facebook_url'] ?? null,
                'linkedin_url' => $validated['linkedin_url'] ?? null,
                'github_url' => $validated['github_url'] ?? null,
                'selected_template' => $validated['selected_template'],
            ]);

            // Replace education entries with the submitted entries.
            $portfolio->education()->delete();

            foreach ($validated['education'] ?? [] as $item) {
                if (!collect($item)->contains(
                    fn ($value) => filled($value)
                )) {
                    continue;
                }

                $portfolio->education()->create([
                    'school' => $item['school'] ?? null,
                    'course_program' => $item['course_program'] ?? null,
                    'year' => $item['year'] ?? null,
                ]);
            }

            // Replace skills.
            $portfolio->skills()->delete();

            foreach ($validated['skills'] ?? [] as $item) {
                if (!filled($item['skill_name'] ?? null)) {
                    continue;
                }

                $portfolio->skills()->create([
                    'skill_name' => $item['skill_name'],
                ]);
            }

            // Replace projects.
            $portfolio->projects()->delete();

            foreach ($validated['projects'] ?? [] as $item) {
                if (!collect($item)->contains(
                    fn ($value) => filled($value)
                )) {
                    continue;
                }

                $portfolio->projects()->create([
                    'title' => $item['title'] ?? null,
                    'description' => $item['description'] ?? null,
                    'link' => $item['link'] ?? null,
                ]);
            }

            // Replace work experience entries.
            $portfolio->experiences()->delete();

            foreach ($validated['experiences'] ?? [] as $item) {
                if (!collect($item)->contains(
                    fn ($value) => filled($value)
                )) {
                    continue;
                }

                $portfolio->experiences()->create([
                    'organization' => $item['organization'] ?? null,
                    'position' => $item['position'] ?? null,
                    'description' => $item['description'] ?? null,
                ]);
            }
        });

        // Remove the old image only after the database update succeeds.
        if (
            $request->hasFile('profile_picture')
            && $oldProfilePicturePath
        ) {
            Storage::disk('public')->delete($oldProfilePicturePath);
        }

        return redirect()
            ->route('portfolio.manage')
            ->with('success', 'Your portfolio has been updated successfully!');
    }

    // Display the template selection page.
    public function changeTemplate(Request $request)
    {
        $portfolio = $request->user()
            ->portfolio()
            ->firstOrFail();

        return view('portfolio.template', compact('portfolio'));
    }

    // Save the selected template.
    public function updateTemplate(Request $request)
    {
        $validated = $request->validate([
            'selected_template' => [
                'required',
                'in:simple,modern,creative',
            ],
        ]);

        $portfolio = $request->user()
            ->portfolio()
            ->firstOrFail();

        $portfolio->update([
            'selected_template' => $validated['selected_template'],
        ]);

        // Creative requires a separate palette selection step.
        if ($validated['selected_template'] === 'creative') {
            return redirect()->route('portfolio.palette');
        }

        return redirect()
            ->route('portfolio.manage')
            ->with('success', 'Portfolio template updated successfully!');
    }

    // Display the palette selection page for Creative portfolios only.
    public function choosePalette(Request $request)
    {
        $portfolio = $request->user()
            ->portfolio()
            ->firstOrFail();

        if ($portfolio->selected_template !== 'creative') {
            return redirect()->route('portfolio.manage');
        }

        return view('portfolio.palette', compact('portfolio'));
    }

    // Save the selected color palette for Creative only.
    public function updatePalette(Request $request)
    {
        $validated = $request->validate([
            'color_palette' => [
                'required',
                'in:ocean,sunset,lavender,forest,monochrome',
            ],
        ]);

        $portfolio = $request->user()
            ->portfolio()
            ->firstOrFail();

        if ($portfolio->selected_template !== 'creative') {
            return redirect()
                ->route('portfolio.manage')
                ->with('error', 'Palettes are only available for Creative.');
        }

        $portfolio->update([
            'color_palette' => $validated['color_palette'],
        ]);

        return redirect()
            ->route('portfolio.manage')
            ->with('success', 'Creative palette saved successfully!');
    }

    // Delete the logged-in user's portfolio.
public function destroy(Request $request)
{
    // Only find the portfolio belonging to this user.
    $portfolio = $request->user()
        ->portfolio()
        ->firstOrFail();

    // Remember the picture path before deleting the portfolio.
    $profilePicturePath = $portfolio->profile_picture_path;

    // Delete the portfolio.
    // Related entries are deleted through the database cascade rules.
    $portfolio->delete();

    // Remove the uploaded profile picture, if one exists.
    if ($profilePicturePath) {
        Storage::disk('public')->delete($profilePicturePath);
    }

    return redirect()
        ->route('portfolio.create')
        ->with(
            'success',
            'Portfolio deleted successfully. You can create a new one anytime!'
        );
}
    // Display the portfolio creation form.
    public function create()
    {
        return view('portfolio.create');
    }

    // Validate and save the first portfolio for the logged-in user.
    public function store(Request $request)
    {
        // Each account can create one portfolio.
        if ($request->user()->portfolio()->exists()) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'You already have a portfolio.');
        }

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],

            'profile_picture' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'email' => ['required', 'email', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'about_me' => ['nullable', 'string'],

            'website_url' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],

            'selected_template' => [
                'required',
                'in:simple,modern,creative',
            ],

            'education' => ['nullable', 'array'],
            'education.*.school' => [
                'nullable', 'string', 'max:255',
            ],
            'education.*.course_program' => [
                'nullable', 'string', 'max:255',
            ],
            'education.*.year' => [
                'nullable', 'string', 'max:50',
            ],

            'skills' => ['nullable', 'array'],
            'skills.*.skill_name' => [
                'nullable', 'string', 'max:255',
            ],

            'projects' => ['nullable', 'array'],
            'projects.*.title' => [
                'nullable', 'string', 'max:255',
            ],
            'projects.*.description' => ['nullable', 'string'],
            'projects.*.link' => [
                'nullable', 'url', 'max:255',
            ],

            'experiences' => ['nullable', 'array'],
            'experiences.*.organization' => [
                'nullable', 'string', 'max:255',
            ],
            'experiences.*.position' => [
                'nullable', 'string', 'max:255',
            ],
            'experiences.*.description' => ['nullable', 'string'],
        ]);

        // Store the uploaded profile picture, if supplied.
        $profilePicturePath = null;

        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request
                ->file('profile_picture')
                ->store('profile-pictures', 'public');
        }

        // Create the portfolio under the current user's account.
        $portfolio = Portfolio::create([
            'user_id' => $request->user()->id,
            'full_name' => $validated['full_name'],
            'profile_picture_path' => $profilePicturePath,
            'email' => $validated['email'],
            'contact_number' => $validated['contact_number'] ?? null,
            'address' => $validated['address'] ?? null,
            'about_me' => $validated['about_me'] ?? null,
            'website_url' => $validated['website_url'] ?? null,
            'facebook_url' => $validated['facebook_url'] ?? null,
            'linkedin_url' => $validated['linkedin_url'] ?? null,
            'github_url' => $validated['github_url'] ?? null,
            'selected_template' => $validated['selected_template'],
        ]);

        // Save education entries.
        foreach ($validated['education'] ?? [] as $item) {
            if (!collect($item)->contains(fn ($value) => filled($value))) {
                continue;
            }

            $portfolio->education()->create([
                'school' => $item['school'] ?? null,
                'course_program' => $item['course_program'] ?? null,
                'year' => $item['year'] ?? null,
            ]);
        }

        // Save skills.
        foreach ($validated['skills'] ?? [] as $item) {
            if (!filled($item['skill_name'] ?? null)) {
                continue;
            }

            $portfolio->skills()->create([
                'skill_name' => $item['skill_name'],
            ]);
        }

        // Save projects.
        foreach ($validated['projects'] ?? [] as $item) {
            if (!collect($item)->contains(fn ($value) => filled($value))) {
                continue;
            }

            $portfolio->projects()->create([
                'title' => $item['title'] ?? null,
                'description' => $item['description'] ?? null,
                'link' => $item['link'] ?? null,
            ]);
        }

        // Save work experience entries.
        foreach ($validated['experiences'] ?? [] as $item) {
            if (!collect($item)->contains(fn ($value) => filled($value))) {
                continue;
            }

            $portfolio->experiences()->create([
                'organization' => $item['organization'] ?? null,
                'position' => $item['position'] ?? null,
                'description' => $item['description'] ?? null,
            ]);
        }

        // If Creative was selected, choose the palette next.
        if ($portfolio->selected_template === 'creative') {
            return redirect()->route('portfolio.palette');
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Your portfolio has been saved successfully!');
    }
}
