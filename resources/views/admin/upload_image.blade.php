@extends('layout.app')

@section('content')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<script>
    // Automatically fade out after 3 seconds
    setTimeout(function() {
        let alert = document.getElementById('success-alert');
        if (alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close(); // Triggers Bootstrap's dismiss animation
        }
    }, 3000); // 3 seconds
</script>
@endif

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-5">
            <div class="card-header">Upload Image</div>

            <!-- Upload image -->
            <div class="card-body">
                <form method="POST" action="{{ route('images.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="imageType" class="form-label">Image Type</label>
                        <select class="form-control" id="imageType" name="imageType" required>
                            <option value="">-- Select Type --</option>
                            <option value="wedding">Wedding</option>
                            <option value="event">Event</option>
                            <option value="fashion">Fashion</option>
                            <option value="convo">Convocation</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>

        <!-- Filter Dropdown -->
        <form method="GET" action="{{ route('images.index') }}" class="mb-3">
            <label for="type">Choose Image Type:</label>
            <select name="type" id="type" onchange="this.form.submit()">
                <option value="">-- All Types --</option>
                @foreach($types as $type)
                <option value="{{ $type }}" {{ $filterType == $type ? 'selected' : '' }}>
                    {{ ucfirst($type) }}
                </option>
                @endforeach
            </select>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Preview</th>
                    <th scope="col">File Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($images as $image)
                <tr>
                    <td>{{ $image->id }}</td>
                    <td><img src="{{ asset('storage/images/'. $image->filename) }}" width="100" alt="Image"></td>
                    <td>{{ $image->filename }}</td>
                    <td>{{$image->image_type }}</td>
                    <td>
                        <form action="{{ route('image.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection