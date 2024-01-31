@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Product</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right">
                        <a href="{{ route('admin.product.list') }}" class="btn btn-primary btn-sm">Back</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">

                            <form action="" method="POST">
                                {{ csrf_field() }}
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title <span style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="title"
                                                    value="{{ old('title', $product->title) }}" placeholder="Title"
                                                    required>
                                                @error('title')
                                                    <span class="text text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>SKU <span style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="sku"
                                                    value="{{ old('title', $product->sku) }}" placeholder="SKU" required>
                                                @error('sku')
                                                    <span class="text text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Category <span style="color: red">*</span></label>
                                                <select class="form-control" name="category_id">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Sub Category <span style="color: red">*</span></label>
                                                <select class="form-control" name="sub_category_id">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Brand <span style="color: red">*</span></label>
                                                <select class="form-control" name="brand">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Color <span style="color: red">*</span></label>
                                            <div>
                                                <label><input type="checkbox" name="color_id[]"> Red</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Price <span style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="price" value=""
                                                    placeholder="Price" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Old Price <span style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="old_price" value=""
                                                    placeholder="Old Price" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Short Desription <span style="color: red">*</span></label>
                                                <textarea class="form-control" name="short_desription" value="" placeholder="Short Desription "></textarea>

                                            </div>
                                        </div>
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
