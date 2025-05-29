<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Menampilkan daftar semua modul.
     */
    public function index()
    {
        $modules = Module::paginate(10);
        return view('admin.modules.index', compact('modules'));
    }

    /**
     * Menampilkan form untuk membuat modul baru.
     */
    public function create()
    {
        return view('admin.modules.create');
    }

    /**
     * Menyimpan modul baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:modules,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048'
        ]);
    
        $imagePath = null;
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/modules', 'public');
        }
    
        Module::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath
        ]);

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit untuk modul tertentu.
     */
    public function edit(Module $module)
    {
        return view('admin.modules.edit', compact('module'));
    }

    /**
     * Memperbarui modul di database.
     */
    public function update(Request $request, Module $module)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:modules,name,' . $module->id,
            'description' => 'nullable|string',
        ]);

        $module->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil diperbarui!');
    }

    /**
     * Menghapus modul dari database.
     */
    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil dihapus!');
    }
}
