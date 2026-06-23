@extends('public.layouts.app')

@php
  $slug      = strtolower($flagshipEvent->short_name);
  $label     = strtoupper($flagshipEvent->short_name);
  $allEditions = $allEditions ?? collect();
  $pastEditions = $allEditions->where('status', 'past')->values();
  $statusColors = ['planning'=>'#f59e0b','upcoming'=>'#3b82f6','open'=>'#10b981','past'=>'#9ca3af'];
@endphp

@section('title', $label . ' ' . $flagshipEvent->year . ' — ' . $flagshipEvent->full_name . ' | YES IEM')

@push('styles')
<style>
/* ── HERO ── */
.fh-hero { background: var(--navy-dark); position: relative; overflow: hidden; padding: 0; }
.fh-hero::before { content:''; position:absolute; inset:0; background:linear-gradient(135deg,#001228 0%,#002855 60%,#0a3a6b 100%); }
.fh-hero::after  { content:''; position:absolute; bottom:0; left:0; right:0; height:4px; background:linear-gradient(90deg,transparent 0%,var(--gold) 40%,transparent 100%); }
.fh-watermark { position:absolute; right:-20px; top:50%; transform:translateY(-50%); font-family:'Playfair Display',serif; font-size:clamp(160px,22vw,280px); font-weight:900; color:rgba(255,255,255,0.035); letter-spacing:-10px; line-height:1; pointer-events:none; user-select:none; white-space:nowrap; }
.fh-hero-inner { position:relative; z-index:2; padding:72px 60px 64px; max-width:900px; }

.fh-pills { display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-bottom:28px; }
.fh-pill { display:inline-flex; align-items:center; gap:7px; background:rgba(200,168,75,0.12); border:1px solid rgba(200,168,75,0.3); padding:5px 14px; font-size:10px; font-weight:700; letter-spacing:2.5px; text-transform:uppercase; color:var(--gold); }
.fh-status-pill { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; font-size:9px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.12); }
.fh-status-dot { width:7px; height:7px; border-radius:50%; display:inline-block; flex-shrink:0; }

.fh-title { font-family:'Playfair Display',serif; font-size:clamp(52px,8vw,96px); font-weight:900; color:var(--white); line-height:0.9; margin-bottom:12px; letter-spacing:-2px; }
.fh-title .accent { color:var(--gold); }
.fh-full-name { font-size:16px; color:rgba(255,255,255,0.45); letter-spacing:2.5px; text-transform:uppercase; margin-bottom:16px; }
.fh-theme { font-size:15px; font-weight:600; color:var(--gold); opacity:.9; font-style:italic; margin-bottom:20px; letter-spacing:.5px; }
.fh-desc { font-size:17px; color:rgba(255,255,255,0.72); line-height:1.85; max-width:600px; margin-bottom:36px; }

.fh-meta { display:flex; flex-wrap:wrap; gap:22px; margin-bottom:36px; }
.fh-meta-item { display:flex; align-items:center; gap:8px; }
.fh-meta-item svg { width:14px; height:14px; stroke:var(--gold); fill:none; stroke-width:2; flex-shrink:0; }
.fh-meta-item span { font-size:13px; color:rgba(255,255,255,0.65); }

.btn-gold { display:inline-flex; align-items:center; gap:8px; background:var(--gold); color:var(--navy-dark); font-family:'DM Sans',sans-serif; font-size:12px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; padding:13px 28px; text-decoration:none; transition:all .2s; flex-shrink:0; }
.btn-gold:hover { background:var(--gold-light); }

/* ── STATS STRIP ── */
.fh-stats { background:rgba(0,0,0,0.3); border-top:1px solid rgba(255,255,255,0.08); position:relative; z-index:2; }
.fh-stats-inner { padding:24px 60px; display:flex; gap:0; align-items:stretch; }
.fh-stat { padding:0 40px 0 0; border-right:1px solid rgba(255,255,255,0.1); margin-right:40px; }
.fh-stat:last-child { border-right:none; }
.fh-stat-num { font-family:'Playfair Display',serif; font-size:32px; font-weight:900; color:var(--gold); line-height:1; }
.fh-stat-lbl { font-size:10px; color:rgba(255,255,255,0.4); letter-spacing:2px; text-transform:uppercase; margin-top:4px; }

/* ── YEAR NAV ── */
.year-nav { background:#0a1e3d; border-bottom:1px solid rgba(255,255,255,0.08); overflow-x:auto; display:flex; align-items:center; padding:0 60px; }
.year-tab { display:inline-flex; align-items:center; gap:7px; padding:14px 18px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:rgba(255,255,255,0.38); text-decoration:none; border-bottom:3px solid transparent; white-space:nowrap; transition:all .2s; flex-shrink:0; }
.year-tab:hover { color:rgba(255,255,255,0.75); }
.year-tab.active { color:var(--gold); border-bottom-color:var(--gold); }
.year-tab-badge { font-size:8px; padding:1px 5px; border-radius:2px; font-weight:700; letter-spacing:.5px; }
.ytb-open { background:#10b981; color:#fff; }
.ytb-upcoming { background:#3b82f6; color:#fff; }
.ytb-planning { background:#f59e0b; color:#fff; }

/* ── DIVIDER ── */
.gold-strip { height:4px; background:linear-gradient(90deg,var(--navy) 0%,var(--gold) 40%,transparent 100%); }

/* ── BLOG CONTENT ── */
.fh-blog { max-width:860px; margin:0 auto; padding:72px 60px; }
.blog-body { font-size:16px; line-height:1.95; color:#333; }
.blog-body h2 { font-family:'Playfair Display',serif; font-size:30px; font-weight:900; color:var(--navy); margin:52px 0 18px; line-height:1.2; }
.blog-body h2:first-child { margin-top:0; }
.blog-body h3 { font-size:20px; font-weight:700; color:var(--navy); margin:36px 0 12px; }
.blog-body p { margin-bottom:20px; }
.blog-body ul, .blog-body ol { margin:0 0 20px 26px; }
.blog-body li { margin-bottom:9px; }
.blog-body strong { color:var(--navy-dark); }
.blog-body a { color:var(--navy); text-decoration:underline; transition:color .2s; }
.blog-body a:hover { color:var(--gold); }
.blog-body blockquote { border-left:4px solid var(--gold); padding:16px 22px; margin:28px 0; background:#faf9f6; color:#555; font-style:italic; font-size:17px; }
.blog-body hr { border:none; border-top:1px solid #e8e8e4; margin:44px 0; }
.blog-body table { width:100%; border-collapse:collapse; margin-bottom:28px; font-size:14px; }
.blog-body th { background:var(--navy); color:var(--gold); padding:11px 16px; text-align:left; font-size:11px; letter-spacing:1px; text-transform:uppercase; }
.blog-body td { padding:11px 16px; border-bottom:1px solid #e8e8e4; }
.blog-body tr:last-child td { border-bottom:none; }
.blog-body img { max-width:100%; border-radius:3px; margin:10px 0; }

/* ── NO CONTENT PLACEHOLDER ── */
.fh-placeholder { padding:72px 60px; max-width:760px; margin:0 auto; text-align:center; }
.fh-placeholder-icon { font-size:48px; margin-bottom:20px; }
.fh-placeholder p { font-size:15px; color:var(--grey); line-height:1.8; }

/* ── PAST EDITIONS ── */
.past-editions { background:#f5f4f0; padding:80px 60px; }
.pe-eyebrow { font-size:10px; font-weight:700; letter-spacing:4px; text-transform:uppercase; color:var(--gold); margin-bottom:10px; }
.pe-heading { font-family:'Playfair Display',serif; font-size:clamp(32px,4vw,48px); font-weight:900; color:var(--navy); margin-bottom:6px; }
.pe-heading em { color:var(--gold); font-style:normal; }
.pe-rule { width:52px; height:3px; background:var(--gold); margin:16px 0 48px; }
.pe-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:1px; background:var(--light-grey, #e0ddd8); }
.pe-card { background:#fff; padding:32px 26px; text-decoration:none; display:flex; flex-direction:column; gap:6px; transition:all .25s; position:relative; overflow:hidden; }
.pe-card::before { content:''; position:absolute; bottom:0; left:0; right:0; height:3px; background:transparent; transition:background .2s; }
.pe-card:hover { background:#faf9f6; transform:translateY(-3px); box-shadow:0 12px 32px rgba(0,31,69,.1); z-index:1; }
.pe-card:hover::before { background:var(--gold); }
.pe-card.current-view { background:var(--navy-dark); }
.pe-card.current-view .pe-year { color:var(--gold); }
.pe-card.current-view .pe-name { color:#fff; }
.pe-card.current-view .pe-loc { color:rgba(255,255,255,0.5); }
.pe-card.current-view .pe-loc svg { stroke:rgba(255,255,255,0.4); }
.pe-card.current-view .pe-count { color:var(--gold); }
.pe-year { font-family:'Playfair Display',serif; font-size:44px; font-weight:900; color:var(--gold); line-height:1; }
.pe-name { font-size:13px; font-weight:700; color:var(--navy); margin-top:4px; }
.pe-loc { display:flex; align-items:center; gap:5px; font-size:11px; color:var(--grey); margin-top:6px; }
.pe-loc svg { width:11px; height:11px; stroke:var(--grey); fill:none; stroke-width:2; flex-shrink:0; }
.pe-count { font-size:12px; font-weight:700; color:var(--gold); margin-top:8px; }
</style>
@endpush

@section('content')

{{-- ════════════════ HERO ════════════════ --}}
<div class="fh-hero">
  <div class="fh-watermark">{{ $label }}</div>
  <div class="fh-hero-inner">

    {{-- Breadcrumb --}}
    <div class="breadcrumb" style="margin-bottom:28px">
      <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.4)">Home</a>
      <span style="color:rgba(255,255,255,0.2)">›</span>
      <a href="{{ route('official-board-events') }}" style="color:rgba(255,255,255,0.4)">Events</a>
      <span style="color:rgba(255,255,255,0.2)">›</span>
      <a href="{{ route('flagship.slug', $slug) }}" style="color:rgba(255,255,255,0.4)">{{ $label }}</a>
      <span style="color:rgba(255,255,255,0.2)">›</span>
      <span style="color:var(--gold)">{{ $flagshipEvent->year }}</span>
    </div>

    {{-- Pills --}}
    <div class="fh-pills">
      <div class="fh-pill">Flagship Event</div>
      <div class="fh-status-pill">
        <span class="fh-status-dot" style="background:{{ $statusColors[$flagshipEvent->status] ?? '#9ca3af' }}"></span>
        <span style="color:rgba(255,255,255,0.7)">{{ ucfirst($flagshipEvent->status) }}</span>
      </div>
    </div>

    {{-- Title --}}
    <h1 class="fh-title">
      {{ substr($label, 0, 3) }}<span class="accent">{{ substr($label, 3) }}</span>
      <span class="accent">{{ $flagshipEvent->year }}</span>
    </h1>
    <div class="fh-full-name">{{ $flagshipEvent->full_name }}</div>
    @if($flagshipEvent->theme)
      <div class="fh-theme">"{{ $flagshipEvent->theme }}"</div>
    @endif
    @if($flagshipEvent->description)
      <p class="fh-desc">{{ $flagshipEvent->description }}</p>
    @endif

    {{-- Meta row --}}
    <div class="fh-meta">
      @if($flagshipEvent->event_date)
      <div class="fh-meta-item">
        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <span>{{ $flagshipEvent->event_date }}</span>
      </div>
      @endif
      @if($flagshipEvent->location)
      <div class="fh-meta-item">
        <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        <span>{{ $flagshipEvent->location }}</span>
      </div>
      @endif
      @if($flagshipEvent->host)
      <div class="fh-meta-item">
        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <span>Hosted by {{ $flagshipEvent->host }}</span>
      </div>
      @endif
    </div>

    {{-- CTA --}}
    @if($flagshipEvent->registration_url && in_array($flagshipEvent->status, ['upcoming','open']))
    <a href="{{ $flagshipEvent->registration_url }}" target="_blank" rel="noopener" class="btn-gold">
      Register for {{ $label }} {{ $flagshipEvent->year }}
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </a>
    @endif
  </div>

  {{-- Stats strip --}}
  @if($flagshipEvent->expected_delegates || $allEditions->count() > 1)
  <div class="fh-stats">
    <div class="fh-stats-inner">
      @if($flagshipEvent->expected_delegates)
      <div class="fh-stat">
        <div class="fh-stat-num">{{ number_format($flagshipEvent->expected_delegates) }}</div>
        <div class="fh-stat-lbl">{{ $flagshipEvent->status === 'past' ? 'Participants' : 'Expected Delegates' }}</div>
      </div>
      @endif
      @if($allEditions->count() > 1)
      <div class="fh-stat">
        <div class="fh-stat-num">{{ $allEditions->count() }}</div>
        <div class="fh-stat-lbl">Editions</div>
      </div>
      @endif
      <div class="fh-stat">
        <div class="fh-stat-num">{{ $flagshipEvent->year }}</div>
        <div class="fh-stat-lbl">Edition Year</div>
      </div>
    </div>
  </div>
  @endif
</div>

{{-- ════════════════ YEAR NAV ════════════════ --}}
@if($allEditions->count() > 1)
<div class="year-nav">
  @foreach($allEditions as $ed)
  @php $isActive = $ed->id === $flagshipEvent->id; @endphp
  <a href="{{ route('flagship.slug', [$slug, $ed->year]) }}"
     class="year-tab{{ $isActive ? ' active' : '' }}">
    {{ $ed->year }}
    @if($ed->status !== 'past')
      <span class="year-tab-badge ytb-{{ $ed->status }}">{{ ucfirst($ed->status) }}</span>
    @endif
  </a>
  @endforeach
</div>
@endif

<div class="gold-strip"></div>

{{-- ════════════════ MAIN CONTENT ════════════════ --}}
@if($flagshipEvent->content)
<div class="fh-blog">
  <div class="blog-body">{!! $flagshipEvent->content !!}</div>
</div>
@else
<div class="fh-placeholder">
  <div class="fh-placeholder-icon">📋</div>
  <p>Full programme details for <strong>{{ $label }} {{ $flagshipEvent->year }}</strong> are being finalised.<br>Check back closer to the event date for the complete programme.</p>
  @if($flagshipEvent->registration_url && in_array($flagshipEvent->status, ['upcoming','open']))
    <a href="{{ $flagshipEvent->registration_url }}" target="_blank" rel="noopener" class="btn-gold" style="margin-top:28px;display:inline-flex">
      Register Now →
    </a>
  @endif
</div>
@endif

{{-- ════════════════ PAST EDITIONS ════════════════ --}}
@if($pastEditions->isNotEmpty())
<div class="past-editions">
  <div class="pe-eyebrow">Our History</div>
  <h2 class="pe-heading">Past <em>Editions</em></h2>
  <div class="pe-rule"></div>
  <div class="pe-grid">
    @foreach($pastEditions as $ed)
    <a href="{{ route('flagship.slug', [$slug, $ed->year]) }}"
       class="pe-card{{ $ed->id === $flagshipEvent->id ? ' current-view' : '' }}">
      <div class="pe-year">{{ $ed->year }}</div>
      <div class="pe-name">{{ $ed->short_name }} {{ $ed->year }}</div>
      @if($ed->location)
      <div class="pe-loc">
        <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        {{ $ed->location }}
      </div>
      @endif
      @if($ed->expected_delegates)
      <div class="pe-count">{{ number_format($ed->expected_delegates) }} participants</div>
      @endif
    </a>
    @endforeach
  </div>
</div>
@endif

@endsection
