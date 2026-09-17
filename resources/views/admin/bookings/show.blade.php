@extends('layouts.admin', ['activePage' => 'bookings', 'title' => 'Booking #' . $booking->BookingID . ' Dossier - EVENTFLARE Admin Console'])

@push('styles')
<style>
/* Multi-Stage Progression Stepper */
.stage-stepper-container {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 26px 30px;
    margin-bottom: 28px;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);
}
.stage-stepper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
}
.stage-stepper::before {
    content: '';
    position: absolute;
    top: 20px;
    left: 40px;
    right: 40px;
    height: 3px;
    background: #e2e8f0;
    z-index: 1;
}
.stage-step-item {
    position: relative;
    z-index: 2;
    text-align: center;
    flex: 1;
}
.stage-step-icon {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #f1f5f9;
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    font-size: 15px;
    font-weight: 800;
    border: 3px solid #ffffff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
}
.stage-step-item.completed .stage-step-icon {
    background: #10b981;
    color: #ffffff;
    box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
}
.stage-step-item.active .stage-step-icon {
    background: var(--primary);
    color: #ffffff;
    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.2);
    animation: stagePulse 2s infinite;
}
@keyframes stagePulse {
    0% { box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(139, 92, 246, 0); }
    100% { box-shadow: 0 0 0 0 rgba(139, 92, 246, 0); }
}
.stage-step-label {
    font-size: 13px;
    font-weight: 800;
    color: #94a3b8;
    margin-bottom: 2px;
}
.stage-step-item.active .stage-step-label {
    color: var(--primary);
}
.stage-step-item.completed .stage-step-label {
    color: #065f46;
}
.stage-step-desc {
    font-size: 11px;
    color: #64748b;
}

/* Modal Styling */
.admin-modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
    z-index: 1050;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.admin-modal-card {
    background: #ffffff;
    border-radius: 16px;
    width: 100%;
    max-width: 680px;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 20px 40px rgba(15, 23, 42, 0.2);
    border: 1px solid #e2e8f0;
    overflow: hidden;
}
.admin-modal-header {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8fafc;
}
.admin-modal-body {
    padding: 24px;
    overflow-y: auto;
}
.admin-modal-footer {
    padding: 16px 24px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    background: #f8fafc;
}

/* Print Rules */
@media print {
    body * {
        visibility: hidden !important;
    }
    #printableBookingDossier, #printableBookingDossier * {
        visibility: visible !important;
    }
    #printableBookingDossier {
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
        padding: 20px !important;
    }
    .no-print {
        display: none !important;
    }
}
</style>
@endpush

@section('content')
<div id="printableBookingDossier">
    <!-- Top Executive Header & Action Bar -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <a href="{{ route('admin.bookings.index') }}" class="no-print" style="color: var(--primary); font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 8px; text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Back to Reservations Ledger
            </a>
            <div style="display: flex; align-items: center; gap: 12px;">
                <h1 style="font-size: 26px; font-weight: 900; color: var(--text-heading); margin: 0;">
                    Reservation #{{ $booking->BookingID }}
                </h1>
                <span style="font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 12px; text-transform: uppercase; letter-spacing: 0.5px;
                    @if($booking->status === 'completed') background: #dcfce7; color: #15803d;
                    @elseif($booking->status === 'in progress' || $booking->status === 'in_progress') background: #f3e8ff; color: #7e22ce;
                    @elseif($booking->status === 'confirmed') background: #eff6ff; color: #1d4ed8;
                    @elseif($booking->status === 'cancelled') background: #fee2e2; color: #b91c1c;
                    @else background: #fef3c7; color: #b45309; @endif">
                    {{ str_replace('_', ' ', $booking->status) }}
                </span>
            </div>
            <p style="font-size: 13px; color: var(--text-muted); margin: 4px 0 0;">
                Client: <strong>{{ $booking->user->fullname ?? $booking->user_name }}</strong>
                @if($booking->user && $booking->user->email) &bull; {{ $booking->user->email }} @endif
            </p>
        </div>

        <div class="no-print" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <!-- Instant Status Updater Form -->
            <form method="POST" action="{{ route('admin.bookings.status', $booking->BookingID) }}" style="display: flex; align-items: center; gap: 8px;">
                @csrf
                @method('PATCH')
                <select name="status" onchange="this.form.submit()" class="form-input" style="padding: 9px 14px; font-weight: 700; font-size: 13px; border-radius: 10px; cursor: pointer;">
                    <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Stage 1: Pending</option>
                    <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Stage 2: Confirmed</option>
                    <option value="in_progress" {{ in_array($booking->status, ['in progress', 'in_progress']) ? 'selected' : '' }}>Stage 3: In Progress</option>
                    <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Stage 4: Completed (Final)</option>
                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </form>

            <a href="{{ route('client.bookings.pdf', $booking->BookingID) }}" target="_blank" class="btn btn-secondary" style="border-radius: 10px; padding: 9px 16px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-file-pdf" style="color: #ef4444;"></i> PDF Voucher
            </a>

            <button onclick="window.print()" type="button" class="btn" style="background: #ffffff; border: 1px solid #e2e8f0; color: #1e293b; padding: 9px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-print" style="color: var(--primary);"></i> Print Slip
            </button>

            @if(in_array($booking->status, ['completed', 'confirmed', 'in progress', 'in_progress']))
                @if($booking->caseStudy)
                    <a href="{{ route('admin.portfolio.index') }}" class="btn" style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 9px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;" title="Portfolio showcase published for this event">
                        <i class="fas fa-check-circle" style="color: #16a34a;"></i> In Portfolio
                    </a>
                @else
                    <a href="{{ route('admin.portfolio.index', ['autofill_booking' => $booking->BookingID]) }}" class="btn btn-primary" style="padding: 9px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;" title="Convert verified booking details into a public portfolio case study">
                        <i class="fas fa-camera-retro"></i> Showcase to Portfolio
                    </a>
                @endif
            @endif
        </div>
    </div>

    <!-- Multi-Stage Lifecycle Progression Stepper -->
    @php
        $st = $booking->status ?: 'pending';
        $isCancelled = ($st === 'cancelled');

        // Logic for 4 stages: Submitted -> Confirmed -> In Progress -> Completed
        $step1Done = true; // Always done once reservation exists

        $step2Done = in_array($st, ['confirmed', 'in progress', 'in_progress', 'completed']);
        $step2Active = ($st === 'pending');

        $step3Done = in_array($st, ['in progress', 'in_progress', 'completed']);
        $step3Active = ($st === 'confirmed');

        $step4Done = ($st === 'completed');
        $step4Active = in_array($st, ['in progress', 'in_progress']);
    @endphp

    <div class="stage-stepper-container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
            <div style="font-size: 12px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.8px;">
                <i class="fas fa-stream" style="color: var(--primary); margin-right: 6px;"></i> Event Reservation Lifecycle (All Stages)
            </div>
            <div style="font-size: 12px; font-weight: 700;">
                @if($st === 'completed')
                    <span style="color: #10b981;"><i class="fas fa-check-double"></i> Final Stage Completed</span>
                @elseif($isCancelled)
                    <span style="color: #ef4444;"><i class="fas fa-ban"></i> Stage Aborted (Cancelled)</span>
                @else
                    <span style="color: var(--primary);"><i class="fas fa-spinner fa-spin"></i> Active Operational Pipeline</span>
                @endif
            </div>
        </div>

        @if($isCancelled)
            <div style="background: #fef2f2; border: 1px solid #fee2e2; border-radius: 12px; padding: 16px; color: #b91c1c; font-weight: 700; text-align: center; margin-bottom: 10px;">
                <i class="fas fa-times-circle" style="margin-right: 6px;"></i> This reservation has been CANCELLED. You can reinstate it anytime using the status dropdown above.
            </div>
        @else
            <div class="stage-stepper">
                <!-- Stage 1: Submitted -->
                <div class="stage-step-item completed">
                    <div class="stage-step-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="stage-step-label">Stage 1: Submitted</div>
                    <div class="stage-step-desc">Client Request Received</div>
                </div>

                <!-- Stage 2: Confirmed -->
                <div class="stage-step-item {{ $step2Done ? 'completed' : ($step2Active ? 'active' : '') }}">
                    <div class="stage-step-icon">
                        <i class="fas {{ $step2Done ? 'fa-check' : 'fa-clipboard-check' }}"></i>
                    </div>
                    <div class="stage-step-label">Stage 2: Confirmed</div>
                    <div class="stage-step-desc">Dates & Venue Locked</div>
                </div>

                <!-- Stage 3: In Progress -->
                <div class="stage-step-item {{ $step3Done ? 'completed' : ($step3Active ? 'active' : '') }}">
                    <div class="stage-step-icon">
                        <i class="fas {{ $step3Done ? 'fa-check' : 'fa-tools' }}"></i>
                    </div>
                    <div class="stage-step-label">Stage 3: In Progress</div>
                    <div class="stage-step-desc">Vendors Assigned & Active</div>
                </div>

                <!-- Stage 4: Completed (Final Stage) -->
                <div class="stage-step-item {{ $step4Done ? 'completed' : ($step4Active ? 'active' : '') }}">
                    <div class="stage-step-icon">
                        <i class="fas {{ $step4Done ? 'fa-check' : 'fa-flag-checkered' }}"></i>
                    </div>
                    <div class="stage-step-label">Stage 4: Completed</div>
                    <div class="stage-step-desc">Final Stage Executed</div>
                </div>
            </div>

            <!-- Fast-Action Stage Advancement Buttons -->
            <div class="no-print" style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                @if($st === 'pending')
                    <form method="POST" action="{{ route('admin.bookings.status', $booking->BookingID) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="btn btn-primary" style="padding: 8px 18px; border-radius: 10px; font-weight: 700; font-size: 13px;">
                            <i class="fas fa-arrow-right"></i> Advance to Stage 2: Confirm Booking
                        </button>
                    </form>
                @elseif($st === 'confirmed')
                    <form method="POST" action="{{ route('admin.bookings.status', $booking->BookingID) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="in_progress">
                        <button type="submit" class="btn btn-primary" style="padding: 8px 18px; border-radius: 10px; font-weight: 700; font-size: 13px;">
                            <i class="fas fa-arrow-right"></i> Advance to Stage 3: Begin In Progress
                        </button>
                    </form>
                @elseif(in_array($st, ['in progress', 'in_progress']))
                    <form method="POST" action="{{ route('admin.bookings.status', $booking->BookingID) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="btn" style="background: #10b981; color: #ffffff; padding: 8px 20px; border-radius: 10px; font-weight: 700; font-size: 13px; border: none; cursor: pointer;">
                            <i class="fas fa-flag-checkered"></i> Mark Final Stage: Completed
                        </button>
                    </form>
                @endif
            </div>
        @endif
    </div>

    <!-- Event Key Metrics Summary Grid -->
    <div class="stat-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 28px;">
        <div class="glass-card" style="padding: 20px;">
            <small style="font-size: 11px; text-transform: uppercase; font-weight: 800; color: var(--text-muted); display: block; margin-bottom: 6px;">EVENT CATEGORY</small>
            <div style="font-weight: 800; font-size: 17px; color: var(--text-heading);">{{ $booking->EventType }}</div>
            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">{{ $booking->DayNight }} Session</div>
        </div>

        <div class="glass-card" style="padding: 20px;">
            <small style="font-size: 11px; text-transform: uppercase; font-weight: 800; color: var(--text-muted); display: block; margin-bottom: 6px;">RESERVED DATE</small>
            <div style="font-weight: 800; font-size: 17px; color: var(--primary);">
                {{ \Carbon\Carbon::parse($booking->EventDate)->format('M d, Y') }}
            </div>
            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                @php
                    $days = round(\Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($booking->EventDate)->startOfDay(), false));
                @endphp
                @if($days > 0)
                    In {{ $days }} Days
                @elseif($days === 0)
                    Happening Today
                @else
                    {{ abs($days) }} Days Ago (Concluded)
                @endif
            </div>
        </div>

        <div class="glass-card" style="padding: 20px;">
            <small style="font-size: 11px; text-transform: uppercase; font-weight: 800; color: var(--text-muted); display: block; margin-bottom: 6px;">DESTINATION VENUE</small>
            <div style="font-weight: 800; font-size: 17px; color: var(--text-heading); display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-map-marker-alt" style="color: #ef4444; font-size: 14px;"></i> {{ $booking->Place }}
            </div>
            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">Sri Lanka Venue</div>
        </div>

        <div class="glass-card" style="padding: 20px;">
            <small style="font-size: 11px; text-transform: uppercase; font-weight: 800; color: var(--text-muted); display: block; margin-bottom: 6px;">HEADCOUNT & CATERING</small>
            <div style="font-weight: 800; font-size: 17px; color: var(--text-heading);">
                {{ $booking->NumberOfGuests }} Guests
            </div>
            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                {{ $booking->FoodPreferences ?: 'Standard Menu' }}
            </div>
        </div>
    </div>

    <!-- Two-Column Operational Details -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start; margin-bottom: 28px;">
        <!-- Left: Contracted Suppliers & Line Items -->
        <div class="glass-card" style="padding: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
                <h3 style="font-size: 17px; font-weight: 800; color: var(--text-heading); margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-handshake" style="color: var(--primary);"></i> Contracted Suppliers & Service Items ({{ $booking->services->count() }})
                </h3>
                <button type="button" class="btn btn-primary no-print" onclick="openAssignModal()" style="padding: 6px 14px; font-size: 12px; font-weight: 700; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fas fa-plus"></i> Assign Supplier
                </button>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
                    <thead>
                        <tr style="color: var(--text-muted); font-size: 11px; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 10px 12px;">Service Capability</th>
                            <th style="padding: 10px 12px;">Contracted Vendor</th>
                            <th style="padding: 10px 12px;">Package & Notes</th>
                            <th style="padding: 10px 12px;">Allocated Cost</th>
                            <th style="padding: 10px 12px; text-align: right;" class="no-print">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking->services as $bs)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 12px;">
                                    <strong style="color: var(--text-heading);">{{ $bs->service->service_name ?? 'General Service' }}</strong>
                                </td>
                                <td style="padding: 12px;">
                                    @if($bs->supplier)
                                        <div style="font-weight: 700; color: var(--primary);">{{ $bs->supplier->business_name }}</div>
                                        <small style="color: #64748b;">{{ $bs->supplier->contact_phone }}</small>
                                    @else
                                        <span style="color: #94a3b8; font-style: italic;">Unassigned</span>
                                    @endif
                                </td>
                                <td style="padding: 12px;">
                                    @if($bs->listing)
                                        <div style="font-weight: 600; color: #334155;">{{ $bs->listing->title }}</div>
                                    @endif
                                    @if($bs->custom_notes)
                                        <small style="color: #64748b; display: block;">{{ $bs->custom_notes }}</small>
                                    @endif
                                </td>
                                <td style="padding: 12px; font-weight: 800; color: #059669;">
                                    @if($bs->assigned_cost > 0)
                                        LKR {{ number_format($bs->assigned_cost) }}
                                    @elseif($bs->listing && $bs->listing->price > 0)
                                        LKR {{ number_format($bs->listing->price) }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td style="padding: 12px; text-align: right;" class="no-print">
                                    <form method="POST" action="{{ route('admin.bookings.assignments.destroy', $bs->id) }}" onsubmit="return confirm('Remove this supplier assignment?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline" style="border: 1px solid #fee2e2; color: #ef4444; padding: 4px 8px; font-size: 11px; border-radius: 8px;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                    <i class="fas fa-clipboard-list" style="font-size: 24px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                                    No suppliers assigned to this reservation yet. Click "+ Assign Supplier" above to attach accredited vendors.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Client Identity & Celebration Notes -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <!-- Client Identity Card -->
            <div class="glass-card" style="padding: 22px;">
                <h3 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin: 0 0 14px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-user-circle" style="color: var(--primary);"></i> Client Information
                </h3>
                <div style="font-size: 13px; line-height: 1.8;">
                    <div><span style="color: var(--text-muted);">Full Name:</span> <strong>{{ $booking->user->fullname ?? $booking->user_name }}</strong></div>
                    <div><span style="color: var(--text-muted);">Username:</span> <strong style="color: var(--primary);">@<span>{{ $booking->user_name }}</span></strong></div>
                    <div><span style="color: var(--text-muted);">Email:</span> {{ $booking->user->email ?? 'Not available' }}</div>
                    <div><span style="color: var(--text-muted);">Client Ref:</span> <span style="font-family: monospace;">#USR-{{ str_pad($booking->user_id ?? 0, 4, '0', STR_PAD_LEFT) }}</span></div>
                </div>
            </div>

            <!-- Couple Names & Custom Details -->
            <div class="glass-card" style="padding: 22px;">
                <h3 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin: 0 0 14px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-sticky-note" style="color: var(--primary);"></i> Celebration Notes & Requests
                </h3>
                <div style="font-size: 13px; color: #475569; line-height: 1.6;">
                    {{ $booking->ExtraDetails ?: 'No custom notes or special requests provided for this event.' }}
                </div>
            </div>

            <!-- Customer Rating Card (If Reviewed) -->
            @if($booking->ratings && $booking->ratings->count() > 0)
                <div class="glass-card" style="padding: 22px;">
                    <h3 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin: 0 0 14px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">
                        <i class="fas fa-star" style="color: #f59e0b;"></i> Customer Endorsement
                    </h3>
                    @foreach($booking->ratings as $r)
                        <div style="margin-bottom: 10px;">
                            <div style="color: #f59e0b; font-size: 13px; font-weight: 800;">
                                <i class="fas fa-star"></i> {{ $r->rating }}.0
                                @if($r->review_title) &bull; {{ $r->review_title }} @endif
                            </div>
                            <p style="font-size: 12px; color: #64748b; margin: 4px 0 0;">{{ $r->review_text }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal: Assign Supplier to Service Line Item -->
<div class="admin-modal-backdrop" id="assignSupplierModal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <h3 style="margin: 0; font-size: 17px; font-weight: 800; color: var(--text-heading);">
                <i class="fas fa-user-plus" style="color: var(--primary); margin-right: 6px;"></i> Assign Supplier to Booking #{{ $booking->BookingID }}
            </h3>
            <button type="button" onclick="closeAssignModal()" style="background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer;">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.bookings.assign', $booking->BookingID) }}">
            @csrf
            <div class="admin-modal-body">
                <div style="margin-bottom: 14px;">
                    <label class="form-label" style="font-size: 12px; font-weight: 700;">Service Line Item <span style="color:#ef4444;">*</span></label>
                    <select name="service_id" class="form-input" required>
                        <option value="">Select Service Catalog Item...</option>
                        @foreach($catalogServices as $cs)
                            <option value="{{ $cs->service_id }}">{{ $cs->service_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 14px;">
                    <label class="form-label" style="font-size: 12px; font-weight: 700;">Accredited Vendor <span style="color:#ef4444;">*</span></label>
                    <select name="supplier_id" class="form-input" required>
                        <option value="">Select Supplier...</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}">{{ $sup->business_name }} ({{ $sup->category }}) &bull; {{ $sup->location }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 14px;">
                    <label class="form-label" style="font-size: 12px; font-weight: 700;">Assigned Budget Cost (LKR)</label>
                    <input type="number" name="assigned_cost" class="form-input" min="0" placeholder="e.g. 75000">
                </div>

                <div style="margin-bottom: 14px;">
                    <label class="form-label" style="font-size: 12px; font-weight: 700;">Operational Instructions / Custom Notes</label>
                    <textarea name="custom_notes" class="form-input" rows="3" placeholder="Specific guidelines for this vendor (timing, stage position, equipment)..."></textarea>
                </div>
            </div>

            <div class="admin-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeAssignModal()" style="padding: 9px 18px; border-radius: 10px; font-weight: 700; font-size: 13px;">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" style="padding: 9px 22px; border-radius: 10px; font-weight: 700; font-size: 13px;">
                    <i class="fas fa-check"></i> Assign & Notify Vendor
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openAssignModal() {
    document.getElementById('assignSupplierModal').style.display = 'flex';
}
function closeAssignModal() {
    document.getElementById('assignSupplierModal').style.display = 'none';
}
document.getElementById('assignSupplierModal').addEventListener('click', (e) => {
    if (e.target.id === 'assignSupplierModal') closeAssignModal();
});
</script>
@endpush
