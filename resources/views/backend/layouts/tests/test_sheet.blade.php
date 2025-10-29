@extends('backend.app')

@section('title', 'Fitness Tests Sheet')

@section('content')
    <!--app-content open-->
    <div class="app-content main-content mt-0">
        <div class="side-app">

            <div class="main-container container-fluid">
                <div class="page-header">
                    <div>
                        <h1 class="page-title">Fitness Tests Sheet</h1>
                    </div>
                    <div class="ms-auto pageheader-btn">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Tests</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sheet</li>
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
                                            data-bs-target="#recordSheetModal" id="addTestBtn">Add Sheet</button>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table text-nowrap mb-0 table-bordered" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fitness Test</th>
                                                <th>Sheet Name</th>
                                                <th>Sheet URL</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Test Record Sheet Modal -->
    <div class="modal fade" id="recordSheetModal" tabindex="-1" aria-labelledby="recordSheetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="recordSheetForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="recordSheetID">

                    <div class="modal-header">
                        <h5 class="modal-title" id="recordSheetModalLabel">Upload Test Record Sheet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            {{-- Fitness Test Dropdown --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Select Fitness Test <span class="text-danger">*</span></label>
                                <select class="form-control" name="fitness_test_id" id="fitness_test_id">
                                    <option value="">Select Fitness Test</option>
                                    @foreach ($fitnessTests as $test)
                                        <option value="{{ $test->id }}">{{ $test->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text fitness_test_id_error"></span>
                            </div>

                            {{-- Sheet Name --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Sheet Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="sheet_name"
                                    placeholder="Enter Sheet Name">
                                <span class="text-danger error-text name_error"></span>
                            </div>

                            {{-- File Upload --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Upload Sheet (PDF/Excel/Image) <span
                                        class="text-danger">*</span></label>
                                <input type="file" name="sheet_url" id="sheet_file" class="form-control dropify"
                                    accept=".pdf,.xlsx,.xls,image/*">
                                <span class="text-danger error-text sheet_url_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="recordSheetSubmitBtn">Save Sheet</button>
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
                    url: "{{ route('test.record.sheet') }}",
                    type: "GET",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'fitness_test',
                        name: 'fitness_test'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'sheet_url',
                        name: 'sheet_url',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });


            // Open modal for new sheet
            $('#addTestBtn').click(function() {
                $('#recordSheetModalLabel').text('Upload Test Record Sheet');
                $('#recordSheetForm')[0].reset();
                $('#recordSheetID').val('');
                $('.error-text').text('');

                let fileInput = $('#sheet_file').data('dropify');
                if (fileInput) {
                    fileInput.resetPreview();
                    fileInput.clearElement();
                }

                $('#recordSheetSubmitBtn').prop('disabled', false).html('Save Sheet');
                $('#recordSheetModal').modal('show');
            });

            // Submit form (Create or Update)
            $('#recordSheetForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let id = $('#recordSheetID').val();

                let url = id ?
                    "{{ route('test.record.sheet.update', ':id') }}".replace(':id', id) :
                    "{{ route('test.record.sheet.store') }}";

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
                        $('#recordSheetSubmitBtn').prop('disabled', true).html('Processing...');
                    },
                    success: function(response) {
                        if (response.status == 0) {
                            $.each(response.errors, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            $('#recordSheetModal').modal('hide');
                            $('#recordSheetForm')[0].reset();
                            let fileInput = $('#sheet_file').data('dropify');
                            if (fileInput) {
                                fileInput.resetPreview();
                                fileInput.clearElement();
                            }
                            toastr.success(response.message);
                            $('#datatable').DataTable().ajax.reload();
                        }
                        $('#recordSheetSubmitBtn').prop('disabled', false).html('Save Sheet');
                    },
                    error: function(xhr) {
                        $('#recordSheetSubmitBtn').prop('disabled', false).html('Save Sheet');
                        toastr.error(xhr.responseJSON.message || 'Something went wrong.');
                    }
                });
            });

            // Edit Sheet
            $(document).on('click', '.editSheet', function() {
                var id = $(this).data('id');
                var url = "{{ route('test.record.sheet.edit', ':id') }}".replace(':id', id);

                $.get(url, function(response) {
                    if (response.success) {
                        $('#recordSheetModalLabel').text('Edit Record Sheet');
                        $('#recordSheetID').val(response.data.id);
                        $('#fitness_test_id').val(response.data.fitness_test_id);
                        $('#sheet_name').val(response.data.name);

                        let fileInput = $('#sheet_file').dropify();
                        fileInput = fileInput.data('dropify');
                        fileInput.resetPreview();
                        fileInput.clearElement();

                        if (response.data.sheet_url) {
                            let baseUrl = "{{ asset('') }}";
                            fileInput.settings.defaultFile = baseUrl + response.data.sheet_url;
                            fileInput.destroy();
                            fileInput.init();
                        }

                        $('#recordSheetModal').modal('show');
                    } else {
                        toastr.error('Failed to load sheet data!');
                    }
                }).fail(function() {
                    toastr.error('Something went wrong while loading data.');
                });
            });
        });


        // delete funcitonality
        // delete Confirm
        function showDeleteConfirm(id) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to delete this record sheet?',
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
            let url = "{{ route('test.record.sheet.delete', ':id') }}";
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
