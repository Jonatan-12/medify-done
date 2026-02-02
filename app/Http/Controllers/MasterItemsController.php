<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\MasterItemsExport;
use Maatwebsite\Excel\Facades\Excel;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $query = MasterItem::query();

        if ($request->kode) {
            $query->where('kode', $request->kode);
        }

        if ($request->nama) {
            $query->where('nama', 'LIKE', '%' . $request->nama . '%');
        }

        if ($request->hargamin) {
            $query->where('harga_beli', '>=', $request->hargamin);
        }

        if ($request->hargamax) {
            $query->where('harga_beli', '<=', $request->hargamax);
        }

        $data = $query
            ->select(
                'id',
                'kode',
                'nama',
                'jenis',
                'harga_beli',
                'laba',
                'supplier',
                'foto' 
            )
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method === 'new') {
            $item = null;
        } else {
            $item = MasterItem::with('categories')->findOrFail($id);
        }

        return view('master_items.form.index', [
            'item' => $item,
            'method' => $method,
            'categories' => Category::orderBy('nama')->get()
        ]);
    }

    public function singleView($kode)
    {
        $data = MasterItem::with('categories')
            ->where('kode', $kode)
            ->firstOrFail();

        return view('master_items.single.index', compact('data'));
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method === 'new') {
            $item = new MasterItem;
            $kode = str_pad(MasterItem::count() + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $item = MasterItem::findOrFail($id);
            $kode = $item->kode;
        }

        $item->nama = $request->nama;
        $item->harga_beli = $request->harga_beli;
        $item->laba = $request->laba;
        $item->kode = $kode;
        $item->supplier = $request->supplier;
        $item->jenis = $request->jenis;

        // UPLOAD FOTO
        if ($request->hasFile('foto')) {
            if ($method !== 'new' && $item->foto) {
                Storage::disk('public')->delete($item->foto);
            }

            $item->foto = $request->file('foto')->store('master-items', 'public');
        }

        $item->save();

        // SIMPAN KATEGORI (MANY TO MANY)
        if ($request->category_ids) {
            $item->categories()->sync($request->category_ids);
        }

        return redirect('master-items');
    }

    public function delete($id)
    {
        $item = MasterItem::findOrFail($id);

        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }

        $item->categories()->detach();
        $item->delete();

        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();

        foreach ($data as $item) {
            $item->kode = str_pad($item->id, 5, '0', STR_PAD_LEFT);
            $item->harga_beli = rand(100, 1000000);
            $item->laba = rand(10, 99);
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        return ['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'][rand(0,4)];
    }

    private function getRandomJenis()
    {
        return ['Obat','Alkes','Matkes','Umum','ATK'][rand(0,4)];
    }
    public function exportExcel()
{
    return Excel::download(
        new MasterItemsExport,
        'master-items.xlsx'
    );
}
}
