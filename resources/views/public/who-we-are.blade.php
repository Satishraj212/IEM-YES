@extends('public.layouts.app')

@section('title', 'Who We Are – YES Young Engineer Section | IEM Malaysia')

@push('styles')
<style>
.stats-strip { background: var(--navy); padding: 36px 60px; display: grid; grid-template-columns: repeat(4,1fr); }
.stat-item { text-align: center; padding: 12px 0; border-right: 1px solid rgba(255,255,255,0.12); }
.stat-item:last-child { border-right: none; }
.stat-item .num { font-family: 'Playfair Display', serif; font-size: 38px; font-weight: 900; color: var(--gold); display: block; line-height: 1; }
.stat-item .label { font-size: 12px; color: rgba(255,255,255,0.65); letter-spacing: 1.5px; text-transform: uppercase; margin-top: 6px; display: block; }
.anchor-nav { position: sticky; top: 72px; z-index: 800; background: var(--white); border-bottom: 1px solid var(--light-grey); display: flex; gap: 0; padding: 0 60px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
.anchor-btn { padding: 16px 24px; font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--grey); text-decoration: none; border-bottom: 3px solid transparent; transition: all .2s; white-space: nowrap; }
.anchor-btn:hover { color: var(--navy); }
.anchor-btn.active { color: var(--navy); border-bottom-color: var(--gold); }
.vm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 3px; margin-top: 52px; }
.vm-card { padding: 52px 48px; position: relative; overflow: hidden; }
.vm-card.vision { background: var(--navy); }
.vm-card.mission { background: var(--navy-dark); }
.vm-card::before { content: ''; position: absolute; top: -60px; right: -60px; width: 220px; height: 220px; border-radius: 50%; background: radial-gradient(circle,rgba(200,168,75,0.08) 0%,transparent 70%); }
.vm-icon { width: 56px; height: 56px; border: 2px solid var(--gold); display: flex; align-items: center; justify-content: center; margin-bottom: 24px; }
.vm-icon svg { width: 26px; height: 26px; stroke: var(--gold); fill: none; stroke-width: 1.5; }
.vm-card h2 { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 900; color: var(--gold); margin-bottom: 20px; }
.vm-card p { font-size: 16px; color: rgba(255,255,255,0.82); line-height: 1.9; font-weight: 300; }
.vm-card .highlight-text { font-family: 'Playfair Display', serif; font-size: 22px; color: var(--white); font-style: italic; line-height: 1.5; margin-bottom: 16px; border-left: 3px solid var(--gold); padding-left: 20px; }
.values-hexgrid { display: grid; grid-template-columns: repeat(3,1fr); gap: 3px; }
.value-block { background: var(--white); padding: 44px 36px; border-bottom: 3px solid transparent; transition: all .35s cubic-bezier(.2,.8,.3,1); }
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
.malaysia-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: start; }
.map-visual { width: 100%; background: var(--navy); aspect-ratio: 4/3; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
.map-visual::before { content: 'MALAYSIA'; position: absolute; font-family: 'Playfair Display', serif; font-size: 80px; font-weight: 900; color: rgba(255,255,255,0.03); letter-spacing: 10px; }
.map-legend { margin-top: 16px; display: flex; gap: 20px; font-size: 12px; color: var(--grey); }
.map-legend span { display: flex; align-items: center; gap: 6px; }
.legend-dot { width: 10px; height: 10px; border-radius: 50%; }
.legend-dot.hq { background: var(--gold-light); }
.legend-dot.branch { background: var(--gold); }
.branch-region { border-bottom: 1px solid var(--light-grey); }
.branch-region-header { display: flex; align-items: center; justify-content: space-between; padding: 18px 0; cursor: pointer; user-select: none; }
.branch-region-header h3 { font-size: 15px; font-weight: 700; color: var(--navy); }
.branch-region-header .count { font-size: 11px; background: var(--navy); color: var(--gold); padding: 3px 10px; font-weight: 700; letter-spacing: 1px; }
.branch-region-header .chevron { font-size: 11px; color: var(--gold); transition: transform .25s; }
.branch-region.open .chevron { transform: rotate(180deg); }
.branch-items { display: none; padding-bottom: 14px; }
.branch-region.open .branch-items { display: flex; flex-wrap: wrap; gap: 8px; }
.branch-tag { background: var(--offwhite); color: var(--navy); padding: 6px 14px; font-size: 12px; font-weight: 500; border: 1px solid var(--light-grey); transition: all .2s; }
.branch-tag:hover { background: var(--navy); color: var(--gold); border-color: var(--navy); }
.branch-tag.hq { background: var(--navy); color: var(--gold); border-color: var(--navy); }
</style>
@endpush

@section('content')

<div class="stats-strip">
  <div class="stat-item"><span class="num">26</span><span class="label">State Branches</span></div>
  <div class="stat-item"><span class="num">12,000+</span><span class="label">Active Members</span></div>
  <div class="stat-item"><span class="num">38+</span><span class="label">Universities Covered</span></div>
  <div class="stat-item"><span class="num">150+</span><span class="label">Events Per Year</span></div>
</div>

<div class="page-hero">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a><span>›</span>
    <a href="#">About Us</a><span>›</span>
    <span class="current">Who We Are</span>
  </div>
  <h1>Who We <em>Are</em></h1>
</div>

<nav class="anchor-nav" id="anchorNav">
  <a href="#vision-mission" class="anchor-btn active">Vision &amp; Mission</a>
  <a href="#values" class="anchor-btn">Values</a>
  <a href="#where-we-are" class="anchor-btn">Where We Are</a>
</nav>

<section class="content-section" id="vision-mission">
  <div class="section-label reveal">About YES – IEM</div>
  <h2 class="section-title reveal">Our Vision &amp; <em>Mission</em></h2>
  <div class="divider reveal"></div>
  <div class="vm-grid reveal">
    <div class="vm-card vision">
      <div class="vm-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/></svg></div>
      <h2>Vision</h2>
      <p class="highlight-text">"To be the leading voice and champion for young engineers in Malaysia."</p>
      <p>YES aspires to be the foremost platform that inspires, connects, and elevates young engineers — creating a generation of professionals who lead with technical excellence and ethical responsibility.</p>
    </div>
    <div class="vm-card mission">
      <div class="vm-icon"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
      <h2>Mission</h2>
      <p class="highlight-text">"Empowering young engineers through engagement, education, and excellence."</p>
      <p>We are committed to providing meaningful platforms for professional development, fostering a strong engineering community, and driving sustainable impact through technical leadership and community service.</p>
    </div>
  </div>
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

<section class="content-section alt" id="values">
  <div class="section-label reveal">What We Stand For</div>
  <h2 class="section-title reveal">Our Core <em>Values</em></h2>
  <div class="divider reveal"></div>
  <div class="values-hexgrid" style="margin-top:52px;">
    @foreach([
      ['01','Excellence','<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>','We hold ourselves to the highest standard in everything we do.'],
      ['02','Integrity','<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>','We act with honesty, transparency, and accountability in all dealings.'],
      ['03','Innovation','<path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>','We embrace new ideas and technologies to lead change in the industry.'],
      ['04','Inclusivity','<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>','YES is a home for every young engineer in Malaysia.'],
      ['05','Collaboration','<circle cx="12" cy="12" r="10"/>','We believe engineering is a team sport — we achieve more together.'],
      ['06','Sustainability','<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>','We champion engineering solutions that are environmentally responsible.'],
    ] as [$n, $t, $ico, $d])
    <div class="value-block reveal">
      <div class="val-number">{{ $n }}</div>
      <div class="val-icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.5">{!! $ico !!}</svg></div>
      <div class="val-title">{{ $t }}</div>
      <div class="val-desc">{{ $d }}</div>
    </div>
    @endforeach
  </div>
</section>

<section class="content-section" id="where-we-are">
  <div class="section-label reveal">Our Presence</div>
  <h2 class="section-title reveal">Where We <em>Are</em></h2>
  <div class="divider reveal"></div>
  <p class="reveal" style="font-size:16px;color:var(--grey);line-height:1.8;max-width:680px;margin-bottom:56px;">YES – IEM operates nationwide, with an active HQ in Kuala Lumpur and branches spanning every state in Peninsular Malaysia, Sabah, and Sarawak. Our reach covers over 12,000 members across universities and engineering firms.</p>
  <div class="malaysia-layout reveal">
    <div>
      <div class="map-visual">
        <svg viewBox="0 0 480 300" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:100%;position:absolute;inset:0;">
          <path d="M80,60 L120,40 L170,35 L210,45 L230,60 L250,80 L260,110 L255,140 L240,165 L225,180 L200,200 L175,205 L150,195 L130,185 L110,165 L90,140 L75,110 L70,80 Z" fill="rgba(255,255,255,0.05)" stroke="rgba(200,168,75,0.3)" stroke-width="1.5"/>
          <path d="M330,50 L390,45 L420,65 L410,90 L380,100 L350,95 L325,80 Z" fill="rgba(255,255,255,0.05)" stroke="rgba(200,168,75,0.3)" stroke-width="1.5"/>
          <path d="M270,90 L340,80 L360,100 L350,130 L320,150 L285,155 L265,135 L255,110 Z" fill="rgba(255,255,255,0.05)" stroke="rgba(200,168,75,0.3)" stroke-width="1.5"/>
          <circle cx="175" cy="120" r="8" fill="#e8c96a" opacity="0.9"/>
          <circle cx="175" cy="120" r="14" fill="rgba(232,201,106,0.2)"/>
          <text x="190" y="116" fill="#e8c96a" font-size="9" font-family="DM Sans,sans-serif" font-weight="700">HQ – KUALA LUMPUR</text>
          <circle cx="120" cy="70" r="5" fill="#c8a84b" opacity="0.85"/>
          <text x="130" y="68" fill="rgba(255,255,255,0.6)" font-size="8" font-family="DM Sans,sans-serif">PENANG</text>
          <circle cx="195" cy="192" r="5" fill="#c8a84b" opacity="0.85"/>
          <text x="205" y="190" fill="rgba(255,255,255,0.6)" font-size="8" font-family="DM Sans,sans-serif">JOHOR</text>
          <circle cx="145" cy="90" r="5" fill="#c8a84b" opacity="0.85"/>
          <text x="128" y="88" fill="rgba(255,255,255,0.6)" font-size="8" font-family="DM Sans,sans-serif">PERAK</text>
          <circle cx="375" cy="68" r="5" fill="#c8a84b" opacity="0.85"/>
          <text x="382" y="66" fill="rgba(255,255,255,0.6)" font-size="8" font-family="DM Sans,sans-serif">SABAH</text>
          <circle cx="310" cy="118" r="5" fill="#c8a84b" opacity="0.85"/>
          <text x="318" y="116" fill="rgba(255,255,255,0.6)" font-size="8" font-family="DM Sans,sans-serif">SARAWAK</text>
        </svg>
      </div>
      <div class="map-legend">
        <span><div class="legend-dot hq"></div> YES HQ</span>
        <span><div class="legend-dot branch"></div> State Branch</span>
      </div>
    </div>
    <div>
      <p style="font-size:13px;color:var(--grey);line-height:1.8;margin-bottom:24px;">YES currently operates <strong style="color:var(--navy)">26 active branches</strong> nationwide.</p>
      @foreach([
        ['Klang Valley &amp; Selangor', 'HQ + 3 Branches', ['YES HQ – Putrajaya','Klang Valley','Shah Alam','Subang Jaya'], true],
        ['Northern Region', '4 Branches', ['Penang','Perak','Kedah','Perlis'], false],
        ['Southern Region', '3 Branches', ['Johor Bahru','Melaka','Negeri Sembilan'], false],
        ['East Coast', '3 Branches', ['Pahang','Terengganu','Kelantan'], false],
        ['East Malaysia', '3 Branches', ['Sabah','Sarawak (Kuching)','Sarawak (Miri)'], false],
      ] as [$region, $count, $branches, $open])
      <div class="branch-region{{ $open ? ' open' : '' }}">
        <div class="branch-region-header" onclick="toggleBranch(this)">
          <h3>{!! $region !!}</h3>
          <div style="display:flex;gap:10px;align-items:center;"><span class="count">{{ $count }}</span><span class="chevron">{{ $open ? '▲' : '▼' }}</span></div>
        </div>
        <div class="branch-items">
          @foreach($branches as $i => $b)
            <span class="branch-tag{{ $i === 0 && $open ? ' hq' : '' }}">{{ $b }}</span>
          @endforeach
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

@endsection

@push('scripts')
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
const anchorBtns = document.querySelectorAll('.anchor-btn');
const sections = ['vision-mission','values','where-we-are'].map(id => document.getElementById(id));
window.addEventListener('scroll', () => {
  let current = '';
  sections.forEach(sec => { if (sec && window.scrollY >= sec.offsetTop - 160) current = sec.id; });
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
