@extends('layouts.eventflare')

@section('title', 'Book Your Celebration — EVENTFLARE')

@section('content')
<div style="max-width: 1100px; margin: 40px auto 80px; padding: 0 24px;">

    <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 40px; align-items: start;">
        <!-- Left: Form Container -->
        <div class="glass-card" style="padding: 35px;">
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(139, 92, 246, 0.1); color: var(--primary); padding: 5px 14px; border-radius: 20px; font-size: 13px; font-weight: 700; margin-bottom: 12px;">
                <i class="fas fa-calendar-plus"></i> Guaranteed Booking Engine
            </div>
            <h1 style="font-size: 32px; font-weight: 900; color: var(--text-heading); margin-bottom: 8px;">
                Book Your Celebration
            </h1>
            <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 25px;">
                Directly configure your dates, venue, guest numbers, and food preference tier.
            </p>

            <!-- Dynamic Category Wizard Banner -->
            @if(strcasecmp($preEvent, 'Weddings') === 0 || strcasecmp($preEvent, 'Wedding') === 0)
                <div style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.12), rgba(236, 72, 153, 0.1)); border: 1px solid rgba(139, 92, 246, 0.3); border-radius: 14px; padding: 16px 18px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 15px;">
                    <div>
                        <strong style="color: var(--primary); font-size: 14px; display: block; margin-bottom: 2px;"><i class="fas fa-gem"></i> Planning a Royal Wedding?</strong>
                        <span style="font-size: 12px; color: var(--text-muted);">Accredited florists, poruwa stylists, and photography specialists are ready.</span>
                    </div>
                </div>
            @elseif(stripos($preEvent, 'DJ') !== false || stripos($preEvent, 'Party') !== false)
                <div style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(236, 72, 153, 0.08)); border: 1px solid rgba(139, 92, 246, 0.3); border-radius: 14px; padding: 16px 18px; margin-bottom: 24px;">
                    <strong style="color: var(--primary); font-size: 14px; display: block; margin-bottom: 2px;"><i class="fas fa-bolt"></i> Intelligent Sound & Club Visuals Active</strong>
                    <span style="font-size: 12px; color: var(--text-muted);">High-output lighting rigs, pro audio stacks, and headline DJ packages available.</span>
                </div>
            @endif

            <form method="POST" action="{{ route('booking.store') }}">
                @csrf

                <!-- Customer Read-Only Badge (Security Fix: prevents username spoofing) -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <small style="color: var(--text-muted); font-size: 11px; font-weight: 700; text-transform: uppercase;">Logged In Client</small>
                        <div style="font-weight: 800; font-size: 14px; color: var(--text-heading);">
                            {{ Auth::user()->fullname ?? Auth::user()->username }} ({{ Auth::user()->email }})
                        </div>
                    </div>
                    <span style="background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 10px;">
                        <i class="fas fa-shield-alt"></i> Verified Account
                    </span>
                </div>

                <!-- Event Type & Venue -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                    <div>
                        <label class="form-label" for="EventType">Event Category <span style="color:#ef4444;">*</span></label>
                        <select id="EventType" class="form-input" name="EventType" required>
                            <option value="">Select category</option>
                            @foreach ($eventTypes as $type)
                                <option value="{{ $type->type_name }}" {{ (strcasecmp($preEvent, $type->type_name) === 0 || old('EventType') === $type->type_name) ? 'selected' : '' }}>
                                    {{ $type->type_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('EventType') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="form-label" for="Place">Venue / City Location <span style="color:#ef4444;">*</span></label>
                        <input type="text" id="Place" class="form-input" placeholder="e.g. Shangri-La Colombo or Kandy" name="Place" 
                               value="{{ old('Place', $preVenue) }}" required>
                        @error('Place') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Guests & Date -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                    <div>
                        <label class="form-label" for="NumberOfGuests">Expected Guests <span style="color:#ef4444;">*</span></label>
                        <input type="number" id="NumberOfGuests" class="form-input" placeholder="e.g. 150" name="NumberOfGuests" min="1" max="50000"
                               value="{{ old('NumberOfGuests', $preGuests > 0 ? $preGuests : 100) }}" required>
                        @error('NumberOfGuests') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="form-label" for="EventDate">Reservation Date <span style="color:#ef4444;">*</span></label>
                        <input type="date" id="EventDate" class="form-input" name="EventDate" min="{{ date('Y-m-d') }}"
                               value="{{ old('EventDate') }}" required>
                        @error('EventDate') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Day/Night Session & Food Tier -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                    <div>
                        <label class="form-label" for="DayNight">Session Timing <span style="color:#ef4444;">*</span></label>
                        <select id="DayNight" class="form-input" name="DayNight" required>
                            <option value="">Select session</option>
                            <option value="Day" {{ old('DayNight') === 'Day' ? 'selected' : '' }}>Day Session (Morning/Afternoon)</option>
                            <option value="Night" {{ old('DayNight') === 'Night' ? 'selected' : '' }}>Night Session (Evening Gala)</option>
                        </select>
                        @error('DayNight') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="form-label" for="FoodPreferences">Catering Tier <span style="color:#ef4444;">*</span></label>
                        <select id="FoodPreferences" class="form-input" name="FoodPreferences" required>
                            <option value="">Select pricing tier</option>
                            <option value="High price" {{ old('FoodPreferences') === 'High price' ? 'selected' : '' }}>High Tier (Luxury Buffet & Live Stations)</option>
                            <option value="Middle price" {{ old('FoodPreferences') === 'Middle price' ? 'selected' : '' }}>Medium Tier (Standard 3-Course Buffet)</option>
                            <option value="Low Price" {{ old('FoodPreferences') === 'Low Price' ? 'selected' : '' }}>Economy Tier (Light Refreshments & Starters)</option>
                        </select>
                        <a href="{{ route('food-calculator') }}" target="_blank" style="font-size: 12px; color: var(--primary); font-weight: 600; display: inline-block; margin-top: 4px;">
                            <i class="fas fa-calculator"></i> Open Food Calculator
                        </a>
                        @error('FoodPreferences') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Event Extra Equipment / Staging -->
                <div style="margin-bottom: 18px;">
                    <label class="form-label" for="equipment">Stage & AV Production Needs (Optional)</label>
                    <input type="text" id="equipment" class="form-input" name="equipment" 
                           placeholder="e.g. Ambient floral arch, wireless handheld mics, LED mood wash"
                           value="{{ old('equipment') }}">
                </div>

                <!-- Special Instructions -->
                <div style="margin-bottom: 24px;">
                    <label class="form-label" for="ExtraDetails">Special Notes & Itinerary Requests</label>
                    <textarea id="ExtraDetails" class="form-input" style="height: 90px; resize: vertical;" name="ExtraDetails" 
                              placeholder="Any dietary restrictions, theme colors, VIP requests, or specific vendor preferences...">{{ old('ExtraDetails', $preDetails) }}</textarea>
                </div>

                <!-- Itemized Vendor Packages (if applicable) -->
                @if($services->isNotEmpty())
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px; margin-bottom: 24px;">
                        <h4 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin-bottom: 14px;">
                            <i class="fas fa-tags" style="color: var(--primary); margin-right: 6px;"></i> Optional Handpicked Vendor Add-Ons
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @foreach($services as $srv)
                                @if($srv->listings->isNotEmpty())
                                    <div>
                                        <label style="font-size: 12px; font-weight: 700; color: var(--text-heading); display: block; margin-bottom: 4px;">
                                            {{ $srv->service_name }}
                                        </label>
                                        <select name="selected_packages[{{ $srv->service_id }}]" class="form-input" style="font-size: 13px;">
                                            <option value="">No vendor add-on (Default coordination)</option>
                                            @foreach($srv->listings as $pkg)
                                                <option value="{{ $pkg->listing_id }}">
                                                    {{ $pkg->supplier->business_name }}: {{ $pkg->title }} — LKR {{ number_format($pkg->price) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; border-radius: 30px; font-size: 15px; font-weight: 800;">
                    <i class="fas fa-check-circle"></i> Confirm & Secure Event Reservation
                </button>
            </form>
        </div>

        <!-- Right: Showcase & Assurance Sidecard -->
        <div>
            <div style="position: sticky; top: 100px; display: flex; flex-direction: column; gap: 20px;">
                <!-- Trust Card -->
                <div class="glass-card" style="padding: 26px; border-radius: 20px;">
                    <h3 style="font-size: 18px; font-weight: 800; color: var(--text-heading); margin-bottom: 14px;">
                        <i class="fas fa-award" style="color: #f59e0b; margin-right: 6px;"></i> Why Book with EVENTFLARE?
                    </h3>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px; font-size: 13px; color: var(--text-muted);">
                        <li style="display: flex; gap: 10px; align-items: flex-start;">
                            <i class="fas fa-check-circle" style="color: #10b981; margin-top: 2px;"></i>
                            <span><strong>100% Accredited Suppliers:</strong> Every caterer, decorator, and sound engineer is vetted.</span>
                        </li>
                        <li style="display: flex; gap: 10px; align-items: flex-start;">
                            <i class="fas fa-check-circle" style="color: #10b981; margin-top: 2px;"></i>
                            <span><strong>Transparent Pricing:</strong> No surprise fees; clear itemized estimates in Sri Lankan Rupees.</span>
                        </li>
                        <li style="display: flex; gap: 10px; align-items: flex-start;">
                            <i class="fas fa-check-circle" style="color: #10b981; margin-top: 2px;"></i>
                            <span><strong>Instant Itinerary PDF:</strong> Receive your formal confirmation slip immediately upon booking.</span>
                        </li>
                    </ul>
                </div>

                <!-- Event Image Banner -->
                <div style="border-radius: 20px; overflow: hidden; height: 260px; position: relative; box-shadow: var(--shadow-premium);">
                    <img src="{{ asset('assets/images/evnt.jpg') }}" alt="Event Celebration" 
                         style="width: 100%; height: 100%; object-fit: cover;"
                         onerror="this.src='https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=800'">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(10,8,19,0.85), transparent); display: flex; flex-direction: column; justify-content: flex-end; padding: 20px; color: #fff;">
                        <h4 style="font-size: 18px; font-weight: 800; margin: 0 0 4px;">Unforgettable Moments</h4>
                        <p style="font-size: 12px; color: rgba(255,255,255,0.8); margin: 0;">Tailored celebrations across Sri Lanka from concept to completion.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
