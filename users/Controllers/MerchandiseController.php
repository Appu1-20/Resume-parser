<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MerchandiseController extends Controller
{
    public function index( ) {
        return view( 'merchandise.create');
    }

     public function create()
    {
        $validatedData = $this->validateMerchandise();

        Merchandise::create($validatedData);

        return redirect('merchandise/view')->with('success', 'Merchandise created successfully.');
    }
    public function view( ) {
        $merchandises = Merchandise::paginate(5);

        if ($merchandises->isEmpty()) {
            return redirect('merchandise/create')->with('success', 'No merchandise found. Please create a merchandise.');
        }

        return view('merchandise.index', compact('merchandises'));
    }

    public function edit(Merchandise $merchandise) {
        return view('merchandise.edit', [
            'merchandise' => $merchandise
        ]);
    }

    public function delete(Merchandise $merchandise) {
        
        $merchandise->delete();

        return back()->with('success', 'Merchandise Deleted!');
    }

    public function update(Merchandise $merchandise) {
        $attributes = $this->validateMerchandise($merchandise);

        $merchandise->update($attributes);

        return redirect('merchandise/view')->with('success', 'Merchandise has been updated' );
    }

    protected function validateMerchandise(?Merchandise $merchandise = null): array {
        $merchandise ??= new Merchandise();

        return request()->validate([
            'name'              => 'required|min:3|max:255|',
            'merchandise_code'  => ['required', Rule::unique('merchandises', 'merchandise_code')->ignore($merchandise)],
        ]);
    }
}
