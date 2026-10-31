<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProjectController extends Controller
{
    public function index()
    {
        $perPage = (int) request('per_page', 10);
        if (!in_array($perPage, [10, 25, 50], true)) {
            $perPage = 10;
        }
        $search = trim((string) request('search', ''));
        $projects = Project::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('teknologi', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.projects.index', compact('projects', 'perPage', 'search'));
    }

    public function create()
    {
        return view('admin.projects.create', ['project' => new Project(), 'action' => 'Tambah']);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('projects', 'public');
        }
        Project::create($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil ditambahkan.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.create', compact('project') + ['action' => 'Edit']);
    }

    public function update(Request $request, Project $project)
    {
        $data = $this->validatedData($request);
        if ($request->hasFile('image')) {
            if ($project->image && !str_starts_with($project->image, 'http')) {
                Storage::disk('public')->delete($project->image);
            }
            $data['image'] = $request->file('image')->store('projects', 'public');
        } else {
            unset($data['image']);
        }
        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        if ($project->image && !str_starts_with($project->image, 'http')) {
            Storage::disk('public')->delete($project->image);
        }
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'teknologi' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'status' => ['required', 'string', 'in:active,archived,Selesai,In Progress'],
        ]);
    }
}
