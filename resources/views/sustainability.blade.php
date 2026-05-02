<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Sustainability – YES Young Engineer Section | IEM Malaysia</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<style>
:root {
  --navy: #003366;
  --navy-dark: #001f45;
  --gold: #c8a84b;
  --white: #ffffff;
  --offwhite: #f5f4f0;
  --grey: #6b7280;
  --light-grey: #e8e8e4;
  --green-dark: #0d4a2b;
  --green: #1a6b3c;
  --green-accent: #4caf7d;
  --green-light: #a8e6c1;
}
* { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }
body { font-family: 'DM Sans', sans-serif; color: #222; background: var(--white); overflow-x: hidden; }

/* ── TOP BAR ── */
.top-bar { background: var(--navy-dark); color: rgba(255,255,255,0.65); font-size: 12px; display: flex; justify-content: flex-end; align-items: center; gap: 24px; padding: 7px 60px; }
.top-bar a { color: rgba(255,255,255,0.65); text-decoration: none; transition: color .2s; }
.top-bar a:hover { color: var(--gold); }

/* ── NAV ── */
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

.mega-menu {
  position: absolute; top: 100%; left: 0;
  width: max-content; min-width: 420px;
  max-width: min(680px, calc(100vw - 60px));
  background: var(--white);
  box-shadow: 0 20px 60px rgba(0,51,102,0.15);
  display: grid; grid-template-columns: 1fr 1fr;
  opacity: 0; pointer-events: none;
  transform: translateY(-8px); transition: all .25s ease;
  border-top: 3px solid var(--gold);
}
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

/* ── PAGE HERO ── */
.page-hero {
  background: linear-gradient(135deg, var(--navy-dark) 0%, #0a2a52 55%, #0d3d22 100%);
  padding: 72px 60px 56px;
  position: relative;
  overflow: hidden;
}
.page-hero::before {
  content: '';
  position: absolute; top: -60px; right: -60px;
  width: 480px; height: 480px; border-radius: 50%;
  background: radial-gradient(circle, rgba(200,168,75,0.06) 0%, transparent 70%);
}
.page-hero::after {
  content: '';
  position: absolute; bottom: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--gold) 0%, var(--green-accent) 50%, transparent 100%);
}
.page-hero .hero-pattern {
  position: absolute; inset: 0;
  background-image: radial-gradient(circle, rgba(200,168,75,0.04) 1px, transparent 1px);
  background-size: 36px 36px;
}
.breadcrumb { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; font-size: 12px; letter-spacing: 1.5px; text-transform: uppercase; position: relative; z-index: 2; }
.breadcrumb a { color: rgba(255,255,255,0.45); text-decoration: none; transition: color .2s; }
.breadcrumb a:hover { color: var(--gold); }
.breadcrumb span { color: rgba(255,255,255,0.2); }
.breadcrumb .current { color: var(--gold); }
.hero-inner { position: relative; z-index: 2; max-width: 680px; }
.hero-inner h1 { font-family: 'Playfair Display', serif; font-size: clamp(34px, 4.5vw, 56px); color: var(--white); font-weight: 900; line-height: 1.1; }
.hero-inner h1 em { color: var(--gold); font-style: normal; }
.hero-inner p { font-size: 16px; color: rgba(255,255,255,0.65); margin-top: 16px; line-height: 1.8; max-width: 560px; }

/* ── STICKY SECTION NAV ── */
.section-nav {
  position: sticky; top: 72px; z-index: 900;
  background: var(--navy); border-bottom: 2px solid rgba(255,255,255,0.08);
  display: flex; align-items: center; gap: 0;
  padding: 0 60px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}
.section-nav a {
  display: flex; align-items: center; gap: 8px;
  padding: 18px 28px;
  color: rgba(255,255,255,0.55);
  text-decoration: none; font-size: 13px; font-weight: 600;
  letter-spacing: 1px; text-transform: uppercase;
  border-bottom: 3px solid transparent;
  transition: all .2s; position: relative; top: 2px;
}
.section-nav a:hover { color: var(--white); }
.section-nav a.active { color: var(--gold); border-bottom-color: var(--gold); }
.section-nav-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; flex-shrink: 0; }

/* ── SHARED SECTION STYLES ── */
.content-section { padding: 80px 60px; scroll-margin-top: 140px; }
.content-section:nth-child(even) { background: var(--offwhite); }
.section-label { font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 10px; }
.section-title { font-family: 'Playfair Display', serif; font-size: clamp(28px, 3.5vw, 44px); color: var(--navy); font-weight: 900; line-height: 1.15; }
.section-title em { color: var(--gold); font-style: normal; }
.section-divider { width: 60px; height: 3px; background: var(--gold); margin: 20px 0 32px; }
.lead-text { font-size: 17px; color: #444; line-height: 1.85; max-width: 720px; margin-bottom: 24px; }
.body-text { font-size: 15px; color: #555; line-height: 1.9; max-width: 720px; margin-bottom: 20px; }

/* ── INITIATIVE SECTION ── */
#initiative { background: var(--white); }
.initiative-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: start; margin-top: 48px; }
.initiative-visual { position: relative; }
.initiative-visual .main-card {
  background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy) 100%);
  padding: 48px 40px; position: relative; overflow: hidden;
}
.initiative-visual .main-card::before {
  content: '';
  position: absolute; bottom: -40px; right: -40px;
  width: 200px; height: 200px; border-radius: 50%;
  background: radial-gradient(circle, rgba(200,168,75,0.12) 0%, transparent 70%);
}
.initiative-visual .big-icon { font-size: 64px; line-height: 1; margin-bottom: 20px; display: block; }
.initiative-visual .main-card h3 { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 900; color: var(--white); margin-bottom: 12px; }
.initiative-visual .main-card p { font-size: 14px; color: rgba(255,255,255,0.65); line-height: 1.75; }
.initiative-visual .stat-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 2px; margin-top: 2px; }
.initiative-visual .stat-box { background: var(--gold); padding: 20px 16px; text-align: center; }
.initiative-visual .stat-box .num { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 900; color: var(--navy-dark); line-height: 1; }
.initiative-visual .stat-box .lbl { font-size: 10px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--navy-dark); opacity: 0.7; margin-top: 4px; display: block; }
.initiative-content .pillar-list { list-style: none; margin-top: 8px; }
.initiative-content .pillar-list li { display: flex; gap: 16px; padding: 16px 0; border-bottom: 1px solid var(--light-grey); }
.initiative-content .pillar-list li:last-child { border-bottom: none; }
.pillar-num { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 900; color: var(--gold); opacity: 0.4; flex-shrink: 0; line-height: 1; }
.pillar-text h4 { font-size: 15px; font-weight: 700; color: var(--navy); margin-bottom: 4px; }
.pillar-text p { font-size: 13.5px; color: var(--grey); line-height: 1.7; }

/* ── PLEDGE SECTION ── */
#pledge { background: var(--offwhite); }
.pledge-layout { display: grid; grid-template-columns: 1.2fr 1fr; gap: 60px; align-items: start; margin-top: 48px; }
.pledge-document {
  background: var(--white); border-left: 4px solid var(--gold);
  padding: 40px 40px 36px; box-shadow: 0 8px 40px rgba(0,0,0,0.06);
  position: relative;
}
.pledge-document::before {
  content: '"';
  position: absolute; top: 20px; right: 28px;
  font-family: 'Playfair Display', serif; font-size: 100px; font-weight: 900;
  color: var(--gold); opacity: 0.08; line-height: 1;
}
.pledge-document .doc-label { font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
.pledge-document .doc-label::after { content: ''; flex: 1; height: 1px; background: var(--light-grey); }
.pledge-document p { font-size: 15px; line-height: 1.9; color: #444; margin-bottom: 16px; font-style: italic; }
.pledge-document p:last-of-type { margin-bottom: 28px; }
.pledge-document .sig-line { display: flex; align-items: center; gap: 16px; padding-top: 20px; border-top: 1px solid var(--light-grey); }
.pledge-document .sig-mark { width: 44px; height: 44px; background: var(--navy); display: flex; align-items: center; justify-content: center; border-radius: 4px; flex-shrink: 0; }
.pledge-document .sig-mark span { color: var(--gold); font-family: 'Playfair Display', serif; font-size: 16px; font-weight: 900; }
.pledge-document .sig-info small { display: block; font-size: 11px; color: var(--grey); letter-spacing: 1px; text-transform: uppercase; }
.pledge-document .sig-info strong { font-size: 14px; color: var(--navy); font-weight: 700; }
.pledge-aside h3 { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; color: var(--navy); margin-bottom: 20px; }
.pledge-commitments { list-style: none; }
.pledge-commitments li { display: flex; gap: 14px; align-items: flex-start; padding: 14px 0; border-bottom: 1px solid var(--light-grey); }
.pledge-commitments li:last-child { border-bottom: none; }
.pledge-check { width: 28px; height: 28px; background: var(--green); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
.pledge-check svg { width: 13px; height: 13px; stroke: var(--white); fill: none; stroke-width: 2.5; }
.pledge-commitments li p { font-size: 14px; color: #444; line-height: 1.65; }
.pledge-cta { margin-top: 28px; }
.btn-navy { display: inline-flex; align-items: center; gap: 10px; background: var(--navy); color: var(--white); padding: 14px 28px; font-weight: 700; font-size: 13px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; border: 2px solid var(--navy); transition: all .2s; }
.btn-navy:hover { background: transparent; color: var(--navy); }

/* ── DECLARATION SECTION ── */
#declaration { background: var(--white); }
.declaration-hero-bar { background: linear-gradient(135deg, var(--green-dark) 0%, var(--green) 100%); padding: 40px 48px; display: flex; align-items: center; justify-content: space-between; gap: 32px; margin-top: 48px; }
.declaration-hero-bar h3 { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 900; color: var(--white); }
.declaration-hero-bar p { font-size: 14px; color: rgba(255,255,255,0.7); margin-top: 6px; }
.btn-gold-solid { display: inline-flex; align-items: center; gap: 8px; background: var(--gold); color: var(--navy-dark); padding: 14px 28px; font-weight: 700; font-size: 13px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; border: 2px solid var(--gold); transition: all .2s; white-space: nowrap; }
.btn-gold-solid:hover { background: transparent; color: var(--gold); }
.declaration-body { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; margin-top: 48px; align-items: start; }
.declaration-text .statement-block { border-left: 3px solid var(--gold); padding-left: 24px; margin-bottom: 28px; }
.declaration-text .statement-block h4 { font-size: 16px; font-weight: 700; color: var(--navy); margin-bottom: 8px; }
.declaration-text .statement-block p { font-size: 14px; color: #555; line-height: 1.8; }
.declaration-endorsements h3 { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; color: var(--navy); margin-bottom: 24px; }
.endorsement-card { background: var(--offwhite); padding: 20px 22px; border-left: 3px solid var(--green-accent); margin-bottom: 12px; transition: transform .2s; }
.endorsement-card:hover { transform: translateX(6px); }
.endorsement-card .who { font-size: 13px; font-weight: 700; color: var(--navy); }
.endorsement-card .role { font-size: 11px; color: var(--grey); letter-spacing: 0.5px; margin-top: 2px; }
.endorsement-card .quote { font-size: 13px; color: #555; line-height: 1.65; margin-top: 8px; font-style: italic; }
.declaration-date { display: inline-flex; align-items: center; gap: 12px; background: var(--offwhite); padding: 14px 20px; margin-top: 24px; font-size: 13px; font-weight: 600; color: var(--navy); }
.declaration-date span { color: var(--gold); font-weight: 700; }

/* ── CTA FOOTER STRIP ── */
.page-cta { background: var(--navy-dark); padding: 60px; display: flex; align-items: center; justify-content: space-between; gap: 40px; }
.page-cta h2 { font-family: 'Playfair Display', serif; font-size: 30px; font-weight: 900; color: var(--white); }
.page-cta p { font-size: 15px; color: rgba(255,255,255,0.6); margin-top: 8px; max-width: 500px; }
.cta-buttons { display: flex; gap: 12px; flex-shrink: 0; }
.btn-gold-outline { display: inline-flex; align-items: center; gap: 8px; border: 2px solid var(--gold); color: var(--gold); padding: 14px 28px; font-weight: 700; font-size: 13px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; transition: all .2s; white-space: nowrap; }
.btn-gold-outline:hover { background: var(--gold); color: var(--navy-dark); }

/* ── FOOTER ── */
footer { background: var(--navy-dark); padding: 48px 60px 0; }
.footer-mini { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 40px; padding-bottom: 40px; border-bottom: 1px solid rgba(255,255,255,0.1); }
.footer-mini p { font-size: 13px; color: rgba(255,255,255,0.55); line-height: 1.8; margin-top: 12px; max-width: 300px; }
.footer-mini h4 { font-size: 10px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase; color: var(--gold); margin-bottom: 16px; }
.footer-mini ul { list-style: none; }
.footer-mini ul li { margin-bottom: 9px; }
.footer-mini ul li a { color: rgba(255,255,255,0.55); text-decoration: none; font-size: 13px; transition: color .2s; }
.footer-mini ul li a:hover { color: var(--white); }
.footer-bottom { padding: 20px 0; display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: rgba(255,255,255,0.35); }
.footer-bottom a { color: rgba(255,255,255,0.35); text-decoration: none; margin-left: 20px; }
.footer-bottom a:hover { color: var(--gold); }

/* ── BACK TO TOP ── */
.back-top { position: fixed; bottom: 32px; right: 32px; width: 46px; height: 46px; background: var(--gold); color: var(--navy-dark); display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700; cursor: pointer; opacity: 0; transition: opacity .3s; z-index: 999; text-decoration: none; }
.back-top.visible { opacity: 1; }

/* ── REVEAL ANIMATION ── */
.reveal { opacity: 0; transform: translateY(24px); transition: opacity .65s ease, transform .65s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-delay-1 { transition-delay: .1s; }
.reveal-delay-2 { transition-delay: .2s; }
</style>
</head>
<body>

<div class="top-bar">
  <a href="{{ route('login') }}">Portal Login</a>
  <a href="#">Careers</a>
  <a href="#">Media</a>
</div>

<!-- NAV -->
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

    <li>
      <a href="#">Events <span class="nav-arrow"></span></a>
      <div class="mega-menu">
        <div class="mega-col">
          <h4>General Events</h4>
          <ul>
            <li><a href="{{ route('official-board-events') }}">Official Board Events</a></li>
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

    <!-- SUSTAINABILITY — active page -->
    <li class="active">
      <a href="#">Sustainability <span class="nav-arrow"></span></a>
      <div class="mega-menu single-col">
        <div class="mega-col">
          <h4>Our Commitments</h4>
          <ul>
            <li><a href="{{ route('sustainability') }}#initiative" class="active-link">Sustainability Initiative</a></li>
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

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="hero-pattern"></div>
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span>›</span>
    <span class="current">Sustainability</span>
  </div>
  <div class="hero-inner">
    <h1>Our Sustainability <em>Commitments</em></h1>
    <p>YES – IEM Malaysia's formal framework for sustainable engineering practice. From grassroots initiatives to a binding declaration, we are committed to engineering a greener, more equitable ASEAN.</p>
  </div>
</div>

<!-- STICKY SECTION NAV -->
<nav class="section-nav" id="sectionNav">
  <a href="#initiative" class="active" data-section="initiative">
    <span class="section-nav-dot"></span> Initiative
  </a>
  <a href="#pledge" data-section="pledge">
    <span class="section-nav-dot"></span> Pledge
  </a>
  <a href="#declaration" data-section="declaration">
    <span class="section-nav-dot"></span> Declaration
  </a>
</nav>

<!-- ══════════════════════════════════
     SECTION 1 — SUSTAINABILITY INITIATIVE
═══════════════════════════════════ -->
<section class="content-section" id="initiative">
  <div class="section-label">Section 01</div>
  <h2 class="section-title">Sustainability <em>Initiative</em></h2>
  <div class="section-divider"></div>
  <p class="lead-text reveal">YES Malaysia's Sustainability Initiative is our structured, multi-year programme to embed environmental responsibility into every layer of engineering education, practice, and community engagement across the country.</p>

  <div class="initiative-grid">
    <div class="initiative-visual reveal reveal-delay-1">
      <div class="main-card">
        <span class="big-icon">🌿</span>
        <h3>A Greener Engineering Future</h3>
        <p>Launched in 2023, the YES Sustainability Initiative covers five pillars: carbon literacy, green design, community engineering, renewable energy access, and policy advocacy.</p>
      </div>
      <div class="stat-row">
        <div class="stat-box"><div class="num">30+</div><span class="lbl">Projects</span></div>
        <div class="stat-box"><div class="num">2,400</div><span class="lbl">Volunteers</span></div>
        <div class="stat-box"><div class="num">26</div><span class="lbl">States</span></div>
      </div>
    </div>

    <div class="initiative-content reveal reveal-delay-2">
      <p class="body-text">The initiative operates through five strategic pillars, each designed to build a generation of engineers who understand — and are empowered to address — the sustainability challenges of our time.</p>
      <ul class="pillar-list">
        <li>
          <div class="pillar-num">01</div>
          <div class="pillar-text"><h4>Carbon Literacy &amp; Education</h4><p>Training programmes and workshops that equip YES members with the knowledge to calculate, reduce, and offset their engineering footprint.</p></div>
        </li>
        <li>
          <div class="pillar-num">02</div>
          <div class="pillar-text"><h4>Green Design Integration</h4><p>Encouraging student and graduate engineers to incorporate sustainable design principles — LEED, BREEAM, MS1525 — into all professional projects.</p></div>
        </li>
        <li>
          <div class="pillar-num">03</div>
          <div class="pillar-text"><h4>Community &amp; Rural Engineering</h4><p>Deploying engineering skills to build resilient, clean-energy infrastructure in underserved communities across Peninsular Malaysia, Sabah, and Sarawak.</p></div>
        </li>
        <li>
          <div class="pillar-num">04</div>
          <div class="pillar-text"><h4>Renewable Energy Access</h4><p>Partnering with government agencies and NGOs to accelerate solar, hydro, and biomass energy deployment in off-grid communities.</p></div>
        </li>
        <li>
          <div class="pillar-num">05</div>
          <div class="pillar-text"><h4>Policy Advocacy</h4><p>Representing the youth engineering voice in national sustainability policy forums, contributing to Malaysia's National Energy Transition Roadmap.</p></div>
        </li>
      </ul>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════
     SECTION 2 — SUSTAINABILITY PLEDGE
═══════════════════════════════════ -->
<section class="content-section" id="pledge">
  <div class="section-label">Section 02</div>
  <h2 class="section-title">Sustainability <em>Pledge</em></h2>
  <div class="section-divider"></div>
  <p class="lead-text reveal">The YES Sustainability Pledge is a voluntary commitment made by our members and chapters. It is a personal and collective declaration of responsibility — an engineer's promise to the planet.</p>

  <div class="pledge-layout">
    <div class="pledge-document reveal reveal-delay-1">
      <div class="doc-label">The YES Sustainability Pledge</div>
      <p>I, as a member of the Young Engineer Section of the Institution of Engineers Malaysia, pledge to uphold the principles of sustainable engineering in all my professional and academic pursuits.</p>
      <p>I commit to designing, building, and advocating for solutions that respect environmental boundaries, serve communities equitably, and protect the planet for future generations of Malaysians and the global community.</p>
      <p>I recognise that engineers bear a unique responsibility to translate scientific knowledge into real-world action — and I accept this responsibility with humility, purpose, and resolve.</p>
      <p>I will continuously learn, collaborate, and innovate in the pursuit of a net-zero, resilient, and just Malaysia.</p>
      <div class="sig-line">
        <div class="sig-mark"><span>YES</span></div>
        <div class="sig-info">
          <small>Endorsed by</small>
          <strong>YES – IEM National Board, 2024</strong>
        </div>
      </div>
    </div>

    <div class="pledge-aside reveal reveal-delay-2">
      <h3>What the Pledge Commits You To</h3>
      <ul class="pledge-commitments">
        <li>
          <div class="pledge-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
          <p>Apply sustainable design principles in all professional engineering work and student projects.</p>
        </li>
        <li>
          <div class="pledge-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
          <p>Participate in at least one YES sustainability programme or volunteer event per year.</p>
        </li>
        <li>
          <div class="pledge-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
          <p>Advocate for green engineering standards within your institution or workplace.</p>
        </li>
        <li>
          <div class="pledge-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
          <p>Commit to continuous learning in sustainability, climate science, and green technology.</p>
        </li>
        <li>
          <div class="pledge-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
          <p>Share knowledge and mentor fellow engineers on sustainability best practices.</p>
        </li>
      </ul>
      <div class="pledge-cta">
        <a href="#" class="btn-navy">Sign the Pledge →</a>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════
     SECTION 3 — SUSTAINABILITY DECLARATION
═══════════════════════════════════ -->
<section class="content-section" id="declaration">
  <div class="section-label">Section 03</div>
  <h2 class="section-title">Sustainability <em>Declaration</em></h2>
  <div class="section-divider"></div>
  <p class="lead-text reveal">The YES Malaysia Sustainability Declaration is our formal, institutional statement of intent — adopted by the YES National Board and endorsed by chapter leaders across all 26 state branches in 2024.</p>

  <div class="declaration-hero-bar reveal">
    <div>
      <h3>YES Malaysia Sustainability Declaration 2024</h3>
      <p>Formally adopted at the YES National Board Meeting, Putrajaya, 14 September 2024.</p>
    </div>
    <a href="#" class="btn-gold-solid">Download Declaration (PDF) ↓</a>
  </div>

  <div class="declaration-body">
    <div class="declaration-text reveal reveal-delay-1">
      <div class="statement-block">
        <h4>Preamble</h4>
        <p>The Young Engineer Section of IEM Malaysia acknowledges that climate change, biodiversity loss, and resource depletion represent the defining engineering challenges of this generation. We accept our responsibility to act — not merely as professionals, but as citizens of Malaysia and the global community.</p>
      </div>
      <div class="statement-block">
        <h4>Our Commitment to Net-Zero</h4>
        <p>YES Malaysia commits to supporting Malaysia's national net-zero target by 2050 through engineering education, community programmes, and policy engagement. We will track and report our collective progress annually.</p>
      </div>
      <div class="statement-block">
        <h4>Our Commitment to Equity</h4>
        <p>We recognise that the transition to a sustainable economy must be just and inclusive. YES will ensure that sustainability programmes prioritise underserved communities in both rural and urban settings.</p>
      </div>
      <div class="statement-block">
        <h4>Our Commitment to Collaboration</h4>
        <p>YES Malaysia will actively partner with government bodies, industry, universities, and civil society to amplify our impact — recognising that sustainable development requires cross-sector collaboration.</p>
      </div>
      <div class="declaration-date">
        Adopted: <span>14 September 2024</span> &nbsp;|&nbsp; Signatories: <span>26 Chapter Chairs</span>
      </div>
    </div>

    <div class="declaration-endorsements reveal reveal-delay-2">
      <h3>Endorsed By</h3>
      <div class="endorsement-card">
        <div class="who">Dr. Ahmad Faizal Ibrahim</div>
        <div class="role">YES National Chairman 2024–2025</div>
        <p class="quote">"This declaration is not just a document — it is our generation's promise to the engineers who will come after us."</p>
      </div>
      <div class="endorsement-card">
        <div class="who">Ir. Nurul Ain Zainudin</div>
        <div class="role">YES Sustainability Committee Chair</div>
        <p class="quote">"We have the tools, the talent, and now the mandate. Malaysian engineers will lead the transition to a greener ASEAN."</p>
      </div>
      <div class="endorsement-card">
        <div class="who">Ir. Mohd Hafiz Rashid</div>
        <div class="role">YES Sabah &amp; Sarawak Representative</div>
        <p class="quote">"For our forests, our rivers, and our communities — we stand together on this declaration."</p>
      </div>
    </div>
  </div>
</section>

<!-- PAGE CTA -->
<div class="page-cta">
  <div>
    <h2>Ready to Join the Movement?</h2>
    <p>Sign the pledge, volunteer at a YES green event, or contact us to partner on a sustainability programme in your community.</p>
  </div>
  <div class="cta-buttons">
    <a href="#pledge" class="btn-gold-solid">Sign the Pledge</a>
    <a href="{{ route('sustainability-events') }}" class="btn-gold-outline">View Green Events</a>
  </div>
</div>

<!-- FOOTER -->
<footer>
  <div class="footer-mini">
    <div>
      <a href="{{ route('home') }}" style="display:inline-block;margin-bottom:14px;">
        <img src="{{ asset('images/iem-yes-logo.png') }}" alt="IEM Young Engineers Section" style="height:44px;width:auto;display:block;"/>
      </a>
      <p>Young Engineer Section (YES) — the youth arm of the Institution of Engineers Malaysia (IEM), empowering the next generation of engineering professionals since 1987.</p>
    </div>
    <div>
      <h4>Sustainability</h4>
      <ul>
        <li><a href="{{ route('sustainability') }}#initiative">Sustainability Initiative</a></li>
        <li><a href="{{ route('sustainability') }}#pledge">Sustainability Pledge</a></li>
        <li><a href="{{ route('sustainability') }}#declaration">Sustainability Declaration</a></li>
        <li><a href="{{ route('sustainability-events') }}">Sustainability Events</a></li>
      </ul>
    </div>
    <div>
      <h4>Quick Links</h4>
      <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('who-we-are') }}">About YES</a></li>
        <li><a href="{{ route('official-board-events') }}">Events</a></li>
        <li><a href="{{ route('natsum') }}">NATSUM</a></li>
        <li><a href="{{ route('cafeo') }}">CAFEO</a></li>
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
// ── Scroll reveal ──
const obs = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.08 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

// ── Sticky section nav active state ──
const sections = ['initiative', 'pledge', 'declaration'];
const navLinks  = document.querySelectorAll('.section-nav a');

function updateActiveNav() {
  let current = 'initiative';
  sections.forEach(id => {
    const el = document.getElementById(id);
    if (el && window.scrollY >= el.offsetTop - 200) current = id;
  });
  navLinks.forEach(a => a.classList.toggle('active', a.dataset.section === current));
}
window.addEventListener('scroll', updateActiveNav, { passive: true });
updateActiveNav();

// ── Back to top ──
window.addEventListener('scroll', () => {
  document.getElementById('backTop').classList.toggle('visible', window.scrollY > 300);
});
</script>
</body>
</html>