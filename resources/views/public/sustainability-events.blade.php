@extends('public.layouts.app')

@section('title', 'Sustainability Events – YES Young Engineer Section | IEM Malaysia')

@push('styles')
<style>
.timeline-strip { background: var(--offwhite); border-bottom: 2px solid var(--light-grey); display: flex; padding: 0 60px; }
.timeline-tab { padding: 18px 24px; font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--grey); background: none; border: none; border-bottom: 3px solid transparent; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; }
.timeline-tab:hover { color: var(--navy); }
.timeline-tab.active { color: var(--navy); border-bottom-color: var(--gold); }
.category-bar { background: var(--white); border-bottom: 1px solid var(--light-grey); padding: 14px 60px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
.category-pills { display: flex; gap: 6px; flex-wrap: wrap; }
.pill { padding: 7px 16px; font-size: 11px; font-weight: 600; letter-spacing: .5px; text-transform: uppercase; color: var(--grey); background: var(--offwhite); border: 1px solid var(--light-grey); cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; }
.pill:hover { color: var(--navy); border-color: var(--navy); }
.pill.active { background: #1a6b3c; color: #a8e6c1; border-color: #1a6b3c; }
.filter-right { display: flex; align-items: center; gap: 12px; }
.search-box { display: flex; align-items: center; gap: 8px; background: var(--white); border: 1px solid var(--light-grey); padding: 8px 14px; }
.search-box input { border: none; outline: none; font-family: 'DM Sans', sans-serif; font-size: 13px; color: #222; background: transparent; width: 180px; }
.search-box svg { width: 15px; height: 15px; stroke: var(--grey); fill: none; stroke-width: 2; }
.sort-select { border: 1px solid var(--light-grey); background: var(--white); padding: 8px 12px; font-family: 'DM Sans', sans-serif; font-size: 12px; font-weight: 600; color: var(--navy); cursor: pointer; outline: none; }
.results-info { padding: 16px 60px; font-size: 13px; color: var(--grey); background: var(--offwhite); border-bottom: 1px solid var(--light-grey); }
.results-info strong { color: var(--navy); }
.events-body { padding: 52px 60px 80px; }
.events-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; }
.event-card { background: var(--white); border: 1px solid var(--light-grey); overflow: hidden; display: flex; flex-direction: column; transition: all .3s; }
.event-card:hover { box-shadow: 0 12px 40px rgba(0,100,50,0.12); transform: translateY(-4px); }
.card-img { height: 200px; position: relative; overflow: hidden; flex-shrink: 0; }
.card-img-inner { width: 100%; height: 100%; background-size: cover; background-position: center; transition: transform .5s; }
.event-card:hover .card-img-inner { transform: scale(1.06); }
.card-badge { position: absolute; top: 14px; left: 14px; background: #1a6b3c; color: #a8e6c1; font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 5px 12px; }
.card-badge.official { background: var(--navy); color: var(--gold); }
.card-status { position: absolute; top: 14px; right: 14px; font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 5px 12px; }
.status-open,.status-approved { background: #1a6b3c; color: #a8e6c1; }
.status-upcoming { background: var(--navy-dark); color: rgba(255,255,255,0.7); }
.status-closed { background: #6b2222; color: #e6a8a8; }
.card-category { position: absolute; bottom: 14px; left: 14px; background: rgba(10,50,30,0.75); color: rgba(255,255,255,0.9); font-size: 9px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; padding: 4px 10px; }
.card-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }
.card-meta { display: flex; align-items: center; gap: 14px; margin-bottom: 10px; flex-wrap: wrap; }
.card-date { font-size: 11px; color: var(--gold); font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
.card-location { font-size: 11px; color: var(--grey); display: flex; align-items: center; gap: 4px; }
.card-location svg { width: 11px; height: 11px; stroke: var(--grey); fill: none; stroke-width: 2; }
.card-body h3 { font-size: 16px; font-weight: 700; color: var(--navy); line-height: 1.3; margin-bottom: 8px; }
.card-body p { font-size: 13px; color: var(--grey); line-height: 1.6; flex: 1; }
.card-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 10px; }
.tag { background: #d1fae5; color: #065f46; padding: 3px 9px; font-size: 10px; font-weight: 600; letter-spacing: .5px; border: 1px solid #a7f3d0; }
.card-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 16px; padding-top: 14px; border-top: 1px solid var(--light-grey); }
.card-seats { font-size: 11px; color: var(--grey); }
.card-seats strong { color: var(--navy); font-weight: 700; }
.card-cta { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: #1a6b3c; text-decoration: none; border-bottom: 2px solid #4caf7d; padding-bottom: 1px; transition: color .2s; }
.card-cta:hover { color: #4caf7d; }
.no-results { grid-column: span 3; text-align: center; padding: 80px 20px; display: none; }
.no-results svg { width: 52px; height: 52px; stroke: var(--light-grey); fill: none; stroke-width: 1.5; margin-bottom: 20px; }
.no-results h3 { font-size: 20px; font-weight: 700; color: var(--navy); margin-bottom: 8px; }
.no-results p { font-size: 14px; color: var(--grey); }
.cta-strip { background: linear-gradient(135deg,#0d4a2b,#1a6b3c); padding: 40px 60px; display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap; margin-top: 52px; }
.cta-strip h3 { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 900; color: var(--white); margin-bottom: 6px; }
.cta-strip p { font-size: 14px; color: rgba(255,255,255,0.7); }
.btn-green-solid { background: #4caf7d; color: var(--white); padding: 13px 28px; font-weight: 700; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; white-space: nowrap; transition: all .2s; }
.btn-green-solid:hover { background: #a8e6c1; color: #0d4a2b; }
.pagination { display: flex; align-items: center; justify-content: center; gap: 4px; margin-top: 48px; }
.page-btn { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--light-grey); background: var(--white); font-size: 13px; font-weight: 600; color: var(--navy); cursor: pointer; transition: all .2s; text-decoration: none; }
.page-btn:hover { background: var(--offwhite); border-color: var(--navy); }
.page-btn.active { background: var(--navy); color: var(--gold); border-color: var(--navy); }
.hero-stats { display: flex; gap: 32px; flex-shrink: 0; }
.hero-stats .big { font-family: 'Playfair Display', serif; font-size: 48px; font-weight: 900; color: var(--gold); line-height: 1; text-align: right; }
.hero-stats .lbl { font-size: 11px; color: rgba(255,255,255,0.5); letter-spacing: 2px; text-transform: uppercase; margin-top: 4px; }
.bg-g1{background:linear-gradient(135deg,#0d4a2b,#2d8a55)} .bg-g2{background:linear-gradient(135deg,#1a6b3c,#4caf7d)} .bg-g3{background:linear-gradient(135deg,#064e3b,#047857)} .bg-g4{background:linear-gradient(135deg,#0d4a2b,#1a6b3c)} .bg-g5{background:linear-gradient(135deg,#14532d,#16a34a)} .bg-g6{background:linear-gradient(135deg,#052e16,#15803d)}
</style>
@endpush

@section('content')

<div class="page-hero">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a><span>›</span>
    <a href="#">Events</a><span>›</span>
    <span class="current">Sustainability Events</span>
  </div>
  <div class="hero-inner">
    <div class="hero-left">
      <h1>Sustainability <em>Events</em></h1>
      <p>Volunteer drives, green outreach camps, environmental workshops, and community campaigns — engineering a better planet one project at a time.</p>
    </div>
    <div class="hero-stats">
      <div class="hero-stat"><div class="big">{{ $events->count() + $officialSdg->count() }}</div><div class="lbl">Events This Year</div></div>
      <div class="hero-stat"><div class="big">{{ $events->pluck('branch_id')->unique()->count() }}</div><div class="lbl">Branches</div></div>
    </div>
  </div>
</div>

<div class="timeline-strip">
  <button class="timeline-tab active" onclick="filterTimeline('present', this)">Present Events</button>
  <button class="timeline-tab" onclick="filterTimeline('past', this)">Past Events</button>
</div>

<div class="category-bar">
  <div class="category-pills">
    <button class="pill active" onclick="filterCat('all', this)">All Categories</button>
    <button class="pill" onclick="filterCat('volunteer', this)">Volunteer</button>
    <button class="pill" onclick="filterCat('outreach', this)">Outreach</button>
    <button class="pill" onclick="filterCat('workshop', this)">Workshop</button>
    <button class="pill" onclick="filterCat('campaign', this)">Campaign</button>
    <button class="pill" onclick="filterCat('sdg-event', this)">SDG Event</button>
  </div>
  <div class="filter-right">
    <div class="search-box">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <input type="text" placeholder="Search events..." oninput="searchEvents(this.value)"/>
    </div>
    <select class="sort-select" onchange="sortEvents(this.value)">
      <option value="date-asc">Date: Soonest First</option>
      <option value="date-desc">Date: Latest First</option>
      <option value="name-asc">Name: A–Z</option>
    </select>
  </div>
</div>

<div class="results-info" id="resultsInfo">Showing <strong>{{ $events->count() + $officialSdg->count() }}</strong> events</div>

<div class="events-body">
  <div class="events-grid" id="eventsGrid">

    @php $bgColors = ['bg-g1','bg-g2','bg-g3','bg-g4','bg-g5','bg-g6']; $idx = 0; @endphp

    @forelse($events as $event)
    @php
      $statusKey   = $event->status === 'past' ? 'closed' : $event->status;
      $statusLabel = match($event->status) { 'open'=>'Open','approved'=>'Open','upcoming'=>'Upcoming','past'=>'Past',default=>ucfirst($event->status) };
      $catSlug     = strtolower(str_replace([' ', '/'], '-', $event->category ?? 'volunteer'));
      $bgClass     = $bgColors[$idx % 6]; $idx++;
    @endphp
    <div class="event-card reveal"
         data-cat="{{ $catSlug }}"
         data-status="{{ $statusKey }}"
         data-name="{{ strtolower($event->title) }}"
         data-date="{{ $event->start_date?->format('Y-m-d') }}">
      <div class="card-img">
        <div class="card-img-inner {{ $bgClass }}" @if($event->poster_url) style="background-image:url('{{ $event->poster_url }}')" @endif></div>
        <div class="card-badge">Green</div>
        <div class="card-status status-{{ $statusKey }}">{{ $statusLabel }}</div>
        @if($event->category)<div class="card-category">{{ $event->category }}</div>@endif
      </div>
      <div class="card-body">
        <div class="card-meta">
          <span class="card-date">{{ $event->date_display }}</span>
          @if($event->venue)<span class="card-location"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>{{ $event->venue }}</span>@endif
        </div>
        <h3>{{ $event->title }}</h3>
        <p>{{ Str::limit($event->description, 120) }}</p>
        @if($event->tags)<div class="card-tags">@foreach(array_slice((array)$event->tags,0,3) as $tag)<span class="tag">{{ $tag }}</span>@endforeach</div>@endif
        <div class="card-footer">
          @if($event->status === 'past')
            <span class="card-seats">Event <strong>Concluded</strong></span>
            <a href="#" class="card-cta">View Highlights →</a>
          @else
            <span class="card-seats">Slots <strong>Open</strong></span>
            <a href="{{ route('login.student') }}" class="card-cta">Volunteer Now →</a>
          @endif
        </div>
      </div>
    </div>
    @empty
    @endforelse

    @foreach($officialSdg as $event)
    @php
      $statusKey   = $event->status === 'past' ? 'closed' : $event->status;
      $statusLabel = match($event->status) { 'open'=>'Open','upcoming'=>'Upcoming','past'=>'Past',default=>ucfirst($event->status) };
      $bgClass     = $bgColors[$idx % 6]; $idx++;
    @endphp
    <div class="event-card reveal"
         data-cat="campaign"
         data-status="{{ $statusKey }}"
         data-name="{{ strtolower($event->name) }}"
         data-date="{{ $event->start_date?->format('Y-m-d') }}">
      <div class="card-img">
        <div class="card-img-inner {{ $bgClass }}" @if($event->poster_url) style="background-image:url('{{ $event->poster_url }}')" @endif></div>
        <div class="card-badge official">Official</div>
        <div class="card-status status-{{ $statusKey }}">{{ $statusLabel }}</div>
      </div>
      <div class="card-body">
        <div class="card-meta">
          <span class="card-date">{{ $event->start_date?->format('j M Y') }}</span>
          @if($event->location)<span class="card-location"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>{{ $event->location }}</span>@endif
        </div>
        <h3>{{ $event->name }}</h3>
        <p>{{ Str::limit($event->description, 120) }}</p>
        <div class="card-footer">
          @if($event->status === 'past')
            <span class="card-seats">Event <strong>Concluded</strong></span><a href="#" class="card-cta">View Highlights →</a>
          @else
            @php $sl = $event->total_seats ? ($event->total_seats - $event->registered_count) : null; @endphp
            @if($sl !== null)<span class="card-seats">Slots: <strong>{{ $sl }} / {{ $event->total_seats }}</strong></span>
            @else<span class="card-seats">Open Registration</span>@endif
            <a href="{{ route('login') }}" class="card-cta">Register Now →</a>
          @endif
        </div>
      </div>
    </div>
    @endforeach

    <div class="no-results" id="noResults">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <h3>No events found</h3><p>Try adjusting your filters.</p>
    </div>
  </div>

  <div class="cta-strip reveal">
    <div><h3>Ready to Make a Green Impact?</h3><p>Register as a YES Sustainability Volunteer and be the first notified of new green events.</p></div>
    <a href="#" class="btn-green-solid">Register as Volunteer →</a>
  </div>
  <div class="pagination">
    <a href="#" class="page-btn">‹</a>
    <a href="#" class="page-btn active">1</a>
    <span style="font-size:13px;color:var(--grey);padding:0 16px">Showing {{ $events->count() + $officialSdg->count() }} events</span>
    <a href="#" class="page-btn">›</a>
  </div>
</div>

@endsection

@push('scripts')
<script>
let activeCat = 'all', activeSearch = '', activeTimeline = 'present';
const allCards = () => Array.from(document.querySelectorAll('.event-card[data-cat]'));
function filterTimeline(tl, btn) {
  activeTimeline = tl;
  document.querySelectorAll('.timeline-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active'); applyFilters();
}
function filterCat(cat, btn) {
  activeCat = cat;
  document.querySelectorAll('.pill').forEach(b => b.classList.remove('active'));
  btn.classList.add('active'); applyFilters();
}
function searchEvents(val) { activeSearch = val.toLowerCase(); applyFilters(); }
function sortEvents(val) {
  const grid = document.getElementById('eventsGrid');
  allCards().sort((a, b) => {
    if (val === 'date-asc') return new Date(a.dataset.date) - new Date(b.dataset.date);
    if (val === 'date-desc') return new Date(b.dataset.date) - new Date(a.dataset.date);
    return a.dataset.name.localeCompare(b.dataset.name);
  }).forEach(c => grid.appendChild(c));
}
function applyFilters() {
  let visible = 0;
  allCards().forEach(card => {
    const isPast = card.dataset.status === 'closed';
    const ok = ((activeTimeline === 'present' && !isPast) || (activeTimeline === 'past' && isPast))
              && (activeCat === 'all' || card.dataset.cat === activeCat)
              && (!activeSearch || card.dataset.name.includes(activeSearch));
    card.style.display = ok ? '' : 'none';
    if (ok) visible++;
  });
  document.getElementById('noResults').style.display = visible === 0 ? 'block' : 'none';
  document.getElementById('resultsInfo').innerHTML = `Showing <strong>${visible}</strong> event${visible !== 1 ? 's' : ''}`;
}
applyFilters();
</script>
@endpush
