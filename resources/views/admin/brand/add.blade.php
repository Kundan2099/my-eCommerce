@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Brand</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right">
                        <a href="{{ route('admin.brand.list') }}" class="btn btn-primary btn-sm">Back</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">

                            <form action="{{ route('admin.brand.insert') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Brand Name <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name') }}" placeholder="Brand Name" required>
                                        @error('name')
                                            <span class="text text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Slug <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="slug"
                                            value="{{ old('slug') }}" placeholder="Slug Ex. URL " required>
                                        @error('slug')
                                            <span class="text text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Status <span style="color: red">*</span></label>
                                        <select class="form-control" name="status">
                                            <option value="0">Active</option>
                                            <option value="1">Inactive</option>
                                        </select>
                                    </div>
                                    <tr>
                                        <div class="form-group">
                                            <label>Meta Title <span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="meta_title"
                                                value="{{ old('meta_title') }}" placeholder="Meta Title " required>
                                            @error('meta_title')
                                                <span class="text text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Meta Description </label>
                                            <textarea type="text" class="form-control" name="meta_description" placeholder="Meta Description ">{{ old('meta_description') }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Meta Keywords </label>
                                            <input type="text" class="form-control" name="meta_keyword"
                                                value="{{ old('meta_keyword') }}" placeholder="Meta Keywords ">
                                        </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
