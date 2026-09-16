<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EVENTFLARE Reservation Voucher — #{{ $booking->BookingID }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #1e293b;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #8b5cf6;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .brand-title {
            font-size: 24px;
            font-weight: bold;
            color: #8b5cf6;
            letter-spacing: 1px;
        }
        .brand-sub {
            font-size: 11px;
            color: #64748b;
        }
        .voucher-title {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #0f172a;
        }
        .voucher-ref {
            text-align: right;
            font-size: 13px;
            color: #8b5cf6;
            font-weight: bold;
        }
        .summary-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }
        .summary-table {
            width: 100%;
        }
        .summary-table td {
            padding: 6px 4px;
            font-size: 12px;
        }
        .label {
            color: #64748b;
            font-weight: bold;
            width: 25%;
        }
        .value {
            color: #0f172a;
            font-weight: bold;
            width: 25%;
        }
        .services-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .services-table th {
            background-color: #f1f5f9;
            color: #475569;
            font-size: 11px;
            text-transform: uppercase;
            padding: 8px;
            border: 1px solid #e2e8f0;
            text-align: left;
        }
        .services-table td {
            padding: 8px;
            border: 1px solid #e2e8f0;
            font-size: 12px;
        }
        .status-pill {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            background: #dcfce7;
            color: #15803d;
        }
        .footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td>
                <div class="brand-title">EVENTFLARE</div>
                <div class="brand-sub">Sri Lanka's Premier Event Coordination Platform</div>
            </td>
            <td>
                <div class="voucher-title">RESERVATION VOUCHER</div>
                <div class="voucher-ref">Ref: #{{ $booking->BookingID }}</div>
            </td>
        </tr>
    </table>

    <div class="summary-box">
        <table class="summary-table">
            <tr>
                <td class="label">Client Name:</td>
                <td class="value">{{ $booking->user->fullname ?? $booking->user_name }}</td>
                <td class="label">Event Category:</td>
                <td class="value">{{ $booking->EventType }}</td>
            </tr>
            <tr>
                <td class="label">Event Date:</td>
                <td class="value">{{ \Carbon\Carbon::parse($booking->EventDate)->format('F j, Y') }}</td>
                <td class="label">Session Timing:</td>
                <td class="value">{{ $booking->DayNight }} Session</td>
            </tr>
            <tr>
                <td class="label">Venue Location:</td>
                <td class="value">{{ $booking->Place }}</td>
                <td class="label">Expected Headcount:</td>
                <td class="value">{{ $booking->NumberOfGuests }} Guests</td>
            </tr>
            <tr>
                <td class="label">Catering Tier:</td>
                <td class="value">{{ $booking->FoodPreferences ?: 'Standard Tier' }}</td>
                <td class="label">Current Status:</td>
                <td class="value"><span class="status-pill">{{ $booking->status }}</span></td>
            </tr>
        </table>
    </div>

    <h4 style="color: #0f172a; margin-bottom: 10px;">Contracted Suppliers & Itemized Services</h4>
    <table class="services-table">
        <thead>
            <tr>
                <th>Service Line</th>
                <th>Contracted Supplier</th>
                <th>Contact Hotline</th>
                <th style="text-align: right;">Cost Allocation (LKR)</th>
            </tr>
        </thead>
        <tbody>
            @php $totalAlloc = 0; @endphp
            @forelse($booking->services as $srv)
                @php $totalAlloc += $srv->assigned_cost; @endphp
                <tr>
                    <td>
                        <strong>{{ $srv->service->service_name ?? 'Itemized Service' }}</strong>
                        @if($srv->listing)
                            <div style="font-size: 10px; color: #64748b;">{{ $srv->listing->title }}</div>
                        @endif
                    </td>
                    <td>{{ $srv->supplier->business_name ?? 'Assigned Specialist' }}</td>
                    <td>{{ $srv->supplier->contact_phone ?? 'Direct Hotline' }}</td>
                    <td style="text-align: right; font-weight: bold;">
                        {{ $srv->assigned_cost > 0 ? number_format($srv->assigned_cost) : 'Included' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #64748b; padding: 15px;">
                        Suppliers and itemized line items are currently undergoing active dispatch coordination.
                    </td>
                </tr>
            @endforelse
            @if($totalAlloc > 0)
                <tr style="background-color: #f8fafc;">
                    <td colspan="3" style="text-align: right; font-weight: bold;">Total Confirmed Vendor Allocations:</td>
                    <td style="text-align: right; font-weight: bold; color: #8b5cf6;">LKR {{ number_format($totalAlloc) }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="margin-top: 15px;">
        <h4 style="color: #0f172a; margin-bottom: 6px;">Production & Staging Specifications</h4>
        <p style="font-size: 11px; color: #475569; margin: 0 0 10px;">
            {{ $booking->extra->equipment ?? 'Standard Event Sound, Lighting, and Production Staging Setup' }}
        </p>

        @if($booking->ExtraDetails)
            <h4 style="color: #0f172a; margin-bottom: 6px;">Client Instructions</h4>
            <p style="font-size: 11px; color: #475569; margin: 0;">
                {{ $booking->ExtraDetails }}
            </p>
        @endif
    </div>

    <div class="footer">
        Generated electronically by EVENTFLARE Platform &bull; Colombo, Sri Lanka &bull; support@eventflare.lk<br>
        This voucher serves as a verified confirmation of your celebration reservation.
    </div>

</body>
</html>
