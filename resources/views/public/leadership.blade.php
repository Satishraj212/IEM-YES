@extends('public.layouts.app')

@section('title', $title . ' – YES Young Engineer Section | IEM Malaysia')

@push('styles')
<style>
.ldr-hero { background: var(--navy-dark); padding: 52px 60px; position: relative; overflow: hidden; }
.ldr-hero::before { content: ''; position: absolute; top: -80px; right: -80px; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(200,168,75,0.06) 0%, transparent 70%); }
.ldr-hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(32px, 4vw, 52px); color: var(--white); font-weight: 900; margin-bottom: 10px; }
.ldr-hero h1 em { color: var(--gold); font-style: normal; }
.ldr-hero p { font-size: 15px; color: rgba(255,255,255,0.65); max-width: 560px; line-height: 1.7; }

.tab-bar { background: var(--offwhite); border-bottom: 2px solid var(--light-grey); display: flex; padding: 0 60px; position: sticky; top: 72px; z-index: 800; flex-wrap: wrap; overflow-x: auto; }
.tab-btn { display: inline-block; padding: 16px 22px; font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--grey); border: none; border-bottom: 3px solid transparent; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; text-decoration: none; white-space: nowrap; }
.tab-btn:hover { color: var(--navy); }
.tab-btn.active { color: var(--navy); border-bottom-color: var(--gold); }

.ldr-body { padding: 44px 60px 80px; max-width: 980px; }
.empty { text-align: center; padding: 80px 20px; }
.empty h3 { font-size: 20px; font-weight: 700; color: var(--navy); margin-bottom: 10px; }
.empty p { font-size: 14px; color: var(--grey); max-width: 440px; margin: 0 auto; }

.ocv { background: var(--white); border: 1px solid var(--light-grey); }
.ocv-head { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 16px 22px; border-bottom: 1px solid var(--light-grey); background: var(--offwhite); flex-wrap: wrap; }
.ocv-title { font-family: 'Playfair Display', serif; font-size: 19px; font-weight: 900; color: var(--navy); }
.ocv-sub { font-size: 12px; color: var(--grey); margin-top: 2px; }
.ocv-yearpick { display: flex; align-items: center; gap: 8px; }
.ocv-yearpick span { font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--grey); }
.ocv-year { border: 1px solid var(--light-grey); background: #fff; padding: 8px 12px; font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 600; color: var(--navy); cursor: pointer; outline: none; }
.ocv-year:focus { border-color: var(--navy); }
.ocv-yearlabel { font-size: 12px; font-weight: 700; color: var(--grey); letter-spacing: .5px; }
.ocv-chart { padding: 22px; text-align: center; background: #fafafa; }
.ocv-chart img { max-width: 100%; max-height: 620px; object-fit: contain; cursor: zoom-in; border: 1px solid var(--light-grey); background: #fff; }
.ocv-pdf { padding: 60px 20px; text-align: center; }
.ocv-pdf div { font-size: 13px; color: var(--grey); margin-bottom: 8px; }
.ocv-pdf a { font-size: 13px; color: var(--navy); font-weight: 700; text-decoration: none; }
.ocv-empty { padding: 48px; text-align: center; font-size: 13px; color: var(--grey); }

.ldr-writeup { margin-top: 28px; }
.ldr-writeup h2 { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 900; color: var(--navy); padding-bottom: 8px; border-bottom: 2px solid var(--gold); margin-bottom: 14px; }
.ldr-writeup p { font-size: 14px; color: #444; line-height: 1.85; }

.lb { position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 9999; display: none; align-items: center; justify-content: center; flex-direction: column; }
.lb.open { display: flex; }
.lb img { max-width: 92vw; max-height: 82vh; object-fit: contain; }
.lb-close { position: absolute; top: 20px; right: 28px; background: none; border: none; font-size: 36px; color: rgba(255,255,255,0.7); cursor: pointer; line-height: 1; transition: color .2s; }
.lb-close:hover { color: var(--gold); }
.lb-caption { margin-top: 12px; font-size: 13px; color: rgba(255,255,255,0.55); letter-spacing: .5px; }
</style>
@endpush

@section('content')

<div class="ldr-hero">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a><span>›</span>
    <a href="{{ route('who-we-are') }}">About Us</a><span>›</span>
    <span class="current">{{ $title }}</span>
  </div>
  <h1 style="margin-top:16px">{{ $title }}</h1>
  <p>Browse the organisation chart{{ $section === 'hq' ? '' : 's' }} — select a year to view the current or a past chart.</p>
</div>

@if($tabs->isNotEmpty())
<div class="tab-bar">
  @foreach($tabs as $t)
  <a href="{{ $t['url'] }}" class="tab-btn {{ $t['active'] ? 'active' : '' }}">{{ $t['name'] }}</a>
  @endforeach
</div>
@endif

<div class="ldr-body">
  @if($viewer)
  @include('public.partials.org-chart-viewer', ['v' => $viewer, 'vid' => 'main'])

  @if(!empty($writeup))
  <div class="ldr-writeup">
    <h2>About {{ $viewer['name'] }}</h2>
    <p>{!! nl2br(e($writeup)) !!}</p>
  </div>
  @endif

  @else
  <div class="empty">
    <h3>No organisation chart {{ $section === 'hq' ? 'yet' : 'published yet' }}</h3>
    <p>
      @if($section === 'hq') The YES HQ (Kuala Lumpur) office-bearers chart will appear here once uploaded.
      @elseif($section === 'states') State branch organisation charts will appear here once HQ uploads them.
      @else Student chapter charts appear here once approved by HQ.
      @endif
    </p>
  </div>
  @endif
</div>

<div class="lb" id="lightbox" onclick="if(event.target===this)closeLightbox()">
  <button class="lb-close" onclick="closeLightbox()">×</button>
  <img id="lbImg" src="" alt=""/>
  <div class="lb-caption" id="lbCaption"></div>
</div>

@endsection

@push('scripts')
<script>
// Switch the visible chart for the viewer by year index.
function ocvShow(vid, idx) {
  document.querySelectorAll('.ocv-chart[data-v="' + vid + '"]').forEach(el => {
    el.style.display = el.dataset.i === String(idx) ? 'block' : 'none';
  });
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
@endpush
