@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-center pt-5">
                <form class="card w-50" method="POST" action="{{route('admin.attributes.update', $attribute)}}">
                    @csrf
                    @method('PUT')

                    <h5 class="card-header">Edit attribute</h5>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Attribute name"
                                   value="{{ old('name') ?? $attribute->name }}">

                            @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        {{--
                        // TODO: make options list
                        <div class="mb-3">
                            <label for="options">Options</label>
                        </div>
                        --}}
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-outline-success">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
