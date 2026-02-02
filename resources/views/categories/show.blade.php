@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Detail Kategori</h4>

        <a href="{{ route('categories.pdf', $category->id) }}"
           class="btn btn-danger">
            Download PDF
        </a>
    </div>

    <!-- INFO KATEGORI -->
    <div class="card mb-4">
        <div class="card-body">
            <p class="mb-2">
                <strong>Nama:</strong> {{ $category->nama }}
            </p>
            <p class="mb-0">
                <strong>Kode:</strong> {{ $category->kode }}
            </p>
        </div>
    </div>

    <!-- ITEMS -->
    <h5 class="mb-3">Items dalam kategori ini</h5>

    <div class="card mb-4">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Item</th>
                        <th>Kode Item</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($category->items as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kode }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-3 text-muted">
                                Belum ada item pada kategori ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- BACK -->
    <a href="{{ route('categories.index') }}"
       class="btn btn-link">
        ← Kembali ke daftar kategori
    </a>

</div>
@endsection
