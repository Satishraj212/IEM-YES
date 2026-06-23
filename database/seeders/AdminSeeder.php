<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
use App\Models\OfficialEvent;
use App\Models\StudentEventSubmission;
use App\Models\FlagshipEvent;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // ── Branches ──────────────────────────────────────────────────────────
        $branches = [
            ['name' => 'National',              'state' => null,           'color' => '#c8a84b', 'member_count' => 0,    'new_members_this_month' => 0],
            ['name' => 'Kuala Lumpur',          'state' => 'Kuala Lumpur', 'color' => '#003366', 'member_count' => 3240, 'new_members_this_month' => 88],
            ['name' => 'Selangor',              'state' => 'Selangor',     'color' => '#1a6b3c', 'member_count' => 2652, 'new_members_this_month' => 54],
            ['name' => 'Wilayah Persekutuan',   'state' => 'WP',           'color' => '#c8a84b', 'member_count' => 2240, 'new_members_this_month' => 40],
            ['name' => 'Johor',                 'state' => 'Johor',        'color' => '#c0392b', 'member_count' => 1180, 'new_members_this_month' => 22],
            ['name' => 'Penang',                'state' => 'Penang',       'color' => '#1d4ed8', 'member_count' => 890,  'new_members_this_month' => 18],
            ['name' => 'Sabah',                 'state' => 'Sabah',        'color' => '#5b21b6', 'member_count' => 620,  'new_members_this_month' => 12],
            ['name' => 'Sarawak',               'state' => 'Sarawak',      'color' => '#d97706', 'member_count' => 580,  'new_members_this_month' => 8],
        ];

        $createdBranches = [];
        foreach ($branches as $b) {
            $createdBranches[$b['name']] = Branch::create($b);
        }

        // ── Official Events ───────────────────────────────────────────────────
        $officialEvents = [
            [
                'name'             => 'YES Annual General Meeting 2025',
                'category'         => 'Board Meeting',
                'location'         => 'Grand Ballroom, KLCC',
                'start_date'       => '2025-03-15',
                'status'           => 'open',
                'total_seats'      => 200,
                'registered_count' => 48,
                'branch_id'        => $createdBranches['National']->id,
                'organiser'        => 'Super Admin',
                'tags'             => ['Annual', 'Board', 'KL'],
                'is_published'     => true,
                'description'      => 'The annual general meeting for the YES IEM national board. All board members and regional delegates are expected to attend to discuss the year\'s strategic direction and elect committee positions.',
                'admin_notes'      => '',
            ],
            [
                'name'             => 'YES National Board Retreat 2025',
                'category'         => 'Retreat',
                'location'         => 'George Town, Penang',
                'start_date'       => '2025-04-08',
                'status'           => 'open',
                'total_seats'      => 60,
                'registered_count' => 22,
                'branch_id'        => $createdBranches['Penang']->id,
                'organiser'        => 'Penang Chapter Head',
                'tags'             => ['Retreat', 'Board', 'Strategy'],
                'is_published'     => true,
                'description'      => 'Annual board retreat for strategic planning and team building.',
                'admin_notes'      => 'Confirm accommodation at Straits Hotel.',
            ],
            [
                'name'             => 'Industry Collaboration Summit',
                'category'         => 'Summit',
                'location'         => 'JB City Square, Johor Bahru',
                'start_date'       => '2025-05-22',
                'status'           => 'open',
                'total_seats'      => 250,
                'registered_count' => 105,
                'branch_id'        => $createdBranches['Johor']->id,
                'organiser'        => 'Johor Chapter Head',
                'tags'             => ['Industry', 'Summit', 'Collaboration'],
                'is_published'     => true,
                'description'      => 'A high-profile summit bringing together engineering firms and YES IEM chapters.',
                'admin_notes'      => '',
            ],
            [
                'name'             => 'YES Leadership Excellence Forum',
                'category'         => 'Forum',
                'location'         => 'Marriott, Putrajaya',
                'start_date'       => '2025-06-18',
                'status'           => 'upcoming',
                'total_seats'      => null,
                'registered_count' => 0,
                'branch_id'        => $createdBranches['National']->id,
                'organiser'        => 'Super Admin',
                'tags'             => ['Leadership', 'Forum'],
                'is_published'     => false,
                'description'      => 'Annual leadership forum for YES IEM branch heads and board members.',
                'admin_notes'      => 'Registration to open in May.',
            ],
            [
                'name'             => 'Mid-Year Board Review & Planning',
                'category'         => 'Review',
                'location'         => 'Kuala Lumpur',
                'start_date'       => '2025-07-10',
                'status'           => 'upcoming',
                'total_seats'      => null,
                'registered_count' => 0,
                'branch_id'        => $createdBranches['National']->id,
                'organiser'        => 'Super Admin',
                'tags'             => ['Board', 'Review', 'Planning'],
                'is_published'     => false,
                'description'      => 'Bi-annual review of YES IEM objectives and key results.',
                'admin_notes'      => '',
            ],
            [
                'name'             => 'YES Annual Gala Dinner 2024',
                'category'         => 'Gala / Dinner',
                'location'         => 'Grand Hyatt, Kuala Lumpur',
                'start_date'       => '2024-11-30',
                'status'           => 'past',
                'total_seats'      => 400,
                'registered_count' => 400,
                'branch_id'        => $createdBranches['National']->id,
                'organiser'        => 'Super Admin',
                'tags'             => ['Gala', 'Annual', 'Networking'],
                'is_published'     => true,
                'description'      => 'The pinnacle networking event of the YES IEM calendar, attended by 400 guests.',
                'admin_notes'      => 'Fully attended. Awards presented.',
            ],
        ];

        foreach ($officialEvents as $e) {
            OfficialEvent::create($e);
        }

        // ── Student Event Submissions ──────────────────────────────────────────
        $submissions = [
            [
                'title'           => 'Engineering Innovation Hackathon 2025',
                'university'      => 'UTM',
                'university_full' => 'Universiti Teknologi Malaysia, Skudai',
                'category'        => 'hackathon',
                'event_date'      => '2–4 Apr 2025',
                'submitted_by'    => 'Ahmad Faiz Bin Razali',
                'stage'           => 'budget',
                'stage_history'   => ['pending', 'ppw'],
                'budget'          => ['venue' => 2500, 'catering' => 1800, 'prizes' => 3000, 'marketing' => 800, 'logistics' => 600],
                'description'     => "The Engineering Innovation Hackathon 2025 is a 3-day flagship competition organised by the YES IEM UTM Student Chapter.\n\nCash prizes totalling RM 5,000 will be awarded to the top 3 teams.",
                'admin_notes'     => '',
                'ppw_filename'    => 'Hackathon_2025_PPW_UTM.pdf',
                'ppw_size'        => '2.4 MB',
                'poster_filename' => 'Hackathon_2025_Poster.png',
            ],
            [
                'title'           => 'STEM Career Fair 2025',
                'university'      => 'UPM',
                'university_full' => 'Universiti Putra Malaysia, Serdang',
                'category'        => 'career',
                'event_date'      => '18 Apr 2025',
                'submitted_by'    => 'Nurul Ain Zainudin',
                'stage'           => 'ppw',
                'stage_history'   => ['pending'],
                'budget'          => ['venue' => 3000, 'catering' => 2200, 'Booth Setup' => 1500, 'marketing' => 1000, 'logistics' => 500],
                'description'     => "STEM Career Fair 2025 brings together 40+ employers from engineering, technology, and science sectors.\n\nWalk-in registration will be available on the day.",
                'admin_notes'     => '',
                'ppw_filename'    => 'STEM_CareerFair_2025_PPW_UPM.pdf',
                'ppw_size'        => '1.8 MB',
                'poster_filename' => 'STEM_CareerFair_2025_Poster.png',
            ],
            [
                'title'           => 'Robotics & Automation Webinar Series',
                'university'      => 'Online',
                'university_full' => 'Online (National)',
                'category'        => 'webinar',
                'event_date'      => '5 May – 10 Jun 2025',
                'submitted_by'    => 'Lee Chun Wei',
                'stage'           => 'approved',
                'stage_history'   => ['pending', 'ppw', 'budget'],
                'budget'          => ['platform' => 1200, 'Speaker Honorarium' => 2400, 'marketing' => 600, 'Certificate Printing' => 800],
                'description'     => "A 6-session online webinar series covering fundamentals to advanced topics in robotics and industrial automation.\n\nParticipants who attend at least 4 sessions will receive a YES IEM certificate of completion.",
                'admin_notes'     => 'Approved — strong proposal with clear KPIs and industry speaker confirmations. Budget well-justified.',
                'ppw_filename'    => 'Robotics_Webinar_PPW.pdf',
                'ppw_size'        => '1.1 MB',
                'poster_filename' => 'Robotics_Webinar_Poster.png',
            ],
            [
                'title'           => 'BIM & Digital Engineering Workshop',
                'university'      => 'UM',
                'university_full' => 'Universiti Malaya, Kuala Lumpur',
                'category'        => 'workshop',
                'event_date'      => '7 Jun 2025',
                'submitted_by'    => 'Siti Aisyah Ramli',
                'stage'           => 'pending',
                'stage_history'   => [],
                'budget'          => ['venue' => 800, 'Software Licenses' => 1200, 'catering' => 600, 'marketing' => 400],
                'description'     => "A hands-on workshop on Building Information Modelling (BIM) and digital engineering tools.\n\nLimited to 40 participants to ensure quality of instruction.",
                'admin_notes'     => '',
                'ppw_filename'    => 'BIM_Workshop_PPW_UM.pdf',
                'ppw_size'        => '980 KB',
                'poster_filename' => 'BIM_Workshop_Poster.png',
            ],
            [
                'title'           => 'YES National Paper Presentation Competition',
                'university'      => 'UiTM',
                'university_full' => 'Universiti Teknologi MARA, Shah Alam',
                'category'        => 'competition',
                'event_date'      => '20 Jul 2025',
                'submitted_by'    => 'Rajesh Kumar',
                'stage'           => 'rejected',
                'stage_history'   => ['pending'],
                'budget'          => ['venue' => 2000, 'prizes' => 4000, 'catering' => 1500, 'marketing' => 700, 'logistics' => 300],
                'description'     => "Annual competition open to undergraduate and postgraduate students from all Malaysian universities.\n\nCash prizes for top 3 positions. All participants receive a certificate.",
                'admin_notes'     => 'Rejected at PPW stage — incomplete budget justification. Resubmission invited with revised documentation.',
                'ppw_filename'    => 'PaperComp_2025_PPW.pdf',
                'ppw_size'        => '2.1 MB',
                'poster_filename' => 'PaperComp_Poster.png',
            ],
        ];

        foreach ($submissions as $s) {
            StudentEventSubmission::create($s);
        }

        // ── Flagship Events ───────────────────────────────────────────────────
        FlagshipEvent::create([
            'short_name'         => 'NATSUM',
            'full_name'          => 'National Student Symposium',
            'year'               => 2025,
            'event_date'         => 'August 2025 (TBC)',
            'location'           => 'Universiti Malaya, KL',
            'host'               => null,
            'expected_delegates' => 1200,
            'status'             => 'planning',
        ]);

        FlagshipEvent::create([
            'short_name'         => 'CAFEO',
            'full_name'          => 'Conference of ASEAN Federation of Engineering Organisations',
            'year'               => 2025,
            'event_date'         => 'November 2025 (TBC)',
            'location'           => null,
            'host'               => 'Malaysia (YES IEM)',
            'expected_delegates' => 800,
            'status'             => 'planning',
        ]);

        // ── Activity Logs ──────────────────────────────────────────────────────
        // No fabricated entries — the activity feed is a true audit trail and is
        // populated only by real actions (event review, org-chart uploads, budget
        // and report decisions, etc.). The portal has no member/event registration
        // or pledge flows, so those events are never logged.
    }
}
