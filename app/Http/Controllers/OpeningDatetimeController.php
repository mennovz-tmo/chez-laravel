<?php

namespace App\Http\Controllers;

use App\Models\OpeningDatetime;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OpeningDatetimeController extends Controller
{
    public function index()
    {
        return view('opening_datetime.index')->with(['items' => OpeningDatetime::all()->sortByDesc('date')]);
    }

    private function validate_opening_datetime(Request $request, ?OpeningDatetime $openingDatetime = null): array|RedirectResponse
    {
        $redirect_with_error = function (string $message) use ($openingDatetime) {
            $redirect = $openingDatetime
                ? redirect()->route('opening-datetime.edit', compact('openingDatetime'))
                : redirect()->route('opening-datetime.view');

            return $redirect->withErrors($message);
        };

        $validated = $request->validate([
            'date' => 'required|date',
            'open' => 'required|boolean',
            'opening' => 'nullable|date_format:H:i',
            'closing' => 'nullable|date_format:H:i',
        ]);

        $existing_date = OpeningDatetime::select('date')->where('date', '=', $validated['date'])->get();
        if ($existing_date->count() > 0) {
            $redirect_with_error('De ingevulde datum heeft al speciale data.');
        }

        if ($validated['open'] && (! $request->filled('opening') || ! $request->filled('closing'))) {
            return $redirect_with_error('Als je open bent moet je wel tijden aangeven dat je open bent.');
        }

        $opening = DateTime::createFromFormat('H:i', $validated['opening'] ?? '');
        $closing = DateTime::createFromFormat('H:i', $validated['closing'] ?? '');
        if ($opening > $closing) {
            return $redirect_with_error('De opening is na de sluiting.');
        }

        return $validated;
    }

    public function create(Request $request)
    {
        $validated = $this->validate_opening_datetime($request);

        if ($validated instanceof RedirectResponse) {
            return $validated;
        }

        OpeningDatetime::create($validated);

        return redirect()
            ->route('opening-datetime.view')
            ->with('success', 'Toegevoegd.');
    }

    public function edit(Request $request, OpeningDatetime $openingDatetime)
    {
        if ($request->isMethod('GET')) {
            return view('opening_datetime.edit')->with(['item' => $openingDatetime]);
        }
        $validated = $this->validate_opening_datetime($request, $openingDatetime);

        if ($validated instanceof RedirectResponse) {
            return $validated;
        }

        $openingDatetime->update($validated);

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
