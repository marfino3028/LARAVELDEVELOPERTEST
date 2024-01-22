<?php

// app/Http/Controllers/ReservationController.php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'reservation_time' => 'required|date',
            'walk_in' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        return \DB::transaction(function () use ($request) {
            $reservation = Reservation::create([
                'name' => $request->input('name'),
                'reservation_time' => $request->input('reservation_time'),
                'walk_in' => $request->input('walk_in', false),
            ]);

            return response()->json(['reservation' => $reservation], 201);
        });
    }

    public function index()
    {
        $reservations = Reservation::all();

        return response()->json(['reservations' => $reservations], 200);
    }
}
