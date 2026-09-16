@extends('layouts.eventflare')

@section('title', 'Food & Catering Budget Calculator — EVENTFLARE')

@section('content')
<div style="max-width: 1100px; margin: 0 auto; padding: 40px 24px;">
    <div style="text-align: center; margin-bottom: 40px;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(139, 92, 246, 0.1); color: var(--primary); padding: 6px 16px; border-radius: 30px; font-size: 13px; font-weight: 700; margin-bottom: 12px;">
            <i class="fas fa-calculator"></i> Catering Cost Intelligence
        </div>
        <h1 style="font-size: 36px; font-weight: 900; color: var(--text-heading); margin-bottom: 10px;">Food & Beverage Budget Calculator</h1>
        <p style="color: var(--text-muted); font-size: 15px; max-width: 620px; margin: 0 auto;">Plan guest plate costs, beverage packages, and dessert stations with real-time variance detection.</p>
    </div>

    <form method="POST" action="{{ route('food-calculator.calculate') }}">
        @csrf

        <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 30px; align-items: start;">
            <!-- Input Parameters Card -->
            <div class="glass-card">
                <h2 style="font-size: 20px; font-weight: 800; margin-bottom: 20px; color: var(--text-heading); border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
                    <i class="fas fa-sliders-h" style="color: var(--primary); margin-right: 8px;"></i> Budget Parameters
                </h2>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                    <div>
                        <label style="display:block; font-size:13px; font-weight:700; margin-bottom:6px;">Total Event Budget (LKR)</label>
                        <input type="number" name="total_budget" value="{{ old('total_budget', $data['total_budget']) }}" class="form-input" required>
                    </div>
                    <div>
                        <label style="display:block; font-size:13px; font-weight:700; margin-bottom:6px;">Allocated Food Budget (LKR)</label>
                        <input type="number" name="food_budget" value="{{ old('food_budget', $data['food_budget']) }}" class="form-input" required>
                    </div>
                </div>

                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 14px; color: var(--text-heading);">Itemized Food Categories</h3>

                <!-- Buffet -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:16px; margin-bottom:14px;">
                    <div style="font-weight:700; font-size:14px; margin-bottom:10px;"><i class="fas fa-utensils" style="color:#ec4899; margin-right:6px;"></i> Buffet / Plated Meals</div>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                        <div>
                            <label style="font-size:12px; color:var(--text-muted);">Guest Count (Pax)</label>
                            <input type="number" name="buffet_quantity" value="{{ old('buffet_quantity', $data['buffet_quantity']) }}" class="form-input" style="padding:10px;" required>
                        </div>
                        <div>
                            <label style="font-size:12px; color:var(--text-muted);">Per Pax Unit Price (LKR)</label>
                            <input type="number" name="buffet_price" value="{{ old('buffet_price', $data['buffet_price']) }}" class="form-input" style="padding:10px;" required>
                        </div>
                    </div>
                </div>

                <!-- Beverages -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:16px; margin-bottom:14px;">
                    <div style="font-weight:700; font-size:14px; margin-bottom:10px;"><i class="fas fa-glass-martini-alt" style="color:#8b5cf6; margin-right:6px;"></i> Welcome Drinks & Mocktails</div>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                        <div>
                            <label style="font-size:12px; color:var(--text-muted);">Quantity / Servings</label>
                            <input type="number" name="beverages_quantity" value="{{ old('beverages_quantity', $data['beverages_quantity']) }}" class="form-input" style="padding:10px;" required>
                        </div>
                        <div>
                            <label style="font-size:12px; color:var(--text-muted);">Unit Price (LKR)</label>
                            <input type="number" name="beverages_price" value="{{ old('beverages_price', $data['beverages_price']) }}" class="form-input" style="padding:10px;" required>
                        </div>
                    </div>
                </div>

                <!-- Desserts -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:16px; margin-bottom:14px;">
                    <div style="font-weight:700; font-size:14px; margin-bottom:10px;"><i class="fas fa-ice-cream" style="color:#f59e0b; margin-right:6px;"></i> Dessert Station & Sweets</div>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                        <div>
                            <label style="font-size:12px; color:var(--text-muted);">Quantity / Servings</label>
                            <input type="number" name="desserts_quantity" value="{{ old('desserts_quantity', $data['desserts_quantity']) }}" class="form-input" style="padding:10px;" required>
                        </div>
                        <div>
                            <label style="font-size:12px; color:var(--text-muted);">Unit Price (LKR)</label>
                            <input type="number" name="desserts_price" value="{{ old('desserts_price', $data['desserts_price']) }}" class="form-input" style="padding:10px;" required>
                        </div>
                    </div>
                </div>

                <!-- Snacks -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:16px; margin-bottom:20px;">
                    <div style="font-weight:700; font-size:14px; margin-bottom:10px;"><i class="fas fa-cookie-bite" style="color:#10b981; margin-right:6px;"></i> Evening Canapés & Snacks</div>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                        <div>
                            <label style="font-size:12px; color:var(--text-muted);">Portion Count</label>
                            <input type="number" name="snacks_quantity" value="{{ old('snacks_quantity', $data['snacks_quantity']) }}" class="form-input" style="padding:10px;" required>
                        </div>
                        <div>
                            <label style="font-size:12px; color:var(--text-muted);">Unit Price (LKR)</label>
                            <input type="number" name="snacks_price" value="{{ old('snacks_price', $data['snacks_price']) }}" class="form-input" style="padding:10px;" required>
                        </div>
                    </div>
                </div>

                @auth
                    @if($userBookings->isNotEmpty())
                        <div style="margin-bottom:20px;">
                            <label style="display:block; font-size:13px; font-weight:700; margin-bottom:6px;">Associate with Your Booking (Optional)</label>
                            <select name="booking_id" class="form-input">
                                <option value="">None (Independent estimate)</option>
                                @foreach($userBookings as $b)
                                    <option value="{{ $b->BookingID }}">{{ $b->BookingID }} — {{ $b->EventType }} ({{ $b->Place }})</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                @endauth

                <div style="display:flex; gap:12px;">
                    <button type="submit" class="btn btn-secondary" style="flex:1; padding:13px;">
                        <i class="fas fa-sync-alt"></i> Calculate Summary
                    </button>
                    @auth
                        <button type="submit" name="save_to_db" value="1" class="btn btn-primary" style="flex:1; padding:13px;">
                            <i class="fas fa-save"></i> Save to Records
                        </button>
                    @endauth
                </div>
            </div>

            <!-- Real-Time Calculation Output Card -->
            <div>
                <div class="glass-card" style="background:#ffffff; border:2px solid var(--card-border);">
                    <h2 style="font-size: 20px; font-weight: 800; margin-bottom: 20px; color: var(--text-heading); border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
                        <i class="fas fa-chart-pie" style="color: var(--primary); margin-right: 8px;"></i> Cost Breakdown
                    </h2>

                    <div style="display:flex; flex-direction:column; gap:14px; margin-bottom:24px;">
                        <div style="display:flex; justify-content:space-between; font-size:14px;">
                            <span style="color:var(--text-muted);"><i class="fas fa-utensils"></i> Buffet Meals</span>
                            <span style="font-weight:700;">LKR {{ number_format($data['buffet_cost']) }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:14px;">
                            <span style="color:var(--text-muted);"><i class="fas fa-glass-martini-alt"></i> Beverages</span>
                            <span style="font-weight:700;">LKR {{ number_format($data['beverages_cost']) }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:14px;">
                            <span style="color:var(--text-muted);"><i class="fas fa-ice-cream"></i> Desserts</span>
                            <span style="font-weight:700;">LKR {{ number_format($data['desserts_cost']) }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:14px;">
                            <span style="color:var(--text-muted);"><i class="fas fa-cookie-bite"></i> Snacks & Canapés</span>
                            <span style="font-weight:700;">LKR {{ number_format($data['snacks_cost']) }}</span>
                        </div>
                    </div>

                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:14px; padding:18px; margin-bottom:20px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <span style="font-size:13px; color:var(--text-muted); font-weight:600;">Total Catering Cost</span>
                            <span style="font-size:22px; font-weight:900; color:var(--primary);">LKR {{ number_format($data['total_spent']) }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:13px; color:var(--text-muted); font-weight:600;">Allocated Food Budget</span>
                            <span style="font-size:15px; font-weight:700;">LKR {{ number_format($data['food_budget']) }}</span>
                        </div>
                    </div>

                    @if($data['remaining_budget'] >= 0)
                        <div style="background:#ecfdf5; border:1px solid #a7f3d0; border-radius:12px; padding:16px; color:#065f46; display:flex; align-items:center; gap:12px;">
                            <i class="fas fa-check-circle" style="font-size:24px;"></i>
                            <div>
                                <div style="font-weight:800; font-size:14px;">Within Budget Surplus</div>
                                <div style="font-size:12px; opacity:0.9;">You have LKR {{ number_format($data['remaining_budget']) }} remaining in your catering envelope.</div>
                            </div>
                        </div>
                    @else
                        <div style="background:#fef2f2; border:1px solid #fecaca; border-radius:12px; padding:16px; color:#991b1b; display:flex; align-items:center; gap:12px;">
                            <i class="fas fa-exclamation-triangle" style="font-size:24px;"></i>
                            <div>
                                <div style="font-weight:800; font-size:14px;">Budget Deficit Alert</div>
                                <div style="font-size:12px; opacity:0.9;">Projected catering exceeds allocated food budget by LKR {{ number_format(abs($data['remaining_budget'])) }}.</div>
                            </div>
                        </div>
                    @endif

                    <div style="margin-top:20px; text-align:center;">
                        <a href="{{ route('events.index') }}" class="btn btn-outline" style="border:1px solid #e2e8f0; width:100%; font-size:13px;">
                            <i class="fas fa-store"></i> Browse Accredited Caterers
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection