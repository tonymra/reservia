<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', Room::class)) {
            abort(403);
        }

        $query = Room::query()->orderBy('room_number');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('room_number', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%")
                    ->orWhere('room_type', 'like', "%{$search}%");
            });
        }

        return Inertia::render('Rooms/Index', [
            'rooms' => $query->paginate(10)->withQueryString(),
            'routeName' => Route::currentRouteName(),
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Room::class)) {
            abort(403);
        }

        return Inertia::render('Rooms/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Room::class)) {
            abort(403);
        }

        Room::create($request->validate([
            'room_number' => ['required', 'max:255'],
            'price' => ['required', 'numeric', 'max:99999.99'],
            'room_type' => ['required', 'max:255'],
            'description' => ['required'],
        ]));

        return redirect()->route('rooms.index')->with('success', 'Room created !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->user()->cannot('view', Room::class)) {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit(Request $request, Room $room)
    {
        if ($request->user()->cannot('update', Room::class)) {
            abort(403);
        }


        return Inertia::render('Rooms/Edit', [
            'room' => [
                'id' => $room->id,
                'room_type' => $room->room_type,
                'room_number' => $room->room_number,
                'description' => $room->description,
                'price' => $room->price
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $roomId)
    {
        if ($request->user()->cannot('update', Room::class)) {
            abort(403);
        }

        $room = Room::whereId($roomId)->firstOrFail();

        $validated = $request->validate([
            'room_number' => ['required', 'string', 'max:255'],
            'room_type' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request, $roomId)
    {
        if ($request->user()->cannot('delete', Room::class)) {
            abort(403);
        }

        $room = Room::whereId($roomId)->firstOrFail();

        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }

}
