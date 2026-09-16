@extends('layouts.eventflare')

@section('title', 'Manage Packages & Listings — EVENTFLARE')

@section('content')
<div style="max-width: 1200px; margin: 40px auto 80px; padding: 0 24px;">

    <!-- Header & Action Button -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
        <div>
            <a href="{{ route('supplier.dashboard') }}" style="color: var(--primary); font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 8px;">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <h1 style="font-size: 32px; font-weight: 900; color: var(--text-heading); margin: 0;">
                Vendor Packages & Catalogue
            </h1>
            <p style="color: var(--text-muted); font-size: 14px; margin-top: 4px;">Create transparent packages shown directly on event showcase and booking pages.</p>
        </div>
        <button type="button" class="btn btn-primary" onclick="openCreateListingModal()" style="border-radius: 30px; padding: 12px 24px; font-weight: 700;">
            <i class="fas fa-plus"></i> New Package Listing
        </button>
    </div>

    <!-- Active Listings Grid -->
    @if($listings->isEmpty())
        <div class="glass-card" style="padding: 60px 20px; text-align: center; color: var(--text-muted);">
            <i class="fas fa-box-open" style="font-size: 48px; opacity: 0.3; margin-bottom: 16px; display: block; color: var(--primary);"></i>
            <h3 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-bottom: 8px;">No Listings Created Yet</h3>
            <p style="margin-bottom: 20px; font-size: 14px;">Define your first service package to allow customers to choose your business during booking.</p>
            <button type="button" class="btn btn-primary" onclick="openCreateListingModal()" style="padding: 10px 24px; border-radius: 25px;">
                Create Your First Package
            </button>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 24px;">
            @foreach($listings as $l)
                <div class="glass-card" style="display: flex; flex-direction: column; justify-content: space-between; border-radius: 18px; padding: 24px; overflow: hidden;">
                    <div>
                        @if($l->image_url)
                            <div style="margin: -24px -24px 16px -24px; height: 160px; overflow: hidden; background: #f1f5f9;">
                                <img src="{{ $l->image_url }}" alt="{{ $l->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @endif

                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                            <span style="background: rgba(139, 92, 246, 0.1); color: var(--primary); font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 12px; text-transform: uppercase;">
                                {{ $l->service->service_name ?? 'Service' }}
                            </span>
                            <span style="background: {{ $l->status === 'active' ? '#dcfce7' : '#fee2e2' }}; color: {{ $l->status === 'active' ? '#15803d' : '#b91c1c' }}; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 10px; text-transform: capitalize;">
                                {{ $l->status }}
                            </span>
                        </div>

                        <h3 style="font-size: 18px; font-weight: 800; color: var(--text-heading); margin-bottom: 8px;">
                            {{ $l->title }}
                        </h3>

                        <div style="font-size: 22px; font-weight: 900; color: #059669; margin-bottom: 12px;">
                            LKR {{ number_format($l->price) }}
                            <small style="font-size: 12px; font-weight: 600; color: var(--text-muted);">/ {{ str_replace('_', ' ', $l->price_type) }}</small>
                        </div>

                        <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin-bottom: 16px;">
                            {{ $l->description }}
                        </p>

                        @if($l->capacity)
                            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 14px;">
                                <i class="fas fa-users fa-xs"></i> Typical Capacity: Up to {{ $l->capacity }} guests
                            </div>
                        @endif
                    </div>

                    <div style="display: flex; gap: 8px; border-top: 1px solid #f1f5f9; padding-top: 16px; margin-top: 10px;">
                        <form method="POST" action="{{ route('supplier.listings.toggle', $l->listing_id) }}" style="flex: 1;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline" style="width: 100%; padding: 7px; font-size: 12px; border-radius: 15px; border: 1px solid #cbd5e1;">
                                <i class="fas fa-power-off"></i> {{ $l->status === 'active' ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        <button type="button" class="btn btn-secondary" style="flex: 1; padding: 7px; font-size: 12px; border-radius: 15px;"
                                onclick="openEditListingModal({{ json_encode($l) }})">
                            <i class="fas fa-edit"></i> Edit
                        </button>

                        <form method="POST" action="{{ route('supplier.listings.destroy', $l->listing_id) }}" onsubmit="return confirm('Delete this package listing permanently?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline" style="padding: 7px 12px; font-size: 12px; border-radius: 15px; border: 1px solid #fee2e2; color: #ef4444;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

<!-- Modal: Create / Edit Listing -->
<div id="listingModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div class="glass-card" style="background: #ffffff; border-radius: 20px; max-width: 600px; width: 100%; box-shadow: 0 25px 50px rgba(0,0,0,0.25); overflow: hidden; padding: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px;">
            <h3 id="modalHeading" style="margin: 0; font-size: 20px; font-weight: 800; color: var(--text-heading);">Create Package Listing</h3>
            <button type="button" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #94a3b8;" onclick="closeListingModal()">&times;</button>
        </div>

        <form id="listingForm" method="POST" action="{{ route('supplier.listings.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <!-- Category Service Selection -->
            <div style="margin-bottom: 16px;">
                <label class="form-label" for="service_id">Service Category <span style="color:#ef4444;">*</span></label>
                <select id="service_id" name="service_id" class="form-input" required>
                    <option value="">Select Service Line</option>
                    @foreach($services as $s)
                        <option value="{{ $s->service_id }}">{{ $s->eventType->type_name ?? 'Event' }} &mdash; {{ $s->service_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Title -->
            <div style="margin-bottom: 16px;">
                <label class="form-label" for="title">Listing / Package Title <span style="color:#ef4444;">*</span></label>
                <input type="text" id="title" name="title" class="form-input" placeholder="e.g. Platinum Live Poruwa & Floral Arch Setup" required>
            </div>

            <!-- Price & Price Type -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label class="form-label" for="price">Price in LKR <span style="color:#ef4444;">*</span></label>
                    <input type="number" id="price" name="price" class="form-input" placeholder="e.g. 150000" min="0" step="100" required>
                </div>
                <div>
                    <label class="form-label" for="price_type">Pricing Unit <span style="color:#ef4444;">*</span></label>
                    <select id="price_type" name="price_type" class="form-input" required>
                        <option value="total_package">Total Package</option>
                        <option value="per_person">Per Person</option>
                        <option value="per_hour">Per Hour</option>
                        <option value="per_day">Per Day</option>
                    </select>
                </div>
            </div>

            <!-- Capacity & Status -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label class="form-label" for="capacity">Typical Guest Capacity (Optional)</label>
                    <input type="number" id="capacity" name="capacity" class="form-input" placeholder="e.g. 300">
                </div>
                <div>
                    <label class="form-label" for="status">Publication Status <span style="color:#ef4444;">*</span></label>
                    <select id="status" name="status" class="form-input" required>
                        <option value="active">Active (Visible to Buyers)</option>
                        <option value="inactive">Inactive (Draft / Hidden)</option>
                    </select>
                </div>
            </div>

            <!-- Image Upload Field -->
            <div style="margin-bottom: 16px; background: #faf5ff; border: 1px dashed #d8b4fe; border-radius: 12px; padding: 14px;">
                <label class="form-label" for="image"><i class="fas fa-camera" style="color: var(--primary);"></i> Feature Package Image (JPEG, PNG, WEBP max 3MB)</label>
                <input type="file" id="image" name="image" class="form-input" accept="image/*" style="padding: 6px;">
            </div>

            <!-- Description -->
            <div style="margin-bottom: 24px;">
                <label class="form-label" for="description">Detailed Deliverables & Inclusions</label>
                <textarea id="description" name="description" class="form-input" rows="3" placeholder="Itemize equipment, crew headcount, transport arrangements, and turnaround hours..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn btn-secondary" onclick="closeListingModal()" style="border-radius: 20px; font-size: 13px;">Cancel</button>
                <button type="submit" class="btn btn-primary" style="border-radius: 20px; font-size: 13px; font-weight: 700;">Save Package</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateListingModal() {
        document.getElementById('modalHeading').innerText = 'Create Package Listing';
        document.getElementById('listingForm').action = "{{ route('supplier.listings.store') }}";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('service_id').value = '';
        document.getElementById('title').value = '';
        document.getElementById('price').value = '';
        document.getElementById('price_type').value = 'total_package';
        document.getElementById('capacity').value = '';
        document.getElementById('status').value = 'active';
        document.getElementById('description').value = '';
        document.getElementById('listingModal').style.display = 'flex';
    }

    function openEditListingModal(item) {
        document.getElementById('modalHeading').innerText = 'Edit Package Listing';
        document.getElementById('listingForm').action = `/supplier/listings/${item.listing_id}`;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('service_id').value = item.service_id;
        document.getElementById('title').value = item.title;
        document.getElementById('price').value = item.price;
        document.getElementById('price_type').value = item.price_type;
        document.getElementById('capacity').value = item.capacity || '';
        document.getElementById('status').value = item.status;
        document.getElementById('description').value = item.description || '';
        document.getElementById('listingModal').style.display = 'flex';
    }

    function closeListingModal() {
        document.getElementById('listingModal').style.display = 'none';
    }
</script>
@endsection
