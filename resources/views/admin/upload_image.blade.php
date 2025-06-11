@extends('layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-5">
            <div class="card-header">Upload Image</div>

            <div class="card-body">
                <form method="POST" action="{{ route('images.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="imageType" class="form-label">Image Type</label>
                        <select class="form-control" id="imageType" name="imageType" required>
                            <option value="">-- Select Type --</option>
                            <option value="wedding">Wedding</option>
                            <option value="birthday">Birthday</option>
                            <option value="event">Event</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Delete Image</div>

            <div class="card-body">
                <form method="POST" action="{{ route('images.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <select name="imageType" id="imageType">
                            <option value="">Select type of image</option>
                            <option value="wedding">Wedding</option>
                            <option value="corporate">Corporate</option>
                            <option value="fashion">Fashion</option>
                            <option value="convocation">Convocation</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection