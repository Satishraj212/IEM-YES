@extends('public.layouts.app')

@php
  $ev           = $flagshipEvent;
  $allEditions  = $allEditions ?? collect();
  $pastEditions = $allEditions->where('status','past')->sortByDesc('year')->values();
  $isActive     = in_array($ev->status, ['open','upcoming']);
  $founding     = \App\Models\FlagshipEvent::FOUNDING_YEAR['NATSUM'] ?? 1995;
  $editionOrd   = $ev->edition_ordinal;                              // e.g. "30th"
  // Distinguishing per-edition figures (admin-set; sensible fallbacks)
  $participants     = $ev->stat('participants', $ev->expected_delegates ? number_format($ev->expected_delegates) : null);
  $universities     = $ev->stat('universities');
  $industryPartners = $ev->stat('industry_partners');
  // Split the acronym into two stacked halves for the hero title (NAT / SUM)
  $label     = strtoupper($ev->short_name);
  $splitAt   = (int) ceil(strlen($label) / 2);
  $namePart1 = substr($label, 0, $splitAt);
  $namePart2 = substr($label, $splitAt);
@endphp

@section('title', 'NATSUM ' . $ev->year . ' — ' . $ev->full_name . ' | YES IEM Malaysia')

@push('styles')
<style>
/* ── Year nav ── */
.year-nav { background:#0a1e3d; border-bottom:1px solid rgba(255,255,255,.08); overflow-x:auto; display:flex; align-items:center; padding:0 60px; }
.year-tab { display:inline-flex; align-items:center; gap:7px; padding:14px 18px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:rgba(255,255,255,.38); text-decoration:none; border-bottom:3px solid transparent; white-space:nowrap; transition:all .2s; flex-shrink:0; }
.year-tab:hover { color:rgba(255,255,255,.75); }
.year-tab.active { color:var(--gold); border-bottom-color:var(--gold); }
.ytb { font-size:8px; padding:1px 5px; border-radius:2px; font-weight:700; }
.ytb-open{background:#10b981;color:#fff} .ytb-upcoming{background:#3b82f6;color:#fff} .ytb-planning{background:#f59e0b;color:#fff}

/* ── HERO ── */
.natsum-hero { background:var(--navy-dark); min-height:90vh; display:flex; align-items:center; position:relative; overflow:hidden; }
.hero-bg { position:absolute; inset:0; background:linear-gradient(145deg,#001228 0%,#002855 50%,#001a3d 100%); }
.hero-circuit { position:absolute; inset:0; background-image:radial-gradient(rgba(200,168,75,.06) 1px,transparent 1px); background-size:40px 40px; }
.hero-glow-tl { position:absolute; top:-200px; left:-100px; width:600px; height:600px; border-radius:50%; background:radial-gradient(circle,rgba(200,168,75,.07) 0%,transparent 60%); }
.hero-glow-br { position:absolute; bottom:-100px; right:-100px; width:500px; height:500px; border-radius:50%; background:radial-gradient(circle,rgba(0,51,102,.4) 0%,transparent 60%); }
.hero-diagonal { position:absolute; top:0; right:0; width:50%; height:100%; clip-path:polygon(20% 0%,100% 0%,100% 100%,0% 100%); background:rgba(200,168,75,.03); }
.ns-hero-inner { display:block; position:relative; z-index:2; padding:96px 60px 80px; width:100%; max-width:760px; }
.hero-eyebrow { display:inline-flex; align-items:center; gap:10px; border:1px solid rgba(200,168,75,.35); padding:7px 16px; margin-bottom:32px; }
.hero-eyebrow .dot { width:6px; height:6px; border-radius:50%; background:var(--gold); flex-shrink:0; }
.eyebrow-text { font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:var(--gold); }
.hero-title { font-family:'Playfair Display',serif; font-weight:900; line-height:.82; letter-spacing:-3px; margin-bottom:20px; }
.hero-title .t1 { display:block; font-size:clamp(64px,10vw,140px); color:var(--white); }
.hero-title .t2 { display:block; font-size:clamp(64px,10vw,140px); color:var(--gold); }
.hero-subtitle { font-size:14px; color:rgba(255,255,255,.4); letter-spacing:4px; text-transform:uppercase; margin-bottom:22px; }
.hero-theme { font-size:16px; font-weight:600; color:rgba(255,255,255,.7); font-style:italic; margin-bottom:22px; max-width:520px; }
.hero-desc-p { font-size:16px; color:rgba(255,255,255,.62); line-height:1.85; max-width:480px; margin-bottom:38px; }
.hero-cta-row { display:flex; gap:14px; flex-wrap:wrap; }
.hero-corner { position:absolute; right:60px; bottom:52px; z-index:2; text-align:right; }
.hc-date { font-family:'Playfair Display',serif; font-size:26px; font-weight:900; color:var(--gold); line-height:1; }
.hc-loc { display:flex; align-items:center; justify-content:flex-end; gap:6px; font-size:13px; color:rgba(255,255,255,.6); margin-top:8px; }
.hc-loc svg { width:13px; height:13px; stroke:var(--gold); fill:none; stroke-width:2; flex-shrink:0; }
@media (max-width:900px){ .hero-corner { position:static; text-align:left; margin-top:32px; } .hc-loc { justify-content:flex-start; } }
.btn-gold { background:var(--gold); color:var(--navy-dark); padding:14px 32px; font-weight:700; font-size:13px; letter-spacing:1px; text-transform:uppercase; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:all .2s; border:2px solid var(--gold); }
.btn-gold:hover { background:transparent; color:var(--gold); }
.btn-outline-white { border:2px solid rgba(255,255,255,.25); color:rgba(255,255,255,.8); padding:14px 32px; font-weight:600; font-size:13px; letter-spacing:1px; text-transform:uppercase; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:all .2s; }
.btn-outline-white:hover { border-color:var(--gold); color:var(--gold); }

/* stats bar */
.hero-stats { background:rgba(0,0,0,.25); border-top:1px solid rgba(255,255,255,.08); position:relative; z-index:2; }
.hero-stats-inner { padding:24px 60px; display:flex; gap:0; }
.h-stat { padding:0 40px 0 0; border-right:1px solid rgba(255,255,255,.1); margin-right:40px; }
.h-stat:last-child { border-right:none; }
.h-stat-num { font-family:'Playfair Display',serif; font-size:36px; font-weight:900; color:var(--gold); line-height:1; }
.h-stat-lbl { font-size:10px; color:rgba(255,255,255,.38); letter-spacing:2px; text-transform:uppercase; margin-top:4px; }

/* ── ANCHOR NAV ── */
.anchor-nav { background:var(--navy); display:flex; gap:0; padding:0 60px; position:sticky; top:72px; z-index:900; overflow-x:auto; }
.anchor-btn { padding:18px 26px; font-size:12px; font-weight:600; letter-spacing:1px; text-transform:uppercase; color:rgba(255,255,255,.5); text-decoration:none; border-bottom:3px solid transparent; transition:all .2s; white-space:nowrap; }
.anchor-btn:hover { color:var(--white); }
.anchor-btn.active { color:var(--gold); border-bottom-color:var(--gold); }

/* ── SECTIONS ── */
.section { padding:88px 60px; }
.section.alt { background:var(--offwhite, #f5f4f0); }
.section.dark { background:var(--navy-dark); }
.section-label { font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:var(--gold); margin-bottom:10px; }
.section-title { font-family:'Playfair Display',serif; font-size:clamp(28px,3vw,44px); color:var(--navy); font-weight:900; line-height:1.15; }
.section-title em { color:var(--gold); font-style:normal; }
.section-title.light { color:var(--white); }
.divider { width:60px; height:3px; background:var(--gold); margin:18px 0 36px; }

/* ── ABOUT NATSUM ── */
.about-grid { display:grid; grid-template-columns:1fr 1fr; gap:72px; align-items:center; }
.about-visual { background:var(--navy); height:440px; display:flex; flex-direction:column; align-items:center; justify-content:center; position:relative; overflow:hidden; }
.about-visual::before { content:'NATSUM'; font-family:'Playfair Display',serif; font-size:70px; font-weight:900; color:rgba(255,255,255,.04); position:absolute; letter-spacing:4px; }
.natsum-badge { position:absolute; bottom:-18px; right:-18px; background:var(--gold); padding:22px 28px; text-align:center; }
.natsum-badge .b-year { font-family:'Playfair Display',serif; font-size:40px; font-weight:900; color:var(--navy-dark); line-height:1; }
.natsum-badge .b-lbl { font-size:10px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--navy-dark); opacity:.65; }
.about-text p { font-size:15px; color:#444; line-height:1.85; margin-bottom:16px; }
.about-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:3px; margin-top:32px; }
.ab-stat { background:var(--navy); padding:22px 18px; text-align:center; }
.ab-stat .num { font-family:'Playfair Display',serif; font-size:30px; font-weight:900; color:var(--gold); display:block; line-height:1; }
.ab-stat .lbl { font-size:10px; color:rgba(255,255,255,.5); letter-spacing:1.5px; text-transform:uppercase; margin-top:5px; display:block; }

/* ── ACTIVITIES ── */
.act-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:3px; margin-top:48px; }
.act-card { background:var(--white); border:1px solid var(--light-grey, #e8e8e4); padding:40px 36px; transition:all .3s; }
.act-card:hover { background:var(--navy); border-color:var(--navy); transform:translateY(-4px); box-shadow:0 20px 50px rgba(0,31,69,.15); }
.act-icon { width:56px; height:56px; border:2px solid var(--light-grey, #e8e8e4); display:flex; align-items:center; justify-content:center; margin-bottom:20px; transition:all .3s; }
.act-card:hover .act-icon { border-color:rgba(200,168,75,.3); background:rgba(200,168,75,.1); }
.act-icon svg { width:26px; height:26px; stroke:var(--navy); fill:none; stroke-width:1.5; transition:stroke .3s; }
.act-card:hover .act-icon svg { stroke:var(--gold); }
.act-tag { display:inline-block; font-size:9px; font-weight:700; letter-spacing:2px; text-transform:uppercase; padding:3px 10px; background:var(--offwhite, #f5f4f0); color:var(--navy); margin-bottom:12px; transition:all .3s; }
.act-card:hover .act-tag { background:rgba(200,168,75,.15); color:var(--gold); }
.act-card h3 { font-size:20px; font-weight:700; color:var(--navy); margin-bottom:10px; transition:color .3s; }
.act-card:hover h3 { color:var(--white); }
.act-card p { font-size:13.5px; color:var(--grey, #6b7280); line-height:1.75; transition:color .3s; }
.act-card:hover p { color:rgba(255,255,255,.65); }

/* ── JOIN ── */
.join-steps { display:grid; grid-template-columns:repeat(4,1fr); gap:3px; margin-top:48px; }
.join-step-card { background:var(--white); border:1px solid var(--light-grey, #e8e8e4); padding:40px 28px; position:relative; overflow:hidden; transition:all .3s; }
.join-step-card::before { content:attr(data-num); position:absolute; top:-10px; right:16px; font-family:'Playfair Display',serif; font-size:80px; font-weight:900; color:rgba(0,51,102,.05); line-height:1; pointer-events:none; }
.join-step-card:hover { background:var(--navy); border-color:var(--navy); transform:translateY(-4px); }
.join-step-card:hover::before { color:rgba(255,255,255,.04); }
.step-num { width:36px; height:36px; background:var(--navy); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; color:var(--gold); margin-bottom:20px; transition:background .3s; }
.join-step-card:hover .step-num { background:var(--gold); color:var(--navy-dark); }
.join-step-card h3 { font-size:16px; font-weight:700; color:var(--navy); margin-bottom:10px; transition:color .3s; }
.join-step-card:hover h3 { color:var(--white); }
.join-step-card p { font-size:13px; color:var(--grey, #6b7280); line-height:1.7; transition:color .3s; }
.join-step-card:hover p { color:rgba(255,255,255,.65); }
.join-cta-band { background:var(--navy); padding:44px 52px; display:flex; align-items:center; justify-content:space-between; gap:32px; margin-top:3px; }
.join-cta-band h3 { font-family:'Playfair Display',serif; font-size:26px; font-weight:900; color:var(--white); }
.join-cta-band p { font-size:14px; color:rgba(255,255,255,.6); margin-top:6px; }

/* ── OPPORTUNITIES ── */
.opp-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:3px; margin-top:48px; }
.opp-card { padding:40px 30px; background:var(--white); border:1px solid var(--light-grey, #e8e8e4); transition:all .3s; }
.opp-card:hover { background:var(--navy); border-color:var(--navy); transform:translateY(-4px); }
.opp-num-lbl { font-family:'Playfair Display',serif; font-size:48px; font-weight:900; color:var(--light-grey, #e8e8e4); line-height:1; margin-bottom:16px; transition:color .3s; }
.opp-card:hover .opp-num-lbl { color:rgba(200,168,75,.2); }
.opp-card h3 { font-size:18px; font-weight:700; color:var(--navy); margin-bottom:10px; transition:color .3s; }
.opp-card:hover h3 { color:var(--white); }
.opp-card p { font-size:13.5px; color:var(--grey, #6b7280); line-height:1.75; transition:color .3s; }
.opp-card:hover p { color:rgba(255,255,255,.65); }

/* ── PAST EDITIONS ── */
.pe-section { background:var(--offwhite, #f5f4f0); padding:88px 60px; }
.pe-eyebrow { font-size:10px; font-weight:700; letter-spacing:4px; text-transform:uppercase; color:var(--gold); margin-bottom:10px; }
.pe-heading { font-family:'Playfair Display',serif; font-size:clamp(32px,4vw,48px); font-weight:900; color:var(--navy); }
.pe-heading em { color:var(--gold); font-style:normal; }
.pe-rule { width:52px; height:3px; background:var(--gold); margin:16px 0 48px; }
.pe-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(190px,1fr)); gap:3px; background:var(--light-grey, #e8e8e4); }
.pe-card { background:var(--white); padding:36px 28px; text-decoration:none; display:flex; flex-direction:column; gap:6px; transition:all .25s; position:relative; }
.pe-card::after { content:''; position:absolute; bottom:0; left:0; right:0; height:3px; background:transparent; transition:background .2s; }
.pe-card:hover { background:#faf9f6; transform:translateY(-3px); box-shadow:0 12px 32px rgba(0,31,69,.1); z-index:1; }
.pe-card:hover::after { background:var(--gold); }
.pe-card.current-view { background:var(--navy-dark); }
.pe-card.current-view .pe-year-num { color:var(--gold); }
.pe-card.current-view .pe-card-name { color:var(--white); }
.pe-card.current-view .pe-card-loc { color:rgba(255,255,255,.5); }
.pe-card.current-view .pe-card-count { color:var(--gold); }
.pe-year-num { font-family:'Playfair Display',serif; font-size:44px; font-weight:900; color:var(--gold); line-height:1; }
.pe-card-name { font-size:13px; font-weight:700; color:var(--navy); margin-top:4px; }
.pe-card-loc { font-size:11px; color:var(--grey, #6b7280); margin-top:6px; display:flex; align-items:center; gap:4px; }
.pe-card-loc svg { width:11px; height:11px; stroke:var(--grey); fill:none; stroke-width:2; }
.pe-card-count { font-size:12px; font-weight:700; color:var(--gold); margin-top:8px; }

/* ── FAQ ── */
.faq-list { max-width:820px; margin:48px auto 0; }
.faq-item { border-bottom:1px solid var(--light-grey, #e8e8e4); }
.faq-question { width:100%; padding:22px 0; display:flex; align-items:center; justify-content:space-between; background:none; border:none; cursor:pointer; text-align:left; font-family:'DM Sans',sans-serif; }
.faq-question span { font-size:16px; font-weight:600; color:var(--navy); }
.faq-chevron { width:20px; height:20px; border:1.5px solid var(--gold); display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:transform .25s; color:var(--gold); font-size:14px; }
.faq-item.open .faq-chevron { transform:rotate(180deg); }
.faq-answer { max-height:0; overflow:hidden; transition:max-height .4s ease; }
.faq-answer p { font-size:14px; color:var(--grey, #6b7280); line-height:1.8; padding-bottom:20px; }

/* ── BLOG CONTENT (admin customizable) ── */
.admin-content { max-width:860px; margin:0 auto; padding:72px 60px; }
.admin-content h2 { font-family:'Playfair Display',serif; font-size:30px; font-weight:900; color:var(--navy); margin:52px 0 18px; }
.admin-content h2:first-child { margin-top:0; }
.admin-content h3 { font-size:20px; font-weight:700; color:var(--navy); margin:36px 0 12px; }
.admin-content p { font-size:16px; color:#333; line-height:1.9; margin-bottom:20px; }
.admin-content ul, .admin-content ol { margin:0 0 20px 26px; font-size:15px; color:#333; line-height:1.9; }
.admin-content li { margin-bottom:8px; }
.admin-content blockquote { border-left:4px solid var(--gold); padding:16px 22px; margin:28px 0; background:#faf9f6; font-style:italic; }
.admin-content table { width:100%; border-collapse:collapse; margin-bottom:28px; font-size:14px; }
.admin-content th { background:var(--navy); color:var(--gold); padding:11px 16px; text-align:left; font-size:11px; letter-spacing:1px; text-transform:uppercase; }
.admin-content td { padding:11px 16px; border-bottom:1px solid var(--light-grey, #e8e8e4); }

/* ── REVEAL ── */
.reveal { opacity:0; transform:translateY(24px); transition:opacity .7s ease,transform .7s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
.reveal-d1{transition-delay:.1s} .reveal-d2{transition-delay:.2s} .reveal-d3{transition-delay:.3s} .reveal-d4{transition-delay:.4s}

.back-top { position:fixed; bottom:32px; right:32px; width:46px; height:46px; background:var(--gold); color:var(--navy-dark); display:flex; align-items:center; justify-content:center; font-size:20px; cursor:pointer; opacity:0; transition:opacity .3s; z-index:999; text-decoration:none; font-weight:700; }
.back-top.visible { opacity:1; }
</style>
@endpush

@section('content')

{{-- ── YEAR SWITCHER ── --}}
@if($allEditions->count() > 1)
<div class="year-nav">
  @foreach($allEditions as $ed)
  <a href="{{ route('flagship.slug', [strtolower($ed->short_name), $ed->year]) }}"
     class="year-tab{{ $ed->id === $ev->id ? ' active' : '' }}">
    {{ $ed->year }}
    @if($ed->status !== 'past')<span class="ytb ytb-{{ $ed->status }}">{{ ucfirst($ed->status) }}</span>@endif
  </a>
  @endforeach
</div>
@endif

{{-- ══ HERO ══ --}}
<div class="natsum-hero">
  <div class="hero-bg"></div>
  <div class="hero-circuit"></div>
  <div class="hero-glow-tl"></div>
  <div class="hero-glow-br"></div>
  <div class="hero-diagonal"></div>
  <div class="ns-hero-inner">
    <div class="hero-eyebrow"><span class="dot"></span><span class="eyebrow-text">Flagship Event · Annual since {{ $founding }}</span></div>
    <div class="hero-title">
      <span class="t1">{{ $namePart1 }}</span>
      <span class="t2">{{ $namePart2 }}</span>
    </div>
    <div class="hero-subtitle">{{ $ev->full_name }}</div>
    @if($ev->theme)<div class="hero-theme">"{{ $ev->theme }}"</div>@endif
    <p class="hero-desc-p">{{ $ev->description ?: 'Malaysia\'s largest national student engineering summit — where the nation\'s top engineering undergraduates gather to present, compete, network, and represent Malaysia on the ASEAN stage at CAFEO.' }}</p>
    <div class="hero-cta-row">
      @if($ev->registration_url && $isActive)
        <a href="{{ $ev->registration_url }}" target="_blank" rel="noopener" class="btn-gold">Register for NATSUM {{ $ev->year }} →</a>
      @endif
      <a href="#about" class="btn-outline-white">Learn More</a>
    </div>
  </div>

  {{-- Date / location corner --}}
  @if($ev->event_date || $ev->location)
  <div class="hero-corner">
    @if($ev->event_date)<div class="hc-date">{{ $ev->event_date }}</div>@endif
    @if($ev->location)<div class="hc-loc"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>{{ $ev->location }}</div>@endif
  </div>
  @endif
</div>

{{-- ══ ANCHOR NAV ══ --}}
<nav class="anchor-nav" id="anchorNav">
  <a href="#about"    class="anchor-btn active">About NATSUM</a>
  <a href="#activities" class="anchor-btn">Programme</a>
  <a href="#join"     class="anchor-btn">How to Join</a>
  <a href="#opps"     class="anchor-btn">Opportunities</a>
  <a href="#editions" class="anchor-btn">Past Editions</a>
  <a href="#faq"      class="anchor-btn">FAQ</a>
</nav>

{{-- ══ ADMIN-CUSTOMIZABLE CONTENT ══ --}}
@if($ev->content)
<div class="admin-content">{!! $ev->content !!}</div>
@endif

{{-- ══ ABOUT ══ --}}
<section class="section" id="about">
  <div class="about-grid">
    <div class="about-text">
      <div class="section-label reveal">What is NATSUM?</div>
      <h2 class="section-title reveal">Malaysia's Largest <em>Student Engineering</em> Summit</h2>
      <div class="divider reveal"></div>
      <p class="reveal">NATSUM — the National Student Summit — is YES – IEM's flagship annual event for engineering and science undergraduates. First held in {{ $founding }}, it has grown into Malaysia's most prestigious student engineering platform, drawing thousands of participants from universities across the country.</p>
      <p class="reveal">Over three intensive days, students compete in technical challenges, attend industry-led workshops, network with engineering professionals, and gain direct exposure to Malaysia's leading engineering organisations — all in one immersive experience.</p>
      <div class="about-stats reveal">
        <div class="ab-stat"><span class="num">{{ $participants ?: '—' }}</span><span class="lbl">Participants</span></div>
        <div class="ab-stat"><span class="num">{{ $universities ?: '—' }}</span><span class="lbl">Universities</span></div>
        <div class="ab-stat"><span class="num">{{ $industryPartners ?: '—' }}</span><span class="lbl">Industry Partners</span></div>
      </div>
    </div>
    <div class="what-visual reveal" style="position:relative">
      <div class="about-visual">
        <div class="natsum-badge">
          <div class="b-year">{{ $editionOrd ?: $ev->year }}</div>
          <div class="b-lbl">Edition</div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ══ PROGRAMME ══ --}}
<section class="section alt" id="activities">
  <div class="section-label reveal">What to Expect</div>
  <h2 class="section-title reveal">Summit <em>Programme</em></h2>
  <div class="divider reveal"></div>
  <div class="act-grid">
    <div class="act-card reveal reveal-d1">
      <div class="act-icon"><svg viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div>
      <div class="act-tag">Core Event</div>
      <h3>Technical Paper Presentation</h3>
      <p>The centrepiece of NATSUM — student teams present original engineering research and solutions to a panel of industry judges. Top presenters are selected to represent Malaysia at CAFEO the following year.</p>
    </div>
    <div class="act-card reveal reveal-d2">
      <div class="act-icon"><svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
      <div class="act-tag">Competition</div>
      <h3>Engineering Case Competition</h3>
      <p>Teams tackle real-world engineering challenges set by industry sponsors. Competing groups pitch solutions under time pressure, developing problem-solving agility and professional communication skills.</p>
    </div>
    <div class="act-card reveal reveal-d1">
      <div class="act-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
      <div class="act-tag">Leadership</div>
      <h3>Young Engineers Forum</h3>
      <p>Keynotes, panel discussions, and workshops led by industry professionals, IEM Fellows, and international engineering leaders — providing career clarity and professional inspiration for engineering graduates.</p>
    </div>
    <div class="act-card reveal reveal-d2">
      <div class="act-icon"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
      <div class="act-tag">Networking</div>
      <h3>Technical Tours &amp; Networking</h3>
      <p>Curated visits to engineering infrastructure sites, industry facilities, and innovation hubs in the host city — followed by the NATSUM Gala Night to celebrate excellence in Malaysian student engineering.</p>
    </div>
  </div>
</section>

{{-- ══ HOW TO JOIN ══ --}}
<section class="section" id="join">
  <div class="section-label reveal">Participate</div>
  <h2 class="section-title reveal">How to <em>Join NATSUM</em> {{ $ev->year }}</h2>
  <div class="divider reveal"></div>
  <div class="join-steps">
    <div class="join-step-card reveal reveal-d1" data-num="01">
      <div class="step-num">01</div>
      <h3>Register Your University Team</h3>
      <p>Registration opens 3 months before NATSUM. Each university student branch can send multiple delegations. Register via the YES portal or contact your YES State Branch.</p>
    </div>
    <div class="join-step-card reveal reveal-d2" data-num="02">
      <div class="step-num">02</div>
      <h3>Prepare Your Technical Paper</h3>
      <p>Submit an abstract in your chosen technical track (Civil, Mechanical, Electrical, Chemical, Environmental, or Interdisciplinary). Papers must be original research by Malaysian engineering students.</p>
    </div>
    <div class="join-step-card reveal reveal-d3" data-num="03">
      <div class="step-num">03</div>
      <h3>Attend &amp; Present</h3>
      <p>Arrive at {{ $ev->location ?: 'the host university' }} for {{ $ev->event_date ?: 'the summit dates' }}. Present your paper, participate in workshops, and compete for the NATSUM Best Paper Award.</p>
    </div>
    <div class="join-step-card reveal reveal-d4" data-num="04">
      <div class="step-num">04</div>
      <h3>Get Selected for CAFEO</h3>
      <p>Top-ranked paper presenters are evaluated for Malaysia's CAFEO delegation. Selected students receive a YES travel grant to present at the ASEAN engineering conference the following year.</p>
    </div>
  </div>
  <div class="join-cta-band reveal">
    <div>
      <h3>NATSUM {{ $ev->year }}{{ $ev->event_date ? ' — '.$ev->event_date : '' }}</h3>
      <p>{{ $ev->location ? 'Hosted at '.$ev->location.'.' : 'Host university to be announced.' }} {{ $isActive ? 'Registration is now open.' : 'Details coming soon.' }}</p>
    </div>
    @if($ev->registration_url && $isActive)
      <a href="{{ $ev->registration_url }}" target="_blank" rel="noopener" class="btn-gold">Register Now →</a>
    @elseif(!$isActive)
      <a href="{{ route('flagship.slug', 'cafeo') }}" class="btn-gold">Learn About CAFEO →</a>
    @endif
  </div>
</section>

{{-- ══ OPPORTUNITIES ══ --}}
<section class="section alt" id="opps">
  <div class="section-label reveal">Why Attend</div>
  <h2 class="section-title reveal">Opportunities &amp; <em>Impact</em></h2>
  <div class="divider reveal"></div>
  <div class="opp-grid">
    <div class="opp-card reveal reveal-d1"><div class="opp-num-lbl">01</div><h3>CAFEO Selection</h3><p>NATSUM is the primary pathway to representing Malaysia at CAFEO — ASEAN's largest engineering conference. Top paper presenters receive a YES-funded CAFEO delegation spot.</p></div>
    <div class="opp-card reveal reveal-d2"><div class="opp-num-lbl">02</div><h3>IEM Student Recognition</h3><p>NATSUM Best Paper and Best Presenter awards are recognised by IEM as formal student engineering achievements. Awards are recorded in your IEM membership profile.</p></div>
    <div class="opp-card reveal reveal-d3"><div class="opp-num-lbl">03</div><h3>Industry Exposure</h3><p>Sponsors and industry partners actively scout NATSUM for internship and graduate placement candidates. The summit is a live recruitment platform for engineering talent across Malaysia.</p></div>
    <div class="opp-card reveal reveal-d1"><div class="opp-num-lbl">04</div><h3>National Network</h3><p>NATSUM delegates build lifelong peer networks spanning every university and engineering discipline in Malaysia — the foundation for a powerful professional alumni community.</p></div>
    <div class="opp-card reveal reveal-d2"><div class="opp-num-lbl">05</div><h3>Technical Publication</h3><p>Accepted papers are published in the NATSUM Proceedings, distributed to IEM branches nationwide. Selected papers are considered for nomination to the CAFEO Proceedings.</p></div>
    <div class="opp-card reveal reveal-d3"><div class="opp-num-lbl">06</div><h3>Leadership Development</h3><p>YES runs pre-NATSUM leadership bootcamps and post-event mentoring for top delegates. NATSUM alumni frequently go on to lead YES State Branches and IEM national committees.</p></div>
  </div>
</section>

{{-- ══ PAST EDITIONS (from DB) ══ --}}
@if($pastEditions->isNotEmpty())
<div class="pe-section" id="editions">
  <div class="pe-eyebrow">Our History</div>
  <h2 class="pe-heading">Past <em>Editions</em></h2>
  <div class="pe-rule"></div>
  <div class="pe-grid">
    @foreach($pastEditions as $ed)
    <a href="{{ route('flagship.slug', [strtolower($ed->short_name), $ed->year]) }}"
       class="pe-card{{ $ed->id === $ev->id ? ' current-view' : '' }}">
      <div class="pe-year-num">{{ $ed->year }}</div>
      <div class="pe-card-name">{{ $ed->short_name }} {{ $ed->year }}</div>
      @if($ed->location)
      <div class="pe-card-loc">
        <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        {{ $ed->location }}
      </div>
      @endif
      @if($ed->expected_delegates)
      <div class="pe-card-count">{{ number_format($ed->expected_delegates) }} participants</div>
      @endif
    </a>
    @endforeach
  </div>
</div>
@endif

{{-- ══ FAQ ══ --}}
<section class="section" id="faq">
  <div style="text-align:center">
    <div class="section-label reveal" style="display:inline-block">Questions</div>
    <h2 class="section-title reveal" style="text-align:center">Frequently Asked <em>Questions</em></h2>
    <div class="divider reveal" style="margin:18px auto 0"></div>
  </div>
  <div class="faq-list">
    @foreach([
      ['Who can attend NATSUM?', 'NATSUM is open to all engineering and applied science undergraduates from Malaysian universities. You do not need to submit a paper to attend — you can register as a general delegate and participate in all workshops, forums, and networking sessions.'],
      ['How do I submit a paper?', 'Paper submission opens alongside delegate registration, approximately 3 months before NATSUM. Submit your abstract through the YES registration portal. Papers are reviewed by IEM-appointed academic and industry judges.'],
      ['What engineering disciplines are eligible?', 'NATSUM accepts papers across all engineering disciplines: Civil & Structural, Mechanical, Electrical & Electronic, Chemical, Environmental, Geotechnical, Industrial, and interdisciplinary engineering topics.'],
      ['Is there a cost to attend?', 'YES – IEM subsidises NATSUM registration. A nominal registration fee covers accommodation at the host university, meals, and the Gala Night. Fees vary by year — check the YES portal for NATSUM '.$ev->year.' pricing.'],
      ['How are CAFEO delegates selected?', 'YES and IEM evaluate top-ranked NATSUM paper presenters on paper quality, ASEAN relevance, and presentation performance. Selected delegates receive an official YES travel grant covering CAFEO registration, flights, and accommodation.'],
    ] as [$q, $a])
    <div class="faq-item reveal">
      <button class="faq-question" onclick="toggleFaq(this)"><span>{{ $q }}</span><div class="faq-chevron">▼</div></button>
      <div class="faq-answer"><p>{{ $a }}</p></div>
    </div>
    @endforeach
  </div>
</section>

<a href="#" class="back-top" id="backTop">↑</a>

@endsection

@push('scripts')
<script>
function toggleFaq(btn) {
  const item = btn.parentElement;
  const answer = item.querySelector('.faq-answer');
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item.open').forEach(i => {
    i.classList.remove('open');
    i.querySelector('.faq-answer').style.maxHeight = '0';
  });
  if (!isOpen) { item.classList.add('open'); answer.style.maxHeight = answer.scrollHeight + 'px'; }
}

const anchorBtns = document.querySelectorAll('.anchor-btn');
const sectionIds = ['about','activities','join','opps','editions','faq'];
window.addEventListener('scroll', () => {
  let current = '';
  sectionIds.forEach(id => { const el = document.getElementById(id); if (el && window.scrollY >= el.offsetTop - 200) current = id; });
  anchorBtns.forEach(btn => btn.classList.toggle('active', btn.getAttribute('href') === '#' + current));
  document.getElementById('backTop')?.classList.toggle('visible', window.scrollY > 400);
});

document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const id = a.getAttribute('href').slice(1);
    const el = document.getElementById(id);
    if (el) { e.preventDefault(); el.scrollIntoView({ behavior: 'smooth' }); }
  });
});

const obs = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.08 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
</script>
@endpush
