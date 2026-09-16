<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodCalculatorController extends Controller
{
    public function index()
    {
        $userBookings = collect();
        if (Auth::check()) {
            $userBookings = Booking::where('user_id', Auth::id())->get();
        }

        $data = [
            'total_budget' => 1500000,
            'food_budget' => 800000,
            'buffet_quantity' => 150,
            'buffet_price' => 3800,
            'beverages_quantity' => 150,
            'beverages_price' => 650,
            'desserts_quantity' => 150,
            'desserts_price' => 450,
            'snacks_quantity' => 100,
            'snacks_price' => 300,
            'buffet_cost' => 570000,
            'beverages_cost' => 97500,
            'desserts_cost' => 67500,
            'snacks_cost' => 30000,
            'total_spent' => 765000,
            'remaining_budget' => 35000,
            'variance' => 35000,
            'calculated' => false,
        ];

        return view('pages.food-calculator', compact('data', 'userBookings'));
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'total_budget' => ['required', 'numeric', 'min:0'],
            'food_budget' => ['required', 'numeric', 'min:0'],
            'buffet_quantity' => ['required', 'integer', 'min:0'],
            'buffet_price' => ['required', 'numeric', 'min:0'],
            'beverages_quantity' => ['required', 'integer', 'min:0'],
            'beverages_price' => ['required', 'numeric', 'min:0'],
            'desserts_quantity' => ['required', 'integer', 'min:0'],
            'desserts_price' => ['required', 'numeric', 'min:0'],
            'snacks_quantity' => ['required', 'integer', 'min:0'],
            'snacks_price' => ['required', 'numeric', 'min:0'],
            'booking_id' => ['nullable', 'string', 'max:50'],
        ]);

        $buffetCost = $validated['buffet_quantity'] * $validated['buffet_price'];
        $beveragesCost = $validated['beverages_quantity'] * $validated['beverages_price'];
        $dessertsCost = $validated['desserts_quantity'] * $validated['desserts_price'];
        $snacksCost = $validated['snacks_quantity'] * $validated['snacks_price'];

        $totalSpent = $buffetCost + $beveragesCost + $dessertsCost + $snacksCost;
        $remainingBudget = $validated['food_budget'] - $totalSpent;
        $variance = $remainingBudget;

        $data = array_merge($validated, [
            'buffet_cost' => $buffetCost,
            'beverages_cost' => $beveragesCost,
            'desserts_cost' => $dessertsCost,
            'snacks_cost' => $snacksCost,
            'total_spent' => $totalSpent,
            'remaining_budget' => $remainingBudget,
            'variance' => $variance,
            'calculated' => true,
        ]);

        if ($request->has('save_to_db')) {
            Budget::create([
                'user_name' => Auth::user()->username ?? 'Guest',
                'booking_id' => $validated['booking_id'] ?? null,
                'total_budget' => $validated['total_budget'],
                'food_budget' => $validated['food_budget'],
                'buffet_cost' => $buffetCost,
                'beverages_cost' => $beveragesCost,
                'desserts_cost' => $dessertsCost,
                'snacks_cost' => $snacksCost,
                'total_spent' => $totalSpent,
                'remaining_budget' => $remainingBudget,
                'variance' => $variance,
            ]);

            session()->flash('success', 'Budget estimate computed and saved to your records successfully!');
        }

        $userBookings = collect();
        if (Auth::check()) {
            $userBookings = Booking::where('user_id', Auth::id())->get();
        }

        return view('pages.food-calculator', compact('data', 'userBookings'));
    }
}