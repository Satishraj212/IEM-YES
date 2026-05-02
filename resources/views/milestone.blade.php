<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Milestones – YES Young Engineer Section | IEM Malaysia</title>
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
nav.main-nav { position: sticky; top: 0; z-index: 1000; background: var(--white); border-bottom: 3px solid var(--gold); display: flex; align-items: center; justify-content: space-between; padding: 0 60px; height: 72px; box-shadow: 0 2px 20px rgba(0,0,0,0.08); }
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

/* ── PAGE HERO ── */
.page-hero { background: var(--navy-dark); padding: 80px 60px 60px; position: relative; overflow: hidden; }
.page-hero::before { content: ''; position: absolute; top: -80px; right: -80px; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(200,168,75,0.06) 0%, transparent 70%); }
.page-hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--gold) 0%, transparent 60%); }
.breadcrumb { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; font-size: 12px; letter-spacing: 1.5px; text-transform: uppercase; }
.breadcrumb a { color: rgba(255,255,255,0.5); text-decoration: none; transition: color .2s; }
.breadcrumb a:hover { color: var(--gold); }
.breadcrumb span { color: rgba(255,255,255,0.25); }
.breadcrumb .current { color: var(--gold); }
.page-hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(36px, 4vw, 58px); color: var(--white); font-weight: 900; line-height: 1.1; }
.page-hero h1 em { color: var(--gold); font-style: normal; }
.page-hero-sub { font-size: 16px; color: rgba(255,255,255,0.65); margin-top: 16px; max-width: 560px; line-height: 1.7; }

/* ── DECADE FILTER ── */
.decade-filter { background: var(--offwhite); padding: 0 60px; display: flex; gap: 0; border-bottom: 2px solid var(--light-grey); overflow-x: auto; position: sticky; top: 72px; z-index: 900; }
.decade-btn { padding: 18px 28px; font-size: 13px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--grey); background: none; border: none; border-bottom: 3px solid transparent; cursor: pointer; transition: all .2s; white-space: nowrap; font-family: 'DM Sans', sans-serif; }
.decade-btn:hover { color: var(--navy); }
.decade-btn.active { color: var(--navy); border-bottom-color: var(--gold); }

/* ── TIMELINE WRAPPER ── */
.timeline-wrapper { padding: 80px 60px; max-width: 1100px; margin: 0 auto; }

/* ── TIMELINE VERTICAL LINE ── */
.timeline { position: relative; }
.timeline::before { content: ''; position: absolute; left: 50%; top: 0; bottom: 0; width: 2px; background: linear-gradient(180deg, var(--gold) 0%, rgba(200,168,75,0.15) 100%); transform: translateX(-50%); }

/* ── DECADE GROUP ── */
.decade-group { margin-bottom: 72px; display: none; }
.decade-group.visible { display: block; }
.decade-heading { text-align: center; position: relative; margin-bottom: 52px; }
.decade-heading::before { content: ''; position: absolute; left: 50%; top: 50%; transform: translate(-50%,-50%); width: 120px; height: 1px; background: var(--gold); }
.decade-heading span { background: var(--white); position: relative; z-index: 1; font-family: 'Playfair Display', serif; font-size: 48px; font-weight: 900; color: var(--light-grey); padding: 0 16px; }

/* ── MILESTONE ITEM ── */
.milestone-item { display: grid; grid-template-columns: 1fr 60px 1fr; align-items: start; margin-bottom: 52px; gap: 0; }
.milestone-item:nth-child(even) .ms-content { grid-column: 3; }
.milestone-item:nth-child(even) .ms-center { grid-column: 2; }
.milestone-item:nth-child(even) .ms-empty { grid-column: 1; }
.ms-content { padding: 0 36px; }
.ms-center { display: flex; flex-direction: column; align-items: center; padding-top: 8px; }
.ms-dot { width: 18px; height: 18px; background: var(--gold); border-radius: 50%; border: 3px solid var(--white); box-shadow: 0 0 0 3px var(--gold); flex-shrink: 0; position: relative; z-index: 2; transition: transform .3s; }
.milestone-item:hover .ms-dot { transform: scale(1.4); box-shadow: 0 0 0 5px rgba(200,168,75,0.3); }

/* ── MILESTONE CARD ── */
.ms-card { background: var(--white); border: 1px solid var(--light-grey); padding: 28px; transition: all .35s; position: relative; overflow: hidden; }
.ms-card::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: var(--gold); transform: scaleX(0); transition: transform .35s; }
.milestone-item:hover .ms-card { box-shadow: 0 16px 48px rgba(0,31,69,0.1); transform: translateY(-4px); border-color: rgba(200,168,75,0.3); }
.milestone-item:hover .ms-card::after { transform: scaleX(1); }
.ms-card.featured { border-color: var(--gold); background: var(--navy); }
.ms-card.featured::after { transform: scaleX(1); background: var(--gold-light); }
.ms-year { font-family: 'Playfair Display', serif; font-size: 38px; font-weight: 900; color: var(--gold); line-height: 1; margin-bottom: 8px; display: block; }
.ms-card.featured .ms-year { color: var(--gold-light); }
.ms-tag { display: inline-block; font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 4px 10px; margin-bottom: 12px; }
.ms-tag.founding { background: var(--gold); color: var(--navy-dark); }
.ms-tag.achievement { background: var(--navy); color: var(--gold); }
.ms-tag.expansion { background: #1a6b3c; color: #a8e6c1; }
.ms-tag.event { background: #4a1a6b; color: #c4a8e6; }
.ms-tag.international { background: #6b1a1a; color: #e6a8a8; }
.ms-card.featured .ms-tag.founding { background: var(--gold-light); color: var(--navy-dark); }
.ms-card h3 { font-size: 18px; font-weight: 700; color: var(--navy); margin-bottom: 8px; line-height: 1.3; }
.ms-card.featured h3 { color: var(--white); }
.ms-card p { font-size: 13.5px; color: var(--grey); line-height: 1.75; }
.ms-card.featured p { color: rgba(255,255,255,0.7); }
.milestone-item:nth-child(odd) .ms-card { text-align: right; }
.milestone-item:nth-child(odd) .ms-tag { float: right; }
.milestone-item:nth-child(odd) .ms-tag + * { clear: both; }

/* ── SCROLL ANIMATIONS ── */
.reveal { opacity: 0; transform: translateY(30px); transition: opacity .7s ease, transform .7s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }

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
<nav class="main-nav">
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
            <li><a href="{{ route('who-we-are') }}#vision-mission">Mission &amp; Vision</a></li>
            <li><a href="{{ route('who-we-are') }}#values">Values</a></li>
            <li><a href="{{ route('who-we-are') }}#where-we-are">Where We Are</a></li>
            <li><a href="{{ route('milestone') }}" class="active-link">Milestones</a></li>
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

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span>›</span>
    <a href="{{ route('who-we-are') }}">About Us</a>
    <span>›</span>
    <span class="current">Milestones</span>
  </div>
  <h1>Our <em>Milestones</em></h1>
  <p class="page-hero-sub">Over 38 years of shaping Malaysia's engineering landscape — a journey of growth, achievement, and enduring impact for young engineers across the nation.</p>
</div>

<!-- DECADE FILTER — newest first -->
<div class="decade-filter">
  <button class="decade-btn active" onclick="filterDecade('all', this)">All</button>
  <button class="decade-btn" onclick="filterDecade('2020s', this)">2020s</button>
  <button class="decade-btn" onclick="filterDecade('2010s', this)">2010s</button>
  <button class="decade-btn" onclick="filterDecade('2000s', this)">2000s</button>
  <button class="decade-btn" onclick="filterDecade('1990s', this)">1990s</button>
  <button class="decade-btn" onclick="filterDecade('1980s', this)">1980s</button>
</div>

<!-- TIMELINE — newest to oldest -->
<div class="timeline-wrapper">
  <div class="timeline">

    <!-- ══ 2020s ══ -->
    <div class="decade-group visible" data-decade="2020s">
      <div class="decade-heading"><span>2020s</span></div>

      <div class="milestone-item reveal">
        <div class="ms-empty"></div>
        <div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-content">
          <div class="ms-card featured">
            <span class="ms-year">2024</span>
            <span class="ms-tag founding">Present</span>
            <h3>YES AI &amp; Sustainability Programme</h3>
            <p>YES launched its most ambitious programme to date — an AI-integrated sustainability curriculum equipping young Malaysian engineers with tools and skills to build a greener, smarter future for the nation.</p>
          </div>
        </div>
      </div>

      <div class="milestone-item reveal">
        <div class="ms-content">
          <div class="ms-card">
            <span class="ms-year">2022</span>
            <span class="ms-tag expansion">Expansion</span>
            <h3>26 Active Branches &amp; 12,000 Members</h3>
            <p>YES reached its highest-ever membership of 12,000 active members and 26 operational state branches — the most expansive footprint in YES history.</p>
          </div>
        </div>
        <div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-empty"></div>
      </div>

      <div class="milestone-item reveal">
        <div class="ms-empty"></div>
        <div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-content">
          <div class="ms-card">
            <span class="ms-year">2020</span>
            <span class="ms-tag achievement">Achievement</span>
            <h3>Digital Pivot — Virtual Programmes</h3>
            <p>YES rapidly transformed its physical events into virtual formats during the pandemic, maintaining full engagement with over 8,000 online programme participants across webinars, virtual hackathons, and e-mentoring sessions.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- ══ 2010s ══ -->
    <div class="decade-group visible" data-decade="2010s">
      <div class="decade-heading"><span>2010s</span></div>

      <div class="milestone-item reveal">
        <div class="ms-content">
          <div class="ms-card">
            <span class="ms-year">2019</span>
            <span class="ms-tag achievement">Achievement</span>
            <h3>Industry 4.0 Taskforce Established</h3>
            <p>YES formed a dedicated Industry 4.0 taskforce to prepare young engineers for the digital transformation era — delivering training in AI, IoT, robotics, and smart manufacturing across all state branches.</p>
          </div>
        </div>
        <div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-empty"></div>
      </div>

      <div class="milestone-item reveal">
        <div class="ms-empty"></div>
        <div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-content">
          <div class="ms-card">
            <span class="ms-year">2017</span>
            <span class="ms-tag event">Event</span>
            <h3>30th Anniversary Gala</h3>
            <p>YES celebrated its 30th anniversary with a national gala attended by over 1,500 members, alumni, industry leaders, and government representatives — reflecting on three decades of engineering youth empowerment.</p>
          </div>
        </div>
      </div>

      <div class="milestone-item reveal">
        <div class="ms-content">
          <div class="ms-card">
            <span class="ms-year">2015</span>
            <span class="ms-tag achievement">Achievement</span>
            <h3>YES Green Engineering Initiative</h3>
            <p>YES launched its sustainability arm, embedding environmental responsibility into its programmes — including green engineering workshops, river rehabilitation drives, and renewable energy outreach camps.</p>
          </div>
        </div>
        <div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-empty"></div>
      </div>

      <div class="milestone-item reveal">
        <div class="ms-empty"></div>
        <div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-content">
          <div class="ms-card">
            <span class="ms-year">2012</span>
            <span class="ms-tag expansion">Expansion</span>
            <h3>University Student Chapters Launched</h3>
            <p>YES formalised its university outreach through student chapters across 25 Malaysian universities — bringing YES's network directly to undergraduate engineers before graduation.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- ══ 2000s ══ -->
    <div class="decade-group visible" data-decade="2000s">
      <div class="decade-heading"><span>2000s</span></div>

      <div class="milestone-item reveal">
        <div class="ms-content">
          <div class="ms-card">
            <span class="ms-year">2009</span>
            <span class="ms-tag international">International</span>
            <h3>ASEAN Young Engineers Summit Co-Hosted</h3>
            <p>Malaysia — through YES – IEM — co-hosted the ASEAN Young Engineers Summit in Kuala Lumpur, bringing together young engineering leaders from 10 ASEAN nations.</p>
          </div>
        </div>
        <div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-empty"></div>
      </div>

      <div class="milestone-item reveal">
        <div class="ms-empty"></div>
        <div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-content">
          <div class="ms-card">
            <span class="ms-year">2007</span>
            <span class="ms-tag event">Event</span>
            <h3>YES Excellence Awards Introduced</h3>
            <p>The inaugural YES Excellence Awards recognised outstanding young engineers and student chapters for their technical contributions, leadership, and community impact across Malaysia.</p>
          </div>
        </div>
      </div>

      <div class="milestone-item reveal">
        <div class="ms-content">
          <div class="ms-card">
            <span class="ms-year">2004</span>
            <span class="ms-tag achievement">Achievement</span>
            <h3>10,000 Members Milestone</h3>
            <p>YES reached 10,000 registered members — a landmark that cemented YES as the largest youth engineering organisation in Malaysia, with representation in every engineering discipline.</p>
          </div>
        </div>
        <div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-empty"></div>
      </div>

      <div class="milestone-item reveal">
        <div class="ms-empty"></div>
        <div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-content">
          <div class="ms-card">
            <span class="ms-year">2001</span>
            <span class="ms-tag expansion">Expansion</span>
            <h3>East Malaysia Branches Established</h3>
            <p>YES extended its reach to Sabah and Sarawak, completing the nationwide coverage and bringing the total active branches to 18 — representing young engineers across all regions of Malaysia.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- ══ 1990s ══ -->
    <div class="decade-group visible" data-decade="1990s">
      <div class="decade-heading"><span>1990s</span></div>

      <div class="milestone-item reveal">
        <div class="ms-content">
          <div class="ms-card">
            <span class="ms-year">1998</span>
            <span class="ms-tag international">International</span>
            <h3>First CAFEO Participation</h3>
            <p>YES officially represented Malaysia at the Conference of ASEAN Federation of Engineering Organisations (CAFEO), marking YES's debut on the regional engineering stage.</p>
          </div>
        </div>
        <div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-empty"></div>
      </div>

      <div class="milestone-item reveal">
        <div class="ms-empty"></div>
        <div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-content">
          <div class="ms-card">
            <span class="ms-year">1995</span>
            <span class="ms-tag event">Event</span>
            <h3>NATSUM Launched</h3>
            <p>The National Student Summit (NATSUM) was inaugurated as YES's flagship student event — connecting final-year engineering undergraduates with industry and professional mentors at scale.</p>
          </div>
        </div>
      </div>

      <div class="milestone-item reveal">
        <div class="ms-content">
          <div class="ms-card">
            <span class="ms-year">1992</span>
            <span class="ms-tag expansion">Expansion</span>
            <h3>First State Branches Formed</h3>
            <p>YES expanded beyond KL with the establishment of the first state branches in Penang, Johor, and Perak — bringing YES closer to young engineers across the country.</p>
          </div>
        </div>
        <div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-empty"></div>
      </div>
    </div>

    <!-- ══ 1980s ══ -->
    <div class="decade-group visible" data-decade="1980s">
      <div class="decade-heading"><span>1980s</span></div>

      <div class="milestone-item reveal">
        <div class="ms-empty"></div>
        <div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-content">
          <div class="ms-card">
            <span class="ms-year">1989</span>
            <span class="ms-tag achievement">Achievement</span>
            <h3>First National Convention</h3>
            <p>YES held its inaugural National Young Engineers Convention in Kuala Lumpur, attracting over 400 participants and establishing the template for annual flagship events.</p>
          </div>
        </div>
      </div>

      <div class="milestone-item reveal">
        <div class="ms-content">
          <div class="ms-card featured">
            <span class="ms-year">1987</span>
            <span class="ms-tag founding">Founding</span>
            <h3>YES – IEM Established</h3>
            <p>The Young Engineer Section was officially established under the Institution of Engineers Malaysia (IEM), creating a dedicated platform for engineering professionals under 35 to network, grow, and contribute to the nation.</p>
          </div>
        </div>
        <div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-empty"></div>
      </div>
    </div>

  </div>
</div>

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
function filterDecade(decade, btn) {
  document.querySelectorAll('.decade-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.decade-group').forEach(g => {
    g.classList.toggle('visible', decade === 'all' || g.dataset.decade === decade);
  });
}

const obs = new IntersectionObserver(entries => {
  entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.08 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

window.addEventListener('scroll', () => {
  document.getElementById('backTop').classList.toggle('visible', window.scrollY > 300);
});
</script>
</body>
</html>