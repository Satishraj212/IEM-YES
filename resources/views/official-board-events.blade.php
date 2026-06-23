<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Official Board Events – YES Young Engineer Section | IEM Malaysia</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<style>
:root {
  --navy: #003366;
  --navy-dark: #001f45;
  --gold: #c8a84b;
  --gold-light: #e8c96a;
  --white: #ffffff;
  --offwhite: #f5f4f0;
  --grey: #6b7280;
  --light-grey: #e8e8e4;
}
* { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }
body { font-family: 'DM Sans', sans-serif; color: #222; background: var(--white); overflow-x: hidden; }

.top-bar { background: var(--navy-dark); color: rgba(255,255,255,0.65); font-size: 12px; display: flex; justify-content: flex-end; align-items: center; gap: 24px; padding: 7px 60px; }
.top-bar a { color: rgba(255,255,255,0.65); text-decoration: none; transition: color .2s; }
.top-bar a:hover { color: var(--gold); }

nav { position: sticky; top: 0; z-index: 1000; background: var(--white); border-bottom: 3px solid var(--gold); display: flex; align-items: center; justify-content: space-between; padding: 0 60px; height: 72px; box-shadow: 0 2px 20px rgba(0,0,0,0.08); }
.logo { display: flex; align-items: center; text-decoration: none; }
.nav-logo-img { height: 52px; width: auto; display: block; object-fit: contain; }
.nav-links { display: flex; list-style: none; height: 100%; }
.nav-links > li { position: relative; height: 100%; display: flex; align-items: center; }
.nav-links > li > a { display: flex; align-items: center; gap: 5px; padding: 0 22px; height: 100%; text-decoration: none; color: var(--navy); font-size: 14px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; transition: color .2s; position: relative; }
.nav-links > li > a::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: var(--gold); transform: scaleX(0); transition: transform .25s ease; }
.nav-links > li:hover > a { color: var(--gold); }
.nav-links > li:hover > a::after { transform: scaleX(1); }
.nav-links > li.active > a { color: var(--gold); }
.nav-links > li.active > a::after { transform: scaleX(1); }
.nav-arrow { width: 0; height: 0; border-left: 4px solid transparent; border-right: 4px solid transparent; border-top: 5px solid currentColor; transition: transform .2s; }
.nav-links > li:hover .nav-arrow { transform: rotate(180deg); }
.mega-menu { position: absolute; top: 100%; left: 0; width: max-content; min-width: 420px; max-width: min(680px, calc(100vw - 60px)); background: var(--white); box-shadow: 0 20px 60px rgba(0,51,102,0.15); display: grid; grid-template-columns: 1fr 1fr; opacity: 0; pointer-events: none; transform: translateY(-8px); transition: all .25s ease; border-top: 3px solid var(--gold); }
.nav-links > li:nth-last-child(-n+2) .mega-menu { left: auto; right: 0; }
.nav-links > li:hover .mega-menu { opacity: 1; pointer-events: all; transform: translateY(0); }
.mega-menu.single-col { grid-template-columns: 1fr; min-width: 260px; max-width: 300px; }
.mega-col { padding: 28px 30px; }
.mega-col:first-child { background: var(--offwhite); border-right: 1px solid var(--light-grey); }
.mega-menu.single-col .mega-col:first-child { border-right: none; }
.mega-col h4 { font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--gold); margin-bottom: 14px; padding-bottom: 8px; border-bottom: 1px solid var(--light-grey); }
.mega-col ul { list-style: none; }
.mega-col ul li a { display: block; padding: 6px 0; color: var(--navy); text-decoration: none; font-size: 13.5px; transition: all .15s; }
.mega-col ul li a:hover { color: var(--gold); padding-left: 8px; }
.mega-col ul li a.active-link { color: var(--gold); font-weight: 600; padding-left: 8px; border-left: 2px solid var(--gold); }

.page-hero { background: var(--navy-dark); padding: 72px 60px 52px; position: relative; overflow: hidden; }
.page-hero::before { content: ''; position: absolute; top: -80px; right: -80px; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(200,168,75,0.06) 0%, transparent 70%); }
.page-hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--gold) 0%, transparent 60%); }
.breadcrumb { display: flex; align-items: center; gap: 8px; margin-bottom: 18px; font-size: 12px; letter-spacing: 1.5px; text-transform: uppercase; }
.breadcrumb a { color: rgba(255,255,255,0.5); text-decoration: none; transition: color .2s; }
.breadcrumb a:hover { color: var(--gold); }
.breadcrumb span { color: rgba(255,255,255,0.25); }
.breadcrumb .current { color: var(--gold); }
.hero-inner { display: flex; align-items: flex-end; justify-content: space-between; gap: 40px; }
.hero-left h1 { font-family: 'Playfair Display', serif; font-size: clamp(32px, 4vw, 52px); color: var(--white); font-weight: 900; line-height: 1.1; }
.hero-left h1 em { color: var(--gold); font-style: normal; }
.hero-left p { font-size: 15px; color: rgba(255,255,255,0.65); margin-top: 14px; max-width: 500px; line-height: 1.7; }
.hero-stat { text-align: right; flex-shrink: 0; }
.hero-stat .big { font-family: 'Playfair Display', serif; font-size: 56px; font-weight: 900; color: var(--gold); line-height: 1; }
.hero-stat .lbl { font-size: 11px; color: rgba(255,255,255,0.5); letter-spacing: 2px; text-transform: uppercase; margin-top: 4px; }

.filter-bar { background: var(--offwhite); border-bottom: 2px solid var(--light-grey); padding: 0 60px; display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap; min-height: 64px; }
.filter-tabs { display: flex; }
.filter-tab { padding: 20px 22px; font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--grey); background: none; border: none; border-bottom: 3px solid transparent; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; white-space: nowrap; }
.filter-tab:hover { color: var(--navy); }
.filter-tab.active { color: var(--navy); border-bottom-color: var(--gold); }
.filter-right { display: flex; align-items: center; gap: 12px; }
.search-box { display: flex; align-items: center; gap: 8px; background: var(--white); border: 1px solid var(--light-grey); padding: 8px 14px; }
.search-box input { border: none; outline: none; font-family: 'DM Sans', sans-serif; font-size: 13px; color: #222; background: transparent; width: 180px; }
.search-box svg { width: 15px; height: 15px; stroke: var(--grey); fill: none; stroke-width: 2; flex-shrink: 0; }
.sort-select { border: 1px solid var(--light-grey); background: var(--white); padding: 8px 12px; font-family: 'DM Sans', sans-serif; font-size: 12px; font-weight: 600; color: var(--navy); cursor: pointer; outline: none; }

.events-body { padding: 52px 60px 80px; }
.events-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; margin-bottom: 52px; }

.event-card { background: var(--white); border: 1px solid var(--light-grey); overflow: hidden; transition: transform .3s, box-shadow .3s; display: flex; flex-direction: column; }
.event-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(0,31,69,0.12); border-color: rgba(200,168,75,0.3); }
.card-img { height: 210px; position: relative; overflow: hidden; flex-shrink: 0; }
.card-img-inner { width: 100%; height: 100%; background-size: cover; background-position: center; transition: transform .5s; }
.event-card:hover .card-img-inner { transform: scale(1.06); }
.card-badge { position: absolute; top: 14px; left: 14px; background: var(--navy); color: var(--gold); font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 5px 12px; }
.card-status { position: absolute; top: 14px; right: 14px; font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 5px 12px; }
.status-open { background: #1a6b3c; color: #a8e6c1; }
.status-upcoming { background: var(--navy-dark); color: rgba(255,255,255,0.7); }
.status-closed { background: #6b2222; color: #e6a8a8; }
.status-full { background: #6b4f1a; color: #e6c87a; }
.card-body { padding: 22px 22px 18px; flex: 1; display: flex; flex-direction: column; }
.card-meta { display: flex; flex-direction: column; gap: 6px; margin-bottom: 12px; }
.card-meta-row { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.card-date { font-size: 11px; color: var(--gold); font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
.card-location { font-size: 11px; color: var(--grey); display: flex; align-items: center; gap: 4px; }
.card-location svg { width: 11px; height: 11px; stroke: var(--grey); fill: none; stroke-width: 2; }
.card-branch { font-size: 10px; color: var(--gold); font-weight: 600; letter-spacing: .5px; text-transform: uppercase; background: rgba(200,168,75,0.1); padding: 2px 8px; border: 1px solid rgba(200,168,75,0.3); }
.card-body h3 { font-size: 17px; font-weight: 700; color: var(--navy); line-height: 1.3; margin-bottom: 8px; }
.card-desc { font-size: 13px; color: var(--grey); line-height: 1.7; flex: 1; }
.card-tags { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 10px; }
.card-tag { background: var(--offwhite); color: var(--navy); padding: 2px 8px; font-size: 10px; font-weight: 600; border: 1px solid var(--light-grey); }
.card-contact { display: flex; align-items: center; gap: 6px; margin-top: 10px; padding-top: 10px; border-top: 1px solid var(--light-grey); font-size: 11px; color: var(--grey); }
.card-contact svg { width: 11px; height: 11px; stroke: var(--grey); fill: none; stroke-width: 2; flex-shrink: 0; }
.card-contact strong { color: var(--navy); }
.card-contact .sep { color: var(--light-grey); }
.card-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 18px; padding-top: 16px; border-top: 1px solid var(--light-grey); }
.card-seats { font-size: 11px; color: var(--grey); }
.card-seats strong { color: var(--navy); font-weight: 700; }
.card-cta { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--navy); text-decoration: none; border-bottom: 2px solid var(--gold); padding-bottom: 1px; transition: color .2s; }
.card-cta:hover { color: var(--gold); }
.card-cta.disabled { color: var(--grey); border-bottom-color: var(--light-grey); pointer-events: none; }
.event-card.featured { grid-column: span 3; flex-direction: row; }
.event-card.featured .card-img { height: auto; min-height: 260px; width: 420px; flex-shrink: 0; }
.event-card.featured .card-body { padding: 36px 40px; }
.event-card.featured .card-body h3 { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 900; }

.pagination { display: flex; align-items: center; justify-content: center; gap: 4px; }
.page-btn { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--light-grey); background: var(--white); font-size: 13px; font-weight: 600; color: var(--navy); cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; text-decoration: none; }
.page-btn:hover { background: var(--offwhite); border-color: var(--navy); }
.page-btn.active { background: var(--navy); color: var(--gold); border-color: var(--navy); }
.page-btn.arrow { font-size: 16px; color: var(--grey); }
.page-btn.arrow:hover { color: var(--navy); }
.page-info { font-size: 13px; color: var(--grey); margin: 0 16px; }

.no-results { grid-column: span 3; text-align: center; padding: 80px 20px; }
.no-results svg { width: 52px; height: 52px; stroke: var(--light-grey); fill: none; stroke-width: 1.5; margin-bottom: 20px; }
.no-results h3 { font-size: 20px; font-weight: 700; color: var(--navy); margin-bottom: 8px; }
.no-results p { font-size: 14px; color: var(--grey); }

.reveal { opacity: 0; transform: translateY(24px); transition: opacity .6s ease, transform .6s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-delay-1 { transition-delay: .08s; } .reveal-delay-2 { transition-delay: .16s; }
.reveal-delay-3 { transition-delay: .24s; } .reveal-delay-4 { transition-delay: .32s; }
.reveal-delay-5 { transition-delay: .40s; } .reveal-delay-6 { transition-delay: .48s; }

.back-top { position: fixed; bottom: 32px; right: 32px; width: 46px; height: 46px; background: var(--gold); color: var(--navy-dark); display: flex; align-items: center; justify-content: center; font-size: 20px; cursor: pointer; opacity: 0; transition: opacity .3s; z-index: 999; text-decoration: none; font-weight: 700; }
.back-top.visible { opacity: 1; }

footer { background: var(--navy-dark); padding: 48px 60px 0; }
.footer-bottom { padding: 20px 0; display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: rgba(255,255,255,0.35); border-top: 1px solid rgba(255,255,255,0.1); }
.footer-bottom a { color: rgba(255,255,255,0.35); text-decoration: none; margin-left: 20px; }
.footer-bottom a:hover { color: var(--gold); }
.footer-mini { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 40px; padding-bottom: 40px; }
.footer-mini p { font-size: 13px; color: rgba(255,255,255,0.55); line-height: 1.8; margin-top: 12px; max-width: 300px; }
.footer-mini h4 { font-size: 10px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase; color: var(--gold); margin-bottom: 16px; }
.footer-mini ul { list-style: none; }
.footer-mini ul li { margin-bottom: 9px; }
.footer-mini ul li a { color: rgba(255,255,255,0.55); text-decoration: none; font-size: 13px; transition: color .2s; }
.footer-mini ul li a:hover { color: var(--white); }

.bg-1 { background: linear-gradient(135deg, #1a3a6b 0%, #2460a7 100%); }
.bg-2 { background: linear-gradient(135deg, #001f45 0%, #0a4a8c 100%); }
.bg-3 { background: linear-gradient(135deg, #0d2a4a 0%, #1a5f8c 100%); }
.bg-4 { background: linear-gradient(135deg, #1a2a6b 0%, #2444a7 100%); }
.bg-5 { background: linear-gradient(135deg, #0a1f45 0%, #103a7a 100%); }
.bg-6 { background: linear-gradient(135deg, #062040 0%, #0d3870 100%); }
</style>
</head>
<body>

<div class="top-bar">
  <a href="{{ route('login') }}">Portal Login</a>
  <a href="#">Careers</a>
  <a href="#">Media</a>
</div>

<nav>
  <a class="logo" href="{{ route('home') }}">
    <img src="{{ asset('images/iem-yes-logo.png') }}" alt="IEM Young Engineers Section" class="nav-logo-img"/>
  </a>
  <ul class="nav-links">

    <li>
      <a href="#">About Us <span class="nav-arrow"></span></a>
      <div class="mega-menu">
        <div class="mega-col">
          <h4>Who We Are</h4>
          <ul>
            <li><a href="{{ route('who-we-are') }}#vision-mission">Mission &amp; Vision</a></li>
            <li><a href="{{ route('who-we-are') }}#values">Values</a></li>
            <li><a href="{{ route('who-we-are') }}#where-we-are">Where We Are</a></li>
            <li><a href="{{ route('milestone') }}">Milestones</a></li>
          </ul>
        </div>
        <div class="mega-col">
          <h4>Leadership</h4>
          <ul>
            <li><a href="#">YES HQ Office Bearers</a></li>
            <li><a href="#">YES State Branches</a></li>
            <li><a href="#">YES Klang Valley Board</a></li>
            <li><a href="#">YES Non-Klang Valley Board</a></li>
          </ul>
        </div>
      </div>
    </li>

    <li class="active">
      <a href="#">Events <span class="nav-arrow"></span></a>
      <div class="mega-menu">
        <div class="mega-col">
          <h4>General Events</h4>
          <ul>
            <li><a href="{{ route('official-board-events') }}" class="active-link">Official Board Events</a></li>
            <li><a href="{{ route('student-section-events') }}">Student Section Events</a></li>
            <li><a href="{{ route('sustainability-events') }}">Sustainability Events</a></li>
          </ul>
        </div>
        <div class="mega-col">
          <h4>Flagship Events</h4>
          <ul>
            <li><a href="{{ route('natsum') }}">NATSUM</a></li>
            <li><a href="{{ route('cafeo') }}">CAFEO</a></li>
          </ul>
        </div>
      </div>
    </li>

    <li>
      <a href="#">Awards <span class="nav-arrow"></span></a>
      <div class="mega-menu">
        <div class="mega-col">
          <h4>Recognition</h4>
          <ul>
            <li><a href="#">Young Engineer Award</a></li>
            <li><a href="#">YAFEO Engineer Award</a></li>
            <li><a href="#">Best Student Branch</a></li>
            <li><a href="#">Best Branch Award</a></li>
          </ul>
        </div>
        <div class="mega-col">
          <h4>Nominate</h4>
          <ul>
            <li><a href="#">Nomination Guidelines</a></li>
            <li><a href="#">Past Recipients</a></li>
            <li><a href="#">Apply Now</a></li>
          </ul>
        </div>
      </div>
    </li>

    <li>
      <a href="#">Sustainability <span class="nav-arrow"></span></a>
      <div class="mega-menu single-col">
        <div class="mega-col">
          <h4>Our Commitments</h4>
          <ul>
            <li><a href="{{ route('sustainability') }}#initiative">Sustainability Initiative</a></li>
            <li><a href="{{ route('sustainability') }}#pledge">Sustainability Pledge</a></li>
            <li><a href="{{ route('sustainability') }}#declaration">Sustainability Declaration</a></li>
          </ul>
        </div>
      </div>
    </li>

    <li>
      <a href="{{ route('home') }}#footer">Contact Us</a>
    </li>

  </ul>
</nav>

<div class="page-hero">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a><span>›</span>
    <a href="#">Events</a><span>›</span>
    <span class="current">Official Board Events</span>
  </div>
  <div class="hero-inner">
    <div class="hero-left">
      <h1>YES <em>HQ</em> Events</h1>
      <p>Professionally curated events organised by the YES National Board — covering leadership forums, industry summits, annual general meetings, and strategic retreats for members nationwide.</p>
    </div>
    <div class="hero-stat">
      <div class="big">{{ $eventsThisYear ?? $events->count() }}</div>
      <div class="lbl">Events This Year</div>
    </div>
  </div>
</div>

@php $allCategories = $events->pluck('category')->unique()->filter()->sort()->values(); @endphp
<div class="filter-bar">
  <div class="filter-tabs">
    <button class="filter-tab active" onclick="filterTimeline('present', this)">Present</button>
    <button class="filter-tab" onclick="filterTimeline('past', this)">Past</button>
  </div>
  <div class="filter-right">
    @if($allCategories->isNotEmpty())
    <select class="sort-select" onchange="filterCategory(this.value)">
      <option value="">All Categories</option>
      @foreach($allCategories as $cat)
        <option value="{{ strtolower(str_replace([' ','/'], '-', $cat)) }}">{{ $cat }}</option>
      @endforeach
    </select>
    @endif
    <div class="search-box">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <input type="text" id="searchInput" placeholder="Search events..." oninput="searchEvents(this.value)"/>
    </div>
    <select class="sort-select" onchange="sortEvents(this.value)">
      <option value="date-asc">Date: Soonest First</option>
      <option value="date-desc">Date: Latest First</option>
      <option value="name-asc">Name: A–Z</option>
    </select>
  </div>
</div>

<div class="events-body">
  <div class="events-grid" id="eventsGrid">

    @forelse ($events as $event)
    @php
      $featured    = $loop->first;
      $statusKey   = $event->effective_status === 'past' ? 'closed' : $event->effective_status;
      $statusLabel = match($event->effective_status) { 'open'=>'Open','upcoming'=>'Upcoming','past'=>'Past', default=>ucfirst($event->effective_status) };
      $bgClass     = 'bg-' . (($loop->index % 6) + 1);
      $catSlug     = strtolower(str_replace([' ','/'], '-', $event->category ?? ''));
      $dateRange   = $event->end_date && $event->end_date->ne($event->start_date)
                       ? $event->start_date?->format('j') . '–' . $event->end_date?->format('j M Y')
                       : $event->start_date?->format('j M Y');
      $descLimit   = $featured ? 320 : 120;
    @endphp
    <div class="event-card {{ $featured ? 'featured' : '' }} reveal {{ $loop->index > 0 ? 'reveal-delay-' . min($loop->index, 6) : '' }}"
         data-status="{{ $statusKey }}"
         data-name="{{ strtolower($event->name) }}"
         data-date="{{ $event->start_date?->format('Y-m-d') }}"
         data-category="{{ $catSlug }}">

      {{-- Image / Poster --}}
      <div class="card-img">
        <div class="card-img-inner {{ $bgClass }}"
             @if($event->poster_src) style="background-image:url('{{ $event->poster_src }}')" @endif></div>
        <div class="card-badge">{{ $event->category ?? 'Official' }}</div>
        <div class="card-status status-{{ $statusKey }}">{{ $statusLabel }}</div>
      </div>

      {{-- Body --}}
      <div class="card-body">

        {{-- Date · Time · Branch --}}
        <div class="card-meta">
          <div class="card-meta-row">
            <span class="card-date">
              {{ $dateRange }}
              @if($event->start_time) · {{ $event->start_time }}@endif
            </span>
            @if($event->branch_name && $event->branch_name !== 'National')
              <span class="card-branch">{{ $event->branch_name }}</span>
            @endif
          </div>
          @if($event->location)
          <div class="card-meta-row">
            <span class="card-location">
              <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              {{ $event->location }}
            </span>
          </div>
          @endif
        </div>

        <h3>{{ $event->name }}</h3>

        @if($event->description)
          <p class="card-desc">{{ Str::limit($event->description, $descLimit) }}</p>
        @endif

        {{-- Tags --}}
        @if($event->tags && count($event->tags))
          <div class="card-tags">
            @foreach($event->tags as $tag)
              <span class="card-tag">{{ $tag }}</span>
            @endforeach
          </div>
        @endif

        {{-- Organiser + Phone --}}
        @if($event->organiser)
          <div class="card-contact">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <strong>{{ $event->organiser }}</strong>
            @if($event->organiser_phone)
              <span class="sep">·</span>
              {{ $event->organiser_phone }}
            @endif
          </div>
        @endif

        {{-- Footer --}}
        <div class="card-footer">
          @if($event->effective_status === 'past')
            <span class="card-seats">Event <strong>Concluded</strong></span>
          @elseif($event->effective_status === 'upcoming')
            <span class="card-seats">Registration <strong>Opens Soon</strong></span>
          @else
            <span class="card-seats">Registration <strong>Open</strong></span>
          @endif
        </div>

      </div>
    </div>
    @empty
    <div style="grid-column:span 3;text-align:center;padding:80px 20px">
      <svg viewBox="0 0 24 24" style="width:52px;height:52px;stroke:var(--light-grey);fill:none;stroke-width:1.5;margin-bottom:20px"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      <h3 style="font-size:20px;font-weight:700;color:var(--navy);margin-bottom:8px">No events published yet</h3>
      <p style="font-size:14px;color:var(--grey)">Check back soon for upcoming YES HQ events.</p>
    </div>
    @endforelse

    <div class="no-results" id="noResults" style="display:none;">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <h3>No events found</h3>
      <p>Try adjusting your search or filter criteria.</p>
    </div>

  </div>

  <div class="pagination" id="pagination">
    <a href="#" class="page-btn arrow">‹</a>
    <a href="#" class="page-btn active">1</a>
    <a href="#" class="page-btn">2</a>
    <a href="#" class="page-btn">3</a>
    <span class="page-info">Showing 1–6 of 12 events</span>
    <a href="#" class="page-btn arrow">›</a>
  </div>
</div>

<footer>
  <div class="footer-mini">
    <div>
      <a href="{{ route('home') }}" style="display:inline-block;margin-bottom:14px;">
        <img src="{{ asset('images/iem-yes-logo.png') }}" alt="IEM Young Engineers Section" style="height:44px;width:auto;display:block;"/>
      </a>
      <p>Young Engineer Section (YES) — the youth arm of the Institution of Engineers Malaysia (IEM), empowering the next generation of engineering professionals since 1987.</p>
    </div>
    <div>
      <h4>Events</h4>
      <ul>
        <li><a href="{{ route('official-board-events') }}">Official Board Events</a></li>
        <li><a href="{{ route('student-section-events') }}">Student Section Events</a></li>
        <li><a href="{{ route('sustainability-events') }}">Sustainability Events</a></li>
        <li><a href="{{ route('natsum') }}">NATSUM</a></li>
        <li><a href="{{ route('cafeo') }}">CAFEO</a></li>
      </ul>
    </div>
    <div>
      <h4>Contact</h4>
      <ul>
        <li><a href="#">+603 8890 1234</a></li>
        <li><a href="#">secretariat@yes-iem.org.my</a></li>
        <li><a href="#">Putrajaya, Malaysia</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© 2025 YES – Young Engineer Section, IEM Malaysia. All rights reserved.</span>
    <div><a href="#">Privacy Policy</a><a href="#">Terms of Use</a></div>
  </div>
</footer>

<a href="#" class="back-top" id="backTop">↑</a>

<script>
const allCards = () => Array.from(document.querySelectorAll('.event-card[data-status]'));
let activeTimeline = 'present', activeCategory = '', searchQuery = '';

function filterTimeline(tl, btn) {
  activeTimeline = tl;
  document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  applyFilters();
}
function filterCategory(cat) { activeCategory = cat; applyFilters(); }
function searchEvents(val) { searchQuery = val.toLowerCase(); applyFilters(); }
function sortEvents(val) {
  const grid = document.getElementById('eventsGrid');
  const cards = allCards();
  cards.sort((a, b) => {
    if (val === 'date-asc') return new Date(a.dataset.date) - new Date(b.dataset.date);
    if (val === 'date-desc') return new Date(b.dataset.date) - new Date(a.dataset.date);
    if (val === 'name-asc') return a.dataset.name.localeCompare(b.dataset.name);
  });
  cards.forEach(c => grid.appendChild(c));
}
function applyFilters() {
  let visible = 0;
  allCards().forEach(card => {
    const isPast = card.dataset.status === 'closed';
    const ok = ((activeTimeline === 'present' && !isPast) || (activeTimeline === 'past' && isPast))
            && (!activeCategory || card.dataset.category === activeCategory)
            && (!searchQuery   || card.dataset.name.includes(searchQuery));
    card.style.display = ok ? '' : 'none';
    if (ok) visible++;
  });
  document.getElementById('noResults').style.display = visible === 0 ? 'flex' : 'none';
  const f = document.querySelector('.event-card.featured');
  if (f) f.style.gridColumn = f.style.display !== 'none' ? 'span 3' : '';
}

applyFilters();

const obs = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.08 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
window.addEventListener('scroll', () => {
  document.getElementById('backTop').classList.toggle('visible', window.scrollY > 300);
});
</script>
</body>
</html>