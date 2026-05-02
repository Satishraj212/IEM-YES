<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Awards & Recognition – YES Young Engineer Section | IEM Malaysia</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --navy:#003366;--navy-dark:#001f45;--navy-mid:#002855;
  --gold:#c8a84b;--gold-light:#e8c96a;--gold-dim:rgba(200,168,75,.12);
  --off:#f5f4f0;--light:#e8e8e4;--grey:#6b7280;
  --green:#1a6b3c;--green-a:#4caf7d;
  --red:#c0392b;--amber:#d97706;--amber-l:#fef3c7;
}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;color:#222;background:var(--off);overflow-x:hidden}

/* ── TOP BAR ── */
.top-bar{background:var(--navy-dark);color:rgba(255,255,255,0.65);font-size:12px;display:flex;justify-content:flex-end;align-items:center;gap:24px;padding:7px 60px}
.top-bar a{color:rgba(255,255,255,0.65);text-decoration:none;transition:color .2s}
.top-bar a:hover{color:var(--gold)}
/* ── NAV ── */
nav.main-nav{position:sticky;top:0;z-index:1000;background:#fff;border-bottom:3px solid var(--gold);display:flex;align-items:center;justify-content:space-between;padding:0 60px;height:72px;box-shadow:0 2px 20px rgba(0,0,0,0.08)}
.logo{display:flex;align-items:center;text-decoration:none}
.nav-logo-img{height:52px;width:auto;display:block;object-fit:contain}
.nav-links-list{display:flex;list-style:none;height:100%}
.nav-links-list>li{position:relative;height:100%;display:flex;align-items:center}
.nav-links-list>li>a{display:flex;align-items:center;gap:5px;padding:0 22px;height:100%;text-decoration:none;color:var(--navy);font-size:14px;font-weight:600;letter-spacing:.5px;text-transform:uppercase;transition:color .2s;position:relative}
.nav-links-list>li>a::after{content:'';position:absolute;bottom:0;left:0;right:0;height:3px;background:var(--gold);transform:scaleX(0);transition:transform .25s ease}
.nav-links-list>li:hover>a{color:var(--gold)}
.nav-links-list>li:hover>a::after{transform:scaleX(1)}
.nav-links-list>li.active>a{color:var(--gold)}
.nav-links-list>li.active>a::after{transform:scaleX(1)}
.nav-arrow{width:0;height:0;border-left:4px solid transparent;border-right:4px solid transparent;border-top:5px solid currentColor;transition:transform .2s}
.nav-links-list>li:hover .nav-arrow{transform:rotate(180deg)}
.mega-menu{position:absolute;top:100%;left:0;width:max-content;min-width:420px;max-width:min(680px,calc(100vw - 60px));background:#fff;box-shadow:0 20px 60px rgba(0,51,102,0.15);display:grid;grid-template-columns:1fr 1fr;opacity:0;pointer-events:none;transform:translateY(-8px);transition:all .25s ease;border-top:3px solid var(--gold)}
.nav-links-list>li:nth-last-child(-n+2) .mega-menu{left:auto;right:0}
.nav-links-list>li:hover .mega-menu{opacity:1;pointer-events:all;transform:translateY(0)}
.mega-menu.single-col{grid-template-columns:1fr;min-width:260px;max-width:300px}
.mega-col{padding:28px 30px}
.mega-col:first-child{background:var(--off);border-right:1px solid var(--light)}
.mega-menu.single-col .mega-col:first-child{border-right:none}
.mega-col h4{font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--gold);margin-bottom:14px;padding-bottom:8px;border-bottom:1px solid var(--light)}
.mega-col ul{list-style:none}
.mega-col ul li a{display:block;padding:6px 0;color:var(--navy);text-decoration:none;font-size:13.5px;transition:all .15s}
.mega-col ul li a:hover{color:var(--gold);padding-left:8px}
.mega-col ul li a.active-link{color:var(--gold);font-weight:600;padding-left:8px;border-left:2px solid var(--gold)}

/* ── HERO ── */
.hero{background:linear-gradient(135deg,var(--navy-dark) 0%,var(--navy-mid) 60%,#1a3a6e 100%);padding:70px 28px 60px;text-align:center;position:relative;overflow:hidden}
.hero::before{content:'';position:absolute;inset:0;background:repeating-linear-gradient(45deg,rgba(200,168,75,.03) 0,rgba(200,168,75,.03) 1px,transparent 0,transparent 50%);background-size:20px 20px;pointer-events:none}
.hero-eyebrow{font-size:10px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:rgba(200,168,75,.7);margin-bottom:14px}
.hero-title{font-family:'Playfair Display',serif;font-size:46px;font-weight:900;color:#fff;line-height:1.1;margin-bottom:16px}
.hero-title em{color:var(--gold);font-style:italic}
.hero-sub{font-size:15px;color:rgba(255,255,255,.55);max-width:560px;margin:0 auto 28px;line-height:1.7}
.hero-stats{display:flex;justify-content:center;gap:40px;flex-wrap:wrap;margin-top:32px}
.hs{text-align:center}
.hs-val{font-family:'Playfair Display',serif;font-size:32px;font-weight:900;color:var(--gold);line-height:1}
.hs-lbl{font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-top:4px}

/* ── BREADCRUMB ── */
.breadcrumb{max-width:1240px;margin:0 auto;padding:14px 28px;display:flex;align-items:center;gap:6px;font-size:11px;color:var(--grey)}
.breadcrumb a{color:var(--grey);text-decoration:none}
.breadcrumb a:hover{color:var(--navy)}
.breadcrumb span{color:#bbb}

/* ── SECTION ANCHOR NAV ── */
.anchor-nav{background:#fff;border-bottom:2px solid var(--light);position:sticky;top:72px;z-index:80}
.anchor-inner{max-width:1240px;margin:0 auto;padding:0 28px;display:flex;gap:0;overflow-x:auto}
.an-link{padding:14px 20px;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--grey);text-decoration:none;border-bottom:2px solid transparent;margin-bottom:-2px;white-space:nowrap;transition:all .2s}
.an-link:hover{color:var(--navy)}
.an-link.active{color:var(--navy);border-bottom-color:var(--gold)}

/* ── LAYOUT ── */
.container{max-width:1240px;margin:0 auto;padding:0 28px}
.section{padding:56px 0}
.section-eyebrow{font-size:10px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--gold);margin-bottom:10px}
.section-title{font-family:'Playfair Display',serif;font-size:34px;font-weight:900;color:var(--navy-dark);margin-bottom:10px;line-height:1.2}
.section-title em{color:var(--gold);font-style:italic}
.section-sub{font-size:14px;color:var(--grey);line-height:1.7;max-width:600px}

/* ── AWARD CATEGORY TABS ── */
.cat-tabs{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:32px}
.ctab{padding:8px 18px;border:1px solid var(--light);background:#fff;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--grey);cursor:pointer;border-radius:2px;transition:all .2s}
.ctab:hover{border-color:var(--navy);color:var(--navy)}
.ctab.active{background:var(--navy-dark);color:var(--gold);border-color:var(--navy-dark)}

/* ── LEADERBOARD ── */
.leaderboard{background:#fff;border:1px solid var(--light);border-radius:4px;overflow:hidden}
.lb-head{display:grid;grid-template-columns:56px 1fr 120px 120px 100px;gap:0;padding:10px 20px;background:var(--off);border-bottom:2px solid var(--light)}
.lb-head span{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey)}
.lb-row{display:grid;grid-template-columns:56px 1fr 120px 120px 100px;gap:0;padding:14px 20px;border-bottom:1px solid var(--light);align-items:center;transition:background .15s}
.lb-row:last-child{border-bottom:none}
.lb-row:hover{background:#fafaf8}
.lb-row.gold-row{background:rgba(200,168,75,.04)}
.lb-rank{font-family:'Playfair Display',serif;font-size:18px;font-weight:900;color:var(--grey)}
.lb-row:nth-child(1) .lb-rank{color:var(--gold)}
.lb-row:nth-child(2) .lb-rank{color:#aaa}
.lb-row:nth-child(3) .lb-rank{color:#b87333}
.lb-medal{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0}
.medal-gold{background:rgba(200,168,75,.15);border:1px solid rgba(200,168,75,.35)}
.medal-silver{background:rgba(170,170,170,.15);border:1px solid rgba(170,170,170,.35)}
.medal-bronze{background:rgba(184,115,51,.12);border:1px solid rgba(184,115,51,.3)}
.medal-none{background:var(--off);border:1px solid var(--light)}
.lb-chapter-name{font-size:13px;font-weight:700;color:var(--navy-dark)}
.lb-chapter-uni{font-size:11px;color:var(--grey);margin-top:2px}
.lb-pts{font-family:'Playfair Display',serif;font-size:18px;font-weight:900;color:var(--navy);text-align:center}
.lb-pts-lbl{font-size:9px;color:var(--grey);text-align:center;margin-top:1px}
.lb-awards-cell{display:flex;gap:4px;flex-wrap:wrap}
.lb-badge{padding:3px 8px;font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;border-radius:2px}
.badge-gold{background:rgba(200,168,75,.15);color:#7a5b14;border:1px solid rgba(200,168,75,.3)}
.badge-silver{background:rgba(170,170,170,.12);color:#555;border:1px solid rgba(170,170,170,.3)}
.badge-cert{background:#eff6ff;color:#1e40af;border:1px solid rgba(29,78,216,.2)}

/* ── AWARD CARDS ── */
.award-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.award-card{background:#fff;border:1px solid var(--light);padding:24px;position:relative;overflow:hidden;transition:box-shadow .2s}
.award-card:hover{box-shadow:0 6px 24px rgba(0,31,69,.08)}
.award-card-bar{position:absolute;top:0;left:0;right:0;height:3px}
.award-icon{width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:14px}
.award-icon svg{width:22px;height:22px;stroke:currentColor;fill:none;stroke-width:1.8}
.award-name{font-family:'Playfair Display',serif;font-size:16px;font-weight:700;color:var(--navy-dark);margin-bottom:6px}
.award-desc{font-size:12px;color:var(--grey);line-height:1.65;margin-bottom:14px}
.award-pts{display:inline-flex;align-items:center;gap:5px;font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--gold);background:var(--gold-dim);border:1px solid rgba(200,168,75,.25);padding:4px 10px;border-radius:2px}

/* ── PAST WINNERS ── */
.winners-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px}
.winner-card{background:#fff;border:1px solid var(--light);padding:20px;display:flex;gap:14px;align-items:flex-start}
.winner-year{font-family:'Playfair Display',serif;font-size:28px;font-weight:900;color:var(--gold);min-width:56px;line-height:1}
.winner-content{}
.winner-award{font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--gold);margin-bottom:4px}
.winner-chapter{font-size:14px;font-weight:700;color:var(--navy-dark);margin-bottom:2px}
.winner-uni{font-size:11px;color:var(--grey)}
.winner-pts{font-size:11px;font-weight:700;color:var(--navy);margin-top:6px}

/* ── ANNOUNCEMENT BANNER ── */
.announcement{background:var(--navy-dark);border:1px solid rgba(200,168,75,.2);padding:20px 28px;display:flex;align-items:center;gap:16px;margin-bottom:32px;border-radius:4px}
.ann-icon{width:44px;height:44px;background:var(--gold-dim);border:1px solid rgba(200,168,75,.3);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.ann-icon svg{width:20px;height:20px;stroke:var(--gold);fill:none;stroke-width:2}
.ann-text{}
.ann-label{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(200,168,75,.6);margin-bottom:4px}
.ann-msg{font-size:13px;color:#fff;font-weight:600;line-height:1.5}
.ann-sub{font-size:11px;color:rgba(255,255,255,.45);margin-top:2px}

/* ── REVEAL ── */
.reveal{opacity:0;transform:translateY(20px);transition:opacity .5s,transform .5s}
.reveal.visible{opacity:1;transform:translateY(0)}

/* ── FOOTER ── */
.site-footer{background:var(--navy-dark);padding:48px 60px 0}
.footer-mini{display:grid;grid-template-columns:2fr 1fr 1fr;gap:40px;padding-bottom:40px}
.footer-mini p{font-size:13px;color:rgba(255,255,255,.55);line-height:1.8;margin-top:12px;max-width:300px}
.footer-mini h4{font-size:10px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:var(--gold);margin-bottom:16px}
.footer-mini ul{list-style:none}
.footer-mini ul li{margin-bottom:9px}
.footer-mini ul li a{color:rgba(255,255,255,.55);text-decoration:none;font-size:13px;transition:color .2s}
.footer-mini ul li a:hover{color:#fff}
.footer-bottom{padding:20px 0;display:flex;justify-content:space-between;align-items:center;font-size:12px;color:rgba(255,255,255,.35);border-top:1px solid rgba(255,255,255,.1)}
.footer-bottom a{color:rgba(255,255,255,.35);text-decoration:none;margin-left:20px}
.footer-bottom a:hover{color:var(--gold)}
</style>
</head>
<body>

<div class="top-bar">
  <a href="{{ route('login') }}">Portal Login</a>
  <a href="#">Careers</a>
  <a href="#">Media</a>
</div>

<nav class="main-nav">
  <a class="logo" href="{{ route('home') }}">
    <img src="{{ asset('images/iem-yes-logo.png') }}" alt="IEM Young Engineers Section" class="nav-logo-img"/>
  </a>
  <ul class="nav-links-list">

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

    <li class="active">
      <a href="{{ route('awards') }}">Awards <span class="nav-arrow"></span></a>
      <div class="mega-menu">
        <div class="mega-col">
          <h4>Recognition</h4>
          <ul>
            <li><a href="{{ route('awards') }}#leaderboard" class="active-link">Chapter Leaderboard</a></li>
            <li><a href="{{ route('awards') }}#categories">Award Categories</a></li>
            <li><a href="{{ route('awards') }}#past-winners">Past Winners</a></li>
          </ul>
        </div>
        <div class="mega-col">
          <h4>Nominate</h4>
          <ul>
            <li><a href="#">Nomination Guidelines</a></li>
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

    <li><a href="{{ route('home') }}#footer">Contact Us</a></li>

  </ul>
</nav>

{{-- Hero --}}
<div class="hero">
    <div class="hero-eyebrow">Excellence & Recognition</div>
    <h1 class="hero-title">Student Chapter <em>Awards</em></h1>
    <p class="hero-sub">Recognising the outstanding contributions of YES student chapters across Malaysian universities. Awards are announced annually at the National Student Summit (NATSUM).</p>
    <div class="hero-stats">
        <div class="hs"><div class="hs-val">38</div><div class="hs-lbl">Universities</div></div>
        <div class="hs"><div class="hs-val">6</div><div class="hs-lbl">Award Categories</div></div>
        <div class="hs"><div class="hs-val">2025</div><div class="hs-lbl">Current Cycle</div></div>
        <div class="hs"><div class="hs-val">NATSUM</div><div class="hs-lbl">Announcement</div></div>
    </div>
</div>

<div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span>/</span>
    <span>Awards</span>
</div>

{{-- Anchor Nav --}}
<div class="anchor-nav">
    <div class="anchor-inner">
        <a href="#leaderboard" class="an-link active">Leaderboard</a>
        <a href="#categories" class="an-link">Award Categories</a>
        <a href="#past-winners" class="an-link">Past Winners</a>
        <a href="#how-points-work" class="an-link">How Points Work</a>
    </div>
</div>

{{-- ── LEADERBOARD ── --}}
<section id="leaderboard" class="section">
    <div class="container">

        <div class="announcement">
            <div class="ann-icon"><svg viewBox="0 0 24 24"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg></div>
            <div class="ann-text">
                <div class="ann-label">2025 Award Cycle — In Progress</div>
                <div class="ann-msg">Points are accumulating. Final results will be announced at NATSUM 2025 (14–16 August, Kuala Lumpur).</div>
                <div class="ann-sub">Last updated: {{ now()->format('j F Y') }}</div>
            </div>
        </div>

        <div style="margin-bottom:20px">
            <div class="section-eyebrow">2024/25 Academic Year</div>
            <h2 class="section-title">Chapter <em>Leaderboard</em></h2>
            <p class="section-sub">Rankings based on accumulated points from events, community service, sustainability initiatives, and YES collaboration activities.</p>
        </div>

        <div class="cat-tabs" style="margin-bottom:20px">
            <button class="ctab active" onclick="filterRegion('all',this)">All Regions</button>
            <button class="ctab" onclick="filterRegion('klang',this)">Klang Valley</button>
            <button class="ctab" onclick="filterRegion('northern',this)">Northern</button>
            <button class="ctab" onclick="filterRegion('southern',this)">Southern</button>
            <button class="ctab" onclick="filterRegion('east',this)">East Coast</button>
            <button class="ctab" onclick="filterRegion('eastm',this)">East Malaysia</button>
        </div>

        <div class="leaderboard reveal">
            <div class="lb-head">
                <span>Rank</span>
                <span>Chapter</span>
                <span style="text-align:center">Points</span>
                <span>Awards Earned</span>
                <span style="text-align:right">Region</span>
            </div>

            {{-- Row 1 --}}
            <div class="lb-row gold-row" data-region="klang">
                <div style="display:flex;align-items:center;gap:10px">
                    <span class="lb-rank">1</span>
                    <div class="lb-medal medal-gold">🥇</div>
                </div>
                <div>
                    <div class="lb-chapter-name">YES UTM Kuala Lumpur</div>
                    <div class="lb-chapter-uni">Universiti Teknologi Malaysia, KL Campus</div>
                </div>
                <div><div class="lb-pts">1,240</div><div class="lb-pts-lbl">pts</div></div>
                <div class="lb-awards-cell">
                    <span class="lb-badge badge-gold">Best Chapter</span>
                    <span class="lb-badge badge-cert">SDG Champion</span>
                </div>
                <div style="text-align:right;font-size:11px;color:var(--grey)">Klang Valley</div>
            </div>

            {{-- Row 2 --}}
            <div class="lb-row" data-region="northern">
                <div style="display:flex;align-items:center;gap:10px">
                    <span class="lb-rank">2</span>
                    <div class="lb-medal medal-silver">🥈</div>
                </div>
                <div>
                    <div class="lb-chapter-name">YES USM Penang</div>
                    <div class="lb-chapter-uni">Universiti Sains Malaysia, Engineering Campus</div>
                </div>
                <div><div class="lb-pts">1,105</div><div class="lb-pts-lbl">pts</div></div>
                <div class="lb-awards-cell">
                    <span class="lb-badge badge-silver">Runner-Up</span>
                    <span class="lb-badge badge-cert">Best Event</span>
                </div>
                <div style="text-align:right;font-size:11px;color:var(--grey)">Northern</div>
            </div>

            {{-- Row 3 --}}
            <div class="lb-row" data-region="southern">
                <div style="display:flex;align-items:center;gap:10px">
                    <span class="lb-rank">3</span>
                    <div class="lb-medal medal-bronze">🥉</div>
                </div>
                <div>
                    <div class="lb-chapter-name">YES UTM Johor</div>
                    <div class="lb-chapter-uni">Universiti Teknologi Malaysia, Skudai</div>
                </div>
                <div><div class="lb-pts">980</div><div class="lb-pts-lbl">pts</div></div>
                <div class="lb-awards-cell">
                    <span class="lb-badge badge-cert">Most Active</span>
                </div>
                <div style="text-align:right;font-size:11px;color:var(--grey)">Southern</div>
            </div>

            {{-- Rows 4–8 --}}
            @foreach([
                [4,'YES UTP Perak','Universiti Teknologi PETRONAS','855','klang','Klang Valley'],
                [5,'YES UNITEN KL','Universiti Tenaga Nasional, KL Campus','810','klang','Klang Valley'],
                [6,'YES UiTM Shah Alam','Universiti Teknologi MARA, Shah Alam','760','klang','Klang Valley'],
                [7,'YES UMP Gambang','Universiti Malaysia Pahang','680','east','East Coast'],
                [8,'YES UNIMAS Sarawak','Universiti Malaysia Sarawak','640','eastm','East Malaysia'],
            ] as [$rank,$name,$uni,$pts,$region,$regionLabel])
            <div class="lb-row" data-region="{{ $region }}">
                <div style="display:flex;align-items:center;gap:10px">
                    <span class="lb-rank">{{ $rank }}</span>
                    <div class="lb-medal medal-none" style="font-size:11px;font-weight:700;color:var(--grey)">{{ $rank }}</div>
                </div>
                <div>
                    <div class="lb-chapter-name">{{ $name }}</div>
                    <div class="lb-chapter-uni">{{ $uni }}</div>
                </div>
                <div><div class="lb-pts">{{ $pts }}</div><div class="lb-pts-lbl">pts</div></div>
                <div class="lb-awards-cell">—</div>
                <div style="text-align:right;font-size:11px;color:var(--grey)">{{ $regionLabel }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── AWARD CATEGORIES ── --}}
<section id="categories" class="section" style="background:#fff;border-top:1px solid var(--light);border-bottom:1px solid var(--light)">
    <div class="container">
        <div style="margin-bottom:32px" class="reveal">
            <div class="section-eyebrow">Recognition Framework</div>
            <h2 class="section-title">Award <em>Categories</em></h2>
            <p class="section-sub">Six distinct awards recognise different dimensions of student chapter excellence throughout the year.</p>
        </div>

        <div class="award-grid reveal">
            <div class="award-card">
                <div class="award-card-bar" style="background:var(--gold)"></div>
                <div class="award-icon" style="background:var(--gold-dim);color:var(--gold)">
                    <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                <div class="award-name">Best Chapter Award</div>
                <div class="award-desc">Awarded to the chapter with the highest overall performance across events, membership, collaboration, and sustainability activities during the academic year.</div>
                <span class="award-pts">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    500 pts bonus
                </span>
            </div>

            <div class="award-card">
                <div class="award-card-bar" style="background:var(--navy)"></div>
                <div class="award-icon" style="background:rgba(0,31,69,.06);color:var(--navy)">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/></svg>
                </div>
                <div class="award-name">Best Event Award</div>
                <div class="award-desc">Recognises the chapter that organised the most impactful and well-attended event in collaboration with YES during the year. Judges evaluate reach, quality, and alignment.</div>
                <span class="award-pts">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    300 pts bonus
                </span>
            </div>

            <div class="award-card">
                <div class="award-card-bar" style="background:var(--green-a)"></div>
                <div class="award-icon" style="background:rgba(76,175,125,.1);color:var(--green)">
                    <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div class="award-name">SDG Champion Award</div>
                <div class="award-desc">Awarded to the chapter with the highest engagement in sustainability-aligned activities (UN SDGs). Includes volunteer hours, green campaigns, and outreach projects.</div>
                <span class="award-pts">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    250 pts bonus
                </span>
            </div>

            <div class="award-card">
                <div class="award-card-bar" style="background:var(--amber)"></div>
                <div class="award-icon" style="background:var(--amber-l);color:var(--amber)">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="award-name">Most Active Chapter</div>
                <div class="award-desc">Recognises the chapter with the most events organised, highest average attendance per event, and strongest member participation rate throughout the academic year.</div>
                <span class="award-pts">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    200 pts bonus
                </span>
            </div>

            <div class="award-card">
                <div class="award-card-bar" style="background:#7c3aed"></div>
                <div class="award-icon" style="background:#ede9fe;color:#5b21b6">
                    <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <div class="award-name">Rising Chapter Award</div>
                <div class="award-desc">For newly established or previously inactive chapters that demonstrate significant growth and improvement in their first two years of participation with YES.</div>
                <span class="award-pts">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    150 pts bonus
                </span>
            </div>

            <div class="award-card">
                <div class="award-card-bar" style="background:#0891b2"></div>
                <div class="award-icon" style="background:#e0f2fe;color:#0369a1">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                </div>
                <div class="award-name">International Engagement</div>
                <div class="award-desc">Recognises chapters that actively participated in CAFEO delegations, ASEAN engineering partnerships, or international engineering exchange programmes.</div>
                <span class="award-pts">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    200 pts bonus
                </span>
            </div>
        </div>
    </div>
</section>

{{-- ── PAST WINNERS ── --}}
<section id="past-winners" class="section">
    <div class="container">
        <div style="margin-bottom:32px" class="reveal">
            <div class="section-eyebrow">Award History</div>
            <h2 class="section-title">Past <em>Winners</em></h2>
            <p class="section-sub">Best Chapter Award recipients from previous academic years. Full results are archived and presented at each annual NATSUM ceremony.</p>
        </div>

        <div class="winners-grid reveal">
            @foreach([
                ['2024','Best Chapter Award','YES UTM Kuala Lumpur','Universiti Teknologi Malaysia, KL','1,180 pts'],
                ['2024','Best Event Award','YES UTP Perak','Universiti Teknologi PETRONAS','920 pts'],
                ['2023','Best Chapter Award','YES USM Penang','Universiti Sains Malaysia','1,045 pts'],
                ['2023','SDG Champion','YES UNIMAS Sarawak','Universiti Malaysia Sarawak','880 pts'],
                ['2022','Best Chapter Award','YES UTM Johor','Universiti Teknologi Malaysia, Skudai','995 pts'],
                ['2022','Most Active Chapter','YES UiTM Shah Alam','Universiti Teknologi MARA','840 pts'],
                ['2021','Best Chapter Award','YES UM Kuala Lumpur','Universiti Malaya','960 pts'],
                ['2021','Rising Chapter Award','YES UNIKL','Universiti Kuala Lumpur','670 pts'],
            ] as [$year,$award,$chapter,$uni,$pts])
            <div class="winner-card reveal">
                <div class="winner-year">{{ $year }}</div>
                <div class="winner-content">
                    <div class="winner-award">{{ $award }}</div>
                    <div class="winner-chapter">{{ $chapter }}</div>
                    <div class="winner-uni">{{ $uni }}</div>
                    <div class="winner-pts">{{ $pts }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── HOW POINTS WORK ── --}}
<section id="how-points-work" class="section" style="background:#fff;border-top:1px solid var(--light)">
    <div class="container">
        <div style="margin-bottom:32px" class="reveal">
            <div class="section-eyebrow">Scoring System</div>
            <h2 class="section-title">How <em>Points Work</em></h2>
            <p class="section-sub">Points are assigned by YES administrators based on verified activity type and quality. All submissions are reviewed before points are recorded.</p>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px" class="reveal">
            <div style="background:var(--off);border:1px solid var(--light);padding:24px">
                <div style="font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);margin-bottom:16px;border-bottom:1px solid var(--light);padding-bottom:10px">Activity Point Values</div>
                @foreach([
                    ['YES Collaboration Event','100 – 200 pts','Per approved event with YES co-branding'],
                    ['Sustainability / SDG Activity','50 – 150 pts','Volunteer work, green campaigns, outreach'],
                    ['Annual Report Submission','50 pts','On-time, complete, approved submission'],
                    ['Org Chart Approved','25 pts','Verified org structure submitted and approved'],
                    ['NATSUM Participation','100 pts','Delegation registered and attended'],
                    ['CAFEO Delegation','150 pts','International conference participation'],
                    ['Industry Talk / Webinar','30 – 80 pts','Based on attendance and speaker quality'],
                ] as [$act,$pts,$note])
                <div style="display:grid;grid-template-columns:1fr 80px;gap:8px;padding:10px 0;border-bottom:1px solid var(--light);align-items:start">
                    <div>
                        <div style="font-size:12px;font-weight:600;color:var(--navy-dark)">{{ $act }}</div>
                        <div style="font-size:11px;color:var(--grey);margin-top:2px">{{ $note }}</div>
                    </div>
                    <div style="text-align:right;font-family:'Playfair Display',serif;font-size:14px;font-weight:700;color:var(--gold)">{{ $pts }}</div>
                </div>
                @endforeach
            </div>

            <div style="background:var(--off);border:1px solid var(--light);padding:24px">
                <div style="font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);margin-bottom:16px;border-bottom:1px solid var(--light);padding-bottom:10px">Evaluation Timeline</div>
                @foreach([
                    ['1','Submit Activity','Chapter submits event/activity through the YES portal after completion.','var(--navy)'],
                    ['2','Admin Review','YES admin reviews submission documents and verifies activity details.','var(--gold)'],
                    ['3','Points Assigned','Admin assigns appropriate point value; chapter is notified.','var(--green-a)'],
                    ['4','Leaderboard Updated','Points appear on the public leaderboard within 3 working days.','var(--navy)'],
                    ['5','NATSUM Ceremony','Final rankings confirmed; awards presented at the annual ceremony.','var(--gold)'],
                ] as [$num,$title,$desc,$color])
                <div style="display:flex;gap:12px;padding:12px 0;border-bottom:1px solid var(--light)">
                    <div style="width:26px;height:26px;border-radius:50%;background:{{ $color }};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0">{{ $num }}</div>
                    <div>
                        <div style="font-size:12px;font-weight:700;color:var(--navy-dark);margin-bottom:2px">{{ $title }}</div>
                        <div style="font-size:11px;color:var(--grey);line-height:1.55">{{ $desc }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<footer class="site-footer">
  <div class="footer-mini">
    <div>
      <a href="{{ route('home') }}" style="display:inline-block;margin-bottom:14px;">
        <img src="{{ asset('images/iem-yes-logo.png') }}" alt="IEM Young Engineers Section" style="height:44px;width:auto;display:block;"/>
      </a>
      <p>Young Engineer Section (YES) — the youth arm of the Institution of Engineers Malaysia (IEM), empowering the next generation of engineering professionals since 1987.</p>
    </div>
    <div>
      <h4>Awards</h4>
      <ul>
        <li><a href="{{ route('awards') }}#leaderboard">Chapter Leaderboard</a></li>
        <li><a href="{{ route('awards') }}#categories">Award Categories</a></li>
        <li><a href="{{ route('awards') }}#past-winners">Past Winners</a></li>
        <li><a href="{{ route('awards') }}#how-points-work">How Points Work</a></li>
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
    <span>© {{ date('Y') }} YES – Young Engineer Section, IEM Malaysia. All rights reserved.</span>
    <div><a href="#">Privacy Policy</a><a href="#">Terms of Use</a></div>
  </div>
</footer>

<script>
// Anchor nav active state on scroll
const sections = ['leaderboard','categories','past-winners','how-points-work'];
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            document.querySelectorAll('.an-link').forEach(l => l.classList.remove('active'));
            const link = document.querySelector(`.an-link[href="#${e.target.id}"]`);
            if (link) link.classList.add('active');
        }
    });
}, {rootMargin:'-30% 0px -60% 0px'});
sections.forEach(id => { const el = document.getElementById(id); if(el) observer.observe(el); });

// Region filter
function filterRegion(region, btn) {
    document.querySelectorAll('.lb-row').forEach(row => {
        row.style.display = (region === 'all' || row.dataset.region === region) ? '' : 'none';
    });
    document.querySelectorAll('.ctab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

// Scroll reveal
const revealEls = document.querySelectorAll('.reveal');
const revObs = new IntersectionObserver(entries => {
    entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
}, {threshold:0.1});
revealEls.forEach(el => revObs.observe(el));
</script>
</body>
</html>
