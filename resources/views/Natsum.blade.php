<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>NATSUM {{ $event?->year ?? '2025' }} – National Student Summit | YES IEM Malaysia</title>
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
.mega-menu { position: absolute; top: 100%; left: 0; min-width: 680px; background: var(--white); box-shadow: 0 20px 60px rgba(0,51,102,0.15); display: grid; grid-template-columns: 1fr 1fr; opacity: 0; pointer-events: none; transform: translateY(-8px); transition: all .25s ease; border-top: 3px solid var(--gold); }
.nav-links > li:hover .mega-menu { opacity: 1; pointer-events: all; transform: translateY(0); }
.mega-col { padding: 28px 30px; }
.mega-col:first-child { background: var(--offwhite); border-right: 1px solid var(--light-grey); }
.mega-col h4 { font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--gold); margin-bottom: 14px; padding-bottom: 8px; border-bottom: 1px solid var(--light-grey); }
.mega-col ul { list-style: none; }
.mega-col ul li a { display: block; padding: 6px 0; color: var(--navy); text-decoration: none; font-size: 13.5px; transition: all .15s; }
.mega-col ul li a:hover { color: var(--gold); padding-left: 8px; }
.mega-col ul li a.active-link { color: var(--gold); font-weight: 600; padding-left: 8px; border-left: 2px solid var(--gold); }

/* ── NATSUM HERO ── */
.natsum-hero { background: var(--navy-dark); min-height: 92vh; display: flex; align-items: center; position: relative; overflow: hidden; }
.natsum-hero::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, #001f45 0%, #003366 50%, #0a4a8c 100%); }
/* Decorative rings */
.hero-ring { position: absolute; border-radius: 50%; border: 1px solid rgba(200,168,75,0.12); }
.ring-1 { width: 700px; height: 700px; top: 50%; right: -200px; transform: translateY(-50%); }
.ring-2 { width: 500px; height: 500px; top: 50%; right: -100px; transform: translateY(-50%); }
.ring-3 { width: 300px; height: 300px; top: 50%; right: 0; transform: translateY(-50%); }
.hero-glow { position: absolute; top: -100px; right: 100px; width: 600px; height: 600px; border-radius: 50%; background: radial-gradient(circle, rgba(200,168,75,0.08) 0%, transparent 60%); }

.hero-content { position: relative; z-index: 2; padding: 100px 60px 80px; max-width: 700px; }
.event-edition { display: inline-flex; align-items: center; gap: 10px; background: rgba(200,168,75,0.12); border: 1px solid rgba(200,168,75,0.3); padding: 8px 20px; margin-bottom: 28px; }
.event-edition span { font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); }
.event-edition .dot { width: 6px; height: 6px; background: var(--gold); border-radius: 50%; }

.natsum-hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(52px, 7vw, 88px); color: var(--white); font-weight: 900; line-height: 0.95; margin-bottom: 10px; }
.natsum-hero h1 .accent { color: var(--gold); display: block; }
.natsum-hero .subtitle { font-size: 16px; color: rgba(255,255,255,0.5); letter-spacing: 4px; text-transform: uppercase; margin-bottom: 24px; }
.natsum-hero p { font-size: 17px; color: rgba(255,255,255,0.75); line-height: 1.8; max-width: 520px; margin-bottom: 40px; }

.hero-cta-row { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
.btn-gold { background: var(--gold); color: var(--navy-dark); padding: 15px 36px; font-weight: 700; font-size: 13px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all .2s; border: 2px solid var(--gold); }
.btn-gold:hover { background: transparent; color: var(--gold); }
.btn-ghost { border: 2px solid rgba(255,255,255,0.3); color: rgba(255,255,255,0.85); padding: 15px 36px; font-weight: 600; font-size: 13px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all .2s; }
.btn-ghost:hover { border-color: var(--gold); color: var(--gold); }

.hero-countdown { position: absolute; bottom: 52px; left: 60px; z-index: 2; display: flex; gap: 28px; }
.countdown-item { text-align: center; }
.countdown-item .num { font-family: 'Playfair Display', serif; font-size: 36px; font-weight: 900; color: var(--white); line-height: 1; display: block; }
.countdown-item .lbl { font-size: 10px; color: rgba(255,255,255,0.4); letter-spacing: 2px; text-transform: uppercase; margin-top: 4px; display: block; }
.countdown-sep { font-family: 'Playfair Display', serif; font-size: 28px; color: var(--gold); align-self: flex-end; padding-bottom: 18px; }

.hero-date-badge { position: absolute; bottom: 52px; right: 60px; z-index: 2; text-align: right; }
.hero-date-badge .date { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 900; color: var(--gold); }
.hero-date-badge .venue { font-size: 13px; color: rgba(255,255,255,0.55); margin-top: 4px; letter-spacing: 1px; }

/* ── ANCHOR NAV ── */
.anchor-nav { background: var(--navy); display: flex; gap: 0; padding: 0 60px; position: sticky; top: 72px; z-index: 900; }
.anchor-btn { padding: 18px 26px; font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: rgba(255,255,255,0.55); text-decoration: none; border-bottom: 3px solid transparent; transition: all .2s; white-space: nowrap; }
.anchor-btn:hover { color: var(--white); }
.anchor-btn.active { color: var(--gold); border-bottom-color: var(--gold); }

/* ── SECTION SHARED ── */
.section { padding: 88px 60px; }
.section.alt { background: var(--offwhite); }
.section.dark { background: var(--navy-dark); }
.section-label { font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 10px; }
.section-title { font-family: 'Playfair Display', serif; font-size: clamp(28px, 3vw, 44px); color: var(--navy); font-weight: 900; line-height: 1.15; }
.section-title em { color: var(--gold); font-style: normal; }
.section-title.light { color: var(--white); }
.divider { width: 60px; height: 3px; background: var(--gold); margin: 18px 0 32px; }

/* ── ABOUT NATSUM ── */
.about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 72px; align-items: center; }
.about-visual { position: relative; }
.about-visual-main { background: linear-gradient(135deg, var(--navy) 0%, #1a5fa8 100%); height: 400px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
.about-visual-main::before { content: 'NATSUM'; font-family: 'Playfair Display', serif; font-size: 72px; font-weight: 900; color: rgba(255,255,255,0.06); letter-spacing: 8px; position: absolute; }
.about-year-badge { position: absolute; bottom: -20px; right: -20px; width: 130px; height: 130px; background: var(--gold); display: flex; flex-direction: column; align-items: center; justify-content: center; }
.about-year-badge .yr { font-family: 'Playfair Display', serif; font-size: 36px; font-weight: 900; color: var(--navy-dark); line-height: 1; }
.about-year-badge .yr-lbl { font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--navy-dark); opacity: 0.6; }
.about-text p { font-size: 15px; color: #444; line-height: 1.85; margin-bottom: 16px; }
.stat-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 3px; margin-top: 32px; }
.stat-box { background: var(--navy); padding: 24px 20px; text-align: center; }
.stat-box .num { font-family: 'Playfair Display', serif; font-size: 34px; font-weight: 900; color: var(--gold); display: block; line-height: 1; }
.stat-box .lbl { font-size: 10px; color: rgba(255,255,255,0.55); letter-spacing: 1.5px; text-transform: uppercase; margin-top: 6px; display: block; }

/* ── ACTIVITIES ── */
.activities-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 3px; margin-top: 48px; }
.activity-card { background: var(--white); padding: 36px 28px; border-bottom: 3px solid transparent; transition: all .3s; }
.activity-card:hover { border-bottom-color: var(--gold); background: var(--navy); transform: translateY(-4px); box-shadow: 0 20px 50px rgba(0,31,69,0.15); }
.activity-icon { width: 52px; height: 52px; background: var(--offwhite); display: flex; align-items: center; justify-content: center; margin-bottom: 18px; transition: background .3s; }
.activity-card:hover .activity-icon { background: rgba(200,168,75,0.15); }
.activity-icon svg { width: 24px; height: 24px; stroke: var(--navy); fill: none; stroke-width: 1.5; transition: stroke .3s; }
.activity-card:hover .activity-icon svg { stroke: var(--gold); }
.activity-card h3 { font-size: 18px; font-weight: 700; color: var(--navy); margin-bottom: 10px; transition: color .3s; }
.activity-card:hover h3 { color: var(--white); }
.activity-card p { font-size: 13.5px; color: var(--grey); line-height: 1.75; transition: color .3s; }
.activity-card:hover p { color: rgba(255,255,255,0.68); }

/* ── HOW TO JOIN ── */
.join-steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 3px; margin-top: 48px; }
.step-card { background: var(--white); padding: 36px 28px; position: relative; border: 1px solid var(--light-grey); }
.step-card::after { content: '→'; position: absolute; right: -16px; top: 50%; transform: translateY(-50%); font-size: 20px; color: var(--gold); z-index: 2; }
.step-card:last-child::after { display: none; }
.step-num { font-family: 'Playfair Display', serif; font-size: 52px; font-weight: 900; color: var(--light-grey); line-height: 1; margin-bottom: 14px; }
.step-card h3 { font-size: 16px; font-weight: 700; color: var(--navy); margin-bottom: 8px; }
.step-card p { font-size: 13px; color: var(--grey); line-height: 1.7; }
.join-cta-strip { background: var(--navy); padding: 44px 52px; display: flex; align-items: center; justify-content: space-between; gap: 32px; margin-top: 3px; }
.join-cta-strip h3 { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 900; color: var(--white); }
.join-cta-strip p { font-size: 14px; color: rgba(255,255,255,0.65); margin-top: 6px; }

/* ── OPPORTUNITIES ── */
.opps-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 48px; }
.opp-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(200,168,75,0.2); padding: 36px 32px; transition: all .3s; }
.opp-card:hover { background: rgba(200,168,75,0.06); border-color: rgba(200,168,75,0.4); transform: translateY(-3px); }
.opp-tag { display: inline-block; font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 4px 10px; background: rgba(200,168,75,0.15); color: var(--gold); margin-bottom: 16px; }
.opp-card h3 { font-size: 20px; font-weight: 700; color: var(--white); margin-bottom: 12px; }
.opp-card p { font-size: 13.5px; color: rgba(255,255,255,0.6); line-height: 1.75; }
.opp-list { list-style: none; margin-top: 16px; }
.opp-list li { font-size: 13px; color: rgba(255,255,255,0.65); padding: 6px 0; border-bottom: 1px solid rgba(255,255,255,0.06); display: flex; align-items: center; gap: 10px; }
.opp-list li::before { content: ''; width: 6px; height: 6px; background: var(--gold); border-radius: 50%; flex-shrink: 0; }

/* ── PAST EDITIONS ── */
.editions-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 3px; margin-top: 48px; }
.edition-card { background: var(--white); border: 1px solid var(--light-grey); padding: 28px 24px; transition: all .3s; text-align: center; }
.edition-card:hover { background: var(--navy); border-color: var(--navy); transform: translateY(-4px); }
.edition-year { font-family: 'Playfair Display', serif; font-size: 40px; font-weight: 900; color: var(--gold); display: block; line-height: 1; margin-bottom: 8px; }
.edition-card h3 { font-size: 14px; font-weight: 700; color: var(--navy); margin-bottom: 6px; transition: color .3s; }
.edition-card:hover h3 { color: var(--white); }
.edition-location { font-size: 12px; color: var(--grey); transition: color .3s; display: flex; align-items: center; gap: 4px; justify-content: center; }
.edition-location svg { width: 11px; height: 11px; stroke: var(--grey); fill: none; stroke-width: 2; transition: stroke .3s; }
.edition-card:hover .edition-location { color: rgba(255,255,255,0.55); }
.edition-card:hover .edition-location svg { stroke: rgba(255,255,255,0.55); }
.edition-att { font-size: 12px; color: var(--gold); font-weight: 700; margin-top: 8px; display: block; }

/* ── FAQ ── */
.faq-list { max-width: 820px; margin: 48px auto 0; }
.faq-item { border-bottom: 1px solid var(--light-grey); }
.faq-question { width: 100%; padding: 22px 0; display: flex; align-items: center; justify-content: space-between; background: none; border: none; cursor: pointer; text-align: left; font-family: 'DM Sans', sans-serif; }
.faq-question span { font-size: 16px; font-weight: 600; color: var(--navy); }
.faq-chevron { width: 20px; height: 20px; border: 1.5px solid var(--gold); display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: transform .25s; color: var(--gold); font-size: 14px; }
.faq-item.open .faq-chevron { transform: rotate(180deg); }
.faq-answer { max-height: 0; overflow: hidden; transition: max-height .4s ease; }
.faq-answer p { font-size: 14px; color: var(--grey); line-height: 1.8; padding-bottom: 20px; }

/* ── REVEAL ── */
.reveal { opacity: 0; transform: translateY(24px); transition: opacity .7s ease, transform .7s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-d1 { transition-delay: .1s; }
.reveal-d2 { transition-delay: .2s; }
.reveal-d3 { transition-delay: .3s; }
.reveal-d4 { transition-delay: .4s; }

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
.logo-sm { display: flex; align-items: center; gap: 10px; text-decoration: none; margin-bottom: 12px; }
.logo-sm-mark { width: 40px; height: 40px; background: var(--navy); border-radius: 4px; display: flex; align-items: center; justify-content: center; }
.logo-sm-mark span { color: var(--gold); font-family: 'Playfair Display', serif; font-size: 17px; font-weight: 900; }
.logo-sm-text .org { font-size: 15px; font-weight: 700; color: var(--white); letter-spacing: 1px; }
.logo-sm-text .tagline { font-size: 9px; color: rgba(255,255,255,0.45); letter-spacing: 1px; text-transform: uppercase; }
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
        <div class="mega-col"><h4>Who We Are</h4><ul>
          <li><a href="{{ route('who-we-are') }}#vision-mission">Mission &amp; Vision</a></li>
          <li><a href="{{ route('who-we-are') }}#values">Values</a></li>
          <li><a href="{{ route('who-we-are') }}#where-we-are">Where We Are</a></li>
          <li><a href="{{ route('milestone') }}">Milestones</a></li>
        </ul></div>
        <div class="mega-col"><h4>Leadership</h4><ul>
          <li><a href="#">YES HQ Office Bearers</a></li>
          <li><a href="#">YES State Branches</a></li>
          <li><a href="#">YES Klang Valley Board</a></li>
          <li><a href="#">YES Non-Klang Valley Board</a></li>
        </ul></div>
      </div>
    </li>
    <li class="active">
      <a href="#">Events <span class="nav-arrow"></span></a>
      <div class="mega-menu">
        <div class="mega-col"><h4>General Events</h4><ul>
          <li><a href="{{ route('official-board-events') }}">Official Board Events</a></li>
          <li><a href="{{ route('student-section-events') }}">Student Section Events</a></li>
        </ul></div>
        <div class="mega-col"><h4>Flagship Events</h4><ul>
          <li><a href="{{ route('natsum') }}" class="active-link">NATSUM</a></li>
          <li><a href="{{ route('cafeo') }}">CAFEO</a></li>
        </ul></div>
      </div>
    </li>
    <li>
      <a href="#">Awards <span class="nav-arrow"></span></a>
      <div class="mega-menu">
        <div class="mega-col"><h4>Recognition</h4><ul><li><a href="#">YES Excellence Awards</a></li><li><a href="#">Student Achievement Awards</a></li></ul></div>
        <div class="mega-col"><h4>Nominate</h4><ul><li><a href="#">Nomination Guidelines</a></li><li><a href="#">Past Recipients</a></li></ul></div>
      </div>
    </li>
    <li>
      <a href="#">Sustainability <span class="nav-arrow"></span></a>
      <div class="mega-menu">
        <div class="mega-col"><h4>Our Commitments</h4><ul><li><a href="#">Environmental Initiatives</a></li><li><a href="#">Community Outreach</a></li></ul></div>
        <div class="mega-col"><h4>Get Involved</h4><ul><li><a href="#">Volunteer Programme</a></li><li><a href="#">Sustainability Reports</a></li></ul></div>
      </div>
    </li>
    <li><a href="{{ route('home') }}#footer">Contact Us</a></li>
  </ul>
</nav>

<!-- ══ HERO ══ -->
<div class="natsum-hero">
  <div class="hero-ring ring-1"></div>
  <div class="hero-ring ring-2"></div>
  <div class="hero-ring ring-3"></div>
  <div class="hero-glow"></div>
  <div class="hero-content">
    <div class="event-edition">
      <div class="dot"></div>
      <span>Flagship Event · Annual Since 1995</span>
    </div>
    <h1>NAT<span class="accent">SUM</span></h1>
    <div class="subtitle">National Student Summit</div>
    @if($event?->theme)
    <div style="font-size:13px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--gold);margin-bottom:20px;opacity:.9">{{ $event->theme }}</div>
    @endif
    <p>{{ $event?->description ?? 'Malaysia\'s premier gathering of engineering and science students — a three-day summit of competitions, industry workshops, leadership sessions, and networking with the brightest young engineers in the country.' }}</p>
    <div class="hero-cta-row">
      @if($event?->registration_url)
      <a href="{{ $event->registration_url }}" target="_blank" class="btn-gold">Register for NATSUM {{ $event->year }} →</a>
      @else
      <a href="#join" class="btn-gold">Register for NATSUM {{ $event?->year ?? '2025' }} →</a>
      @endif
      <a href="#about" class="btn-ghost">Learn More</a>
    </div>
  </div>

  <div class="hero-countdown" id="countdown">
    <div class="countdown-item"><span class="num" id="cd-days">48</span><span class="lbl">Days</span></div>
    <div class="countdown-sep">:</div>
    <div class="countdown-item"><span class="num" id="cd-hours">12</span><span class="lbl">Hours</span></div>
    <div class="countdown-sep">:</div>
    <div class="countdown-item"><span class="num" id="cd-mins">34</span><span class="lbl">Mins</span></div>
    <div class="countdown-sep">:</div>
    <div class="countdown-item"><span class="num" id="cd-secs">09</span><span class="lbl">Secs</span></div>
  </div>
  <div class="hero-date-badge">
    <div class="date">{{ $event?->event_date ?? '14–16 Aug 2025' }}</div>
    <div class="venue">📍 {{ $event?->location ?? 'Universiti Malaya, Kuala Lumpur' }}</div>
  </div>
</div>

<!-- ══ ANCHOR NAV ══ -->
<nav class="anchor-nav" id="anchorNav">
  <a href="#about" class="anchor-btn active">About NATSUM</a>
  <a href="#activities" class="anchor-btn">Activities</a>
  <a href="#join" class="anchor-btn">How to Join</a>
  <a href="#opportunities" class="anchor-btn">Opportunities</a>
  <a href="#editions" class="anchor-btn">Past Editions</a>
  <a href="#faq" class="anchor-btn">FAQ</a>
</nav>

<!-- ══ ABOUT ══ -->
<section class="section" id="about">
  <div class="about-grid">
    <div class="about-visual reveal">
      <div class="about-visual-main"></div>
      <div class="about-year-badge">
        <span class="yr">30th</span>
        <span class="yr-lbl">Edition</span>
      </div>
    </div>
    <div class="about-text">
      <div class="section-label reveal">What is NATSUM?</div>
      <h2 class="section-title reveal">Malaysia's Largest <em>Student Engineering</em> Summit</h2>
      <div class="divider reveal"></div>
      <p class="reveal">NATSUM — the National Student Summit — is YES – IEM's flagship annual event for engineering and science undergraduates. First held in 1995, it has grown into Malaysia's most prestigious student engineering platform, drawing thousands of participants from universities across the country.</p>
      <p class="reveal">Over three intensive days, students compete in technical challenges, attend industry-led workshops, network with engineering professionals, and gain direct exposure to Malaysia's leading engineering organisations — all in one immersive experience.</p>
      <div class="stat-row reveal">
        <div class="stat-box"><span class="num">3,500+</span><span class="lbl">Participants</span></div>
        <div class="stat-box"><span class="num">80+</span><span class="lbl">Universities</span></div>
        <div class="stat-box"><span class="num">50+</span><span class="lbl">Industry Partners</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ══ ACTIVITIES ══ -->
<section class="section alt" id="activities">
  <div class="section-label reveal">What Happens at NATSUM</div>
  <h2 class="section-title reveal">Events &amp; <em>Activities</em></h2>
  <div class="divider reveal"></div>
  <div class="activities-grid">
    <div class="activity-card reveal reveal-d1">
      <div class="activity-icon">
        <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
      </div>
      <h3>Technical Paper Presentation</h3>
      <p>Present your final year project or research to a panel of industry judges. Top papers earn national recognition and qualify for regional CAFEO representation.</p>
    </div>
    <div class="activity-card reveal reveal-d2">
      <div class="activity-icon">
        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      </div>
      <h3>Industry Networking Sessions</h3>
      <p>Curated networking sessions with engineers, HR managers, and industry leaders from Malaysia's top conglomerates — in an intimate, structured environment.</p>
    </div>
    <div class="activity-card reveal reveal-d3">
      <div class="activity-icon">
        <svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
      </div>
      <h3>Technical Workshops</h3>
      <p>Hands-on workshops covering digital engineering, AI applications, sustainable design, and Industry 4.0 tools — led by practitioners from industry and academia.</p>
    </div>
    <div class="activity-card reveal reveal-d1">
      <div class="activity-icon">
        <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      </div>
      <h3>Engineering Quiz Championship</h3>
      <p>A multi-round inter-university quiz competition testing engineering knowledge across civil, mechanical, electrical, and chemical disciplines. Prizes for top three teams.</p>
    </div>
    <div class="activity-card reveal reveal-d2">
      <div class="activity-icon">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
      </div>
      <h3>Leadership &amp; Soft Skills Forum</h3>
      <p>Plenary sessions and workshops on professional communication, engineering ethics, leadership in diverse teams, and building a standout engineering career.</p>
    </div>
    <div class="activity-card reveal reveal-d3">
      <div class="activity-icon">
        <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
      </div>
      <h3>Student Chapter Awards Night</h3>
      <p>The closing gala evening celebrates the best student YES chapters nationwide, recognising outstanding contributions to the engineering community across all universities.</p>
    </div>
  </div>
</section>

<!-- ══ HOW TO JOIN ══ -->
<section class="section" id="join">
  <div class="section-label reveal">Get Involved</div>
  <h2 class="section-title reveal">How to <em>Join</em> NATSUM 2025</h2>
  <div class="divider reveal"></div>
  <div class="join-steps">
    <div class="step-card reveal reveal-d1">
      <div class="step-num">01</div>
      <h3>Check Eligibility</h3>
      <p>Open to all full-time undergraduate students enrolled in engineering or science programmes at Malaysian universities. Fresh graduates within 1 year may also participate.</p>
    </div>
    <div class="step-card reveal reveal-d2">
      <div class="step-num">02</div>
      <h3>Register Online</h3>
      <p>Complete the online registration form. Individual and team registrations are available. Early bird pricing closes 30 June 2025.</p>
    </div>
    <div class="step-card reveal reveal-d3">
      <div class="step-num">03</div>
      <h3>Pay Registration Fee</h3>
      <p>Registration fee: RM 80 (individual) · RM 280 (team of 4). Payment via online banking or credit card. YES members receive a 20% discount.</p>
    </div>
    <div class="step-card reveal reveal-d4">
      <div class="step-num">04</div>
      <h3>Attend &amp; Compete</h3>
      <p>Receive your confirmation kit, select your workshops, and show up ready to learn, compete, and connect. Welcome dinner on Day 1 is complimentary.</p>
    </div>
  </div>
  <div class="join-cta-strip reveal">
    <div>
      <h3>Ready to join NATSUM 2025?</h3>
      <p>Registration is open now — early bird pricing until 30 June 2025.</p>
    </div>
    <a href="#" class="btn-gold">Register Now →</a>
  </div>
</section>

<!-- ══ OPPORTUNITIES ══ -->
<section class="section dark" id="opportunities">
  <div class="section-label reveal">Why Attend</div>
  <h2 class="section-title light reveal">Opportunities &amp; <em>Benefits</em></h2>
  <div class="divider reveal"></div>
  <div class="opps-grid">
    <div class="opp-card reveal reveal-d1">
      <div class="opp-tag">Career</div>
      <h3>Internship &amp; Graduate Placements</h3>
      <p>50+ companies attend NATSUM's career exhibition. On-the-spot interviews and internship offers are regularly made to outstanding student participants.</p>
      <ul class="opp-list">
        <li>Direct recruitment interviews</li>
        <li>Graduate programme sign-ups</li>
        <li>Scholarship opportunities</li>
        <li>Industry mentorship matching</li>
      </ul>
    </div>
    <div class="opp-card reveal reveal-d2">
      <div class="opp-tag">Recognition</div>
      <h3>Awards &amp; Prizes</h3>
      <p>Win national recognition at Malaysia's most prestigious student engineering event. Top performers in each competition category receive certificates and cash prizes.</p>
      <ul class="opp-list">
        <li>Best Paper Presentation (RM 2,000)</li>
        <li>Engineering Quiz Champions (RM 1,500)</li>
        <li>Best Student Chapter Award</li>
        <li>YES Young Engineer of the Year Award</li>
      </ul>
    </div>
    <div class="opp-card reveal reveal-d3">
      <div class="opp-tag">International</div>
      <h3>CAFEO Representation</h3>
      <p>Top-performing students at NATSUM's paper presentation competition are selected to represent Malaysia at CAFEO — the ASEAN Federation of Engineering Organisations conference.</p>
      <ul class="opp-list">
        <li>Represent Malaysia regionally</li>
        <li>Travel grant provided</li>
        <li>ASEAN-level networking</li>
        <li>International publication opportunity</li>
      </ul>
    </div>
    <div class="opp-card reveal reveal-d4">
      <div class="opp-tag">Development</div>
      <h3>CPD Points &amp; Certificates</h3>
      <p>All NATSUM participants receive a certificate of attendance endorsed by YES – IEM. Workshops qualify for IEM Continuing Professional Development (CPD) points.</p>
      <ul class="opp-list">
        <li>YES – IEM endorsed certificate</li>
        <li>Up to 12 CPD points</li>
        <li>Workshop completion certificates</li>
        <li>LinkedIn-ready credentials</li>
      </ul>
    </div>
  </div>
</section>

<!-- ══ PAST EDITIONS ══ -->
<section class="section alt" id="editions">
  <div class="section-label reveal">Our History</div>
  <h2 class="section-title reveal">Past <em>Editions</em></h2>
  <div class="divider reveal"></div>
  <div class="editions-grid">
    <div class="edition-card reveal reveal-d1">
      <span class="edition-year">2024</span>
      <h3>NATSUM 2024</h3>
      <div class="edition-location"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> UKM, Bangi</div>
      <span class="edition-att">3,200 participants</span>
    </div>
    <div class="edition-card reveal reveal-d2">
      <span class="edition-year">2023</span>
      <h3>NATSUM 2023</h3>
      <div class="edition-location"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> USM, Penang</div>
      <span class="edition-att">2,900 participants</span>
    </div>
    <div class="edition-card reveal reveal-d3">
      <span class="edition-year">2022</span>
      <h3>NATSUM 2022</h3>
      <div class="edition-location"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> UTM, Skudai</div>
      <span class="edition-att">2,400 participants</span>
    </div>
    <div class="edition-card reveal reveal-d4">
      <span class="edition-year">2021</span>
      <h3>NATSUM 2021</h3>
      <div class="edition-location"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> Virtual Event</div>
      <span class="edition-att">4,100 participants</span>
    </div>
  </div>
</section>

<!-- ══ FAQ ══ -->
<section class="section" id="faq">
  <div style="text-align:center;">
    <div class="section-label reveal" style="display:inline-block;">Questions</div>
    <h2 class="section-title reveal" style="max-width:100%;text-align:center;">Frequently Asked <em>Questions</em></h2>
    <div class="divider reveal" style="margin:18px auto 0;"></div>
  </div>
  <div class="faq-list">
    <div class="faq-item reveal">
      <button class="faq-question" onclick="toggleFaq(this)">
        <span>Who is eligible to attend NATSUM?</span>
        <div class="faq-chevron">▼</div>
      </button>
      <div class="faq-answer"><p>NATSUM is open to all full-time undergraduate students enrolled in engineering, technology, or science programmes at any Malaysian university. Fresh graduates who completed their degree within the past 12 months are also eligible to register.</p></div>
    </div>
    <div class="faq-item reveal">
      <button class="faq-question" onclick="toggleFaq(this)">
        <span>What is the registration fee?</span>
        <div class="faq-chevron">▼</div>
      </button>
      <div class="faq-answer"><p>Individual registration: RM 80 (early bird RM 60 until 30 June 2025). Team registration (4 members): RM 280. YES members receive an additional 20% discount. The fee covers all programme sessions, meals on Day 1–3, and the closing dinner.</p></div>
    </div>
    <div class="faq-item reveal">
      <button class="faq-question" onclick="toggleFaq(this)">
        <span>Is accommodation provided?</span>
        <div class="faq-chevron">▼</div>
      </button>
      <div class="faq-answer"><p>NATSUM does not include accommodation in the registration fee. However, a list of nearby hotels and university hostels with negotiated group rates is provided upon registration confirmation. Participants are encouraged to book early.</p></div>
    </div>
    <div class="faq-item reveal">
      <button class="faq-question" onclick="toggleFaq(this)">
        <span>How do I submit a paper for the Paper Presentation competition?</span>
        <div class="faq-chevron">▼</div>
      </button>
      <div class="faq-answer"><p>Submit your abstract (500–800 words) via the NATSUM registration portal by 15 July 2025. Accepted abstracts will be notified by 25 July, after which you submit the full paper by 5 August. All engineering and science disciplines are welcome.</p></div>
    </div>
    <div class="faq-item reveal">
      <button class="faq-question" onclick="toggleFaq(this)">
        <span>Can non-YES members attend?</span>
        <div class="faq-chevron">▼</div>
      </button>
      <div class="faq-answer"><p>Yes — NATSUM is open to all eligible students regardless of YES membership. However, YES members enjoy a 20% discount on registration fees and priority access to networking sessions. You can sign up as a YES member during the registration process.</p></div>
    </div>
  </div>
</section>

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
        <li><a href="{{ route('natsum') }}">NATSUM</a></li>
        <li><a href="{{ route('cafeo') }}">CAFEO</a></li>
      </ul>
    </div>
    <div>
      <h4>Contact</h4>
      <ul>
        <li><a href="#">+603 8890 1234</a></li>
        <li><a href="#">natsum@yes-iem.org.my</a></li>
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
// Countdown to NATSUM 2025: 14 Aug 2025
const target = new Date('2025-08-14T08:00:00');
function updateCountdown() {
  const now = new Date();
  const diff = target - now;
  if (diff <= 0) { document.getElementById('countdown').style.display = 'none'; return; }
  const d = Math.floor(diff / 86400000);
  const h = Math.floor((diff % 86400000) / 3600000);
  const m = Math.floor((diff % 3600000) / 60000);
  const s = Math.floor((diff % 60000) / 1000);
  document.getElementById('cd-days').textContent = String(d).padStart(2,'0');
  document.getElementById('cd-hours').textContent = String(h).padStart(2,'0');
  document.getElementById('cd-mins').textContent = String(m).padStart(2,'0');
  document.getElementById('cd-secs').textContent = String(s).padStart(2,'0');
}
updateCountdown();
setInterval(updateCountdown, 1000);

// FAQ accordion
function toggleFaq(btn) {
  const item = btn.parentElement;
  const answer = item.querySelector('.faq-answer');
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item.open').forEach(i => {
    i.classList.remove('open');
    i.querySelector('.faq-answer').style.maxHeight = '0';
  });
  if (!isOpen) {
    item.classList.add('open');
    answer.style.maxHeight = answer.scrollHeight + 'px';
  }
}

// Anchor nav active
const anchorBtns = document.querySelectorAll('.anchor-btn');
const sectionIds = ['about','activities','join','opportunities','editions','faq'];
window.addEventListener('scroll', () => {
  let current = '';
  sectionIds.forEach(id => {
    const el = document.getElementById(id);
    if (el && window.scrollY >= el.offsetTop - 200) current = id;
  });
  anchorBtns.forEach(btn => {
    btn.classList.toggle('active', btn.getAttribute('href') === '#' + current);
  });
  document.getElementById('backTop').classList.toggle('visible', window.scrollY > 400);
});

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const id = a.getAttribute('href').slice(1);
    const el = document.getElementById(id);
    if (el) { e.preventDefault(); el.scrollIntoView({ behavior: 'smooth' }); }
  });
});

// Reveal
const obs = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.08 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
</script>
</body>
</html>