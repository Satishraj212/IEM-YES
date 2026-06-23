@extends('public.layouts.app')

@php
  $ev           = $flagshipEvent;
  $allEditions  = $allEditions ?? collect();
  $pastEditions = $allEditions->where('status','past')->sortByDesc('year')->values();
  $isActive     = in_array($ev->status, ['open','upcoming']);
  $editionStr   = $ev->edition_ordinal;                          // e.g. "42nd"
  // Distinguishing per-edition figures (admin-set; sensible fallbacks)
  $nations   = $ev->stat('nations', '10');
  $delegates = $ev->stat('delegates', $ev->expected_delegates ? number_format($ev->expected_delegates).'+' : null);
  $hostCode  = strtoupper($ev->stat('host_code', ''));           // e.g. "MY"
  // Country code → flag emoji (regional indicator letters)
  $flagOf = function ($code) {
      $code = strtoupper(trim($code));
      if (strlen($code) !== 2) return '🌏';
      return mb_chr(0x1F1E6 + ord($code[0]) - 65) . mb_chr(0x1F1E6 + ord($code[1]) - 65);
  };
@endphp

@section('title', 'CAFEO ' . $ev->year . ' — ' . $ev->full_name . ' | YES IEM Malaysia')

@push('styles')
<style>
:root { --asean-teal:#0a5a6b; }

/* ── Year nav ── */
.year-nav { background:#0a1e3d; border-bottom:1px solid rgba(255,255,255,.08); overflow-x:auto; display:flex; align-items:center; padding:0 60px; }
.year-tab { display:inline-flex; align-items:center; gap:7px; padding:14px 18px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:rgba(255,255,255,.38); text-decoration:none; border-bottom:3px solid transparent; white-space:nowrap; transition:all .2s; flex-shrink:0; }
.year-tab:hover { color:rgba(255,255,255,.75); }
.year-tab.active { color:var(--gold); border-bottom-color:var(--gold); }
.ytb { font-size:8px; padding:1px 5px; border-radius:2px; font-weight:700; }
.ytb-open{background:#10b981;color:#fff} .ytb-upcoming{background:#3b82f6;color:#fff} .ytb-planning{background:#f59e0b;color:#fff}

/* ── HERO ── */
.cafeo-hero { background:var(--navy-dark); min-height:90vh; display:flex; align-items:center; position:relative; overflow:hidden; }
.hero-bg-pattern { position:absolute; inset:0; background:linear-gradient(155deg,#001f45 0%,#002a5e 40%,#001035 100%); }
.hero-grid { position:absolute; inset:0; background-image:linear-gradient(rgba(200,168,75,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(200,168,75,.04) 1px,transparent 1px); background-size:60px 60px; }
.hero-accent-bar { position:absolute; top:0; right:0; width:45%; height:100%; background:linear-gradient(135deg,transparent 0%,rgba(10,90,107,.15) 100%); }
.hero-glow-1 { position:absolute; top:-150px; right:100px; width:700px; height:700px; border-radius:50%; background:radial-gradient(circle,rgba(10,90,107,.12) 0%,transparent 60%); }
.hero-glow-2 { position:absolute; bottom:-100px; left:100px; width:400px; height:400px; border-radius:50%; background:radial-gradient(circle,rgba(200,168,75,.06) 0%,transparent 60%); }
.hero-content { position:relative; z-index:2; padding:100px 60px 80px; display:grid; grid-template-columns:1fr 1fr; gap:80px; align-items:center; width:100%; }
.event-tag { display:inline-flex; align-items:center; gap:8px; margin-bottom:24px; }
.tag-text { font-size:11px; font-weight:700; letter-spacing:2.5px; text-transform:uppercase; color:var(--gold); }
.cafeo-hero h1 { font-family:'Playfair Display',serif; font-size:clamp(58px,6vw,80px); color:var(--white); font-weight:900; line-height:.9; margin-bottom:16px; }
.cafeo-hero .subtitle { font-size:13px; color:rgba(255,255,255,.45); letter-spacing:3px; text-transform:uppercase; margin-bottom:10px; line-height:1.6; max-width:440px; }
.cafeo-hero p.hero-p { font-size:16px; color:rgba(255,255,255,.72); line-height:1.8; max-width:460px; margin:20px 0 36px; }
.hero-cta-row { display:flex; gap:14px; flex-wrap:wrap; }
.btn-gold { background:var(--gold); color:var(--navy-dark); padding:14px 32px; font-weight:700; font-size:13px; letter-spacing:1px; text-transform:uppercase; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:all .2s; border:2px solid var(--gold); }
.btn-gold:hover { background:transparent; color:var(--gold); }
.btn-ghost-light { border:2px solid rgba(255,255,255,.25); color:rgba(255,255,255,.8); padding:14px 32px; font-weight:600; font-size:13px; letter-spacing:1px; text-transform:uppercase; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:all .2s; }
.btn-ghost-light:hover { border-color:var(--gold); color:var(--gold); }

/* ASEAN panel */
.asean-panel { background:rgba(255,255,255,.04); border:1px solid rgba(200,168,75,.15); padding:36px 32px; }
.asean-panel-title { font-size:10px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:var(--gold); margin-bottom:24px; padding-bottom:12px; border-bottom:1px solid rgba(200,168,75,.2); }
.asean-nations { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.nation-item { display:flex; align-items:center; gap:12px; padding:10px 12px; background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.06); transition:all .2s; }
.nation-item:hover { background:rgba(200,168,75,.08); border-color:rgba(200,168,75,.2); }
.nation-flag { font-size:22px; flex-shrink:0; }
.nation-info .name { font-size:13px; font-weight:600; color:var(--white); }
.nation-info .org { font-size:10px; color:rgba(255,255,255,.4); letter-spacing:.5px; }
.asean-note { font-size:11px; color:rgba(255,255,255,.35); margin-top:16px; letter-spacing:.5px; }

/* ── ANCHOR NAV ── */
.anchor-nav { background:var(--navy); display:flex; gap:0; padding:0 60px; position:sticky; top:72px; z-index:900; overflow-x:auto; }
.anchor-btn { padding:18px 26px; font-size:12px; font-weight:600; letter-spacing:1px; text-transform:uppercase; color:rgba(255,255,255,.5); text-decoration:none; border-bottom:3px solid transparent; transition:all .2s; white-space:nowrap; }
.anchor-btn:hover { color:var(--white); }
.anchor-btn.active { color:var(--gold); border-bottom-color:var(--gold); }

/* ── SECTIONS ── */
.section { padding:88px 60px; }
.section.alt { background:var(--offwhite, #f5f4f0); }
.section.dark { background:var(--navy-dark); }
.section.navy { background:var(--navy); }
.section-label { font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:var(--gold); margin-bottom:10px; }
.section-title { font-family:'Playfair Display',serif; font-size:clamp(28px,3vw,44px); color:var(--navy); font-weight:900; line-height:1.15; }
.section-title em { color:var(--gold); font-style:normal; }
.section-title.light { color:var(--white); }
.divider { width:60px; height:3px; background:var(--gold); margin:18px 0 36px; }

/* ── ABOUT ── */
.what-grid { display:grid; grid-template-columns:1.1fr 1fr; gap:72px; align-items:center; }
.what-visual-main { background:linear-gradient(135deg,var(--navy-dark) 0%,var(--asean-teal) 100%); height:420px; display:flex; flex-direction:column; align-items:center; justify-content:center; position:relative; overflow:hidden; padding:40px; }
.what-visual-main::before { content:'CAFEO'; font-family:'Playfair Display',serif; font-size:88px; font-weight:900; color:rgba(255,255,255,.04); letter-spacing:6px; position:absolute; }
.cafeo-edition-badge { background:var(--gold); padding:20px 28px; text-align:center; position:absolute; bottom:-20px; right:-20px; }
.cafeo-edition-badge .ed-num { font-family:'Playfair Display',serif; font-size:38px; font-weight:900; color:var(--navy-dark); line-height:1; }
.cafeo-edition-badge .ed-lbl { font-size:10px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--navy-dark); opacity:.65; }
.what-text p { font-size:15px; color:#444; line-height:1.85; margin-bottom:16px; }
.facts-strip { display:grid; grid-template-columns:repeat(3,1fr); gap:3px; margin-top:32px; }
.fact-box { background:var(--navy); padding:24px 18px; text-align:center; }
.fact-box .num { font-family:'Playfair Display',serif; font-size:32px; font-weight:900; color:var(--gold); display:block; line-height:1; }
.fact-box .lbl { font-size:10px; color:rgba(255,255,255,.5); letter-spacing:1.5px; text-transform:uppercase; margin-top:6px; display:block; }

/* ── ACTIVITIES ── */
.activities-layout { display:grid; grid-template-columns:repeat(2,1fr); gap:3px; margin-top:48px; }
.activity-block { background:var(--white); border:1px solid var(--light-grey, #e8e8e4); padding:40px 36px; transition:all .3s; }
.activity-block:hover { background:var(--navy); border-color:var(--navy); transform:translateY(-4px); box-shadow:0 20px 50px rgba(0,31,69,.15); }
.act-icon { width:56px; height:56px; border:2px solid var(--light-grey, #e8e8e4); display:flex; align-items:center; justify-content:center; margin-bottom:20px; transition:border-color .3s; }
.activity-block:hover .act-icon { border-color:rgba(200,168,75,.3); background:rgba(200,168,75,.1); }
.act-icon svg { width:26px; height:26px; stroke:var(--navy); fill:none; stroke-width:1.5; transition:stroke .3s; }
.activity-block:hover .act-icon svg { stroke:var(--gold); }
.act-tag { display:inline-block; font-size:9px; font-weight:700; letter-spacing:2px; text-transform:uppercase; padding:3px 10px; background:var(--offwhite, #f5f4f0); color:var(--navy); margin-bottom:12px; transition:all .3s; }
.activity-block:hover .act-tag { background:rgba(200,168,75,.15); color:var(--gold); }
.activity-block h3 { font-size:20px; font-weight:700; color:var(--navy); margin-bottom:10px; transition:color .3s; }
.activity-block:hover h3 { color:var(--white); }
.activity-block p { font-size:13.5px; color:var(--grey, #6b7280); line-height:1.75; transition:color .3s; }
.activity-block:hover p { color:rgba(255,255,255,.65); }

/* ── MALAYSIA'S ROLE ── */
.role-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:3px; margin-top:48px; }
.role-card { padding:44px 32px; background:rgba(255,255,255,.05); border:1px solid rgba(200,168,75,.12); transition:all .3s; }
.role-card:hover { background:rgba(200,168,75,.07); border-color:rgba(200,168,75,.3); transform:translateY(-4px); }
.role-num { font-family:'Playfair Display',serif; font-size:48px; font-weight:900; color:rgba(200,168,75,.2); line-height:1; margin-bottom:16px; transition:color .3s; }
.role-card:hover .role-num { color:rgba(200,168,75,.35); }
.role-card h3 { font-size:18px; font-weight:700; color:var(--white); margin-bottom:10px; }
.role-card p { font-size:13.5px; color:rgba(255,255,255,.6); line-height:1.75; }

/* ── HOW TO JOIN ── */
.join-two-col { display:grid; grid-template-columns:1fr 1fr; gap:52px; margin-top:48px; }
.join-track { background:var(--white); border:1px solid var(--light-grey, #e8e8e4); padding:40px 36px; }
.join-track-header { display:flex; align-items:center; gap:16px; margin-bottom:28px; padding-bottom:20px; border-bottom:1px solid var(--light-grey, #e8e8e4); }
.track-badge { width:48px; height:48px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.track-badge.delegate { background:var(--navy); }
.track-badge.student { background:var(--gold); }
.track-badge svg { width:22px; height:22px; fill:none; stroke-width:1.5; }
.track-badge.delegate svg { stroke:var(--gold); }
.track-badge.student svg { stroke:var(--navy-dark); }
.track-info h3 { font-size:18px; font-weight:700; color:var(--navy); }
.track-info .track-sub { font-size:12px; color:var(--grey, #6b7280); margin-top:3px; }
.join-steps-list { list-style:none; }
.join-step { display:flex; gap:16px; margin-bottom:20px; align-items:flex-start; }
.step-circle { width:32px; height:32px; background:var(--navy); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:var(--gold); flex-shrink:0; margin-top:1px; }
.join-step .step-text h4 { font-size:14px; font-weight:700; color:var(--navy); margin-bottom:4px; }
.join-step .step-text p { font-size:13px; color:var(--grey, #6b7280); line-height:1.65; }
.join-cta-strip { background:var(--navy); padding:44px 52px; display:flex; align-items:center; justify-content:space-between; gap:32px; margin-top:3px; }
.join-cta-strip h3 { font-family:'Playfair Display',serif; font-size:26px; font-weight:900; color:var(--white); }
.join-cta-strip p { font-size:14px; color:rgba(255,255,255,.6); margin-top:6px; }

/* ── OPPORTUNITIES ── */
.opps-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:3px; margin-top:48px; }
.opp-card { padding:40px 30px; background:var(--white); border:1px solid var(--light-grey, #e8e8e4); transition:all .3s; }
.opp-card:hover { background:var(--navy); border-color:var(--navy); transform:translateY(-4px); }
.opp-num { font-family:'Playfair Display',serif; font-size:48px; font-weight:900; color:var(--light-grey, #e8e8e4); line-height:1; margin-bottom:16px; transition:color .3s; }
.opp-card:hover .opp-num { color:rgba(200,168,75,.2); }
.opp-card h3 { font-size:18px; font-weight:700; color:var(--navy); margin-bottom:10px; transition:color .3s; }
.opp-card:hover h3 { color:var(--white); }
.opp-card p { font-size:13.5px; color:var(--grey, #6b7280); line-height:1.75; transition:color .3s; }
.opp-card:hover p { color:rgba(255,255,255,.65); }

/* ── PAST HOSTS TIMELINE ── */
.hosts-timeline { margin-top:48px; display:flex; flex-direction:column; gap:0; }
.host-row { display:grid; grid-template-columns:100px 3px 1fr; gap:0 20px; align-items:stretch; }
.host-year { font-family:'Playfair Display',serif; font-size:28px; font-weight:900; color:var(--gold); text-align:right; padding:12px 0; }
.host-line-col { display:flex; flex-direction:column; align-items:center; }
.host-dot { width:14px; height:14px; background:var(--gold); border-radius:50%; border:3px solid var(--white); box-shadow:0 0 0 2px var(--gold); flex-shrink:0; margin-top:16px; }
.host-vline { flex:1; width:2px; background:var(--light-grey, #e8e8e4); }
.host-row:last-child .host-vline { display:none; }
.host-card { background:var(--white); border:1px solid var(--light-grey, #e8e8e4); padding:16px 20px; margin:8px 0; display:flex; align-items:center; gap:16px; transition:all .2s; }
.host-card:hover { border-color:var(--gold); background:var(--offwhite, #f5f4f0); }
.host-flag { font-size:28px; }
.host-info h4 { font-size:15px; font-weight:700; color:var(--navy); }
.host-info p { font-size:12px; color:var(--grey, #6b7280); margin-top:2px; }
.host-info .host-theme { font-size:11px; color:var(--gold); font-style:italic; margin-top:4px; }

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
.reveal-d1{transition-delay:.1s} .reveal-d2{transition-delay:.2s} .reveal-d3{transition-delay:.3s}

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
<div class="cafeo-hero">
  <div class="hero-bg-pattern"></div>
  <div class="hero-grid"></div>
  <div class="hero-accent-bar"></div>
  <div class="hero-glow-1"></div>
  <div class="hero-glow-2"></div>
  <div class="hero-content">
    <div class="hero-left">
      <div class="event-tag">
        <span class="tag-text">ASEAN Flagship Event · {{ $editionStr }} Edition</span>
      </div>
      <h1>CAFEO <span style="color:var(--gold)">{{ $ev->year }}</span></h1>
      <div class="subtitle">{{ $ev->full_name }}</div>
      @if($ev->theme)<div style="font-size:14px;color:rgba(255,255,255,.6);font-style:italic;margin:10px 0 0;letter-spacing:.5px">"{{ $ev->theme }}"</div>@endif
      <p class="hero-p">{{ $ev->description ?: 'The premier gathering of engineering professionals across 10 ASEAN nations — where Malaysia\'s young engineers take the regional stage to collaborate, compete, and lead.' }}</p>
      <div class="hero-cta-row">
        @if($ev->registration_url && $isActive)
          <a href="{{ $ev->registration_url }}" target="_blank" rel="noopener" class="btn-gold">Register for CAFEO {{ $ev->year }} →</a>
        @endif
        <a href="#about" class="btn-ghost-light">What is CAFEO?</a>
      </div>
    </div>
    <div class="hero-right">
      <div class="asean-panel">
        <div class="asean-panel-title">AFEO Member Countries — CAFEO {{ $ev->year }}</div>
        <div class="asean-nations">
          <div class="nation-item"><span class="nation-flag">🇲🇾</span><div class="nation-info"><div class="name">Malaysia</div><div class="org">IEM{{ $ev->host && str_contains(strtolower($ev->host),'malaysia') ? ' (Host '.$ev->year.')' : '' }}</div></div></div>
          <div class="nation-item"><span class="nation-flag">🇸🇬</span><div class="nation-info"><div class="name">Singapore</div><div class="org">IES</div></div></div>
          <div class="nation-item"><span class="nation-flag">🇮🇩</span><div class="nation-info"><div class="name">Indonesia</div><div class="org">PII</div></div></div>
          <div class="nation-item"><span class="nation-flag">🇹🇭</span><div class="nation-info"><div class="name">Thailand</div><div class="org">EIT</div></div></div>
          <div class="nation-item"><span class="nation-flag">🇵🇭</span><div class="nation-info"><div class="name">Philippines</div><div class="org">IIEE</div></div></div>
          <div class="nation-item"><span class="nation-flag">🇻🇳</span><div class="nation-info"><div class="name">Vietnam</div><div class="org">VFCEA</div></div></div>
          <div class="nation-item"><span class="nation-flag">🇧🇳</span><div class="nation-info"><div class="name">Brunei</div><div class="org">IEB</div></div></div>
          <div class="nation-item"><span class="nation-flag">🇲🇲</span><div class="nation-info"><div class="name">Myanmar</div><div class="org">MEF</div></div></div>
          <div class="nation-item"><span class="nation-flag">🇰🇭</span><div class="nation-info"><div class="name">Cambodia</div><div class="org">CEAC</div></div></div>
          <div class="nation-item"><span class="nation-flag">🇱🇦</span><div class="nation-info"><div class="name">Laos</div><div class="org">LAEF</div></div></div>
        </div>
        <div class="asean-note">{{ $ev->host ? 'CAFEO '.$ev->year.' is hosted by '.$ev->host : 'CAFEO rotates annually across ASEAN nations' }}</div>
      </div>
    </div>
  </div>
</div>

{{-- ══ ANCHOR NAV ══ --}}
<nav class="anchor-nav" id="anchorNav">
  <a href="#about"         class="anchor-btn active">About CAFEO</a>
  <a href="#activities"    class="anchor-btn">Programme</a>
  <a href="#malaysia"      class="anchor-btn">Malaysia's Role</a>
  <a href="#join"          class="anchor-btn">How to Join</a>
  <a href="#opportunities" class="anchor-btn">Opportunities</a>
  <a href="#hosts"         class="anchor-btn">Past Hosts</a>
  <a href="#faq"           class="anchor-btn">FAQ</a>
</nav>

{{-- ══ ADMIN-CUSTOMIZABLE CONTENT (renders if admin has written it) ══ --}}
@if($ev->content)
<div class="admin-content">
  {!! $ev->content !!}
</div>
@endif

{{-- ══ ABOUT ══ --}}
<section class="section" id="about">
  <div class="what-grid">
    <div class="what-text">
      <div class="section-label reveal">What is CAFEO?</div>
      <h2 class="section-title reveal">ASEAN's Premier <em>Engineering</em> Conference</h2>
      <div class="divider reveal"></div>
      <p class="reveal">CAFEO — the Conference of ASEAN Federation of Engineering Organisations — is the annual flagship conference of AFEO, the umbrella body representing engineering institutions across all 10 ASEAN member countries.</p>
      <p class="reveal">Held each year in a different ASEAN country, CAFEO brings together thousands of engineering professionals, academics, policymakers, and students for three days of technical forums, workshops, policy dialogues, and regional engineering cooperation initiatives.</p>
      <p class="reveal">Malaysia, represented by the Institution of Engineers Malaysia (IEM) — and YES as the youth arm — has been a proud and active participant since CAFEO's inception, hosting the conference multiple times and sending student delegations annually.</p>
      <div class="facts-strip reveal">
        <div class="fact-box"><span class="num">{{ $nations ?: '10' }}</span><span class="lbl">ASEAN Nations</span></div>
        <div class="fact-box"><span class="num">{{ $delegates ?: '—' }}</span><span class="lbl">Annual Delegates</span></div>
        <div class="fact-box"><span class="num">{{ $editionStr ?: $ev->year }}</span><span class="lbl">Edition {{ $ev->year }}</span></div>
      </div>
    </div>
    <div class="what-visual reveal" style="position:relative">
      <div class="what-visual-main"></div>
      <div class="cafeo-edition-badge">
        <div class="ed-num">{{ $editionStr }}</div>
        <div class="ed-lbl">CAFEO {{ $ev->year }}</div>
      </div>
    </div>
  </div>
</section>

{{-- ══ PROGRAMME ══ --}}
<section class="section alt" id="activities">
  <div class="section-label reveal">What Happens at CAFEO</div>
  <h2 class="section-title reveal">Conference <em>Programme</em></h2>
  <div class="divider reveal"></div>
  <div class="activities-layout">
    <div class="activity-block reveal reveal-d1">
      <div class="act-icon"><svg viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div>
      <div class="act-tag">Technical</div>
      <h3>Technical Sessions &amp; Paper Presentations</h3>
      <p>Engineers and researchers present technical papers on infrastructure, sustainability, digital engineering, energy, and emerging technologies. Papers are published in the CAFEO Proceedings.</p>
    </div>
    <div class="activity-block reveal reveal-d2">
      <div class="act-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
      <div class="act-tag">Leadership</div>
      <h3>AFEO General Assembly &amp; Council Meetings</h3>
      <p>National engineering organisations from 10 ASEAN countries convene to set regional standards, discuss cross-border engineering cooperation, and advance ASEAN engineering policy.</p>
    </div>
    <div class="activity-block reveal reveal-d1">
      <div class="act-icon"><svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
      <div class="act-tag">Students</div>
      <h3>Young Engineers &amp; Student Track</h3>
      <p>A dedicated track featuring paper presentations, technical tours, career panels, and the AFEO Young Engineers Forum — where YES members represent Malaysia at the regional level.</p>
    </div>
    <div class="activity-block reveal reveal-d2">
      <div class="act-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></div>
      <div class="act-tag">Networking</div>
      <h3>ASEAN Engineering Exhibition &amp; Gala</h3>
      <p>A showcase of ASEAN engineering innovation and infrastructure projects — followed by the CAFEO Gala Dinner attended by ministers, industry CEOs, and engineering leaders from all 10 nations.</p>
    </div>
  </div>
</section>

{{-- ══ MALAYSIA'S ROLE ══ --}}
<section class="section dark" id="malaysia">
  <div class="section-label reveal">Malaysia at CAFEO</div>
  <h2 class="section-title light reveal">Malaysia's Role &amp; <em>Contributions</em></h2>
  <div class="divider reveal"></div>
  <div class="role-grid">
    <div class="role-card reveal reveal-d1">
      <div class="role-num">IEM</div>
      <h3>Representing Malaysia</h3>
      <p>The Institution of Engineers Malaysia (IEM) is Malaysia's AFEO representative. IEM sends a national delegation — including YES young engineers — to CAFEO every year.</p>
    </div>
    <div class="role-card reveal reveal-d2">
      <div class="role-num">YES</div>
      <h3>Youth Delegation</h3>
      <p>YES – IEM coordinates and funds Malaysia's student and young engineer delegation to CAFEO. Selected through NATSUM's paper presentation competition, YES delegates represent Malaysia in the Young Engineers Forum.</p>
    </div>
    <div class="role-card reveal reveal-d3">
      <div class="role-num">{{ $ev->year }}</div>
      <h3>{{ $ev->host ? 'Hosted by '.$ev->host : 'CAFEO '.$ev->year }}</h3>
      <p>{{ $ev->location ? 'Held at '.$ev->location.'.' : '' }} {{ $ev->host ? 'IEM and YES are proud to represent Malaysia at the '.$editionStr.' edition of this regional flagship.' : 'Malaysia continues its active participation, advancing ASEAN engineering excellence.' }}</p>
    </div>
  </div>
</section>

{{-- ══ HOW TO JOIN ══ --}}
<section class="section" id="join">
  <div class="section-label reveal">Get Involved</div>
  <h2 class="section-title reveal">How to <em>Participate</em> in CAFEO</h2>
  <div class="divider reveal"></div>
  <div class="join-two-col">
    <div class="join-track reveal">
      <div class="join-track-header">
        <div class="track-badge delegate"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
        <div class="track-info"><h3>Professional Delegate</h3><div class="track-sub">For IEM members &amp; engineering professionals</div></div>
      </div>
      <ul class="join-steps-list">
        <li class="join-step"><div class="step-circle">01</div><div class="step-text"><h4>Be an IEM Member</h4><p>CAFEO participation requires active IEM membership. Join at iem.org.my before registering.</p></div></li>
        <li class="join-step"><div class="step-circle">02</div><div class="step-text"><h4>Register via IEM Portal</h4><p>Delegate registration opens 3 months prior to CAFEO. Select your preferred technical sessions.</p></div></li>
        <li class="join-step"><div class="step-circle">03</div><div class="step-text"><h4>Submit a Paper (Optional)</h4><p>Professionals wishing to present must submit an abstract 4 months before the event for review.</p></div></li>
        <li class="join-step"><div class="step-circle">04</div><div class="step-text"><h4>Attend &amp; Represent</h4><p>Join Malaysia's delegation, attend AFEO sessions, and shape ASEAN's engineering future.</p></div></li>
      </ul>
    </div>
    <div class="join-track reveal reveal-d1">
      <div class="join-track-header">
        <div class="track-badge student"><svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg></div>
        <div class="track-info"><h3>Student &amp; YES Delegate</h3><div class="track-sub">For students &amp; young engineers via YES – IEM</div></div>
      </div>
      <ul class="join-steps-list">
        <li class="join-step"><div class="step-circle">01</div><div class="step-text"><h4>Participate in NATSUM</h4><p>The primary route is through NATSUM's Paper Presentation competition. Top performers are selected for CAFEO.</p></div></li>
        <li class="join-step"><div class="step-circle">02</div><div class="step-text"><h4>Be Selected by YES</h4><p>YES evaluates NATSUM participants on paper quality, presentation, and ASEAN relevance.</p></div></li>
        <li class="join-step"><div class="step-circle">03</div><div class="step-text"><h4>Receive YES Travel Grant</h4><p>YES – IEM provides a travel grant covering registration, flights, and accommodation for selected delegates.</p></div></li>
        <li class="join-step"><div class="step-circle">04</div><div class="step-text"><h4>Present &amp; Network Regionally</h4><p>Present your paper to an ASEAN audience and connect with peers from 10 ASEAN countries.</p></div></li>
      </ul>
    </div>
  </div>
  <div class="join-cta-strip reveal">
    <div>
      <h3>CAFEO {{ $ev->year }}{{ $ev->event_date ? ' — '.$ev->event_date : '' }}</h3>
      <p>YES is coordinating the Malaysian student delegation. Secure your spot through NATSUM {{ $ev->year }}.</p>
    </div>
    <a href="{{ route('flagship.slug', 'natsum') }}" class="btn-gold">Register for NATSUM →</a>
  </div>
</section>

{{-- ══ OPPORTUNITIES ══ --}}
<section class="section alt" id="opportunities">
  <div class="section-label reveal">Why Attend CAFEO</div>
  <h2 class="section-title reveal">Opportunities &amp; <em>Impact</em></h2>
  <div class="divider reveal"></div>
  <div class="opps-grid">
    <div class="opp-card reveal reveal-d1"><div class="opp-num">01</div><h3>Regional Recognition</h3><p>Present your engineering work to 5,000+ professionals from 10 ASEAN countries. CAFEO papers are published in official proceedings recognised by all AFEO member institutions.</p></div>
    <div class="opp-card reveal reveal-d2"><div class="opp-num">02</div><h3>ASEAN Networking</h3><p>Build connections with engineering professionals, academics, and policymakers across Southeast Asia. CAFEO alumni networks span every major engineering sector in ASEAN.</p></div>
    <div class="opp-card reveal reveal-d3"><div class="opp-num">03</div><h3>Career Advancement</h3><p>CAFEO participation signals regional engineering leadership. Many YES alumni who attended have gone on to senior roles in multinational corporations and government agencies.</p></div>
    <div class="opp-card reveal reveal-d1"><div class="opp-num">04</div><h3>CPD &amp; Accreditation</h3><p>Attendance earns significant IEM CPD points. Paper presenters receive additional CPD recognition and an official AFEO certificate of participation.</p></div>
    <div class="opp-card reveal reveal-d2"><div class="opp-num">05</div><h3>International Publication</h3><p>Accepted papers are published in the CAFEO Proceedings — a respected regional technical journal distributed to institutions across all 10 ASEAN countries.</p></div>
    <div class="opp-card reveal reveal-d3"><div class="opp-num">06</div><h3>Cultural Exchange</h3><p>CAFEO rotates annually across ASEAN cities. Each edition offers cultural immersion alongside the professional programme in a new ASEAN host country.</p></div>
  </div>
</section>

{{-- ══ PAST HOST COUNTRIES (from DB) ══ --}}
@if($pastEditions->isNotEmpty())
<section class="section" id="hosts">
  <div class="section-label reveal">History</div>
  <h2 class="section-title reveal">Past Host <em>Countries</em></h2>
  <div class="divider reveal"></div>
  <div class="hosts-timeline">
    @foreach($pastEditions as $ed)
    <div class="host-row reveal">
      <div class="host-year">{{ $ed->year }}</div>
      <div class="host-line-col"><div class="host-dot"></div><div class="host-vline"></div></div>
      <div class="host-card">
        <span class="host-flag">{{ $flagOf($ed->stat('host_code', '')) }}</span>
        <div class="host-info">
          <h4>{{ $ed->host ?: 'CAFEO '.$ed->year }}{{ $ed->edition_ordinal ? ' — CAFEO '.$ed->edition_number : '' }}</h4>
          <p>{{ $ed->location ?: 'Location TBC' }}</p>
          @if($ed->theme)<div class="host-theme">"{{ $ed->theme }}"</div>@endif
        </div>
      </div>
    </div>
    @endforeach
  </div>
</section>
@endif

{{-- ══ FAQ ══ --}}
<section class="section alt" id="faq">
  <div style="text-align:center">
    <div class="section-label reveal" style="display:inline-block">Questions</div>
    <h2 class="section-title reveal" style="text-align:center">Frequently Asked <em>Questions</em></h2>
    <div class="divider reveal" style="margin:18px auto 0"></div>
  </div>
  <div class="faq-list">
    @foreach([
      ['What is AFEO and how is it different from CAFEO?', 'AFEO (ASEAN Federation of Engineering Organisations) is the umbrella organisation representing the national engineering institutions of all 10 ASEAN countries. CAFEO (Conference of AFEO) is AFEO\'s annual flagship conference — it is the event, while AFEO is the organisation. Malaysia\'s IEM is the AFEO member from Malaysia.'],
      ['How does YES select the Malaysian student delegation to CAFEO?', 'The primary selection route is through NATSUM\'s Paper Presentation competition. Top-ranked student presenters are evaluated by YES and IEM on paper quality, relevance to regional engineering themes, and presentation performance. Selected delegates are awarded a YES travel grant.'],
      ['Is CAFEO only for professional engineers?', 'No. CAFEO has a dedicated Young Engineers and Student Track that welcomes final-year undergraduates and young professionals. YES specifically coordinates Malaysia\'s student participation through the AFEO Young Engineers Forum.'],
      ['Can I attend CAFEO without submitting a paper?', 'Yes. Delegate registration does not require a paper submission. You can attend as a full delegate and access all technical sessions, workshops, the engineering exhibition, and the Gala Dinner.'],
      ['What CPD points do I earn from CAFEO?', 'Attendance earns significant IEM Continuing Professional Development (CPD) points. Paper presenters receive additional CPD recognition and an official AFEO certificate of participation.'],
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
const sectionIds = ['about','activities','malaysia','join','opportunities','hosts','faq'];
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
