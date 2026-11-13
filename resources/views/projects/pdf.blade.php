<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Project</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #777; padding: 6px; text-align: left; }
        th { text-align: center; }
        img { width: 70px; height: 55px; object-fit: cover; }
    </style>
</head>
<body>
    <h2>Data Projects</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Project</th>
                <th>Teknologi</th>
                <th>Deskripsi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                @php
                    $imageName = str_ends_with(strtolower($project->image ?? ''), '.jgp')
                        ? substr($project->image, 0, -4) . '.jpg'
                        : $project->image;
                    $imagePath = $imageName && !str_contains($imageName, '/')
                        ? public_path('images/' . $imageName)
                        : ($imageName ? storage_path('app/public/' . $imageName) : null);
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="text-align: center">
                        @if ($imagePath && is_file($imagePath))
                            <img src="{{ $imagePath }}" alt="">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->teknologi }}</td>
                    <td>{{ $project->description }}</td>
                    <td>{{ $project->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
