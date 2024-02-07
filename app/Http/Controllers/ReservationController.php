<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', Reservation::class)) {
            abort(403);
        }

        $query = Reservation::query()->orderBy('reference','desc');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('check_in', 'like', "%{$search}%")
                    ->orWhere('check_out', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%");
            });
        }

        return Inertia::render('Reservations/Index', [
            'reservations' => $query->paginate(10)->withQueryString(),
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
        if ($request->user()->cannot('create', Reservation::class)) {
            abort(403);
        }


        $rooms = Room::whereDoesntHave('reservations', function ($query) {
            $query->where('status', 'confirmed');
        })->get();


        return Inertia::render('Reservations/Create', [
            'rooms' => $rooms
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Reservation::class)) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'adults' => ['required', 'integer', 'min:1'],
            'children' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after_or_equal:check_in'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'string', 'max:255'],
            'shuttle' => ['nullable', 'boolean'],
            'parking' => ['nullable', 'boolean'],
            'breakfast' => ['nullable', 'boolean'],
            'room_id' => [
                'required',
                Rule::exists('rooms', 'id'),
                function ($attribute, $value, $fail) use ($request) {
                    $existingReservation = Reservation::whereHas('rooms', function ($query) use ($value) {
                        $query->where('rooms.id', $value);
                    })->where('status', 'confirmed')
                        ->where(function ($query) use ($request) {
                            $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                                ->orWhereBetween('check_out', [$request->check_in, $request->check_out]);
                        })->exists();

                    if ($existingReservation) {
                        return $fail('The selected room is already booked for the given date range.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

// Generate a unique reference...
        $latestReservation = Reservation::latest()->first();
        $i = optional($latestReservation)->id ?? 0;
        $reference = 'R' . date('Ymd') . str_pad($i + 1, 4, '0', STR_PAD_LEFT);

        $user_id = auth()->id(); // Include the user_id of the logged-in user

// Include the optional checkbox values if present in the request
        $reservationData = array_merge($validated, [
            'reference' => $reference,
            'user_id' => $user_id,
        ]);

// Check if the checkboxes are present in the request and include them if not null
        if ($request->has('shuttle')) {
            $reservationData['shuttle'] = $request->boolean('shuttle');
        }
        if ($request->has('parking')) {
            $reservationData['parking'] = $request->boolean('parking');
        }
        if ($request->has('breakfast')) {
            $reservationData['breakfast'] = $request->boolean('breakfast');
        }

// Create the reservation with the merged data
        $reservation = Reservation::create($reservationData);

// Attach the room to the reservation...
        $reservation->rooms()->attach($request->room_id);

        return redirect()->route('reservations.index')->with('success', 'Reservation created successfully!');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->user()->cannot('view', Reservation::class)) {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */


    public function edit(Request $request, Reservation $reservation)
    {
        if ($request->user()->cannot('update', Reservation::class)) {
            abort(403);
        }
        $rooms = Room::whereDoesntHave('reservations', function ($query) {
            $query->where('status', 'confirmed');
        })->get();

        return Inertia::render('Reservations/Edit', [
            'reservation' => $reservation->toArray(),
            'reservation_rooms' => $reservation->rooms,
            'rooms' => $rooms
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $reservationId)
    {
        // Check if the user has permission to update reservations
        if ($request->user()->cannot('update', Reservation::class)) {
            abort(403);
        }

        // Find the reservation by ID or throw a 404 error if not found
        $reservation = Reservation::findOrFail($reservationId);

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'adults' => ['required', 'integer', 'min:1'],
            'children' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after_or_equal:check_in'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'string', 'max:255'],
            'shuttle' => ['nullable', 'boolean'],
            'parking' => ['nullable', 'boolean'],
            'breakfast' => ['nullable', 'boolean'],
            'room_id' => [
                Rule::exists('rooms', 'id'),
                function ($attribute, $value, $fail) use ($request, $reservation) {
                    // Check if the selected room is already booked for the given date range
                    $existingReservation = Reservation::whereHas('rooms', function ($query) use ($value) {
                        $query->where('rooms.id', $value);
                    })->where('status', 'confirmed')
                        ->where(function ($query) use ($request, $reservation) {
                            $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                                ->orWhereBetween('check_out', [$request->check_in, $request->check_out]);
                        })->exists();

                    if ($existingReservation && $reservation->room_id != $value) {
                        return $fail('The selected room is already booked for the given date range.');
                    }
                },
            ],
        ]);

        // If validation fails, redirect back with errors and input data
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if the request includes a new room_id and if rooms are associated with the reservation
        if ($request->has('room_id') && $reservation->rooms->isNotEmpty()) {
            // Update the pivot table with the new room_id
            $reservation->rooms()->sync([$request->room_id]);
        }

        // Update the reservation with the validated data
        $reservation->update($validator->validated());

        // Redirect to the reservations index page with a success message
        return redirect()->route('reservations.index')->with('success', 'Reservation updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request, $reservationId)
    {
        if ($request->user()->cannot('delete', Reservation::class)) {
            abort(403);
        }

        $reservation = Reservation::whereId($reservationId)->firstOrFail();

        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully.');
    }

}
