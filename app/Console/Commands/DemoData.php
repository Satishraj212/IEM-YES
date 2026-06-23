<?php

namespace App\Console\Commands;

use App\Models\AnnualReport;
use App\Models\Branch;
use App\Models\BranchMembershipSnapshot;
use App\Models\BranchOrgChart;
use App\Models\BudgetReceipt;
use App\Models\Event;
use App\Models\OfficialEvent;
use App\Models\StudentAwardCategory;
use App\Models\StudentAwardNomination;
use App\Models\StudentAwardVote;
use App\Models\StudentEventBudget;
use App\Models\StudentEventBudgetItem;
use App\Models\StudentEventRegistration;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Self-contained demo data for video demonstrations.
 *
 *   php artisan demo:data seed     # populate professional demo data (all subsystems, all stages)
 *   php artisan demo:data clear    # remove EXACTLY what seed created (manifest-driven) — nothing else
 *   php artisan demo:data status   # show what the manifest currently tracks
 *
 * Every row and file created during `seed` is recorded in storage/app/demo-manifest.json,
 * so `clear` deletes precisely those records/files and never touches real data.
 */
class DemoData extends Command
{
    protected $signature = 'demo:data {action=seed : seed | clear | status}';
    protected $description = 'Create or remove professional demo data for all subsystems (manifest-tracked, fully reversible).';

    private const MANIFEST = 'demo-manifest.json';
    private const DEMO_TAG = '__demo';

    /** Curated (normally empty) chapters so the demo never collides with real data. */
    private const DEMO_CHAPTERS = [
        'YES UM', 'YES UTAR Sungai Long', 'YES Sunway University', 'YES Taylor\'s University',
        'YES UNITEN', 'YES MMU Cyberjaya', 'YES IIUM', 'YES UKM',
    ];
    private const DEMO_SNAPSHOT_DATES = ['2026-03-31', '2026-04-30', '2026-05-31', '2026-06-15'];

    /** Stable signatures so `purge` can remove demo rows even if the manifest is lost. */
    private const DEMO_EVENT_TITLES = [
        'National Engineering Hackathon 2026', 'Women in Engineering Career Fair', 'Sustainable Design Workshop',
        'AI & Robotics Talk Series', 'Bridge Building Competition', 'Industry 4.0 Webinar',
        'Green Campus SDG Forum', 'STEM Outreach Volunteer Drive', 'Renewable Energy Symposium',
        'Members Networking Night', 'Annual Project Showcase',
        'Robotics Workshop Series', 'Engineering Career Expo', 'Sustainability Design Sprint',
        'Technical Site Visit', 'Chapter Leadership Retreat',
    ];
    private const DEMO_OFFICIAL_NAMES = [
        'YES National Leadership Summit 2026', 'Engineering Industry Networking Night', 'Young Engineers Awards Gala 2025',
    ];

    /** @var array<int,array{type:string,id:mixed}> */
    private array $rows = [];
    /** @var array<int,string> */
    private array $files = [];

    public function handle(): int
    {
        return match ($this->argument('action')) {
            'seed'   => $this->seed(),
            'clear'  => $this->clear(),
            'purge'  => $this->purge(),
            'status' => $this->status(),
            default  => $this->failWith('Unknown action. Use: seed | clear | purge | status'),
        };
    }

    private function failWith(string $msg): int
    {
        $this->error($msg);
        return self::FAILURE;
    }

    // ── SEED ────────────────────────────────────────────────────────────────────

    private function seed(): int
    {
        if (Storage::exists(self::MANIFEST)) {
            $this->warn('A demo manifest already exists. Run "php artisan demo:data clear" first to avoid duplicates.');
            if (! $this->confirm('Seed anyway (may create duplicates)?', false)) {
                return self::SUCCESS;
            }
            $this->rows  = json_decode(Storage::get(self::MANIFEST), true)['rows']  ?? [];
            $this->files = json_decode(Storage::get(self::MANIFEST), true)['files'] ?? [];
        }

        $admin    = User::where('role', 'admin')->first();
        $chapters = Branch::whereIn('name', self::DEMO_CHAPTERS)->whereNotNull('code')->get();

        if ($chapters->isEmpty()) {
            return $this->failWith('No demo chapters found. Seed the chapters (UniversitySeeder) first.');
        }

        $this->info('Seeding demo data…');
        try {
            $this->seedMembership($chapters);
            $published = $this->seedEventPipeline($chapters, $admin);
            $this->seedRegistrations($published);
            $this->seedBudgets($chapters, $admin);
            $this->seedAnnualReports($chapters, $admin);
            $this->seedOrgCharts($chapters, $admin);
            $this->seedOfficialEvents($admin);
            $this->seedAwards($chapters);
        } finally {
            // Persist the manifest no matter what, so even a partial seed is fully removable.
            Storage::put(self::MANIFEST, json_encode(['rows' => $this->rows, 'files' => $this->files], JSON_PRETTY_PRINT));
        }

        $this->newLine();
        $this->info('✓ Demo data seeded — ' . count($this->rows) . ' records, ' . count($this->files) . ' files.');
        $this->line('  Remove it any time with: <comment>php artisan demo:data clear</comment>');
        return self::SUCCESS;
    }

    // ── CLEAR ───────────────────────────────────────────────────────────────────

    private function clear(): int
    {
        if (! Storage::exists(self::MANIFEST)) {
            $this->warn('No demo manifest found — nothing to clear.');
            return self::SUCCESS;
        }

        $manifest = json_decode(Storage::get(self::MANIFEST), true);
        $rows  = $manifest['rows']  ?? [];
        $files = $manifest['files'] ?? [];

        // Files first.
        foreach ($files as $path) {
            Storage::disk('public')->delete($path);
        }

        // Records in reverse creation order so children go before parents.
        $deleted = 0;
        foreach (array_reverse($rows) as $row) {
            $class = $row['type'];
            if (! class_exists($class)) continue;
            $usesSoftDeletes = in_array(
                \Illuminate\Database\Eloquent\SoftDeletes::class,
                class_uses_recursive($class)
            );
            $query = $usesSoftDeletes ? $class::withTrashed() : $class::query();
            foreach ($query->whereKey($row['id'])->get() as $model) {
                $model->forceDelete();
                $deleted++;
            }
        }

        Storage::delete(self::MANIFEST);
        $this->info("✓ Cleared demo data — {$deleted} records and " . count($files) . ' files removed.');
        return self::SUCCESS;
    }

    /**
     * Remove demo data by stable signature — the safety net if the manifest is ever lost
     * (e.g. a seed that crashed before writing it). Targets only demo-shaped rows/files.
     */
    private function purge(): int
    {
        if (! $this->confirm('Purge all demo-signed rows (events, budgets, reports, org charts, awards, official events, snapshots) and the demo/ files?', true)) {
            return self::SUCCESS;
        }

        // Events (+ their children) by demo title or demo tag.
        $eventIds = Event::withTrashed()
            ->where(fn ($q) => $q->whereIn('title', self::DEMO_EVENT_TITLES)->orWhereJsonContains('tags', self::DEMO_TAG))
            ->pluck('id');
        $budgetIds = StudentEventBudget::whereIn('event_id', $eventIds)->pluck('id');
        BudgetReceipt::whereIn('event_budget_id', $budgetIds)->delete();
        StudentEventBudgetItem::whereIn('event_budget_id', $budgetIds)->delete();
        StudentEventBudget::whereIn('id', $budgetIds)->delete();
        StudentEventRegistration::whereIn('event_id', $eventIds)->delete();
        Event::withTrashed()->whereIn('id', $eventIds)->forceDelete();

        // Org charts (demo files live under demo/).
        BranchOrgChart::where('file_path', 'like', 'demo/%')->delete();

        // Annual reports for demo chapters.
        $chapterIds = Branch::whereIn('name', self::DEMO_CHAPTERS)->pluck('id');
        AnnualReport::whereIn('branch_id', $chapterIds)->where('title', 'like', '% Annual Report 2025')->delete();

        // Membership snapshots for demo chapters on the demo dates.
        BranchMembershipSnapshot::whereIn('branch_id', $chapterIds)
            ->whereIn('as_of', self::DEMO_SNAPSHOT_DATES)->delete();

        // Official events.
        OfficialEvent::whereIn('name', self::DEMO_OFFICIAL_NAMES)->delete();

        // Awards (slug prefixed demo-).
        $catIds = StudentAwardCategory::where('slug', 'like', 'demo-%')->pluck('id');
        StudentAwardVote::whereIn('award_category_id', $catIds)->delete();
        StudentAwardNomination::whereIn('award_category_id', $catIds)->delete();
        StudentAwardCategory::whereIn('id', $catIds)->delete();

        // Files + manifest.
        Storage::disk('public')->deleteDirectory('demo');
        Storage::delete(self::MANIFEST);

        $this->info('✓ Purged all demo-signed data and demo/ files.');
        return self::SUCCESS;
    }

    private function status(): int
    {
        if (! Storage::exists(self::MANIFEST)) {
            $this->line('No demo data is currently seeded.');
            return self::SUCCESS;
        }
        $manifest = json_decode(Storage::get(self::MANIFEST), true);
        $rows = collect($manifest['rows'] ?? []);
        $this->info('Demo data currently tracked:');
        foreach ($rows->groupBy('type') as $type => $items) {
            $this->line('  ' . class_basename($type) . ': ' . count($items));
        }
        $this->line('  Files: ' . count($manifest['files'] ?? []));
        return self::SUCCESS;
    }

    // ── Subsystem seeders ───────────────────────────────────────────────────────

    private function seedMembership($chapters): void
    {
        foreach ($chapters as $i => $branch) {
            $base = 32 + $i * 4;
            foreach (['2026-03-31', '2026-04-30', '2026-05-31', '2026-06-15'] as $m => $date) {
                $this->track(BranchMembershipSnapshot::create([
                    'branch_id'    => $branch->id,
                    'as_of'        => $date,
                    'member_count' => $base + $m * 6,
                    'new_members'  => 4 + $m,
                    'recorded_by'  => $this->branchUser($branch)?->id,
                ]));
            }
        }
        $this->line('  • Membership snapshots');
    }

    /** @return \Illuminate\Support\Collection<int,Event> published events */
    private function seedEventPipeline($chapters, $admin): \Illuminate\Support\Collection
    {
        // [title, category, stage, days-from-now]
        $scenarios = [
            ['National Engineering Hackathon 2026', 'Hackathon',   'published', 35],
            ['Women in Engineering Career Fair',    'Career Fair', 'published', 21],
            ['Sustainable Design Workshop',         'Workshop',    'approved',  48],
            ['AI & Robotics Talk Series',           'Talk',        'ppw',       40],
            ['Bridge Building Competition',         'Competition', 'pending',   60],
            ['Industry 4.0 Webinar',                'Webinar',     'pending',   28],
            ['Green Campus SDG Forum',              'SDG Event',   'approved',  55],
            ['STEM Outreach Volunteer Drive',       'Volunteer',   'published', 14],
            ['Renewable Energy Symposium',          'Talk',        'rejected', -10],
            ['Members Networking Night',            'Other',       'draft',     70],
            ['Annual Project Showcase',             'Competition', 'reinstate', 65],
        ];

        $published = collect();
        foreach ($scenarios as $i => [$title, $category, $stage, $days]) {
            $branch = $chapters[$i % $chapters->count()];
            $event  = $this->makeEvent($branch, $admin, $title, $category, $stage, $days);
            if ($event->track_published) $published->push($event);
        }
        $this->line('  • Student events (draft → submitted → PPW → approved → published → rejected → reinstate)');
        return $published;
    }

    private function makeEvent(Branch $branch, $admin, string $title, string $category, string $stage, int $days): Event
    {
        $start = now()->addDays($days)->startOfDay();
        $attrs = [
            'branch_id'   => $branch->id,
            'created_by'  => $this->branchUser($branch)?->id,
            'title'       => $title,
            'category'    => $category,
            'description' => "{$title} hosted by {$branch->name}. A flagship chapter activity bringing together students, faculty and industry partners.",
            'start_date'  => $start,
            'end_date'    => $start->copy()->addDay(),
            'venue'       => $branch->institution ?: 'Main Auditorium',
            'is_sdg'      => in_array($category, ['SDG Event', 'Volunteer']),
            'tags'        => [self::DEMO_TAG, 'engineering', strtolower(str_replace(' ', '-', $category))],
        ];

        // Map demo stage → real status + track flags.
        $attrs += match ($stage) {
            'draft'     => ['status' => 'draft'],
            'reinstate' => ['status' => 'draft', 'revision_note' => 'Please add a detailed budget breakdown and confirm the venue booking before resubmitting.'],
            'pending'   => ['status' => 'submitted', 'track_submitted' => true, 'submitted_at' => now()->subDays(3)],
            'ppw'       => ['status' => 'submitted', 'track_submitted' => true, 'track_doc_approved' => true, 'submitted_at' => now()->subDays(6)],
            'approved'  => ['status' => 'approved', 'track_submitted' => true, 'track_doc_approved' => true, 'track_budget_approved' => true, 'submitted_at' => now()->subDays(9), 'approved_at' => now()->subDays(4), 'approved_by' => $admin?->id],
            'published' => ['status' => 'approved', 'track_submitted' => true, 'track_doc_approved' => true, 'track_budget_approved' => true, 'track_published' => true, 'submitted_at' => now()->subDays(12), 'approved_at' => now()->subDays(7), 'approved_by' => $admin?->id],
            'rejected'  => ['status' => 'rejected', 'track_submitted' => true, 'track_rejected' => true, 'submitted_at' => now()->subDays(14), 'rejection_reason' => 'This proposal overlaps with an existing national event. Please rescope and resubmit next cycle.'],
            default     => ['status' => 'draft'],
        };

        // A poster makes published events look complete on the public site.
        if (($attrs['track_published'] ?? false) || $stage === 'approved') {
            $attrs['poster_path'] = $this->putSvg(
                "demo/posters/{$branch->id}-" . \Illuminate\Support\Str::slug($title) . '.svg',
                $this->posterSvg($title, $branch->name, $start->format('j M Y'))
            );
        }

        $event = Event::create($attrs);
        return $this->track($event);
    }

    private function seedRegistrations($publishedEvents): void
    {
        $users = User::query()->inRandomOrder()->limit(8)->pluck('id');
        foreach ($publishedEvents as $event) {
            foreach ($users->take(rand(4, 8)) as $j => $uid) {
                $attended = $j % 3 === 0;
                $this->track(StudentEventRegistration::create([
                    'event_id'      => $event->id,
                    'user_id'       => $uid,
                    'status'        => $attended ? 'attended' : 'registered',
                    'registered_at' => now()->subDays(rand(1, 10)),
                    'attended_at'   => $attended ? now()->subDays(1) : null,
                ]));
            }
        }
        $this->line('  • Event registrations');
    }

    private function seedBudgets($chapters, $admin): void
    {
        // Each budget needs its own approved event (one-budget-per-event rule).
        // [title, demo-stage]
        $scenarios = [
            ['Robotics Workshop Series',     'pending'],     // Under Review
            ['Engineering Career Expo',      'approved'],    // Approved, awaiting receipts
            ['Sustainability Design Sprint', 'reimbursed'],  // Approved + reimbursed (with receipts)
            ['Technical Site Visit',         'returned'],    // Returned for changes
            ['Chapter Leadership Retreat',   'draft'],       // Reinstated draft (editable)
        ];

        foreach ($scenarios as $i => [$title, $stage]) {
            $branch = $chapters[$i % $chapters->count()];
            $event  = $this->makeEvent($branch, $admin, $title, 'Workshop', 'approved', 30 + $i);

            $lines = [
                ['Venue & Equipment Rental', 1, 1200],
                ['Refreshments & Catering',  1, 600],
                ['Printing & Materials',     1, 350],
                ['Speaker Honorarium',       2, 400],
            ];
            $requested = collect($lines)->sum(fn ($l) => $l[1] * $l[2]);

            $status = match ($stage) {
                'draft'      => StudentEventBudget::STATUS_DRAFT,
                'pending'    => StudentEventBudget::STATUS_PENDING,
                'returned'   => StudentEventBudget::STATUS_REJECTED,
                default      => StudentEventBudget::STATUS_APPROVED,
            };
            $approvedTotal = in_array($stage, ['approved', 'reimbursed']) ? $requested - 350 : null;

            $budget = StudentEventBudget::create([
                'event_id'        => $event->id,
                'category'        => 'Event Operations',
                'total_requested' => $requested,
                'total_approved'  => $approvedTotal,
                'total_reimbursed'=> $stage === 'reimbursed' ? $approvedTotal : null,
                'status'          => $status,
                'justification'   => "Funding request for {$title}: venue, catering, materials and speaker costs.",
                'decision_notes'  => $stage === 'returned' ? 'Catering line is too high — please obtain a second quotation and resubmit.' : ($approvedTotal ? 'Approved with printing line deferred to chapter funds.' : null),
                'decided_by'      => in_array($stage, ['approved', 'reimbursed', 'returned']) ? $admin?->id : null,
                'decided_at'      => in_array($stage, ['approved', 'reimbursed', 'returned']) ? now()->subDays(3) : null,
                'reimbursed_by'   => $stage === 'reimbursed' ? $admin?->id : null,
                'reimbursed_at'   => $stage === 'reimbursed' ? now()->subDay() : null,
            ]);
            $this->track($budget);

            foreach ($lines as $k => [$name, $qty, $cost]) {
                $this->track(StudentEventBudgetItem::create([
                    'event_budget_id' => $budget->id,
                    'name'            => $name,
                    'quantity'        => $qty,
                    'unit_cost'       => $cost,
                    'approved_amount' => $approvedTotal && $name !== 'Printing & Materials' ? $qty * $cost : ($approvedTotal ? 0 : null),
                ]));
            }

            if ($stage === 'reimbursed') {
                $path = $this->putSvg("demo/receipts/{$budget->id}-receipt.svg", $this->receiptSvg($title, $approvedTotal));
                $this->track(BudgetReceipt::create([
                    'event_budget_id' => $budget->id,
                    'path'            => $path,
                    'filename'        => 'receipt-' . \Illuminate\Support\Str::slug($title) . '.svg',
                    'uploaded_by'     => $this->branchUser($branch)?->id,
                ]));
            }
        }
        $this->line('  • Budget requests (draft → under review → approved → reimbursed → returned) + receipts');
    }

    private function seedAnnualReports($chapters, $admin): void
    {
        $scenarios = [['review'], ['approved'], ['returned']];
        foreach ($scenarios as $i => [$stage]) {
            $branch = $chapters[$i % $chapters->count()];
            $status = match ($stage) { 'approved' => 'approved', 'returned' => 'rejected', default => 'pending' };
            $this->track(AnnualReport::create([
                'branch_id'    => $branch->id,
                'submitted_by' => $this->branchUser($branch)?->id,
                'year'         => 2025,
                'title'        => $branch->name . ' Annual Report 2025',
                'report_data'  => [
                    'total_events'   => rand(8, 16),
                    'total_members'  => rand(40, 80),
                    'budget_used'    => rand(8, 20) * 1000,
                    'sdg_events'     => rand(2, 6),
                    'highlights'     => 'A strong year of growth in membership and flagship engineering activities.',
                ],
                'submitted_at' => now()->subDays(8),
                'status'       => $status,
                'notes'        => $stage === 'returned' ? 'Please include the membership growth chart and finalised expenditure before resubmission.' : null,
                'reviewed_by'  => in_array($stage, ['approved', 'returned']) ? $admin?->id : null,
                'reviewed_at'  => in_array($stage, ['approved', 'returned']) ? now()->subDays(2) : null,
            ]));
        }
        $this->line('  • Annual reports (under review → approved → returned)');
    }

    private function seedOrgCharts($chapters, $admin): void
    {
        $year = '2025/2026';

        // Chapter charts: approved (public), pending (in review), rejected (returned).
        $chapterStages = ['approved', 'approved', 'pending', 'rejected'];
        foreach ($chapterStages as $i => $stage) {
            $branch = $chapters[$i % $chapters->count()];
            $this->makeOrgChart($branch, $admin, $year, $stage);
        }

        // State branches + HQ (Kuala Lumpur) — HQ-managed, approved, shown publicly.
        $stateNames = ['Selangor', 'Johor', 'Penang', 'Kuala Lumpur'];
        foreach (Branch::whereIn('name', $stateNames)->whereNull('code')->get() as $state) {
            $this->makeOrgChart($state, $admin, $year, 'approved');
        }
        $this->line('  • Organisation charts (chapter: approved/pending/returned · state branches + HQ)');
    }

    private function makeOrgChart(Branch $branch, $admin, string $year, string $stage): void
    {
        // Skip if a chart already exists for that branch/year (don't disturb real data).
        if (BranchOrgChart::where('branch_id', $branch->id)->where('academic_year', $year)->exists()) {
            return;
        }
        $path = $this->putSvg(
            "demo/org-charts/{$branch->id}-" . str_replace('/', '-', $year) . '.svg',
            $this->orgChartSvg($branch->name, $year)
        );
        $this->track(BranchOrgChart::create([
            'branch_id'      => $branch->id,
            'academic_year'  => $year,
            'file_path'      => $path,
            'status'         => $stage,
            'is_current'     => true,
            'uploaded_by'    => $this->branchUser($branch)?->id ?? $admin?->id,
            'review_comment' => $stage === 'rejected' ? 'The committee structure is unclear — please use the official template and resubmit.' : null,
            'reviewed_by'    => in_array($stage, ['approved', 'rejected']) ? $admin?->id : null,
            'reviewed_at'    => in_array($stage, ['approved', 'rejected']) ? now()->subDays(2) : null,
        ]));
    }

    private function seedOfficialEvents($admin): void
    {
        $events = [
            ['YES National Leadership Summit 2026', 'Conference', 'Kuala Lumpur Convention Centre', 18, 'open',  true,  400],
            ['Engineering Industry Networking Night', 'Networking', 'IEM Headquarters, PJ',         42, 'open',  true,  150],
            ['Young Engineers Awards Gala 2025',     'Ceremony',   'Grand Hyatt Kuala Lumpur',     -30, 'past',  true,  300],
        ];
        foreach ($events as [$name, $cat, $loc, $days, $status, $pub, $seats]) {
            $this->track(OfficialEvent::create([
                'name'        => $name,
                'category'    => $cat,
                'location'    => $loc,
                'start_date'  => now()->addDays($days)->toDateString(),
                'status'      => $status,
                'total_seats' => $seats,
                'registered_count' => rand(20, $seats),
                'organiser'   => 'IEM Young Engineers Section',
                'is_published'=> $pub,
                'description' => "{$name} — a flagship IEM-YES national event.",
                'tags'        => [self::DEMO_TAG, 'national', strtolower($cat)],
            ]));
        }
        $this->line('  • Official / board events (open & past)');
    }

    private function seedAwards($chapters): void
    {
        $cats = [
            ['outstanding-chapter-2025', 'Outstanding Student Chapter 2025', 'voting_active',    'Recognising the most active and impactful student chapter of the year.'],
            ['young-engineer-2025',      'Young Engineer of the Year 2025',  'nominations_open', 'Celebrating an individual member who exemplifies engineering excellence.'],
        ];
        foreach ($cats as [$slug, $name, $status, $desc]) {
            $cat = StudentAwardCategory::create([
                'slug'             => 'demo-' . $slug,
                'name'             => $name,
                'description'      => $desc,
                'status'           => $status,
                'cycle_year'       => 2025,
                'allow_self_apply' => true,
                'allow_nominations'=> true,
            ]);
            $this->track($cat);

            $noms = [];
            foreach ($chapters->take(4) as $branch) {
                $nom = StudentAwardNomination::create([
                    'award_category_id' => $cat->id,
                    'nominated_by'      => $this->branchUser($branch)?->id,
                    'nominee_name'      => $branch->name,
                    'nominee_branch'    => $branch->name,
                    'reason'            => "{$branch->name} has shown exceptional engagement and engineering outreach this cycle.",
                    'status'            => 'shortlisted',
                ]);
                $this->track($nom);
                $noms[] = $nom;
            }

            // A few votes for the voting category.
            if ($status === 'voting_active' && $noms) {
                foreach (User::where('role', 'branch_admin')->inRandomOrder()->take(6)->get() as $voter) {
                    $this->track(StudentAwardVote::create([
                        'award_category_id' => $cat->id,
                        'voter_id'          => $voter->id,
                        'nomination_id'     => $noms[array_rand($noms)]->id,
                        'voted_at'          => now()->subDays(rand(1, 5)),
                    ]));
                }
            }
        }
        $this->line('  • Awards (categories, nominations, votes)');
    }

    // ── Helpers ─────────────────────────────────────────────────────────────────

    private function branchUser(Branch $branch): ?User
    {
        return User::where('branch_id', $branch->id)->where('role', 'branch_admin')->first()
            ?? User::where('branch_id', $branch->id)->first();
    }

    private function track($model)
    {
        $this->rows[] = ['type' => get_class($model), 'id' => $model->getKey()];
        return $model;
    }

    private function putSvg(string $path, string $svg): string
    {
        Storage::disk('public')->put($path, $svg);
        $this->files[] = $path;
        return $path;
    }

    private function posterSvg(string $title, string $branch, string $date): string
    {
        $t = htmlspecialchars($title);
        $b = htmlspecialchars($branch);
        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="600" height="800" viewBox="0 0 600 800">
  <rect width="600" height="800" fill="#001f45"/>
  <rect y="640" width="600" height="160" fill="#c8a84b"/>
  <text x="300" y="120" fill="#c8a84b" font-family="Georgia" font-size="22" text-anchor="middle" letter-spacing="3">YES IEM · {$b}</text>
  <text x="300" y="360" fill="#ffffff" font-family="Georgia" font-weight="bold" font-size="40" text-anchor="middle">
    <tspan x="300" dy="0">{$t}</tspan>
  </text>
  <text x="300" y="710" fill="#001f45" font-family="Arial" font-size="26" text-anchor="middle" font-weight="bold">{$date}</text>
</svg>
SVG;
    }

    private function orgChartSvg(string $branch, string $year): string
    {
        $b = htmlspecialchars($branch);
        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="900" height="560" viewBox="0 0 900 560">
  <rect width="900" height="560" fill="#f7f7f4"/>
  <text x="450" y="50" fill="#001f45" font-family="Georgia" font-size="26" font-weight="bold" text-anchor="middle">{$b} — Organisation Chart</text>
  <text x="450" y="80" fill="#888" font-family="Arial" font-size="14" text-anchor="middle">Academic Year {$year}</text>
  <rect x="370" y="110" width="160" height="56" rx="6" fill="#001f45"/><text x="450" y="144" fill="#fff" font-family="Arial" font-size="15" text-anchor="middle">Chairperson</text>
  <rect x="370" y="210" width="160" height="56" rx="6" fill="#c8a84b"/><text x="450" y="244" fill="#001f45" font-family="Arial" font-size="15" text-anchor="middle">Vice Chair</text>
  <rect x="120" y="330" width="150" height="52" rx="6" fill="#2a5d8f"/><text x="195" y="362" fill="#fff" font-family="Arial" font-size="13" text-anchor="middle">Secretary</text>
  <rect x="375" y="330" width="150" height="52" rx="6" fill="#2a5d8f"/><text x="450" y="362" fill="#fff" font-family="Arial" font-size="13" text-anchor="middle">Treasurer</text>
  <rect x="630" y="330" width="150" height="52" rx="6" fill="#2a5d8f"/><text x="705" y="362" fill="#fff" font-family="Arial" font-size="13" text-anchor="middle">Projects Lead</text>
  <line x1="450" y1="166" x2="450" y2="210" stroke="#aaa" stroke-width="2"/>
  <line x1="450" y1="266" x2="450" y2="300" stroke="#aaa" stroke-width="2"/>
  <line x1="195" y1="300" x2="705" y2="300" stroke="#aaa" stroke-width="2"/>
  <line x1="195" y1="300" x2="195" y2="330" stroke="#aaa" stroke-width="2"/>
  <line x1="450" y1="300" x2="450" y2="330" stroke="#aaa" stroke-width="2"/>
  <line x1="705" y1="300" x2="705" y2="330" stroke="#aaa" stroke-width="2"/>
</svg>
SVG;
    }

    private function receiptSvg(string $title, $amount): string
    {
        $t = htmlspecialchars($title);
        $a = number_format((float) $amount, 2);
        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="480" height="640" viewBox="0 0 480 640">
  <rect width="480" height="640" fill="#ffffff" stroke="#ddd"/>
  <text x="240" y="60" fill="#001f45" font-family="Georgia" font-size="22" font-weight="bold" text-anchor="middle">OFFICIAL RECEIPT</text>
  <line x1="40" y1="90" x2="440" y2="90" stroke="#001f45" stroke-width="2"/>
  <text x="40" y="140" fill="#333" font-family="Arial" font-size="14">Event: {$t}</text>
  <text x="40" y="180" fill="#333" font-family="Arial" font-size="14">Description: Event operations &amp; logistics</text>
  <text x="40" y="220" fill="#333" font-family="Arial" font-size="14">Payment method: Bank transfer</text>
  <line x1="40" y1="520" x2="440" y2="520" stroke="#ddd"/>
  <text x="40" y="560" fill="#001f45" font-family="Arial" font-size="20" font-weight="bold">TOTAL: RM {$a}</text>
</svg>
SVG;
    }
}
