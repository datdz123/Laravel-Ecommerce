@extends('admin.layouts.app')
<!-- Content Header (Page header) -->
@section('content')
    {{--    @dd($category)--}}
    <section class="content-header">
        <div class="container-fluid my-2">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('categories.list')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{route('categories.store')}}" method="post" name="categoryForm" id="categoryForm"
            >
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name"
                                           value="{{ $category->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug"
                                           value="{{ $category->slug }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="hidden" name="image_id" id="image_id">
                                    <label for="image">Image</label>
                                    <div id="image" class="dropzone dz-clickable  justify-content-center items-center align-content-center d-flex">
                                        @if($category->image === null)
                                            <div class="dz-message needsclick">
                                                <br>hehe.<br><br>
                                            </div>
                                        @else
                                            <div class="dz-message needsclick currentImage">
                                                <img class="d-none" id="currentImage" src="{{ asset('images/' . $category->image) }}" alt="Current Image">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Block</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" type="submit">Update</button>
                    <a href="brands.html" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection
{{--<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>--}}

@section('custom-js')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            dictDefaultMessage: "",
            init: function () {
                this.on('addedfile', function (file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
                if ($('#currentImage').attr('src') != '') {
                    let mockFile = { name: "Filename", size: 100, type: 'image/jpeg' };

                    // Emit addedfile event
                    this.emit("addedfile", mockFile);

                    // Set thumbnail size and emit thumbnail event
                    this.emit("thumbnail", mockFile, $('#currentImage').attr('src'));

                    // Set the desired thumbnail size
                    let thumbnailWidth = 120;
                    let thumbnailHeight = 120;

                    // Update the width and height attributes of the img element
                    mockFile.previewElement.querySelector('img').width = thumbnailWidth;
                    mockFile.previewElement.querySelector('img').height = thumbnailHeight;

                    // Emit complete event
                    this.emit("complete", mockFile);
                }
            },


            url: "{{ route('temp-images.create') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }, success: function (file, response) {
                $("#image_id").val(response.image_id);
                //console.log(response)
            }
        });

    </script>
@endsection

