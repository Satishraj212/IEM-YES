<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>@yield('title', 'YES – Young Engineer Section | IEM Malaysia')</title>
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
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }
body { font-family: 'DM Sans', sans-serif; color: #222; background: var(--white); overflow-x: hidden; }

/* ── TOP BAR ── */
.top-bar { background: var(--navy-dark); color: rgba(255,255,255,0.65); font-size: 12px; display: flex; justify-content: flex-end; align-items: center; gap: 24px; padding: 7px 60px; }
.top-bar a, .top-bar button { color: rgba(255,255,255,0.65); text-decoration: none; transition: color .2s; background: none; border: none; font-size: 12px; font-family: 'DM Sans', sans-serif; cursor: pointer; padding: 0; }
.top-bar a:hover, .top-bar button:hover { color: var(--gold); }
.top-bar .sep { color: rgba(255,255,255,0.2); }

/* ── MAIN NAV ── */
nav { position: sticky; top: 0; z-index: 1000; background: var(--white); border-bottom: 3px solid var(--gold); display: flex; align-items: center; justify-content: space-between; padding: 0 60px; height: 72px; box-shadow: 0 2px 20px rgba(0,0,0,0.08); }
.logo { display: flex; align-items: center; text-decoration: none; }
.nav-logo-img { height: 52px; width: auto; display: block; object-fit: contain; }
.nav-links { display: flex; list-style: none; height: 100%; }
.nav-links > li { position: relative; height: 100%; display: flex; align-items: center; }
.nav-links > li > a { display: flex; align-items: center; gap: 5px; padding: 0 22px; height: 100%; text-decoration: none; color: var(--navy); font-size: 14px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; transition: color .2s; position: relative; }
.nav-links > li > a::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: var(--gold); transform: scaleX(0); transition: transform .25s ease; }
.nav-links > li:hover > a,
.nav-links > li.active > a { color: var(--gold); }
.nav-links > li:hover > a::after,
.nav-links > li.active > a::after { transform: scaleX(1); }
.nav-arrow { width: 0; height: 0; border-left: 4px solid transparent; border-right: 4px solid transparent; border-top: 5px solid currentColor; transition: transform .2s; }
.nav-links > li:hover .nav-arrow { transform: rotate(180deg); }

/* ── MEGA MENU ── */
.mega-menu { position: absolute; top: 100%; left: 0; width: max-content; min-width: 420px; max-width: min(720px, calc(100vw - 60px)); background: var(--white); box-shadow: 0 20px 60px rgba(0,51,102,0.15); display: grid; grid-template-columns: 1fr 1fr; opacity: 0; pointer-events: none; transform: translateY(-8px); transition: all .25s ease; border-top: 3px solid var(--gold); }
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
.flagship-empty-note { font-size: 11px; color: var(--grey); font-style: italic; padding: 4px 0; }

/* ── COMMON BUTTONS ── */
.btn-gold { background: var(--gold); color: var(--navy-dark); padding: 14px 32px; font-weight: 700; font-size: 13px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all .2s; border: 2px solid var(--gold); }
.btn-gold:hover { background: transparent; color: var(--gold); }
.btn-outline { border: 2px solid rgba(255,255,255,0.7); color: var(--white); padding: 14px 32px; font-weight: 600; font-size: 13px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all .2s; }
.btn-outline:hover { background: var(--white); color: var(--navy); }
.btn-ghost { border: 2px solid rgba(255,255,255,0.3); color: rgba(255,255,255,0.85); padding: 15px 36px; font-weight: 600; font-size: 13px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all .2s; }
.btn-ghost:hover { border-color: var(--gold); color: var(--gold); }
.btn-navy { background: var(--navy); color: var(--white); padding: 12px 28px; font-weight: 700; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all .2s; border: 2px solid var(--navy); }
.btn-navy:hover { background: transparent; color: var(--navy); }

/* ── PAGE HERO (inner pages) ── */
.page-hero { background: var(--navy-dark); padding: 72px 60px 52px; position: relative; overflow: hidden; }
.page-hero::before { content: ''; position: absolute; top: -80px; right: -80px; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(200,168,75,0.06) 0%, transparent 70%); }
.page-hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--gold) 0%, transparent 60%); }
.breadcrumb { display: flex; align-items: center; gap: 8px; margin-bottom: 18px; font-size: 12px; letter-spacing: 1.5px; text-transform: uppercase; }
.breadcrumb a { color: rgba(255,255,255,0.5); text-decoration: none; transition: color .2s; }
.breadcrumb a:hover { color: var(--gold); }
.breadcrumb span { color: rgba(255,255,255,0.25); }
.breadcrumb .current { color: var(--gold); }
.page-hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(32px, 4vw, 52px); color: var(--white); font-weight: 900; line-height: 1.1; }
.page-hero h1 em { color: var(--gold); font-style: normal; }
.page-hero-sub { font-size: 16px; color: rgba(255,255,255,0.65); margin-top: 14px; max-width: 560px; line-height: 1.7; }
.hero-inner { display: flex; align-items: flex-end; justify-content: space-between; gap: 40px; }
.hero-left h1 { font-family: 'Playfair Display', serif; font-size: clamp(32px, 4vw, 52px); color: var(--white); font-weight: 900; line-height: 1.1; }
.hero-left h1 em { color: var(--gold); font-style: normal; }
.hero-left p { font-size: 15px; color: rgba(255,255,255,0.65); margin-top: 14px; max-width: 500px; line-height: 1.7; }
.hero-stat { text-align: right; flex-shrink: 0; }
.hero-stat .big { font-family: 'Playfair Display', serif; font-size: 56px; font-weight: 900; color: var(--gold); line-height: 1; }
.hero-stat .lbl { font-size: 11px; color: rgba(255,255,255,0.5); letter-spacing: 2px; text-transform: uppercase; margin-top: 4px; }

/* ── SECTION HELPERS ── */
.section-label { font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 10px; }
.section-title { font-family: 'Playfair Display', serif; font-size: clamp(28px, 3vw, 42px); color: var(--navy); font-weight: 900; line-height: 1.15; max-width: 620px; }
.section-title em { color: var(--gold); font-style: normal; }
.content-section { padding: 80px 60px; }
.content-section.alt { background: var(--offwhite); }
.divider { width: 48px; height: 4px; background: var(--gold); margin: 20px 0 32px; }

/* ── SCROLL REVEAL ── */
.reveal { opacity: 0; transform: translateY(30px); transition: opacity .7s ease, transform .7s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-delay-1 { transition-delay: .1s; }
.reveal-delay-2 { transition-delay: .2s; }
.reveal-delay-3 { transition-delay: .3s; }
@keyframes fadeUp { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:translateY(0); } }
.animate-in { animation: fadeUp .6s ease both; }

/* ── IMAGE PLACEHOLDERS ── */
.img-p1 { background: linear-gradient(135deg,#1a3a6b 0%,#2460a7 100%); }
.img-p2 { background: linear-gradient(135deg,#0d4a2b 0%,#2d8a55 100%); }
.img-p3 { background: linear-gradient(135deg,#6b1a1a 0%,#a74424 100%); }
.img-p4 { background: linear-gradient(135deg,#4a1a6b 0%,#7a44a7 100%); }
.img-p5 { background: linear-gradient(135deg,#1a5a6b 0%,#2490a7 100%); }

/* ── FOOTER ── */
footer { background: var(--navy-dark); padding: 60px 60px 0; }
.footer-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr 1.2fr; gap: 40px; padding-bottom: 48px; border-bottom: 1px solid rgba(255,255,255,0.1); }
.footer-brand p { font-size: 13.5px; color: rgba(255,255,255,0.6); line-height: 1.8; max-width: 260px; margin-bottom: 20px; }
.social-links { display: flex; gap: 10px; }
.social-link { width: 36px; height: 36px; border: 1px solid rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px; font-weight: 700; transition: all .2s; }
.social-link:hover { border-color: var(--gold); color: var(--gold); }
.footer-col h4 { font-size: 11px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase; color: var(--gold); margin-bottom: 20px; }
.footer-col ul { list-style: none; }
.footer-col ul li { margin-bottom: 10px; }
.footer-col ul li a { color: rgba(255,255,255,0.6); text-decoration: none; font-size: 13.5px; transition: color .2s; }
.footer-col ul li a:hover { color: var(--white); }
.contact-item { display: flex; gap: 12px; margin-bottom: 16px; font-size: 13.5px; color: rgba(255,255,255,0.6); }
.contact-icon { color: var(--gold); flex-shrink: 0; margin-top: 2px; }
.footer-bottom { padding: 20px 0; display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: rgba(255,255,255,0.35); }
.footer-bottom a { color: rgba(255,255,255,0.35); text-decoration: none; }
.footer-bottom a:hover { color: var(--gold); }
.footer-bottom-links { display: flex; gap: 24px; }

/* ── BACK TO TOP ── */
.back-top { position: fixed; bottom: 32px; right: 32px; width: 46px; height: 46px; background: var(--gold); color: var(--navy-dark); display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700; cursor: pointer; opacity: 0; transition: opacity .3s; z-index: 999; text-decoration: none; }
.back-top.visible { opacity: 1; }
</style>
@stack('styles')
</head>
<body>

{{-- ── TOP UTILITY BAR ── --}}
<div class="top-bar">
  @auth
    @if(auth()->user()->role === 'admin')
      <a href="{{ route('admin.dashboard') }}">Admin Panel</a>
    @else
      <a href="{{ route('student.overview') }}">My Dashboard</a>
    @endif
    <span class="sep">|</span>
    <form method="POST" action="{{ route('logout') }}" style="display:inline">
      @csrf
      <button type="submit">Logout</button>
    </form>
  @else
    <a href="{{ route('login.admin') }}">Admin Login</a>
    <span class="sep">|</span>
    <a href="{{ route('login.student') }}">Student Login</a>
  @endauth
  <span class="sep">|</span>
  <a href="#">Careers</a>
  <a href="#">Media</a>
</div>

{{-- ── MAIN NAVIGATION ── --}}
<nav>
  <a class="logo" href="{{ route('home') }}">
    <img src="{{ asset('images/iem-yes-logo.png') }}" alt="IEM Young Engineers Section" class="nav-logo-img"/>
  </a>

  <ul class="nav-links">

    {{-- About Us --}}
    <li class="{{ ($activeNav ?? '') === 'about' ? 'active' : '' }}">
      <a href="{{ route('who-we-are') }}">About Us <span class="nav-arrow"></span></a>
      <div class="mega-menu">
        <div class="mega-col">
          <h4>Who We Are</h4>
          <ul>
            <li><a href="{{ route('who-we-are') }}#vision-mission" class="{{ Request::routeIs('who-we-are') ? 'active-link' : '' }}">Mission &amp; Vision</a></li>
            <li><a href="{{ route('who-we-are') }}#values">Values</a></li>
            <li><a href="{{ route('who-we-are') }}#where-we-are">Where We Are</a></li>
            <li><a href="{{ route('milestone') }}" class="{{ Request::routeIs('milestone') ? 'active-link' : '' }}">Milestones</a></li>
          </ul>
        </div>
        <div class="mega-col">
          <h4>Leadership</h4>
          <ul>
            <li><a href="{{ route('leadership.hq') }}" class="{{ Request::routeIs('leadership.hq') ? 'active-link' : '' }}">YES HQ Office Bearers</a></li>
            <li><a href="{{ route('leadership.states') }}" class="{{ Request::routeIs('leadership.states') ? 'active-link' : '' }}">YES State Branches</a></li>
            <li><a href="{{ route('leadership.chapters') }}" class="{{ Request::routeIs('leadership.chapters') ? 'active-link' : '' }}">Student Section Chapters</a></li>
          </ul>
        </div>
      </div>
    </li>

    {{-- Events --}}
    <li class="{{ ($activeNav ?? '') === 'events' ? 'active' : '' }}">
      <a href="#">Events <span class="nav-arrow"></span></a>
      <div class="mega-menu">
        <div class="mega-col">
          <h4>General Events</h4>
          <ul>
            <li><a href="{{ route('official-board-events') }}" class="{{ Request::routeIs('official-board-events') ? 'active-link' : '' }}">Official Board Events</a></li>
            <li><a href="{{ route('student-section-events') }}" class="{{ Request::routeIs('student-section-events') ? 'active-link' : '' }}">Student Section Events</a></li>
            <li><a href="{{ route('sustainability-events') }}" class="{{ Request::routeIs('sustainability-events') ? 'active-link' : '' }}">Sustainability Events</a></li>
          </ul>
        </div>
        <div class="mega-col">
          <h4>Flagship Events</h4>
          <ul>
            @forelse($flagshipNavItems as $item)
              @php
                $fSlug   = strtolower($item->short_name);
                $fUrl    = route('flagship.slug', $fSlug);
                $fActive = Request::routeIs('flagship.slug') && request()->route('short_name') === $fSlug;
              @endphp
              <li>
                <a href="{{ $fUrl }}" class="{{ $fActive ? 'active-link' : '' }}">
                  {{ $item->short_name }} {{ $item->year }}
                  @if($item->status === 'open')
                    <span style="margin-left:6px;font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;background:var(--gold);color:var(--navy-dark);padding:2px 6px;">OPEN</span>
                  @endif
                </a>
              </li>
            @empty
              <li><span style="font-size:12px;color:var(--grey);padding:4px 0;display:block">No flagship events yet</span></li>
            @endforelse
          </ul>
        </div>
      </div>
    </li>

    {{-- Awards --}}
    <li class="{{ ($activeNav ?? '') === 'awards' ? 'active' : '' }}">
      <a href="{{ route('awards') }}">Awards <span class="nav-arrow"></span></a>
      <div class="mega-menu">
        <div class="mega-col">
          <h4>Recognition</h4>
          <ul>
            <li><a href="{{ route('awards') }}" class="{{ Request::routeIs('awards') ? 'active-link' : '' }}">YES Excellence Awards</a></li>
            <li><a href="{{ route('awards') }}">Young Engineer Award</a></li>
            <li><a href="{{ route('awards') }}">Best Student Branch</a></li>
          </ul>
        </div>
        <div class="mega-col">
          <h4>Nominate</h4>
          <ul>
            <li><a href="{{ route('login.student') }}">Submit a Nomination</a></li>
            <li><a href="{{ route('awards') }}">Past Recipients</a></li>
          </ul>
        </div>
      </div>
    </li>

    {{-- Sustainability --}}
    <li class="{{ ($activeNav ?? '') === 'sustainability' ? 'active' : '' }}">
      <a href="{{ route('sustainability') }}">Sustainability <span class="nav-arrow"></span></a>
      <div class="mega-menu single-col">
        <div class="mega-col">
          <h4>Our Commitments</h4>
          <ul>
            <li><a href="{{ route('sustainability') }}#initiative" class="{{ Request::routeIs('sustainability') ? 'active-link' : '' }}">Sustainability Initiative</a></li>
            <li><a href="{{ route('sustainability') }}#pledge">Sustainability Pledge</a></li>
            <li><a href="{{ route('sustainability') }}#declaration">Sustainability Declaration</a></li>
            <li><a href="{{ route('sustainability-events') }}" class="{{ Request::routeIs('sustainability-events') ? 'active-link' : '' }}">SDG Events</a></li>
          </ul>
        </div>
      </div>
    </li>

    {{-- Contact --}}
    <li>
      <a href="{{ route('home') }}#footer">Contact Us</a>
    </li>

  </ul>
</nav>

{{-- ── PAGE CONTENT ── --}}
@yield('content')

{{-- ── FOOTER ── --}}
<footer id="footer">
  <div class="footer-grid">
    <div class="footer-brand">
      <img src="{{ asset('images/iem-yes-logo.png') }}" alt="IEM Young Engineers Section" style="height:52px;width:auto;display:block;margin-bottom:16px;"/>
      <p>Young Engineer Section (YES) — the youth arm of the Institution of Engineers Malaysia (IEM), empowering the next generation of engineering professionals since 1987.</p>
      <div class="social-links">
        <a class="social-link" href="#">f</a>
        <a class="social-link" href="#">in</a>
        <a class="social-link" href="#">ig</a>
        <a class="social-link" href="#">yt</a>
      </div>
    </div>
    <div class="footer-col">
      <h4>About</h4>
      <ul>
        <li><a href="{{ route('who-we-are') }}#vision-mission">Mission &amp; Vision</a></li>
        <li><a href="{{ route('who-we-are') }}#values">Values</a></li>
        <li><a href="{{ route('milestone') }}">Milestones</a></li>
        <li><a href="{{ route('leadership') }}">Leadership</a></li>
        <li><a href="{{ route('who-we-are') }}#where-we-are">State Branches</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Events</h4>
      <ul>
        <li><a href="{{ route('official-board-events') }}">Official Board Events</a></li>
        <li><a href="{{ route('student-section-events') }}">Student Section Events</a></li>
        <li><a href="{{ route('sustainability-events') }}">Sustainability Events</a></li>
        @foreach($flagshipNavItems as $item)
          <li><a href="{{ route('flagship.slug', strtolower($item->short_name)) }}">{{ $item->short_name }}</a></li>
        @endforeach
      </ul>
    </div>
    <div class="footer-col">
      <h4>Contact Us</h4>
      <div class="contact-item"><span class="contact-icon">📍</span><span>YES HQ, Level 8, Menara Ingenieur, 1005-1 Jalan P/5, Precinct 5, 62200 Putrajaya, Malaysia</span></div>
      <div class="contact-item"><span class="contact-icon">📞</span><span>+603 8890 1234</span></div>
      <div class="contact-item"><span class="contact-icon">✉️</span><span>secretariat@yes-iem.org.my</span></div>
      <div class="contact-item"><span class="contact-icon">🕐</span><span>Mon – Fri: 9:00 AM – 5:30 PM</span></div>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© {{ date('Y') }} YES – Young Engineer Section, IEM Malaysia. All rights reserved.</span>
    <div class="footer-bottom-links">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Use</a>
      <a href="#">Sitemap</a>
    </div>
  </div>
</footer>

<a href="#" class="back-top" id="backTop">↑</a>

<script>
window.addEventListener('scroll', () => {
  const bt = document.getElementById('backTop');
  if (bt) bt.classList.toggle('visible', window.scrollY > 400);
});

const _revObs = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.08 });
document.querySelectorAll('.reveal').forEach(el => _revObs.observe(el));
</script>
@stack('scripts')

</body>
</html>
