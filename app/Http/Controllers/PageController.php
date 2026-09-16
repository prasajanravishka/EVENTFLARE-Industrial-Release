<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\EventType;
use App\Models\Rating;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $reviews = Rating::with(['user', 'supplier'])
            ->where('admin_status', 'approved')
            ->where('rating', '>=', 4)
            ->latest()
            ->take(6)
            ->get();

        $eventTypes = EventType::active()->withCount('services')->get();
        $supplierCount = Supplier::count();
        $popularLocations = ['Colombo', 'Kandy', 'Galle', 'Negombo', 'Bentota', 'Nuwara Eliya', 'Gampaha', 'Kalutara'];

        return view('pages.home', compact('reviews', 'eventTypes', 'supplierCount', 'popularLocations'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function events()
    {
        $eventTypes = EventType::active()->with(['services'])->get();
        return view('pages.events', compact('eventTypes'));
    }

    public function contact(Request $request)
    {
        $validated = $request->validate([
            'firstname' => ['required', 'string', 'max:50'],
            'lastname'  => ['required', 'string', 'max:50'],
            'email'     => ['required', 'email', 'max:100'],
            'phone'     => ['required', 'string', 'max:20'],
            'message'   => ['required', 'string', 'max:2000'],
        ]);

        $contactMessage = ContactMessage::create($validated);

        // Dispatch inquiry notification email to admin desk
        try {
            $adminEmail = config('mail.from.address', 'admin@eventflare.lk');
            \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\NewContactInquiryMail($contactMessage));
        } catch (\Throwable $mailErr) {
            \Illuminate\Support\Facades\Log::warning("Failed to send contact inquiry notification: " . $mailErr->getMessage());
        }

        return redirect()->to(url('/#contact'))->with('success', 'Thank you! Your inquiry has been sent successfully. Our concierge team will reach out shortly.');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }
}