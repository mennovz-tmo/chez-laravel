<?php

namespace App\Http\Controllers;

use App\Http\Requests\OpeningDatetimeCreateRequest;
use App\Http\Requests\OpeningDatetimeEditRequest;
use App\Models\OpeningDatetime;

class OpeningDatetimeController extends Controller
{
    public function index()
    {
        return view('opening_datetime.index')->with(['items' => OpeningDatetime::all()->sortByDesc('date')]);
    }

    public function create(OpeningDatetimeCreateRequest $request)
    {
        OpeningDatetime::create($request->validated());

        return redirect()
            ->route('opening-datetime.view')
            ->with('success', 'Toegevoegd.');
    }

    public function edit(OpeningDatetimeEditRequest $request, OpeningDatetime $openingDatetime)
    {
        if ($request->isMethod('GET')) {
            return view('opening_datetime.edit')->with(['item' => $openingDatetime]);
        }

        $openingDatetime->update($request->validated());

        return redirect()
            ->route('opening-datetime.view')
            ->with('success', 'Aangepast.');
    }

    public function delete(OpeningDatetime $openingDatetime)
    {
        $openingDatetime->delete();

        return redirect()
            ->route('opening-datetime.view')
            ->with('success', 'Verwijderd.');
    }
}
