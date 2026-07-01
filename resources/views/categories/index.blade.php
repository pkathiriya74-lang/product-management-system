@extends('layouts.app')

@section('title', 'categories')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard</h2>
        @if(Auth::user()->isAdmin())
            <a href="/category_create" class="btn btn-primary">
                Create Category
            </a>
        @endif
    </div>
    @if($categories->isEmpty())
        <p>No category found </p>
    @endif
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Categories</h5>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        @if(Auth::user()->isAdmin())
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>
                                @if($category->status == 'active')
                                    <span class="badge bg-danger-subtle text-success">
                                        Active
                                    </span>

                                @else($category->status == 'inactive')
                                    <span class="badge bg-warning-subtle text-danger">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            @if(Auth::user()->isAdmin())
                            <td>
                                <a href="/category_edit/{{ $category->id }}" class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <a href="/category_delete/{{ $category->id }}" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this category?')">
                                    Delete
                                </a>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection