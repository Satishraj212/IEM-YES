<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlagshipEvent;
use Illuminate\Http\Request;

class FlagshipEventController extends Controller
{
    public function index()
    {
        $flagshipEvents = FlagshipEvent::orderByDesc('year')->get();
        return view('admin.flagship-events', [
            'flagshipEvents' => $flagshipEvents,
            'pageTitle'      => 'Flagship',
            'pageSubtitle'   => 'Events',
            'pageDesc'       => 'NATSUM & CAFEO management',
        ]);
    }

    public function create()
    {
        return view('admin.flagship-form', [
            'event'        => null,
            'pageTitle'    => 'New Flagship',
            'pageSubtitle' => 'Event',
            'pageDesc'     => 'Create a new flagship event',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'short_name'          => 'required|string|max:50',
            'full_name'           => 'required|string|max:255',
            'year'                => 'required|integer|min:2000',
            'event_date'          => 'nullable|string|max:100',
            'location'            => 'nullable|string|max:255',
            'host'                => 'nullable|string|max:255',
            'expected_delegates'  => 'nullable|integer|min:1',
            'status'              => 'required|in:planning,upcoming,open,past',
        ]);
        FlagshipEvent::create($data);
        return redirect()->route('admin.flagship-events')->with('success', 'Flagship event created.');
    }

    public function edit(FlagshipEvent $flagshipEvent)
    {
        return view('admin.flagship-form', [
            'event'        => $flagshipEvent,
            'pageTitle'    => 'Edit Flagship',
            'pageSubtitle' => 'Event',
            'pageDesc'     => 'Update ' . $flagshipEvent->short_name . ' ' . $flagshipEvent->year,
        ]);
    }

    public function update(Request $request, FlagshipEvent $flagshipEvent)
    {
        $data = $request->validate([
            'short_name'          => 'required|string|max:50',
            'full_name'           => 'required|string|max:255',
            'year'                => 'required|integer|min:2000',
            'event_date'          => 'nullable|string|max:100',
            'location'            => 'nullable|string|max:255',
            'host'                => 'nullable|string|max:255',
            'expected_delegates'  => 'nullable|integer|min:1',
            'status'              => 'required|in:planning,upcoming,open,past',
        ]);
        $flagshipEvent->update($data);
        return redirect()->route('admin.flagship-events')->with('success', 'Flagship event updated.');
    }
}