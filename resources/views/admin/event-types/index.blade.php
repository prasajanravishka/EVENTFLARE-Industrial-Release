@extends('layouts.admin', ['activePage' => 'event_types', 'title' => 'Event Types & Services - EVENTFLARE Admin Console'])

@section('content')
<div class="dashboard-header">
    <div class="dashboard-title">
        <h1>Event Categories & Services Catalog</h1>
        <p>Manage core celebratory offerings, service pipelines, and customer booking parameters.</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">
    <!-- Left: Event Categories & Services Tree -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        @foreach($eventTypes as $et)
            <div class="glass-card" style="padding: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                    <div>
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--text-heading); margin: 0;">{{ $et->type_name }}</h3>
                        <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0;">{{ $et->description }}</p>
                    </div>
                    <span style="font-size: 11px; font-weight: 800; padding: 3px 10px; border-radius: 12px; background: {{ $et->is_active ? '#dcfce7' : '#fee2e2' }}; color: {{ $et->is_active ? '#15803d' : '#b91c1c' }};">
                        {{ $et->is_active ? 'Active' : 'Archived' }}
                    </span>
                </div>

                <div style="margin-bottom: 14px;">
                    <strong style="font-size: 12px; text-transform: uppercase; color: var(--text-muted); display: block; margin-bottom: 8px;">Accredited Services ({{ $et->services->count() }})</strong>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        @forelse($et->services as $srv)
                            <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 8px 12px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 13px;">
                                <div>
                                    <span style="font-weight: 700; color: var(--text-heading);">{{ $srv->service_name }}</span>
                                    @if($srv->is_required)
                                        <span style="font-size: 10px; background: #fee2e2; color: #dc2626; padding: 1px 6px; border-radius: 8px; margin-left: 6px; font-weight: 700;">Mandatory</span>
                                    @endif
                                </div>
                                <span style="font-size: 11px; color: var(--text-muted);">Priority #{{ $srv->priority_rank }}</span>
                            </div>
                        @empty
                            <p style="font-size: 12px; color: var(--text-muted); margin: 0;">No services linked to this category yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Right: Add Event Category & Service Forms -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Add Category Form -->
        <div class="glass-card" style="padding: 22px;">
            <h3 style="font-size: 16px; font-weight: 800; color: var(--text-heading); margin-bottom: 14px;">
                <i class="fas fa-plus" style="color: var(--primary); margin-right: 6px;"></i> Add Category
            </h3>
            <form method="POST" action="{{ route('admin.event-types.store') }}">
                @csrf
                <div style="margin-bottom: 12px;">
                    <label class="form-label" for="type_name">Category Name <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="type_name" name="type_name" class="form-input" required placeholder="e.g. Corporate Galas">
                </div>
                <div style="margin-bottom: 12px;">
                    <label class="form-label" for="cat_desc">Description</label>
                    <textarea id="cat_desc" name="description" class="form-input" rows="2" placeholder="Overview of category..."></textarea>
                </div>
                <div style="margin-bottom: 16px;">
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" checked style="accent-color: var(--primary);">
                        <span>Publish immediately (Active)</span>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px; border-radius: 20px; font-weight: 700; font-size: 13px;">
                    Create Category
                </button>
            </form>
        </div>

        <!-- Add Service Form -->
        <div class="glass-card" style="padding: 22px;">
            <h3 style="font-size: 16px; font-weight: 800; color: var(--text-heading); margin-bottom: 14px;">
                <i class="fas fa-plus" style="color: var(--primary); margin-right: 6px;"></i> Add Service Item
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
                <div style="margin-bottom: 12px;">
                    <label class="form-label" for="priority_rank">Priority Rank <span style="color:#ef4444;">*</span></label>
                    <input type="number" id="priority_rank" name="priority_rank" class="form-input" value="1" min="1" required>
                </div>
                <div style="margin-bottom: 16px;">
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer;">
                        <input type="checkbox" name="is_required" value="1" style="accent-color: var(--primary);">
                        <span>Mandatory core service</span>
                    </label>
                </div>
                <button type="submit" class="btn btn-secondary" style="width: 100%; padding: 10px; border-radius: 20px; font-weight: 700; font-size: 13px;">
                    Add Service
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
