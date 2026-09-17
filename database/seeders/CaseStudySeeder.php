<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\EventType;
use App\Services\EventShowcaseData;
use Illuminate\Database\Seeder;

class CaseStudySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Update existing Event Types with badges, chips, colors, and images
        $categoryConfig = [
            'Weddings' => [
                'badge' => 'Royal Weddings',
                'chips' => 'Poruwa Rituals, 4K Cinema Drone, Ves Dancers',
                'vendor_count_label' => '120+ Curated Vendors',
                'accent_color' => '#ec4899',
                'image_url' => 'assets/images/wedding.jpg',
            ],
            'DJ Parties' => [
                'badge' => 'Club Beats',
                'chips' => 'JBL Line Array, Moving Heads, Mobile Bar',
                'vendor_count_label' => '45+ Sound Crews',
                'accent_color' => '#8b5cf6',
                'image_url' => 'assets/images/dj.jpg',
            ],
            'Birthdays' => [
                'badge' => 'Milestones',
                'chips' => 'Fondant Cakes, Kids Entertainers, Balloon Arches',
                'vendor_count_label' => '60+ Entertainers',
                'accent_color' => '#f59e0b',
                'image_url' => 'assets/images/cake.jpg',
            ],
            'Hotel Venues' => [
                'badge' => 'Luxury Venues',
                'chips' => 'Oceanfront Lawns, 5-Star Buffets, Valet Parking',
                'vendor_count_label' => '25+ 5-Star Venues',
                'accent_color' => '#3b82f6',
                'image_url' => 'assets/images/hotel.jpg',
            ],
            'Get Togethers' => [
                'badge' => 'Social Mixers',
                'chips' => 'Live Charcoal BBQ, Acoustic Trio, Marquee Pergolas',
                'vendor_count_label' => '35+ Rental Partners',
                'accent_color' => '#10b981',
                'image_url' => 'assets/images/evnt.jpg',
            ],
        ];

        foreach ($categoryConfig as $typeName => $data) {
            EventType::where('type_name', $typeName)->update([
                'badge' => $data['badge'],
                'chips' => $data['chips'],
                'vendor_count_label' => $data['vendor_count_label'],
                'accent_color' => $data['accent_color'],
                'image_url' => $data['image_url'],
            ]);
        }

        // 2. Import case studies from EventShowcaseData if table is empty
        if (CaseStudy::count() === 0) {
            $categories = [
                'Weddings' => 'wedding',
                'DJ Parties' => 'dj',
                'Birthdays' => 'birthday',
                'Hotel Venues' => 'hotel',
                'Get Togethers' => 'gettogether',
            ];

            $order = 1;
            foreach ($categories as $catName => $catTag) {
                $eventType = EventType::where('type_name', $catName)->first();
                $config = EventShowcaseData::getCategoryData($catName);

                if (!empty($config['case_studies'])) {
                    foreach ($config['case_studies'] as $cs) {
                        CaseStudy::create([
                            'event_type_id' => $eventType?->event_type_id,
                            'title' => $cs['title'],
                            'category_tag' => $catTag,
                            'category_label' => $cs['category_lbl'] ?? $catName,
                            'venue' => $cs['venue'] ?? 'Sri Lanka',
                            'event_date' => $cs['date'] ?? null,
                            'guests_count' => (int) ($cs['guests'] ?? 150),
                            'image_url' => $cs['image'] ?? 'assets/images/weding.jpg',
                            'tagline' => $cs['tag'] ?? null,
                            'summary' => $cs['summary'] ?? null,
                            'quote' => $cs['quote'] ?? null,
                            'client_name' => $cs['client'] ?? null,
                            'services_delivered' => $cs['services'] ?? null,
                            'is_featured_home' => true,
                            'is_active' => true,
                            'display_order' => $order++,
                        ]);
                    }
                }
            }

            // Add Corporate & Bespoke Gala Showcase
            CaseStudy::create([
                'event_type_id' => null,
                'title' => 'Virtusa Annual Global Leadership Summit & Gala',
                'category_tag' => 'corporate',
                'category_label' => 'Corporate & Bespoke',
                'venue' => 'Cinnamon Grand Atrium Ballroom, Colombo',
                'event_date' => 'November 15, 2026',
                'guests_count' => 350,
                'image_url' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&auto=format&fit=crop&q=80',
                'tagline' => 'Keynote Staging & Awards Banquet',
                'summary' => 'A flagship multi-track corporate leadership summit featuring custom LED backdrop stages, simultaneous translation audio rigs, and a 5-course executive gala dinner.',
                'quote' => '"EVENTFLARE managed 350 global executives with zero friction. The staging and banquet were world-class."',
                'client_name' => 'Virtusa Executive Council',
                'services_delivered' => [
                    'Staging & LED Backdrops' => 'Alpha Productions LK',
                    'Executive Gala Banquet' => 'Cinnamon Grand Culinary Services',
                    'Keynote Sound & Lighting' => 'ProSound Systems Colombo',
                ],
                'is_featured_home' => true,
                'is_active' => true,
                'display_order' => $order,
            ]);
        }
    }
}
