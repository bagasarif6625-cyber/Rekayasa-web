@extends('admin.template')

@section('title', 'Data Projects')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <h1 class="h3 mb-0">Data Projects</h1>
        <header class="justify-content-end">
            <a href="{{ route('projects.create') }}" class="btn btn-primary">Tambah Project</a>
            <a href="{{ route('projects.pdf') }}" class="btn btn-danger" target="_blank">Cetak PDF</a>
        </header>
        
        
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button></div>
    @endif

    <div class="card content-card">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.projects.index') }}" class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <label class="small">Tampilkan
                    <select name="per_page" class="form-select form-select-sm d-inline-block w-auto mx-1" onchange="this.form.submit()">
                        <option value="10" @selected($perPage === 10)>10</option><option value="25" @selected($perPage === 25)>25</option><option value="50" @selected($perPage === 50)>50</option>
                    </select> entri
                </label>
                <label class="small">Cari: <input name="search" type="search" value="{{ $search }}" class="form-control form-control-sm d-inline-block w-auto" placeholder="Cari project..."></label>
                <button class="btn btn-sm btn-outline-secondary">Cari</button>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0" id="projects-table">
                    <thead class="table-light"><tr><th>No</th><th>Image</th><th>Title</th><th>Teknologi</th><th>Description</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td>{{ $projects->firstItem() + $loop->index }}</td>
                            <td class="text-center">@if ($project->image)<img src="{{ str_starts_with($project->image, 'http') ? $project->image : (str_contains($project->image, '/') ? asset('storage/' . $project->image) : asset('images/' . $project->image)) }}" alt="{{ $project->title }}" style="width:64px;height:58px;object-fit:cover">@else<span class="text-muted">-</span>@endif</td>
                            <td>{{ $project->title }}</td><td>{{ $project->teknologi }}</td><td>{{ $project->description }}</td>
                            <td>{{ $project->status }}</td>
                            <td class="text-nowrap"><a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus project ini?')">@csrf @method('DELETE')<button class="btn btn-danger btn-sm">Hapus</button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data project.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 gap-2">
                <small class="text-muted">Menampilkan {{ $projects->firstItem() ?? 0 }}–{{ $projects->lastItem() ?? 0 }} dari {{ $projects->total() }} entri</small>
                {{ $projects->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

