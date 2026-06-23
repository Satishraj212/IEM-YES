@extends('public.layouts.app')

@section('title', 'Official Board Events – YES Young Engineer Section | IEM Malaysia')

@push('styles')
<style>
/* ── filter bar ── */
.filter-bar { background: var(--offwhite); border-bottom: 2px solid var(--light-grey); padding: 0 60px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; min-height: 64px; }
.filter-left { display: flex; align-items: center; gap: 0; }
.filter-tab { padding: 20px 20px; font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--grey); background: none; border: none; border-bottom: 3px solid transparent; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; white-space: nowrap; }
.filter-tab:hover { color: var(--navy); }
.filter-tab.active { color: var(--navy); border-bottom-color: var(--gold); }
.filter-right { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.search-box { display: flex; align-items: center; gap: 8px; background: var(--white); border: 1px solid var(--light-grey); padding: 8px 14px; }
.search-box input { border: none; outline: none; font-family: 'DM Sans', sans-serif; font-size: 13px; color: #222; background: transparent; width: 160px; }
.search-box svg { width: 15px; height: 15px; stroke: var(--grey); fill: none; stroke-width: 2; flex-shrink: 0; }
.filter-sel { border: 1px solid var(--light-grey); background: var(--white); padding: 8px 12px; font-family: 'DM Sans', sans-serif; font-size: 12px; font-weight: 600; color: var(--navy); cursor: pointer; outline: none; }

/* ── event grid ── */
.events-body { padding: 52px 60px 80px; }
.events-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; }

/* ── card base ── */
.event-card { background: var(--white); border: 1px solid var(--light-grey); overflow: hidden; display: flex; flex-direction: column; transition: all .3s; }
.event-card:hover { box-shadow: 0 12px 40px rgba(0,31,69,0.1); transform: translateY(-4px); }

/* ── card image ── */
.card-img { height: 210px; position: relative; overflow: hidden; flex-shrink: 0; }
.card-img-inner { width: 100%; height: 100%; background-size: cover; background-position: center; transition: transform .5s; }
.event-card:hover .card-img-inner { transform: scale(1.06); }
.card-badge { position: absolute; top: 14px; left: 14px; background: var(--navy); color: var(--gold); font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 5px 12px; }
.card-status { position: absolute; top: 14px; right: 14px; font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 5px 12px; }
.status-open { background: #1a6b3c; color: #a8e6c1; }
.status-upcoming { background: var(--navy-dark); color: rgba(255,255,255,0.7); }
.status-closed { background: #6b2222; color: #e6a8a8; }

/* ── card body ── */
.card-body { padding: 22px 22px 18px; flex: 1; display: flex; flex-direction: column; }
.card-meta { display: flex; flex-direction: column; gap: 6px; margin-bottom: 12px; }
.card-meta-row { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.card-date { font-size: 11px; color: var(--gold); font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
.card-info { font-size: 11px; color: var(--grey); display: flex; align-items: center; gap: 4px; }
.card-info svg { width: 11px; height: 11px; stroke: var(--grey); fill: none; stroke-width: 2; flex-shrink: 0; }
.card-branch { font-size: 10px; color: var(--gold); font-weight: 600; letter-spacing: .5px; text-transform: uppercase; background: rgba(200,168,75,0.1); padding: 2px 8px; border: 1px solid rgba(200,168,75,0.3); }
.card-body h3 { font-size: 17px; font-weight: 700; color: var(--navy); line-height: 1.3; margin-bottom: 8px; }
.card-desc { font-size: 13px; color: var(--grey); line-height: 1.7; flex: 1; }
.card-tags { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 10px; }
.card-tag { background: var(--offwhite); color: var(--navy); padding: 2px 8px; font-size: 10px; font-weight: 600; border: 1px solid var(--light-grey); }
.card-contact { display: flex; align-items: center; gap: 6px; margin-top: 10px; padding-top: 10px; border-top: 1px solid var(--light-grey); font-size: 11px; color: var(--grey); }
.card-contact svg { width: 11px; height: 11px; stroke: var(--grey); fill: none; stroke-width: 2; flex-shrink: 0; }
.card-contact strong { color: var(--navy); }
.card-contact .sep { color: var(--light-grey); }


/* ── featured card (first, spans full row) ── */
.event-card.featured { grid-column: span 3; flex-direction: row; }
.event-card.featured .card-img { height: auto; min-height: 280px; width: 380px; flex-shrink: 0; }
.event-card.featured .card-img .card-img-inner { height: 100%; }
.event-card.featured .card-body { padding: 32px 36px; }
.event-card.featured .card-body h3 { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 900; margin-bottom: 10px; }
.event-card.featured .card-desc { -webkit-line-clamp: unset; display: block; }

/* ── empty / no results ── */
.no-results { grid-column: span 3; text-align: center; padding: 80px 20px; display: none; }
.no-results svg { width: 52px; height: 52px; stroke: var(--light-grey); fill: none; stroke-width: 1.5; margin-bottom: 20px; }
.no-results h3 { font-size: 20px; font-weight: 700; color: var(--navy); margin-bottom: 8px; }
.no-results p { font-size: 14px; color: var(--grey); }

/* ── pagination ── */
.pagination { display: flex; align-items: center; justify-content: center; gap: 4px; margin-top: 48px; }
.page-btn { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--light-grey); background: var(--white); font-size: 13px; font-weight: 600; color: var(--navy); cursor: pointer; transition: all .2s; text-decoration: none; }
.page-btn:hover { background: var(--offwhite); border-color: var(--navy); }
.page-btn.active { background: var(--navy); color: var(--gold); border-color: var(--navy); }

/* ── image gradient fallbacks ── */
.bg-1{background:linear-gradient(135deg,#1a3a6b,#2460a7)}
.bg-2{background:linear-gradient(135deg,#001f45,#0a4a8c)}
.bg-3{background:linear-gradient(135deg,#0d2a4a,#1a5f8c)}
.bg-4{background:linear-gradient(135deg,#1a2a6b,#2444a7)}
.bg-5{background:linear-gradient(135deg,#0a1f45,#103a7a)}
.bg-6{background:linear-gradient(135deg,#062040,#0d3870)}
</style>
@endpush

@section('content')

@php
  $allCategories = $events->pluck('category')->unique()->filter()->sort()->values();
@endphp

<div class="page-hero">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a><span>›</span>
    <a href="#">Events</a><span>›</span>
    <span class="current">Official Board Events</span>
  </div>
  <div class="hero-inner">
    <div class="hero-left">
      <h1>YES <em>HQ</em> Events</h1>
      <p>Professionally curated events organised by the YES National Board — leadership forums, industry summits, annual general meetings, and strategic retreats for members nationwide.</p>
    </div>
    <div class="hero-stat">
      <div class="big">{{ $eventsThisYear }}</div>
      <div class="lbl">Events This Year</div>
    </div>
  </div>
</div>

<div class="filter-bar">
  <div class="filter-left">
    <button class="filter-tab active" onclick="setTimeline('present', this)">Present</button>
    <button class="filter-tab"        onclick="setTimeline('past', this)">Past</button>
  </div>
  <div class="filter-right">
    @if($allCategories->isNotEmpty())
    <select class="filter-sel" onchange="setCategory(this.value)">
      <option value="">All Categories</option>
      @foreach($allCategories as $cat)
        <option value="{{ strtolower(str_replace([' ','/'], '-', $cat)) }}">{{ $cat }}</option>
      @endforeach
    </select>
    @endif
    <div class="search-box">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <input type="text" id="searchInput" placeholder="Search events…" oninput="setSearch(this.value)"/>
    </div>
    <select class="filter-sel" id="sortSel" onchange="sortEvents(this.value)">
      <option value="date-asc">Date: Soonest</option>
      <option value="date-desc">Date: Latest</option>
      <option value="name-asc">Name: A–Z</option>
    </select>
  </div>
</div>

<div class="events-body">
  <div class="events-grid" id="eventsGrid">

    @forelse($events as $event)
    @php
      $featured    = $loop->first;
      $statusKey   = $event->effective_status === 'past' ? 'closed' : $event->effective_status;
      $statusLabel = match($event->effective_status) { 'open'=>'Open','upcoming'=>'Upcoming','past'=>'Past', default=>ucfirst($event->effective_status) };
      $bgClass     = 'bg-' . (($loop->index % 6) + 1);
      $catSlug     = strtolower(str_replace([' ','/'], '-', $event->category ?? ''));

      $dateRange = $event->end_date && $event->end_date->ne($event->start_date)
        ? $event->start_date?->format('j') . '–' . $event->end_date?->format('j M Y')
        : $event->start_date?->format('j M Y');

      $descLimit = $featured ? 320 : 120;
    @endphp

    <div class="event-card {{ $featured ? 'featured' : '' }} reveal"
         data-status="{{ $statusKey }}"
         data-name="{{ strtolower($event->name) }}"
         data-date="{{ $event->start_date?->format('Y-m-d') }}"
         data-category="{{ $catSlug }}"
         data-organiser="{{ strtolower($event->organiser ?? '') }}"
         data-location="{{ strtolower($event->location ?? '') }}">

      {{-- ── IMAGE / POSTER ── --}}
      <div class="card-img">
        <div class="card-img-inner {{ $bgClass }}"
             @if($event->poster_src) style="background-image:url('{{ $event->poster_src }}')" @endif></div>
        <div class="card-badge">{{ $event->category ?? 'Official' }}</div>
        <div class="card-status status-{{ $statusKey }}">{{ $statusLabel }}</div>
      </div>

      {{-- ── BODY ── --}}
      <div class="card-body">

        {{-- Date · Time · Branch ── --}}
        <div class="card-meta">
          <div class="card-meta-row">
            <span class="card-date">
              {{ $dateRange }}
              @if($event->start_time) · {{ $event->start_time }}@endif
            </span>
            <span class="card-branch">{{ $event->branch_name }}</span>
          </div>

          {{-- Location ── --}}
          @if($event->location)
          <div class="card-meta-row">
            <span class="card-info">
              <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              {{ $event->location }}
            </span>
          </div>
          @endif
        </div>

        {{-- Title ── --}}
        <h3>{{ $event->name }}</h3>

        {{-- Description ── --}}
        @if($event->description)
          <p class="card-desc">{{ Str::limit($event->description, $descLimit) }}</p>
        @endif

        {{-- Tags ── --}}
        @if($event->tags && count($event->tags))
          <div class="card-tags">
            @foreach($event->tags as $tag)
              <span class="card-tag">{{ $tag }}</span>
            @endforeach
          </div>
        @endif

        {{-- Organiser + Phone ── --}}
        @if($event->organiser)
          <div class="card-contact">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <strong>{{ $event->organiser }}</strong>
            @if($event->organiser_phone)
              <span class="sep">·</span>
              <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.35 2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.6a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              {{ $event->organiser_phone }}
            @endif
          </div>
        @endif


      </div>
    </div>

    @empty
    <div class="no-results" style="display:flex;flex-direction:column;align-items:center;grid-column:span 3;padding:80px 20px">
      <svg viewBox="0 0 24 24" style="width:52px;height:52px;stroke:var(--light-grey);fill:none;stroke-width:1.5;margin-bottom:20px"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      <h3 style="font-size:20px;font-weight:700;color:var(--navy);margin-bottom:8px">No events published yet</h3>
      <p style="font-size:14px;color:var(--grey)">Check back soon for upcoming YES HQ events.</p>
    </div>
    @endforelse

    <div class="no-results" id="noResults">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <h3>No events match your filters</h3>
      <p>Try a different category or search term.</p>
    </div>

  </div>

  <div class="pagination">
    <button class="page-btn" id="pgPrev" onclick="goPage(-1)">‹</button>
    <span class="page-btn active" id="pgNum">1</span>
    <span style="font-size:13px;color:var(--grey);padding:0 16px" id="pgInfo"></span>
    <button class="page-btn" id="pgNext" onclick="goPage(1)">›</button>
  </div>
</div>

@endsection

@push('scripts')
<script>
const PER_PAGE = 7;
let activeTimeline = 'present', activeCategory = '', searchQuery = '', activeSort = 'date-asc';
let currentPage = 1;

const allCards = () => Array.from(document.querySelectorAll('.event-card[data-status]'));

function setTimeline(tl, btn) {
  activeTimeline = tl;
  document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  activeSort = tl === 'past' ? 'date-desc' : 'date-asc';
  const sel = document.getElementById('sortSel');
  if (sel) sel.value = activeSort;
  currentPage = 1;
  sortGrid();
  applyFilters();
}

function setCategory(cat) { activeCategory = cat; currentPage = 1; applyFilters(); }
function setSearch(val)    { searchQuery = val.toLowerCase().trim(); currentPage = 1; applyFilters(); }

function sortEvents(val) {
  activeSort = val;
  currentPage = 1;
  sortGrid();
  applyFilters();
}

function sortGrid() {
  const grid = document.getElementById('eventsGrid');
  allCards().sort((a, b) => {
    if (activeSort === 'date-asc')  return new Date(a.dataset.date) - new Date(b.dataset.date);
    if (activeSort === 'date-desc') return new Date(b.dataset.date) - new Date(a.dataset.date);
    return a.dataset.name.localeCompare(b.dataset.name);
  }).forEach(c => grid.appendChild(c));
}

function applyFilters() {
  const cards = allCards();
  cards.forEach(c => c.classList.remove('featured'));

  // Build the full filtered list
  const matched = [];
  cards.forEach(card => {
    const isPast = card.dataset.status === 'closed';
    const haystack = [card.dataset.name, card.dataset.organiser, card.dataset.location].join(' ');
    const ok = ((activeTimeline === 'present' && !isPast) || (activeTimeline === 'past' && isPast))
            && (!activeCategory || card.dataset.category === activeCategory)
            && (!searchQuery    || haystack.includes(searchQuery));
    if (ok) matched.push(card);
  });

  // Clamp page
  const totalPages = Math.max(1, Math.ceil(matched.length / PER_PAGE));
  if (currentPage > totalPages) currentPage = totalPages;

  // Slice to current page
  const start = (currentPage - 1) * PER_PAGE;
  const pageCards = matched.slice(start, start + PER_PAGE);

  // Show/hide
  cards.forEach(c => { c.style.display = 'none'; });
  pageCards.forEach((c, i) => {
    c.style.display = '';
    if (i === 0) c.classList.add('featured');
  });

  // No-results
  document.getElementById('noResults').style.display = matched.length === 0 ? 'block' : 'none';

  // Pagination UI
  const end = Math.min(currentPage * PER_PAGE, matched.length);
  const info = document.getElementById('pgInfo');
  if (info) info.textContent = matched.length > 0
    ? `Showing ${start + 1}–${end} of ${matched.length} event${matched.length !== 1 ? 's' : ''}`
    : '';

  const pgNum  = document.getElementById('pgNum');
  const pgPrev = document.getElementById('pgPrev');
  const pgNext = document.getElementById('pgNext');
  if (pgNum)  pgNum.textContent = currentPage;
  if (pgPrev) { pgPrev.disabled = currentPage <= 1; pgPrev.style.opacity = currentPage <= 1 ? '.35' : '1'; }
  if (pgNext) { pgNext.disabled = currentPage >= totalPages; pgNext.style.opacity = currentPage >= totalPages ? '.35' : '1'; }
}

function goPage(dir) {
  currentPage += dir;
  applyFilters();
  document.getElementById('eventsGrid').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

sortGrid();
applyFilters();
</script>
@endpush
