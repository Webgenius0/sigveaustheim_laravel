@extends('backend.app')

@section('title', 'Footer Manage')

@section('content')
    <!--app-content open-->
    <div class="app-content main-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h1 class="page-title">Footer Manage</h1>
                    </div>
                    <div class="ms-auto pageheader-btn">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Footer</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Index</li>
                        </ol>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="row">
                    <div class="col-12">
                        <div class="card box-shadow-0">
                            <div class="card-body">
                                <form action="{{ route('cms.footer.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <!-- Logo Section -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Logo</label>
                                        @if ($setting->logo)
                                            <div class="mb-2">
                                                <img src="{{ asset('/' . $setting->logo) }}" width="100" alt="Logo"
                                                    class="img-thumbnail">
                                            </div>
                                        @endif
                                        <input type="file" name="logo" class="form-control" accept="image/*">
                                        <small class="text-muted">Supported formats: PNG, JPG, JPEG, SVG, ICO (Max:
                                            2MB)</small>
                                    </div>

                                    <!-- Description Section -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Description</label>
                                        <textarea name="description" class="form-control" rows="4" placeholder="Enter footer description">{{ old('description', $setting->description) }}</textarea>
                                    </div>

                                    <!-- Social Icons Section -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Social Icons</label>
                                        <div id="social-icons-container">
                                            @if ($setting->social_icons && count($setting->social_icons) > 0)
                                                @foreach ($setting->social_icons as $index => $icon)
                                                    <div class="card mb-3 social-item">
                                                        <div class="card-body">
                                                            <div class="row align-items-end">
                                                                <div class="col-lg-5 col-md-12 mb-3">
                                                                    <label class="form-label small text-muted">Icon
                                                                        Image</label>
                                                                    @if (!empty($icon['icon_image']))
                                                                        <div class="mb-2">
                                                                            <img src="{{ asset('/' . $icon['icon_image']) }}"
                                                                                width="40" alt="Social Icon"
                                                                                class="img-thumbnail">
                                                                        </div>
                                                                    @endif
                                                                    <input type="file"
                                                                        name="social_icons[{{ $index }}][icon_image]"
                                                                        class="form-control form-control-sm"
                                                                        accept="image/*">
                                                                    <small class="text-muted">PNG, JPG, SVG (Max:
                                                                        1MB)</small>
                                                                </div>
                                                                <div class="col-lg-5 col-md-12 mb-3">
                                                                    <label class="form-label small text-muted">Social
                                                                        Link</label>
                                                                    <input type="url"
                                                                        name="social_icons[{{ $index }}][link]"
                                                                        value="{{ $icon['link'] ?? '' }}"
                                                                        class="form-control"
                                                                        placeholder="https://facebook.com/yourpage">
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 mb-3 text-end">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-danger remove-icon">
                                                                        <i class="fa fa-times"></i> Remove
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-secondary add-icon">
                                            <i class="fa fa-plus"></i> Add Social Icon
                                        </button>
                                    </div>

                                    <!-- PDF Files Section -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Help Center PDF</label>
                                            @if ($setting->help_center_pdf)
                                                <div class="mb-2">
                                                    <a href="{{ asset('/' . $setting->help_center_pdf) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="fa fa-file-pdf"></i> View Current PDF
                                                    </a>
                                                </div>
                                            @endif
                                            <input type="file" name="help_center_pdf" class="form-control"
                                                accept=".pdf">
                                            <small class="text-muted">Max file size: 10MB</small>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Privacy Policy PDF</label>
                                            @if ($setting->privacy_policy_pdf)
                                                <div class="mb-2">
                                                    <a href="{{ asset('/' . $setting->privacy_policy_pdf) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-info">
                                                        <i class="fa fa-file-pdf"></i> View Current PDF
                                                    </a>
                                                </div>
                                            @endif
                                            <input type="file" name="privacy_policy_pdf" class="form-control"
                                                accept=".pdf">
                                            <small class="text-muted">Max file size: 10MB</small>
                                        </div>
                                    </div>

                                    <!-- Contact Information Section -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Email</label>
                                            <input type="email" name="email" value="{{ old('email', $setting->email) }}"
                                                class="form-control" placeholder="contact@example.com">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Phone</label>
                                            <input type="text" name="phone"
                                                value="{{ old('phone', $setting->phone) }}" class="form-control"
                                                placeholder="+1 234 567 8900">
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="fa fa-save"></i> Update Footer Settings
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('social-icons-container');
            const addButton = document.querySelector('.add-icon');
            let index = {{ count($setting->social_icons ?? []) }};

            // Function to create new social icon row
            function createSocialIconRow(currentIndex) {
                const row = document.createElement('div');
                row.className = 'row mb-3 social-item border p-3';
                row.innerHTML = `
                    <div class="col-md-5">
                        <label class="form-label small">Icon Image</label>
                        <input type="file" name="social_icons[${currentIndex}][icon_image]" class="form-control form-control-sm" accept="image/*">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small">Social Link</label>
                        <input type="url" name="social_icons[${currentIndex}][link]" class="form-control" placeholder="https://facebook.com/yourpage">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger remove-icon w-100">
                            <i class="fa fa-trash"></i> Remove
                        </button>
                    </div>
                `;
                return row;
            }

            // Add new social icon
            addButton.addEventListener('click', function() {
                const row = createSocialIconRow(index);
                container.appendChild(row);
                index++;

                // Add remove functionality to the new row
                row.querySelector('.remove-icon').addEventListener('click', function() {
                    if (confirm('Are you sure you want to remove this social icon?')) {
                        container.removeChild(row);
                    }
                });
            });

            // Add remove functionality to existing rows
            document.querySelectorAll('.remove-icon').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (confirm('Are you sure you want to remove this social icon?')) {
                        this.closest('.social-item').remove();
                    }
                });
            });
        });
    </script>
@endpush
