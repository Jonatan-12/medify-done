<form method="POST" enctype="multipart/form-data">
    @csrf

    @if($method == 'edit')
        @method('PUT')
        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" class="form-control" name="kode_barang"
                   readonly
                   value="{{ $item->kode ?? '' }}">
        </div>
    @endif

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required
               value="{{ old('nama', $item->nama ?? '') }}">
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required
               value="{{ old('harga_beli', $item->harga_beli ?? '') }}">
    </div>

    <div class="form-group">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required
               value="{{ old('laba', $item->laba ?? '') }}">
    </div>

    @php $selectedSupplier = old('supplier', $item->supplier ?? ''); @endphp
    <div class="form-group">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option value="">--Pilih--</option>
            <option value="Tokopaedi" {{ $selectedSupplier == 'Tokopaedi' ? 'selected' : '' }}>Tokopaedi</option>
            <option value="Bukulapuk" {{ $selectedSupplier == 'Bukulapuk' ? 'selected' : '' }}>Bukulapuk</option>
            <option value="TokoBagas" {{ $selectedSupplier == 'TokoBagas' ? 'selected' : '' }}>TokoBagas</option>
            <option value="E Commurz" {{ $selectedSupplier == 'E Commurz' ? 'selected' : '' }}>E Commurz</option>
            <option value="Blublu" {{ $selectedSupplier == 'Blublu' ? 'selected' : '' }}>Blublu</option>
        </select>
    </div>

    @php $selectedJenis = old('jenis', $item->jenis ?? ''); @endphp
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option value="">--Pilih--</option>
            <option value="Obat" {{ $selectedJenis == 'Obat' ? 'selected' : '' }}>Obat</option>
            <option value="Alkes" {{ $selectedJenis == 'Alkes' ? 'selected' : '' }}>Alkes</option>
            <option value="Matkes" {{ $selectedJenis == 'Matkes' ? 'selected' : '' }}>Matkes</option>
            <option value="Umum" {{ $selectedJenis == 'Umum' ? 'selected' : '' }}>Umum</option>
            <option value="ATK" {{ $selectedJenis == 'ATK' ? 'selected' : '' }}>ATK</option>
        </select>
    </div>

    {{-- FOTO --}}
    <div class="form-group">
        <label>Foto Item</label>
        <input type="file" class="form-control" name="foto" accept="image/*">
    </div>

    @if(isset($item) && $item->foto)
        <div class="mb-3">
            <img src="{{ asset('storage/'.$item->foto) }}" width="120" class="img-thumbnail">
        </div>
    @endif

    {{-- Kategori --}}
    <div class="form-group">
        <label>Kategori</label>
        <select name="category_ids[]" class="form-control" multiple>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    @if(isset($item) && $item->categories->pluck('id')->contains($category->id))
                        selected
                    @endif
                >
                    {{ $category->kode }} - {{ $category->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-primary mt-3">
        {{ $method == 'edit' ? 'Update' : 'Submit' }}
    </button>
</form>
