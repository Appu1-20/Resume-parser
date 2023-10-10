<?php

namespace App\Http\Controllers;

use App\Models\Consignee;
use Illuminate\Validation\Rule;

class ConsigneeController extends Controller
{
    public function index( ) {
        return view( 'consignee.create');
    }

    public function create()
    {
        $validatedData = $this->validateConsignee();

        Consignee::create($validatedData);

        return redirect('consignee/view')->with('success', 'Consignee created successfully.');
    }
    public function view( ) {
        $consignees = Consignee::paginate(5);

        if ($consignees->isEmpty()) {
            return redirect('consignee/create')->with('success', 'No consignees found. Please create a consignee.');
        }

        return view('consignee.index', compact('consignees'));
    }

    public function edit(Consignee $consignee) {
        return view('consignee.edit', [
            'consignee' => $consignee
        ]);
    }

    public function delete(Consignee $consignee) {
        $consignee->delete();

        return back()->with('success', 'Consignee Deleted!');
    }

    public function update(Consignee $consignee) {
        $attributes = $this->validateConsignee($consignee);

        $consignee->update($attributes);

        return redirect('consignee/view')->with('success', 'Consignee has been updated' );
    }

    protected function validateConsignee(?Consignee $consignee = null): array {
        $consignee ??= new Consignee();

        return request()->validate([
            'name'                  => 'required|min:3|max:255',
            'email'                 => ['required', Rule::unique('consignees', 'email')->ignore($consignee)],
            'phone'                 => 'required|min:10',
            'consignee_address_1'   => 'required',
            'consignee_address_2'   => 'required',
            'consignee_longitude'   => 'required',
            'consignee_latitude'    => 'required',
        ]);
    }
}
