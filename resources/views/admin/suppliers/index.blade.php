@extends('layouts.admin', ['activePage' => 'suppliers', 'title' => 'Supplier Directory - EVENTFLARE Admin Console'])

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
    max-width: 820px;
    max-height: 92vh;
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

/* Service Checkbox Grid */
.service-group-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 14px;
    margin-bottom: 12px;
}
.service-group-title {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    color: var(--primary);
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.service-checkbox-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 8px;
}
.service-checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: var(--text-heading);
    cursor: pointer;
    background: #ffffff;
    padding: 6px 10px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    transition: all 0.15s ease;
}
.service-checkbox-label:hover {
    border-color: var(--primary);
    background: rgba(139, 92, 246, 0.04);
}
</style>
@endpush

@section('content')
<div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
    <div class="dashboard-title">
        <h1>Supplier & Vendor Directory</h1>
        <p>Oversee accredited event vendors, regional coverage, service capabilities, packages, and registered credentials.</p>
    </div>

    <!-- Add Supplier Action Button -->
    <button type="button" class="btn btn-primary" onclick="openOnboardModal()" style="padding: 10px 20px; border-radius: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25);">
        <i class="fas fa-plus-circle"></i> Onboard New Supplier
    </button>
</div>

<!-- Directory Segment Switcher -->
<div class="directory-segment-bar">
    <a href="{{ route('admin.users.index') }}" class="segment-pill">
        <i class="fas fa-users"></i> Customers / Buyers
        <span class="segment-badge">{{ $totalClientsCount }}</span>
    </a>
    <a href="{{ route('admin.suppliers.index') }}" class="segment-pill active">
        <i class="fas fa-store"></i> Suppliers & Vendors
        <span class="segment-badge">{{ $totalSuppliers }}</span>
    </a>
</div>

<!-- KPI Metric Cards Grid -->
<div class="stat-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 24px;">
    <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(139, 92, 246, 0.12); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-store-alt"></i>
        </div>
        <div>
            <h3 style="font-size: 24px; font-weight: 900; margin: 0; color: var(--text-heading);">{{ number_format($totalSuppliers) }}</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0;">Verified Vendors</p>
        </div>
    </div>

    <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(59, 130, 246, 0.12); color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-tags"></i>
        </div>
        <div>
            <h3 style="font-size: 24px; font-weight: 900; margin: 0; color: var(--text-heading);">{{ number_format($totalCategories) }}</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0;">Speciality Categories</p>
        </div>
    </div>

    <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(16, 185, 129, 0.12); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-handshake"></i>
        </div>
        <div>
            <h3 style="font-size: 24px; font-weight: 900; margin: 0; color: var(--text-heading);">{{ number_format($totalServices) }}</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0;">Accredited Service Links</p>
        </div>
    </div>

    <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(245, 158, 11, 0.12); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-box-open"></i>
        </div>
        <div>
            <h3 style="font-size: 24px; font-weight: 900; margin: 0; color: var(--text-heading);">{{ number_format($totalListings) }}</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0;">Published Packages</p>
        </div>
    </div>
</div>

<!-- Search Bar -->
<div class="glass-card" style="padding: 18px 22px; margin-bottom: 24px;">
    <form method="GET" action="{{ route('admin.suppliers.index') }}" style="display: flex; gap: 12px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 250px;">
            <input type="text" name="search" class="form-input" placeholder="Search by business name, category, city, or username..." value="{{ $search }}">
        </div>
        <button type="submit" class="btn btn-primary" style="padding: 10px 20px; border-radius: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fas fa-search"></i> Search Vendors
        </button>
        @if($search)
            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary" style="padding: 10px 16px; border-radius: 12px;">Clear</a>
        @endif
    </form>
</div>

<!-- Suppliers Table -->
<div class="glass-card" style="padding: 24px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
        <thead>
            <tr style="color: var(--text-muted); font-size: 11px; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 14px;">Business & Account</th>
                <th style="padding: 12px 14px;">Speciality</th>
                <th style="padding: 12px 14px;">Location</th>
                <th style="padding: 12px 14px;">Contact Phone</th>
                <th style="padding: 12px 14px;">Accredited Services</th>
                <th style="padding: 12px 14px;">Packages</th>
                <th style="padding: 12px 14px; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $s)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 14px;">
                        <div style="font-weight: 800; color: var(--text-heading); font-size: 14px;">{{ $s->business_name }}</div>
                        <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                            <span style="color: var(--primary); font-weight: 600;">@<span>{{ $s->user->username ?? 'vendor' }}</span></span>
                            &bull; <span>{{ $s->user->email ?? '' }}</span>
                        </div>
                    </td>
                    <td style="padding: 14px; font-weight: 600; color: var(--primary);">
                        {{ $s->category }}
                    </td>
                    <td style="padding: 14px; color: #64748b;">
                        <i class="fas fa-map-marker-alt fa-xs" style="color: #ef4444; margin-right: 4px;"></i> {{ $s->location }}
                    </td>
                    <td style="padding: 14px; font-weight: 600;">
                        {{ $s->contact_phone }}
                    </td>
                    <td style="padding: 14px;">
                        <span style="font-size: 11px; font-weight: 800; background: #eff6ff; color: #1d4ed8; padding: 3px 10px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;" title="{{ $s->services->pluck('service_name')->join(', ') }}">
                            <i class="fas fa-check fa-xs"></i> {{ $s->services->count() }} Services
                        </span>
                        @if($s->services->count() > 0)
                            <div style="font-size: 10px; color: #94a3b8; margin-top: 4px; max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ $s->services->pluck('service_name')->take(2)->join(', ') }}@if($s->services->count() > 2)...@endif
                            </div>
                        @endif
                    </td>
                    <td style="padding: 14px;">
                        <button type="button"
                                style="font-size: 11px; font-weight: 800; background: #fdf2f8; color: #be185d; padding: 4px 10px; border-radius: 12px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;"
                                title="Click to inspect package details"
                                onclick="openSupplierDossier({{ json_encode([
                                    'id' => $s->id,
                                    'ref' => 'SUP-' . str_pad($s->id, 4, '0', STR_PAD_LEFT),
                                    'business_name' => $s->business_name,
                                    'fullname' => $s->user->fullname ?? 'Not Specified',
                                    'username' => $s->user->username ?? 'vendor',
                                    'email' => $s->user->email ?? '',
                                    'category' => $s->category,
                                    'contact_phone' => $s->contact_phone ?: 'Not provided',
                                    'location' => $s->location ?: 'Not specified',
                                    'description' => $s->description ?: 'No business bio supplied yet.',
                                    'created_at' => $s->created_at ? $s->created_at->format('M d, Y') : '—',
                                    'services' => $s->services->pluck('service_name')->toArray(),
                                    'listings' => $s->listings->map(function($l) {
                                        return [
                                            'id' => $l->listing_id,
                                            'title' => $l->title,
                                            'service_name' => $l->service->service_name ?? 'General Service',
                                            'price' => number_format($l->price),
                                            'price_type' => str_replace('_', ' ', $l->price_type),
                                            'capacity' => $l->capacity ? $l->capacity . ' Guests' : 'Standard',
                                            'status' => $l->status,
                                            'description' => $l->description,
                                        ];
                                    })->toArray()
                                ]) }})">
                            <i class="fas fa-box-open fa-xs"></i> {{ $s->listings->count() }} Packages
                        </button>
                    </td>
                    <td style="padding: 14px; text-align: right;">
                        <div style="display: inline-flex; gap: 8px; align-items: center;">
                            <button type="button"
                                    class="btn btn-outline"
                                    style="border: 1px solid #e2e8f0; color: var(--primary); background: rgba(139, 92, 246, 0.05); padding: 5px 12px; font-size: 12px; font-weight: 700; border-radius: 10px; cursor: pointer;"
                                    title="View Profile & Packages"
                                    onclick="openSupplierDossier({{ json_encode([
                                        'id' => $s->id,
                                        'ref' => 'SUP-' . str_pad($s->id, 4, '0', STR_PAD_LEFT),
                                        'business_name' => $s->business_name,
                                        'fullname' => $s->user->fullname ?? 'Not Specified',
                                        'username' => $s->user->username ?? 'vendor',
                                        'email' => $s->user->email ?? '',
                                        'category' => $s->category,
                                        'contact_phone' => $s->contact_phone ?: 'Not provided',
                                        'location' => $s->location ?: 'Not specified',
                                        'description' => $s->description ?: 'No business bio supplied yet.',
                                        'created_at' => $s->created_at ? $s->created_at->format('M d, Y') : '—',
                                        'services' => $s->services->pluck('service_name')->toArray(),
                                        'listings' => $s->listings->map(function($l) {
                                            return [
                                                'id' => $l->listing_id,
                                                'title' => $l->title,
                                                'service_name' => $l->service->service_name ?? 'General Service',
                                                'price' => number_format($l->price),
                                                'price_type' => str_replace('_', ' ', $l->price_type),
                                                'capacity' => $l->capacity ? $l->capacity . ' Guests' : 'Standard',
                                                'status' => $l->status,
                                                'description' => $l->description,
                                            ];
                                        })->toArray()
                                    ]) }})">
                                <i class="fas fa-eye"></i> Details
                            </button>

                            <button type="button"
                                    class="btn btn-outline"
                                    style="border: 1px solid #e2e8f0; color: #475569; background: #ffffff; padding: 5px 10px; font-size: 12px; font-weight: 700; border-radius: 10px; cursor: pointer;"
                                    title="Edit Supplier"
                                    onclick="openEditModal({{ json_encode([
                                        'id' => $s->id,
                                        'business_name' => $s->business_name,
                                        'fullname' => $s->user->fullname ?? '',
                                        'category' => $s->category,
                                        'contact_phone' => $s->contact_phone,
                                        'location' => $s->location,
                                        'description' => $s->description,
                                        'service_ids' => $s->services->pluck('service_id')->toArray()
                                    ]) }})">
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <form method="POST" action="{{ route('admin.suppliers.destroy', $s->id) }}" onsubmit="return confirm('Permanently delete supplier \'{{ addslashes($s->business_name) }}\' and associated account credentials?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline" style="border: 1px solid #fee2e2; color: #ef4444; background: #fff5f5; padding: 5px 10px; font-size: 12px; border-radius: 10px; cursor: pointer;" title="Delete Supplier">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">No suppliers found matching your query.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $suppliers->links() }}
    </div>
</div>

<!-- Modal 1: Onboard New Supplier Modal -->
<div class="admin-modal-backdrop" id="onboardSupplierModal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(139, 92, 246, 0.12); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 17px; font-weight: 800; color: var(--text-heading);">Onboard New Supplier</h3>
                    <p style="margin: 2px 0 0; font-size: 11px; color: var(--text-muted);">Create vendor credentials, business profile, and accredited services.</p>
                </div>
            </div>
            <button type="button" onclick="closeOnboardModal()" style="background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer;" aria-label="Close">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.suppliers.store') }}">
            @csrf
            <div class="admin-modal-body">
                <!-- Section 1: User Account Credentials -->
                <div style="margin-bottom: 20px;">
                    <h4 style="font-size: 12px; font-weight: 800; text-transform: uppercase; color: var(--primary); letter-spacing: 0.5px; margin: 0 0 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 6px;">
                        <i class="fas fa-key" style="margin-right: 6px;"></i> Step 1: User Login Credentials
                    </h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div>
                            <label class="form-label" style="font-size: 12px; font-weight: 700; color: var(--text-heading);">Username <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="username" class="form-input" required placeholder="e.g. majestic_lighting" value="{{ old('username') }}">
                        </div>
                        <div>
                            <label class="form-label" style="font-size: 12px; font-weight: 700; color: var(--text-heading);">Primary Contact Person <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="fullname" class="form-input" required placeholder="e.g. Kasun Fernando" value="{{ old('fullname') }}">
                        </div>
                        <div>
                            <label class="form-label" style="font-size: 12px; font-weight: 700; color: var(--text-heading);">Work Email <span style="color:#ef4444;">*</span></label>
                            <input type="email" name="email" class="form-input" required placeholder="e.g. kasun@majestic.lk" value="{{ old('email') }}">
                        </div>
                        <div>
                            <label class="form-label" style="font-size: 12px; font-weight: 700; color: var(--text-heading);">Initial Password <span style="color:#ef4444;">*</span></label>
                            <input type="password" name="password" class="form-input" required placeholder="Minimum 6 characters">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Business Profile -->
                <div style="margin-bottom: 20px;">
                    <h4 style="font-size: 12px; font-weight: 800; text-transform: uppercase; color: var(--primary); letter-spacing: 0.5px; margin: 0 0 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 6px;">
                        <i class="fas fa-briefcase" style="margin-right: 6px;"></i> Step 2: Business Profile & Speciality
                    </h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                        <div>
                            <label class="form-label" style="font-size: 12px; font-weight: 700; color: var(--text-heading);">Business / Brand Name <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="business_name" class="form-input" required placeholder="e.g. Majestic Audio & Lighting Solutions" value="{{ old('business_name') }}">
                        </div>
                        <div>
                            <label class="form-label" style="font-size: 12px; font-weight: 700; color: var(--text-heading);">Primary Category <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="category" class="form-input" required placeholder="e.g. Sound, Light & DJ" value="{{ old('category') }}">
                        </div>
                        <div>
                            <label class="form-label" style="font-size: 12px; font-weight: 700; color: var(--text-heading);">Contact Phone <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="contact_phone" class="form-input" required maxlength="20" placeholder="e.g. +94 77 123 4567" value="{{ old('contact_phone') }}">
                        </div>
                        <div>
                            <label class="form-label" style="font-size: 12px; font-weight: 700; color: var(--text-heading);">Operating Location / City <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="location" class="form-input" required placeholder="e.g. Colombo & Western Province" value="{{ old('location') }}">
                        </div>
                    </div>
                    <div>
                        <label class="form-label" style="font-size: 12px; font-weight: 700; color: var(--text-heading);">Business Bio / Summary</label>
                        <textarea name="description" class="form-input" rows="2" placeholder="Brief description of experience, equipment, or culinary speciality...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <!-- Section 3: Accredited Services Checklist -->
                <div>
                    <h4 style="font-size: 12px; font-weight: 800; text-transform: uppercase; color: var(--primary); letter-spacing: 0.5px; margin: 0 0 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 6px;">
                        <i class="fas fa-check-double" style="margin-right: 6px;"></i> Step 3: Accredited Platform Services
                    </h4>
                    <p style="font-size: 12px; color: var(--text-muted); margin: 0 0 12px;">Select all celebratory services this vendor is accredited to fulfill:</p>

                    @php
                        $groupedServices = $allServices->groupBy(function($item) {
                            return $item->eventType->type_name ?? 'General Services';
                        });
                    @endphp

                    @foreach($groupedServices as $groupName => $servicesList)
                        <div class="service-group-box">
                            <div class="service-group-title">
                                <i class="fas fa-chevron-right fa-xs"></i> {{ $groupName }}
                            </div>
                            <div class="service-checkbox-grid">
                                @foreach($servicesList as $srv)
                                    <label class="service-checkbox-label">
                                        <input type="checkbox" name="services[]" value="{{ $srv->service_id }}">
                                        <span>{{ $srv->service_name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="admin-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeOnboardModal()" style="padding: 9px 18px; border-radius: 10px; font-weight: 700; font-size: 13px;">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" style="padding: 9px 22px; border-radius: 10px; font-weight: 700; font-size: 13px;">
                    <i class="fas fa-check"></i> Complete Onboarding
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Edit Supplier Modal -->
<div class="admin-modal-backdrop" id="editSupplierModal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(139, 92, 246, 0.12); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 17px; font-weight: 800; color: var(--text-heading);" id="editModalTitle">Edit Supplier Profile</h3>
                    <p style="margin: 2px 0 0; font-size: 11px; color: var(--text-muted);">Update business details and synchronized accredited services.</p>
                </div>
            </div>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer;" aria-label="Close">&times;</button>
        </div>

        <form method="POST" id="editSupplierForm" action="">
            @csrf
            @method('PUT')
            <div class="admin-modal-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                    <div>
                        <label class="form-label" style="font-size: 12px; font-weight: 700; color: var(--text-heading);">Business / Brand Name <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="business_name" id="edit_business_name" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label" style="font-size: 12px; font-weight: 700; color: var(--text-heading);">Contact Person Name <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="fullname" id="edit_fullname" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label" style="font-size: 12px; font-weight: 700; color: var(--text-heading);">Category <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="category" id="edit_category" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label" style="font-size: 12px; font-weight: 700; color: var(--text-heading);">Contact Phone <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="contact_phone" id="edit_contact_phone" class="form-input" required maxlength="20">
                    </div>
                </div>

                <div style="margin-bottom: 12px;">
                    <label class="form-label" style="font-size: 12px; font-weight: 700; color: var(--text-heading);">Operating Location / City <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="location" id="edit_location" class="form-input" required>
                </div>

                <div style="margin-bottom: 18px;">
                    <label class="form-label" style="font-size: 12px; font-weight: 700; color: var(--text-heading);">Business Description</label>
                    <textarea name="description" id="edit_description" class="form-input" rows="2"></textarea>
                </div>

                <!-- Accredited Services Synchronization Checklist -->
                <div>
                    <h4 style="font-size: 12px; font-weight: 800; text-transform: uppercase; color: var(--primary); letter-spacing: 0.5px; margin: 0 0 10px; border-bottom: 1px solid #f1f5f9; padding-bottom: 6px;">
                        <i class="fas fa-check-double" style="margin-right: 6px;"></i> Accredited Platform Services
                    </h4>

                    @foreach($groupedServices as $groupName => $servicesList)
                        <div class="service-group-box">
                            <div class="service-group-title">
                                <i class="fas fa-chevron-right fa-xs"></i> {{ $groupName }}
                            </div>
                            <div class="service-checkbox-grid">
                                @foreach($servicesList as $srv)
                                    <label class="service-checkbox-label">
                                        <input type="checkbox" name="services[]" value="{{ $srv->service_id }}" class="edit-service-cb" id="edit_srv_{{ $srv->service_id }}">
                                        <span>{{ $srv->service_name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="admin-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()" style="padding: 9px 18px; border-radius: 10px; font-weight: 700; font-size: 13px;">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" style="padding: 9px 22px; border-radius: 10px; font-weight: 700; font-size: 13px;">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
<!-- Modal 3: Supplier Profile & Packages Dossier Modal -->
<div class="admin-modal-backdrop" id="supplierDossierModal">
    <div class="admin-modal-card" style="max-width: 860px;">
        <div class="admin-modal-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(139, 92, 246, 0.12); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fas fa-store-alt"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 17px; font-weight: 800; color: var(--text-heading);" id="dossierSupplierTitle">Supplier Profile & Packages</h3>
                    <span style="font-size: 11px; font-family: monospace; color: var(--primary); font-weight: 800;" id="dossierSupplierRef">#SUP-0000</span>
                </div>
            </div>
            <button type="button" onclick="closeSupplierDossier()" style="background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer;" aria-label="Close">&times;</button>
        </div>

        <div class="admin-modal-body">
            <!-- Profile Metadata Grid -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px; margin-bottom: 20px;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px;">
                    <div>
                        <small style="display: block; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Business Brand Name</small>
                        <strong style="font-size: 14px; color: var(--text-heading);" id="dossierBusinessName">—</strong>
                    </div>
                    <div>
                        <small style="display: block; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Primary Speciality</small>
                        <span style="font-size: 13px; font-weight: 700; color: var(--primary);" id="dossierCategory">—</span>
                    </div>
                    <div>
                        <small style="display: block; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Contact Person</small>
                        <strong style="font-size: 13px; color: var(--text-heading);" id="dossierContactPerson">—</strong>
                    </div>
                    <div>
                        <small style="display: block; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Account Handle & Email</small>
                        <div style="font-size: 12px; color: #334155; font-weight: 600;">
                            <span id="dossierUsername">@—</span>
                            <div style="color: #64748b;" id="dossierEmail">—</div>
                        </div>
                    </div>
                    <div>
                        <small style="display: block; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Phone Contact</small>
                        <span style="font-size: 13px; color: #334155; font-weight: 600;" id="dossierPhone">—</span>
                    </div>
                    <div>
                        <small style="display: block; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Operating Location</small>
                        <span style="font-size: 13px; color: #64748b;" id="dossierLocation">—</span>
                    </div>
                </div>

                <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid #e2e8f0;">
                    <small style="display: block; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Business Bio / Description</small>
                    <p style="font-size: 13px; color: #475569; margin: 0; line-height: 1.5;" id="dossierDescription">—</p>
                </div>

                <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid #e2e8f0;">
                    <small style="display: block; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">Accredited Services</small>
                    <div id="dossierServicesTags" style="display: flex; flex-wrap: wrap; gap: 6px;">
                        <!-- Injected via JS -->
                    </div>
                </div>
            </div>

            <!-- Packages / Listings Section -->
            <h4 style="font-size: 14px; font-weight: 800; color: var(--text-heading); margin: 0 0 12px; display: flex; align-items: center; justify-content: space-between;">
                <span><i class="fas fa-boxes" style="color: var(--primary); margin-right: 6px;"></i> Published Packages & Offerings</span>
                <span id="dossierListingsCountBadge" style="font-size: 11px; font-weight: 800; background: rgba(139, 92, 246, 0.1); color: var(--primary); padding: 2px 8px; border-radius: 10px;">0 Packages</span>
            </h4>

            <div style="overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 10px;">
                <table style="width: 100%; border-collapse: collapse; font-size: 12px; text-align: left;">
                    <thead>
                        <tr style="background: #f8fafc; color: #64748b; font-size: 11px; text-transform: uppercase; border-bottom: 1px solid #e2e8f0;">
                            <th style="padding: 10px 12px;">Package Title</th>
                            <th style="padding: 10px 12px;">Linked Service</th>
                            <th style="padding: 10px 12px;">Price & Rate Type</th>
                            <th style="padding: 10px 12px;">Capacity / Scope</th>
                            <th style="padding: 10px 12px;">Status</th>
                        </tr>
                    </thead>
                    <tbody id="dossierListingsTableBody">
                        <!-- Injected via JS -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="admin-modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeSupplierDossier()" style="padding: 8px 18px; border-radius: 10px; font-weight: 700; font-size: 13px;">
                Close
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openOnboardModal() {
    document.getElementById('onboardSupplierModal').style.display = 'flex';
}

function closeOnboardModal() {
    document.getElementById('onboardSupplierModal').style.display = 'none';
}

function openEditModal(supplier) {
    document.getElementById('editModalTitle').textContent = `Edit: ${supplier.business_name}`;
    document.getElementById('editSupplierForm').action = `{{ url('/admin/suppliers') }}/${supplier.id}`;

    document.getElementById('edit_business_name').value = supplier.business_name;
    document.getElementById('edit_fullname').value = supplier.fullname || '';
    document.getElementById('edit_category').value = supplier.category;
    document.getElementById('edit_contact_phone').value = supplier.contact_phone || '';
    document.getElementById('edit_location').value = supplier.location || '';
    document.getElementById('edit_description').value = supplier.description || '';

    // Reset and check accredited services
    document.querySelectorAll('.edit-service-cb').forEach(cb => {
        cb.checked = false;
    });

    if (supplier.service_ids && Array.isArray(supplier.service_ids)) {
        supplier.service_ids.forEach(srvId => {
            const cb = document.getElementById(`edit_srv_${srvId}`);
            if (cb) cb.checked = true;
        });
    }

    document.getElementById('editSupplierModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editSupplierModal').style.display = 'none';
}

function openSupplierDossier(supplier) {
    document.getElementById('dossierSupplierTitle').textContent = supplier.business_name;
    document.getElementById('dossierSupplierRef').textContent = `#${supplier.ref}`;
    document.getElementById('dossierBusinessName').textContent = supplier.business_name;
    document.getElementById('dossierCategory').textContent = supplier.category;
    document.getElementById('dossierContactPerson').textContent = supplier.fullname;
    document.getElementById('dossierUsername').textContent = `@${supplier.username}`;
    document.getElementById('dossierEmail').textContent = supplier.email || '—';
    document.getElementById('dossierPhone').textContent = supplier.contact_phone;
    document.getElementById('dossierLocation').textContent = supplier.location;
    document.getElementById('dossierDescription').textContent = supplier.description;

    // Services tags
    const servicesContainer = document.getElementById('dossierServicesTags');
    servicesContainer.innerHTML = '';
    if (!supplier.services || supplier.services.length === 0) {
        servicesContainer.innerHTML = '<span style="font-size: 12px; color: #94a3b8;">No accredited services linked.</span>';
    } else {
        supplier.services.forEach(srv => {
            const tag = document.createElement('span');
            tag.style.cssText = 'font-size: 11px; font-weight: 700; background: #eff6ff; color: #1d4ed8; padding: 3px 10px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;';
            tag.innerHTML = `<i class="fas fa-check-circle fa-xs"></i> ${srv}`;
            servicesContainer.appendChild(tag);
        });
    }

    // Listings table
    const tbody = document.getElementById('dossierListingsTableBody');
    tbody.innerHTML = '';
    const listingsCount = supplier.listings ? supplier.listings.length : 0;
    document.getElementById('dossierListingsCountBadge').textContent = `${listingsCount} Packages`;

    if (!supplier.listings || supplier.listings.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 24px;">
                    <i class="fas fa-box-open" style="font-size: 20px; display: block; margin-bottom: 6px;"></i>
                    No published packages recorded for this vendor yet.
                </td>
            </tr>
        `;
    } else {
        supplier.listings.forEach(l => {
            const tr = document.createElement('tr');
            tr.style.borderBottom = '1px solid #f1f5f9';

            let statusBg = l.status === 'active' ? '#dcfce7' : '#f1f5f9';
            let statusColor = l.status === 'active' ? '#15803d' : '#64748b';

            tr.innerHTML = `
                <td style="padding: 10px 12px;">
                    <strong style="color: var(--text-heading); display: block; font-size: 13px;">${l.title}</strong>
                    ${l.description ? `<small style="color: #64748b; display: block; margin-top: 2px;">${l.description.substring(0, 75)}${l.description.length > 75 ? '...' : ''}</small>` : ''}
                </td>
                <td style="padding: 10px 12px; font-weight: 600; color: var(--primary);">${l.service_name}</td>
                <td style="padding: 10px 12px;">
                    <strong style="color: #059669; font-size: 13px;">LKR ${l.price}</strong>
                    <small style="color: #64748b; display: block; font-size: 10px; text-transform: uppercase;">${l.price_type}</small>
                </td>
                <td style="padding: 10px 12px; color: #475569;">${l.capacity}</td>
                <td style="padding: 10px 12px;">
                    <span style="font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 10px; text-transform: capitalize; background: ${statusBg}; color: ${statusColor};">
                        ${l.status}
                    </span>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    document.getElementById('supplierDossierModal').style.display = 'flex';
}

function closeSupplierDossier() {
    document.getElementById('supplierDossierModal').style.display = 'none';
}

// Close on backdrop click
document.getElementById('onboardSupplierModal').addEventListener('click', (e) => {
    if (e.target.id === 'onboardSupplierModal') closeOnboardModal();
});
document.getElementById('editSupplierModal').addEventListener('click', (e) => {
    if (e.target.id === 'editSupplierModal') closeEditModal();
});
document.getElementById('supplierDossierModal').addEventListener('click', (e) => {
    if (e.target.id === 'supplierDossierModal') closeSupplierDossier();
});
</script>
@endpush
