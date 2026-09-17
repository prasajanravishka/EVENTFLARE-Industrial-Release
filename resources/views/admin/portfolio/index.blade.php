@extends('layouts.admin', ['activePage' => 'portfolio', 'title' => 'Executed Portfolio & Case Studies - EVENTFLARE Admin Console'])

@section('content')
<div class="dashboard-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
    <div class="dashboard-title">
        <h1 style="font-size: 26px; font-weight: 900; color: var(--text-heading); display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-photo-video" style="color: var(--primary);"></i> Portfolio & Case Studies
        </h1>
        <p style="color: var(--text-muted); font-size: 13px; margin: 4px 0 0;">
            Manage authentic executed celebrations, dossiers, testimonials, guest metrics, and homepage carousel showcases.
        </p>
    </div>
    <div>
        <button type="button" class="btn btn-primary" onclick="openCreateModal()" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 20px; font-weight: 700; font-size: 13px;">
            <i class="fas fa-plus-circle"></i> Add Celebration Dossier
        </button>
    </div>
</div>

<!-- Top KPI Summary Bar -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="glass-card" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #e0e7ff; color: #4338ca; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-camera-retro"></i>
        </div>
        <div>
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Total Executed</span>
            <div style="font-size: 22px; font-weight: 900; color: var(--text-heading); line-height: 1.2;">
                {{ $stats['total'] }}
            </div>
            <small style="font-size: 11px; color: #16a34a; font-weight: 700;">{{ $stats['active'] }} Active Published</small>
        </div>
    </div>

    <div class="glass-card" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #fdf2f8; color: #db2777; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-star"></i>
        </div>
        <div>
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Home Carousel</span>
            <div style="font-size: 22px; font-weight: 900; color: var(--text-heading); line-height: 1.2;">
                {{ $stats['featured'] }}
            </div>
            <small style="font-size: 11px; color: #db2777; font-weight: 700;">Featured on Homepage</small>
        </div>
    </div>

    <div class="glass-card" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Guests Celebrated</span>
            <div style="font-size: 22px; font-weight: 900; color: var(--text-heading); line-height: 1.2;">
                {{ number_format($stats['total_guests']) }}+
            </div>
            <small style="font-size: 11px; color: var(--text-muted);">Across Sri Lanka venues</small>
        </div>
    </div>

    <div class="glass-card" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #fffbeb; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-layer-group"></i>
        </div>
        <div>
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Sectors Covered</span>
            <div style="font-size: 22px; font-weight: 900; color: var(--text-heading); line-height: 1.2;">
                {{ count($categories) }} Categories
            </div>
            <small style="font-size: 11px; color: #d97706; font-weight: 700;">Weddings, Audio, Galas & more</small>
        </div>
    </div>
</div>

<!-- Search & Filter Controls -->
<div class="glass-card" style="padding: 16px 20px; margin-bottom: 20px;">
    <form method="GET" action="{{ route('admin.portfolio.index') }}" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
        <div style="flex: 1; min-width: 220px; position: relative;">
            <input type="text" name="search" value="{{ $search }}" class="form-input" placeholder="Search by title, venue, or client..." style="padding-left: 36px;">
            <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px;"></i>
        </div>

        <div style="min-width: 180px;">
            <select name="category" class="form-input" onchange="this.form.submit()">
                <option value="all">All Sectors</option>
                @foreach($categories as $tag => $label)
                    <option value="{{ $tag }}" {{ $category === $tag ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div style="min-width: 160px;">
            <select name="status" class="form-input" onchange="this.form.submit()">
                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Statuses</option>
                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active Only</option>
                <option value="featured" {{ $status === 'featured' ? 'selected' : '' }}>Home Featured</option>
                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Drafts / Archived</option>
            </select>
        </div>

        <div>
            <button type="submit" class="btn btn-secondary" style="padding: 8px 16px; border-radius: 12px; font-weight: 700; font-size: 13px;">
                Filter
            </button>
            @if($search || $category !== 'all' || $status !== 'all')
                <a href="{{ route('admin.portfolio.index') }}" class="btn btn-neutral" style="padding: 8px 16px; border-radius: 12px; font-weight: 700; font-size: 13px; text-decoration: none; display: inline-block;">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Portfolio Showcase Items Table -->
<div class="glass-card" style="padding: 0; overflow: hidden; margin-bottom: 24px;">
    <div style="overflow-x: auto;">
        <table class="dashboard-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: rgba(248, 250, 252, 0.8); border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 14px 20px; font-size: 12px; font-weight: 800; color: #475569; text-transform: uppercase;">Celebration Dossier</th>
                    <th style="padding: 14px 16px; font-size: 12px; font-weight: 800; color: #475569; text-transform: uppercase;">Sector & Venue</th>
                    <th style="padding: 14px 16px; font-size: 12px; font-weight: 800; color: #475569; text-transform: uppercase; text-align: center;">Guests</th>
                    <th style="padding: 14px 16px; font-size: 12px; font-weight: 800; color: #475569; text-transform: uppercase; text-align: center;">Home Featured</th>
                    <th style="padding: 14px 16px; font-size: 12px; font-weight: 800; color: #475569; text-transform: uppercase; text-align: center;">Status</th>
                    <th style="padding: 14px 20px; font-size: 12px; font-weight: 800; color: #475569; text-transform: uppercase; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($caseStudies as $cs)
                    @php
                        $badgeColor = match($cs->category_tag) {
                            'wedding' => '#ec4899',
                            'dj' => '#8b5cf6',
                            'birthday' => '#f59e0b',
                            'hotel' => '#3b82f6',
                            'gettogether' => '#10b981',
                            'corporate' => '#6366f1',
                            default => '#6366f1'
                        };
                    @endphp
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;">
                        <td style="padding: 16px 20px;">
                            <div style="display: flex; align-items: center; gap: 14px;">
                                <div style="position: relative; width: 68px; height: 50px; border-radius: 10px; overflow: hidden; background: #f1f5f9; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                                    <img src="{{ asset($cs->image_url) }}" alt="{{ $cs->title }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=200'">
                                </div>
                                <div>
                                    <h4 style="font-size: 14px; font-weight: 800; color: var(--text-heading); margin: 0 0 4px 0; line-height: 1.3;">
                                        {{ $cs->title }}
                                    </h4>
                                    @if($cs->tagline)
                                        <p style="font-size: 12px; color: var(--text-muted); margin: 0 0 3px 0;">
                                            {{ Str::limit($cs->tagline, 55) }}
                                        </p>
                                    @endif
                                    <div style="display: flex; gap: 6px; align-items: center; flex-wrap: wrap;">
                                        @if($cs->client_name)
                                            <span style="font-size: 11px; color: #64748b; background: #f8fafc; padding: 2px 6px; border-radius: 6px; border: 1px solid #e2e8f0;">
                                                <i class="fas fa-user-check" style="color: #10b981;"></i> {{ $cs->client_name }}
                                            </span>
                                        @endif
                                        @if($cs->booking_id)
                                            <a href="{{ route('admin.bookings.show', $cs->booking_id) }}" style="font-size: 11px; font-weight: 700; color: var(--primary); background: rgba(139, 92, 246, 0.08); padding: 2px 8px; border-radius: 6px; text-decoration: none; border: 1px solid rgba(139, 92, 246, 0.15); display: inline-flex; align-items: center; gap: 4px;" title="View Verified Booking Dossier">
                                                <i class="fas fa-receipt fa-xs"></i> #{{ $cs->booking_id }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td style="padding: 16px;">
                            <span style="display: inline-block; font-size: 11px; font-weight: 700; color: {{ $badgeColor }}; background: {{ $badgeColor }}15; padding: 3px 8px; border-radius: 6px; margin-bottom: 4px;">
                                {{ $cs->category_label }}
                            </span>
                            <div style="font-size: 12px; color: #334155; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                                <i class="fas fa-map-marker-alt" style="color: #94a3b8; font-size: 11px;"></i> {{ Str::limit($cs->venue, 35) }}
                            </div>
                            @if($cs->event_date)
                                <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                    <i class="far fa-calendar-alt" style="font-size: 11px;"></i> {{ $cs->event_date }}
                                </div>
                            @endif
                        </td>

                        <td style="padding: 16px; text-align: center;">
                            <span style="font-size: 13px; font-weight: 800; color: var(--text-heading);">
                                {{ $cs->guests_count }}
                            </span>
                            <div style="font-size: 11px; color: var(--text-muted);">Guests</div>
                        </td>

                        <td style="padding: 16px; text-align: center;">
                            <form method="POST" action="{{ route('admin.portfolio.toggle-featured', $cs->id) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;" title="Click to toggle homepage carousel">
                                    @if($cs->is_featured_home)
                                        <span class="badge" style="background: #fdf2f8; color: #db2777; border: 1px solid #fbcfe8; padding: 4px 8px; border-radius: 8px; font-size: 11px; font-weight: 700;">
                                            <i class="fas fa-check-circle"></i> Featured
                                        </span>
                                    @else
                                        <span class="badge" style="background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0; padding: 4px 8px; border-radius: 8px; font-size: 11px;">
                                            Off
                                        </span>
                                    @endif
                                </button>
                            </form>
                        </td>

                        <td style="padding: 16px; text-align: center;">
                            <form method="POST" action="{{ route('admin.portfolio.toggle', $cs->id) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;" title="Click to toggle publish status">
                                    @if($cs->is_active)
                                        <span class="badge badge-success" style="padding: 4px 8px; border-radius: 8px; font-size: 11px; font-weight: 700;">
                                            <i class="fas fa-circle" style="font-size: 8px;"></i> Published
                                        </span>
                                    @else
                                        <span class="badge badge-neutral" style="padding: 4px 8px; border-radius: 8px; font-size: 11px;">
                                            Draft
                                        </span>
                                    @endif
                                </button>
                            </form>
                        </td>

                        <td style="padding: 16px 20px; text-align: right;">
                            <div style="display: inline-flex; align-items: center; gap: 8px;">
                                <button type="button" class="btn-icon" title="Edit Dossier" onclick="openEditModal({{ json_encode($cs) }})" style="width: 32px; height: 32px; border-radius: 8px; border: 1px solid #e2e8f0; background: #ffffff; color: #475569; cursor: pointer;">
                                    <i class="fas fa-edit" style="font-size: 13px;"></i>
                                </button>

                                <form method="POST" action="{{ route('admin.portfolio.destroy', $cs->id) }}" onsubmit="return confirm('Are you sure you want to delete this case study dossier? This action cannot be undone.');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon" title="Delete Dossier" style="width: 32px; height: 32px; border-radius: 8px; border: 1px solid #fecaca; background: #fef2f2; color: #dc2626; cursor: pointer;">
                                        <i class="fas fa-trash-alt" style="font-size: 13px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 40px 20px; text-align: center; color: var(--text-muted);">
                            <div style="font-size: 40px; color: #cbd5e1; margin-bottom: 12px;"><i class="fas fa-camera-retro"></i></div>
                            <h4 style="font-size: 16px; font-weight: 800; color: #334155; margin-bottom: 4px;">No Case Studies Found</h4>
                            <p style="font-size: 13px; margin: 0 0 16px 0;">Start showcasing your real executed celebrations to inspire potential clients.</p>
                            <button type="button" class="btn btn-primary" onclick="openCreateModal()" style="padding: 8px 18px; border-radius: 16px; font-weight: 700; font-size: 12px;">
                                <i class="fas fa-plus"></i> Add First Case Study
                            </button>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($caseStudies->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid #f1f5f9;">
            {{ $caseStudies->links() }}
        </div>
    @endif
</div>

<!-- ================= MODAL: CREATE CASE STUDY ================= -->
<div id="createModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div class="glass-card" style="width: 100%; max-width: 680px; max-height: 90vh; overflow-y: auto; padding: 28px; background: #ffffff; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
            <h3 style="font-size: 18px; font-weight: 900; color: var(--text-heading); margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-plus-circle" style="color: var(--primary);"></i> Add Executed Celebration Dossier
            </h3>
            <button type="button" onclick="closeCreateModal()" style="background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer;">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.portfolio.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- ⚡ Quick Auto-Fill from Verified Completed Booking -->
            <div style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border: 1px solid #bbf7d0; border-radius: 14px; padding: 14px 16px; margin-bottom: 18px; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.06);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <label class="form-label" style="color: #166534; font-weight: 800; margin: 0; display: flex; align-items: center; gap: 6px; font-size: 13px;">
                        <i class="fas fa-bolt" style="color: #16a34a;"></i> Auto-Fill from Completed Booking
                    </label>
                    <span style="font-size: 10.5px; font-weight: 800; color: #15803d; background: #dcfce7; padding: 2px 8px; border-radius: 12px; border: 1px solid #bbf7d0;">
                        100% Platform Verified
                    </span>
                </div>
                <p style="font-size: 12px; color: #166534; margin: 0 0 10px 0; line-height: 1.4;">
                    Select an executed booking to auto-fill client name, sector, venue, date, guest attendance, and itemized vendors with zero manual data entry errors.
                </p>
                <div>
                    <select id="autofill_booking_select" class="form-input" onchange="autoFillFromBooking(this.value)" style="background: #ffffff; border-color: #86efac; font-size: 12.5px; font-weight: 600;">
                        <option value="">-- Select a completed booking to auto-fill --</option>
                        @foreach($completedBookings as $bkg)
                            <option value="{{ $bkg->BookingID }}" {{ (isset($autofillBooking) && $autofillBooking === $bkg->BookingID) ? 'selected' : '' }}>
                                #{{ $bkg->BookingID }} — {{ $bkg->user_name }} ({{ $bkg->EventType }} · {{ $bkg->Place }} · {{ \Carbon\Carbon::parse($bkg->EventDate)->format('M d, Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div id="autofill_status_badge" style="display: none; margin-top: 8px; font-size: 11.5px; color: #15803d; font-weight: 700; align-items: center; gap: 6px;">
                    <i class="fas fa-check-circle" style="color: #16a34a;"></i>
                    <span>Booking details auto-filled! Please review and upload a showcase hero photo below.</span>
                </div>
            </div>

            <input type="hidden" id="create_booking_id" name="booking_id" value="">
            <input type="hidden" id="create_event_type_id" name="event_type_id" value="">

            <div style="margin-bottom: 14px;">
                <label class="form-label" for="create_title">Celebration Title <span style="color:#ef4444;">*</span></label>
                <input type="text" id="create_title" name="title" class="form-input" required placeholder="e.g. Kasun & Dilhani’s Grand Coastal Celebration">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label class="form-label" for="create_category_tag">Event Sector <span style="color:#ef4444;">*</span></label>
                    <select id="create_category_tag" name="category_tag" class="form-input" required>
                        @foreach($categories as $tag => $label)
                            <option value="{{ $tag }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="create_category_label">Badge Label</label>
                    <input type="text" id="create_category_label" name="category_label" class="form-input" placeholder="e.g. Coastal & Beachfront">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label class="form-label" for="create_venue">Venue & Location <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="create_venue" name="venue" class="form-input" required placeholder="e.g. The Kingsbury Ballroom, Colombo">
                </div>
                <div>
                    <label class="form-label" for="create_event_date">Event Date</label>
                    <input type="text" id="create_event_date" name="event_date" class="form-input" placeholder="e.g. October 24, 2026">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label class="form-label" for="create_guests_count">Guests Count <span style="color:#ef4444;">*</span></label>
                    <input type="number" id="create_guests_count" name="guests_count" class="form-input" required value="150" min="1">
                </div>
                <div>
                    <label class="form-label" for="create_tagline">Tagline / Style Highlights</label>
                    <input type="text" id="create_tagline" name="tagline" class="form-input" placeholder="e.g. Traditional Poruwa & Coastal Lawn">
                </div>
            </div>

            <!-- Image Upload or URL -->
            <div style="margin-bottom: 14px; background: #f8fafc; padding: 14px; border-radius: 12px; border: 1px dashed #cbd5e1;">
                <label class="form-label" style="margin-bottom: 6px;">Hero Showcase Photo</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; align-items: center;">
                    <div>
                        <span style="font-size: 11px; color: #64748b; display: block; margin-bottom: 4px;">Upload Image File (Max 4MB):</span>
                        <input type="file" name="image" accept="image/*" class="form-input" style="padding: 6px;">
                    </div>
                    <div>
                        <span style="font-size: 11px; color: #64748b; display: block; margin-bottom: 4px;">Or External/Asset URL:</span>
                        <input type="text" name="image_url" class="form-input" placeholder="assets/images/weding.jpg">
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <label class="form-label" for="create_summary">Executive Summary <span style="color:#ef4444;">*</span></label>
                <textarea id="create_summary" name="summary" class="form-input" rows="3" required placeholder="Describe the celebration atmosphere, setup details, and notable highlights..."></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label class="form-label" for="create_client_name">Client Name(s)</label>
                    <input type="text" id="create_client_name" name="client_name" class="form-input" placeholder="e.g. Kasun & Dilhani Perera">
                </div>
                <div>
                    <label class="form-label" for="create_quote">Client Testimonial Quote</label>
                    <input type="text" id="create_quote" name="quote" class="form-input" placeholder="e.g. EVENTFLARE made our wedding completely stress-free!">
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label class="form-label" for="create_services_input">
                    Delivered Services Breakdown
                    <small style="color: #64748b; font-weight: normal;">(One item per line, formatted as "Service: Vendor")</small>
                </label>
                <textarea id="create_services_input" name="services_input" class="form-input" rows="3" placeholder="Decor & Poruwa: Lotus Floral Elegance&#10;Catering: Grand Royal Banquet&#10;Photography: Aurora Cinematography"></textarea>
            </div>

            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 20px; flex-wrap: wrap;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer; font-weight: 600;">
                    <input type="checkbox" name="is_featured_home" value="1" checked style="accent-color: var(--primary);">
                    <span>Feature on Homepage Horizontal Carousel</span>
                </label>
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer; font-weight: 600;">
                    <input type="checkbox" name="is_active" value="1" checked style="accent-color: var(--primary);">
                    <span>Publish Immediately (Active)</span>
                </label>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeCreateModal()" class="btn btn-neutral" style="padding: 10px 20px; border-radius: 14px; font-weight: 700;">Cancel</button>
                <button type="submit" class="btn btn-primary" style="padding: 10px 24px; border-radius: 14px; font-weight: 700;">
                    <i class="fas fa-save"></i> Save Celebration
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL: EDIT CASE STUDY ================= -->
<div id="editModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div class="glass-card" style="width: 100%; max-width: 680px; max-height: 90vh; overflow-y: auto; padding: 28px; background: #ffffff; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
            <h3 style="font-size: 18px; font-weight: 900; color: var(--text-heading); margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-edit" style="color: var(--primary);"></i> Edit Celebration Dossier
            </h3>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer;">&times;</button>
        </div>

        <form id="editForm" method="POST" action="" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_booking_id" name="booking_id" value="">
            <div style="margin-bottom: 14px;">
                <label class="form-label" for="edit_title">Celebration Title <span style="color:#ef4444;">*</span></label>
                <input type="text" id="edit_title" name="title" class="form-input" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label class="form-label" for="edit_category_tag">Event Sector <span style="color:#ef4444;">*</span></label>
                    <select id="edit_category_tag" name="category_tag" class="form-input" required>
                        @foreach($categories as $tag => $label)
                            <option value="{{ $tag }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="edit_category_label">Badge Label</label>
                    <input type="text" id="edit_category_label" name="category_label" class="form-input">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label class="form-label" for="edit_venue">Venue & Location <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="edit_venue" name="venue" class="form-input" required>
                </div>
                <div>
                    <label class="form-label" for="edit_event_date">Event Date</label>
                    <input type="text" id="edit_event_date" name="event_date" class="form-input">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label class="form-label" for="edit_guests_count">Guests Count <span style="color:#ef4444;">*</span></label>
                    <input type="number" id="edit_guests_count" name="guests_count" class="form-input" required min="1">
                </div>
                <div>
                    <label class="form-label" for="edit_tagline">Tagline / Style Highlights</label>
                    <input type="text" id="edit_tagline" name="tagline" class="form-input">
                </div>
            </div>

            <!-- Image Upload or URL -->
            <div style="margin-bottom: 14px; background: #f8fafc; padding: 14px; border-radius: 12px; border: 1px dashed #cbd5e1;">
                <label class="form-label" style="margin-bottom: 6px;">Hero Showcase Photo</label>
                <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 8px;">
                    <img id="edit_preview_img" src="" alt="Preview" style="width: 60px; height: 45px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <div style="flex: 1;">
                        <span style="font-size: 11px; color: #64748b; display: block;">Replace with new file:</span>
                        <input type="file" name="image" accept="image/*" class="form-input" style="padding: 5px;">
                    </div>
                </div>
                <div>
                    <span style="font-size: 11px; color: #64748b; display: block; margin-bottom: 4px;">Or direct image path:</span>
                    <input type="text" id="edit_image_url" name="image_url" class="form-input">
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <label class="form-label" for="edit_summary">Executive Summary <span style="color:#ef4444;">*</span></label>
                <textarea id="edit_summary" name="summary" class="form-input" rows="3" required></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label class="form-label" for="edit_client_name">Client Name(s)</label>
                    <input type="text" id="edit_client_name" name="client_name" class="form-input">
                </div>
                <div>
                    <label class="form-label" for="edit_quote">Client Testimonial Quote</label>
                    <input type="text" id="edit_quote" name="quote" class="form-input">
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label class="form-label" for="edit_services_input">
                    Delivered Services Breakdown
                    <small style="color: #64748b; font-weight: normal;">(One item per line, formatted as "Service: Vendor")</small>
                </label>
                <textarea id="edit_services_input" name="services_input" class="form-input" rows="3"></textarea>
            </div>

            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 20px; flex-wrap: wrap;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer; font-weight: 600;">
                    <input type="checkbox" id="edit_is_featured_home" name="is_featured_home" value="1" style="accent-color: var(--primary);">
                    <span>Feature on Homepage Horizontal Carousel</span>
                </label>
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer; font-weight: 600;">
                    <input type="checkbox" id="edit_is_active" name="is_active" value="1" style="accent-color: var(--primary);">
                    <span>Active Published</span>
                </label>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeEditModal()" class="btn btn-neutral" style="padding: 10px 20px; border-radius: 14px; font-weight: 700;">Cancel</button>
                <button type="submit" class="btn btn-primary" style="padding: 10px 24px; border-radius: 14px; font-weight: 700;">
                    <i class="fas fa-save"></i> Update Celebration
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openCreateModal() {
        document.getElementById('createModal').style.display = 'flex';
    }

    function closeCreateModal() {
        document.getElementById('createModal').style.display = 'none';
    }

    async function autoFillFromBooking(bookingId) {
        const statusBadge = document.getElementById('autofill_status_badge');
        if (!bookingId) {
            if (statusBadge) statusBadge.style.display = 'none';
            return;
        }

        try {
            if (statusBadge) {
                statusBadge.style.display = 'inline-flex';
                statusBadge.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Fetching booking dossier...';
                statusBadge.style.color = '#0284c7';
            }

            const res = await fetch(`/admin/portfolio/booking-data/${encodeURIComponent(bookingId)}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!res.ok) {
                throw new Error(`Failed to load booking: ${res.statusText}`);
            }

            const data = await res.json();

            // Populate fields
            document.getElementById('create_booking_id').value = data.booking_id || '';
            if (data.event_type_id) {
                document.getElementById('create_event_type_id').value = data.event_type_id;
            }
            if (data.title) document.getElementById('create_title').value = data.title;
            if (data.category_tag) {
                document.getElementById('create_category_tag').value = data.category_tag;
            }
            if (data.category_label) document.getElementById('create_category_label').value = data.category_label;
            if (data.venue) document.getElementById('create_venue').value = data.venue;
            if (data.event_date) document.getElementById('create_event_date').value = data.event_date;
            if (data.guests_count) document.getElementById('create_guests_count').value = data.guests_count;
            if (data.client_name) document.getElementById('create_client_name').value = data.client_name;
            if (data.tagline) document.getElementById('create_tagline').value = data.tagline;
            if (data.summary) document.getElementById('create_summary').value = data.summary;
            if (data.quote) document.getElementById('create_quote').value = data.quote;
            if (data.services_input) document.getElementById('create_services_input').value = data.services_input;

            if (statusBadge) {
                statusBadge.style.display = 'inline-flex';
                statusBadge.innerHTML = '<i class="fas fa-check-circle" style="color: #16a34a;"></i> <span>Booking details auto-filled! Please upload or supply a hero showcase photo below.</span>';
                statusBadge.style.color = '#15803d';
            }
        } catch (err) {
            console.error(err);
            if (statusBadge) {
                statusBadge.style.display = 'inline-flex';
                statusBadge.innerHTML = `<i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i> <span style="color: #b91c1c;">Could not load booking details: ${err.message}</span>`;
            }
        }
    }

    function openEditModal(cs) {
        const form = document.getElementById('editForm');
        form.action = `/admin/portfolio/${cs.id}`;

        document.getElementById('edit_booking_id').value = cs.booking_id || '';
        document.getElementById('edit_title').value = cs.title || '';
        document.getElementById('edit_category_tag').value = cs.category_tag || 'wedding';
        document.getElementById('edit_category_label').value = cs.category_label || '';
        document.getElementById('edit_venue').value = cs.venue || '';
        document.getElementById('edit_event_date').value = cs.event_date || '';
        document.getElementById('edit_guests_count').value = cs.guests_count || 150;
        document.getElementById('edit_tagline').value = cs.tagline || '';
        document.getElementById('edit_image_url').value = cs.image_url || '';
        document.getElementById('edit_preview_img').src = cs.image_url ? (cs.image_url.startsWith('http') ? cs.image_url : '/' + cs.image_url) : 'https://images.unsplash.com/photo-1519741497674-611481863552?w=200';
        document.getElementById('edit_summary').value = cs.summary || '';
        document.getElementById('edit_client_name').value = cs.client_name || '';
        document.getElementById('edit_quote').value = cs.quote || '';

        document.getElementById('edit_is_featured_home').checked = !!cs.is_featured_home;
        document.getElementById('edit_is_active').checked = !!cs.is_active;

        // Parse services object to lines
        let servicesText = '';
        if (cs.services_delivered && typeof cs.services_delivered === 'object') {
            servicesText = Object.entries(cs.services_delivered).map(([k, v]) => `${k}: ${v}`).join('\n');
        }
        document.getElementById('edit_services_input').value = servicesText;

        document.getElementById('editModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Close on outside click
    window.addEventListener('click', function(e) {
        const createModal = document.getElementById('createModal');
        const editModal = document.getElementById('editModal');
        if (e.target === createModal) closeCreateModal();
        if (e.target === editModal) closeEditModal();
    });

    // Auto-open modal if autofill_booking parameter is present in URL
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const autofillBooking = urlParams.get('autofill_booking');
        if (autofillBooking) {
            openCreateModal();
            const select = document.getElementById('autofill_booking_select');
            if (select) {
                select.value = autofillBooking;
            }
            autoFillFromBooking(autofillBooking);
        }
    });
</script>
@endpush
@endsection
