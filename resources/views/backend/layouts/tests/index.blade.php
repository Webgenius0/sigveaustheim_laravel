@extends('backend.app')

@section('title', 'Fitness Tests')

@section('content')
    <!--app-content open-->
    <div class="app-content main-content mt-0">
        <div class="side-app">

            <div class="main-container container-fluid">
                <div class="page-header">
                    <div>
                        <h1 class="page-title">Fitness Tests</h1>
                    </div>
                    <div class="ms-auto pageheader-btn">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Fitness</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tests</li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    {{-- Fitness Tests Table --}}
                    <div class="col-12 col-md-12 col-sm-12">
                        <div class="card box-shadow-0">
                            <div class="card-body">

                                <div class="card-header border-bottom mb-3">
                                    <div class="card-options ms-auto">
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#fitnessTestModal" id="addTestBtn"
                                            @if ($isAddButtonDisabled) disabled @endif>Add Test</button>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table text-nowrap mb-0 table-bordered" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Scoring Type</th>
                                                <th>Image</th>
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

            </div>
        </div>
    </div>

    <!-- CONTAINER CLOSED -->
    <div class="modal fade" id="fitnessTestModal" tabindex="-1" aria-labelledby="fitnessTestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="fitnessTestForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="fitnessTestID">

                    <div class="modal-header">
                        <h5 class="modal-title" id="fitnessTestModalLabel">Create Fitness Test</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            {{-- Name --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Test Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="test_name"
                                    placeholder="Enter Test Name">
                                <span class="text-danger error-text name_error"></span>
                            </div>

                            {{-- Scoring Type --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Scoring Type</label>
                                <select class="form-control" name="scoring_type" id="test_scoring_type">
                                    <option value="">Select Type</option>
                                    <option value="time">Time</option>
                                    <option value="distance">Distance</option>
                                    <option value="count">Count</option>
                                    <option value="reps">Reps</option>
                                    <option value="score">Score</option>
                                    <option value="level">Level</option>
                                </select>
                                <span class="text-danger error-text scoring_type_error"></span>
                            </div>

                            {{-- Description --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control summernote" name="description" id="test_description" rows="4"
                                    placeholder="Enter Description"></textarea>
                                <span class="text-danger error-text description_error"></span>
                            </div>


                            {{-- Image --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" name="image_path" id="test_image" class="form-control dropify"
                                    accept="image">
                                <span class="text-danger error-text image_path_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="fitnessTestSubmitBtn">Save Test</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        //document ready functionq
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            });

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
                    url: "{{ route('fitness.test.index') }}",
                    type: "GET",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'scoring_type'
                    },
                    {
                        data: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],

                drawCallback: function(settings) {
                    let testCount = settings.json.data.length;
                    let addButton = $('#addTestBtn');
                    if (testCount >= 10) {
                        addButton.prop('disabled', true);
                    } else {
                        addButton.prop('disabled', false);
                    }
                }
            });



            // Open modal for new Fitness Test
            $('#addTestBtn').click(function() {
                $('#fitnessTestModalLabel').text('Create Fitness Test');
                $('#fitnessTestForm')[0].reset();
                $('#fitnessTestID').val('');
                $('.error-text').text('');

                // reset summernote
                $('#test_description').summernote('code', '');

                // reset dropify
                let imageInput = $('#test_image').data('dropify');
                if (imageInput) {
                    imageInput.resetPreview();
                    imageInput.clearElement();
                }

                $('#fitnessTestSubmitBtn').prop('disabled', false).html('Save Test');
                $('#fitnessTestModal').modal('show');
            });

            // Handle form submission (Create + Update)
            $('#fitnessTestForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let id = $('#fitnessTestID').val();

                let url = id ?
                    "{{ route('fitness.test.update', ':id') }}".replace(':id', id) :
                    "{{ route('fitness.test.store') }}";

                if (id) {
                    formData.append('_method', 'POST'); // adjust if using PUT/PATCH in backend
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('span.error-text').text('');
                        $('#fitnessTestSubmitBtn').prop('disabled', true).html('Processing...');
                    },
                    success: function(response) {
                        if (response.status == 0) {
                            // Validation errors
                            $.each(response.errors, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            // Success
                            $('#fitnessTestModal').modal('hide');
                            $('#fitnessTestForm')[0].reset();

                            // reset dropify
                            let imageInput = $('#test_image').data('dropify');
                            if (imageInput) {
                                imageInput.resetPreview();
                                imageInput.clearElement();
                            }

                            toastr.success(response.message);
                            $('#datatable').DataTable().ajax.reload();
                        }
                        $('#fitnessTestSubmitBtn').prop('disabled', false).html('Save Test');
                    },
                    error: function(xhr) {
                        $('#fitnessTestSubmitBtn').prop('disabled', false).html('Save Test');
                        if (xhr.status === 422) {
                            $.each(xhr.responseJSON.errors, function(prefix, val) {
                                prefix = prefix.replace(/\./g, '_');
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            toastr.error(xhr.responseJSON.message ||
                                'Something went wrong. Please try again.');
                        }
                    }
                });
            });

            // Edit Test - Load existing data
            $(document).on('click', '.editTest', function() {
                var id = $(this).data('id');
                var url = "{{ route('fitness.test.edit', ':id') }}".replace(':id', id);

                $.get(url, function(response) {
                    if (response.success) {
                        $('#fitnessTestModalLabel').text('Edit Fitness Test');
                        $('#fitnessTestID').val(response.data.id);

                        // Fill form fields
                        $('#test_name').val(response.data.name);
                        $('#test_scoring_type').val(response.data.scoring_type);

                        // Set Summernote content
                        $('#test_description').summernote('reset'); // clear old content
                        $('#test_description').summernote('code', response.data.description || '');

                        // Handle Dropify image
                        let imageInput = $('#test_image').dropify();
                        imageInput = imageInput.data('dropify');
                        imageInput.resetPreview();
                        imageInput.clearElement();

                        if (response.data.image_path) {
                            let baseUrl = "{{ asset('') }}";
                            imageInput.settings.defaultFile = baseUrl + response.data.image_path;
                            imageInput.destroy();
                            imageInput.init();
                        }

                        // Show modal
                        $('#fitnessTestModal').modal('show');
                    } else {
                        toastr.error('Failed to load test data!');
                    }
                }).fail(function() {
                    toastr.error('Something went wrong while loading test data.');
                });
            });

        });


        // delete Confirm
        function showDeleteConfirm(id) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to delete this test?',
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
            let url = "{{ route('fitness.test.delete', ':id') }}";
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
