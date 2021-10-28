@extends('layouts.backend')

@section('title', 'Firmas')

@section('content')
<div class="col-md-6">
    <!-- Normal Form -->
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Normal Form</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option">
                    <i class="si si-wrench"></i>
                </button>
            </div>
        </div>
        <div class="block-content">
            <form action="{{ route('admin.inventory.admin-signatures.store') }}" method="POST"
                enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="form-group">
                    <label class="col-12">Bootstrap's Custom File Input</label>
                    <div class="col-8">
                        <div class="custom-file">
                            <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                            <input type="file" class="custom-file-input" id="imagen-firma" name="imagen-firma"
                                data-toggle="custom-file-input" accept="image/*">
                            <label class="custom-file-label" for="imagen-firma">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-alt-primary">Login</button>
                </div>
            </form>
        </div>
        <img src="/storage/yQC0q1kY6iZMxdSeA8ara8plQaXOsF7IafL6vn77.jpg" alt="">
    </div>
    <!-- END Normal Form -->
</div>

@endsection