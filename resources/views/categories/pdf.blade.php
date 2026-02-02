<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Kategori</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin-bottom: 80px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 6px;
            text-align: left;
        }

        #footer {
            position: fixed;
            bottom: -40px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>
<body>

<h3>Data Kategori</h3>

<p>
    <strong>Nama Kategori:</strong> {{ $category->nama }} <br>
    <strong>Kode Kategori:</strong> {{ $category->kode }}
</p>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="30%">Nama Item</th>
            <th width="20%">Kode Item</th>
            <th width="25%">Supplier</th>
            <th width="20%">Harga Beli</th>
        </tr>
    </thead>
    <tbody>
        @forelse($category->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->supplier }}</td>
                <td>{{ number_format($item->harga_beli) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align:center;">
                    Tidak ada item pada kategori ini
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div id="footer">
    Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}
</div>

</body>
</html>
