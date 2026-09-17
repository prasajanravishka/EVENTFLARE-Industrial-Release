<?php

namespace App\Services;

class EventShowcaseData
{
    /**
     * Get complete showcase configuration, case studies, roadmaps, and metrics for an event type.
     */
    public static function getCategoryData(string $type): array
    {
        $normalized = strtolower(trim($type));

        return match ($normalized) {
            'weddings', 'wedding' => self::getWeddingsData(),
            'dj parties', 'dj-parties', 'dj' => self::getDjPartiesData(),
            'birthdays', 'birthday' => self::getBirthdaysData(),
            'hotel venues', 'hotel-venues', 'hotels', 'hotel' => self::getHotelsData(),
            'get togethers', 'get-together', 'reunions' => self::getGetTogetherData(),
            default => self::getWeddingsData(),
        };
    }

    private static function getWeddingsData(): array
    {
        return [
            'category_name' => 'Weddings',
            'page_title'    => 'Royal Weddings & Poruwa Ceremonies — EVENTFLARE',
            'hero_badge'    => '<i class="fas fa-gem"></i> Curated Luxury Wedding Planning',
            'hero_title'    => 'Royal Poruwa Ceremonies &<br>Grand Wedding Celebrations',
            'hero_subtitle' => 'Celebrate your devotion with bespoke floral Poruwas, 5-star banquets, and cinematic memories. Browse through our executed weddings below, handpick accredited suppliers, and book your custom celebration.',
            'hero_image'    => 'assets/images/W1.jpg',
            'hero_card_tag' => 'Featured Wedding',
            'hero_card_title' => 'The Galle Coastal Wedding',
            'hero_card_desc' => 'Poruwa ceremony & luxury 3-course banquet planned by EVENTFLARE',
            'theme_color'   => '#ec4899',
            'theme_gradient'=> 'linear-gradient(135deg, rgba(236, 72, 153, 0.12), rgba(139, 92, 246, 0.1))',
            'metrics' => [
                ['val' => '150+', 'lbl' => 'Weddings Planned'],
                ['val' => '10', 'lbl' => 'Supplier Categories'],
                ['val' => '4.9 ★', 'lbl' => 'Couple Rating'],
                ['val' => '100%', 'lbl' => 'Verified Vendors']
            ],
            'filter_tabs' => [
                ['key' => 'all', 'lbl' => 'All Weddings (5)'],
                ['key' => 'poruwa', 'lbl' => 'Traditional Poruwa'],
                ['key' => 'coastal', 'lbl' => 'Coastal & Beachfront'],
                ['key' => 'ballroom', 'lbl' => 'Luxury Ballroom'],
                ['key' => 'garden', 'lbl' => 'Garden Romance']
            ],
            'case_studies' => [
                [
                    'id'          => 'bkg-wed-01',
                    'title'       => 'Kasun & Dilhani’s Grand Coastal Celebration',
                    'category'    => 'coastal',
                    'category_lbl'=> 'Coastal & Beachfront',
                    'venue'       => 'The Grand Cinnamon Cove Resort & Spa, Galle',
                    'date'        => 'October 24, 2026',
                    'guests'      => 280,
                    'image'       => 'assets/images/W1.jpg',
                    'tag'         => 'Traditional Poruwa & Coastal Lawn',
                    'summary'     => 'A breathtaking sunset ceremony overlooking the Indian Ocean. Featured a handcrafted floral Poruwa on the manicured lawn, followed by a 3-course seafood banquet and 4K aerial cinema.',
                    'services'    => [
                        'Decor & Poruwa'      => 'Lotus Floral Elegance (Royal Poruwa & Fresh Lotus Floral Mandap)',
                        'Catering'            => 'Grand Royal Banquet (Platinum 3-Course Buffet, 280 Pax)',
                        'Photography & Drone' => 'Aurora Cinematography (4K Drone Coverage & Pre-Shoot Reel)',
                        'Music & Atmosphere'  => 'Ranranga Cultural Troupe & Pulse DJ Live Beats'
                    ],
                    'quote'       => '"EVENTFLARE took care of all vendor coordination. Our coastal wedding in Galle was completely stress-free!"',
                    'client'      => 'Kasun & Dilhani Perera'
                ],
                [
                    'id'          => 'bkg-wed-06',
                    'title'       => 'Malithi & Roshan’s Royal Heritage Kandyan Wedding',
                    'category'    => 'poruwa',
                    'category_lbl'=> 'Traditional Poruwa',
                    'venue'       => 'The Kingsbury Victorian Ballroom, Colombo',
                    'date'        => 'December 18, 2026',
                    'guests'      => 320,
                    'image'       => 'assets/images/W2.jpg',
                    'tag'         => 'Authentic Cultural Grandeur',
                    'summary'     => 'A majestic traditional celebration filled with royal Sinhala customs. Honored with a 12-member Kandyan dance procession, sacred Ashtaka blessings, and exquisite gold-foil confectionery.',
                    'services'    => [
                        'Cultural Ensemble'   => 'Ranranga Traditional Ensemble (Kandyan Drummers & Jayamangala Choir)',
                        'Decor & Floral'      => 'Lotus Floral Elegance (Carved Heritage Poruwa & Oil Lamp Setup)',
                        'Confectionery'       => 'Sweet Symphony (3-Tier Belgian Chocolate & Gold Foil Cake)',
                        'Photography'         => 'Aurora Cinematography (Multi-camera 4K Ceremony Feature)'
                    ],
                    'quote'       => '"The traditional dancers and choir coordination were flawless. Every blessing stanza echoed with royal elegance."',
                    'client'      => 'Malithi De Silva'
                ],
                [
                    'id'          => 'bkg-wed-03',
                    'title'       => 'Ananya & Chathura’s Twilight Garden Vows',
                    'category'    => 'garden',
                    'category_lbl'=> 'Garden Romance',
                    'venue'       => 'Waters Edge Grand Pavilion, Battaramulla',
                    'date'        => 'June 15, 2026',
                    'guests'      => 180,
                    'image'       => 'assets/images/look-from-white-chairs-arranged-wedding-ceremony.jpg',
                    'tag'         => 'Fairy-Light Botanical Garden',
                    'summary'     => 'An enchanting outdoor evening celebration under canopies of fairy lights and vintage wooden cross-back seating. Featured bespoke artisanal grazing stations and an unplugged acoustic trio.',
                    'services'    => [
                        'Outdoor Staging'     => 'Lotus Floral Decor (Vintage Cross-Back Chairs & Canopy)',
                        'Bar & Drinks'        => 'Velvet Mobile Cocktail Bar (Botanical Spritzers & Mocktails)',
                        'Artisan Grazing'     => 'Sweet Symphony (Parisian Macaron Grazing Table)',
                        'Acoustic Music'      => 'Pulse Live Beats (Unplugged Acoustic Trio & Vocals)'
                    ],
                    'quote'       => '"Our guests are still talking about the fairytale fairy-light setup and the custom dessert station!"',
                    'client'      => 'Ananya & Chathura'
                ],
                [
                    'id'          => 'bkg-wed-04',
                    'title'       => 'Dinesh & Senuri’s Minimalist Beachfront Vows',
                    'category'    => 'coastal',
                    'category_lbl'=> 'Coastal & Beachfront',
                    'venue'       => 'Jetwing Lighthouse Oceanside, Galle',
                    'date'        => 'February 12, 2026',
                    'guests'      => 150,
                    'image'       => 'assets/images/wedding-couple-best-friends-are-drinking-champagne-celebrating-park-wedding-day.jpg',
                    'tag'         => 'Boho Sunset Chic',
                    'summary'     => 'An intimate seaside union illuminated by golden-hour sunset skies. Featured a natural driftwood arch, champagne toast reception, and candid documentary photojournalism.',
                    'services'    => [
                        'Seaside Arch'        => 'Lotus Floral Elegance (Organic Pampas & Orchid Arch)',
                        'Hospitality'         => 'Grand Royal Catering (Artisan Canapés & Cocktail Reception)',
                        'Photography'         => 'Aurora Cinematography (Golden Hour Drone Portraits)',
                        'Security & Valet'    => 'Aegis Event Security (VIP Guest Escort & Valet Entry)'
                    ],
                    'quote'       => '"Seamless scheduling from start to finish. Everything matched our minimalist vision."',
                    'client'      => 'Dinesh & Senuri'
                ],
                [
                    'id'          => 'bkg-wed-05',
                    'title'       => 'Nadeesha & Kavindu’s Palatial Crystal Ballroom Reception',
                    'category'    => 'ballroom',
                    'category_lbl'=> 'Luxury Ballroom',
                    'venue'       => 'Shangri-La Main Ballroom, Colombo 02',
                    'date'        => 'January 10, 2026',
                    'guests'      => 420,
                    'image'       => 'assets/images/W4.jpg',
                    'tag'         => 'Modern Luxury & Crystal Chandeliers',
                    'summary'     => 'A high-profile grand wedding gala with imported chandeliers, concert-grade acoustic engineering, dual LED wall visuals, and an extravagant 5-course international dining experience.',
                    'services'    => [
                        'Ballroom Rigging'    => 'Lumina Audio Visual (Line Array Sound & Intelligent Uplighting)',
                        'Catering'            => 'Grand Royal Banquet (5-Course Plated & Carvery Feast)',
                        'Entertainment'       => 'Pulse DJ & Live Beats (Saxophone & Club Hits DJ Setup)',
                        'Custom Cake'         => 'Sweet Symphony (4-Tier Hand-Painted Floral Cake)'
                    ],
                    'quote'       => '"World-class ballroom rigging and dining. Our international guests were completely blown away."',
                    'client'      => 'Nadeesha & Kavindu'
                ]
            ],
            'steps' => [
                [
                    'num' => '1',
                    'title' => 'Pick Venue & Poruwa Setting',
                    'desc' => 'Select beachfront lawn, grand ballroom, or heritage pavilion; choose traditional Poruwa carvings vs. modern floral arches.'
                ],
                [
                    'num' => '2',
                    'title' => 'Calculate Catering & Guesthead',
                    'desc' => 'Use our live cost estimator to calculate 3-course buffets, dessert grazing tables, and welcome beverages for your exact guest count.'
                ],
                [
                    'num' => '3',
                    'title' => 'Handpick Certified Artisans',
                    'desc' => 'Select accredited Poruwa florists, revered Ashtaka narrators, Jayamangala choir vocalists, Kandyan dancers, and 4K drone cinematographers.'
                ],
                [
                    'num' => '4',
                    'title' => 'Track Timeline & PDF Dossier',
                    'desc' => 'Coordinate ritual timings with the concierge, track reservation milestones in your portal, and export your itemized event dossier to PDF.'
                ]
            ],
            'testimonials' => [
                [
                    'stars' => 5,
                    'quote' => 'EVENTFLARE took care of all vendor coordination. Our coastal wedding in Galle was completely stress-free! The drone footage by Aurora was breathtaking.',
                    'name'  => 'Kasun & Dilhani Perera',
                    'venue' => 'Grand Cinnamon Cove, Galle'
                ],
                [
                    'stars' => 5,
                    'quote' => 'The traditional dancers and choir coordination were flawless. Every blessing stanza echoed with royal elegance. Having our budget and supplier list in one PDF dossier made life so easy.',
                    'name'  => 'Malithi De Silva',
                    'venue' => 'Kingsbury Ballroom, Colombo'
                ],
                [
                    'stars' => 5,
                    'quote' => 'Our guests are still raving about the fairy-light setup and the custom dessert station. Being able to pre-calculate catering costs kept us right on budget!',
                    'name'  => 'Ananya & Chathura',
                    'venue' => 'Waters Edge, Battaramulla'
                ]
            ],
            'cta_title' => 'Ready to Begin Your Wedding Story?',
            'cta_desc'  => 'Let EVENTFLARE connect you with accredited vendors, manage your event timeline, and turn your dream celebration into reality.'
        ];
    }

    private static function getDjPartiesData(): array
    {
        return [
            'category_name' => 'DJ Parties',
            'page_title'    => 'DJ Parties, Club Raves & Audio-Visual Production — EVENTFLARE',
            'hero_badge'    => '<i class="fas fa-bolt"></i> High-Voltage Audio & Lighting Rigs',
            'hero_title'    => 'DJ Parties & Intelligent Stage Production',
            'hero_subtitle' => 'Turn up the energy with concert line arrays, multi-beam laser shows, licensed mobile cocktail bars, and chart-topping DJs across Sri Lanka.',
            'hero_image'    => 'assets/images/happy-men-women-throwing-confetti.jpg',
            'hero_card_tag' => 'Featured Rave',
            'hero_card_title' => 'Neon Nights Rooftop Rave',
            'hero_card_desc' => 'Intelligent moving heads, 4K lasers & 4-hour non-stop EDM set',
            'theme_color'   => '#6366f1',
            'theme_gradient'=> 'linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(6, 182, 212, 0.1))',
            'metrics' => [
                ['val' => '85+', 'lbl' => 'Parties & Raves'],
                ['val' => '50KW', 'lbl' => 'Audio Rig Power'],
                ['val' => '4.9 ★', 'lbl' => 'Party Rating'],
                ['val' => '100%', 'lbl' => 'SIA Security Vetted']
            ],
            'filter_tabs' => [
                ['key' => 'all', 'lbl' => 'All Parties (4)'],
                ['key' => 'rave', 'lbl' => 'EDM & Club Raves'],
                ['key' => 'sunset', 'lbl' => 'Sunset & Rooftops'],
                ['key' => 'gala', 'lbl' => 'Mega Galas & Arenas'],
                ['key' => 'beach', 'lbl' => 'Beach Club & Pool']
            ],
            'case_studies' => [
                [
                    'id'          => 'bkg-djp-01',
                    'title'       => 'Neon Nights Rooftop Rave & Laser Show',
                    'category'    => 'rave',
                    'category_lbl'=> 'EDM & Club Raves',
                    'venue'       => 'Cinnamon Lakeside Rooftop Lounge, Colombo',
                    'date'        => 'November 14, 2026',
                    'guests'      => 250,
                    'image'       => 'assets/images/happy-men-women-throwing-confetti.jpg',
                    'tag'         => 'High-Octane EDM & 4K Laser Rig',
                    'summary'     => 'An electrifying sky-high party featuring intelligent beam movers, heavy low-end subwoofers, a synchronized laser show, and live mix sets from premier Sri Lankan DJs.',
                    'services'    => [
                        'A/V & Light Rig'     => 'Lumina Audio Visual (Concert Moving Heads & Laser Truss)',
                        'DJ & Artists'        => 'Pulse DJ & Live Beats (Headliner 4-Hour Nonstop EDM Set)',
                        'Bar & Beverages'     => 'Velvet Mobile Cocktail Bar (Signature Neon Cocktails & Shots)',
                        'Security & Access'   => 'Aegis Event Security (Bouncers & VIP Wristband Control)'
                    ],
                    'quote'       => '"The sound quality and laser sync blew everyone away! The rooftop was buzzing all night long."',
                    'client'      => 'Kavinda & Friends (Annual Reunion)'
                ],
                [
                    'id'          => 'bkg-djp-02',
                    'title'       => 'Sunset Beats Beachfront Deep House Lounge',
                    'category'    => 'sunset',
                    'category_lbl'=> 'Sunset & Rooftops',
                    'venue'       => 'Bentota Beach Resort Palm Lawn',
                    'date'        => 'January 23, 2026',
                    'guests'      => 180,
                    'image'       => 'assets/images/happy-people-celebrating-having-fun.jpg',
                    'tag'         => 'Tropical Deep House & Cocktails',
                    'summary'     => 'A bohemian beachfront sunset gathering with chill deep house grooves, warm festoon lighting, artisanal grazing tables, and a craft rum mixology station.',
                    'services'    => [
                        'Sound & Ambient Rig' => 'Lumina Audio Visual (Weatherproof Sound & Warm String Bulbs)',
                        'Live Mix Performer'  => 'Pulse DJ (Sunset Melodic & Organic Deep House)',
                        'Cocktail Bar'        => 'Velvet Mobile Bar (Coconut Spritzers & Rum Infusions)',
                        'Lawn Staging'        => 'Lotus Floral & Decor (Boho Low Seating & Bean Bags)'
                    ],
                    'quote'       => '"Watching the sun dip below the ocean while sipping craft cocktails with smooth deep house beats was pure magic."',
                    'client'      => 'Ayesha & Tarik (Private Sundowner)'
                ],
                [
                    'id'          => 'bkg-djp-03',
                    'title'       => 'Apex Innovations Mega Gala & After-Party',
                    'category'    => 'gala',
                    'category_lbl'=> 'Mega Galas & Arenas',
                    'venue'       => 'BMICH Main Exhibition Hall B, Colombo',
                    'date'        => 'October 08, 2026',
                    'guests'      => 500,
                    'image'       => 'assets/images/party.jpg',
                    'tag'         => 'Arena Stage & International Line Array',
                    'summary'     => 'A high-impact corporate celebration transitioning into an arena-scale dance bash with 12-meter LED walls, CO2 jets, and dual headliner DJs.',
                    'services'    => [
                        'Concert Rig'         => 'Lumina Audio Visual (Dual Line Arrays & P3 LED Backdrop)',
                        'DJs & Live Acts'     => 'Pulse DJ & Live Beats (Commercial Top-40 & EDM Mashups)',
                        'VIP Hospitality'     => 'Grand Royal Banquet (Interactive Live Cooking & Tapas)',
                        'Security Force'      => 'Aegis Security (10 SIA Officers & Metal Detection Gateways)'
                    ],
                    'quote'       => '"From keynote sound to late-night party vibes, the production standard was world-class."',
                    'client'      => 'Apex Innovations Committee'
                ],
                [
                    'id'          => 'bkg-djp-04',
                    'title'       => 'Mount Lavinia Full Moon Neon Beach Bash',
                    'category'    => 'beach',
                    'category_lbl'=> 'Beach Club & Pool',
                    'venue'       => 'Mount Lavinia Private Beach Arena',
                    'date'        => 'December 05, 2026',
                    'guests'      => 350,
                    'image'       => 'assets/images/evnt.jpg',
                    'tag'         => 'Neon Glow Body Paint & Coastal Beats',
                    'summary'     => 'An open-air beach party with neon UV body paint stations, fire dancers, illuminated cocktail bars, and heavy bass lines pounding under the ocean breeze.',
                    'services'    => [
                        'Audio & UV Staging'  => 'Lumina Audio Visual (Weatherproof Subwoofers & UV Cannons)',
                        'DJ & Live Percussion'=> 'Pulse DJ & Live Beats (Live Bongo Percussion & House Beats)',
                        'Mobile Bar'          => 'Velvet Mobile Bar (Tiki Cocktails & Craft Mocktails)',
                        'Perimeter Security'  => 'Aegis Event Security (Beach Perimeter Patrol & First Aid)'
                    ],
                    'quote'       => '"The atmosphere was unreal. The live percussion accompanying the DJ took the energy through the roof!"',
                    'client'      => 'Dilhani Senanayake'
                ]
            ],
            'steps' => [
                [
                    'num' => '1',
                    'title' => 'Select Arena & Sound Scale',
                    'desc' => 'Pick indoor club, beach lawn, or rooftop terrace; choose column PA vs. concert dual line array.'
                ],
                [
                    'num' => '2',
                    'title' => 'Configure Lighting, Lasers & Stage Rig',
                    'desc' => 'Configure moving-head beams, high-power RGB lasers, haze machines, CO2 cryo cannons, and stage trussing.'
                ],
                [
                    'num' => '3',
                    'title' => 'Book Headline DJs & Mixology Bar',
                    'desc' => 'Select chart-topping DJs, live saxophonists, licensed flair mixologists, and SIA-certified security bouncers.'
                ],
                [
                    'num' => '4',
                    'title' => 'Authorize Rider & Entry Passes',
                    'desc' => 'Finalize technical audio-visual riders, issue guest credentials/wristbands, and export the technical production dossier.'
                ]
            ],
            'testimonials' => [
                [
                    'stars' => 5,
                    'quote' => 'The sound quality and laser sync blew everyone away! The rooftop was buzzing all night long.',
                    'name'  => 'Kavinda & Friends',
                    'venue' => 'Cinnamon Lakeside, Colombo'
                ],
                [
                    'stars' => 5,
                    'quote' => 'Watching the sun dip below the ocean while sipping craft cocktails with smooth deep house beats was pure magic.',
                    'name'  => 'Ayesha & Tarik',
                    'venue' => 'Bentota Beach Resort'
                ],
                [
                    'stars' => 5,
                    'quote' => 'Aegis security kept everything controlled and safe while Pulse DJ kept 500 guests dancing till 2 AM.',
                    'name'  => 'Dilhani Senanayake',
                    'venue' => 'Mount Lavinia Beach Arena'
                ]
            ],
            'cta_title' => 'Ready to Electrify Your Night?',
            'cta_desc'  => 'Lock in Sri Lanka’s top audio crews, headline DJs, and mobile cocktail mixologists for your upcoming rave or party.'
        ];
    }

    private static function getBirthdaysData(): array
    {
        return [
            'category_name' => 'Birthdays',
            'page_title'    => 'Birthdays & Milestone Celebrations — EVENTFLARE',
            'hero_badge'    => '<i class="fas fa-birthday-cake"></i> Milestone Jubilee & Kids Celebrations',
            'hero_title'    => 'Birthdays & Jubilee Celebrations',
            'hero_subtitle' => 'Bespoke 3D sculpted cakes, organic balloon dreamscapes, live magic performers, and kid-friendly catering designed for joyful milestones.',
            'hero_image'    => 'assets/images/B1.jpg',
            'hero_card_tag' => 'Featured Birthday',
            'hero_card_title' => 'Aarav’s 1st Jungle Safari',
            'hero_card_desc' => '3-tier animal cake, interactive games & organic balloon arches',
            'theme_color'   => '#f59e0b',
            'theme_gradient'=> 'linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(244, 63, 94, 0.1))',
            'metrics' => [
                ['val' => '220+', 'lbl' => 'Birthdays Celebrated'],
                ['val' => '50+', 'lbl' => 'Custom Themes'],
                ['val' => '4.9 ★', 'lbl' => 'Parent Rating'],
                ['val' => '100%', 'lbl' => 'Food Safety Certified']
            ],
            'filter_tabs' => [
                ['key' => 'all', 'lbl' => 'All Celebrations (4)'],
                ['key' => 'kids', 'lbl' => 'Kids & Adventure'],
                ['key' => 'sweet16', 'lbl' => 'Sweet 16 & 21st'],
                ['key' => 'milestone', 'lbl' => 'Milestone Jubilees'],
                ['key' => 'fairytale', 'lbl' => 'Princess & Fairytale']
            ],
            'case_studies' => [
                [
                    'id'          => 'bkg-bdy-01',
                    'title'       => 'Aarav’s 1st Wild Jungle Safari Adventure',
                    'category'    => 'kids',
                    'category_lbl'=> 'Kids & Adventure',
                    'venue'       => 'Waters Edge Grand Pavilion Lawn, Battaramulla',
                    'date'        => 'July 18, 2026',
                    'guests'      => 80,
                    'image'       => 'assets/images/B1.jpg',
                    'tag'         => 'Jungle Safari & 3D Animal Cake',
                    'summary'     => 'A playful, vibrant first birthday transformed into a tropical safari. Featured customized organic balloon garlands, lifelike animal props, interactive mascot games, and a chocolate jungle river fountain.',
                    'services'    => [
                        'Themed Decor'        => 'Lotus Floral & Decor (Organic 3-Tier Safari Balloon Arch & Plinths)',
                        'Artisan Cake'        => 'Sweet Symphony (3-Tier Fondant Jungle Animal Sculpture Cake)',
                        'Entertainment'       => 'Ranranga Interactive Games & Magic Show Troupe',
                        'Kids Catering'       => 'Grand Royal Catering (Mini Chicken Sliders, Pizza Bites & Fruit Skewers)'
                    ],
                    'quote'       => '"Aarav’s first birthday looked like a storybook wonderland. The custom animal cake was breathtaking!"',
                    'client'      => 'Dr. Dinesh & Nilushi Ranasinghe'
                ],
                [
                    'id'          => 'bkg-bdy-02',
                    'title'       => 'Senuri’s Sweet 16 Parisian Glamour Gala',
                    'category'    => 'sweet16',
                    'category_lbl'=> 'Sweet 16 & 21st',
                    'venue'       => 'The Kingsbury Balmoral Ballroom, Colombo',
                    'date'        => 'September 05, 2026',
                    'guests'      => 120,
                    'image'       => 'assets/images/B2.jpg',
                    'tag'         => 'Rose Gold Elegance & Macaron Towers',
                    'summary'     => 'An exquisite sweet sixteen inspired by Parisian haute couture. Styled with rose gold sequin arches, bespoke photobooth mirror, a luxury French dessert spread, and a private teen dancefloor with DJ beats.',
                    'services'    => [
                        'Glamour Decor'       => 'Lotus Floral Elegance (Rose Gold Shimmer Wall & Floral Rings)',
                        'French Patisserie'   => 'Sweet Symphony (Custom Macaron Tower & Belgian Truffle Bar)',
                        'DJ & Lighting'       => 'Pulse DJ & Live Beats (Top-40 Commercial & Teen Dance Rig)',
                        'High Tea Banquet'    => 'Grand Royal Catering (Deluxe High Tea & Mocktail Spritzers)'
                    ],
                    'quote'       => '"My daughter and her school friends felt like royalty. Everything from the photo booth to the music was on point!"',
                    'client'      => 'Chathurika Wickremasinghe'
                ],
                [
                    'id'          => 'bkg-bdy-03',
                    'title'       => 'Uncle Nihal’s 60th Vintage Diamond Jubilee',
                    'category'    => 'milestone',
                    'category_lbl'=> 'Milestone Jubilees',
                    'venue'       => 'Mount Lavinia Hotel Ocean Terrace',
                    'date'        => 'October 12, 2026',
                    'guests'      => 150,
                    'image'       => 'assets/images/B3.jpg',
                    'tag'         => 'Golden Milestone & Acoustic Jazz',
                    'summary'     => 'A sophisticated 60th diamond jubilee celebrating six decades of memories. Featured a retrospective memory photo gallery, live saxophone jazz trio, and a bespoke carvery buffet under seaside stars.',
                    'services'    => [
                        'Heritage Staging'    => 'Lotus Decor (Warm Fairy Light Canopies & Retrospective Photo Wall)',
                        'Jubilee Cake'        => 'Sweet Symphony (Classic 2-Tier Rich Plum & Gold Accent Cake)',
                        'Acoustic Jazz'       => 'Pulse Live Beats (Saxophone & Double Bass Jazz Ensemble)',
                        'Seaside Banquet'     => 'Grand Royal Banquet (Slow-Roasted Carvery & Seafood Spread)'
                    ],
                    'quote'       => '"A deeply touching, perfectly coordinated evening. EVENTFLARE honored our family patriarch with unmatched poise."',
                    'client'      => 'Suren & Dilani Gooneratne'
                ],
                [
                    'id'          => 'bkg-bdy-04',
                    'title'       => 'Princess Aria’s Enchanted Fairytale Castle Party',
                    'category'    => 'fairytale',
                    'category_lbl'=> 'Princess & Fairytale',
                    'venue'       => 'Cinnamon Grand Garden Suite Lawn, Colombo',
                    'date'        => 'May 14, 2026',
                    'guests'      => 60,
                    'image'       => 'assets/images/cake.jpg',
                    'tag'         => 'Enchanted Castle & Cotton Candy Cloud Bar',
                    'summary'     => 'A fairytale kingdom brought to life with pastel castle facades, real life Cinderella and Prince mascots, glitter face-painting artists, and a live cotton candy cloud cart.',
                    'services'    => [
                        'Themed Backdrops'    => 'Lotus Decor (Hand-Painted Castle Facade & Throne Chair)',
                        'Sculpted Cake'       => 'Sweet Symphony (Castle-Shaped Fondant Cake with Sugar Pearls)',
                        'Performers'          => 'Ranranga Theatre Troupe (Costumed Mascots & Magic Mirror)',
                        'Dessert Counter'     => 'Grand Royal Catering (Artisan Waffles & Cotton Candy Station)'
                    ],
                    'quote'       => '"Aria was in tears of joy when she saw Cinderella and the castle. Best party ever!"',
                    'client'      => 'Hansi Madushani'
                ]
            ],
            'steps' => [
                [
                    'num' => '1',
                    'title' => 'Choose Theme & Creative Concept',
                    'desc' => 'Define your party concept: Jungle Safari, Sweet 16 Glamour, 60th Diamond Jubilee, or Fairytale Castle.'
                ],
                [
                    'num' => '2',
                    'title' => 'Design Custom Cake & Confectionery',
                    'desc' => 'Order bespoke 3D sculpted cakes, matching cupcake towers, or French macaron grazing stations.'
                ],
                [
                    'num' => '3',
                    'title' => 'Book Animators, Decor & Magic Acts',
                    'desc' => 'Handpick organic balloon garlands, photo booth mirrors, magicians, game emcees, or live acoustic trios.'
                ],
                [
                    'num' => '4',
                    'title' => 'Schedule Itinerary & Party Dossier',
                    'desc' => 'Lock in party schedules, confirm final RSVPs, and generate your celebration itinerary slip.'
                ]
            ],
            'testimonials' => [
                [
                    'stars' => 5,
                    'quote' => 'Aarav’s first birthday looked like a storybook wonderland. The custom animal cake was breathtaking!',
                    'name'  => 'Dr. Dinesh & Nilushi Ranasinghe',
                    'venue' => 'Waters Edge, Battaramulla'
                ],
                [
                    'stars' => 5,
                    'quote' => 'My daughter and her school friends felt like royalty. Everything from the photo booth to the music was on point!',
                    'name'  => 'Chathurika Wickremasinghe',
                    'venue' => 'Kingsbury Balmoral Ballroom'
                ],
                [
                    'stars' => 5,
                    'quote' => 'A deeply touching, perfectly coordinated evening. EVENTFLARE honored our family patriarch with unmatched poise.',
                    'name'  => 'Suren & Dilani Gooneratne',
                    'venue' => 'Mount Lavinia Hotel Ocean Terrace'
                ]
            ],
            'cta_title' => 'Ready to Celebrate a Milestone?',
            'cta_desc'  => 'Let our accredited cake artisans, entertainers, and decorators craft a birthday celebration your family will cherish forever.'
        ];
    }

    private static function getHotelsData(): array
    {
        return [
            'category_name' => 'Hotel Venues',
            'page_title'    => 'Five-Star Hotel Venues & Galas — EVENTFLARE',
            'hero_badge'    => '<i class="fas fa-hotel"></i> Five-Star Hospitality & Ballrooms',
            'hero_title'    => 'Five-Star Hotel Venues & Galas',
            'hero_subtitle' => 'Oceanfront grand ballrooms, crystal chandelier halls, executive culinary teams, and luxury accommodations for landmark celebrations and corporate banquets.',
            'hero_image'    => 'assets/images/H1.jpg',
            'hero_card_tag' => 'Featured Venue',
            'hero_card_title' => 'Grand Horizon Oceanview Ballroom',
            'hero_card_desc' => 'Palatial crystal chandelier hall & private bridal suite at Cinnamon Cove',
            'theme_color'   => '#d97706',
            'theme_gradient'=> 'linear-gradient(135deg, rgba(217, 119, 6, 0.15), rgba(71, 85, 105, 0.1))',
            'metrics' => [
                ['val' => '40+', 'lbl' => 'Luxury Venues'],
                ['val' => '5-Star', 'lbl' => 'Hotel Partners'],
                ['val' => '4.9 ★', 'lbl' => 'Host Rating'],
                ['val' => '100%', 'lbl' => 'Concierge Coordinated']
            ],
            'filter_tabs' => [
                ['key' => 'all', 'lbl' => 'All Venues (4)'],
                ['key' => 'ballroom', 'lbl' => 'Palatial Ballrooms'],
                ['key' => 'lawn', 'lbl' => 'Sunset Ocean Lawns'],
                ['key' => 'suites', 'lbl' => 'VIP Suite Blocks'],
                ['key' => 'conference', 'lbl' => 'Conference Halls']
            ],
            'case_studies' => [
                [
                    'id'          => 'bkg-htl-01',
                    'title'       => 'Grand Horizon Oceanview Ballroom Gala',
                    'category'    => 'ballroom',
                    'category_lbl'=> 'Palatial Ballrooms',
                    'venue'       => 'The Grand Cinnamon Cove Resort & Spa, Galle',
                    'date'        => 'November 18, 2026',
                    'guests'      => 300,
                    'image'       => 'assets/images/H1.jpg',
                    'tag'         => 'Crystal Chandeliers & Executive Banquet',
                    'summary'     => 'A palatial oceanfront celebration in the Grand Horizon Ballroom, equipped with integrated acoustic panels, imported crystal fixtures, and five-star culinary service.',
                    'services'    => [
                        'Hall Reservation'    => 'The Grand Cinnamon Cove (Full Day Main Ballroom & Foyer)',
                        'Executive Dining'    => 'In-House Five-Star Culinary (International Seafood Buffet)',
                        'Audio/Visual'        => 'Lumina AV (Line Array Speech Clarity & Intelligent Mood Wash)',
                        'Valet & Concierge'   => 'Aegis Security (6-Officer Uniformed Valet Team & Lobby Reception)'
                    ],
                    'quote'       => '"Flawless banquet service and breathtaking ocean views. Our high-profile guests were thrilled."',
                    'client'      => 'Amanda Ratnayake (GM)'
                ],
                [
                    'id'          => 'bkg-htl-02',
                    'title'       => 'Sunset Beachside Lawn Corporate Sundowner',
                    'category'    => 'lawn',
                    'category_lbl'=> 'Sunset Ocean Lawns',
                    'venue'       => 'Jetwing Lighthouse Oceanside, Galle',
                    'date'        => 'August 20, 2026',
                    'guests'      => 150,
                    'image'       => 'assets/images/H2.jpg',
                    'tag'         => 'Cliffside Ocean Breeze & Cocktail Reception',
                    'summary'     => 'A prestigious alumni and corporate mixer on the historic lighthouse lawns, featuring passed canapés, craft gin spritzers, and sunset jazz melodies.',
                    'services'    => [
                        'Lawn Booking'        => 'Jetwing Lighthouse (Private Oceanfront Cliff Lawn)',
                        'Canapés & Tapas'     => 'Grand Royal Catering (Artisan Seafood & Cheese Grazing)',
                        'Bar Services'        => 'Velvet Mobile Bar (Botanical Cocktail & Single Malt Bar)',
                        'Live Jazz'           => 'Pulse Live Beats (Unplugged Saxophone & Acoustic Trio)'
                    ],
                    'quote'       => '"The ocean breeze, sunset lighting, and exceptional food made our annual alumni reunion unforgettable."',
                    'client'      => 'Dilhani Senanayake'
                ],
                [
                    'id'          => 'bkg-htl-03',
                    'title'       => 'Shangri-La Main Ballroom International Symposium',
                    'category'    => 'conference',
                    'category_lbl'=> 'Conference Halls',
                    'venue'       => 'Shangri-La Main Ballroom, Colombo 02',
                    'date'        => 'June 15, 2026',
                    'guests'      => 220,
                    'image'       => 'assets/images/H3.jpg',
                    'tag'         => 'Dual LED Walls & Plated 3-Course Luncheon',
                    'summary'     => 'A state-of-the-art medical leadership conference with simultaneous interpretation headsets, 4K livestream broadcasts, and high-tea buffets.',
                    'services'    => [
                        'Symposium Staging'   => 'Shangri-La Ballroom Management (Full Rig & Breakout Rooms)',
                        'Executive Plated'    => 'Shangri-La Executive Chefs (3-Course Plated Health Luncheon)',
                        'Simultaneous AV'     => 'Lumina Audio Visual (Interpretation Radios & Dual LED Displays)',
                        'VIP Guest Rooms'     => 'Cinnamon Cove & Shangri-La Deluxe Room Blocks (30 Suites)'
                    ],
                    'quote'       => '"Precision technical AV and five-star hospitality throughout our three-day international conference."',
                    'client'      => 'Dr. Priyantha Dissanayake'
                ],
                [
                    'id'          => 'bkg-htl-04',
                    'title'       => 'Earls Regency Heritage Mountain Banquet',
                    'category'    => 'ballroom',
                    'category_lbl'=> 'Palatial Ballrooms',
                    'venue'       => 'Earls Regency Grand Ballroom, Kandy',
                    'date'        => 'October 05, 2026',
                    'guests'      => 190,
                    'image'       => 'assets/images/H4.jpg',
                    'tag'         => 'Mountain Panorama & Central Province Heritage',
                    'summary'     => 'An elegant hill-country jubilee dinner overlooking the Mahaweli River valley, accented with warm copper lanterns, live chamber strings, and traditional Kandyan confectionery.',
                    'services'    => [
                        'Ballroom Staging'    => 'Earls Regency Banquets (Riverview Terrace & Grand Hall)',
                        'Cuisine'             => 'In-House Banquet Team (Traditional Upcountry & Western Fusion)',
                        'Chamber Music'       => 'Pulse Live Beats (String Quartet & Flute Accompaniment)',
                        'Dessert Platters'    => 'Sweet Symphony (Artisan Confectionery & Belgian Chocolates)'
                    ],
                    'quote'       => '"The mountain views and ballroom ambience were stunning. Every detail was executed with grace."',
                    'client'      => 'Ananya Sharma'
                ]
            ],
            'steps' => [
                [
                    'num' => '1',
                    'title' => 'Select Grand Hall & Layout',
                    'desc' => 'Explore 5-star oceanview ballrooms, intimate executive boardrooms, or open terraces with flexible seating.'
                ],
                [
                    'num' => '2',
                    'title' => 'Customize In-House Cuisine',
                    'desc' => 'Coordinate directly with executive hotel chefs for plated 3-course dining, multi-cuisine buffets, or high teas.'
                ],
                [
                    'num' => '3',
                    'title' => 'Arrange AV Staging & Room Blocks',
                    'desc' => 'Book podium line-array microphones, dual high-lumen screens, and discounted VIP suite blocks.'
                ],
                [
                    'num' => '4',
                    'title' => 'Lock Banqueting Contract & Valet',
                    'desc' => 'Finalize banquet event orders, coordinate valet parking and security, and export the official hotel booking slip.'
                ]
            ],
            'testimonials' => [
                [
                    'stars' => 5,
                    'quote' => 'Flawless banquet service and breathtaking ocean views. Our high-profile guests were thrilled.',
                    'name'  => 'Amanda Ratnayake',
                    'venue' => 'Cinnamon Cove Resort, Galle'
                ],
                [
                    'stars' => 5,
                    'quote' => 'Precision technical AV and five-star hospitality throughout our three-day international conference.',
                    'name'  => 'Dr. Priyantha Dissanayake',
                    'venue' => 'Shangri-La Ballroom, Colombo'
                ],
                [
                    'stars' => 5,
                    'quote' => 'The ocean breeze, sunset lighting, and exceptional food made our annual alumni reunion unforgettable.',
                    'name'  => 'Tharushi Alwis',
                    'venue' => 'Jetwing Lighthouse, Galle'
                ]
            ],
            'cta_title' => 'Host at Sri Lanka’s Premier Venues',
            'cta_desc'  => 'Lock in verified five-star ballrooms, beachside pavilions, and bespoke banquet packages with upfront pricing.'
        ];
    }

    private static function getGetTogetherData(): array
    {
        return [
            'category_name' => 'Get Togethers',
            'page_title'    => 'Social Mixers, Batch Reunions & Lawn BBQs — EVENTFLARE',
            'hero_badge'    => '<i class="fas fa-handshake"></i> Casual Gatherings & Reunions',
            'hero_title'    => 'Social Mixers, Batch Parties & Lawn BBQs',
            'hero_subtitle' => 'Private lakeside villas, chef-manned charcoal BBQ grills, outdoor marquee tents, and sing-along acoustic sets for effortless reunions and batch get-togethers.',
            'hero_image'    => 'assets/images/G1.jpg',
            'hero_card_tag' => 'Featured Gathering',
            'hero_card_title' => 'Class of 2012 CR&FC Reunion',
            'hero_card_desc' => 'Live charcoal grill feast, marquee canopies & unplugged sing-along',
            'theme_color'   => '#10b981',
            'theme_gradient'=> 'linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(13, 148, 136, 0.1))',
            'metrics' => [
                ['val' => '110+', 'lbl' => 'Reunions Planned'],
                ['val' => '100%', 'lbl' => 'Fresh Charcoal BBQ'],
                ['val' => '4.9 ★', 'lbl' => 'Alumni Rating'],
                ['val' => '0%', 'lbl' => 'Rainout Guarantee']
            ],
            'filter_tabs' => [
                ['key' => 'all', 'lbl' => 'All Gatherings (4)'],
                ['key' => 'bbq', 'lbl' => 'Outdoor BBQ & Lawn'],
                ['key' => 'family', 'lbl' => 'Family Reunions'],
                ['key' => 'alumni', 'lbl' => 'Alumni Mixers'],
                ['key' => 'batch', 'lbl' => 'Batch Parties']
            ],
            'case_studies' => [
                [
                    'id'          => 'bkg-gtg-01',
                    'title'       => 'Royal College Class of 2012 Reunion & Live BBQ',
                    'category'    => 'bbq',
                    'category_lbl'=> 'Outdoor BBQ',
                    'venue'       => 'CR&FC Grounds Pavilion, Colombo 07',
                    'date'        => 'August 22, 2026',
                    'guests'      => 200,
                    'image'       => 'assets/images/G1.jpg',
                    'tag'         => 'Live Charcoal Grill & Acoustic Hits',
                    'summary'     => 'A spirited reunion bringing together 200 old classmates. Featured a live chef-manned BBQ grill with skewers and burgers, chilled beverage stations, an unplugged acoustic band, and nostalgic batch sports.',
                    'services'    => [
                        'Catering & Grill'    => 'Grand Royal Banquet (Live Outdoor Charcoal BBQ & Skewers Feast)',
                        'Canopy & Seating'    => 'Lumina & Lotus Rentals (Marquee Tents, Picnic Benches & Festoon Bulbs)',
                        'Acoustic Duo'        => 'Pulse Live Beats (Unplugged Acoustic Guitar & Sing-Along Anthems)',
                        'Sound & PA'          => 'Lumina Audio Visual (Wireless Mics & Ambient Sound Rig)'
                    ],
                    'quote'       => '"Everyone said it was our best reunion yet. The live BBQ and acoustic sing-along were legendary!"',
                    'client'      => 'Danushka & 2012 Organizing Committee'
                ],
                [
                    'id'          => 'bkg-gtg-02',
                    'title'       => 'Fernandopulle Family Annual Lakeside Gathering',
                    'category'    => 'family',
                    'category_lbl'=> 'Family Reunions',
                    'venue'       => 'Bolgoda Lake Villa Lawn & Garden',
                    'date'        => 'December 12, 2026',
                    'guests'      => 90,
                    'image'       => 'assets/images/G2.jpg',
                    'tag'         => 'Traditional Village Clay-Pot Buffet',
                    'summary'     => 'A heartwarming cross-generational gathering across four generations. Featured a traditional Sri Lankan clay-pot spread by the water, lawn games for grandchildren, and memory photo displays.',
                    'services'    => [
                        'Authentic Dining'    => 'Grand Royal Banquet (Traditional Sri Lankan Clay-Pot Village Buffet)',
                        'Lawn Staging'        => 'Lotus Decor (Rustic Wooden Cross-Back Chairs & Shaded Parasols)',
                        'Soft Background'     => 'Pulse DJ (Calm Instrumental Cello & Flute Playlist)',
                        'Family Portraits'    => 'Aurora Cinematography (Generational Group Photos & Highlight Reel)'
                    ],
                    'quote'       => '"From elderly grandparents to the youngest toddlers, every single guest was comfortable and well fed."',
                    'client'      => 'Priyantha Fernandopulle'
                ],
                [
                    'id'          => 'bkg-gtg-03',
                    'title'       => 'Tech Startup Alumni Summer Mixer',
                    'category'    => 'alumni',
                    'category_lbl'=> 'Alumni Mixers',
                    'venue'       => 'Galle Face Hotel Chequerboard Terrace',
                    'date'        => 'April 18, 2026',
                    'guests'      => 110,
                    'image'       => 'assets/images/G3.jpg',
                    'tag'         => 'Sunset Cocktails & High-Top Lounges',
                    'summary'     => 'A relaxed evening bringing together founders, engineers, and creatives over sea breezes, high-top cocktail tables, tapas platters, and an open karaoke lounge under the stars.',
                    'services'    => [
                        'Canapés & Tapas'     => 'Grand Royal Catering (Artisan Sliders, Bruschettas & Grazing Table)',
                        'Lounge Rentals'      => 'Lumina Rentals (Illuminated High-Top Cocktail Tables & Bar Stools)',
                        'Karaoke & DJ'        => 'Pulse DJ & Live Beats (Wireless Karaoke Console & Sunset Beats)',
                        'Mobile Bar'          => 'Velvet Mobile Mixology (Craft Gin & Coconut Water Cocktails)'
                    ],
                    'quote'       => '"A phenomenal networking vibe. The cocktail setups and relaxed lounge atmosphere struck the perfect chord."',
                    'client'      => 'Manesh & Colombo Tech Meetup'
                ],
                [
                    'id'          => 'bkg-gtg-04',
                    'title'       => 'Villa Republic Bentota Alumni Pool & BBQ Bash',
                    'category'    => 'batch',
                    'category_lbl'=> 'Batch Parties',
                    'venue'       => 'Villa Republic, Bentota',
                    'date'        => 'May 10, 2026',
                    'guests'      => 45,
                    'image'       => 'assets/images/evnt.jpg',
                    'tag'         => 'Private Poolside Villa & Live Grill',
                    'summary'     => 'An intimate weekend getaway for 45 close friends featuring poolside loungers, a live grill master roasting skewers, an acoustic guitar jam, and cold refreshments all afternoon.',
                    'services'    => [
                        'Villa Catering'      => 'Grand Royal Catering (Live BBQ Grill, Marinades & Garlic Breads)',
                        'Poolside Setup'      => 'Lotus Decor (Waterproof Bean Bags & Floating Lanterns)',
                        'Acoustic Jam'        => 'Pulse Live Beats (Acoustic Guitarist & Portable PA)',
                        'Bar Services'        => 'Velvet Mobile Bar (Chilled Craft Beers & Passion Fruit Mocktails)'
                    ],
                    'quote'       => '"The easiest batch trip we ever organized. EVENTFLARE had the villa, BBQ, and sound ready when we arrived."',
                    'client'      => 'Chathura Kulatunga'
                ]
            ],
            'steps' => [
                [
                    'num' => '1',
                    'title' => 'Pick Lawn, Villa or Sports Ground',
                    'desc' => 'Select private lakeside villa lawns, breezy coastal pavilions, or club sports grounds for outdoor sports.'
                ],
                [
                    'num' => '2',
                    'title' => 'Plan Live Charcoal BBQ & Dining',
                    'desc' => 'Choose live chef-manned charcoal BBQ grills, authentic Sri Lankan clay-pot buffets, or finger-food canapés.'
                ],
                [
                    'num' => '3',
                    'title' => 'Reserve Marquee Tents & Acoustic Acts',
                    'desc' => 'Add heavy-duty marquee tents, rustic picnic benches, wireless karaoke, lawn games, or acoustic singers.'
                ],
                [
                    'num' => '4',
                    'title' => 'Coordinate Batch Schedule & Confirmation',
                    'desc' => 'Finalize group headcounts, coordinate logistics with your concierge, and access your instant digital booking dossier.'
                ]
            ],
            'testimonials' => [
                [
                    'stars' => 5,
                    'quote' => 'Everyone said it was our best reunion yet. The live BBQ and acoustic sing-along were legendary!',
                    'name'  => 'Danushka & 2012 Committee',
                    'venue' => 'CR&FC Grounds Pavilion'
                ],
                [
                    'stars' => 5,
                    'quote' => 'From elderly grandparents to the youngest toddlers, every single guest was comfortable and well fed.',
                    'name'  => 'Priyantha Fernandopulle',
                    'venue' => 'Bolgoda Lake Villa Lawn'
                ],
                [
                    'stars' => 5,
                    'quote' => 'Thank you for coordinating our beach get-together last weekend! The food and acoustic music trio were phenomenal.',
                    'name'  => 'Tharushi Alwis',
                    'venue' => 'Villa Republic, Bentota'
                ]
            ],
            'cta_title' => 'Ready to Gather Friends & Family?',
            'cta_desc'  => 'From sizzling charcoal grills to breezy garden marquees, coordinate your next reunion effortlessly with EVENTFLARE.'
        ];
    }
}
