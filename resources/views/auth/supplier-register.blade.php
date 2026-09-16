<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Partner Registration - EVENTFLARE</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <style>
        .split-layout {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            min-height: 100vh;
            width: 100%;
            background: #f8fafc;
        }
        .brand-side {
            position: relative;
            background-image: url('{{ asset("assets/images/evnt.jpg") }}');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            color: #ffffff;
            text-align: center;
        }
        .brand-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.8) 0%, rgba(99, 102, 241, 0.6) 100%);
            z-index: 1;
        }
        .brand-content {
            position: relative;
            z-index: 2;
            animation: springInLeft 1.2s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        }
        .brand-logo {
            font-size: 52px;
            font-weight: 900;
            letter-spacing: 2px;
            margin-bottom: 20px;
            text-shadow: 0 10px 30px rgba(0,0,0,0.5);
            background: linear-gradient(to right, #ffffff, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .brand-subtitle {
            font-size: 18px;
            opacity: 0.9;
            max-width: 420px;
            line-height: 1.6;
        }
        .form-side {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background: #f8fafc;
        }
        .auth-card {
            width: 100%;
            max-width: 520px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,0.6);
            box-shadow: 0 25px 50px -12px rgba(99, 102, 241, 0.15);
            animation: springInUp 1s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        }
        .auth-card h1 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 10px;
            color: var(--text-heading);
            text-align: center;
        }
        .auth-card p.sub {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 25px;
            text-align: center;
        }
        @keyframes springInUp {
            0% { opacity: 0; transform: translateY(60px) scale(0.95); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes springInLeft {
            0% { opacity: 0; transform: translateX(-60px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        .input-group {
            position: relative;
            margin-bottom: 16px;
        }
        .input-group i {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 18px;
        }
        .form-input {
            width: 100%;
            padding: 13px 45px 13px 18px;
            background: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            color: var(--text-main);
            transition: all 0.3s ease;
        }
        .form-input:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            outline: none;
        }
        .submit-btn {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            font-weight: 700;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 12px;
            background: var(--secondary);
            color: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            background: var(--secondary-hover);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }
        .auth-links {
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .auth-links a {
            color: var(--secondary);
            font-weight: 700;
            text-decoration: none;
        }
        @media (max-width: 900px) {
            .split-layout { grid-template-columns: 1fr; }
            .brand-side { min-height: 35vh; padding: 40px 20px; }
            .brand-logo { font-size: 38px; }
            .form-side { padding: 30px 20px; }
        }
    </style>
</head>
<body>
    <div class="split-layout">
        <div class="brand-side">
            <div class="brand-overlay"></div>
            <div class="brand-content">
                <div class="brand-logo">EVENTFLARE</div>
                <p class="brand-subtitle">Grow your business, showcase your service packages, and connect directly with high-value celebrations across Sri Lanka.</p>
            </div>
        </div>

        <div class="form-side">
            <div class="auth-card">
                <form method="POST" action="{{ route('supplier.register') }}">
                    @csrf

                    <h1>Vendor Partner Portal</h1>
                    <p class="sub">Register your business profile to start receiving client bookings</p>

                    @if($errors->any())
                        <div style="background:#fee2e2; color:#dc2626; padding:12px; border-radius:8px; margin-bottom:20px; font-size:13px; display:flex; align-items:center; gap:8px;">
                            <i class="bx bx-error-circle" style="font-size:18px;"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <div class="input-group">
                        <input type="text" class="form-input" name="business_name" value="{{ old('business_name') }}" placeholder="Registered Business / Trading Name" required autofocus>
                        <i class='bx bxs-store'></i>
                    </div>

                    <div class="input-group">
                        <select class="form-input" name="category" required>
                            <option value="">Select Primary Service Category</option>
                            <option value="Catering" {{ old('category') == 'Catering' ? 'selected' : '' }}>Catering & Banquets</option>
                            <option value="Decorators" {{ old('category') == 'Decorators' ? 'selected' : '' }}>Decorators & Florals</option>
                            <option value="Audio/Visual (A/V)" {{ old('category') == 'Audio/Visual (A/V)' ? 'selected' : '' }}>Audio/Visual & Stage Rigging</option>
                            <option value="Hotel Venues" {{ old('category') == 'Hotel Venues' ? 'selected' : '' }}>Hotel Venues & Banquet Halls</option>
                            <option value="DJs/Artists" {{ old('category') == 'DJs/Artists' ? 'selected' : '' }}>DJs, Bands & Performing Artists</option>
                            <option value="Photography & Videography" {{ old('category') == 'Photography & Videography' ? 'selected' : '' }}>Photography & Cinematography</option>
                            <option value="Bakeries & Confectioners" {{ old('category') == 'Bakeries & Confectioners' ? 'selected' : '' }}>Bakeries & Wedding Cakes</option>
                            <option value="Cultural Performers" {{ old('category') == 'Cultural Performers' ? 'selected' : '' }}>Traditional Cultural Troupe & Choirs</option>
                            <option value="Security" {{ old('category') == 'Security' ? 'selected' : '' }}>Event Security & Valet</option>
                            <option value="Bar & Beverage Services" {{ old('category') == 'Bar & Beverage Services' ? 'selected' : '' }}>Mobile Cocktail Bar & Mixology</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <input type="text" class="form-input" name="fullname" value="{{ old('fullname') }}" placeholder="Contact Person / Owner Full Name" required>
                        <i class='bx bxs-user-detail'></i>
                    </div>

                    <div class="input-group">
                        <input type="text" class="form-input" name="username" value="{{ old('username') }}" placeholder="Vendor Account Username" required>
                        <i class='bx bxs-user'></i>
                    </div>

                    <div class="input-group">
                        <input type="email" class="form-input" name="email" value="{{ old('email') }}" placeholder="Business Email Address" required>
                        <i class='bx bxs-envelope'></i>
                    </div>

                    <div class="input-group">
                        <input type="password" class="form-input" name="password" placeholder="Password (min 8 chars, mixed case, number)" required>
                        <i class='bx bxs-key'></i>
                    </div>

                    <div class="input-group">
                        <input type="password" class="form-input" name="password_confirmation" placeholder="Confirm Password" required>
                        <i class='bx bxs-lock-alt'></i>
                    </div>

                    <button type="submit" class="submit-btn">Register as Official Supplier</button>

                    <div class="auth-links">
                        <p>Already a registered partner? <a href="{{ route('login') }}">Sign In</a></p>
                        <p>Looking to plan an event? <a href="{{ route('register') }}">Sign Up as Client</a></p>
                        <p style="margin-top: 10px; font-size: 13px;"><a href="{{ url('/') }}" style="color:var(--text-muted); font-weight:normal;">&larr; Back to Homepage</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
