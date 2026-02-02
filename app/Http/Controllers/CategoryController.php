<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        // FILTER NAMA & KODE
        if ($request->nama) {
            $query->where('nama', 'LIKE', '%' . $request->nama . '%');
        }

        if ($request->kode) {
            $query->where('kode', 'LIKE', '%' . $request->kode . '%');
        }

        $categories = $query->orderBy('id')->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kode' => 'required|unique:categories,kode',
        ]);

        Category::create($request->only('nama', 'kode'));

        return redirect('/categories');
    }

    public function show($id)
    {
        $category = Category::with('items')->findOrFail($id);

        return view('categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.form', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'kode' => 'required|unique:categories,kode,' . $id,
        ]);

        $category->update($request->only('nama', 'kode'));

        return redirect('/categories');
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return redirect('/categories');
    }
    public function printPdf($id)
{
    $category = Category::with('items')->findOrFail($id);

    $pdf = Pdf::loadView('categories.pdf', [
        'category' => $category
    ]);

    return $pdf->download(
        'kategori_' . $category->kode . '.pdf'
    );
}
}
