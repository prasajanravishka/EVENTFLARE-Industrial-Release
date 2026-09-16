@extends('layouts.eventflare')

@section('title', 'Reservation #' . $booking->BookingID . ' — EVENTFLARE')

@section('content')
<div style="max-width: 1000px; margin: 40px auto 80px; padding: 0 24px;">

    <!-- Top Breadcrumb & Actions -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
        <div>
            <a href="{{ route('client.bookings') }}" style="color: var(--primary); font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 8px;">
                <i class="fas fa-arrow-left"></i> Back to Reservations
            </a>
            <h1 style="font-size: 28px; font-weight: 900; color: var(--text-heading); margin: 0;">
                Reservation #{{ $booking->BookingID }}
            </h1>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('client.bookings.pdf', $booking->BookingID) }}" class="btn btn-secondary" style="border-radius: 25px; padding: 10px 20px; font-size: 13px;">
                <i class="fas fa-file-pdf"></i> Download PDF Voucher
            </a>
            <button onclick="window.print()" class="btn btn-outline" style="border-radius: 25px; padding: 10px 20px; font-size: 13px; border: 1px solid #cbd5e1;">
                <i class="fas fa-print"></i> Print Slip
            </button>
        </div>
    </div>

    <!-- Stepper Status Progression -->
    @php
        $st = $booking->status ?: 'pending';
        $isCancelled = ($st === 'cancelled');
        $step1 = 'completed';
        $step2 = in_array($st, ['confirmed', 'in progress', 'completed']) ? 'completed' : ($st === 'pending' ? 'active' : '');
        $step3 = in_array($st, ['in progress', 'completed']) ? 'completed' : ($st === 'confirmed' ? 'active' : '');
        $step4 = ($st === 'completed') ? 'completed' : ($st === 'in progress' ? 'active' : '');
    @endphp

    @if($isCancelled)
        <div style="background: #fef2f2; border: 1px solid #fee2e2; border-radius: 14px; padding: 16px; color: #b91c1c; font-weight: 700; text-align: center; margin-bottom: 30px;">
            <i class="fas fa-times-circle"></i> This reservation has been CANCELLED. Contact support for reinstatement.
        </div>
    @else
        <div class="glass-card" style="padding: 24px 30px; margin-bottom: 30px; border-radius: 16px;">
            <div style="display: flex; justify-content: space-between; position: relative; align-items: center;">
                <div style="text-align: center; flex: 1;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: #10b981; color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 12px; font-weight: 800;">
                        <i class="fas fa-check"></i>
                    </div>
                    <div style="font-size: 12px; font-weight: 700; color: #065f46;">Submitted</div>
                </div>
                <div style="text-align: center; flex: 1;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $step2 === 'completed' ? '#10b981' : ($step2 === 'active' ? 'var(--primary)' : '#cbd5e1') }}; color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 12px; font-weight: 800;">
                        <i class="fas fa-{{ $step2 === 'completed' ? 'check' : 'clipboard-check' }}"></i>
                    </div>
                    <div style="font-size: 12px; font-weight: 700; color: {{ $step2 ? 'var(--text-heading)' : '#94a3b8' }};">Confirmed</div>
                </div>
                <div style="text-align: center; flex: 1;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $step3 === 'completed' ? '#10b981' : ($step3 === 'active' ? 'var(--primary)' : '#cbd5e1') }}; color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 12px; font-weight: 800;">
                        <i class="fas fa-{{ $step3 === 'completed' ? 'check' : 'spinner' }}"></i>
                    </div>
                    <div style="font-size: 12px; font-weight: 700; color: {{ $step3 ? 'var(--text-heading)' : '#94a3b8' }};">In Progress</div>
                </div>
                <div style="text-align: center; flex: 1;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $step4 === 'completed' ? '#10b981' : ($step4 === 'active' ? 'var(--primary)' : '#cbd5e1') }}; color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 12px; font-weight: 800;">
                        <i class="fas fa-flag-checkered"></i>
                    </div>
                    <div style="font-size: 12px; font-weight: 700; color: {{ $step4 ? 'var(--text-heading)' : '#94a3b8' }};">Completed</div>
                </div>
            </div>
        </div>
    @endif

    <!-- Event Summary Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 30px;">
        <div class="glass-card" style="padding: 20px;">
            <small style="font-size: 11px; text-transform: uppercase; font-weight: 800; color: var(--text-muted); display: block; margin-bottom: 4px;">EVENT CATEGORY</small>
            <div style="font-weight: 800; font-size: 16px; color: var(--text-heading);">{{ $booking->EventType }}</div>
            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">{{ $booking->DayNight }} Session</div>
        </div>
        <div class="glass-card" style="padding: 20px;">
            <small style="font-size: 11px; text-transform: uppercase; font-weight: 800; color: var(--text-muted); display: block; margin-bottom: 4px;">RESERVED DATE</small>
            <div style="font-weight: 800; font-size: 16px; color: var(--primary);">{{ \Carbon\Carbon::parse($booking->EventDate)->format('M d, Y') }}</div>
            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">Headcount: {{ $booking->NumberOfGuests }} Guests</div>
        </div>
        <div class="glass-card" style="padding: 20px;">
            <small style="font-size: 11px; text-transform: uppercase; font-weight: 800; color: var(--text-muted); display: block; margin-bottom: 4px;">DESTINATION VENUE</small>
            <div style="font-weight: 800; font-size: 16px; color: var(--text-heading);">{{ $booking->Place }}</div>
            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">Sri Lanka Venue</div>
        </div>
        <div class="glass-card" style="padding: 20px;">
            <small style="font-size: 11px; text-transform: uppercase; font-weight: 800; color: var(--text-muted); display: block; margin-bottom: 4px;">CATERING TIER</small>
            <div style="font-weight: 800; font-size: 16px; color: var(--text-heading);">{{ $booking->FoodPreferences ?: 'Standard' }}</div>
            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">Full Service Provision</div>
        </div>
    </div>

    <!-- Contracted Suppliers & Itemized Services -->
    <div class="glass-card" style="padding: 28px; margin-bottom: 30px;">
        <h3 style="font-size: 18px; font-weight: 800; color: var(--text-heading); margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
            <i class="fas fa-handshake" style="color: var(--primary); margin-right: 8px;"></i>
            Contracted Suppliers & Itemized Services ({{ $booking->services->count() }})
        </h3>

        @if($booking->services->isEmpty())
            <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 20px; text-align: center; color: #64748b; font-size: 14px;">
                <i class="fas fa-user-clock fa-lg" style="margin-bottom: 8px; display: block; color: var(--primary);"></i>
                Suppliers and specialists are actively being assigned for your booking by our event managers.
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 14px;">
                @foreach($booking->services as $srv)
                    <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 14px 18px; border-radius: 12px; border: 1px solid #e2e8f0; flex-wrap: wrap; gap: 12px;">
                        <div>
                            <div style="font-weight: 800; font-size: 14px; color: var(--text-heading);">
                                {{ $srv->service->service_name ?? 'Itemized Service' }}
                            </div>
                            <div style="font-size: 13px; color: #64748b; margin-top: 3px;">
                                <i class="fas fa-store fa-xs" style="color: var(--primary);"></i>
                                <strong>{{ $srv->supplier->business_name ?? 'Assigned Specialist' }}</strong>
                                @if($srv->listing)
                                    &bull; <span style="color: #2563eb;">{{ $srv->listing->title }}</span>
                                @endif
                            </div>
                            @if($srv->custom_notes)
                                <div style="font-size: 12px; color: #94a3b8; margin-top: 2px;">
                                    <em>Note: {{ $srv->custom_notes }}</em>
                                </div>
                            @endif
                        </div>

                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="text-align: right;">
                                @if($srv->assigned_cost > 0)
                                    <div style="font-size: 14px; font-weight: 800; color: #059669;">
                                        LKR {{ number_format($srv->assigned_cost) }}
                                    </div>
                                @endif
                                <div style="font-size: 12px; color: #64748b;">
                                    <i class="fas fa-phone-alt fa-xs"></i> {{ $srv->supplier->contact_phone ?? 'Coordination active' }}
                                </div>
                            </div>

                            <!-- Rating Button for Assigned Supplier -->
                            @if($srv->supplier_id)
                                @php
                                    $existingRating = $booking->ratings->firstWhere('supplier_id', $srv->supplier_id);
                                @endphp
                                <button type="button" class="btn btn-outline" style="padding: 6px 14px; font-size: 12px; border-radius: 20px; border: 1px solid #f59e0b; color: #b45309; background: #fffbeb;"
                                        onclick="openRateModal('{{ $booking->BookingID }}', {{ $srv->supplier_id }}, '{{ addslashes($srv->supplier->business_name ?? '') }}', {{ $existingRating ? $existingRating->rating : 5 }}, '{{ addslashes($existingRating->review_title ?? '') }}', '{{ addslashes($existingRating->review_text ?? '') }}')">
                                    <i class="fas fa-star" style="color: #f59e0b;"></i>
                                    {{ $existingRating ? 'Edit Review (' . $existingRating->rating . '.0)' : 'Review Vendor' }}
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Production Extras & Notes -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="glass-card" style="padding: 22px;">
            <h4 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin-bottom: 8px;">
                <i class="fas fa-cogs" style="color: var(--primary); margin-right: 6px;"></i> Production & Equipment
            </h4>
            <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin: 0;">
                {{ $booking->extra->equipment ?? 'Standard Event Production & Lighting Setup' }}
            </p>
        </div>

        <div class="glass-card" style="padding: 22px;">
            <h4 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin-bottom: 8px;">
                <i class="fas fa-info-circle" style="color: var(--primary); margin-right: 6px;"></i> Special Instructions
            </h4>
            <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin: 0;">
                {{ $booking->ExtraDetails ?: 'No custom instructions provided upon booking creation.' }}
            </p>
        </div>
    </div>

</div>

<!-- Modal: Rate & Review Supplier -->
<div id="rateSupplierModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div class="glass-card" style="background: #ffffff; border-radius: 20px; max-width: 500px; width: 100%; box-shadow: 0 25px 50px rgba(0,0,0,0.25); overflow: hidden; padding: 26px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
            <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: var(--text-heading);">
                <i class="fas fa-star" style="color: #f59e0b; margin-right: 6px;"></i> Review Supplier
            </h3>
            <button type="button" style="background: none; border: none; font-size: 22px; cursor: pointer; color: #94a3b8;" onclick="closeRateModal()">&times;</button>
        </div>

        <form method="POST" action="{{ route('ratings.store') }}">
            @csrf
            <input type="hidden" name="booking_id" id="modalBookingId">
            <input type="hidden" name="supplier_id" id="modalSupplierId">
            <input type="hidden" name="rating" id="modalRatingValue" value="5">

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">
                    Rating Score (1-5 Stars)
                </label>
                <div id="starContainer" style="display: flex; gap: 8px; font-size: 28px; cursor: pointer; color: #f59e0b;">
                    <i class="fas fa-star" data-rating="1"></i>
                    <i class="fas fa-star" data-rating="2"></i>
                    <i class="fas fa-star" data-rating="3"></i>
                    <i class="fas fa-star" data-rating="4"></i>
                    <i class="fas fa-star" data-rating="5"></i>
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">
                    Review Title / Headline
                </label>
                <input type="text" name="review_title" id="modalReviewTitle" class="form-input" placeholder="e.g. Exceptional sound and punctual delivery">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">
                    Feedback & Comments
                </label>
                <textarea name="review_text" id="modalReviewText" class="form-input" rows="3" placeholder="Share your experience working with this supplier..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn btn-secondary" onclick="closeRateModal()" style="border-radius: 20px; font-size: 13px;">Cancel</button>
                <button type="submit" class="btn btn-primary" style="border-radius: 20px; font-size: 13px; font-weight: 700;">Submit Review</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRateModal(bookingId, supplierId, businessName, rating, title, text) {
        document.getElementById('modalBookingId').value = bookingId;
        document.getElementById('modalSupplierId').value = supplierId;
        document.getElementById('modalRatingValue').value = rating || 5;
        document.getElementById('modalReviewTitle').value = title || '';
        document.getElementById('modalReviewText').value = text || '';
        updateStars(rating || 5);
        const modal = document.getElementById('rateSupplierModal');
        modal.style.display = 'flex';
    }

    function closeRateModal() {
        document.getElementById('rateSupplierModal').style.display = 'none';
    }

    function updateStars(val) {
        document.querySelectorAll('#starContainer i').forEach(star => {
            const r = parseInt(star.getAttribute('data-rating'));
            if (r <= val) {
                star.className = 'fas fa-star';
            } else {
                star.className = 'far fa-star';
            }
        });
    }

    document.querySelectorAll('#starContainer i').forEach(star => {
        star.addEventListener('click', function() {
            const r = parseInt(this.getAttribute('data-rating'));
            document.getElementById('modalRatingValue').value = r;
            updateStars(r);
        });
    });
</script>
@endsection
