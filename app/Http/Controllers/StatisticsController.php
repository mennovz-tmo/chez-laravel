<?php

namespace App\Http\Controllers;

use App\Models\OpeningDatetime;
use App\Models\Recipe;
use App\Models\Reservation;
use App\Models\WeeklySchedule;
use Illuminate\Support\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalReservations = Reservation::count();
        $totalGuests = (int) Reservation::sum('amount_of_people');
        $averagePartySize = round((float) (Reservation::avg('amount_of_people') ?? 0), 1);
        $upcomingReservations = Reservation::where('date', '>=', $today->toDateString())->count();

        $start = $today->copy()->subDays(13);
        $perDayRows = Reservation::selectRaw('date, COUNT(*) as reservations, SUM(amount_of_people) as guests')
            ->where('date', '>=', $start->toDateString())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy(fn ($row) => Carbon::parse($row->date)->toDateString());

        $reservationLabels = [];
        $reservationsPerDay = [];
        $guestsPerDay = [];
        for ($i = 0; $i < 14; $i++) {
            $date = $start->copy()->addDays($i);
            $key = $date->toDateString();
            $reservationLabels[] = $date->format('d-m');
            $reservationsPerDay[] = (int) ($perDayRows->get($key)->reservations ?? 0);
            $guestsPerDay[] = (int) ($perDayRows->get($key)->guests ?? 0);
        }

        $arrivalsByHour = Reservation::pluck('arrival')
            ->map(fn ($arrival) => (int) Carbon::parse($arrival)->format('H'))
            ->countBy()
            ->sortKeys();

        $arrivalLabels = $arrivalsByHour->keys()->map(fn ($hour) => sprintf('%02d:00', $hour))->values()->all();
        $arrivalCounts = $arrivalsByHour->values()->all();

        $specialTotal = OpeningDatetime::count();
        $specialOpen = OpeningDatetime::where('open', true)->count();
        $specialClosed = $specialTotal - $specialOpen;
        $upcomingSpecials = OpeningDatetime::where('date', '>=', $today->toDateString())
            ->orderBy('date')
            ->limit(5)
            ->get();

        $weekly = WeeklySchedule::orderBy('day_of_week')->get();
        $weeklyOpenDays = $weekly->where('is_open', true)->count();
        $dayNames = ['Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za', 'Zo'];
        $weeklyHoursLabels = [];
        $weeklyHoursData = [];
        foreach ($weekly as $day) {
            $weeklyHoursLabels[] = $dayNames[$day->day_of_week] ?? (string) $day->day_of_week;
            if (! $day->is_open || ! $day->opening || ! $day->closing) {
                $weeklyHoursData[] = 0;

                continue;
            }
            $weeklyHoursData[] = round(Carbon::parse($day->closing)->diffInMinutes(Carbon::parse($day->opening)) / 60, 1);
        }

        $totalRecipes = Recipe::count();
        $averagePrice = round((float) (Recipe::avg('price') ?? 0), 2);
        $minPrice = (float) (Recipe::min('price') ?? 0);
        $maxPrice = (float) (Recipe::max('price') ?? 0);

        $pricesPerRecipe = Recipe::orderByDesc('price')->limit(12)->get(['name', 'price']);
        $recipePriceLabels = $pricesPerRecipe->pluck('name')->all();
        $recipePriceData = $pricesPerRecipe->pluck('price')->map(fn ($price) => (float) $price)->all();

        $allergenRows = Recipe::selectRaw('allergens, COUNT(*) as total')
            ->groupBy('allergens')
            ->orderByDesc('total')
            ->limit(8)
            ->get();
        $allergenLabels = $allergenRows->pluck('allergens')->all();
        $allergenData = $allergenRows->pluck('total')->map(fn ($total) => (int) $total)->all();

        return view('statistics.index', [
            'totalReservations' => $totalReservations,
            'totalGuests' => $totalGuests,
            'averagePartySize' => $averagePartySize,
            'upcomingReservations' => $upcomingReservations,
            'reservationLabels' => $reservationLabels,
            'reservationsPerDay' => $reservationsPerDay,
            'guestsPerDay' => $guestsPerDay,
            'arrivalLabels' => $arrivalLabels,
            'arrivalCounts' => $arrivalCounts,
            'specialTotal' => $specialTotal,
            'specialOpen' => $specialOpen,
            'specialClosed' => $specialClosed,
            'upcomingSpecials' => $upcomingSpecials,
            'weeklyOpenDays' => $weeklyOpenDays,
            'weeklyHoursLabels' => $weeklyHoursLabels,
            'weeklyHoursData' => $weeklyHoursData,
            'totalRecipes' => $totalRecipes,
            'averagePrice' => $averagePrice,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'recipePriceLabels' => $recipePriceLabels,
            'recipePriceData' => $recipePriceData,
            'allergenLabels' => $allergenLabels,
            'allergenData' => $allergenData,
        ]);
    }
}
