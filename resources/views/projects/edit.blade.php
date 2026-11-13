@extends('admin.template')

@section('title', 'Edit Project')

@section('content')
<div class="mt-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3>Edit Project</h3>
            @if ($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif
            <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Nama Project</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="teknologi" class="form-label">Teknologi</label>
                        <input type="text" name="teknologi" id="teknologi" value="{{ old('teknologi', $project->teknologi) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="">Pilih Status</option>
                            @foreach (['active', 'archived', 'Selesai', 'In Progress'] as $status)
                                <option value="{{ $status }}" @selected(old('status', $project->status) === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" accept="image/*" class="form-control">
                        @if ($project->image)
                            <img class="mt-2" src="{{ str_starts_with($project->image, 'http') ? $project->image : (str_contains($project->image, '/') ? asset('storage/' . $project->image) : asset('images/' . $project->image)) }}" alt="{{ $project->title }}" style="height:70px">
                        @endif
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control" required>{{ old('description', $project->description) }}</textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-danger">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
