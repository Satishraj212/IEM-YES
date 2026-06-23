@extends('public.layouts.app')

@section('title', 'YES – Young Engineer Section | IEM Malaysia')

@push('styles')
<style>
/* ── HERO SLIDER ── */
.hero { position: relative; height: 90vh; min-height: 580px; overflow: hidden; }
.slide { position: absolute; inset: 0; opacity: 0; transition: opacity 1.2s ease; display: flex; align-items: center; }
.slide.active { opacity: 1; z-index: 1; }
.slide-bg { position: absolute; inset: 0; background-size: cover; background-position: center; transform: scale(1.05); transition: transform 8s ease; }
.slide.active .slide-bg { transform: scale(1); }
.slide-overlay { position: absolute; inset: 0; background: linear-gradient(105deg, rgba(0,31,69,0.82) 0%, rgba(0,51,102,0.45) 55%, transparent 100%); }
.slide-content { position: relative; z-index: 2; padding: 0 80px; max-width: 700px; }
.slide-label { display: inline-block; background: var(--gold); color: var(--navy-dark); font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; padding: 6px 14px; margin-bottom: 20px; }
.slide-content h1 { font-family: 'Playfair Display', serif; font-size: clamp(36px, 5vw, 62px); color: var(--white); line-height: 1.1; font-weight: 900; margin-bottom: 20px; }
.slide-content p { color: rgba(255,255,255,0.85); font-size: 17px; line-height: 1.7; margin-bottom: 32px; max-width: 520px; }
.hero-dots { position: absolute; bottom: 28px; left: 80px; z-index: 10; display: flex; gap: 10px; }
.dot { width: 28px; height: 4px; background: rgba(255,255,255,0.4); cursor: pointer; transition: all .3s; }
.dot.active { background: var(--gold); width: 44px; }
.hero-counter { position: absolute; bottom: 28px; right: 60px; z-index: 10; color: rgba(255,255,255,0.6); font-size: 13px; letter-spacing: 2px; }
.hero-counter span { color: var(--white); font-weight: 700; font-size: 18px; }
.slide:nth-child(1) .slide-bg { background: linear-gradient(135deg, #001f45 30%, #0a4a8c 70%, #1a6b3c 100%); }
.slide:nth-child(2) .slide-bg { background: linear-gradient(135deg, #2d0a0a 0%, #8a1515 40%, #1a3a6b 100%); }
.slide:nth-child(3) .slide-bg { background: linear-gradient(135deg, #0d4a2b 0%, #1a6b3c 50%, #003366 100%); }
/* ── STATS STRIP ── */
.stats-strip { background: var(--navy); padding: 36px 60px; display: grid; grid-template-columns: repeat(4,1fr); }
.stat-item { text-align: center; padding: 12px 0; border-right: 1px solid rgba(255,255,255,0.12); }
.stat-item:last-child { border-right: none; }
.stat-item .num { font-family: 'Playfair Display', serif; font-size: 38px; font-weight: 900; color: var(--gold); display: block; line-height: 1; }
.stat-item .label { font-size: 12px; color: rgba(255,255,255,0.65); letter-spacing: 1.5px; text-transform: uppercase; margin-top: 6px; display: block; }
/* ── ABOUT STRIP ── */
.about-strip { background: var(--offwhite); padding: 80px 60px; }
.about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 72px; align-items: center; }
.about-visual { position: relative; height: 420px; }
.about-img-main { position: absolute; top: 0; left: 0; width: 80%; height: 85%; background: linear-gradient(135deg, var(--navy) 0%, #1a5fa8 100%); display: flex; align-items: center; justify-content: center; }
.about-img-main .big-text { font-family: 'Playfair Display', serif; font-size: 80px; font-weight: 900; color: rgba(255,255,255,0.12); line-height: 1; }
.about-img-accent { position: absolute; bottom: 0; right: 0; width: 45%; height: 40%; background: var(--gold); display: flex; align-items: center; justify-content: center; }
.about-img-accent p { font-family: 'Playfair Display', serif; font-size: 36px; font-weight: 900; color: var(--navy-dark); text-align: center; line-height: 1; }
.about-img-accent small { display: block; font-family: 'DM Sans', sans-serif; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; color: var(--navy-dark); opacity: 0.65; }
.about-content p { font-size: 15px; line-height: 1.8; color: #444; margin-bottom: 16px; }
.about-content .section-title { margin-bottom: 20px; }
.values-list { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin: 24px 0 32px; }
.value-item { display: flex; align-items: center; gap: 10px; font-size: 13.5px; font-weight: 600; color: var(--navy); }
.value-dot { width: 8px; height: 8px; background: var(--gold); flex-shrink: 0; }
/* ── EVENTS SECTION ── */
.events-section { background: var(--offwhite); padding: 80px 60px; }
.events-header { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 48px; }
.view-all { color: var(--navy); text-decoration: none; font-weight: 600; font-size: 13px; letter-spacing: 1px; text-transform: uppercase; border-bottom: 2px solid var(--gold); padding-bottom: 2px; transition: color .2s; }
.view-all:hover { color: var(--gold); }
.events-tabs { display: flex; margin-bottom: 36px; border-bottom: 2px solid var(--light-grey); }
.tab-btn { background: none; border: none; padding: 12px 24px; font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--grey); cursor: pointer; position: relative; transition: color .2s; }
.tab-btn.active { color: var(--navy); }
.tab-btn.active::after { content: ''; position: absolute; bottom: -2px; left: 0; right: 0; height: 2px; background: var(--gold); }
.events-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; }
.event-card { background: var(--white); overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); transition: transform .3s, box-shadow .3s; }
.event-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,51,102,0.12); }
.event-card .img-wrap { height: 200px; overflow: hidden; position: relative; }
.event-badge { position: absolute; top: 14px; left: 14px; padding: 5px 12px; font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; }
.badge-official { background: var(--navy); color: var(--gold); }
.badge-student { background: var(--gold); color: var(--navy-dark); }
.badge-sustainability { background: #1a6b3c; color: #a8e6c1; }
.event-body { padding: 20px; }
.event-date { font-size: 11px; color: var(--gold); font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 8px; }
.event-body h3 { font-size: 17px; font-weight: 700; color: var(--navy); margin-bottom: 8px; line-height: 1.3; }
.event-body p { font-size: 13.5px; color: var(--grey); line-height: 1.6; margin-bottom: 16px; }
.event-link { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--navy); text-decoration: none; border-bottom: 1px solid var(--gold); padding-bottom: 1px; transition: color .2s; }
.event-link:hover { color: var(--gold); }
.volunteer-card { background: linear-gradient(135deg,#0d4a2b 0%,#1a6b3c 100%); border-left: 5px solid #4caf7d; padding: 28px; display: flex; justify-content: space-between; align-items: center; margin-top: 24px; }
.volunteer-card .vc-left h3 { color: #a8e6c1; font-size: 10px; letter-spacing: 3px; text-transform: uppercase; margin-bottom: 6px; }
.volunteer-card .vc-left h2 { color: var(--white); font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; }
.btn-green { background: #4caf7d; color: var(--white); padding: 12px 28px; font-weight: 700; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; transition: all .2s; white-space: nowrap; }
.btn-green:hover { background: #a8e6c1; color: #0d4a2b; }
.tab-panel { display: none; }
.tab-panel.active { display: grid; }
/* ── FLAGSHIP SECTION ── */
.flagship-section { background: var(--navy-dark); padding: 80px 60px; }
.flagship-section .section-title { color: var(--white); }
.flagship-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 48px; }
.flagship-card { position: relative; height: 320px; overflow: hidden; cursor: pointer; }
.flagship-card .bg { position: absolute; inset: 0; transition: transform .5s; }
.flagship-card:hover .bg { transform: scale(1.06); }
.flagship-card .overlay { position: absolute; inset: 0; background: linear-gradient(0deg,rgba(0,31,69,0.85) 0%,rgba(0,31,69,0.2) 60%); transition: background .3s; }
.flagship-card:hover .overlay { background: linear-gradient(0deg,rgba(0,31,69,0.9) 0%,rgba(0,31,69,0.4) 60%); }
.flagship-card .info { position: absolute; bottom: 0; left: 0; padding: 28px; }
.flagship-card .year { font-size: 11px; color: var(--gold); letter-spacing: 3px; font-weight: 700; text-transform: uppercase; }
.flagship-card h3 { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 900; color: var(--white); margin: 8px 0 6px; }
.flagship-card p { font-size: 13px; color: rgba(255,255,255,0.7); line-height: 1.6; max-width: 380px; }
.flagship-arrow { position: absolute; top: 24px; right: 24px; width: 40px; height: 40px; border: 1px solid rgba(255,255,255,0.4); display: flex; align-items: center; justify-content: center; color: var(--white); font-size: 18px; opacity: 0; transform: translateX(-8px); transition: all .3s; }
.flagship-card:hover .flagship-arrow { opacity: 1; transform: translateX(0); }
/* ── SUSTAINABILITY CARDS ── */
.sustainability { background: var(--white); padding: 80px 60px; }
.sustain-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 2px; margin-top: 48px; }
.sustain-card { padding: 40px 30px; background: var(--offwhite); transition: background .3s, transform .3s; cursor: pointer; }
.sustain-card:hover { background: var(--navy); transform: translateY(-4px); }
.sustain-icon { width: 52px; height: 52px; background: var(--navy); display: flex; align-items: center; justify-content: center; margin-bottom: 20px; transition: background .3s; }
.sustain-card:hover .sustain-icon { background: var(--gold); }
.sustain-icon svg { width: 26px; height: 26px; stroke: var(--gold); fill: none; stroke-width: 2; transition: stroke .3s; }
.sustain-card:hover .sustain-icon svg { stroke: var(--navy-dark); }
.sustain-card h3 { font-size: 18px; font-weight: 700; color: var(--navy); margin-bottom: 10px; transition: color .3s; }
.sustain-card:hover h3 { color: var(--white); }
.sustain-card p { font-size: 13.5px; color: var(--grey); line-height: 1.7; transition: color .3s; }
.sustain-card:hover p { color: rgba(255,255,255,0.7); }
</style>
@endpush

@section('content')

<section class="hero">
  <div class="slide active">
    <div class="slide-bg"></div>
    <div class="slide-overlay"></div>
    <div class="slide-content animate-in">
      <span class="slide-label">Welcome to YES – IEM</span>
      <h1>Empowering Young<br/>Engineers in Malaysia</h1>
      <p>The Young Engineer Section (YES) of the Institution of Engineers Malaysia — building the next generation of engineering professionals through education, mentorship, and industry collaboration.</p>
      <a href="#" class="btn-gold">Explore Our Programmes ›</a>
      <a href="#events" class="btn-outline">Upcoming Events</a>
    </div>
  </div>
  <div class="slide">
    <div class="slide-bg"></div>
    <div class="slide-overlay"></div>
    <div class="slide-content">
      <span class="slide-label">Flagship Event {{ date('Y') }}</span>
      <h1>NATSUM<br/>National Student Summit</h1>
      <p>The premier gathering of engineering and science students from universities across Malaysia. Join thousands of future innovators.</p>
      <a href="{{ route('natsum') }}" class="btn-gold">Register Now ›</a>
      <a href="{{ route('natsum') }}" class="btn-outline">Learn More</a>
    </div>
  </div>
  <div class="slide">
    <div class="slide-bg"></div>
    <div class="slide-overlay"></div>
    <div class="slide-content">
      <span class="slide-label">Sustainability Initiative</span>
      <h1>Engineering a<br/>Greener Tomorrow</h1>
      <p>Our sustainability programme connects engineers with environmental causes — volunteer, innovate, and make lasting impact.</p>
      <a href="{{ route('sustainability-events') }}" class="btn-gold">View Green Events ›</a>
      <a href="{{ route('sustainability') }}" class="btn-outline">Our Commitments</a>
    </div>
  </div>
  <div class="hero-dots">
    <div class="dot active" onclick="goToSlide(0)"></div>
    <div class="dot" onclick="goToSlide(1)"></div>
    <div class="dot" onclick="goToSlide(2)"></div>
  </div>
  <div class="hero-counter"><span id="slide-num">01</span> / 03</div>
</section>

<div class="stats-strip">
  <div class="stat-item"><span class="num">12,000+</span><span class="label">Members Nationwide</span></div>
  <div class="stat-item"><span class="num">26</span><span class="label">State Branches</span></div>
  <div class="stat-item"><span class="num">150+</span><span class="label">Events Annually</span></div>
  <div class="stat-item"><span class="num">38</span><span class="label">Years of Excellence</span></div>
</div>

<section class="about-strip">
  <div class="about-grid">
    <div class="about-visual">
      <div class="about-img-main"><div class="big-text">YES</div></div>
      <div class="about-img-accent"><p>38<small>Years</small></p></div>
    </div>
    <div class="about-content">
      <div class="section-label">About YES – IEM</div>
      <h2 class="section-title">The <em>Young Engineer Section</em> of IEM</h2>
      <p>YES (Young Engineer Section) is the youth arm of the Institution of Engineers Malaysia (IEM), dedicated to nurturing the next generation of engineering professionals across the country.</p>
      <p>We connect student engineers and young graduates with industry mentors, international events, and meaningful sustainability projects — building career-ready, socially responsible engineers.</p>
      <div class="values-list">
        <div class="value-item"><div class="value-dot"></div>Excellence</div>
        <div class="value-item"><div class="value-dot"></div>Integrity</div>
        <div class="value-item"><div class="value-dot"></div>Innovation</div>
        <div class="value-item"><div class="value-dot"></div>Inclusivity</div>
        <div class="value-item"><div class="value-dot"></div>Collaboration</div>
        <div class="value-item"><div class="value-dot"></div>Sustainability</div>
      </div>
      <a href="{{ route('who-we-are') }}" class="btn-gold">Our Full Story →</a>
    </div>
  </div>
</section>

<section class="events-section" id="events">
  <div class="events-header">
    <div>
      <div class="section-label">What's On</div>
      <h2 class="section-title">Events &amp; <em>Programmes</em></h2>
    </div>
    <a href="{{ route('official-board-events') }}" class="view-all">View All Events →</a>
  </div>
  <div class="events-tabs">
    <button class="tab-btn active" onclick="switchTab(this,'official')">Official Board Events</button>
    <button class="tab-btn" onclick="switchTab(this,'student')">Student Chapter Events</button>
    <button class="tab-btn" onclick="switchTab(this,'sustain')">Sustainability Events</button>
  </div>
  <div class="tab-panel active events-grid" id="tab-official">
    @forelse($upcomingOfficialEvents as $event)
    <div class="event-card">
      <div class="img-wrap img-p{{ ($loop->index % 5) + 1 }}"><div class="event-badge badge-official">Official</div></div>
      <div class="event-body">
        <div class="event-date">{{ $event->start_date?->format('j F Y') }}@if($event->location) · {{ $event->location }}@endif</div>
        <h3>{{ $event->name }}</h3>
        <p>{{ Str::limit($event->description, 120) }}</p>
        <a href="{{ route('official-board-events') }}" class="event-link">Learn More →</a>
      </div>
    </div>
    @empty
    <p style="color:var(--grey);font-size:14px;grid-column:span 3;padding:20px 0">No upcoming official events at this time.</p>
    @endforelse
  </div>
  <div class="tab-panel events-grid" id="tab-student">
    @forelse($upcomingStudentEvents as $event)
    <div class="event-card">
      <div class="img-wrap img-p{{ ($loop->index % 5) + 1 }}"><div class="event-badge badge-student">Student</div></div>
      <div class="event-body">
        <div class="event-date">{{ $event->date_display }}@if($event->venue) · {{ $event->venue }}@endif</div>
        <h3>{{ $event->title }}</h3>
        <p>{{ Str::limit($event->description, 120) }}</p>
        <a href="{{ route('student-section-events') }}" class="event-link">Register Now →</a>
      </div>
    </div>
    @empty
    <p style="color:var(--grey);font-size:14px;grid-column:span 3;padding:20px 0">No upcoming student events at this time.</p>
    @endforelse
  </div>
  <div class="tab-panel events-grid" id="tab-sustain">
    @forelse($sustainabilityEvents as $event)
    <div class="event-card">
      <div class="img-wrap img-p{{ ($loop->index % 5) + 1 }}"><div class="event-badge badge-sustainability">Green</div></div>
      <div class="event-body">
        <div class="event-date">{{ $event->date_display }}@if($event->venue) · {{ $event->venue }}@endif</div>
        <h3>{{ $event->title }}</h3>
        <p>{{ Str::limit($event->description, 120) }}</p>
        <a href="{{ route('sustainability-events') }}" class="event-link">Volunteer →</a>
      </div>
    </div>
    @empty
    <p style="color:var(--grey);font-size:14px;grid-column:span 3;padding:20px 0">No upcoming sustainability events at this time.</p>
    @endforelse
  </div>
  <div class="volunteer-card">
    <div class="vc-left">
      <h3>Sustainability Volunteering</h3>
      <h2>Make an Impact — Register as a YES Green Volunteer</h2>
    </div>
    <a href="{{ route('sustainability-events') }}" class="btn-green">View All Green Events →</a>
  </div>
</section>

<section class="flagship-section">
  <div class="section-label" style="color:var(--gold)">Flagship Programmes</div>
  <h2 class="section-title">Our Signature <em style="color:var(--gold)">Events</em></h2>
  <div class="flagship-grid">
    @php
      $natsum = $flagshipEvents->firstWhere('short_name', 'NATSUM');
      $cafeo  = $flagshipEvents->firstWhere('short_name', 'CAFEO');
    @endphp
    <a href="{{ route('natsum') }}" style="text-decoration:none;">
      <div class="flagship-card">
        <div class="bg" style="background:linear-gradient(135deg,#001f45,#0a4a8c,#1a5fa8)"></div>
        <div class="overlay"></div><div class="flagship-arrow">→</div>
        <div class="info">
          <div class="year">{{ $natsum ? $natsum->year . ' · ' . $natsum->location : 'Annual · Since 1998' }}</div>
          <h3>NATSUM</h3>
          <p>National Student Summit — Malaysia's largest gathering of engineering and science students.</p>
        </div>
      </div>
    </a>
    <a href="{{ route('cafeo') }}" style="text-decoration:none;">
      <div class="flagship-card">
        <div class="bg" style="background:linear-gradient(135deg,#1a3a0d,#2d6b1a,#4a8a2a)"></div>
        <div class="overlay"></div><div class="flagship-arrow">→</div>
        <div class="info">
          <div class="year">{{ $cafeo ? $cafeo->year . ' · ' . $cafeo->location : 'Annual · ASEAN Event' }}</div>
          <h3>CAFEO</h3>
          <p>Conference of ASEAN Federation of Engineering Organisations — the regional stage.</p>
        </div>
      </div>
    </a>
  </div>
</section>

<section class="sustainability">
  <div class="section-label">Our Commitment</div>
  <h2 class="section-title">Sustainability at the <em>Heart</em> of YES</h2>
  <div class="sustain-grid">
    <a href="{{ route('sustainability') }}#initiative" style="text-decoration:none;">
      <div class="sustain-card">
        <div class="sustain-icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 2a7 7 0 1 0 0 14A7 7 0 0 0 12 2z"/><path d="M12 16v6M6 12H2M22 12h-4"/></svg></div>
        <h3>Sustainability Initiative</h3>
        <p>Applying engineering solutions to climate change, water systems, and urban sustainability challenges across Malaysia.</p>
      </div>
    </a>
    <a href="{{ route('sustainability') }}#pledge" style="text-decoration:none;">
      <div class="sustain-card">
        <div class="sustain-icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M9 12l2 2 4-4"/><path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2z"/></svg></div>
        <h3>Sustainability Pledge</h3>
        <p>Our commitment to sustainable engineering practice — signed by YES members and chapters across all 26 state branches.</p>
      </div>
    </a>
    <a href="{{ route('sustainability') }}#declaration" style="text-decoration:none;">
      <div class="sustain-card">
        <div class="sustain-icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></div>
        <h3>Sustainability Declaration</h3>
        <p>YES Malaysia's formal declaration on engineering responsibility towards a net-zero, resilient, and equitable ASEAN future.</p>
      </div>
    </a>
  </div>
</section>

@endsection

@push('scripts')
<script>
let current = 0;
const slides  = document.querySelectorAll('.slide');
const dots    = document.querySelectorAll('.dot');
const numEl   = document.getElementById('slide-num');
function goToSlide(n) {
  slides[current].classList.remove('active'); dots[current].classList.remove('active');
  current = n;
  slides[current].classList.add('active'); dots[current].classList.add('active');
  numEl.textContent = String(current + 1).padStart(2, '0');
}
setInterval(() => goToSlide((current + 1) % slides.length), 5500);
function switchTab(btn, tabId) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('tab-' + tabId).classList.add('active');
}
</script>
@endpush
