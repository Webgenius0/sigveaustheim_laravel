@extends('backend.app')

@section('title', 'Fitness Tests Guide')

@section('content')
    <!--app-content open-->
    <div class="app-content main-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="page-header">
                    <div>
                        <h1 class="page-title">Fitness Test Guide</h1>
                    </div>
                    <div class="ms-auto pageheader-btn">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Guide</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tests</li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    {{-- Fitness Tests Table --}}
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div class="col-12 col-md-8 offset-md-2">


                                    {{-- error handling --}}
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                                            <strong><i class="fas fa-check-circle me-1"></i></strong>
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    @if (session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                            <strong><i class="fas fa-exclamation-triangle me-1"></i></strong>
                                            {{ session('error') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif


                                    <div class="card shadow-sm border-0">
                                        <div
                                            class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Add Test Guide</h5>

                                            <!-- View Guide Button -->
                                            <a href="{{ isset($testGuide) && $testGuide->guide_file_path ? asset($testGuide->guide_file_path) : '#' }}"
                                                target="_blank"
                                                class="btn btn-light btn-sm {{ isset($testGuide) && $testGuide->guide_file_path ? '' : 'disabled' }}">
                                                <i class="fas fa-eye me-1"></i> View Guide
                                            </a>
                                        </div>

                                        <div class="card-body">
                                            <form action="{{ route('test-guides.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf

                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <label for="name" class="form-label">Guide Name</label>
                                                        <input type="text" name="name" id="name"
                                                            class="form-control form-control-sm"
                                                            placeholder="Enter guide name"
                                                            value="{{ old('name', $testGuide->name ?? '') }}" required>

                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-md-12">
                                                        <label for="guide_file_path" class="form-label">Upload Guide
                                                            (PDF)</label>
                                                        <input type="file" name="guide_file_path" id="guide_file_path"
                                                            accept="application/pdf" class="form-control form-control-sm">

                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-save me-1"></i> Save Guide
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

            </div>
        </div>
    </div>
@endsection
