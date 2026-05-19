<?php

namespace App\Http\Controllers;

use App\Http\Requests\VisitPostRequest;
use App\Models\Visit;
use App\Models\VisitedSite;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    public function store(VisitPostRequest $request)
    {
        $validated  = $request->validated();
        $visitedSite = VisitedSite::where('domain', $validated['domain'])->first();
        if ($visitedSite) {
            $visitedSite->update([
                'domain' => $validated['domain'],
                'api_key' => $validated['api_key']
            ]);
        } else {
            $visitedSite = new VisitedSite();
            $visitedSite->domain = $validated['domain'];
            $visitedSite->api_key = $validated['api_key'];
            $visitedSite->save();
        }

        $visit = new Visit();
        $visit->ip = $validated['ip'];
        $visit->visited_site_id = $visitedSite->id;
        $visit->city = $validated['city'] ?? null;
        $visit->country = $validated['country'] ?? null;
        $visit->device = $validated['device'] ?? null;
        $visit->url = $validated['url'] ?? null;
        $visit->save();

        return response()->json(['status' => 'ok']);
    }

    public function hourly()
    {
        return Cache::remember('visits_stats_hourly', 3600, function () {
            $raw = Visit::select(
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('COUNT(DISTINCT ip) as unique_visits')
            )
                ->groupBy(DB::raw('HOUR(created_at)'))
                ->orderBy('hour')
                ->pluck('unique_visits', 'hour');

            $result = [];

            for ($i = 0; $i < 24; $i++) {
                $result[] = [
                    'hour' => str_pad($i, 2, '0', STR_PAD_LEFT),
                    'unique_visits' => $raw[$i] ?? 0
                ];
            }

            return response()->json($result);
        });
    }

    public function cities()
    {
        return Cache::remember('visits_stats_cities', 3600, function () {
            $data = Visit::selectRaw('city, COUNT(*) as count')
                ->groupBy('city')
                ->orderByDesc('count')
                ->get();

            return response()->json($data);
        });
    }

    public function index()
    {
        return view('stats');
    }
}
