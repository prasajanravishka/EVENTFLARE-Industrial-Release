@extends('layouts.admin', ['activePage' => 'users', 'title' => 'Client Accounts - EVENTFLARE Admin Console'])

@push('styles')
<style>
/* Directory Segment Switcher */
.directory-segment-bar {
    display: inline-flex;
    background: #f1f5f9;
    padding: 5px;
    border-radius: 14px;
    gap: 6px;
    margin-bottom: 24px;
    border: 1px solid #e2e8f0;
}
.segment-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 18px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    text-decoration: none;
    transition: all 0.2s ease;
}
.segment-pill:hover {
    color: var(--primary);
    background: rgba(255, 255, 255, 0.6);
}
.segment-pill.active {
    background: #ffffff;
    color: var(--primary);
    box-shadow: 0 2px 8px rgba(139, 92, 246, 0.15);
}
.segment-badge {
    font-size: 11px;
    font-weight: 800;
    padding: 2px 8px;
    border-radius: 12px;
    background: rgba(139, 92, 246, 0.1);
    color: var(--primary);
}
.segment-pill.active .segment-badge {
    background: var(--primary);
    color: #ffffff;
}

/* User Avatar Initial */
.user-avatar-initial {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(59, 130, 246, 0.15));
    color: var(--primary);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 14px;
    border: 1px solid rgba(139, 92, 246, 0.2);
}

/* Modal Overlay & Card */
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
    max-width: 760px;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 20px 40px rgba(15, 23, 42, 0.2);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    animation: modalPop 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes modalPop {
    from { transform: scale(0.95) translateY(10px); opacity: 0; }
    to { transform: scale(1) translateY(0); opacity: 1; }
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

/* Print Specific Styles */
@media print {
    body * {
        visibility: hidden !important;
    }
    #printDossierArea, #printDossierArea * {
        visibility: visible !important;
    }
    #printDossierArea {
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
        padding: 20px !important;
        background: #ffffff !important;
        color: #000000 !important;
    }
    .no-print {
        display: none !important;
    }
}
</style>
@endpush

@section('content')
<div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
    <div class="dashboard-title">
        <h1>Client Accounts Ledger</h1>
        <p>Manage verified customer profiles, contact credentials, reservation histories, and account dossiers.</p>
    </div>

    <!-- Export & Reporting Action Toolbar -->
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <button type="button" id="btnExportPdf" class="btn" style="background: #ffffff; border: 1px solid #e2e8f0; color: #1e293b; padding: 9px 16px; border-radius: 12px; font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <i class="fas fa-file-pdf" style="color: #ef4444;"></i> Export Landscape PDF
        </button>
        <button type="button" id="btnExportCsv" class="btn" style="background: #ffffff; border: 1px solid #e2e8f0; color: #1e293b; padding: 9px 16px; border-radius: 12px; font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <i class="fas fa-file-csv" style="color: #10b981;"></i> Export Tabular CSV
        </button>
    </div>
</div>

<!-- Directory Segment Switcher -->
<div class="directory-segment-bar">
    <a href="{{ route('admin.users.index') }}" class="segment-pill active">
        <i class="fas fa-users"></i> Customers / Buyers
        <span class="segment-badge">{{ $totalClients }}</span>
    </a>
    <a href="{{ route('admin.suppliers.index') }}" class="segment-pill">
        <i class="fas fa-store"></i> Suppliers & Vendors
        <span class="segment-badge">{{ $totalSuppliersCount }}</span>
    </a>
</div>

<!-- KPI Metric Cards Grid -->
<div class="stat-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 24px;">
    <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(59, 130, 246, 0.12); color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-user-friends"></i>
        </div>
        <div>
            <h3 style="font-size: 24px; font-weight: 900; margin: 0; color: var(--text-heading);">{{ number_format($totalClients) }}</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0;">Registered Clients</p>
        </div>
    </div>

    <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(16, 185, 129, 0.12); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div>
            <h3 style="font-size: 24px; font-weight: 900; margin: 0; color: var(--text-heading);">{{ number_format($activeClients) }}</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0;">Active Buyers (&ge; 1 Booking)</p>
        </div>
    </div>

    <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(245, 158, 11, 0.12); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-user-clock"></i>
        </div>
        <div>
            <h3 style="font-size: 24px; font-weight: 900; margin: 0; color: var(--text-heading);">{{ number_format($dormantClients) }}</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0;">Dormant Accounts (0 Bookings)</p>
        </div>
    </div>

    <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(139, 92, 246, 0.12); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-layer-group"></i>
        </div>
        <div>
            <h3 style="font-size: 24px; font-weight: 900; margin: 0; color: var(--text-heading);">{{ number_format($totalBookings) }}</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0;">Platform Event Bookings</p>
        </div>
    </div>
</div>

<!-- Search, Filter & Sort Controls -->
<div class="glass-card" style="padding: 18px 22px; margin-bottom: 24px;">
    <form method="GET" action="{{ route('admin.users.index') }}" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
        <div style="flex: 1; min-width: 240px;">
            <input type="text" name="search" class="form-input" placeholder="Search by username, full name, or email..." value="{{ $search }}">
        </div>

        <div style="min-width: 170px;">
            <select name="activity" class="form-input" style="padding: 10px 14px;">
                <option value="all" {{ $activity === 'all' ? 'selected' : '' }}>All Activity Statuses</option>
                <option value="active" {{ $activity === 'active' ? 'selected' : '' }}>Active (Has Bookings)</option>
                <option value="inactive" {{ $activity === 'inactive' ? 'selected' : '' }}>Inactive / Dormant (0)</option>
            </select>
        </div>

        <div style="min-width: 170px;">
            <select name="sort" class="form-input" style="padding: 10px 14px;">
                <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Newest Registered</option>
                <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest Registered</option>
                <option value="most_bookings" {{ $sort === 'most_bookings' ? 'selected' : '' }}>Most Bookings First</option>
                <option value="least_bookings" {{ $sort === 'least_bookings' ? 'selected' : '' }}>Least Bookings First</option>
                <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Client Name (A-Z)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" style="padding: 10px 20px; border-radius: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fas fa-filter"></i> Apply Filters
        </button>

        @if($search || $activity !== 'all' || $sort !== 'latest')
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" style="padding: 10px 16px; border-radius: 12px;">Clear</a>
        @endif
    </form>
</div>

<!-- Users Table -->
<div class="glass-card" style="padding: 24px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;" id="clientsTable">
        <thead>
            <tr style="color: var(--text-muted); font-size: 11px; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 14px;">User / Handle</th>
                <th style="padding: 12px 14px;">Full Name</th>
                <th style="padding: 12px 14px;">Email Address</th>
                <th style="padding: 12px 14px;">Reservations</th>
                <th style="padding: 12px 14px;">Registration Date</th>
                <th style="padding: 12px 14px; text-align: right;">Dossier & Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $u)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 14px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="user-avatar-initial">
                                {{ strtoupper(substr($u->username, 0, 1)) }}
                            </div>
                            <div>
                                <strong style="color: var(--primary); font-size: 13px;">@<span>{{ $u->username }}</span></strong>
                                <div style="font-size: 11px; color: var(--text-muted); font-family: monospace;">#USR-{{ str_pad($u->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 14px; font-weight: 700; color: var(--text-heading);">
                        {{ $u->fullname ?: '—' }}
                    </td>
                    <td style="padding: 14px; color: #64748b;">
                        {{ $u->email }}
                    </td>
                    <td style="padding: 14px;">
                        @if($u->bookings_count > 0)
                            <span style="font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 12px; background: #dcfce7; color: #15803d; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fas fa-check-circle fa-xs"></i> {{ $u->bookings_count }} Bookings
                            </span>
                        @else
                            <span style="font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 12px; background: #f1f5f9; color: #94a3b8;">
                                No Bookings
                            </span>
                        @endif
                    </td>
                    <td style="padding: 14px; color: #64748b;">
                        {{ $u->created_at ? $u->created_at->format('M d, Y') : '—' }}
                    </td>
                    <td style="padding: 14px; text-align: right;">
                        <div style="display: inline-flex; gap: 8px; align-items: center;">
                            <button type="button"
                                    class="btn btn-outline"
                                    style="border: 1px solid #e2e8f0; color: var(--primary); background: rgba(139, 92, 246, 0.05); padding: 5px 12px; font-size: 12px; font-weight: 700; border-radius: 10px; cursor: pointer;"
                                    onclick="openClientDossier({{ json_encode([
                                        'id' => $u->id,
                                        'ref' => 'USR-' . str_pad($u->id, 4, '0', STR_PAD_LEFT),
                                        'username' => $u->username,
                                        'fullname' => $u->fullname ?: 'Not Specified',
                                        'email' => $u->email,
                                        'created_at' => $u->created_at ? $u->created_at->format('M d, Y') : '—',
                                        'bookings_count' => $u->bookings_count,
                                        'bookings' => $u->bookings->map(function($b) {
                                            return [
                                                'booking_id' => $b->BookingID,
                                                'event_type' => $b->EventType,
                                                'place' => $b->Place,
                                                'event_date' => $b->EventDate ? \Carbon\Carbon::parse($b->EventDate)->format('M d, Y') : '—',
                                                'guests' => $b->NumberOfGuests,
                                                'status' => $b->status,
                                            ];
                                        })
                                    ]) }})">
                                <i class="fas fa-folder-open"></i> Dossier
                            </button>

                            <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Permanently delete account @{{ $u->username }}? All associated records will be removed.');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline" style="border: 1px solid #fee2e2; color: #ef4444; background: #fff5f5; padding: 5px 10px; font-size: 12px; border-radius: 10px; cursor: pointer;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">No client accounts matched your criteria.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $users->links() }}
    </div>
</div>

<!-- Hidden PDF Export Container (A4 Landscape Layout) -->
<div id="pdfExportContainer" style="display: none; background: #ffffff; padding: 30px; font-family: sans-serif; color: #0f172a;">
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #8b5cf6; padding-bottom: 16px; margin-bottom: 24px;">
        <div>
            <h1 style="margin: 0; font-size: 24px; color: #8b5cf6; font-weight: 800; letter-spacing: 0.5px;">EVENTFLARE</h1>
            <p style="margin: 4px 0 0; font-size: 12px; color: #64748b; font-weight: 600;">Official Customer Directory & Client Ledger</p>
        </div>
        <div style="text-align: right; font-size: 11px; color: #64748b;">
            <div><strong>Document Ref:</strong> DIR-CUST-{{ date('Ymd') }}</div>
            <div><strong>Export Date:</strong> {{ now()->format('M d, Y h:i A') }}</div>
            <div><strong>Total Records in Scope:</strong> {{ $users->total() }}</div>
        </div>
    </div>

    <table style="width: 100%; border-collapse: collapse; font-size: 11px; text-align: left;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 1.5px solid #cbd5e1; color: #334155; text-transform: uppercase;">
                <th style="padding: 8px 10px;">ID Ref</th>
                <th style="padding: 8px 10px;">Username</th>
                <th style="padding: 8px 10px;">Full Name</th>
                <th style="padding: 8px 10px;">Email Address</th>
                <th style="padding: 8px 10px; text-align: center;">Bookings</th>
                <th style="padding: 8px 10px;">Registered</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 8px 10px; font-family: monospace; font-weight: 700;">#USR-{{ str_pad($u->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td style="padding: 8px 10px; font-weight: 600;">{{ $u->username }}</td>
                    <td style="padding: 8px 10px;">{{ $u->fullname ?: '—' }}</td>
                    <td style="padding: 8px 10px; color: #475569;">{{ $u->email }}</td>
                    <td style="padding: 8px 10px; text-align: center; font-weight: 700;">{{ $u->bookings_count }}</td>
                    <td style="padding: 8px 10px; color: #64748b;">{{ $u->created_at ? $u->created_at->format('M d, Y') : '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 24px; padding-top: 12px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; font-size: 10px; color: #94a3b8;">
        <span>EVENTFLARE Industrial Platform • Confidential Administrative Export</span>
        <span>A4 Landscape Directory View</span>
    </div>
</div>

<!-- Interactive Client Dossier Modal -->
<div class="admin-modal-backdrop" id="clientDossierModal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(139, 92, 246, 0.12); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fas fa-id-card"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 17px; font-weight: 800; color: var(--text-heading);" id="dossierModalTitle">Client Account Dossier</h3>
                    <span style="font-size: 11px; font-family: monospace; color: var(--primary); font-weight: 800;" id="dossierModalRef">#USR-0000</span>
                </div>
            </div>
            <button type="button" onclick="closeClientDossier()" style="background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer;" aria-label="Close">&times;</button>
        </div>

        <div class="admin-modal-body" id="printDossierArea">
            <!-- Printable Header for Dossier -->
            <div class="print-only-header" style="display: none; border-bottom: 2px solid #8b5cf6; padding-bottom: 12px; margin-bottom: 20px;">
                <h2 style="margin: 0; font-size: 20px; color: #8b5cf6; font-weight: 800;">EVENTFLARE — Official Client Account Dossier</h2>
                <div style="display: flex; justify-content: space-between; font-size: 11px; color: #64748b; margin-top: 6px;">
                    <span id="printDossierRefTag">Dossier Reference: #USR-0000</span>
                    <span id="printDossierTimestamp">Generated: {{ now()->format('M d, Y h:i A') }}</span>
                </div>
            </div>

            <!-- Client Metadata Profile Card -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px; margin-bottom: 20px;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px;">
                    <div>
                        <small style="display: block; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Full Legal Name</small>
                        <strong style="font-size: 14px; color: var(--text-heading);" id="dossierFullname">—</strong>
                    </div>
                    <div>
                        <small style="display: block; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Username Handle</small>
                        <strong style="font-size: 14px; color: var(--primary);" id="dossierUsername">@—</strong>
                    </div>
                    <div>
                        <small style="display: block; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Email Address</small>
                        <span style="font-size: 13px; color: #334155; font-weight: 600;" id="dossierEmail">—</span>
                    </div>
                    <div>
                        <small style="display: block; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Registration Date</small>
                        <span style="font-size: 13px; color: #64748b;" id="dossierRegistered">—</span>
                    </div>
                </div>
            </div>

            <!-- Reservations History Table -->
            <h4 style="font-size: 14px; font-weight: 800; color: var(--text-heading); margin: 0 0 12px; display: flex; align-items: center; justify-content: space-between;">
                <span><i class="fas fa-calendar-alt" style="color: var(--primary); margin-right: 6px;"></i> Reservation History Ledger</span>
                <span id="dossierBookingsCountBadge" style="font-size: 11px; font-weight: 800; background: rgba(139, 92, 246, 0.1); color: var(--primary); padding: 2px 8px; border-radius: 10px;">0 Bookings</span>
            </h4>

            <div style="overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 10px;">
                <table style="width: 100%; border-collapse: collapse; font-size: 12px; text-align: left;">
                    <thead>
                        <tr style="background: #f8fafc; color: #64748b; font-size: 11px; text-transform: uppercase; border-bottom: 1px solid #e2e8f0;">
                            <th style="padding: 10px 12px;">Booking ID</th>
                            <th style="padding: 10px 12px;">Event Category</th>
                            <th style="padding: 10px 12px;">Date</th>
                            <th style="padding: 10px 12px;">Venue / Place</th>
                            <th style="padding: 10px 12px; text-align: center;">Guests</th>
                            <th style="padding: 10px 12px;">Status</th>
                        </tr>
                    </thead>
                    <tbody id="dossierBookingsTableBody">
                        <!-- Populated via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="admin-modal-footer">
            <button type="button" class="btn" onclick="printClientDossier()" style="background: #ffffff; border: 1px solid #e2e8f0; color: #1e293b; padding: 8px 16px; border-radius: 10px; font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-print" style="color: var(--primary);"></i> Print Client Record
            </button>
            <button type="button" class="btn btn-secondary" onclick="closeClientDossier()" style="padding: 8px 18px; border-radius: 10px; font-weight: 700; font-size: 13px;">
                Close
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- html2pdf.js CDN for Landscape PDF Directory Generation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Landscape PDF Directory Export
    const btnExportPdf = document.getElementById('btnExportPdf');
    if (btnExportPdf) {
        btnExportPdf.addEventListener('click', () => {
            const element = document.getElementById('pdfExportContainer');
            if (!element) return;

            element.style.display = 'block';

            const opt = {
                margin:       10,
                filename:     'customer_directory.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
            };

            html2pdf().set(opt).from(element).save().then(() => {
                element.style.display = 'none';
            }).catch(err => {
                console.error('PDF generation error:', err);
                element.style.display = 'none';
                alert('Could not export PDF. Please try again.');
            });
        });
    }

    // 2. Tabular CSV Data Export
    const btnExportCsv = document.getElementById('btnExportCsv');
    if (btnExportCsv) {
        btnExportCsv.addEventListener('click', () => {
            const rows = [];
            rows.push(['User ID', 'Username', 'Full Name', 'Email Address', 'Bookings Made', 'Registration Date', 'Account Role']);

            @foreach($users as $u)
                rows.push([
                    "{{ 'USR-' . str_pad($u->id, 4, '0', STR_PAD_LEFT) }}",
                    "{{ addslashes($u->username) }}",
                    "{{ addslashes($u->fullname ?: '—') }}",
                    "{{ addslashes($u->email) }}",
                    "{{ $u->bookings_count }}",
                    "{{ $u->created_at ? $u->created_at->format('Y-m-d') : '' }}",
                    "Client"
                ]);
            @endforeach

            const csvContent = "data:text/csv;charset=utf-8," 
                + rows.map(r => r.map(field => `"${String(field).replace(/"/g, '""')}"`).join(",")).join("\n");

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "customers_list.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    }
});

// 3. Client Dossier Modal & Print Spooler
let currentClientData = null;

function openClientDossier(client) {
    currentClientData = client;

    document.getElementById('dossierModalTitle').textContent = `${client.fullname} (@${client.username})`;
    document.getElementById('dossierModalRef').textContent = `#${client.ref}`;
    document.getElementById('dossierFullname').textContent = client.fullname;
    document.getElementById('dossierUsername').textContent = `@${client.username}`;
    document.getElementById('dossierEmail').textContent = client.email;
    document.getElementById('dossierRegistered').textContent = client.created_at;
    document.getElementById('dossierBookingsCountBadge').textContent = `${client.bookings_count} Bookings`;

    // Print headers
    const refTag = document.getElementById('printDossierRefTag');
    if (refTag) refTag.textContent = `Dossier Reference: #${client.ref}`;

    const tbody = document.getElementById('dossierBookingsTableBody');
    tbody.innerHTML = '';

    if (!client.bookings || client.bookings.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" style="text-align: center; color: #94a3b8; padding: 24px;">
                    <i class="fas fa-calendar-times" style="font-size: 20px; display: block; margin-bottom: 6px;"></i>
                    This client has not placed any reservations yet.
                </td>
            </tr>
        `;
    } else {
        client.bookings.forEach(b => {
            const tr = document.createElement('tr');
            tr.style.borderBottom = '1px solid #f1f5f9';

            let statusBg = '#dcfce7';
            let statusColor = '#15803d';
            if (b.status === 'pending') { statusBg = '#fef3c7'; statusColor = '#b45309'; }
            else if (b.status === 'confirmed') { statusBg = '#eff6ff'; statusColor = '#1d4ed8'; }
            else if (b.status === 'in_progress' || b.status === 'in progress') { statusBg = '#f3e8ff'; statusColor = '#7e22ce'; }
            else if (b.status === 'cancelled') { statusBg = '#fee2e2'; statusColor = '#b91c1c'; }

            tr.innerHTML = `
                <td style="padding: 10px 12px; font-family: monospace; font-weight: 800; color: var(--primary);">#${b.booking_id}</td>
                <td style="padding: 10px 12px; font-weight: 600;">${b.event_type}</td>
                <td style="padding: 10px 12px; color: #64748b;">${b.event_date}</td>
                <td style="padding: 10px 12px; color: #475569;">${b.place || '—'}</td>
                <td style="padding: 10px 12px; text-align: center; font-weight: 700;">${b.guests}</td>
                <td style="padding: 10px 12px;">
                    <span style="font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 10px; text-transform: capitalize; background: ${statusBg}; color: ${statusColor};">
                        ${b.status}
                    </span>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    const modal = document.getElementById('clientDossierModal');
    modal.style.display = 'flex';
}

function closeClientDossier() {
    const modal = document.getElementById('clientDossierModal');
    modal.style.display = 'none';
}

function printClientDossier() {
    const printArea = document.getElementById('printDossierArea');
    const printHeader = printArea.querySelector('.print-only-header');
    if (printHeader) printHeader.style.display = 'block';

    window.print();

    if (printHeader) printHeader.style.display = 'none';
}

// Close on backdrop click
document.getElementById('clientDossierModal').addEventListener('click', (e) => {
    if (e.target.id === 'clientDossierModal') {
        closeClientDossier();
    }
});
</script>
@endpush
