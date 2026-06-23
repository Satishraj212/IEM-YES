<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Leadership & Organisation Charts – YES IEM Malaysia</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<style>
:root{--navy:#003366;--navy-dark:#001f45;--gold:#c8a84b;--gold-light:#e8c96a;--white:#fff;--offwhite:#f5f4f0;--grey:#6b7280;--light:#e8e8e4}
*{margin:0;padding:0;box-sizing:border-box}html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;color:#222;background:var(--white);overflow-x:hidden}
.top-bar{background:var(--navy-dark);color:rgba(255,255,255,.65);font-size:12px;display:flex;justify-content:flex-end;align-items:center;gap:24px;padding:7px 60px}
.top-bar a{color:rgba(255,255,255,.65);text-decoration:none;transition:color .2s}.top-bar a:hover{color:var(--gold)}
nav{position:sticky;top:0;z-index:1000;background:var(--white);border-bottom:3px solid var(--gold);display:flex;align-items:center;justify-content:space-between;padding:0 60px;height:72px;box-shadow:0 2px 20px rgba(0,0,0,.08)}
.logo{display:flex;align-items:center;text-decoration:none}
.nav-links{display:flex;list-style:none;height:100%}
.nav-links li{height:100%;display:flex;align-items:center}
.nav-links a{display:flex;align-items:center;height:100%;padding:0 18px;font-size:13px;font-weight:600;color:#333;text-decoration:none;letter-spacing:.3px;transition:color .2s;border-bottom:3px solid transparent;margin-bottom:-3px}
.nav-links a:hover,.nav-links a.active{color:var(--navy);border-bottom-color:var(--gold)}
.hero{background:linear-gradient(135deg,var(--navy-dark) 0%,#002a5c 60%,#0a3d6b 100%);padding:72px 60px 60px;position:relative;overflow:hidden}
.hero::after{content:'';position:absolute;inset:0;background:repeating-linear-gradient(45deg,transparent,transparent 40px,rgba(200,168,75,.03) 40px,rgba(200,168,75,.03) 41px);pointer-events:none}
.hero-eyebrow{font-size:11px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:rgba(200,168,75,.7);margin-bottom:14px}
.hero-title{font-family:'Playfair Display',serif;font-size:44px;font-weight:900;color:#fff;line-height:1.08;margin-bottom:16px}
.hero-title em{color:var(--gold);font-style:normal}
.hero-sub{font-size:15px;color:rgba(255,255,255,.6);line-height:1.75;max-width:560px}
.main{max-width:1200px;margin:0 auto;padding:56px 60px}
/* tabs */
.tab-bar{display:flex;gap:0;border-bottom:2px solid var(--light);margin-bottom:40px}
.tab-btn{padding:12px 28px;background:none;border:none;border-bottom:3px solid transparent;font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;color:var(--grey);cursor:pointer;text-transform:uppercase;letter-spacing:1px;transition:all .2s;margin-bottom:-2px}
.tab-btn:hover{color:var(--navy)}
.tab-btn.active{color:var(--navy);border-bottom-color:var(--gold)}
.tab-panel{display:none}.tab-panel.active{display:block}
/* branch grid */
.branch-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:28px}
.branch-card{background:#fff;border:1px solid var(--light);overflow:hidden;transition:box-shadow .2s}
.branch-card:hover{box-shadow:0 8px 32px rgba(0,31,69,.1)}
.bc-header{background:var(--navy-dark);padding:18px 22px;display:flex;align-items:center;gap:14px}
.bc-seal{width:44px;height:44px;background:var(--gold);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:13px;font-weight:900;color:var(--navy-dark);flex-shrink:0;letter-spacing:1px}
.bc-name{font-family:'Playfair Display',serif;font-size:14px;font-weight:700;color:#fff}
.bc-chapter{font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--gold);margin-top:2px}
.bc-body{padding:0}
.bc-chart{background:#f9f9f9;border-bottom:1px solid var(--light);overflow:hidden;text-align:center;cursor:pointer}
.bc-chart img{max-width:100%;max-height:300px;object-fit:contain;display:block;margin:0 auto;transition:transform .3s}
.bc-chart:hover img{transform:scale(1.02)}
.bc-meta{padding:14px 22px;display:flex;align-items:center;justify-content:space-between}
.bc-year{font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey)}
.bc-view{font-size:11px;font-weight:700;color:var(--navy);text-decoration:none;display:flex;align-items:center;gap:4px}
.bc-view:hover{color:var(--gold)}
/* past records */
.year-section{margin-bottom:48px}
.year-heading{font-family:'Playfair Display',serif;font-size:22px;font-weight:900;color:var(--navy-dark);padding-bottom:12px;border-bottom:2px solid var(--gold);margin-bottom:24px;display:flex;align-items:center;gap:10px}
.year-heading span{font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);font-family:'DM Sans',sans-serif}
.past-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:18px}
.past-card{background:#fff;border:1px solid var(--light);overflow:hidden;transition:box-shadow .2s}
.past-card:hover{box-shadow:0 4px 16px rgba(0,31,69,.08)}
.past-chart{background:#f9f9f9;height:180px;overflow:hidden;display:flex;align-items:center;justify-content:center}
.past-chart img{max-width:100%;max-height:100%;object-fit:contain}
.past-chart .pdf-ph{font-size:12px;color:var(--grey);text-align:center;padding:16px}
.past-meta{padding:12px 16px;border-top:1px solid var(--light)}
.past-branch{font-size:12px;font-weight:700;color:var(--navy)}
.past-year{font-size:10px;font-weight:600;letter-spacing:.5px;color:var(--grey);margin-top:2px}
/* lightbox */
.lb{display:none;position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:9999;align-items:center;justify-content:center;flex-direction:column;gap:16px}
.lb.open{display:flex}
.lb img{max-width:90vw;max-height:85vh;object-fit:contain;box-shadow:0 20px 60px rgba(0,0,0,.5)}
.lb-close{position:fixed;top:20px;right:24px;width:40px;height:40px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:50%;color:#fff;font-size:22px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .2s}
.lb-close:hover{background:rgba(255,255,255,.25)}
.lb-caption{font-size:13px;color:rgba(255,255,255,.7);text-align:center}
/* empty */
.empty{text-align:center;padding:80px 24px;color:var(--grey)}
.empty h3{font-family:'Playfair Display',serif;font-size:20px;color:var(--navy-dark);margin-bottom:8px}
.empty p{font-size:13px;line-height:1.7}
footer{background:var(--navy-dark);color:rgba(255,255,255,.5);text-align:center;padding:28px 24px;font-size:12px}
footer a{color:var(--gold);text-decoration:none}
</style>
</head>
<body>

<div class="top-bar">
  <a href="{{ route('home') }}">Home</a>
  <a href="{{ route('official-board-events') }}">Events</a>
  <a href="{{ route('awards') }}">Awards</a>
</div>

<nav>
  <a class="logo" href="{{ route('home') }}">
    <span style="font-family:'Playfair Display',serif;font-size:20px;font-weight:900;color:var(--navy-dark)">YES <em style="color:var(--gold);font-style:normal">IEM</em></span>
  </a>
  <ul class="nav-links">
    <li><a href="{{ route('home') }}">Home</a></li>
    <li><a href="{{ route('official-board-events') }}">Official Events</a></li>
    <li><a href="{{ route('student-section-events') }}">Student Events</a></li>
    <li><a href="{{ route('leadership') }}" class="active">Leadership</a></li>
    <li><a href="{{ route('awards') }}">Awards</a></li>
  </ul>
</nav>

<div class="hero">
  <div class="hero-eyebrow">YES IEM Malaysia · Leadership</div>
  <h1 class="hero-title">Organisation <em>Charts</em></h1>
  <p class="hero-sub">Browse the current and historical organisation charts of YES IEM student section branches across Malaysia.</p>
</div>

<div class="main">

  {{-- Tab bar --}}
  <div class="tab-bar">
    <button class="tab-btn active" onclick="switchTab('present', this)">Present</button>
    <button class="tab-btn" onclick="switchTab('past', this)">Past Records</button>
  </div>

  {{-- PRESENT TAB --}}
  <div class="tab-panel active" id="tab-present">
    @if($branches->isEmpty())
    <div class="empty">
      <h3>No organisation charts uploaded yet</h3>
      <p>Branch administrators can upload their org charts from their student section dashboard.</p>
    </div>
    @else
    <div class="branch-grid">
      @foreach($branches as $branch)
      <div class="branch-card">
        <div class="bc-header">
          <div class="bc-seal">{{ strtoupper(substr($branch->code ?? $branch->name, 0, 3)) }}</div>
          <div>
            <div class="bc-name">{{ $branch->name }}</div>
            <div class="bc-chapter">{{ $branch->chapter_name ?? $branch->chapter }}</div>
          </div>
        </div>
        <div class="bc-body">
          @if(str_ends_with($branch->org_chart_path, '.pdf'))
          <div class="bc-chart" style="height:200px;cursor:default">
            <div style="padding:40px;text-align:center">
              <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--grey)" stroke-width="1.5" style="margin-bottom:8px"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
              <div style="font-size:12px;color:var(--grey)">PDF Document</div>
            </div>
          </div>
          @else
          <div class="bc-chart" onclick="openLightbox('{{ asset('storage/'.$branch->org_chart_path) }}', '{{ $branch->name }} Organisation Chart')">
            <img src="{{ asset('storage/'.$branch->org_chart_path) }}" alt="{{ $branch->name }} Org Chart" loading="lazy"/>
          </div>
          @endif
          <div class="bc-meta">
            <span class="bc-year">AY {{ $branch->academic_year ?? now()->year }}</span>
            @if(str_ends_with($branch->org_chart_path, '.pdf'))
            <a href="{{ asset('storage/'.$branch->org_chart_path) }}" target="_blank" class="bc-view">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
              Open PDF
            </a>
            @else
            <a href="{{ asset('storage/'.$branch->org_chart_path) }}" download class="bc-view">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              Download
            </a>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>

  {{-- PAST TAB --}}
  <div class="tab-panel" id="tab-past">
    @if($pastCharts->isEmpty())
    <div class="empty">
      <h3>No past records yet</h3>
      <p>Historical org charts will appear here as branches upload new charts each academic year.</p>
    </div>
    @else
    @foreach($pastCharts->sortKeysDesc() as $year => $charts)
    <div class="year-section">
      <div class="year-heading">
        Academic Year {{ $year }}
        <span>{{ $charts->count() }} {{ Str::plural('branch', $charts->count()) }}</span>
      </div>
      <div class="past-grid">
        @foreach($charts as $chart)
        <div class="past-card">
          <div class="past-chart">
            @if(str_ends_with($chart->file_path, '.pdf'))
            <div class="pdf-ph">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--grey)" stroke-width="1.5" style="margin:0 auto 8px;display:block"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
              PDF Document
            </div>
            @else
            <img src="{{ asset('storage/'.$chart->file_path) }}"
                 alt="{{ $chart->branch->name ?? '' }} Org Chart {{ $year }}"
                 loading="lazy"
                 style="cursor:pointer"
                 onclick="openLightbox('{{ asset('storage/'.$chart->file_path) }}', '{{ addslashes(($chart->branch->name ?? '').' — AY '.$year) }}')"/>
            @endif
          </div>
          <div class="past-meta">
            <div class="past-branch">{{ $chart->branch->name ?? 'Unknown Branch' }}</div>
            <div class="past-year">AY {{ $chart->academic_year }} · Uploaded {{ $chart->created_at->format('d M Y') }}</div>
            @if(str_ends_with($chart->file_path, '.pdf'))
            <a href="{{ asset('storage/'.$chart->file_path) }}" target="_blank" style="font-size:11px;color:var(--navy);font-weight:600;margin-top:6px;display:inline-block">Open PDF →</a>
            @else
            <a href="{{ asset('storage/'.$chart->file_path) }}" download style="font-size:11px;color:var(--navy);font-weight:600;margin-top:6px;display:inline-block">Download →</a>
            @endif
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endforeach
    @endif
  </div>

</div>

{{-- Lightbox --}}
<div class="lb" id="lightbox" onclick="if(event.target===this)closeLightbox()">
  <button class="lb-close" onclick="closeLightbox()">×</button>
  <img id="lbImg" src="" alt=""/>
  <div class="lb-caption" id="lbCaption"></div>
</div>

<footer>
  <p>© {{ now()->year }} Young Engineers Section (YES) · Institution of Engineers Malaysia</p>
</footer>

<script>
function switchTab(tab, btn) {
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  document.getElementById('tab-' + tab).classList.add('active');
  btn.classList.add('active');
}
function openLightbox(src, caption) {
  document.getElementById('lbImg').src = src;
  document.getElementById('lbCaption').textContent = caption;
  document.getElementById('lightbox').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeLightbox() {
  document.getElementById('lightbox').classList.remove('open');
  document.getElementById('lbImg').src = '';
  document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });
</script>
</body>
</html>
