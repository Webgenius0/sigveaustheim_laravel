@extends('backend.app')

@section('title', 'Fitness Test Levels')

@section('content')
    <!--app-content open-->
    <div class="app-content main-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="page-header">
                    <div>
                        <h1 class="page-title">Fitness Test Levels</h1>
                    </div>
                    <div class="ms-auto pageheader-btn">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Fitness</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Test Levels</li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    {{-- Fitness Test Levels Table --}}
                    <div class="col-12 col-md-12 col-sm-12">
                        <div class="card box-shadow-0">
                            <div class="card-body">
                                <div class="card-header border-bottom mb-3">
                                    <div class="card-options ms-auto">
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#fitnessTestLevelModal" id="addLevelBtn">Add Level</button>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table text-nowrap mb-0 table-bordered" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Test Name</th>
                                                <th>Level</th>
                                                <th>Level Name</th>
                                                <th>Percentage Range</th>
                                                <th>Comment</th>
                                                <th>Star Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fitness Test Level Modal -->
                <div class="modal fade" id="fitnessTestLevelModal" tabindex="-1"
                    aria-labelledby="fitnessTestLevelModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <form id="fitnessTestLevelForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="fitnessTestLevelID">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="fitnessTestLevelModalLabel">Create Fitness Test Level</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">×</button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        {{-- Test Name --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Fitness Test <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="test_id" id="test_id">
                                                <option value="">Select Test</option>
                                                @foreach (\App\Models\FitnessTests::all() as $test)
                                                    <option value="{{ $test->id }}">{{ $test->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text test_id_error"></span>
                                        </div>

                                        {{-- Level --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Level <span class="text-danger">*</span></label>
                                            <select class="form-control" name="level" id="level">
                                                <option value="">Select Level</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                            <span class="text-danger error-text level_error"></span>
                                        </div>

                                        {{-- Level Name --}}
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Level Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="level_name" id="level_name"
                                                placeholder="Enter Level Name (e.g., Foundation)">
                                            <span class="text-danger error-text level_name_error"></span>
                                        </div>

                                        {{-- Percentage Range --}}
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Min Percentage <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="min_percentage"
                                                id="min_percentage" placeholder="Enter Min Percentage (e.g., 1)"
                                                min="0" max="100">
                                            <span class="text-danger error-text min_percentage_error"></span>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Max Percentage <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="max_percentage"
                                                id="max_percentage" placeholder="Enter Max Percentage (e.g., 20)"
                                                min="0" max="100">
                                            <span class="text-danger error-text max_percentage_error"></span>
                                        </div>

                                        {{-- Comment --}}
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Comment</label>
                                            <textarea class="form-control summernote" name="comment" id="comment" rows="4"
                                                placeholder="Enter Comment (e.g., Needs improvement in agility)"></textarea>
                                            <span class="text-danger error-text comment_error"></span>
                                        </div>

                                        {{-- Star Image --}}
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Star Image</label>
                                            <input type="file" name="star_image" id="star_image"
                                                class="form-control dropify" accept="image/*">
                                            <span class="text-danger error-text star_image_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="fitnessTestLevelSubmitBtn">Save
                                        Level</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            });

            // Initialize Summernote
            $('.summernote').summernote({
                height: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]
            });

            // Initialize Dropify for image inputs
            $('.dropify').dropify({
                messages: {
                    default: 'Drag and drop or click to upload an image',
                    replace: 'Drag and drop or click to replace',
                    remove: 'Remove',
                    error: 'Error: Something went wrong'
                },
                error: {
                    'fileSize': 'The file size is too large).',
                    'fileExtension': 'Only image files are allowed).'
                }
            });

            // DataTable
            let dTable = $('#datatable').DataTable({
                order: [],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                processing: true,
                responsive: true,
                serverSide: true,
                language: {
                    processing: `<div class="text-center">
                                    <img src="{{ asset('default/loader.gif') }}" alt="Loader" style="width: 50px;">
                                </div>`
                },
                ajax: {
                    url: "{{ route('fitness.test.level.index') }}",
                    type: "GET",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'test_name'
                    },
                    {
                        data: 'level'
                    },
                    {
                        data: 'level_name'
                    },
                    {
                        data: 'percentage_range'
                    },
                    {
                        data: 'comment'
                    },
                    {
                        data: 'star_image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],

            });


            // Open modal for new Fitness Test Level
            $('#addLevelBtn').click(function() {
                $('#fitnessTestLevelModalLabel').text('Create Fitness Test Level');
                $('#fitnessTestLevelForm')[0].reset();
                $('#fitnessTestLevelID').val('');
                $('.error-text').text('');

                // Reset Summernote
                $('#comment').summernote('code', '');

                // Reset Dropify for star_image
                let starImageInput = $('#star_image').data('dropify');
                if (starImageInput) {
                    starImageInput.resetPreview();
                    starImageInput.clearElement();
                }

                $('#fitnessTestLevelSubmitBtn').prop('disabled', false).html('Save Level');
                $('#fitnessTestLevelModal').modal('show');
            });

            // Handle form submission (Create + Update)
            $('#fitnessTestLevelForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let id = $('#fitnessTestLevelID').val();

                let url = id ?
                    "{{ route('fitness.test.level.update', ':id') }}".replace(':id', id) :
                    "{{ route('fitness.test.level.store') }}";

                if (id) {
                    formData.append('_method', 'POST');
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('span.error-text').text('');
                        $('#fitnessTestLevelSubmitBtn').prop('disabled', true).html(
                            'Processing...');
                    },
                    success: function(response) {
                        if (response.success === false) {
                            // Validation errors
                            $.each(response.errors, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                            // Show general message as toast if no field-specific errors
                            if (!response.errors) {
                                toastr.error(response.message);
                            }
                        } else {
                            // Success
                            $('#fitnessTestLevelModal').modal('hide');
                            $('#fitnessTestLevelForm')[0].reset();

                            // Reset Dropify for star_image
                            let starImageInput = $('#star_image').data('dropify');
                            if (starImageInput) {
                                starImageInput.resetPreview();
                                starImageInput.clearElement();
                            }

                            // Reset Summernote
                            $('#comment').summernote('code', '');

                            toastr.success(response.message);
                            $('#datatable').DataTable().ajax.reload();
                        }
                        $('#fitnessTestLevelSubmitBtn').prop('disabled', false).html(
                            'Save Level');
                    },
                    error: function(xhr) {
                        $('#fitnessTestLevelSubmitBtn').prop('disabled', false).html(
                            'Save Level');

                        if (xhr.status === 422) {
                            let response = xhr.responseJSON;

                            // Handle field-specific validation errors
                            if (response.errors) {
                                $.each(response.errors, function(prefix, val) {
                                    prefix = prefix.replace(/\./g, '_');
                                    $('span.' + prefix + '_error').text(val[0]);
                                });
                            }

                            // Handle custom validation messages (like "Cannot add more than 5 levels")
                            if (response.message && !response.errors) {
                                toastr.error(response.message);
                            }
                        } else {
                            toastr.error(xhr.responseJSON?.message ||
                                'Something went wrong. Please try again.');
                        }
                    }
                });
            });


            // Edit Level - Load existing data
            $(document).on('click', '.editLevel', function() {
                var id = $(this).data('id');
                var url = "{{ route('fitness.test.level.edit', ':id') }}".replace(':id', id);

                $.get(url, function(response) {
                    if (response.id) { // Controller returns level data directly
                        $('#fitnessTestLevelModalLabel').text('Edit Fitness Test Level');
                        $('#fitnessTestLevelID').val(response.id);

                        // Fill form fields
                        $('#test_id').val(response.test_id);
                        $('#level').val(response.level);
                        $('#level_name').val(response.level_name);
                        $('#min_percentage').val(response.min_percentage);
                        $('#max_percentage').val(response.max_percentage);

                        // Set Summernote content
                        $('#comment').summernote('reset');
                        $('#comment').summernote('code', response.comment || '');

                        // Handle Dropify for star_image
                        let starImageInput = $('#star_image').dropify();
                        starImageInput = starImageInput.data('dropify');
                        starImageInput.resetPreview();
                        starImageInput.clearElement();
                        if (response.star_image) {
                            let baseUrl = "{{ asset('') }}";
                            starImageInput.settings.defaultFile = baseUrl + '/' + response
                                .star_image;
                            starImageInput.destroy();
                            starImageInput.init();
                        }

                        // Show modal
                        $('#fitnessTestLevelModal').modal('show');
                    } else {
                        toastr.error('Failed to load level data!');
                    }
                }).fail(function() {
                    toastr.error('Something went wrong while loading level data.');
                });
            });
        });
    </script>


    {{-- delete system --}}
    <script>
        // delete Confirm
        function showDeleteConfirm(id) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to delete this level?',
                text: 'If you delete this, it will be gone forever.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteItem(id);
                }
            });
        }

        // Delete Button
        function deleteItem(id) {
            NProgress.start();
            let url = "{{ route('fitness.test.level.delete', ':id') }}";
            let csrfToken = '{{ csrf_token() }}';
            $.ajax({
                type: "DELETE",
                url: url.replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(resp) {
                    NProgress.done();
                    toastr.success(resp.message);
                    $('#datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    NProgress.done();
                    toastr.error(error.message);
                }
            });
        }
    </script>
@endpush
