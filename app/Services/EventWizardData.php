<?php

namespace App\Services;

class EventWizardData
{
    /**
     * Retrieve complete dynamic wizard configuration for an event category.
     */
    public static function getWizardConfig(?string $eventType): array
    {
        $normalized = strtolower(trim((string) $eventType));

        return match (true) {
            str_contains($normalized, 'dj') || str_contains($normalized, 'party') || str_contains($normalized, 'rave')
                => self::getDjPartiesConfig(),

            str_contains($normalized, 'birth') || str_contains($normalized, 'bday') || str_contains($normalized, 'jubilee')
                => self::getBirthdaysConfig(),

            str_contains($normalized, 'hotel') || str_contains($normalized, 'venue') || str_contains($normalized, 'gala')
                => self::getHotelsConfig(),

            str_contains($normalized, 'together') || str_contains($normalized, 'reunion') || str_contains($normalized, 'mixer') || str_contains($normalized, 'bbq')
                => self::getGetTogethersConfig(),

            default => self::getWeddingsConfig(),
        };
    }

    /**
     * 1. WEDDINGS CONFIGURATION
     */
    private static function getWeddingsConfig(): array
    {
        return [
            'category_name'     => 'Weddings',
            'booking_prefix'    => 'BKG-WED-',
            'theme_badge'       => 'Curated Bespoke Nuptials',
            'theme_title'       => 'The Royal Nuptial Journey',
            'theme_subtitle'    => 'Experience Sri Lanka’s finest wedding curation across 4 interactive stages. Configure your venue, theme, catering, and accredited cultural artisans with real-time financial telemetry.',
            'alert_hook'        => 'Planning a Royal Wedding?',
            'theme_colors' => [
                'primary_glow'       => 'rgba(139, 92, 246, 0.45)',
                'secondary_glow'     => 'rgba(236, 72, 153, 0.4)',
                'accent'             => '#f59e0b',
                'accent_glow'        => 'rgba(245, 158, 11, 0.35)',
                'surface_glass_card' => 'rgba(27, 23, 49, 0.78)',
                'active_border'      => 'rgba(139, 92, 246, 0.75)',
                'active_bg'          => 'rgba(139, 92, 246, 0.16)',
                'badge_color'        => '#c4b5fd',
                'orb_1'              => 'linear-gradient(135deg, #7c3aed, #4f46e5)',
                'orb_2'              => 'linear-gradient(135deg, #ec4899, #db2777)',
                'orb_3'              => 'linear-gradient(135deg, #f59e0b, #d97706)',
            ],
            'host_label'        => 'Groom & Bride / Couple Names',
            'host_placeholder'  => 'e.g. Kasun Perera & Dilhani Senanayake',
            'date_label'        => 'Auspicious Wedding Date',
            'session_day_title' => 'Daytime Auspicious Ceremony',
            'session_day_desc'  => 'Traditional morning Poruwa ritual, Nekath timings, luncheon banquet & afternoon toasts (08:00 AM – 03:30 PM)',
            'session_night_title' => 'Starlight Evening Gala',
            'session_night_desc'=> 'Twilight vows, illuminated floral mandap, cocktail reception, 5-course banquet & dancing (05:30 PM – Midnight)',
            'guest_min'         => 20,
            'guest_max'         => 1500,
            'guest_default'     => 150,
            'venues' => [
                [
                    'name'     => 'Shangri-La Colombo',
                    'capacity' => 'Up to 1,500 Guests',
                    'tag'      => 'Lotus Ballroom • Ocean Views',
                    'city'     => 'Colombo 02',
                    'icon'     => 'fas fa-gem',
                ],
                [
                    'name'     => 'Cinnamon Grand Colombo',
                    'capacity' => 'Up to 800 Guests',
                    'tag'      => 'Oak Room • 5-Star Luxury',
                    'city'     => 'Colombo 03',
                    'icon'     => 'fas fa-crown',
                ],
                [
                    'name'     => 'Kingsbury Victorian Ballroom',
                    'capacity' => 'Up to 500 Guests',
                    'tag'      => 'Victorian Grandeur • Harbour View',
                    'city'     => 'Colombo 01',
                    'icon'     => 'fas fa-landmark',
                ],
                [
                    'name'     => 'Jetwing Blue Negombo',
                    'capacity' => 'Up to 600 Guests',
                    'tag'      => 'Coastal Beachfront Ballroom',
                    'city'     => 'Negombo',
                    'icon'     => 'fas fa-umbrella-beach',
                ],
                [
                    'name'     => 'Earl\'s Regency Kandy',
                    'capacity' => 'Up to 700 Guests',
                    'tag'      => 'Knuckles Range View • Heritage',
                    'city'     => 'Kandy',
                    'icon'     => 'fas fa-mountain',
                ],
                [
                    'name'     => 'Bespoke Venue',
                    'capacity' => 'Custom Capacity',
                    'tag'      => 'Private Estate / Ancestral Home',
                    'city'     => 'Islandwide',
                    'icon'     => 'fas fa-map-marker-alt',
                ],
            ],
            'styles' => [
                'Traditional' => [
                    'title' => 'Traditional Poruwa',
                    'icon'  => 'fas fa-landmark',
                    'color' => '#f59e0b',
                    'desc'  => 'Sacred Sinhala cultural rituals, Magul Bera drummers, Jayamangala chants & lotus mandaps.',
                ],
                'Western' => [
                    'title' => 'Western Elegance',
                    'icon'  => 'fas fa-church',
                    'color' => '#60a5fa',
                    'desc'  => 'Contemporary cathedral aisle styling, formal black-tie banquet, champagne toasts & first dance.',
                ],
                'Beach' => [
                    'title' => 'Coastal Beachside',
                    'icon'  => 'fas fa-umbrella-beach',
                    'color' => '#34d399',
                    'desc'  => 'Tropical sunset vows, floral timber canopies, ocean breezes & barefoot luxury ambiance.',
                ],
                'Ballroom' => [
                    'title' => 'Grand Luxury Ballroom',
                    'icon'  => 'fas fa-gem',
                    'color' => '#f472b6',
                    'desc'  => '5-Star hotel grandeur, crystal chandeliers, floral tunnels, and theatrical ambient wash.',
                ],
            ],
            'catering_tiers' => [
                'Platinum' => [
                    'name'      => 'Platinum Royal Banquet',
                    'rate'      => 8500.00,
                    'tagline'   => '5-Course International Gourmet Buffet & Live Themed Carving Stations',
                    'highlights'=> ['Unlimited Welcome Mocktails & Fresh Fruit Carafes', '3 Live Action Stations (Mongolian BBQ, Satay & Roast Ribs)', '12 Artisanal Desserts & Belgian Chocolate Fountain', 'Dedicated Head Waiter & White Glove Table Service'],
                    'badge'     => 'Signature Luxury',
                ],
                'Executive' => [
                    'name'      => 'Executive Signature Dining',
                    'rate'      => 6200.00,
                    'tagline'   => '3-Course Delicacy Buffet with Curated Ceylon & Continental Specialities',
                    'highlights'=> ['Welcome Fruit Punch & Chilled Canapés', '2 Live Action Stations (Pasta Corner & Grilled Seafood)', '8 Handcrafted Tropical & French Pastries', 'Trained Uniformed Banquet Captains'],
                    'badge'     => 'Best Value',
                ],
                'Cocktail' => [
                    'name'      => 'Cocktail Canapé & High Tea',
                    'rate'      => 4800.00,
                    'tagline'   => 'Gourmet Pass-Around Canapés, Artisan Sliders & Grazing Boards',
                    'highlights'=> ['14 Signature Pass-Around Finger Food Selections', 'Artisanal European Cheese & Charcuterie Board', 'Live Dim Sum & Yakitori Brochette Stations', 'Specialized Mixologist Mocktail Station'],
                    'badge'     => 'Chic & Light',
                ],
            ],
            'equipment_label'       => 'Stage, Floral Mandap & AV Production Needs',
            'equipment_placeholder' => 'e.g. Traditional carved Poruwa with fresh white lotus, cold pyrotechnics for entrance, 4K LED backdrop, crystal head table lighting',
            'notes_label'           => 'Auspicious Nekath Times, Dietary Quotas & Coordination Notes',
            'notes_placeholder'     => 'Specify exact auspicious Nekath timings for Poruwa ascent, rings exchange, dietary counts (halal, vegetarian, vegan), or special bridal suite requests...',
        ];
    }

    /**
     * 2. DJ PARTIES & CLUB RAVES CONFIGURATION
     */
    private static function getDjPartiesConfig(): array
    {
        return [
            'category_name'     => 'DJ Parties',
            'booking_prefix'    => 'BKG-DJ-',
            'theme_badge'       => 'High-Voltage Sound & Lighting Rigs',
            'theme_title'       => 'Intelligent Sound & Rave Production Wizard',
            'theme_subtitle'    => 'Turn up the energy with concert line arrays, multi-beam laser shows, licensed mobile cocktail bars, and chart-topping DJs across Sri Lanka.',
            'alert_hook'        => 'Intelligent Sound & Club Visuals Active',
            'theme_colors' => [
                'primary_glow'       => 'rgba(99, 102, 241, 0.55)',
                'secondary_glow'     => 'rgba(6, 182, 212, 0.45)',
                'accent'             => '#a855f7',
                'accent_glow'        => 'rgba(168, 85, 247, 0.4)',
                'surface_glass_card' => 'rgba(18, 17, 38, 0.82)',
                'active_border'      => 'rgba(99, 102, 241, 0.85)',
                'active_bg'          => 'rgba(99, 102, 241, 0.18)',
                'badge_color'        => '#a5b4fc',
                'orb_1'              => 'linear-gradient(135deg, #6366f1, #3b82f6)',
                'orb_2'              => 'linear-gradient(135deg, #06b6d4, #0284c7)',
                'orb_3'              => 'linear-gradient(135deg, #a855f7, #7c3aed)',
            ],
            'host_label'        => 'Event Organizer / DJ Crew / Host Name',
            'host_placeholder'  => 'e.g. DJ Kevin Beats / Apex Promotions / Kavinda & Friends',
            'date_label'        => 'Party / Rave Date',
            'session_day_title' => 'Sunset Sundowner Session',
            'session_day_desc'  => 'Golden hour beach beats, tropical house, craft cocktails & twilight chill lounge (04:00 PM – 10:00 PM)',
            'session_night_title' => 'All-Night Neon Rave',
            'session_night_desc'=> 'Concert dual line array, heavy subwoofers, moving-head lasers, CO2 jets & headline EDM sets (08:00 PM – 04:00 AM)',
            'guest_min'         => 50,
            'guest_max'         => 2500,
            'guest_default'     => 250,
            'venues' => [
                [
                    'name'     => 'Cinnamon Lakeside Rooftop',
                    'capacity' => 'Up to 350 Partygoers',
                    'tag'      => 'Skyline Panorama • Neon Rig',
                    'city'     => 'Colombo 02',
                    'icon'     => 'fas fa-city',
                ],
                [
                    'name'     => 'Bentota Beach Resort Palm Lawn',
                    'capacity' => 'Up to 450 Partygoers',
                    'tag'      => 'Oceanfront Lawn • Deep House',
                    'city'     => 'Bentota',
                    'icon'     => 'fas fa-water',
                ],
                [
                    'name'     => 'BMICH Main Exhibition Hall B',
                    'capacity' => 'Up to 1,500 Partygoers',
                    'tag'      => 'Arena Concert Rig • P3 LED Wall',
                    'city'     => 'Colombo 07',
                    'icon'     => 'fas fa-broadcast-tower',
                ],
                [
                    'name'     => 'Mount Lavinia Beach Arena',
                    'capacity' => 'Up to 600 Partygoers',
                    'tag'      => 'Private Coastal Beach • UV Glow',
                    'city'     => 'Mount Lavinia',
                    'icon'     => 'fas fa-umbrella-beach',
                ],
                [
                    'name'     => 'Viharamahadevi Amphitheatre',
                    'capacity' => 'Up to 1,000 Partygoers',
                    'tag'      => 'Open-Air Festival Amphitheatre',
                    'city'     => 'Colombo 07',
                    'icon'     => 'fas fa-bolt',
                ],
                [
                    'name'     => 'Bespoke Club / Private Warehouse',
                    'capacity' => 'Custom Arena',
                    'tag'      => 'Industrial Warehouse / Private Lawn',
                    'city'     => 'Islandwide',
                    'icon'     => 'fas fa-map-marker-alt',
                ],
            ],
            'styles' => [
                'Rave' => [
                    'title' => 'EDM & Club Rave',
                    'icon'  => 'fas fa-bolt',
                    'color' => '#6366f1',
                    'desc'  => 'High-octane electronic dance music, intelligent beam movers, CO2 cryo cannons & bass drops.',
                ],
                'Sunset' => [
                    'title' => 'Sunset Deep House',
                    'icon'  => 'fas fa-sun',
                    'color' => '#06b6d4',
                    'desc'  => 'Melodic & organic deep house grooves, bohemian lounge low seating, ambient festoon bulbs.',
                ],
                'Gala' => [
                    'title' => 'Mega Arena & After-Party',
                    'icon'  => 'fas fa-compact-disc',
                    'color' => '#a855f7',
                    'desc'  => 'Stadium dual line arrays, 12-meter LED backdrop, commercial Top-40 hits & VIP bottle service.',
                ],
                'Beach' => [
                    'title' => 'Neon UV Beach Bash',
                    'icon'  => 'fas fa-fire',
                    'color' => '#ec4899',
                    'desc'  => 'Coastal sands, UV neon body paint stations, live bongo percussion & tiki cocktail mixology.',
                ],
            ],
            'catering_tiers' => [
                'Platinum' => [
                    'name'      => 'VIP Open Bar & Canapé Grazing',
                    'rate'      => 5800.00,
                    'tagline'   => 'Premium Mobile Cocktail Bar, Flair Mixologists & Hot Tapas Platters',
                    'highlights'=> ['2 Dedicated Master Flair Mixologists with Neon Bar Station', 'Signature Infused Cocktails, Shooters & Craft Mocktails', 'Gourmet Sliders, Yakitori Skewers & Loaded Nacho Bar', 'VIP Wristband Table Service & Chilled Glassware'],
                    'badge'     => 'High Octane',
                ],
                'Executive' => [
                    'name'      => 'Cocktail & Party Bites Tier',
                    'rate'      => 3800.00,
                    'tagline'   => 'Craft Beer, Sangria Bar & Artisan Street Food Grazing Table',
                    'highlights'=> ['Craft Mocktail & Sangria Punch Dispensers', 'Chicken & Beef Sliders, Crispy Wings & Loaded Fries', 'Assorted Finger Food Grazing Board', 'Bar Staff & Recycling Cleanup Crew'],
                    'badge'     => 'Party Favorite',
                ],
                'Cocktail' => [
                    'name'      => 'Energy & Mocktail Lounge',
                    'rate'      => 2600.00,
                    'tagline'   => 'Botanical Mocktails, Energy Elixirs & Late-Night Snack Cones',
                    'highlights'=> ['Red Bull & Botanical Fruit Spritzers Station', 'Mini Pizza Bites, Spring Rolls & Churro Cones', 'Hydration Water Bar with Electrolyte Carafes', 'Self-Serve Grazing Setup'],
                    'badge'     => 'Chic & Light',
                ],
            ],
            'equipment_label'       => 'Audio/Visual Rig, Laser Truss & DJ Equipment Needs',
            'equipment_placeholder' => 'e.g. Dual 15-inch subwoofers, 6 moving head laser beams, smoke haze machine, Pioneer CDJ-3000 DJ console, CO2 jets',
            'notes_label'           => 'DJ Rider Requirements, Wristband Credentials & Security Notes',
            'notes_placeholder'     => 'Specify artist rider technical requirements, VIP guestlist wristband tiers, age verification checkpoints, or sound curfew constraints...',
        ];
    }

    /**
     * 3. BIRTHDAYS & JUBILEE CELEBRATIONS CONFIGURATION
     */
    private static function getBirthdaysConfig(): array
    {
        return [
            'category_name'     => 'Birthdays',
            'booking_prefix'    => 'BKG-BDAY-',
            'theme_badge'       => 'Milestone Jubilee & Kids Celebrations',
            'theme_title'       => 'Milestone Birthday Celebration Wizard',
            'theme_subtitle'    => 'Bespoke 3D sculpted cakes, organic balloon dreamscapes, live magic performers, and kid-friendly catering designed for joyful milestones.',
            'alert_hook'        => 'Milestone Birthday Celebration Selected',
            'theme_colors' => [
                'primary_glow'       => 'rgba(245, 158, 11, 0.45)',
                'secondary_glow'     => 'rgba(244, 63, 94, 0.4)',
                'accent'             => '#ec4899',
                'accent_glow'        => 'rgba(236, 72, 153, 0.35)',
                'surface_glass_card' => 'rgba(29, 21, 35, 0.8)',
                'active_border'      => 'rgba(245, 158, 11, 0.8)',
                'active_bg'          => 'rgba(245, 158, 11, 0.16)',
                'badge_color'        => '#fde68a',
                'orb_1'              => 'linear-gradient(135deg, #f59e0b, #d97706)',
                'orb_2'              => 'linear-gradient(135deg, #f43f5e, #e11d48)',
                'orb_3'              => 'linear-gradient(135deg, #ec4899, #be185d)',
            ],
            'host_label'        => 'Celebrant Name & Age Milestone',
            'host_placeholder'  => 'e.g. Aarav (1st Birthday) / Senuri (Sweet 16) / Uncle Nihal (60th Jubilee)',
            'date_label'        => 'Celebration Date',
            'session_day_title' => 'Daytime Birthday Bash',
            'session_day_desc'  => 'Playful daytime games, mascot entertainment, magic show, cake cutting & kids lunch feast (10:00 AM – 03:00 PM)',
            'session_night_title' => 'Starlight Milestone Dinner',
            'session_night_desc'=> 'Elegant evening banquet, retrospective memory photo wall, live acoustic trio & celebratory toast (06:00 PM – 11:00 PM)',
            'guest_min'         => 20,
            'guest_max'         => 500,
            'guest_default'     => 80,
            'venues' => [
                [
                    'name'     => 'Waters Edge Pavilion',
                    'capacity' => 'Up to 200 Guests',
                    'tag'      => 'Lakeside Lawn • Playful Ambiance',
                    'city'     => 'Battaramulla',
                    'icon'     => 'fas fa-birthday-cake',
                ],
                [
                    'name'     => 'Kingsbury Balmoral Ballroom',
                    'capacity' => 'Up to 250 Guests',
                    'tag'      => 'Sweet 16 Glamour • Crystal Lighting',
                    'city'     => 'Colombo 01',
                    'icon'     => 'fas fa-gem',
                ],
                [
                    'name'     => 'Mount Lavinia Ocean Terrace',
                    'capacity' => 'Up to 180 Guests',
                    'tag'      => 'Golden Jubilee • Seaside Stars',
                    'city'     => 'Mount Lavinia',
                    'icon'     => 'fas fa-glass-cheers',
                ],
                [
                    'name'     => 'Cinnamon Grand Garden Suite',
                    'capacity' => 'Up to 120 Guests',
                    'tag'      => 'Enchanted Castle • Private Garden',
                    'city'     => 'Colombo 03',
                    'icon'     => 'fas fa-seedling',
                ],
                [
                    'name'     => 'Earl\'s Regency Grand Ballroom',
                    'capacity' => 'Up to 200 Guests',
                    'tag'      => 'Hill Country Milestone • Mountain View',
                    'city'     => 'Kandy',
                    'icon'     => 'fas fa-mountain',
                ],
                [
                    'name'     => 'Private Residence / Garden Lawn',
                    'capacity' => 'Custom Intimate Space',
                    'tag'      => 'Family Backyard / Private Villa',
                    'city'     => 'Islandwide',
                    'icon'     => 'fas fa-home',
                ],
            ],
            'styles' => [
                'Kids' => [
                    'title' => 'Kids Adventure & Safari',
                    'icon'  => 'fas fa-paw',
                    'color' => '#f59e0b',
                    'desc'  => 'Organic animal balloon arches, 3D animal props, interactive mascot games & chocolate fountain.',
                ],
                'Sweet16' => [
                    'title' => 'Sweet 16 & 21st Glamour',
                    'icon'  => 'fas fa-crown',
                    'color' => '#ec4899',
                    'desc'  => 'Rose gold sequin shimmer walls, photobooth magic mirror, macaron towers & teen dance DJ.',
                ],
                'Milestone' => [
                    'title' => 'Golden Diamond Jubilee',
                    'icon'  => 'fas fa-award',
                    'color' => '#fbbf24',
                    'desc'  => 'Sophisticated 40th/50th/60th celebration, retrospective memory gallery, acoustic jazz & slow-roast carvery.',
                ],
                'Fairytale' => [
                    'title' => 'Fairytale Princess & Castle',
                    'icon'  => 'fas fa-magic',
                    'color' => '#a855f7',
                    'desc'  => 'Hand-painted castle facade, real-life princess mascots, glitter face-painting & cotton candy cart.',
                ],
            ],
            'catering_tiers' => [
                'Platinum' => [
                    'name'      => 'Jubilee Deluxe Feast & Cake Bar',
                    'rate'      => 5200.00,
                    'tagline'   => '3-Course International Carvery, Custom 3D Cake Tasting & Dessert Table',
                    'highlights'=> ['Multi-Course Hot Buffet with Live Roast Carvery & Pasta Stall', 'Dedicated Sweet Symphony French Macaron & Tartlet Bar', 'Unlimited Mocktail Carafes & Gourmet Ice Cream Sundaes', 'Full Wait Staff & Cake Cutting Ceremony Assistance'],
                    'badge'     => 'Milestone Grand',
                ],
                'Executive' => [
                    'name'      => 'High Tea & Parisian Grazing',
                    'rate'      => 3800.00,
                    'tagline'   => 'Artisan Finger Sandwiches, French Macarons, Cupcakes & Chilled Spritzers',
                    'highlights'=> ['Deluxe High Tea Spread with Smoked Salmon Pinwheels & Sliders', 'Assorted Artisan Cupcake & Macaron Platter', 'Fresh Fruit Infused Mocktails & Chilled Ceylon Tea', 'Uniformed Service Captains'],
                    'badge'     => 'Chic Elegance',
                ],
                'Cocktail' => [
                    'name'      => 'Kids Fiesta Buffet & Snack Platter',
                    'rate'      => 2500.00,
                    'tagline'   => 'Mini Burger Sliders, Chicken Nuggets, Waffle Cones & Fruit Skewers',
                    'highlights'=> ['Kid-Approved Finger Food Spread (Sliders, Fries, Nuggets)', 'Mini Fruit Skewers & Marshmallow Pop Sticks', 'Juice Box Station & Soft Ice Cream Cups', 'Kid-Safe Bio-Degradable Partyware'],
                    'badge'     => 'Kids Favorite',
                ],
            ],
            'equipment_label'       => 'Thematic Props, Balloon Backdrops & Magic Acts Needs',
            'equipment_placeholder' => 'e.g. 3-tier organic balloon arch, 3D acrylic name signage, neon number prop, magic show sound PA, mascot costume hire',
            'notes_label'           => 'Cake Inscription, Dietary Quotas & Games Schedule Notes',
            'notes_placeholder'     => 'Specify exact cake inscription wording, cake flavor preferences (e.g. Belgian chocolate ganache), kid allergy warnings (nut-free), and surprise timings...',
        ];
    }

    /**
     * 4. HOTEL VENUES & FIVE-STAR GALAS CONFIGURATION
     */
    private static function getHotelsConfig(): array
    {
        return [
            'category_name'     => 'Hotel Venues',
            'booking_prefix'    => 'BKG-HTL-',
            'theme_badge'       => 'Five-Star Hospitality & Ballrooms',
            'theme_title'       => 'Five-Star Hotel Venue & Gala Wizard',
            'theme_subtitle'    => 'Oceanfront grand ballrooms, crystal chandelier halls, executive culinary teams, and luxury accommodations for landmark celebrations and corporate banquets.',
            'alert_hook'        => 'Five-Star Hotel Venue & Ballroom Coordination',
            'theme_colors' => [
                'primary_glow'       => 'rgba(217, 119, 6, 0.5)',
                'secondary_glow'     => 'rgba(180, 83, 9, 0.4)',
                'accent'             => '#f59e0b',
                'accent_glow'        => 'rgba(245, 158, 11, 0.35)',
                'surface_glass_card' => 'rgba(28, 24, 30, 0.82)',
                'active_border'      => 'rgba(217, 119, 6, 0.85)',
                'active_bg'          => 'rgba(217, 119, 6, 0.16)',
                'badge_color'        => '#fcd34d',
                'orb_1'              => 'linear-gradient(135deg, #d97706, #b45309)',
                'orb_2'              => 'linear-gradient(135deg, #f59e0b, #78350f)',
                'orb_3'              => 'linear-gradient(135deg, #64748b, #334155)',
            ],
            'host_label'        => 'Host Entity / Corporate Organization / Client Name',
            'host_placeholder'  => 'e.g. Dr. Priyantha Dissanayake / Apex Global Holdings / Alumni Council',
            'date_label'        => 'Gala / Banquet Date',
            'session_day_title' => 'Executive Day Symposium',
            'session_day_desc'  => 'Plenary presentations, dual LED displays, simultaneous translation, executive high-tea & 3-course plated lunch (08:00 AM – 04:00 PM)',
            'session_night_title' => 'Grand Evening Gala',
            'session_night_desc'=> 'Crystal chandeliers, red carpet welcome, champagne reception, 5-course international carvery & live orchestra (06:00 PM – Midnight)',
            'guest_min'         => 50,
            'guest_max'         => 1500,
            'guest_default'     => 220,
            'venues' => [
                [
                    'name'     => 'Shangri-La Main Ballroom',
                    'capacity' => 'Up to 800 Delegates',
                    'tag'      => 'Acoustic Panels • Dual LED Walls',
                    'city'     => 'Colombo 02',
                    'icon'     => 'fas fa-hotel',
                ],
                [
                    'name'     => 'Grand Horizon Oceanview Ballroom',
                    'capacity' => 'Up to 450 Guests',
                    'tag'      => 'Crystal Chandeliers • Oceanfront',
                    'city'     => 'Galle',
                    'icon'     => 'fas fa-gem',
                ],
                [
                    'name'     => 'Kingsbury Victorian Hall',
                    'capacity' => 'Up to 400 Guests',
                    'tag'      => 'Victorian Colonial Grandeur',
                    'city'     => 'Colombo 01',
                    'icon'     => 'fas fa-landmark',
                ],
                [
                    'name'     => 'Jetwing Lighthouse Oceanside Lawn',
                    'capacity' => 'Up to 350 Guests',
                    'tag'      => 'Cliffside Ocean Breeze • Lawn',
                    'city'     => 'Galle',
                    'icon'     => 'fas fa-water',
                ],
                [
                    'name'     => 'Earl\'s Regency Grand Ballroom',
                    'capacity' => 'Up to 400 Guests',
                    'tag'      => 'Mahaweli River View • Mountain Panorama',
                    'city'     => 'Kandy',
                    'icon'     => 'fas fa-mountain',
                ],
                [
                    'name'     => 'Bespoke 5-Star Partner Hall',
                    'capacity' => 'Custom Ballroom',
                    'tag'      => 'Exclusive Partner Hotel Booking',
                    'city'     => 'Islandwide',
                    'icon'     => 'fas fa-concierge-bell',
                ],
            ],
            'styles' => [
                'Ballroom' => [
                    'title' => 'Palatial Black-Tie Gala',
                    'icon'  => 'fas fa-gem',
                    'color' => '#d97706',
                    'desc'  => 'Red carpet arrival, crystal chandeliers, tiered banquet roundtables & formal awards stage.',
                ],
                'Conference' => [
                    'title' => 'Corporate Symposium',
                    'icon'  => 'fas fa-microphone-alt',
                    'color' => '#60a5fa',
                    'desc'  => 'Dual LED screen setup, digital podium, simultaneous interpretation headsets & breakout suites.',
                ],
                'Lawn' => [
                    'title' => 'Sunset Cliffside Banquet',
                    'icon'  => 'fas fa-wind',
                    'color' => '#34d399',
                    'desc'  => 'Oceanfront lawns, cliffside sunset views, champagne toast cocktail tables & chamber quartet.',
                ],
                'Suites' => [
                    'title' => 'VIP Suite Block & Lounge',
                    'icon'  => 'fas fa-bed',
                    'color' => '#f472b6',
                    'desc'  => 'Block booking of Deluxe Oceanview Suites, private check-in lounge & 24-hour butler coordination.',
                ],
            ],
            'catering_tiers' => [
                'Platinum' => [
                    'name'      => 'Five-Star Presidential Plated',
                    'rate'      => 8200.00,
                    'tagline'   => '4-Course Individually Plated Haute Cuisine with Pre-Dinner Canapés',
                    'highlights'=> ['Amuse-Bouche & Artisan Seafood Terrine Starter', 'Choice of Prime Black Angus Tenderloin or Lobster Tail', 'Valrhona Dark Chocolate Sphere Dessert', 'Dedicated Sommelier & White Glove Plated Service'],
                    'badge'     => 'Haute Cuisine',
                ],
                'Executive' => [
                    'name'      => 'Executive International Buffet',
                    'rate'      => 6400.00,
                    'tagline'   => 'Multi-Cuisine 5-Star Banquet with Live Action Carvery Stations',
                    'highlights'=> ['Multi-National Salads, Live Carvery & Asian Wok Counter', 'Curated Ceylon Seafood & Continental Specialities', '12 Artisanal Desserts & Tropical Fruit Display', 'Uniformed Hotel Captains & Station Chefs'],
                    'badge'     => 'Corporate Choice',
                ],
                'Cocktail' => [
                    'name'      => 'Executive High Tea & Reception',
                    'rate'      => 4200.00,
                    'tagline'   => 'Artisan Tartlets, European Charcuterie & Botanical Mocktails',
                    'highlights'=> ['Smoked Salmon Blinis, Parma Ham Bruschetta & Mini Quiches', 'Artisan Macarons, Eclairs & Scones with Clotted Cream', 'Fresh Botanical Mocktails & Single-Origin Ceylon Teas', 'Continuous Cocktail Wait Staff'],
                    'badge'     => 'Refined Social',
                ],
            ],
            'equipment_label'       => 'AV Staging, Podium, Dual LED Screens & Room Block Needs',
            'equipment_placeholder' => 'e.g. Dual P3 LED walls (4m x 2.5m), digital acrylic podium mic, simultaneous interpretation headsets (100 units), 15 VIP deluxe room blocks',
            'notes_label'           => 'Banquet Event Order (BEO) Directives, Valet & Protocol Notes',
            'notes_placeholder'     => 'Specify VIP dignitary protocols, valet parking vehicle counts, hotel room block check-in/out dates, and dietary requirements...',
        ];
    }

    /**
     * 5. GET TOGETHERS, SOCIAL MIXERS & LAWN BBQS CONFIGURATION
     */
    private static function getGetTogethersConfig(): array
    {
        return [
            'category_name'     => 'Get Togethers',
            'booking_prefix'    => 'BKG-GET-',
            'theme_badge'       => 'Casual Gatherings & Reunions',
            'theme_title'       => 'Social Mixer, Batch Reunion & Lawn BBQ Wizard',
            'theme_subtitle'    => 'Private lakeside villas, chef-manned charcoal BBQ grills, outdoor marquee tents, and sing-along acoustic sets for effortless reunions and batch get-togethers.',
            'alert_hook'        => 'Social Mixer & Lawn BBQ Setup',
            'theme_colors' => [
                'primary_glow'       => 'rgba(16, 185, 129, 0.45)',
                'secondary_glow'     => 'rgba(13, 148, 136, 0.4)',
                'accent'             => '#059669',
                'accent_glow'        => 'rgba(5, 150, 105, 0.35)',
                'surface_glass_card' => 'rgba(19, 32, 28, 0.8)',
                'active_border'      => 'rgba(16, 185, 129, 0.8)',
                'active_bg'          => 'rgba(16, 185, 129, 0.16)',
                'badge_color'        => '#a7f3d0',
                'orb_1'              => 'linear-gradient(135deg, #10b981, #059669)',
                'orb_2'              => 'linear-gradient(135deg, #0d9488, #0f766e)',
                'orb_3'              => 'linear-gradient(135deg, #f59e0b, #d97706)',
            ],
            'host_label'        => 'Batch / Family / Group Organizer Name',
            'host_placeholder'  => 'e.g. Royal College Class of 2012 / Fernandopulle Family Reunion',
            'date_label'        => 'Gathering Date',
            'session_day_title' => 'Daytime Lawn Picnic & Games',
            'session_day_desc'  => 'Outdoor marquee canopies, garden games, pool party, cold drinks & traditional village clay-pot lunch (10:00 AM – 04:00 PM)',
            'session_night_title' => 'Starlight BBQ & Sing-Along',
            'session_night_desc'=> 'Chef-manned charcoal grills, skewers, warm festoon bulbs, acoustic guitar duo & late-night sing-along (05:00 PM – 11:00 PM)',
            'guest_min'         => 20,
            'guest_max'         => 500,
            'guest_default'     => 100,
            'venues' => [
                [
                    'name'     => 'CR&FC Grounds Pavilion',
                    'capacity' => 'Up to 350 Attendees',
                    'tag'      => 'Lawn Pavilion • Live BBQ',
                    'city'     => 'Colombo 07',
                    'icon'     => 'fas fa-futbol',
                ],
                [
                    'name'     => 'Bolgoda Lake Resort Lawn',
                    'capacity' => 'Up to 150 Attendees',
                    'tag'      => 'Lakeside Villa • Poolside',
                    'city'     => 'Moratuwa',
                    'icon'     => 'fas fa-water',
                ],
                [
                    'name'     => 'Galle Face Chequerboard Terrace',
                    'capacity' => 'Up to 200 Attendees',
                    'tag'      => 'Ocean Sunset • High-Top Lounge',
                    'city'     => 'Colombo 03',
                    'icon'     => 'fas fa-wind',
                ],
                [
                    'name'     => 'Bentota Beach Resort Garden',
                    'capacity' => 'Up to 250 Attendees',
                    'tag'      => 'Tropical Palm Lawn • Beach Access',
                    'city'     => 'Bentota',
                    'icon'     => 'fas fa-umbrella-beach',
                ],
                [
                    'name'     => 'Villa Republic Poolside Garden',
                    'capacity' => 'Up to 80 Attendees',
                    'tag'      => 'Private Luxury Villa • Intimate',
                    'city'     => 'Bentota',
                    'icon'     => 'fas fa-swimming-pool',
                ],
                [
                    'name'     => 'Bespoke Private Lawn / Clubhouse',
                    'capacity' => 'Custom Gathering',
                    'tag'      => 'Private Estate / Ancestral Lawn',
                    'city'     => 'Islandwide',
                    'icon'     => 'fas fa-map-pin',
                ],
            ],
            'styles' => [
                'Bbq' => [
                    'title' => 'Outdoor Live Charcoal BBQ',
                    'icon'  => 'fas fa-fire-alt',
                    'color' => '#10b981',
                    'desc'  => 'Chef-manned charcoal grill, jumbo prawn skewers, gourmet burgers, festoon lighting & picnic benches.',
                ],
                'Family' => [
                    'title' => 'Village Clay-Pot Feast',
                    'icon'  => 'fas fa-utensils',
                    'color' => '#f59e0b',
                    'desc'  => 'Lakeside authentic clay-pot curries, live hoppers/roti action counter & traditional village hospitality.',
                ],
                'Alumni' => [
                    'title' => 'Alumni Sunset Cocktails',
                    'icon'  => 'fas fa-cocktail',
                    'color' => '#60a5fa',
                    'desc'  => 'Chequerboard ocean views, high-top illuminated cocktail tables, tapas grazing & karaoke sing-along.',
                ],
                'Batch' => [
                    'title' => 'Casual Lawn Picnic & Games',
                    'icon'  => 'fas fa-users',
                    'color' => '#a7f3d0',
                    'desc'  => 'Shaded marquee tents, cross-back seating, volleyball/cricket games & casual acoustic duo music.',
                ],
            ],
            'catering_tiers' => [
                'Platinum' => [
                    'name'      => 'Master Grill Charcoal BBQ Feast',
                    'rate'      => 5400.00,
                    'tagline'   => 'Live Charcoal Grill with Jumbo Prawns, Marinated Steaks & Gourmet Burger Bar',
                    'highlights'=> ['Live Chef Grills: Jumbo Prawns, Chicken Skewers & Angus Sliders', 'Corn on Cob, Roasted Jacket Potatoes & Fresh Garden Salads', 'Chilled Beer/Beverage Tubs with Continuous Ice Replenishment', 'Live Grill Chefs & Clean-Up Stewards'],
                    'badge'     => 'BBQ Masterpiece',
                ],
                'Executive' => [
                    'name'      => 'Authentic Clay-Pot Village Feast',
                    'rate'      => 4200.00,
                    'tagline'   => 'Traditional Sri Lankan Spread with Live Action Egg Hoppers & Roti',
                    'highlights'=> ['Clay-Pot Curries (Jaffna Crab, Black Pork, Dhal, Polos)', 'Live Hopper & Kottu Action Stations', 'Fresh Fruit Carafes & Traditional Watalappam Dessert', 'Clay-Pot Rustic Buffet Presentation'],
                    'badge'     => 'Authentic Ceylon',
                ],
                'Cocktail' => [
                    'name'      => 'Sunset Tapas & Grazing Board',
                    'rate'      => 3100.00,
                    'tagline'   => 'Artisan Sliders, Bruschettas, Nachos & Fruit Spritzers',
                    'highlights'=> ['Mini Chicken Burgers, Fish Cutlets & Vegetable Spring Rolls', 'Loaded Nacho Station with Guacamole & Sour Cream', 'Chilled Mocktail Pitchers & Fresh Lime Sodas', 'Self-Serve Grazing Table Setup'],
                    'badge'     => 'Casual Mixer',
                ],
            ],
            'equipment_label'       => 'Marquee Canopies, Picnic Furniture & Acoustic PA Needs',
            'equipment_placeholder' => 'e.g. 2 waterproof marquee tents (20x20 ft), 10 wooden picnic benches, fairy light festoon bulbs, wireless karaoke PA system, cricket kit',
            'notes_label'           => 'Batch Roster, Dietary Preferences & Nostalgia Playlist Notes',
            'notes_placeholder'     => 'Specify school/batch year, ice delivery preferences, BYOB corkage details, dietary counts (halal, vegetarian), and acoustic sing-along playlist requests...',
        ];
    }
}
