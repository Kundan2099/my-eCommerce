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
                                                <select class="form-control" id="ChangeCategory" name="category_id">
                                                    <option value="">Select</option>
                                                    @foreach ($getCtategory as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Sub Category <span style="color: red">*</span></label>
                                                <select class="form-control" id="getSubCategory" name="sub_category_id">
                                                    <option value="">Select</option>
                                                    @foreach ($getCtategory as $subcategory)
                                                        <option value="">
                                                        </option>
                                                    @endforeach
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

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Color <span style="color: red">*</span></label>
                                                <div>
                                                    <label><input type="checkbox" name="color_id[]"> Red</label>
                                                </div>
                                                <div>
                                                    <label><input type="checkbox" name="color_id[]"> White</label>
                                                </div>
                                                <div>
                                                    <label><input type="checkbox" name="color_id[]"> Green</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Price ($)<span style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="price" value=""
                                                    placeholder="Price" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Old Price ($)<span style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="old_price" value=""
                                                    placeholder="Old Price" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Size <span style="color: red">*</span></label>
                                                <div>
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Price ($)</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name=""
                                                                        class="form-control">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name=""
                                                                        class="form-control">
                                                                </td>
                                                                <td>
                                                                    <button type="button"
                                                                        class="btn btn-primary">Add</button>
                                                                    <button type="button"
                                                                        class="btn btn-danger">Delete</button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name=""
                                                                        class="form-control">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name=""
                                                                        class="form-control">
                                                                </td>
                                                                <td>
                                                                    <button type="button"
                                                                        class="btn btn-danger">Delete</button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name=""
                                                                        class="form-control">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name=""
                                                                        class="form-control">
                                                                </td>
                                                                <td>
                                                                    <button type="button"
                                                                        class="btn btn-danger">Delete</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
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

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Desription <span style="color: red">*</span></label>
                                                <textarea class="form-control" name="desription" value="" placeholder="Desription "></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Additional Information <span style="color: red">*</span></label>
                                                <textarea class="form-control" name="additional_information" value="" placeholder="Additional Information="></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Shiping Returns <span style="color: red">*</span></label>
                                                <textarea class="form-control" name="shiping_&_returns" value="" placeholder="Shiping Returns "></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Status <span style="color: red">*</span></label>
                                        <select class="form-control" name="status">
                                            <option value="0">Active</option>
                                            <option value="1">Inactive</option>
                                        </select>
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

@section('script')
    <script type="text/javascript">
        $('body').delegate('#ChangeCategory', 'change', function(e) {
            var id = $(this).val();
            $.ajax({
                type: "POST"
                url: "{{ url('admin/get_sub_category') }}",
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json"
                success: function(data) {
                    $('#getsubCategory').html(data.html);
                },
                error: function(data) {}
            });
        });
    </script>
@endsection
