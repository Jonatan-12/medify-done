@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        {{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori' }}
                    </h5>
                </div>

                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($category) 
                                    ? route('categories.update',$category->id) 
                                    : route('categories.store') }}">
                        @csrf
                        @if(isset($category)) 
                            @method('PUT') 
                        @endif

                        <!-- NAMA -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nama Kategori
                            </label>
                            <input type="text"
                                   name="nama"
                                   class="form-control"
                                   value="{{ old('nama', $category->nama ?? '') }}"
                                   placeholder="Contoh: Obat"
                                   required>
                        </div>

                        <!-- KODE -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Kode Kategori
                            </label>
                            <input type="text"
                                   name="kode"
                                   class="form-control"
                                   value="{{ old('kode', $category->kode ?? '') }}"
                                   placeholder="Contoh: OBT"
                                   required>
                        </div>

                        <!-- BUTTON -->
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('categories.index') }}"
                               class="btn btn-secondary me-2">
                                Batal
                            </a>

                            <button type="submit"
                                    class="btn btn-primary">
                                Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
