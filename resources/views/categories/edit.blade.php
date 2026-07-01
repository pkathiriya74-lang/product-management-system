@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header text-center">
                    <h3>Edit Category</h3>
                </div>

                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/category_edit/{{ $category->id }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}"
                                placeholder="Enter name">
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="statusSwitch" name="status"
                                value="active" {{ $category->status == 'active' ? 'checked' : ''}}>
                            <label class="form-check-label" for="statusSwitch" id="statusLabel">
                                {{ $category->status == 'active' ? 'Active' : 'Inactive' }}
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Update category
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
    <script>
        const statusSwitch = document.getElementById('statusSwitch');
        const statusLabel = document.getElementById('statusLabel');

        statusSwitch.addEventListener('change', function () {
            if (this.checked) {
                statusLabel.textContent = 'Active';
            } else {
                statusLabel.textContent = 'Inactive';
            }
        });
    </script>
@endsection