@extends('backend.app')

@section('title', 'Footer Manage')

@section('content')
    <!--app-content open-->
    <div class="app-content main-content mt-0">
        <div class="side-app">

            <div class="main-container container-fluid">
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

                <div class="row">
                    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                        <div class="card box-shadow-0">
                            <div class="card-body">
                                <form action="{{ route('cms.footer.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')

                                    <!-- Logo -->
                                    <div class="mb-3">
                                        <label>Logo (Image)</label>
                                        @if ($setting->logo)
                                            <img src="{{ asset('storage/' . $setting->logo) }}" width="100"
                                                alt="Logo">
                                        @endif
                                        <input type="file" name="logo" class="form-control">
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control">{{ old('description', $setting->description) }}</textarea>
                                    </div>

                                    <!-- Social Icons -->
                                    <div class="mb-3">
                                        <label>Social Icons</label>
                                        <div id="social-icons-container">
                                            @foreach ($setting->social_icons ?? [] as $icon)
                                                <div class="row mb-2">
                                                    <div class="col-md-5">
                                                        <input type="text" name="social_icon[{{ $loop->index }}][icon]"
                                                            value="{{ $icon['icon'] }}" class="form-control"
                                                            placeholder="Icon Class (e.g., fa-facebook)">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="url" name="social_icon[{{ $loop->index }}][link]"
                                                            value="{{ $icon['link'] }}" class="form-control"
                                                            placeholder="Social Link">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger remove-icon">X</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-sm btn-secondary add-icon">+ Add Social
                                            Icon</button>
                                    </div>

                                    <!-- Help Center PDF -->
                                    <div class="mb-3">
                                        <label>Help Center PDF</label>
                                        @if ($setting->help_center_pdf)
                                            <a href="{{ asset('storage/' . $setting->help_center_pdf) }}"
                                                target="_blank">View PDF</a>
                                        @endif
                                        <input type="file" name="help_center_pdf" class="form-control">
                                    </div>

                                    <!-- Privacy Policy PDF -->
                                    <div class="mb-3">
                                        <label>Privacy Policy PDF</label>
                                        @if ($setting->privacy_policy_pdf)
                                            <a href="{{ asset('storage/' . $setting->privacy_policy_pdf) }}"
                                                target="_blank">View PDF</a>
                                        @endif
                                        <input type="file" name="privacy_policy_pdf" class="form-control">
                                    </div>

                                    <!-- Email & Phone -->
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" value="{{ old('email', $setting->email) }}"
                                            class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Phone</label>
                                        <input type="text" name="phone" value="{{ old('phone', $setting->phone) }}"
                                            class="form-control">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update Footer</button>
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
            let index = {{ count($setting->social_icons) }};

            addButton.addEventListener('click', function() {
                const row = document.createElement('div');
                row.className = 'row mb-2';
                row.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="social_icon[${index}][icon]" class="form-control" placeholder="Icon Class (e.g., fa-facebook)">
            </div>
            <div class="col-md-5">
                <input type="url" name="social_icon[${index}][link]" class="form-control" placeholder="Social Link">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-sm btn-danger remove-icon">X</button>
            </div>
        `;
                container.appendChild(row);
                index++;

                // Remove button functionality
                row.querySelector('.remove-icon').addEventListener('click', function() {
                    container.removeChild(row);
                });
            });

            // Remove existing icons
            document.querySelectorAll('.remove-icon').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.row').remove();
                });
            });
        });
    </script>
@endpush
