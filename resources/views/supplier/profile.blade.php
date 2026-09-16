@extends('layouts.eventflare')

@section('title', 'Supplier Business Profile — EVENTFLARE')

@section('content')
<div style="max-width: 900px; margin: 40px auto 80px; padding: 0 24px;">

    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
        <div>
            <a href="{{ route('supplier.dashboard') }}" style="color: var(--primary); font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 8px;">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <h1 style="font-size: 32px; font-weight: 900; color: var(--text-heading); margin: 0;">
                Supplier Business Profile
            </h1>
            <p style="color: var(--text-muted); font-size: 14px; margin-top: 4px;">Update your trade name, operational contact info, and accredited service specialities.</p>
        </div>
    </div>

    <!-- Profile Form Card -->
    <div class="glass-card" style="padding: 35px;">
        <form method="POST" action="{{ route('supplier.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Account Header Info -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 16px 20px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    @if($supplier && $supplier->logo_url)
                        <img src="{{ $supplier->logo_url }}" alt="Logo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary);">
                    @endif
                    <div>
                        <small style="color: var(--text-muted); font-size: 11px; font-weight: 800; text-transform: uppercase;">Authenticated Account</small>
                        <div style="font-size: 15px; font-weight: 800; color: var(--text-heading);">{{ Auth::user()->username }} ({{ Auth::user()->email }})</div>
                    </div>
                </div>
                <span style="background: #dbeafe; color: #1d4ed8; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 12px;">
                    <i class="fas fa-briefcase"></i> Supplier Role
                </span>
            </div>

            <!-- Logo Upload Field -->
            <div style="margin-bottom: 20px; background: #faf5ff; border: 1px dashed #d8b4fe; border-radius: 14px; padding: 16px;">
                <label class="form-label" for="logo"><i class="fas fa-image" style="color: var(--primary);"></i> Business Brand Logo / Avatar (JPEG, PNG, WEBP max 2MB)</label>
                <input type="file" id="logo" name="logo" class="form-input" accept="image/*" style="padding: 8px;">
                @error('logo') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <!-- Business Name & Category -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label class="form-label" for="business_name">Trading / Business Name <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="business_name" name="business_name" class="form-input" 
                           value="{{ old('business_name', $supplier->business_name ?? '') }}" required placeholder="e.g. Royal Poruwa & Florals">
                    @error('business_name') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="form-label" for="category">Primary Trade Speciality</label>
                    <input type="text" id="category" name="category" class="form-input" 
                           value="{{ old('category', $supplier->category ?? '') }}" placeholder="e.g. Poruwa Specialists, Audio Engineering">
                    @error('category') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Phone & Location -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label class="form-label" for="contact_phone">Direct Dispatch Phone <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="contact_phone" name="contact_phone" class="form-input" 
                           value="{{ old('contact_phone', $supplier->contact_phone ?? '') }}" required placeholder="e.g. +94 77 123 4567">
                    @error('contact_phone') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="form-label" for="location">Operating Region / City <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="location" name="location" class="form-input" 
                           value="{{ old('location', $supplier->location ?? '') }}" required placeholder="e.g. Colombo, Kandy, Galle">
                    @error('location') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Business Bio -->
            <div style="margin-bottom: 25px;">
                <label class="form-label" for="description">Company Profile & Experience Overview</label>
                <textarea id="description" name="description" class="form-input" rows="4" 
                          placeholder="Describe your capabilities, past events, equipment inventory, and crew qualifications...">{{ old('description', $supplier->description ?? '') }}</textarea>
                @error('description') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <!-- Accredited Service Offerings (Multi-checkbox grouped by event type) -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px; margin-bottom: 28px;">
                <h3 style="font-size: 16px; font-weight: 800; color: var(--text-heading); margin-bottom: 6px;">
                    <i class="fas fa-check-double" style="color: var(--primary); margin-right: 6px;"></i> Accredited Service Offerings
                </h3>
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 18px;">
                    Select the specific line services your business is authorized to deliver on EVENTFLARE:
                </p>

                @php
                    $currentServiceIds = $supplier ? $supplier->services->pluck('service_id')->toArray() : [];
                @endphp

                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @foreach($eventTypes as $et)
                        <div style="border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
                            <strong style="font-size: 13px; color: var(--primary); display: block; margin-bottom: 8px;">
                                {{ $et->type_name }}
                            </strong>
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 8px;">
                                @foreach($et->services as $s)
                                    <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #475569; cursor: pointer;">
                                        <input type="checkbox" name="services[]" value="{{ $s->service_id }}"
                                               {{ in_array($s->service_id, old('services', $currentServiceIds)) ? 'checked' : '' }}
                                               style="accent-color: var(--primary); width: 16px; height: 16px;">
                                        <span>{{ $s->service_name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="padding: 13px 30px; border-radius: 30px; font-weight: 800;">
                <i class="fas fa-save"></i> Save Business Profile & Services
            </button>
        </form>
    </div>

</div>
@endsection
