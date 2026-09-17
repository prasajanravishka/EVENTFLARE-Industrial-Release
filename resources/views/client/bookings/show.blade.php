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
                                        onclick="openRateModal('{{ $booking->BookingID }}', {{ $srv->supplier_id }}, '{{ addslashes($srv->supplier->business_name ?? '') }}', {{ $existingRating ? $existingRating->rating : 5 }}, '{{ addslashes($existingRating->review_title ?? '') }}', '{{ addslashes($existingRating->review_text ?? '') }}', {{ $existingRating->rating_quality ?? 5 }}, {{ $existingRating->rating_punctuality ?? 5 }}, {{ $existingRating->rating_communication ?? 5 }}, {{ $existingRating->rating_value ?? 5 }}, '{{ addslashes($existingRating->supplier_reply ?? '') }}')">
                                    <i class="fas fa-star" style="color: #f59e0b;"></i>
                                    {{ $existingRating ? 'Edit Review (' . $existingRating->rating . '.0)' : 'Review Vendor' }}
                                </button>
                            @endif
                        </div>

                        <!-- Existing Review & Supplier Reply Preview -->
                        @if(isset($existingRating) && $existingRating)
                            <div style="width: 100%; margin-top: 10px; padding-top: 10px; border-top: 1px dashed #e2e8f0; font-size: 12px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                    <span style="font-weight: 700; color: #1e293b;">
                                        Your Verified Review: 
                                        <span style="color: #f59e0b;"><i class="fas fa-star"></i> {{ $existingRating->rating }}.0</span>
                                        @if($existingRating->review_title)
                                            — "{{ $existingRating->review_title }}"
                                        @endif
                                    </span>
                                    <span style="font-size: 11px; color: #94a3b8;">{{ $existingRating->updated_at->format('M d, Y') }}</span>
                                </div>
                                @if($existingRating->review_text)
                                    <p style="margin: 0 0 6px; color: #64748b; font-style: italic;">"{{ $existingRating->review_text }}"</p>
                                @endif

                                <!-- Photo Thumbnails -->
                                @if(!empty($existingRating->photos) && is_array($existingRating->photos))
                                    <div style="display: flex; gap: 8px; margin-top: 6px; margin-bottom: 6px;">
                                        @foreach($existingRating->photos as $photoUrl)
                                            <a href="{{ asset($photoUrl) }}" target="_blank" style="display: block; width: 45px; height: 45px; border-radius: 6px; overflow: hidden; border: 1px solid #cbd5e1;">
                                                <img src="{{ asset($photoUrl) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="Event Photo">
                                            </a>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Official Supplier Response -->
                                @if($existingRating->supplier_reply)
                                    <div style="background: rgba(139, 92, 246, 0.08); border-left: 3px solid var(--primary); padding: 8px 12px; border-radius: 6px; margin-top: 8px;">
                                        <strong style="color: var(--primary); font-size: 12px;">
                                            <i class="fas fa-reply fa-xs"></i> Official Response from {{ $srv->supplier->business_name ?? 'Vendor' }}:
                                        </strong>
                                        <p style="margin: 3px 0 0; color: #334155; font-size: 12px;">"{{ $existingRating->supplier_reply }}"</p>
                                    </div>
                                @endif
                            </div>
                        @endif
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

<!-- Modal: Rate & Review Supplier (Multi-Criteria & Photo Upload) -->
<div id="rateSupplierModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(5px); z-index: 9999; align-items: center; justify-content: center; padding: 20px; overflow-y: auto;">
    <div class="glass-card" style="background: #ffffff; border-radius: 20px; max-width: 540px; width: 100%; box-shadow: 0 25px 50px rgba(0,0,0,0.25); overflow: hidden; padding: 26px; max-height: 90vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
            <div>
                <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: var(--text-heading);">
                    <i class="fas fa-star" style="color: #f59e0b; margin-right: 6px;"></i> Review & Endorse Specialist
                </h3>
                <span id="modalSupplierSubtitle" style="font-size: 12px; color: var(--text-muted); font-weight: 600;">Verified Event Supplier</span>
            </div>
            <button type="button" style="background: none; border: none; font-size: 22px; cursor: pointer; color: #94a3b8;" onclick="closeRateModal()">&times;</button>
        </div>

        <form method="POST" action="{{ route('ratings.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="booking_id" id="modalBookingId">
            <input type="hidden" name="supplier_id" id="modalSupplierId">
            <input type="hidden" name="rating" id="modalRatingValue" value="5">

            <!-- Overall Score -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; margin-bottom: 16px; text-align: center;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">
                    Overall Experience Rating
                </label>
                <div id="starContainer" style="display: flex; justify-content: center; gap: 10px; font-size: 32px; cursor: pointer; color: #f59e0b;">
                    <i class="fas fa-star" data-rating="1"></i>
                    <i class="fas fa-star" data-rating="2"></i>
                    <i class="fas fa-star" data-rating="3"></i>
                    <i class="fas fa-star" data-rating="4"></i>
                    <i class="fas fa-star" data-rating="5"></i>
                </div>
                <div style="font-size: 12px; font-weight: 700; color: #b45309; margin-top: 4px;" id="ratingScoreText">5.0 — Exceptional</div>
            </div>

            <!-- Multi-Criteria Ratings -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; margin-bottom: 16px;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-heading); text-transform: uppercase; margin-bottom: 10px;">
                    <i class="fas fa-sliders-h" style="color: var(--primary); margin-right: 4px;"></i> Detailed Criteria Scores
                </label>
                
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <!-- Quality -->
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13px;">
                        <span style="color: #475569; font-weight: 600;">Quality & Artistry</span>
                        <div class="criteria-stars" data-name="rating_quality" style="color: #f59e0b; cursor: pointer;">
                            <input type="hidden" name="rating_quality" id="val_quality" value="5">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star" data-val="{{ $i }}" onclick="setCriteria('rating_quality', {{ $i }})"></i>
                            @endfor
                        </div>
                    </div>

                    <!-- Punctuality -->
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13px;">
                        <span style="color: #475569; font-weight: 600;">Punctuality & Schedule</span>
                        <div class="criteria-stars" data-name="rating_punctuality" style="color: #f59e0b; cursor: pointer;">
                            <input type="hidden" name="rating_punctuality" id="val_punctuality" value="5">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star" data-val="{{ $i }}" onclick="setCriteria('rating_punctuality', {{ $i }})"></i>
                            @endfor
                        </div>
                    </div>

                    <!-- Communication -->
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13px;">
                        <span style="color: #475569; font-weight: 600;">Communication & Service</span>
                        <div class="criteria-stars" data-name="rating_communication" style="color: #f59e0b; cursor: pointer;">
                            <input type="hidden" name="rating_communication" id="val_communication" value="5">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star" data-val="{{ $i }}" onclick="setCriteria('rating_communication', {{ $i }})"></i>
                            @endfor
                        </div>
                    </div>

                    <!-- Value -->
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13px;">
                        <span style="color: #475569; font-weight: 600;">Value for Investment</span>
                        <div class="criteria-stars" data-name="rating_value" style="color: #f59e0b; cursor: pointer;">
                            <input type="hidden" name="rating_value" id="val_value" value="5">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star" data-val="{{ $i }}" onclick="setCriteria('rating_value', {{ $i }})"></i>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Title / Headline -->
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">
                    Review Headline / Summary
                </label>
                <input type="text" name="review_title" id="modalReviewTitle" class="form-input" placeholder="e.g. Exceptional sound, stunning decor, and punctual arrival">
            </div>

            <!-- Detailed Feedback Comments -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">
                    Detailed Feedback & Experience
                </label>
                <textarea name="review_text" id="modalReviewText" class="form-input" rows="3" placeholder="Share your experience with this specialist to guide future celebration hosts..."></textarea>
            </div>

            <!-- Verified Celebration Photos Upload -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--text-heading); margin-bottom: 6px;">
                    <i class="fas fa-camera" style="color: var(--primary); margin-right: 4px;"></i> Upload Celebration Photos (Optional, max 3)
                </label>
                <input type="file" name="photos[]" id="modalPhotos" class="form-input" multiple accept="image/jpeg,image/png,image/webp" onchange="previewPhotos(event)">
                <small style="display: block; font-size: 11px; color: var(--text-muted); margin-top: 4px;">
                    Attach real photos of your event setup (e.g. stage, Poruwa, food, lighting).
                </small>
                <div id="photoPreviewBox" style="display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap;"></div>
            </div>

            <!-- Supplier Reply Box (if previously replied) -->
            <div id="modalSupplierReplyBox" style="display: none; background: #f8fafc; border-left: 3px solid var(--primary); padding: 12px; border-radius: 6px; margin-bottom: 18px; font-size: 12px;">
                <strong style="color: var(--primary);"><i class="fas fa-reply"></i> Official Supplier Reply:</strong>
                <p id="modalSupplierReplyText" style="margin: 4px 0 0; color: #334155; font-style: italic;"></p>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn btn-secondary" onclick="closeRateModal()" style="border-radius: 20px; font-size: 13px;">Cancel</button>
                <button type="submit" class="btn btn-primary" style="border-radius: 20px; font-size: 13px; font-weight: 700;">Submit Verified Review</button>
            </div>
        </form>
    </div>
</div>

<script>
    const scoreDescriptions = {
        1: '1.0 — Poor Experience',
        2: '2.0 — Fair / Below Expectations',
        3: '3.0 — Satisfactory / Average',
        4: '4.0 — Very Good / High Quality',
        5: '5.0 — Exceptional / Royal Standard'
    };

    function openRateModal(bookingId, supplierId, businessName, rating, title, text, quality, punctuality, communication, value, reply) {
        document.getElementById('modalBookingId').value = bookingId;
        document.getElementById('modalSupplierId').value = supplierId;
        document.getElementById('modalSupplierSubtitle').innerText = businessName || 'Verified Specialist';
        document.getElementById('modalRatingValue').value = rating || 5;
        document.getElementById('modalReviewTitle').value = title || '';
        document.getElementById('modalReviewText').value = text || '';

        updateStars(rating || 5);
        setCriteria('rating_quality', quality || rating || 5);
        setCriteria('rating_punctuality', punctuality || rating || 5);
        setCriteria('rating_communication', communication || rating || 5);
        setCriteria('rating_value', value || rating || 5);

        // Supplier reply display if available
        const replyBox = document.getElementById('modalSupplierReplyBox');
        if (reply) {
            document.getElementById('modalSupplierReplyText').innerText = '"' + reply + '"';
            replyBox.style.display = 'block';
        } else {
            replyBox.style.display = 'none';
        }

        document.getElementById('photoPreviewBox').innerHTML = '';
        const modal = document.getElementById('rateSupplierModal');
        modal.style.display = 'flex';
    }

    function closeRateModal() {
        document.getElementById('rateSupplierModal').style.display = 'none';
    }

    function updateStars(val) {
        document.querySelectorAll('#starContainer i').forEach(star => {
            const r = parseInt(star.getAttribute('data-rating'));
            star.className = (r <= val) ? 'fas fa-star' : 'far fa-star';
        });
        const label = scoreDescriptions[val] || (val + '.0');
        document.getElementById('ratingScoreText').innerText = label;
    }

    document.querySelectorAll('#starContainer i').forEach(star => {
        star.addEventListener('click', function() {
            const r = parseInt(this.getAttribute('data-rating'));
            document.getElementById('modalRatingValue').value = r;
            updateStars(r);
        });
    });

    function setCriteria(name, val) {
        const inputId = name.replace('rating_', 'val_');
        const input = document.getElementById(inputId);
        if (input) input.value = val;

        const container = document.querySelector(`.criteria-stars[data-name="${name}"]`);
        if (container) {
            container.querySelectorAll('i').forEach(star => {
                const v = parseInt(star.getAttribute('data-val'));
                star.className = (v <= val) ? 'fas fa-star' : 'far fa-star';
            });
        }
    }

    function previewPhotos(event) {
        const box = document.getElementById('photoPreviewBox');
        box.innerHTML = '';
        const files = event.target.files;
        if (files) {
            for (let i = 0; i < Math.min(files.length, 3); i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '60px';
                    img.style.height = '60px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '8px';
                    img.style.border = '1px solid #cbd5e1';
                    box.appendChild(img);
                };
                reader.readAsDataURL(files[i]);
            }
        }
    }
</script>
@endsection
