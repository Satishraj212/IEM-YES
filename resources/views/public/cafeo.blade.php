@extends('public.layouts.app')

@section('title', 'CAFEO ' . ($event?->year ?? date('Y')) . ' – Conference of ASEAN Federation | YES IEM Malaysia')

@push('styles')
<style>
.cafeo-hero { background: var(--navy-dark); min-height: 90vh; display: flex; align-items: center; position: relative; overflow: hidden; }
.hero-bg-pattern { position: absolute; inset: 0; background: linear-gradient(155deg,#001f45 0%,#002a5e 40%,#001035 100%); }
.hero-grid { position: absolute; inset: 0; background-image: linear-gradient(rgba(200,168,75,0.04) 1px,transparent 1px),linear-gradient(90deg,rgba(200,168,75,0.04) 1px,transparent 1px); background-size: 60px 60px; }
.hero-accent-bar { position: absolute; top: 0; right: 0; width: 45%; height: 100%; background: linear-gradient(135deg,transparent 0%,rgba(10,90,107,0.15) 100%); }
.hero-glow-1 { position: absolute; top: -150px; right: 100px; width: 700px; height: 700px; border-radius: 50%; background: radial-gradient(circle,rgba(10,90,107,0.12) 0%,transparent 60%); }
.hero-glow-2 { position: absolute; bottom: -100px; left: 100px; width: 400px; height: 400px; border-radius: 50%; background: radial-gradient(circle,rgba(200,168,75,0.06) 0%,transparent 60%); }
.hero-content { position: relative; z-index: 2; padding: 100px 60px 80px; display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; width: 100%; }
.event-tag { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 24px; }
.event-tag .tag-text { font-size: 11px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase; color: var(--gold); }
.cafeo-hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(58px,6vw,80px); color: var(--white); font-weight: 900; line-height: 0.9; margin-bottom: 16px; }
.cafeo-hero .subtitle { font-size: 13px; color: rgba(255,255,255,0.45); letter-spacing: 3px; text-transform: uppercase; margin-bottom: 10px; line-height: 1.6; max-width: 440px; }
.cafeo-hero p { font-size: 16px; color: rgba(255,255,255,0.72); line-height: 1.8; max-width: 460px; margin: 20px 0 36px; }
.hero-cta-row { display: flex; gap: 14px; flex-wrap: wrap; }
.asean-panel { background: rgba(255,255,255,0.04); border: 1px solid rgba(200,168,75,0.15); padding: 36px 32px; }
.asean-panel-title { font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 24px; padding-bottom: 12px; border-bottom: 1px solid rgba(200,168,75,0.2); }
.asean-nations { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.nation-item { display: flex; align-items: center; gap: 12px; padding: 10px 12px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); transition: all .2s; }
.nation-item:hover { background: rgba(200,168,75,0.08); border-color: rgba(200,168,75,0.2); }
.nation-flag { font-size: 22px; flex-shrink: 0; }
.nation-info .name { font-size: 13px; font-weight: 600; color: var(--white); }
.nation-info .org { font-size: 10px; color: rgba(255,255,255,0.4); letter-spacing: 0.5px; }
.asean-note { font-size: 11px; color: rgba(255,255,255,0.35); margin-top: 16px; letter-spacing: 0.5px; }
.anchor-nav { background: var(--navy); display: flex; gap: 0; padding: 0 60px; position: sticky; top: 72px; z-index: 900; overflow-x: auto; }
.anchor-btn { padding: 18px 26px; font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: rgba(255,255,255,0.5); text-decoration: none; border-bottom: 3px solid transparent; transition: all .2s; white-space: nowrap; }
.anchor-btn:hover { color: var(--white); }
.anchor-btn.active { color: var(--gold); border-bottom-color: var(--gold); }
.section { padding: 88px 60px; }
.section.alt { background: var(--offwhite); }
.section.dark { background: var(--navy-dark); }
.what-grid { display: grid; grid-template-columns: 1.1fr 1fr; gap: 72px; align-items: center; }
.what-visual { position: relative; }
.what-visual-main { background: linear-gradient(135deg,var(--navy-dark) 0%,#0a5a6b 100%); height: 420px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; overflow: hidden; padding: 40px; }
.what-visual-main::before { content: 'CAFEO'; font-family: 'Playfair Display', serif; font-size: 88px; font-weight: 900; color: rgba(255,255,255,0.04); letter-spacing: 6px; position: absolute; }
.cafeo-edition-badge { background: var(--gold); padding: 20px 28px; text-align: center; position: absolute; bottom: -20px; right: -20px; }
.cafeo-edition-badge .ed-num { font-family: 'Playfair Display', serif; font-size: 38px; font-weight: 900; color: var(--navy-dark); line-height: 1; }
.cafeo-edition-badge .ed-lbl { font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--navy-dark); opacity: 0.65; }
.what-text p { font-size: 15px; color: #444; line-height: 1.85; margin-bottom: 16px; }
.facts-strip { display: grid; grid-template-columns: repeat(3,1fr); gap: 3px; margin-top: 32px; }
.fact-box { background: var(--navy); padding: 24px 18px; text-align: center; }
.fact-box .num { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 900; color: var(--gold); display: block; line-height: 1; }
.fact-box .lbl { font-size: 10px; color: rgba(255,255,255,0.5); letter-spacing: 1.5px; text-transform: uppercase; margin-top: 6px; display: block; }
.activities-layout { display: grid; grid-template-columns: repeat(2,1fr); gap: 3px; margin-top: 48px; }
.activity-block { background: var(--white); border: 1px solid var(--light-grey); padding: 40px 36px; transition: all .3s; }
.activity-block:hover { background: var(--navy); border-color: var(--navy); transform: translateY(-4px); box-shadow: 0 20px 50px rgba(0,31,69,0.15); }
.act-icon { width: 56px; height: 56px; border: 2px solid var(--light-grey); display: flex; align-items: center; justify-content: center; margin-bottom: 20px; transition: border-color .3s; }
.activity-block:hover .act-icon { border-color: rgba(200,168,75,0.3); background: rgba(200,168,75,0.1); }
.act-icon svg { width: 26px; height: 26px; stroke: var(--navy); fill: none; stroke-width: 1.5; transition: stroke .3s; }
.activity-block:hover .act-icon svg { stroke: var(--gold); }
.act-tag { display: inline-block; font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 3px 10px; background: var(--offwhite); color: var(--navy); margin-bottom: 12px; transition: all .3s; }
.activity-block:hover .act-tag { background: rgba(200,168,75,0.15); color: var(--gold); }
.activity-block h3 { font-size: 20px; font-weight: 700; color: var(--navy); margin-bottom: 10px; transition: color .3s; }
.activity-block:hover h3 { color: var(--white); }
.activity-block p { font-size: 13.5px; color: var(--grey); line-height: 1.75; transition: color .3s; }
.activity-block:hover p { color: rgba(255,255,255,0.65); }
.role-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 3px; margin-top: 48px; }
.role-card { padding: 44px 32px; background: rgba(255,255,255,0.05); border: 1px solid rgba(200,168,75,0.12); transition: all .3s; }
.role-card:hover { background: rgba(200,168,75,0.07); border-color: rgba(200,168,75,0.3); transform: translateY(-4px); }
.role-num { font-family: 'Playfair Display', serif; font-size: 48px; font-weight: 900; color: rgba(200,168,75,0.2); line-height: 1; margin-bottom: 16px; }
.role-card h3 { font-size: 18px; font-weight: 700; color: var(--white); margin-bottom: 10px; }
.role-card p { font-size: 13.5px; color: rgba(255,255,255,0.6); line-height: 1.75; }
.join-two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 52px; margin-top: 48px; }
.join-track { background: var(--white); border: 1px solid var(--light-grey); padding: 40px 36px; }
.join-track-header { display: flex; align-items: center; gap: 16px; margin-bottom: 28px; padding-bottom: 20px; border-bottom: 1px solid var(--light-grey); }
.track-badge { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.track-badge.delegate { background: var(--navy); }
.track-badge.student { background: var(--gold); }
.track-badge svg { width: 22px; height: 22px; fill: none; stroke-width: 1.5; }
.track-badge.delegate svg { stroke: var(--gold); }
.track-badge.student svg { stroke: var(--navy-dark); }
.track-info h3 { font-size: 18px; font-weight: 700; color: var(--navy); }
.track-info .track-sub { font-size: 12px; color: var(--grey); margin-top: 3px; }
.join-steps-list { list-style: none; }
.join-step { display: flex; gap: 16px; margin-bottom: 20px; align-items: flex-start; }
.step-circle { width: 32px; height: 32px; background: var(--navy); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: var(--gold); flex-shrink: 0; margin-top: 1px; }
.join-step .step-text h4 { font-size: 14px; font-weight: 700; color: var(--navy); margin-bottom: 4px; }
.join-step .step-text p { font-size: 13px; color: var(--grey); line-height: 1.65; }
.join-cta-strip { background: var(--navy); padding: 44px 52px; display: flex; align-items: center; justify-content: space-between; gap: 32px; margin-top: 3px; flex-wrap: wrap; }
.join-cta-strip h3 { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 900; color: var(--white); }
.join-cta-strip p { font-size: 14px; color: rgba(255,255,255,0.6); margin-top: 6px; }
.opps-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 3px; margin-top: 48px; }
.opp-card { padding: 40px 30px; background: var(--white); border: 1px solid var(--light-grey); transition: all .3s; }
.opp-card:hover { background: var(--navy); border-color: var(--navy); transform: translateY(-4px); }
.opp-num { font-family: 'Playfair Display', serif; font-size: 48px; font-weight: 900; color: var(--light-grey); line-height: 1; margin-bottom: 16px; transition: color .3s; }
.opp-card:hover .opp-num { color: rgba(200,168,75,0.2); }
.opp-card h3 { font-size: 18px; font-weight: 700; color: var(--navy); margin-bottom: 10px; transition: color .3s; }
.opp-card:hover h3 { color: var(--white); }
.opp-card p { font-size: 13.5px; color: var(--grey); line-height: 1.75; transition: color .3s; }
.opp-card:hover p { color: rgba(255,255,255,0.65); }
.hosts-timeline { margin-top: 48px; display: flex; flex-direction: column; }
.host-row { display: grid; grid-template-columns: 100px 3px 1fr; gap: 0 20px; align-items: stretch; }
.host-year { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 900; color: var(--gold); text-align: right; padding: 12px 0; }
.host-line-col { display: flex; flex-direction: column; align-items: center; }
.host-dot { width: 14px; height: 14px; background: var(--gold); border-radius: 50%; border: 3px solid var(--white); box-shadow: 0 0 0 2px var(--gold); flex-shrink: 0; margin-top: 16px; }
.host-vline { flex: 1; width: 2px; background: var(--light-grey); }
.host-row:last-child .host-vline { display: none; }
.host-card { background: var(--white); border: 1px solid var(--light-grey); padding: 16px 20px; margin: 8px 0; display: flex; align-items: center; gap: 16px; transition: all .2s; }
.host-card:hover { border-color: var(--gold); background: var(--offwhite); }
.host-flag { font-size: 28px; }
.host-info h4 { font-size: 15px; font-weight: 700; color: var(--navy); }
.host-info p { font-size: 12px; color: var(--grey); margin-top: 2px; }
.host-info .host-theme { font-size: 11px; color: var(--gold); font-style: italic; margin-top: 4px; }
.faq-list { max-width: 820px; margin: 48px auto 0; }
.faq-item { border-bottom: 1px solid var(--light-grey); }
.faq-question { width: 100%; padding: 22px 0; display: flex; align-items: center; justify-content: space-between; background: none; border: none; cursor: pointer; text-align: left; font-family: 'DM Sans', sans-serif; }
.faq-question span { font-size: 16px; font-weight: 600; color: var(--navy); }
.faq-chevron { width: 20px; height: 20px; border: 1.5px solid var(--gold); display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: transform .25s; color: var(--gold); font-size: 14px; }
.faq-item.open .faq-chevron { transform: rotate(180deg); }
.faq-answer { max-height: 0; overflow: hidden; transition: max-height .4s ease; }
.faq-answer p { font-size: 14px; color: var(--grey); line-height: 1.8; padding-bottom: 20px; }
.reveal-d1 { transition-delay: .1s; } .reveal-d2 { transition-delay: .2s; } .reveal-d3 { transition-delay: .3s; }
</style>
@endpush

@section('content')

<div class="cafeo-hero">
  <div class="hero-bg-pattern"></div>
  <div class="hero-grid"></div>
  <div class="hero-accent-bar"></div>
  <div class="hero-glow-1"></div>
  <div class="hero-glow-2"></div>
  <div class="hero-content">
    <div class="hero-left">
      <div class="event-tag"><span class="tag-text">ASEAN Flagship Event · Annual</span></div>
      <h1>CAFEO</h1>
      <div class="subtitle">Conference of ASEAN Federation of<br/>Engineering Organisations</div>
      @if($event?->theme)<div style="font-size:13px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--gold);margin-bottom:16px;opacity:.9">{{ $event->theme }}</div>@endif
      <p>{{ $event?->description ?? "The premier gathering of engineering professionals across 10 ASEAN nations — where Malaysia's young engineers take the regional stage to collaborate, compete, and lead." }}</p>
      <div class="hero-cta-row">
        @if($event?->registration_url)
        <a href="{{ $event->registration_url }}" target="_blank" class="btn-gold">Register for CAFEO {{ $event->year }} →</a>
        @else
        <a href="#join" class="btn-gold">How Malaysia Participates →</a>
        @endif
        <a href="#about" class="btn-ghost">What is CAFEO?</a>
      </div>
    </div>
    <div class="hero-right">
      <div class="asean-panel">
        <div class="asean-panel-title">AFEO Member Countries — CAFEO {{ $event?->year ?? date('Y') }}</div>
        <div class="asean-nations">
          <div class="nation-item"><span class="nation-flag">🇲🇾</span><div class="nation-info"><div class="name">Malaysia</div><div class="org">IEM</div></div></div>
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
        <div class="asean-note">CAFEO {{ $event?->year ?? date('Y') }} {{ $event?->location ? '— ' . $event->location : '— hosted by Malaysia, organised by IEM' }}</div>
      </div>
    </div>
  </div>
</div>

<nav class="anchor-nav" id="anchorNav">
  <a href="#about" class="anchor-btn active">About CAFEO</a>
  <a href="#activities" class="anchor-btn">Programme</a>
  <a href="#malaysia" class="anchor-btn">Malaysia's Role</a>
  <a href="#join" class="anchor-btn">How to Join</a>
  <a href="#opportunities" class="anchor-btn">Opportunities</a>
  <a href="#hosts" class="anchor-btn">Past Hosts</a>
  <a href="#faq" class="anchor-btn">FAQ</a>
</nav>

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
        <div class="fact-box"><span class="num">10</span><span class="lbl">ASEAN Nations</span></div>
        <div class="fact-box"><span class="num">5,000+</span><span class="lbl">Annual Delegates</span></div>
        <div class="fact-box"><span class="num">42nd</span><span class="lbl">Edition in 2025</span></div>
      </div>
    </div>
    <div class="what-visual reveal">
      <div class="what-visual-main"></div>
      <div class="cafeo-edition-badge"><div class="ed-num">42nd</div><div class="ed-lbl">CAFEO 2025</div></div>
    </div>
  </div>
</section>

<section class="section alt" id="activities">
  <div class="section-label reveal">What Happens at CAFEO</div>
  <h2 class="section-title reveal">Conference <em>Programme</em></h2>
  <div class="divider reveal"></div>
  <div class="activities-layout">
    <div class="activity-block reveal reveal-d1">
      <div class="act-icon"><svg viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div>
      <div class="act-tag">Technical</div>
      <h3>Technical Sessions &amp; Paper Presentations</h3>
      <p>Engineers and researchers present technical papers on infrastructure, sustainability, digital engineering, energy, and emerging technologies. Papers are reviewed and published in the CAFEO Proceedings.</p>
    </div>
    <div class="activity-block reveal reveal-d2">
      <div class="act-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
      <div class="act-tag">Leadership</div>
      <h3>AFEO General Assembly &amp; Council Meetings</h3>
      <p>National engineering organisations from 10 ASEAN countries convene to set regional engineering standards, discuss cross-border cooperation, and advance ASEAN engineering policy.</p>
    </div>
    <div class="activity-block reveal reveal-d1">
      <div class="act-icon"><svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
      <div class="act-tag">Students</div>
      <h3>Young Engineers &amp; Student Track</h3>
      <p>A dedicated track for young engineers and student delegates — featuring paper presentations, technical tours, career panels, and the prestigious AFEO Young Engineers Forum.</p>
    </div>
    <div class="activity-block reveal reveal-d2">
      <div class="act-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></div>
      <div class="act-tag">Networking</div>
      <h3>ASEAN Engineering Exhibition &amp; Gala</h3>
      <p>A showcase of ASEAN engineering innovation and infrastructure projects — followed by the CAFEO Gala Dinner attended by ministers, industry CEOs, and engineering leaders from all 10 nations.</p>
    </div>
  </div>
</section>

<section class="section dark" id="malaysia">
  <div class="section-label reveal">Malaysia at CAFEO</div>
  <h2 class="section-title light reveal">Malaysia's Role &amp; <em>Contributions</em></h2>
  <div class="divider reveal"></div>
  <div class="role-grid">
    <div class="role-card reveal reveal-d1">
      <div class="role-num">IEM</div>
      <h3>Representing Malaysia</h3>
      <p>The Institution of Engineers Malaysia (IEM) is Malaysia's AFEO representative. IEM sends a national delegation — including YES young engineers — to CAFEO every year, participating in all technical and policy sessions.</p>
    </div>
    <div class="role-card reveal reveal-d2">
      <div class="role-num">YES</div>
      <h3>Youth Delegation</h3>
      <p>YES – IEM coordinates and funds Malaysia's student and young engineer delegation to CAFEO. Selected through NATSUM's paper presentation competition, YES delegates represent Malaysia in the Young Engineers Forum.</p>
    </div>
    <div class="role-card reveal reveal-d3">
      <div class="role-num">{{ $event?->year ?? '2025' }}</div>
      <h3>Malaysia Hosts CAFEO {{ $event?->year ?? '2025' }}</h3>
      <p>Malaysia has the honour of hosting CAFEO's 42nd edition in {{ $event?->year ?? '2025' }}. IEM and YES are co-organising the conference, positioning Malaysia as the centre of ASEAN engineering excellence.</p>
    </div>
  </div>
</section>

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
        <li class="join-step"><div class="step-circle">01</div><div class="step-text"><h4>Be an IEM Member</h4><p>CAFEO participation requires active IEM membership. You can join IEM at iem.org.my before registering.</p></div></li>
        <li class="join-step"><div class="step-circle">02</div><div class="step-text"><h4>Register via IEM Portal</h4><p>Delegate registration opens 3 months prior to CAFEO. Register through the IEM member portal and select your preferred technical sessions.</p></div></li>
        <li class="join-step"><div class="step-circle">03</div><div class="step-text"><h4>Submit a Paper (Optional)</h4><p>Professionals wishing to present a technical paper must submit an abstract for review by the CAFEO technical committee, 4 months before the event.</p></div></li>
        <li class="join-step"><div class="step-circle">04</div><div class="step-text"><h4>Attend &amp; Represent</h4><p>Join Malaysia's delegation, attend the AFEO sessions, and be part of the regional engineering community shaping ASEAN's future.</p></div></li>
      </ul>
    </div>
    <div class="join-track reveal reveal-d1">
      <div class="join-track-header">
        <div class="track-badge student"><svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg></div>
        <div class="track-info"><h3>Student &amp; YES Delegate</h3><div class="track-sub">For students &amp; young engineers via YES – IEM</div></div>
      </div>
      <ul class="join-steps-list">
        <li class="join-step"><div class="step-circle">01</div><div class="step-text"><h4>Participate in NATSUM</h4><p>The primary route for students is through NATSUM's Paper Presentation competition. Top performers are selected to represent Malaysia at CAFEO.</p></div></li>
        <li class="join-step"><div class="step-circle">02</div><div class="step-text"><h4>Be Selected by YES</h4><p>YES evaluates NATSUM participants on paper quality, presentation performance, and ASEAN engineering relevance. Selected delegates are notified within 2 weeks of NATSUM.</p></div></li>
        <li class="join-step"><div class="step-circle">03</div><div class="step-text"><h4>Receive YES Travel Grant</h4><p>YES – IEM provides a travel grant covering registration, flights, and accommodation for selected student delegates.</p></div></li>
        <li class="join-step"><div class="step-circle">04</div><div class="step-text"><h4>Present &amp; Network Regionally</h4><p>Present your paper to an ASEAN audience, attend the Young Engineers Forum, and connect with engineering peers from 10 ASEAN countries.</p></div></li>
      </ul>
    </div>
  </div>
  <div class="join-cta-strip reveal">
    <div><h3>CAFEO {{ $event?->year ?? date('Y') }} — Hosted by Malaysia</h3><p>YES is coordinating the Malaysian student delegation. Secure your spot through NATSUM {{ $event?->year ?? date('Y') }}.</p></div>
    <a href="{{ route('natsum') }}" class="btn-gold">Register for NATSUM →</a>
  </div>
</section>

<section class="section alt" id="opportunities">
  <div class="section-label reveal">Why Attend CAFEO</div>
  <h2 class="section-title reveal">Opportunities &amp; <em>Impact</em></h2>
  <div class="divider reveal"></div>
  <div class="opps-grid">
    @foreach([
      ['01','Regional Recognition','Present your engineering work to an audience of 5,000+ professionals from 10 ASEAN countries. CAFEO papers are published in official proceedings and recognised internationally.'],
      ['02','ASEAN Networking','Build connections with engineering professionals, academics, and policymakers across Southeast Asia. CAFEO alumni networks span every major engineering sector across ASEAN.'],
      ['03','Career Advancement','CAFEO participation signals regional engineering leadership. Many Malaysian YES alumni who attended CAFEO have gone on to senior roles in multinational engineering corporations.'],
      ['04','CPD &amp; Accreditation','Attendance at CAFEO earns significant IEM Continuing Professional Development (CPD) points. Paper presenters receive additional CPD recognition and an AFEO certificate.'],
      ['05','International Publication','Accepted CAFEO papers are published in the annual CAFEO Proceedings — a respected regional technical journal distributed to engineering institutions across all 10 ASEAN countries.'],
      ['06','Cultural Exchange','CAFEO rotates annually across ASEAN cities — past hosts include Singapore, Bangkok, Manila, Hanoi, and Jakarta. Each edition offers unique cultural immersion.'],
    ] as [$num, $title, $desc])
    <div class="opp-card reveal">
      <div class="opp-num">{{ $num }}</div>
      <h3>{!! $title !!}</h3>
      <p>{{ $desc }}</p>
    </div>
    @endforeach
  </div>
</section>

<section class="section" id="hosts">
  <div class="section-label reveal">History</div>
  <h2 class="section-title reveal">Past Host <em>Countries</em></h2>
  <div class="divider reveal"></div>
  <div class="hosts-timeline">
    @foreach([
      ['2025','🇲🇾','Malaysia — CAFEO 42','Kuala Lumpur Convention Centre, KL','"Engineering for a Sustainable ASEAN Future"'],
      ['2024','🇻🇳','Vietnam — CAFEO 41','Ho Chi Minh City, Vietnam','"Innovation and Digital Transformation in Engineering"'],
      ['2023','🇹🇭','Thailand — CAFEO 40','Bangkok, Thailand','"Engineering Solutions for Resilient ASEAN Communities"'],
      ['2022','🇵🇭','Philippines — CAFEO 39','Manila, Philippines','"Building Back Better: Engineering Post-Pandemic"'],
      ['2019','🇮🇩','Indonesia — CAFEO 37','Bali, Indonesia','"ASEAN Connectivity: Infrastructure for the Future"'],
    ] as [$year, $flag, $name, $loc, $theme])
    <div class="host-row reveal">
      <div class="host-year">{{ $year }}</div>
      <div class="host-line-col"><div class="host-dot"></div><div class="host-vline"></div></div>
      <div class="host-card">
        <span class="host-flag">{{ $flag }}</span>
        <div class="host-info"><h4>{{ $name }}</h4><p>{{ $loc }}</p><div class="host-theme">{{ $theme }}</div></div>
      </div>
    </div>
    @endforeach
  </div>
</section>

<section class="section alt" id="faq">
  <div style="text-align:center">
    <div class="section-label reveal" style="display:inline-block">Questions</div>
    <h2 class="section-title reveal" style="max-width:100%;text-align:center">Frequently Asked <em>Questions</em></h2>
    <div class="divider reveal" style="margin:18px auto 0"></div>
  </div>
  <div class="faq-list">
    @foreach([
      ['What is AFEO and how is it different from CAFEO?','AFEO (ASEAN Federation of Engineering Organisations) is the umbrella organisation representing the national engineering institutions of all 10 ASEAN countries. CAFEO (Conference of AFEO) is AFEO\'s annual flagship conference. Malaysia\'s IEM is the AFEO member from Malaysia.'],
      ['How does YES select the Malaysian student delegation to CAFEO?','The primary selection route is through NATSUM\'s Paper Presentation competition. Top-ranked student presenters are evaluated on the quality of their paper, relevance to regional engineering themes, and presentation performance. Selected delegates are awarded a YES travel grant.'],
      ['Is CAFEO only for professional engineers?','No. CAFEO has a dedicated Young Engineers and Student Track that welcomes final-year undergraduates and young professionals. YES specifically coordinates Malaysia\'s student participation through the Young Engineers Forum.'],
      ['Where is CAFEO 2025 being held?','CAFEO 2025 (42nd edition) is being hosted by Malaysia at the Kuala Lumpur Convention Centre (KLCC) in November 2025. IEM and YES are co-organising the event.'],
      ['Can I attend CAFEO without submitting a paper?','Yes. Delegate registration does not require a paper submission. You can attend as a full delegate and access all technical sessions, workshops, the engineering exhibition, and the Gala Dinner.'],
    ] as [$q, $a])
    <div class="faq-item reveal">
      <button class="faq-question" onclick="toggleFaq(this)">
        <span>{{ $q }}</span><div class="faq-chevron">▼</div>
      </button>
      <div class="faq-answer"><p>{{ $a }}</p></div>
    </div>
    @endforeach
  </div>
</section>

@endsection

@push('scripts')
<script>
function toggleFaq(btn) {
  const item = btn.parentElement;
  const answer = item.querySelector('.faq-answer');
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item.open').forEach(i => { i.classList.remove('open'); i.querySelector('.faq-answer').style.maxHeight = '0'; });
  if (!isOpen) { item.classList.add('open'); answer.style.maxHeight = answer.scrollHeight + 'px'; }
}
const anchorBtns = document.querySelectorAll('.anchor-btn');
const sectionIds = ['about','activities','malaysia','join','opportunities','hosts','faq'];
window.addEventListener('scroll', () => {
  let current = '';
  sectionIds.forEach(id => { const el = document.getElementById(id); if (el && window.scrollY >= el.offsetTop - 200) current = id; });
  anchorBtns.forEach(btn => btn.classList.toggle('active', btn.getAttribute('href') === '#' + current));
});
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const el = document.getElementById(a.getAttribute('href').slice(1));
    if (el) { e.preventDefault(); el.scrollIntoView({ behavior: 'smooth' }); }
  });
});
</script>
@endpush
