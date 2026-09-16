@if(session('success'))
    <div class="alert-banner message-success" style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; padding:12px 20px; border-radius:12px; margin-bottom:20px; display:flex; align-items:center; justify-content:space-between; gap:10px;">
        <div style="display:flex; align-items:center; gap:10px;">
            <i class="fas fa-check-circle" style="font-size:18px;"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove();" style="background:none; border:none; font-size:20px; cursor:pointer; color:inherit;">&times;</button>
    </div>
@endif

@if(session('error'))
    <div class="alert-banner message-error" style="background:#fef2f2; color:#991b1b; border:1px solid #fecaca; padding:12px 20px; border-radius:12px; margin-bottom:20px; display:flex; align-items:center; justify-content:space-between; gap:10px;">
        <div style="display:flex; align-items:center; gap:10px;">
            <i class="fas fa-exclamation-circle" style="font-size:18px;"></i>
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove();" style="background:none; border:none; font-size:20px; cursor:pointer; color:inherit;">&times;</button>
    </div>
@endif

@if(session('status'))
    <div class="alert-banner message-info" style="background:#eff6ff; color:#1e40af; border:1px solid #bfdbfe; padding:12px 20px; border-radius:12px; margin-bottom:20px; display:flex; align-items:center; justify-content:space-between; gap:10px;">
        <div style="display:flex; align-items:center; gap:10px;">
            <i class="fas fa-info-circle" style="font-size:18px;"></i>
            <span>{{ session('status') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove();" style="background:none; border:none; font-size:20px; cursor:pointer; color:inherit;">&times;</button>
    </div>
@endif
