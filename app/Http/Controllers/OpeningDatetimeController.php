<?php

namespace App\Http\Controllers;

use App\Models\OpeningDatetime;
use DateTime;
use Illuminate\Http\Request;

class OpeningDatetimeController extends Controller
{
    public function index()
    {
        return view('opening_datetime.index', ['items' => OpeningDatetime::all()->sortBy('date')]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'open' => 'required|boolean',
            'opening' => 'nullable|date_format:H:i',
            'closing' => 'nullable|date_format:H:i',
        ]);

        $opening = DateTime::createFromFormat('H:i', $request->input('opening'));
        $closing = DateTime::createFromFormat('H:i', $request->input('closing'));
        if ($opening > $closing) {
            return redirect()->route('opening-datetime.view')->withErrors('De opening is na de sluiting.');
        }

        if ($request->input('open') && (! $request->filled('opening') || ! $request->filled('closing'))) {
            return redirect()->route('opening-datetime.view')->withErrors('Als je open bent moet je wel tijden aangeven dat je open bent.');
        }

        OpeningDatetime::create($request->only(['date', 'open', 'opening', 'closing']));

        return redirect()->route('opening-datetime.view')->with('success', 'Toegevoegd.');
    }

    public function edit(Request $request, OpeningDatetime $openingDatetime)
    {
        if ($request->isMethod('GET')) {
            return view('opening_datetime.edit', ['item' => $openingDatetime]);
        }
        $request->validate([
            'date' => 'required|date',
            'open' => 'required|boolean',
            'opening' => 'nullable|date_format:H:i',
            'closing' => 'nullable|date_format:H:i',
        ]);

        if ($request->input('open') && (! $request->filled('opening') || ! $request->filled('closing'))) {
            return redirect()->route('opening-datetime.edit', ['openingDatetime' => $openingDatetime])->withErrors('Als je open bent moet je wel tijden aangeven dat je open bent.');
        }

        $opening = DateTime::createFromFormat('H:i', $request->input('opening'));
        $closing = DateTime::createFromFormat('H:i', $request->input('closing'));
        if ($opening > $closing) {
            return redirect()->route('opening-datetime.edit', ['openingDatetime' => $openingDatetime])->withErrors('De opening is na de sluiting');
        }

        $openingDatetime->update($request->only(['date', 'open', 'opening', 'closing']));

        return redirect()->route('opening-datetime.view')->with('success', 'Aangepast.');
    }

    public function delete(OpeningDatetime $openingDatetime)
    {
        $openingDatetime->delete();

        return redirect()->route('opening-datetime.view')->with('success', 'Verwijderd.');
    }
}
