@extends('layouts.admin', ['activePage' => 'event_types', 'title' => 'Event Types & Services - EVENTFLARE Admin Console'])

@section('content')
<div class="dashboard-header" style="margin-bottom: 24px;">
    <div class="dashboard-title">
        <h1 style="font-size: 26px; font-weight: 900; color: var(--text-heading); display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-layer-group" style="color: var(--primary);"></i> Event Categories & Services Catalog
        </h1>
        <p style="color: var(--text-muted); font-size: 13px; margin: 4px 0 0;">
            Manage celebratory offerings, service pipelines, vendor accreditation, and celebration parameters.
        </p>
    </div>
</div>

<!-- Top KPI Summary Bar -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="glass-card" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #e0e7ff; color: #4338ca; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-cubes"></i>
        </div>
        <div>
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Categories</span>
            <div style="font-size: 22px; font-weight: 900; color: var(--text-heading); line-height: 1.2;">
                {{ $stats['total_categories'] ?? count($eventTypes) }}
            </div>
            <small style="font-size: 11px; color: #16a34a; font-weight: 700;">
                {{ $stats['active_categories'] ?? $eventTypes->where('is_active', true)->count() }} Active
                @if(($stats['archived_categories'] ?? 0) > 0)
                    · <span style="color: #dc2626;">{{ $stats['archived_categories'] }} Archived</span>
                @endif
            </small>
        </div>
    </div>

    <div class="glass-card" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-list-check"></i>
        </div>
        <div>
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Catalog Services</span>
            <div style="font-size: 22px; font-weight: 900; color: var(--text-heading); line-height: 1.2;">
                {{ $stats['total_services'] ?? 0 }}
            </div>
            <small style="font-size: 11px; color: var(--text-muted);">Configured pipelines</small>
        </div>
    </div>

    <div class="glass-card" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #fef2f2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-shield-halved"></i>
        </div>
        <div>
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Mandatory Core</span>
            <div style="font-size: 22px; font-weight: 900; color: var(--text-heading); line-height: 1.2;">
                {{ $stats['mandatory_services'] ?? 0 }}
            </div>
            <small style="font-size: 11px; color: #dc2626; font-weight: 700;">Required for reservation</small>
        </div>
    </div>

    <div class="glass-card" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        @php
            $shortageCount = 0;
            foreach($eventTypes as $et) {
                foreach($et->services as $s) {
                    if (($s->suppliers_count ?? 0) === 0) {
                        $shortageCount++;
                    }
                }
            }
        @endphp
        <div style="width: 48px; height: 48px; border-radius: 12px; background: {{ $shortageCount > 0 ? '#fffbeb' : '#f0fdf4' }}; color: {{ $shortageCount > 0 ? '#d97706' : '#16a34a' }}; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas {{ $shortageCount > 0 ? 'fa-triangle-exclamation' : 'fa-circle-check' }}"></i>
        </div>
        <div>
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Supply Health</span>
            <div style="font-size: 22px; font-weight: 900; color: {{ $shortageCount > 0 ? '#d97706' : '#16a34a' }}; line-height: 1.2;">
                {{ $shortageCount > 0 ? $shortageCount . ' Shortages' : '100% Covered' }}
            </div>
            <small style="font-size: 11px; color: var(--text-muted);">
                {{ $shortageCount > 0 ? 'Services without vendors' : 'All services have vendors' }}
            </small>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- SECOND PRIORITY: SHORTAGE TOOLBAR & SEARCH -->
<!-- ========================================== -->
<div class="glass-card" style="padding: 14px 20px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
    <!-- Filter Segmented Buttons -->
    <div style="display: inline-flex; background: #f1f5f9; border-radius: 30px; padding: 4px; gap: 4px; border: 1px solid #e2e8f0;">
        <button type="button" id="filterBtnAll" class="filter-pill-btn" onclick="setCatalogFilter('all')" style="border: none; background: #ffffff; color: var(--text-heading); font-size: 12px; font-weight: 800; padding: 6px 16px; border-radius: 20px; cursor: pointer; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
            <i class="fas fa-layer-group" style="color: var(--primary);"></i> All Services 
            <span style="background: #e2e8f0; padding: 1px 7px; border-radius: 10px; font-size: 10px;">{{ $stats['total_services'] }}</span>
        </button>
        <button type="button" id="filterBtnShortage" class="filter-pill-btn" onclick="setCatalogFilter('shortages')" style="border: none; background: transparent; color: #64748b; font-size: 12px; font-weight: 800; padding: 6px 16px; border-radius: 20px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
            <i class="fas fa-triangle-exclamation" style="color: #d97706;"></i> Supply Shortages Only 
            <span id="shortageBadgeCount" style="background: {{ $shortageCount > 0 ? '#fef3c7' : '#e2e8f0' }}; color: {{ $shortageCount > 0 ? '#b45309' : '#64748b' }}; padding: 1px 7px; border-radius: 10px; font-size: 10px; font-weight: 800;">
                {{ $shortageCount }}
            </span>
        </button>
    </div>

    <!-- Live Search Input -->
    <div style="position: relative; width: 100%; max-width: 320px;">
        <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px;"></i>
        <input type="text" id="catalogSearchInput" oninput="searchCatalog(this.value)" placeholder="Search service or category..." class="form-input" style="padding-left: 36px; font-size: 12px; height: 38px; border-radius: 20px; background: #ffffff;">
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">
    <!-- Left: Event Categories & Services Tree -->
    <div id="categoriesContainer" style="display: flex; flex-direction: column; gap: 20px;">
        @foreach($eventTypes as $et)
            <div class="glass-card category-card-block" data-category="{{ strtolower($et->type_name) }}" style="padding: 24px; border-left: 4px solid {{ $et->is_active ? 'var(--primary)' : '#94a3b8' }};">
                <!-- Category Card Header -->
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px; gap: 16px;">
                    <div style="display: flex; gap: 16px; align-items: center;">
                        <!-- Category Image Thumbnail / Preview -->
                        <div style="position: relative; width: 68px; height: 68px; border-radius: 14px; overflow: hidden; background: #e2e8f0; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: 2px solid #ffffff;">
                            @if($et->image_display_url)
                                <img src="{{ $et->image_display_url }}" alt="{{ $et->type_name }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1511578314322-379afb476865?w=200';">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--primary), #818cf8); color: #ffffff; font-size: 24px;">
                                    <i class="fas fa-sparkles"></i>
                                </div>
                            @endif
                        </div>

                        <div>
                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                <h3 style="font-size: 19px; font-weight: 800; color: var(--text-heading); margin: 0;">{{ $et->type_name }}</h3>
                                <span style="font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px; background: {{ $et->is_active ? '#dcfce7' : '#fee2e2' }}; color: {{ $et->is_active ? '#15803d' : '#b91c1c' }};">
                                    {{ $et->is_active ? 'Active' : 'Archived' }}
                                </span>
                            </div>
                            <p style="font-size: 13px; color: var(--text-muted); margin: 4px 0 0; max-width: 520px; line-height: 1.4;">
                                {{ $et->description ?: 'No category description provided.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Category Action Buttons (Toggle, Edit, Delete) -->
                    <div style="display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                        <!-- Toggle Active/Archived Form -->
                        <form method="POST" action="{{ route('admin.event-types.toggle', $et->event_type_id) }}" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline" style="border: 1px solid {{ $et->is_active ? '#cbd5e1' : '#bbf7d0' }}; color: {{ $et->is_active ? '#64748b' : '#15803d' }}; padding: 5px 10px; font-size: 11px; border-radius: 12px; font-weight: 700;" title="{{ $et->is_active ? 'Archive this category' : 'Publish & activate this category' }}">
                                <i class="fas {{ $et->is_active ? 'fa-eye-slash' : 'fa-check' }}"></i> {{ $et->is_active ? 'Archive' : 'Activate' }}
                            </button>
                        </form>

                        <!-- Edit Category Button -->
                        <button type="button" class="btn btn-outline" style="border: 1px solid #c7d2fe; color: #4338ca; padding: 5px 10px; font-size: 11px; border-radius: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;" onclick="openEditCategoryModal({{ json_encode($et) }})">
                            <i class="fas fa-pen-to-square"></i> Edit
                        </button>

                        <!-- Delete Category Form -->
                        <form method="POST" action="{{ route('admin.event-types.destroy', $et->event_type_id) }}" style="display: inline;" onsubmit="return confirm('Permanently remove category \'{{ $et->type_name }}\'? Note: This action is blocked if active bookings or services exist.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline" style="border: 1px solid #fee2e2; color: #ef4444; padding: 5px 8px; font-size: 11px; border-radius: 12px;" title="Delete category">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Accredited Services Pipeline -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <strong style="font-size: 12px; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">
                            Accredited Service Pipeline ({{ $et->services->count() }})
                        </strong>
                        <span style="font-size: 11px; color: var(--text-muted);">
                            Ordered by priority execution rank
                        </span>
                    </div>

                    <div class="services-list-wrapper" style="display: flex; flex-direction: column; gap: 8px;">
                        @forelse($et->services as $srv)
                            @php
                                $hasShortage = (($srv->suppliers_count ?? 0) === 0);
                            @endphp
                            <div class="service-row-item" 
                                 data-service="{{ strtolower($srv->service_name) }}" 
                                 data-category="{{ strtolower($et->type_name) }}" 
                                 data-notes="{{ strtolower($srv->notes ?? '') }}"
                                 data-shortage="{{ $hasShortage ? '1' : '0' }}"
                                 style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 13px; gap: 12px; transition: all 0.2s;">
                                
                                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    <span style="font-size: 11px; font-weight: 800; background: #e2e8f0; color: #475569; padding: 2px 7px; border-radius: 8px;" title="Execution Rank">
                                        #{{ $srv->priority_rank }}
                                    </span>
                                    <span style="font-weight: 700; color: var(--text-heading);">{{ $srv->service_name }}</span>

                                    @if($srv->is_required)
                                        <span style="font-size: 10px; background: #fee2e2; color: #dc2626; padding: 1px 7px; border-radius: 8px; font-weight: 800;">
                                            Mandatory
                                        </span>
                                    @endif

                                    @if($srv->typical_capacity)
                                        <span style="font-size: 11px; color: #64748b; background: #ffffff; padding: 1px 6px; border-radius: 6px; border: 1px solid #e2e8f0;" title="Typical guest capacity">
                                            <i class="fas fa-users fa-xs" style="color: var(--primary);"></i> {{ $srv->typical_capacity }} pax
                                        </span>
                                    @endif

                                    <!-- Market Pricing Guide -->
                                    @if($srv->min_price)
                                        <span style="font-size: 11px; font-weight: 700; color: #4338ca; background: #e0e7ff; padding: 2px 7px; border-radius: 8px; border: 1px solid #c7d2fe;" title="Market Pricing: LKR {{ number_format($srv->min_price) }} to {{ number_format($srv->max_price) }} (Avg: LKR {{ number_format($srv->avg_price) }})">
                                            <i class="fas fa-tag fa-xs"></i> LKR {{ number_format($srv->min_price) }} - {{ number_format($srv->max_price) }}
                                        </span>
                                    @endif

                                    <!-- Interactive Vendor Coverage & Shortage Buttons -->
                                    @if(!$hasShortage)
                                        <button type="button" class="btn btn-outline" 
                                                onclick="openServiceVendorsModal({{ json_encode($srv) }}, '{{ addslashes($et->type_name) }}')" 
                                                style="border: 1px solid #bbf7d0; background: #ecfdf5; color: #047857; font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 10px; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;" 
                                                title="Click to inspect accredited vendors and package pricing">
                                            <i class="fas fa-store fa-xs"></i> {{ $srv->suppliers_count }} {{ Str::plural('Vendor', $srv->suppliers_count) }} ({{ $srv->listings_count }} pkgs)
                                            <i class="fas fa-chevron-right fa-xs" style="opacity: 0.6; margin-left: 2px;"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-outline" 
                                                onclick="openQuickAssignModal({{ $srv->service_id }}, '{{ addslashes($srv->service_name) }}', '{{ addslashes($et->type_name) }}')" 
                                                style="border: 1px solid #fde68a; background: #fffbeb; color: #b45309; font-size: 11px; font-weight: 800; padding: 3px 9px; border-radius: 10px; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; box-shadow: 0 1px 4px rgba(217, 119, 6, 0.15);" 
                                                title="Supply Deficit! Click to accredit a vendor immediately">
                                            <i class="fas fa-triangle-exclamation fa-xs" style="color: #d97706;"></i> 0 Vendors (Click to Fix)
                                            <i class="fas fa-plus fa-xs" style="margin-left: 2px;"></i>
                                        </button>
                                    @endif
                                </div>

                                <!-- Service Actions: Edit & Delete -->
                                <div style="display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                                    <button type="button" class="btn btn-outline" style="border: 1px solid #e2e8f0; color: #475569; padding: 3px 8px; font-size: 11px; border-radius: 8px;" onclick="openEditServiceModal({{ json_encode($srv) }})" title="Edit Service">
                                        <i class="fas fa-pencil"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.services.destroy', $srv->service_id) }}" style="display: inline;" onsubmit="return confirm('Remove service \'{{ $srv->service_name }}\' from catalog?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline" style="border: 1px solid #fee2e2; color: #ef4444; padding: 3px 8px; font-size: 11px; border-radius: 8px;" title="Delete Service">
                                            <i class="fas fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p style="font-size: 12px; color: var(--text-muted); margin: 0; padding: 8px;">No services linked to this category yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Right: Add Event Category & Service Forms -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Add Category Form with Image Upload & Preview -->
        <div class="glass-card" style="padding: 22px;">
            <h3 style="font-size: 16px; font-weight: 800; color: var(--text-heading); margin-bottom: 14px; display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-folder-plus" style="color: var(--primary);"></i> Add Event Category
            </h3>
            <form method="POST" action="{{ route('admin.event-types.store') }}" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 12px;">
                    <label class="form-label" for="type_name">Category Name <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="type_name" name="type_name" class="form-input" required placeholder="e.g. Corporate Galas & Summits">
                </div>

                <div style="margin-bottom: 12px;">
                    <label class="form-label" for="cat_desc">Description</label>
                    <textarea id="cat_desc" name="description" class="form-input" rows="2" placeholder="Overview of celebratory offering..."></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                    <div>
                        <label class="form-label" for="add_badge">Card Badge Label</label>
                        <input type="text" id="add_badge" name="badge" class="form-input" placeholder="e.g. Royal Weddings">
                    </div>
                    <div>
                        <label class="form-label" for="add_accent_color">Accent Color</label>
                        <input type="text" id="add_accent_color" name="accent_color" class="form-input" placeholder="#ec4899">
                    </div>
                </div>

                <div style="margin-bottom: 12px;">
                    <label class="form-label" for="add_chips">Feature Chips (comma separated)</label>
                    <input type="text" id="add_chips" name="chips" class="form-input" placeholder="e.g. Poruwa Rituals, 4K Cinema Drone, Ves Dancers">
                </div>

                <div style="margin-bottom: 12px;">
                    <label class="form-label" for="add_vendor_count_label">Vendor Highlights Label</label>
                    <input type="text" id="add_vendor_count_label" name="vendor_count_label" class="form-input" placeholder="e.g. 120+ Curated Vendors">
                </div>

                <!-- Category Image Upload & Preview -->
                <div style="margin-bottom: 12px; background: #f8fafc; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <label class="form-label" style="margin-bottom: 6px; display: block;">
                        <i class="fas fa-image" style="color: var(--primary); margin-right: 4px;"></i> Category Image / Banner
                    </label>

                    <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 8px;">
                        <div id="add_cat_img_box" style="width: 54px; height: 54px; border-radius: 10px; background: #e2e8f0; overflow: hidden; display: flex; align-items: center; justify-content: center; color: #94a3b8; flex-shrink: 0; border: 1px solid #cbd5e1;">
                            <i class="fas fa-image fa-lg"></i>
                        </div>
                        <div style="flex: 1;">
                            <input type="file" name="image" id="add_cat_image_file" class="form-input" accept="image/*" style="font-size: 11px; padding: 4px;" onchange="previewUploadImage(this, 'add_cat_img_box')">
                            <small style="color: #64748b; font-size: 10px; display: block; margin-top: 2px;">JPG, PNG, WebP up to 4MB</small>
                        </div>
                    </div>

                    <input type="url" name="image_url" class="form-input" placeholder="Or enter direct image URL (https://...)" style="font-size: 12px;">
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" checked style="accent-color: var(--primary);">
                        <span>Publish immediately (Active)</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px; border-radius: 20px; font-weight: 700; font-size: 13px;">
                    <i class="fas fa-plus"></i> Create Category
                </button>
            </form>
        </div>

        <!-- Add Service Form -->
        <div class="glass-card" style="padding: 22px;">
            <h3 style="font-size: 16px; font-weight: 800; color: var(--text-heading); margin-bottom: 14px; display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-plus-circle" style="color: var(--primary);"></i> Add Service Item
            </h3>
            <form method="POST" action="{{ route('admin.services.store') }}">
                @csrf
                <div style="margin-bottom: 12px;">
                    <label class="form-label" for="srv_event_type_id">Category <span style="color:#ef4444;">*</span></label>
                    <select id="srv_event_type_id" name="event_type_id" class="form-input" required>
                        @foreach($eventTypes as $et)
                            <option value="{{ $et->event_type_id }}">{{ $et->type_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 12px;">
                    <label class="form-label" for="service_name">Service Name <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="service_name" name="service_name" class="form-input" required placeholder="e.g. Traditional Dancers & Drummers">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                    <div>
                        <label class="form-label" for="priority_rank">Priority Rank <span style="color:#ef4444;">*</span></label>
                        <input type="number" id="priority_rank" name="priority_rank" class="form-input" value="1" min="1" required>
                    </div>
                    <div>
                        <label class="form-label" for="typical_capacity">Typical Pax</label>
                        <input type="number" id="typical_capacity" name="typical_capacity" class="form-input" placeholder="e.g. 250" min="1">
                    </div>
                </div>

                <div style="margin-bottom: 12px;">
                    <label class="form-label" for="notes">Operational Notes</label>
                    <input type="text" id="notes" name="notes" class="form-input" placeholder="e.g. Advance lead time of 3 weeks required">
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer;">
                        <input type="checkbox" name="is_required" value="1" style="accent-color: var(--primary);">
                        <span>Mandatory core service</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-secondary" style="width: 100%; padding: 10px; border-radius: 20px; font-weight: 700; font-size: 13px;">
                    <i class="fas fa-plus"></i> Add Service
                </button>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- SECOND PRIORITY MODAL: ACCREDITED VENDORS DRILLDOWN & MANAGER  -->
<!-- ============================================================== -->
<div id="serviceVendorsModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div class="glass-card" style="width: 100%; max-width: 680px; background: #ffffff; border-radius: 20px; padding: 28px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative; max-height: 90vh; overflow-y: auto;">
        <button type="button" onclick="closeServiceVendorsModal()" style="position: absolute; top: 20px; right: 20px; background: transparent; border: none; font-size: 18px; color: #94a3b8; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>

        <div style="margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px;">
            <span id="svm_category_badge" style="font-size: 11px; font-weight: 800; background: #e0e7ff; color: #4338ca; padding: 2px 8px; border-radius: 10px; text-transform: uppercase; letter-spacing: 0.5px;"></span>
            <h3 id="svm_service_title" style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin: 6px 0 2px 0;"></h3>
            <p style="font-size: 12px; color: var(--text-muted); margin: 0;">
                Suppliers accredited to provide this service line for celebration reservations.
            </p>
        </div>

        <!-- Table of Accredited Suppliers -->
        <div style="margin-bottom: 24px; overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid #e2e8f0; color: var(--text-muted); font-size: 11px; text-transform: uppercase;">
                        <th style="padding: 10px 12px;">Vendor Business</th>
                        <th style="padding: 10px 12px;">Contact</th>
                        <th style="padding: 10px 12px;">Active Packages</th>
                        <th style="padding: 10px 12px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody id="svm_suppliers_tbody">
                    <!-- Populated dynamically via JS -->
                </tbody>
            </table>
        </div>

        <!-- Quick Accredit Another Vendor Form -->
        <div style="background: #f8fafc; padding: 18px; border-radius: 14px; border: 1px solid #e2e8f0;">
            <h4 style="font-size: 14px; font-weight: 800; color: var(--text-heading); margin: 0 0 10px 0; display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-user-plus" style="color: var(--primary);"></i> Accredit Another Supplier to this Service
            </h4>
            <form id="svm_accredit_form" method="POST" action="" style="display: flex; gap: 10px; align-items: center;">
                @csrf
                <div style="flex: 1;">
                    <select name="supplier_id" id="svm_supplier_select" class="form-input" required style="font-size: 13px;">
                        <option value="">-- Choose registered vendor --</option>
                        @foreach($allSuppliers as $sup)
                            <option value="{{ $sup->id }}">{{ $sup->business_name }} ({{ $sup->contact_person ?? $sup->user->fullname }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 9px 18px; border-radius: 12px; font-weight: 700; font-size: 12px; white-space: nowrap;">
                    <i class="fas fa-check"></i> Accredit Vendor
                </button>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- SECOND PRIORITY MODAL: QUICK ASSIGN TO RESOLVE SHORTAGE        -->
<!-- ============================================================== -->
<div id="quickAssignVendorModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div class="glass-card" style="width: 100%; max-width: 480px; background: #ffffff; border-radius: 20px; padding: 28px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative;">
        <button type="button" onclick="closeQuickAssignModal()" style="position: absolute; top: 20px; right: 20px; background: transparent; border: none; font-size: 18px; color: #94a3b8; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>

        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                <i class="fas fa-bolt"></i>
            </div>
            <div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--text-heading); margin: 0;">Resolve Supply Deficit</h3>
                <small style="color: var(--text-muted);">Quick-accredit an existing vendor</small>
            </div>
        </div>

        <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; padding: 12px 14px; margin-bottom: 18px; font-size: 13px; color: #92400e;">
            Currently <strong>0 vendors</strong> offer <span id="qam_service_title" style="font-weight: 800;"></span> under <span id="qam_category_title" style="font-weight: 800;"></span>.
        </div>

        <form id="quickAssignForm" method="POST" action="">
            @csrf
            <div style="margin-bottom: 16px;">
                <label class="form-label" for="qam_supplier_id" style="font-weight: 700;">Select Platform Vendor to Accredit <span style="color:#ef4444;">*</span></label>
                <select name="supplier_id" id="qam_supplier_id" class="form-input" required style="font-size: 13px;">
                    <option value="">-- Choose vendor to accredit --</option>
                    @foreach($allSuppliers as $sup)
                        <option value="{{ $sup->id }}">{{ $sup->business_name }} ({{ $sup->contact_person ?? $sup->user->fullname }})</option>
                    @endforeach
                </select>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                <a href="{{ route('admin.suppliers.index') }}" style="font-size: 12px; color: var(--primary); text-decoration: none; font-weight: 700;">
                    <i class="fas fa-user-plus"></i> Onboard New Vendor
                </a>
                <div style="display: flex; gap: 8px;">
                    <button type="button" class="btn btn-outline" onclick="closeQuickAssignModal()" style="border-radius: 20px; padding: 8px 16px; font-size: 12px; font-weight: 700;">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" style="border-radius: 20px; padding: 8px 20px; font-size: 12px; font-weight: 700;">
                        <i class="fas fa-check"></i> Accredit Now
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: EDIT CATEGORY (INCLUDING IMAGE EDIT) -->
<!-- ========================================== -->
<div id="editCategoryModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div class="glass-card" style="width: 100%; max-width: 520px; background: #ffffff; border-radius: 20px; padding: 28px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative; max-height: 90vh; overflow-y: auto;">
        <button type="button" onclick="closeEditCategoryModal()" style="position: absolute; top: 20px; right: 20px; background: transparent; border: none; font-size: 18px; color: #94a3b8; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>

        <h3 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-top: 0; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-pen-to-square" style="color: var(--primary);"></i> Edit Event Category
        </h3>
        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 20px;">
            Update category title, description, and promotional banner image.
        </p>

        <form id="editCategoryForm" method="POST" action="" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 14px;">
                <label class="form-label" for="edit_type_name">Category Name <span style="color:#ef4444;">*</span></label>
                <input type="text" id="edit_type_name" name="type_name" class="form-input" required>
            </div>

            <div style="margin-bottom: 14px;">
                <label class="form-label" for="edit_description">Description</label>
                <textarea id="edit_description" name="description" class="form-input" rows="3"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 14px;">
                <div>
                    <label class="form-label" for="edit_badge">Card Badge Label</label>
                    <input type="text" id="edit_badge" name="badge" class="form-input" placeholder="e.g. Royal Weddings">
                </div>
                <div>
                    <label class="form-label" for="edit_accent_color">Accent Color</label>
                    <input type="text" id="edit_accent_color" name="accent_color" class="form-input" placeholder="#ec4899">
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <label class="form-label" for="edit_chips">Feature Chips (comma separated)</label>
                <input type="text" id="edit_chips" name="chips" class="form-input" placeholder="e.g. Poruwa Rituals, 4K Drone, Ves Dancers">
            </div>

            <div style="margin-bottom: 14px;">
                <label class="form-label" for="edit_vendor_count_label">Vendor Highlights Label</label>
                <input type="text" id="edit_vendor_count_label" name="vendor_count_label" class="form-input" placeholder="e.g. 120+ Curated Vendors">
            </div>

            <!-- IMAGE EDIT PART -->
            <div style="margin-bottom: 16px; background: #f8fafc; padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0;">
                <label class="form-label" style="margin-bottom: 8px; display: block; font-weight: 700;">
                    <i class="fas fa-camera" style="color: var(--primary); margin-right: 4px;"></i> Category Image & Banner
                </label>

                <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 10px;">
                    <!-- Current / Preview Thumbnail -->
                    <div id="edit_cat_img_preview" style="width: 72px; height: 72px; border-radius: 12px; background: #e2e8f0; overflow: hidden; display: flex; align-items: center; justify-content: center; color: #94a3b8; flex-shrink: 0; border: 2px solid #cbd5e1; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                        <i class="fas fa-image fa-2x"></i>
                    </div>

                    <div style="flex: 1;">
                        <label style="font-size: 11px; font-weight: 700; color: #475569; display: block; margin-bottom: 3px;">Upload New Image</label>
                        <input type="file" name="image" id="edit_cat_image_file" class="form-input" accept="image/*" style="font-size: 11px; padding: 5px;" onchange="previewUploadImage(this, 'edit_cat_img_preview')">
                        <small style="color: #64748b; font-size: 10px; display: block; margin-top: 2px;">Recommended: 1200x800px landscape</small>
                    </div>
                </div>

                <div>
                    <label style="font-size: 11px; font-weight: 700; color: #475569; display: block; margin-bottom: 3px;">Or Existing Image URL</label>
                    <input type="url" id="edit_image_url" name="image_url" class="form-input" placeholder="https://images.unsplash.com/..." style="font-size: 12px;" oninput="previewUrlImage(this.value, 'edit_cat_img_preview')">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer;">
                    <input type="checkbox" id="edit_is_active" name="is_active" value="1" style="accent-color: var(--primary);">
                    <span>Category is Active & Visible in Booking Portal</span>
                </label>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn btn-outline" onclick="closeEditCategoryModal()" style="border-radius: 20px; padding: 8px 18px; font-weight: 700; font-size: 13px;">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" style="border-radius: 20px; padding: 8px 22px; font-weight: 700; font-size: 13px;">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: EDIT SERVICE SPECIFICATION          -->
<!-- ========================================== -->
<div id="editServiceModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div class="glass-card" style="width: 100%; max-width: 520px; background: #ffffff; border-radius: 20px; padding: 28px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative; max-height: 90vh; overflow-y: auto;">
        <button type="button" onclick="closeEditServiceModal()" style="position: absolute; top: 20px; right: 20px; background: transparent; border: none; font-size: 18px; color: #94a3b8; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>

        <h3 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-top: 0; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-sliders" style="color: var(--primary);"></i> Edit Service Specification
        </h3>
        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 20px;">
            Update priority ranking, mandatory flags, and operational pax rules.
        </p>

        <form id="editServiceForm" method="POST" action="">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 14px;">
                <label class="form-label" for="edit_srv_event_type_id">Belongs To Category <span style="color:#ef4444;">*</span></label>
                <select id="edit_srv_event_type_id" name="event_type_id" class="form-input" required>
                    @foreach($eventTypes as $et)
                        <option value="{{ $et->event_type_id }}">{{ $et->type_name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 14px;">
                <label class="form-label" for="edit_srv_name">Service Name <span style="color:#ef4444;">*</span></label>
                <input type="text" id="edit_srv_name" name="service_name" class="form-input" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                <div>
                    <label class="form-label" for="edit_srv_priority">Priority Rank <span style="color:#ef4444;">*</span></label>
                    <input type="number" id="edit_srv_priority" name="priority_rank" class="form-input" min="1" required>
                </div>
                <div>
                    <label class="form-label" for="edit_srv_capacity">Typical Capacity (Pax)</label>
                    <input type="number" id="edit_srv_capacity" name="typical_capacity" class="form-input" min="1" placeholder="e.g. 250">
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <label class="form-label" for="edit_srv_notes">Operational Notes</label>
                <input type="text" id="edit_srv_notes" name="notes" class="form-input" placeholder="e.g. Coordinate timing with choir">
            </div>

            <div style="margin-bottom: 14px;">
                <label class="form-label" for="edit_srv_desc">Service Description</label>
                <textarea id="edit_srv_desc" name="description" class="form-input" rows="2"></textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer;">
                    <input type="checkbox" id="edit_srv_required" name="is_required" value="1" style="accent-color: var(--primary);">
                    <span>Mandatory core service (Customer cannot uncheck this)</span>
                </label>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn btn-outline" onclick="closeEditServiceModal()" style="border-radius: 20px; padding: 8px 18px; font-weight: 700; font-size: 13px;">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" style="border-radius: 20px; padding: 8px 22px; font-weight: 700; font-size: 13px;">
                    <i class="fas fa-save"></i> Update Service
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentFilterMode = 'all';

    // Preview local image upload
    function previewUploadImage(input, targetContainerId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.getElementById(targetContainerId);
                container.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Preview URL image input
    function previewUrlImage(url, targetContainerId) {
        if (url && url.startsWith('http')) {
            const container = document.getElementById(targetContainerId);
            container.innerHTML = `<img src="${url}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.parentElement.innerHTML='<i class=\\'fas fa-image fa-2x\\'></i>'">`;
        }
    }

    // Filter by 'all' or 'shortages'
    function setCatalogFilter(mode) {
        currentFilterMode = mode;
        const btnAll = document.getElementById('filterBtnAll');
        const btnShortage = document.getElementById('filterBtnShortage');

        if (mode === 'shortages') {
            btnShortage.style.background = '#ffffff';
            btnShortage.style.color = 'var(--text-heading)';
            btnShortage.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
            btnAll.style.background = 'transparent';
            btnAll.style.color = '#64748b';
            btnAll.style.boxShadow = 'none';
        } else {
            btnAll.style.background = '#ffffff';
            btnAll.style.color = 'var(--text-heading)';
            btnAll.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
            btnShortage.style.background = 'transparent';
            btnShortage.style.color = '#64748b';
            btnShortage.style.boxShadow = 'none';
        }

        applyCatalogFilters();
    }

    // Live search in catalog
    function searchCatalog() {
        applyCatalogFilters();
    }

    // Combined filter function
    function applyCatalogFilters() {
        const query = (document.getElementById('catalogSearchInput').value || '').toLowerCase().trim();
        const categoryBlocks = document.querySelectorAll('.category-card-block');

        categoryBlocks.forEach(catCard => {
            const catName = catCard.dataset.category || '';
            const serviceRows = catCard.querySelectorAll('.service-row-item');
            let visibleServiceCount = 0;

            serviceRows.forEach(row => {
                const srvName = row.dataset.service || '';
                const notes = row.dataset.notes || '';
                const isShortage = (row.dataset.shortage === '1');

                const matchesFilter = (currentFilterMode === 'all') || (currentFilterMode === 'shortages' && isShortage);
                const matchesSearch = !query || srvName.includes(query) || catName.includes(query) || notes.includes(query);

                if (matchesFilter && matchesSearch) {
                    row.style.display = 'flex';
                    visibleServiceCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // If query matches category or category has visible services, keep category block visible
            if (visibleServiceCount > 0 || (!query && currentFilterMode === 'all')) {
                catCard.style.display = 'block';
            } else {
                catCard.style.display = 'none';
            }
        });
    }

    // Second Priority: Open Service Vendors Modal (Drilldown)
    function openServiceVendorsModal(srv, categoryName) {
        document.getElementById('svm_category_badge').innerText = categoryName;
        document.getElementById('svm_service_title').innerText = srv.service_name;

        // Set accredit form action
        document.getElementById('svm_accredit_form').action = `/admin/services/${srv.service_id}/quick-assign`;

        // Populate table
        const tbody = document.getElementById('svm_suppliers_tbody');
        tbody.innerHTML = '';

        const suppliers = srv.suppliers || [];
        if (suppliers.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" style="text-align: center; color: var(--text-muted); padding: 24px;">No accredited suppliers for this service yet.</td></tr>`;
        } else {
            suppliers.forEach(sup => {
                const contact = sup.contact_phone || (sup.user ? sup.user.email : 'N/A');
                const packagesCount = sup.listings_count || (sup.listings ? sup.listings.length : 0);

                const tr = document.createElement('tr');
                tr.style.borderBottom = '1px solid #f1f5f9';
                tr.innerHTML = `
                    <td style="padding: 12px;">
                        <strong style="color: var(--text-heading);">${sup.business_name}</strong>
                        <small style="display: block; color: var(--text-muted);">${sup.category_specialization || 'General Vendor'}</small>
                    </td>
                    <td style="padding: 12px; font-size: 12px; color: #475569;">
                        <div><i class="fas fa-phone fa-xs" style="color: var(--primary); margin-right: 4px;"></i>${sup.contact_phone || 'No phone'}</div>
                        <div style="color: #94a3b8;"><i class="fas fa-envelope fa-xs" style="margin-right: 4px;"></i>${sup.user ? sup.user.email : ''}</div>
                    </td>
                    <td style="padding: 12px;">
                        <span style="background: #e0e7ff; color: #4338ca; font-weight: 700; font-size: 11px; padding: 2px 8px; border-radius: 10px;">
                            ${packagesCount} Available
                        </span>
                    </td>
                    <td style="padding: 12px; text-align: right;">
                        <form method="POST" action="/admin/services/${srv.service_id}/suppliers/${sup.id}" style="display: inline;" onsubmit="return confirm('Remove accreditation for \'${sup.business_name}\' from this service?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline" style="border: 1px solid #fee2e2; color: #ef4444; padding: 4px 8px; font-size: 11px; border-radius: 8px;" title="Remove Accreditation">
                                <i class="fas fa-user-minus"></i> Remove
                            </button>
                        </form>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        document.getElementById('serviceVendorsModal').style.display = 'flex';
    }

    function closeServiceVendorsModal() {
        document.getElementById('serviceVendorsModal').style.display = 'none';
    }

    // Second Priority: Open Quick Assign Shortage Modal
    function openQuickAssignModal(serviceId, serviceName, categoryName) {
        document.getElementById('qam_service_title').innerText = serviceName;
        document.getElementById('qam_category_title').innerText = categoryName;

        const form = document.getElementById('quickAssignForm');
        form.action = `/admin/services/${serviceId}/quick-assign`;

        document.getElementById('quickAssignVendorModal').style.display = 'flex';
    }

    function closeQuickAssignModal() {
        document.getElementById('quickAssignVendorModal').style.display = 'none';
    }

    // Image Preview Handlers for Upload & URL inputs
    function previewUploadImage(input, targetId) {
        const target = document.getElementById(targetId);
        if (!target) return;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                target.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewUrlImage(url, targetId) {
        const target = document.getElementById(targetId);
        if (!target) return;
        if (url && url.trim().length > 0) {
            const resolved = (url.startsWith('http://') || url.startsWith('https://') || url.startsWith('/')) ? url : '/' + url.replace(/^\//, '');
            target.innerHTML = `<img src="${resolved}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\\'fas fa-image fa-2x\\'></i>';">`;
        } else {
            target.innerHTML = `<i class="fas fa-image fa-2x"></i>`;
        }
    }

    // Edit Category Modal Open/Close
    function openEditCategoryModal(et) {
        const modal = document.getElementById('editCategoryModal');
        const form = document.getElementById('editCategoryForm');
        form.action = `/admin/event-types/${et.event_type_id}`;

        document.getElementById('edit_type_name').value = et.type_name || '';
        document.getElementById('edit_description').value = et.description || '';
        document.getElementById('edit_badge').value = et.badge || '';
        document.getElementById('edit_accent_color').value = et.accent_color || '';
        document.getElementById('edit_chips').value = et.chips || '';
        document.getElementById('edit_vendor_count_label').value = et.vendor_count_label || '';
        document.getElementById('edit_image_url').value = et.image_url || '';
        document.getElementById('edit_is_active').checked = Boolean(et.is_active);

        // Reset file input and preview current image
        document.getElementById('edit_cat_image_file').value = '';
        const previewBox = document.getElementById('edit_cat_img_preview');
        const displayImg = et.image_display_url || (et.image_url ? ((et.image_url.startsWith('http://') || et.image_url.startsWith('https://') || et.image_url.startsWith('/')) ? et.image_url : '/' + et.image_url.replace(/^\//, '')) : null);
        if (displayImg) {
            previewBox.innerHTML = `<img src="${displayImg}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\\'fas fa-image fa-2x\\'></i>';">`;
        } else {
            previewBox.innerHTML = `<i class="fas fa-image fa-2x"></i>`;
        }

        modal.style.display = 'flex';
    }

    function closeEditCategoryModal() {
        document.getElementById('editCategoryModal').style.display = 'none';
    }

    // Edit Service Modal Open/Close
    function openEditServiceModal(srv) {
        const modal = document.getElementById('editServiceModal');
        const form = document.getElementById('editServiceForm');
        form.action = `/admin/services/${srv.service_id}`;

        document.getElementById('edit_srv_event_type_id').value = srv.event_type_id;
        document.getElementById('edit_srv_name').value = srv.service_name || '';
        document.getElementById('edit_srv_priority').value = srv.priority_rank || 1;
        document.getElementById('edit_srv_capacity').value = srv.typical_capacity || '';
        document.getElementById('edit_srv_notes').value = srv.notes || '';
        document.getElementById('edit_srv_desc').value = srv.description || '';
        document.getElementById('edit_srv_required').checked = Boolean(srv.is_required);

        modal.style.display = 'flex';
    }

    function closeEditServiceModal() {
        document.getElementById('editServiceModal').style.display = 'none';
    }

    // Close modals on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEditCategoryModal();
            closeEditServiceModal();
            closeServiceVendorsModal();
            closeQuickAssignModal();
        }
    });
</script>
@endsection

