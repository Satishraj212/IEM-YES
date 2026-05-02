<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Who We Are – YES Young Engineer Section | IEM Malaysia</title>
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

/* ── MEGA MENU — overflow fix ── */
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

/* ── STATS STRIP (moved to top) ── */
.stats-strip { background: var(--navy); padding: 36px 60px; display: grid; grid-template-columns: repeat(4, 1fr); }
.stat-item { text-align: center; padding: 12px 0; border-right: 1px solid rgba(255,255,255,0.12); }
.stat-item:last-child { border-right: none; }
.stat-item .num { font-family: 'Playfair Display', serif; font-size: 38px; font-weight: 900; color: var(--gold); display: block; line-height: 1; }
.stat-item .label { font-size: 12px; color: rgba(255,255,255,0.65); letter-spacing: 1.5px; text-transform: uppercase; margin-top: 6px; display: block; }

/* ── PAGE HERO ── */
.page-hero { background: var(--navy-dark); padding: 80px 60px 60px; position: relative; overflow: hidden; }
.page-hero::before { content: ''; position: absolute; top: -80px; right: -80px; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(200,168,75,0.06) 0%, transparent 70%); }
.page-hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--gold) 0%, transparent 60%); }
.breadcrumb { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; font-size: 12px; letter-spacing: 1.5px; text-transform: uppercase; }
.breadcrumb a { color: rgba(255,255,255,0.5); text-decoration: none; transition: color .2s; }
.breadcrumb a:hover { color: var(--gold); }
.breadcrumb span { color: rgba(255,255,255,0.25); }
.breadcrumb .current { color: var(--gold); }
.page-hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(36px, 4vw, 58px); color: var(--white); font-weight: 900; line-height: 1.1; max-width: 700px; }
.page-hero h1 em { color: var(--gold); font-style: normal; }

/* ── IN-PAGE ANCHORS NAV ── */
.anchor-nav { background: var(--offwhite); border-bottom: 2px solid var(--light-grey); position: sticky; top: 72px; z-index: 900; display: flex; gap: 0; padding: 0 60px; }
.anchor-btn { padding: 18px 28px; font-size: 13px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--grey); text-decoration: none; border-bottom: 3px solid transparent; transition: all .2s; white-space: nowrap; }
.anchor-btn:hover { color: var(--navy); }
.anchor-btn.active { color: var(--navy); border-bottom-color: var(--gold); }

/* ── SECTION SHARED ── */
.content-section { padding: 90px 60px; }
.content-section.alt { background: var(--offwhite); }
.section-label { font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 10px; }
.section-title { font-family: 'Playfair Display', serif; font-size: clamp(28px, 3vw, 44px); color: var(--navy); font-weight: 900; line-height: 1.15; }
.section-title em { color: var(--gold); font-style: normal; }
.divider { width: 60px; height: 3px; background: var(--gold); margin: 20px 0 36px; }

/* ── VISION & MISSION ── */
#vision-mission .vm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 3px; margin-top: 52px; }
.vm-card { padding: 52px 48px; position: relative; overflow: hidden; }
.vm-card.vision { background: var(--navy); }
.vm-card.mission { background: var(--navy-dark); }
.vm-card::before { content: ''; position: absolute; top: -60px; right: -60px; width: 220px; height: 220px; border-radius: 50%; background: radial-gradient(circle, rgba(200,168,75,0.08) 0%, transparent 70%); }
.vm-icon { width: 56px; height: 56px; border: 2px solid var(--gold); display: flex; align-items: center; justify-content: center; margin-bottom: 24px; }
.vm-icon svg { width: 26px; height: 26px; stroke: var(--gold); fill: none; stroke-width: 1.5; }
.vm-card h2 { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 900; color: var(--gold); margin-bottom: 20px; }
.vm-card p { font-size: 16px; color: rgba(255,255,255,0.82); line-height: 1.9; font-weight: 300; }
.vm-card .highlight-text { font-family: 'Playfair Display', serif; font-size: 22px; color: var(--white); font-style: italic; line-height: 1.5; margin-bottom: 16px; border-left: 3px solid var(--gold); padding-left: 20px; }

/* ── VALUES ── */
#values .values-intro { max-width: 680px; margin-bottom: 56px; }
.values-intro p { font-size: 16px; color: var(--grey); line-height: 1.8; margin-top: 12px; }
.values-hexgrid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 3px; }
.value-block { background: var(--white); padding: 44px 36px; border-bottom: 3px solid transparent; transition: all .35s cubic-bezier(.2,.8,.3,1); cursor: default; }
.value-block:hover { border-bottom-color: var(--gold); background: var(--navy); transform: translateY(-4px); box-shadow: 0 20px 50px rgba(0,31,69,0.15); }
.val-number { font-family: 'Playfair Display', serif; font-size: 52px; font-weight: 900; color: var(--light-grey); line-height: 1; margin-bottom: 16px; transition: color .35s; }
.value-block:hover .val-number { color: rgba(200,168,75,0.25); }
.val-icon { width: 44px; height: 44px; background: var(--offwhite); display: flex; align-items: center; justify-content: center; margin-bottom: 16px; transition: background .35s; }
.value-block:hover .val-icon { background: rgba(200,168,75,0.15); }
.val-icon svg { width: 22px; height: 22px; stroke: var(--navy); fill: none; stroke-width: 1.5; transition: stroke .35s; }
.value-block:hover .val-icon svg { stroke: var(--gold); }
.val-title { font-size: 19px; font-weight: 700; color: var(--navy); margin-bottom: 10px; transition: color .35s; }
.value-block:hover .val-title { color: var(--white); }
.val-desc { font-size: 13.5px; color: var(--grey); line-height: 1.75; transition: color .35s; }
.value-block:hover .val-desc { color: rgba(255,255,255,0.68); }

/* ── WHERE WE ARE ── */
#where-we-are .where-intro { max-width: 680px; margin-bottom: 56px; }
.where-intro p { font-size: 16px; color: var(--grey); line-height: 1.8; margin-top: 12px; }
.malaysia-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: start; }
.map-container { position: relative; }
.map-visual { width: 100%; background: var(--navy); aspect-ratio: 4/3; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
.map-visual::before { content: 'MALAYSIA'; position: absolute; font-family: 'Playfair Display', serif; font-size: 80px; font-weight: 900; color: rgba(255,255,255,0.03); letter-spacing: 10px; }
.map-legend { margin-top: 16px; display: flex; gap: 20px; font-size: 12px; color: var(--grey); }
.map-legend span { display: flex; align-items: center; gap: 6px; }
.legend-dot { width: 10px; height: 10px; border-radius: 50%; }
.legend-dot.hq { background: var(--gold-light); }
.legend-dot.branch { background: var(--gold); }
.branches-list { display: flex; flex-direction: column; gap: 0; }
.branch-region { border-bottom: 1px solid var(--light-grey); }
.branch-region-header { display: flex; align-items: center; justify-content: space-between; padding: 18px 0; cursor: pointer; user-select: none; }
.branch-region-header h3 { font-size: 15px; font-weight: 700; color: var(--navy); letter-spacing: 0.3px; }
.branch-region-header .count { font-size: 11px; background: var(--navy); color: var(--gold); padding: 3px 10px; font-weight: 700; letter-spacing: 1px; }
.branch-region-header .chevron { font-size: 11px; color: var(--gold); transition: transform .25s; }
.branch-region.open .chevron { transform: rotate(180deg); }
.branch-items { display: none; padding-bottom: 14px; }
.branch-region.open .branch-items { display: flex; flex-wrap: wrap; gap: 8px; }
.branch-tag { background: var(--offwhite); color: var(--navy); padding: 6px 14px; font-size: 12px; font-weight: 500; border: 1px solid var(--light-grey); transition: all .2s; }
.branch-tag:hover { background: var(--navy); color: var(--gold); border-color: var(--navy); }
.branch-tag.hq { background: var(--navy); color: var(--gold); border-color: var(--navy); }

/* ── SCROLL ANIMATIONS ── */
.reveal { opacity: 0; transform: translateY(30px); transition: opacity .7s ease, transform .7s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-delay-1 { transition-delay: .1s; }
.reveal-delay-2 { transition-delay: .2s; }
.reveal-delay-3 { transition-delay: .3s; }
.reveal-delay-4 { transition-delay: .4s; }
.reveal-delay-5 { transition-delay: .5s; }

/* ── BACK TO TOP ── */
.back-top { position: fixed; bottom: 32px; right: 32px; width: 46px; height: 46px; background: var(--gold); color: var(--navy-dark); display: flex; align-items: center; justify-content: center; font-size: 20px; cursor: pointer; opacity: 0; transition: opacity .3s; z-index: 999; text-decoration: none; font-weight: 700; }
.back-top.visible { opacity: 1; }

/* ── FOOTER ── */
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
</style>
</head>
<body>

<!-- TOP BAR -->
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

    <!-- ABOUT US — active -->
    <li class="active">
      <a href="#">About Us <span class="nav-arrow"></span></a>
      <div class="mega-menu">
        <div class="mega-col">
          <h4>Who We Are</h4>
          <ul>
            <li><a href="{{ route('who-we-are') }}#vision-mission" class="active-link">Mission &amp; Vision</a></li>
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

    <!-- EVENTS -->
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

    <!-- AWARDS -->
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

    <!-- SUSTAINABILITY -->
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

    <!-- CONTACT US -->
    <li><a href="{{ route('home') }}#footer">Contact Us</a></li>

  </ul>
</nav>

<!-- STATS STRIP — moved to top -->
<div class="stats-strip">
  <div class="stat-item"><span class="num">26</span><span class="label">State Branches</span></div>
  <div class="stat-item"><span class="num">12,000+</span><span class="label">Active Members</span></div>
  <div class="stat-item"><span class="num">38+</span><span class="label">Universities Covered</span></div>
  <div class="stat-item"><span class="num">150+</span><span class="label">Events Per Year</span></div>
</div>

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span>›</span>
    <a href="#">About Us</a>
    <span>›</span>
    <span class="current">Who We Are</span>
  </div>
  <h1>Who We <em>Are</em></h1>
</div>

<!-- ANCHOR NAV -->
<nav class="anchor-nav" id="anchorNav">
  <a href="#vision-mission" class="anchor-btn active">Vision &amp; Mission</a>
  <a href="#values" class="anchor-btn">Values</a>
  <a href="#where-we-are" class="anchor-btn">Where We Are</a>
</nav>

<!-- ════════════════════════════════════════
     SECTION 1 — VISION & MISSION
═══════════════════════════════════════════ -->
<section class="content-section" id="vision-mission">
  <div class="section-label reveal">About YES – IEM</div>
  <h2 class="section-title reveal">Our Vision &amp; <em>Mission</em></h2>
  <div class="divider reveal"></div>

  <div class="vm-grid reveal">
    <div class="vm-card vision">
      <div class="vm-icon">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/></svg>
      </div>
      <h2>Vision</h2>
      <p class="highlight-text">"To be the leading voice and champion for young engineers in Malaysia."</p>
      <p>YES aspires to be the foremost platform that inspires, connects, and elevates young engineers — creating a generation of professionals who lead with technical excellence, ethical responsibility, and a commitment to nation-building.</p>
    </div>
    <div class="vm-card mission">
      <div class="vm-icon">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      </div>
      <h2>Mission</h2>
      <p class="highlight-text">"Empowering young engineers through engagement, education, and excellence."</p>
      <p>We are committed to providing meaningful platforms for professional development, fostering a strong engineering community, advocating for young engineers' interests within IEM and the industry, and driving sustainable impact through technical leadership and community service.</p>
    </div>
  </div>

  <!-- Objectives -->
  <div style="margin-top:52px;display:grid;grid-template-columns:repeat(3,1fr);gap:3px;">
    <div class="reveal reveal-delay-1" style="background:var(--offwhite);padding:36px 30px;border-top:3px solid var(--gold);">
      <div style="font-family:'Playfair Display',serif;font-size:44px;color:var(--light-grey);font-weight:900;margin-bottom:12px;">01</div>
      <h3 style="font-size:17px;font-weight:700;color:var(--navy);margin-bottom:10px;">Professional Development</h3>
      <p style="font-size:13.5px;color:var(--grey);line-height:1.75;">Provide workshops, seminars, and mentorship to upskill young engineers entering the workforce.</p>
    </div>
    <div class="reveal reveal-delay-2" style="background:var(--offwhite);padding:36px 30px;border-top:3px solid var(--navy);">
      <div style="font-family:'Playfair Display',serif;font-size:44px;color:var(--light-grey);font-weight:900;margin-bottom:12px;">02</div>
      <h3 style="font-size:17px;font-weight:700;color:var(--navy);margin-bottom:10px;">Community &amp; Network</h3>
      <p style="font-size:13.5px;color:var(--grey);line-height:1.75;">Build a thriving nationwide network of engineers who collaborate, support each other, and grow together.</p>
    </div>
    <div class="reveal reveal-delay-3" style="background:var(--offwhite);padding:36px 30px;border-top:3px solid var(--gold);">
      <div style="font-family:'Playfair Display',serif;font-size:44px;color:var(--light-grey);font-weight:900;margin-bottom:12px;">03</div>
      <h3 style="font-size:17px;font-weight:700;color:var(--navy);margin-bottom:10px;">National Advocacy</h3>
      <p style="font-size:13.5px;color:var(--grey);line-height:1.75;">Represent the interests of young engineers in national policy dialogue, industry standards, and IEM governance.</p>
    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     SECTION 2 — VALUES
═══════════════════════════════════════════ -->
<section class="content-section alt" id="values">
  <div class="values-intro">
    <div class="section-label reveal">What We Stand For</div>
    <h2 class="section-title reveal">Our Core <em>Values</em></h2>
    <div class="divider reveal"></div>
    <p class="reveal">Everything YES does is guided by six core values — the principles that define who we are, how we work, and what we stand for as Malaysia's premier platform for young engineers.</p>
  </div>

  <div class="values-hexgrid">
    <div class="value-block reveal reveal-delay-1">
      <div class="val-number">01</div>
      <div class="val-icon"><svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
      <div class="val-title">Excellence</div>
      <div class="val-desc">We hold ourselves to the highest standard in everything — from the events we organise to the professionals we cultivate. Mediocrity is not in our vocabulary.</div>
    </div>
    <div class="value-block reveal reveal-delay-2">
      <div class="val-number">02</div>
      <div class="val-icon"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
      <div class="val-title">Integrity</div>
      <div class="val-desc">We act with honesty, transparency, and accountability in all our dealings — upholding the ethical standards expected of engineering professionals.</div>
    </div>
    <div class="value-block reveal reveal-delay-3">
      <div class="val-number">03</div>
      <div class="val-icon"><svg viewBox="0 0 24 24"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg></div>
      <div class="val-title">Innovation</div>
      <div class="val-desc">We embrace new ideas, technologies, and approaches — encouraging young engineers to think creatively and lead change in the industry.</div>
    </div>
    <div class="value-block reveal reveal-delay-1">
      <div class="val-number">04</div>
      <div class="val-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
      <div class="val-title">Inclusivity</div>
      <div class="val-desc">We welcome engineers of all backgrounds, disciplines, and stages of career. YES is a home for every young engineer in Malaysia.</div>
    </div>
    <div class="value-block reveal reveal-delay-2">
      <div class="val-number">05</div>
      <div class="val-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg></div>
      <div class="val-title">Collaboration</div>
      <div class="val-desc">We believe engineering is a team sport. By fostering partnerships across universities, industries, and institutions, we achieve more together.</div>
    </div>
    <div class="value-block reveal reveal-delay-3">
      <div class="val-number">06</div>
      <div class="val-icon"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
      <div class="val-title">Sustainability</div>
      <div class="val-desc">We champion engineering solutions that are environmentally responsible and socially conscious, ensuring a better Malaysia for future generations.</div>
    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     SECTION 3 — WHERE WE ARE
═══════════════════════════════════════════ -->
<section class="content-section" id="where-we-are">
  <div class="where-intro">
    <div class="section-label reveal">Our Presence</div>
    <h2 class="section-title reveal">Where We <em>Are</em></h2>
    <div class="divider reveal"></div>
    <p class="reveal">YES – IEM operates nationwide, with an active HQ in Kuala Lumpur and branches spanning every state in Peninsular Malaysia, Sabah, and Sarawak. Our reach covers over 12,000 members across universities and engineering firms.</p>
  </div>

  <div class="malaysia-layout reveal">
    <div class="map-container">
      <div class="map-visual">
        <svg viewBox="0 0 480 300" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:100%;position:absolute;inset:0;">
          <path d="M80,60 L120,40 L170,35 L210,45 L230,60 L250,80 L260,110 L255,140 L240,165 L225,180 L200,200 L175,205 L150,195 L130,185 L110,165 L90,140 L75,110 L70,80 Z" fill="rgba(255,255,255,0.05)" stroke="rgba(200,168,75,0.3)" stroke-width="1.5"/>
          <path d="M330,50 L390,45 L420,65 L410,90 L380,100 L350,95 L325,80 Z" fill="rgba(255,255,255,0.05)" stroke="rgba(200,168,75,0.3)" stroke-width="1.5"/>
          <path d="M270,90 L340,80 L360,100 L350,130 L320,150 L285,155 L265,135 L255,110 Z" fill="rgba(255,255,255,0.05)" stroke="rgba(200,168,75,0.3)" stroke-width="1.5"/>
          <circle cx="175" cy="120" r="8" fill="#e8c96a" opacity="0.9"/>
          <circle cx="175" cy="120" r="14" fill="rgba(232,201,106,0.2)"/>
          <circle cx="175" cy="120" r="20" fill="rgba(232,201,106,0.1)"/>
          <text x="190" y="116" fill="#e8c96a" font-size="9" font-family="DM Sans,sans-serif" font-weight="700">HQ – KUALA LUMPUR</text>
          <circle cx="120" cy="70" r="5" fill="#c8a84b" opacity="0.85"/>
          <text x="130" y="68" fill="rgba(255,255,255,0.6)" font-size="8" font-family="DM Sans,sans-serif">PENANG</text>
          <circle cx="195" cy="192" r="5" fill="#c8a84b" opacity="0.85"/>
          <text x="205" y="190" fill="rgba(255,255,255,0.6)" font-size="8" font-family="DM Sans,sans-serif">JOHOR</text>
          <circle cx="145" cy="90" r="5" fill="#c8a84b" opacity="0.85"/>
          <text x="128" y="88" fill="rgba(255,255,255,0.6)" font-size="8" font-family="DM Sans,sans-serif">PERAK</text>
          <circle cx="215" cy="105" r="5" fill="#c8a84b" opacity="0.85"/>
          <text x="222" y="103" fill="rgba(255,255,255,0.6)" font-size="8" font-family="DM Sans,sans-serif">PAHANG</text>
          <circle cx="375" cy="68" r="5" fill="#c8a84b" opacity="0.85"/>
          <text x="382" y="66" fill="rgba(255,255,255,0.6)" font-size="8" font-family="DM Sans,sans-serif">SABAH</text>
          <circle cx="310" cy="118" r="5" fill="#c8a84b" opacity="0.85"/>
          <text x="318" y="116" fill="rgba(255,255,255,0.6)" font-size="8" font-family="DM Sans,sans-serif">SARAWAK</text>
          <circle cx="205" cy="55" r="5" fill="#c8a84b" opacity="0.85"/>
          <text x="212" y="53" fill="rgba(255,255,255,0.6)" font-size="8" font-family="DM Sans,sans-serif">KELANTAN</text>
        </svg>
      </div>
      <div class="map-legend">
        <span><div class="legend-dot hq"></div> YES HQ</span>
        <span><div class="legend-dot branch"></div> State Branch</span>
      </div>
    </div>

    <div>
      <div style="margin-bottom:24px;">
        <div style="font-size:13px;color:var(--grey);line-height:1.8;">YES currently operates <strong style="color:var(--navy)">26 active branches</strong> nationwide — click each region to see the branches.</div>
      </div>
      <div class="branches-list">
        <div class="branch-region open">
          <div class="branch-region-header" onclick="toggleBranch(this)">
            <h3>Klang Valley &amp; Selangor</h3>
            <div style="display:flex;gap:10px;align-items:center;"><span class="count">HQ + 3 Branches</span><span class="chevron">▲</span></div>
          </div>
          <div class="branch-items">
            <span class="branch-tag hq">YES HQ – Putrajaya</span>
            <span class="branch-tag">Klang Valley</span>
            <span class="branch-tag">Shah Alam</span>
            <span class="branch-tag">Subang Jaya</span>
          </div>
        </div>
        <div class="branch-region">
          <div class="branch-region-header" onclick="toggleBranch(this)">
            <h3>Northern Region</h3>
            <div style="display:flex;gap:10px;align-items:center;"><span class="count">4 Branches</span><span class="chevron">▼</span></div>
          </div>
          <div class="branch-items">
            <span class="branch-tag">Penang</span>
            <span class="branch-tag">Perak</span>
            <span class="branch-tag">Kedah</span>
            <span class="branch-tag">Perlis</span>
          </div>
        </div>
        <div class="branch-region">
          <div class="branch-region-header" onclick="toggleBranch(this)">
            <h3>Southern Region</h3>
            <div style="display:flex;gap:10px;align-items:center;"><span class="count">3 Branches</span><span class="chevron">▼</span></div>
          </div>
          <div class="branch-items">
            <span class="branch-tag">Johor Bahru</span>
            <span class="branch-tag">Melaka</span>
            <span class="branch-tag">Negeri Sembilan</span>
          </div>
        </div>
        <div class="branch-region">
          <div class="branch-region-header" onclick="toggleBranch(this)">
            <h3>East Coast</h3>
            <div style="display:flex;gap:10px;align-items:center;"><span class="count">3 Branches</span><span class="chevron">▼</span></div>
          </div>
          <div class="branch-items">
            <span class="branch-tag">Pahang</span>
            <span class="branch-tag">Terengganu</span>
            <span class="branch-tag">Kelantan</span>
          </div>
        </div>
        <div class="branch-region">
          <div class="branch-region-header" onclick="toggleBranch(this)">
            <h3>East Malaysia</h3>
            <div style="display:flex;gap:10px;align-items:center;"><span class="count">3 Branches</span><span class="chevron">▼</span></div>
          </div>
          <div class="branch-items">
            <span class="branch-tag">Sabah</span>
            <span class="branch-tag">Sarawak (Kuching)</span>
            <span class="branch-tag">Sarawak (Miri)</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-mini">
    <div>
      <img src="{{ asset('images/iem-yes-logo.png') }}" alt="IEM Young Engineers Section" style="height:44px;width:auto;display:block;margin-bottom:16px;"/>
      <p>Young Engineer Section (YES) — the youth arm of the Institution of Engineers Malaysia (IEM), empowering the next generation of engineering professionals since 1987.</p>
    </div>
    <div>
      <h4>Who We Are</h4>
      <ul>
        <li><a href="{{ route('who-we-are') }}#vision-mission">Vision &amp; Mission</a></li>
        <li><a href="{{ route('who-we-are') }}#values">Values</a></li>
        <li><a href="{{ route('who-we-are') }}#where-we-are">Where We Are</a></li>
        <li><a href="{{ route('milestone') }}">Milestones</a></li>
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
function toggleBranch(header) {
  const region = header.parentElement;
  const isOpen = region.classList.contains('open');
  document.querySelectorAll('.branch-region').forEach(r => {
    r.classList.remove('open');
    r.querySelector('.chevron').textContent = '▼';
  });
  if (!isOpen) {
    region.classList.add('open');
    header.querySelector('.chevron').textContent = '▲';
  }
}

const reveals = document.querySelectorAll('.reveal');
const obs = new IntersectionObserver(entries => {
  entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
reveals.forEach(el => obs.observe(el));

const anchorBtns = document.querySelectorAll('.anchor-btn');
const sections = ['vision-mission','values','where-we-are'].map(id => document.getElementById(id));
window.addEventListener('scroll', () => {
  let current = '';
  sections.forEach(sec => {
    if (sec && window.scrollY >= sec.offsetTop - 160) current = sec.id;
  });
  anchorBtns.forEach(btn => {
    btn.classList.toggle('active', btn.getAttribute('href') === '#' + current);
  });
  document.getElementById('backTop').classList.toggle('visible', window.scrollY > 300);
});

document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const id = a.getAttribute('href').slice(1);
    const el = document.getElementById(id);
    if (el) { e.preventDefault(); el.scrollIntoView({ behavior: 'smooth' }); }
  });
});

if (location.hash) {
  setTimeout(() => {
    const el = document.querySelector(location.hash);
    if (el) el.scrollIntoView({ behavior: 'smooth' });
  }, 100);
}
</script>
</body>
</html>