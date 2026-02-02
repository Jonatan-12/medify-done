@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="mb-4">Kategori Items</h4>

    <!-- FILTER -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">

                <div class="col-md-4">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text"
                           name="nama"
                           class="form-control"
                           placeholder="Nama kategori"
                           value="{{ request('nama') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Kode Kategori</label>
                    <input type="text"
                           name="kode"
                           class="form-control"
                           placeholder="Kode"
                           value="{{ request('kode') }}">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        Filter
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- TAMBAH -->
    <div class="mb-3">
        <a href="{{ route('categories.create') }}"
           class="btn btn-success">
            + Tambah Kategori
        </a>
    </div>

    <!-- TABLE -->
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Kode</th>
                        <th width="220">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                        <tr>
                            <td>{{ $cat->nama }}</td>
                            <td>{{ $cat->kode }}</td>
                            <td>
                                <a href="{{ route('categories.show',$cat->id) }}"
                                   class="btn btn-sm btn-primary">
                                    View
                                </a>

                                <a href="{{ route('categories.edit',$cat->id) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('categories.destroy',$cat->id) }}"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus kategori?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-3">
                                Data kategori belum ada
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
