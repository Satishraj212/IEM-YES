@php
  $statusColors = ['planning'=>'#f59e0b','upcoming'=>'#3b82f6','open'=>'#10b981','past'=>'#9ca3af'];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>{{ $flagshipEvent->short_name }} {{ $flagshipEvent->year }} — {{ $flagshipEvent->full_name }} | YES IEM Malaysia</title>
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

/* ── HERO ── */
.detail-hero { background: var(--navy-dark); min-height: 65vh; display: flex; align-items: center; position: relative; overflow: hidden; }
.detail-hero::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, #001f45 0%, #003366 55%, #0a4a8c 100%); }
.hero-watermark { position: absolute; right: -40px; top: 50%; transform: translateY(-50%); font-family: 'Playfair Display', serif; font-size: 220px; font-weight: 900; color: rgba(255,255,255,0.025); letter-spacing: -8px; line-height: 1; pointer-events: none; user-select: none; }
.detail-hero-content { position: relative; z-index: 2; padding: 80px 60px; max-width: 820px; }

.breadcrumb { display: flex; align-items: center; gap: 8px; margin-bottom: 24px; }
.breadcrumb a { font-size: 12px; color: rgba(255,255,255,0.45); text-decoration: none; letter-spacing: .5px; transition: color .2s; }
.breadcrumb a:hover { color: var(--gold); }
.breadcrumb span { font-size: 12px; color: rgba(255,255,255,0.25); }

.event-pill { display: inline-flex; align-items: center; gap: 8px; background: rgba(200,168,75,0.12); border: 1px solid rgba(200,168,75,0.3); padding: 6px 16px; margin-bottom: 22px; }
.event-pill span { font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); }
.status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; font-size: 9px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; }

.detail-hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(48px, 7vw, 82px); color: var(--white); font-weight: 900; line-height: 0.95; margin-bottom: 8px; }
.detail-hero h1 .accent { color: var(--gold); }
.full-name { font-size: 18px; color: rgba(255,255,255,0.55); letter-spacing: 2px; margin-bottom: 12px; }
.event-theme { font-size: 14px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--gold); opacity: .85; margin-bottom: 20px; }
.detail-hero p.hero-desc { font-size: 17px; color: rgba(255,255,255,0.75); line-height: 1.8; max-width: 580px; margin-bottom: 32px; }

.hero-meta { display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 32px; }
.hero-meta-item { display: flex; align-items: center; gap: 8px; }
.hero-meta-item svg { width: 14px; height: 14px; stroke: var(--gold); fill: none; stroke-width: 2; flex-shrink: 0; }
.hero-meta-item span { font-size: 13px; color: rgba(255,255,255,0.65); }

.btn-gold { background: var(--gold); color: var(--navy-dark); padding: 14px 32px; font-weight: 700; font-size: 13px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all .2s; border: 2px solid var(--gold); }
.btn-gold:hover { background: transparent; color: var(--gold); }
.btn-ghost { border: 2px solid rgba(255,255,255,0.3); color: rgba(255,255,255,0.8); padding: 14px 32px; font-weight: 600; font-size: 13px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all .2s; }
.btn-ghost:hover { border-color: var(--gold); color: var(--gold); }

/* ── BLOG BODY ── */
.blog-wrap { max-width: 800px; margin: 0 auto; padding: 72px 60px; }
.blog-body { font-size: 16px; line-height: 1.9; color: #333; }
.blog-body h2 { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 900; color: var(--navy); margin: 48px 0 16px; line-height: 1.2; }
.blog-body h2:first-child { margin-top: 0; }
.blog-body h3 { font-size: 20px; font-weight: 700; color: var(--navy); margin: 32px 0 12px; }
.blog-body p { margin-bottom: 18px; }
.blog-body ul, .blog-body ol { margin: 0 0 18px 24px; }
.blog-body li { margin-bottom: 8px; }
.blog-body strong { color: var(--navy-dark); }
.blog-body a { color: var(--navy); text-decoration: underline; transition: color .2s; }
.blog-body a:hover { color: var(--gold); }
.blog-body blockquote { border-left: 3px solid var(--gold); padding: 14px 20px; margin: 24px 0; background: var(--offwhite); color: #555; font-style: italic; }
.blog-body hr { border: none; border-top: 1px solid var(--light-grey); margin: 40px 0; }
.blog-body table { width: 100%; border-collapse: collapse; margin-bottom: 24px; font-size: 14px; }
.blog-body th { background: var(--navy); color: var(--gold); padding: 10px 14px; text-align: left; font-size: 11px; letter-spacing: 1px; text-transform: uppercase; }
.blog-body td { padding: 10px 14px; border-bottom: 1px solid var(--light-grey); }
.blog-body tr:last-child td { border-bottom: none; }

/* No content placeholder */
.no-content { padding: 72px 60px; max-width: 800px; margin: 0 auto; text-align: center; }
.no-content p { font-size: 15px; color: var(--grey); line-height: 1.8; }

/* ── DIVIDER STRIP ── */
.divider-strip { height: 4px; background: linear-gradient(90deg, var(--navy) 0%, var(--gold) 50%, var(--navy) 100%); }

/* footer */
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

.back-top { position: fixed; bottom: 32px; right: 32px; width: 46px; height: 46px; background: var(--gold); color: var(--navy-dark); display: flex; align-items: center; justify-content: center; font-size: 20px; cursor: pointer; opacity: 0; transition: opacity .3s; z-index: 999; text-decoration: none; font-weight: 700; }
.back-top.visible { opacity: 1; }
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
          <li><a href="{{ route('milestone') }}">Milestones</a></li>
        </ul></div>
        <div class="mega-col"><h4>Leadership</h4><ul>
          <li><a href="#">YES HQ Office Bearers</a></li>
          <li><a href="#">YES State Branches</a></li>
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
          <li><a href="{{ route('natsum') }}">NATSUM</a></li>
          <li><a href="{{ route('cafeo') }}">CAFEO</a></li>
        </ul></div>
      </div>
    </li>
    <li><a href="{{ route('awards') }}">Awards</a></li>
    <li><a href="{{ route('home') }}#footer">Contact Us</a></li>
  </ul>
</nav>

<!-- ══ HERO ══ -->
<div class="detail-hero">
  <div class="hero-watermark">{{ $flagshipEvent->short_name }}</div>
  <div class="detail-hero-content">

    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span>/</span>
      <a href="{{ strtolower($flagshipEvent->short_name) === 'natsum' ? route('natsum') : route('cafeo') }}">{{ $flagshipEvent->short_name }}</a>
      <span>/</span>
      <a href="#" style="color:rgba(255,255,255,0.55)">{{ $flagshipEvent->year }}</a>
    </div>

    <div style="display:flex;align-items:center;gap:10px;margin-bottom:22px;flex-wrap:wrap">
      <div class="event-pill">
        <span>Flagship Event</span>
      </div>
      <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 12px;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;background:rgba(200,168,75,0.1)">
        <span style="width:6px;height:6px;border-radius:50%;background:{{ $statusColors[$flagshipEvent->status] ?? '#9ca3af' }};display:inline-block"></span>
        <span style="color:rgba(255,255,255,0.7)">{{ ucfirst($flagshipEvent->status) }}</span>
      </span>
    </div>

    <h1>{{ strtoupper(substr($flagshipEvent->short_name, 0, 3)) }}<span class="accent">{{ strtoupper(substr($flagshipEvent->short_name, 3)) }}</span></h1>
    <div class="full-name">{{ $flagshipEvent->full_name }}</div>

    @if($flagshipEvent->theme)
    <div class="event-theme">{{ $flagshipEvent->theme }}</div>
    @endif

    @if($flagshipEvent->description)
    <p class="hero-desc">{{ $flagshipEvent->description }}</p>
    @endif

    <div class="hero-meta">
      @if($flagshipEvent->event_date)
      <div class="hero-meta-item">
        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <span>{{ $flagshipEvent->event_date }}</span>
      </div>
      @endif
      @if($flagshipEvent->location)
      <div class="hero-meta-item">
        <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        <span>{{ $flagshipEvent->location }}</span>
      </div>
      @endif
      @if($flagshipEvent->host)
      <div class="hero-meta-item">
        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        <span>Hosted by {{ $flagshipEvent->host }}</span>
      </div>
      @endif
      @if($flagshipEvent->expected_delegates)
      <div class="hero-meta-item">
        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        <span>{{ number_format($flagshipEvent->expected_delegates) }} expected delegates</span>
      </div>
      @endif
    </div>

    <div style="display:flex;gap:14px;flex-wrap:wrap">
      @if($flagshipEvent->registration_url && in_array($flagshipEvent->status, ['upcoming','open']))
      <a href="{{ $flagshipEvent->registration_url }}" target="_blank" class="btn-gold">Register Now →</a>
      @endif
      <a href="{{ strtolower($flagshipEvent->short_name) === 'natsum' ? route('natsum') : route('cafeo') }}" class="btn-ghost">← Back to {{ $flagshipEvent->short_name }}</a>
    </div>

  </div>
</div>

<div class="divider-strip"></div>

<!-- ══ BLOG CONTENT ══ -->
@if($flagshipEvent->content)
<div class="blog-wrap">
  <div class="blog-body">
    {!! $flagshipEvent->content !!}
  </div>
</div>
@else
<div class="no-content">
  <p style="margin-bottom:16px;font-size:32px;line-height:1">📋</p>
  <p>Full event details and programme for <strong>{{ $flagshipEvent->short_name }} {{ $flagshipEvent->year }}</strong> are coming soon.<br/>Check back closer to the event date for updates.</p>
  @if($flagshipEvent->registration_url && in_array($flagshipEvent->status, ['upcoming','open']))
  <a href="{{ $flagshipEvent->registration_url }}" target="_blank" class="btn-gold" style="margin-top:24px;display:inline-flex">Register Now →</a>
  @endif
</div>
@endif

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
        <li><a href="#">yes@iem.org.my</a></li>
        <li><a href="#">Putrajaya, Malaysia</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© {{ now()->year }} YES – Young Engineer Section, IEM Malaysia. All rights reserved.</span>
    <div><a href="#">Privacy Policy</a><a href="#">Terms of Use</a></div>
  </div>
</footer>

<a href="#" class="back-top" id="backTop">↑</a>

<script>
window.addEventListener('scroll', () => {
  document.getElementById('backTop').classList.toggle('visible', window.scrollY > 400);
});
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const id = a.getAttribute('href').slice(1);
    const el = document.getElementById(id);
    if (el) { e.preventDefault(); el.scrollIntoView({ behavior: 'smooth' }); }
  });
});
</script>
</body>
</html>
