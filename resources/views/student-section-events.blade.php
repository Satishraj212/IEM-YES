<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Student Section Events – YES Young Engineer Section | IEM Malaysia</title>
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

.page-hero { background: linear-gradient(135deg, var(--navy-dark) 0%, #0a3060 100%); padding: 72px 60px 52px; position: relative; overflow: hidden; }
.page-hero::before { content: ''; position: absolute; top: -80px; right: -80px; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(200,168,75,0.08) 0%, transparent 70%); }
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
.hero-stats { display: flex; gap: 40px; flex-shrink: 0; }
.hero-stat { text-align: center; }
.hero-stat .big { font-family: 'Playfair Display', serif; font-size: 42px; font-weight: 900; color: var(--gold); line-height: 1; }
.hero-stat .lbl { font-size: 10px; color: rgba(255,255,255,0.5); letter-spacing: 2px; text-transform: uppercase; margin-top: 4px; }

.category-bar { background: var(--offwhite); border-bottom: 2px solid var(--light-grey); padding: 16px 60px; display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; }
.category-pills { display: flex; gap: 8px; flex-wrap: wrap; }
.pill { padding: 8px 18px; font-size: 12px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; border: 1.5px solid var(--light-grey); background: var(--white); color: var(--grey); cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; }
.pill:hover { border-color: var(--navy); color: var(--navy); }
.pill.active { background: var(--navy); color: var(--gold); border-color: var(--navy); }
.filter-right { display: flex; align-items: center; gap: 12px; }
.search-box { display: flex; align-items: center; gap: 8px; background: var(--white); border: 1px solid var(--light-grey); padding: 8px 14px; }
.search-box input { border: none; outline: none; font-family: 'DM Sans', sans-serif; font-size: 13px; color: #222; background: transparent; width: 180px; }
.search-box svg { width: 15px; height: 15px; stroke: var(--grey); fill: none; stroke-width: 2; flex-shrink: 0; }
.sort-select { border: 1px solid var(--light-grey); background: var(--white); padding: 8px 12px; font-family: 'DM Sans', sans-serif; font-size: 12px; font-weight: 600; color: var(--navy); cursor: pointer; outline: none; }

.results-info { padding: 20px 60px 0; font-size: 13px; color: var(--grey); }
.results-info strong { color: var(--navy); }

.events-body { padding: 28px 60px 80px; }
.events-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; margin-bottom: 52px; }

.event-card { background: var(--white); border: 1px solid var(--light-grey); overflow: hidden; transition: transform .3s, box-shadow .3s; display: flex; flex-direction: column; }
.event-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(0,31,69,0.12); border-color: rgba(200,168,75,0.3); }
.card-img { height: 210px; position: relative; overflow: hidden; flex-shrink: 0; }
.card-img-inner { width: 100%; height: 100%; background-size: cover; background-position: center; transition: transform .5s; }
.event-card:hover .card-img-inner { transform: scale(1.06); }
.card-badge { position: absolute; top: 14px; left: 14px; background: var(--gold); color: var(--navy-dark); font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 5px 12px; }
.card-status { position: absolute; top: 14px; right: 14px; font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 5px 12px; }
.status-open { background: #1a6b3c; color: #a8e6c1; }
.status-upcoming { background: var(--navy-dark); color: rgba(255,255,255,0.7); }
.status-closed { background: #6b2222; color: #e6a8a8; }
.card-category { position: absolute; bottom: 14px; left: 14px; font-size: 9px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 4px 10px; }
.cat-hackathon { background: rgba(74,26,107,0.85); color: #c4a8e6; }
.cat-career { background: rgba(0,51,102,0.85); color: var(--gold-light); }
.cat-webinar { background: rgba(26,107,60,0.85); color: #a8e6c1; }
.cat-workshop { background: rgba(107,63,26,0.85); color: #e6c87a; }
.cat-competition { background: rgba(107,26,26,0.85); color: #e6a8a8; }
.card-body { padding: 22px 22px 18px; flex: 1; display: flex; flex-direction: column; }
.card-meta { display: flex; align-items: center; gap: 14px; margin-bottom: 10px; flex-wrap: wrap; }
.card-date { font-size: 11px; color: var(--gold); font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
.card-location { font-size: 11px; color: var(--grey); display: flex; align-items: center; gap: 4px; }
.card-location svg { width: 11px; height: 11px; stroke: var(--grey); fill: none; stroke-width: 2; }
.card-body h3 { font-size: 17px; font-weight: 700; color: var(--navy); line-height: 1.3; margin-bottom: 10px; }
.card-body p { font-size: 13px; color: var(--grey); line-height: 1.7; flex: 1; }
.card-tags { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 12px; }
.tag { font-size: 10px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; padding: 3px 8px; background: var(--offwhite); color: var(--navy); border: 1px solid var(--light-grey); }
.card-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 16px; padding-top: 14px; border-top: 1px solid var(--light-grey); }
.card-seats { font-size: 11px; color: var(--grey); }
.card-seats strong { color: var(--navy); font-weight: 700; }
.card-cta { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--navy); text-decoration: none; border-bottom: 2px solid var(--gold); padding-bottom: 1px; transition: color .2s; }
.card-cta:hover { color: var(--gold); }

.pagination { display: flex; align-items: center; justify-content: center; gap: 4px; }
.page-btn { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--light-grey); background: var(--white); font-size: 13px; font-weight: 600; color: var(--navy); cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; text-decoration: none; }
.page-btn:hover { background: var(--offwhite); border-color: var(--navy); }
.page-btn.active { background: var(--navy); color: var(--gold); border-color: var(--navy); }
.page-btn.arrow { font-size: 16px; color: var(--grey); }
.page-info { font-size: 13px; color: var(--grey); margin: 0 16px; }

.no-results { grid-column: span 3; text-align: center; padding: 80px 20px; display: none; flex-direction: column; align-items: center; }
.no-results svg { width: 52px; height: 52px; stroke: var(--light-grey); fill: none; stroke-width: 1.5; margin-bottom: 20px; }
.no-results h3 { font-size: 20px; font-weight: 700; color: var(--navy); margin-bottom: 8px; }
.no-results p { font-size: 14px; color: var(--grey); }

.reveal { opacity: 0; transform: translateY(24px); transition: opacity .6s ease, transform .6s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-delay-1 { transition-delay: .08s; } .reveal-delay-2 { transition-delay: .16s; }
.reveal-delay-3 { transition-delay: .24s; } .reveal-delay-4 { transition-delay: .32s; }
.reveal-delay-5 { transition-delay: .40s; }

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

.bg-s1 { background: linear-gradient(135deg, #1a3a6b 0%, #2460a7 100%); }
.bg-s2 { background: linear-gradient(135deg, #0d4a2b 0%, #2d8a55 100%); }
.bg-s3 { background: linear-gradient(135deg, #4a1a6b 0%, #7a44a7 100%); }
.bg-s4 { background: linear-gradient(135deg, #6b1a1a 0%, #a74424 100%); }
.bg-s5 { background: linear-gradient(135deg, #1a5a6b 0%, #2490a7 100%); }
.bg-s6 { background: linear-gradient(135deg, #3a6b1a 0%, #6ba724 100%); }
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
            <li><a href="{{ route('official-board-events') }}">Official Board Events</a></li>
            <li><a href="{{ route('student-section-events') }}" class="active-link">Student Section Events</a></li>
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
    <span class="current">Student Section Events</span>
  </div>
  <div class="hero-inner">
    <div class="hero-left">
      <h1>Student Section <em>Events</em></h1>
      <p>Hackathons, career fairs, webinars, workshops, and competitions — designed exclusively for engineering students and fresh graduates across Malaysia's universities.</p>
    </div>
    <div class="hero-stats">
      <div class="hero-stat"><div class="big">38</div><div class="lbl">Universities</div></div>
      <div class="hero-stat"><div class="big">24</div><div class="lbl">Events This Year</div></div>
    </div>
  </div>
</div>

<div class="category-bar">
  <div class="category-pills">
    <button class="pill active" onclick="filterCat('all', this)">All Categories</button>
    <button class="pill" onclick="filterCat('hackathon', this)">Hackathon</button>
    <button class="pill" onclick="filterCat('career', this)">Career Fair</button>
    <button class="pill" onclick="filterCat('webinar', this)">Webinar</button>
    <button class="pill" onclick="filterCat('workshop', this)">Workshop</button>
    <button class="pill" onclick="filterCat('competition', this)">Competition</button>
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

<div class="results-info" id="resultsInfo">Showing <strong>6</strong> events</div>

<div class="events-body">
  <div class="events-grid" id="eventsGrid">

    <div class="event-card reveal" data-cat="hackathon" data-status="open" data-name="Engineering Innovation Hackathon" data-date="2025-04-02">
      <div class="card-img">
        <div class="card-img-inner bg-s3"></div>
        <div class="card-badge">Student</div>
        <div class="card-status status-open">Open</div>
        <div class="card-category cat-hackathon">Hackathon</div>
      </div>
      <div class="card-body">
        <div class="card-meta">
          <span class="card-date">2–4 Apr 2025</span>
          <span class="card-location"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>UTM, Skudai</span>
        </div>
        <h3>Engineering Innovation Hackathon 2025</h3>
        <p>48-hour hackathon where student teams tackle real-world engineering challenges with mentorship from industry professionals. Open to all engineering disciplines.</p>
        <div class="card-tags"><span class="tag">Team Event</span><span class="tag">Industry Mentors</span><span class="tag">Cash Prize</span></div>
        <div class="card-footer">
          <span class="card-seats">Seats: <strong>36 / 120</strong> remaining</span>
          <a href="#" class="card-cta">Register Now →</a>
        </div>
      </div>
    </div>

    <div class="event-card reveal reveal-delay-1" data-cat="career" data-status="open" data-name="STEM Career Fair 2025" data-date="2025-04-18">
      <div class="card-img">
        <div class="card-img-inner bg-s1"></div>
        <div class="card-badge">Student</div>
        <div class="card-status status-open">Open</div>
        <div class="card-category cat-career">Career Fair</div>
      </div>
      <div class="card-body">
        <div class="card-meta">
          <span class="card-date">18 Apr 2025</span>
          <span class="card-location"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>UPM, Serdang</span>
        </div>
        <h3>STEM Career Fair 2025</h3>
        <p>Connect with top engineering firms and research institutions. Explore internships, scholarships, and graduate programme opportunities from over 40 employers.</p>
        <div class="card-tags"><span class="tag">Walk-in Welcome</span><span class="tag">40+ Employers</span><span class="tag">Free Entry</span></div>
        <div class="card-footer">
          <span class="card-seats">Walk-in &amp; <strong>Pre-registered</strong></span>
          <a href="#" class="card-cta">Learn More →</a>
        </div>
      </div>
    </div>

    <div class="event-card reveal reveal-delay-2" data-cat="webinar" data-status="open" data-name="Robotics and Automation Webinar Series" data-date="2025-05-05">
      <div class="card-img">
        <div class="card-img-inner bg-s2"></div>
        <div class="card-badge">Student</div>
        <div class="card-status status-open">Open</div>
        <div class="card-category cat-webinar">Webinar</div>
      </div>
      <div class="card-body">
        <div class="card-meta">
          <span class="card-date">5 May – 10 Jun 2025</span>
          <span class="card-location"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Online (Zoom)</span>
        </div>
        <h3>Robotics &amp; Automation Webinar Series</h3>
        <p>Six-part online series covering Industry 4.0 technologies. Guest speakers from leading manufacturing and automation companies including Bosch, ABB, and Omron.</p>
        <div class="card-tags"><span class="tag">6 Sessions</span><span class="tag">Certificate</span><span class="tag">Free</span></div>
        <div class="card-footer">
          <span class="card-seats">Seats: <strong>220 / 500</strong> remaining</span>
          <a href="#" class="card-cta">Register →</a>
        </div>
      </div>
    </div>

    <div class="event-card reveal reveal-delay-3" data-cat="workshop" data-status="upcoming" data-name="BIM and Digital Engineering Workshop" data-date="2025-06-07">
      <div class="card-img">
        <div class="card-img-inner bg-s4"></div>
        <div class="card-badge">Student</div>
        <div class="card-status status-upcoming">Upcoming</div>
        <div class="card-category cat-workshop">Workshop</div>
      </div>
      <div class="card-body">
        <div class="card-meta">
          <span class="card-date">7–8 Jun 2025</span>
          <span class="card-location"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>UM, Kuala Lumpur</span>
        </div>
        <h3>BIM &amp; Digital Engineering Workshop</h3>
        <p>Hands-on two-day workshop on Building Information Modelling, AutoCAD Civil 3D, and digital construction workflows. Participants receive a YES-endorsed certificate upon completion.</p>
        <div class="card-tags"><span class="tag">Hands-on</span><span class="tag">Certificate</span><span class="tag">Software Provided</span></div>
        <div class="card-footer">
          <span class="card-seats">Registration opens <strong>15 May</strong></span>
          <a href="#" class="card-cta">Notify Me →</a>
        </div>
      </div>
    </div>

    <div class="event-card reveal reveal-delay-4" data-cat="competition" data-status="upcoming" data-name="YES National Paper Presentation Competition" data-date="2025-07-20">
      <div class="card-img">
        <div class="card-img-inner bg-s5"></div>
        <div class="card-badge">Student</div>
        <div class="card-status status-upcoming">Upcoming</div>
        <div class="card-category cat-competition">Competition</div>
      </div>
      <div class="card-body">
        <div class="card-meta">
          <span class="card-date">20 Jul 2025</span>
          <span class="card-location"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>UITM Shah Alam</span>
        </div>
        <h3>YES National Paper Presentation Competition</h3>
        <p>Present your final year project or research to a panel of industry judges. Winners represent Malaysia at CAFEO's student paper presentation. Open to all final-year undergraduates.</p>
        <div class="card-tags"><span class="tag">All Disciplines</span><span class="tag">Cash Prize</span><span class="tag">CAFEO Entry</span></div>
        <div class="card-footer">
          <span class="card-seats">Abstract submission <strong>open now</strong></span>
          <a href="#" class="card-cta">Submit Abstract →</a>
        </div>
      </div>
    </div>

    <div class="event-card reveal reveal-delay-5" data-cat="career" data-status="closed" data-name="Graduate Engineering Networking Night 2024" data-date="2024-11-15">
      <div class="card-img">
        <div class="card-img-inner bg-s6"></div>
        <div class="card-badge">Student</div>
        <div class="card-status status-closed">Past</div>
        <div class="card-category cat-career">Career Fair</div>
      </div>
      <div class="card-body">
        <div class="card-meta">
          <span class="card-date">15 Nov 2024</span>
          <span class="card-location"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Intercontinental KL</span>
        </div>
        <h3>Graduate Engineering Networking Night 2024</h3>
        <p>An exclusive evening connecting final-year students and fresh graduates with HR directors and hiring managers from Malaysia's top engineering conglomerates. Over 300 attendees.</p>
        <div class="card-tags"><span class="tag">Networking</span><span class="tag">Smart Casual</span></div>
        <div class="card-footer">
          <span class="card-seats">Event <strong>Concluded</strong></span>
          <a href="#" class="card-cta">View Recap →</a>
        </div>
      </div>
    </div>

    <div class="no-results" id="noResults">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <h3>No events found</h3>
      <p>Try adjusting your search or filter criteria.</p>
    </div>

  </div>

  <div class="pagination">
    <a href="#" class="page-btn arrow">‹</a>
    <a href="#" class="page-btn active">1</a>
    <a href="#" class="page-btn">2</a>
    <a href="#" class="page-btn">3</a>
    <a href="#" class="page-btn">4</a>
    <span class="page-info">Showing 1–6 of 24 events</span>
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
let activeCat = 'all', activeSearch = '';
const allCards = () => Array.from(document.querySelectorAll('.event-card[data-cat]'));

function filterCat(cat, btn) {
  activeCat = cat;
  document.querySelectorAll('.pill').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  applyFilters();
}
function searchEvents(val) { activeSearch = val.toLowerCase(); applyFilters(); }
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
    const show = (activeCat === 'all' || card.dataset.cat === activeCat) &&
                 (!activeSearch || card.dataset.name.toLowerCase().includes(activeSearch));
    card.style.display = show ? '' : 'none';
    if (show) visible++;
  });
  document.getElementById('noResults').style.display = visible === 0 ? 'flex' : 'none';
  document.getElementById('resultsInfo').innerHTML = `Showing <strong>${visible}</strong> event${visible !== 1 ? 's' : ''}`;
}

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