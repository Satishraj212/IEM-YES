{{-- $v = ['name','institution','charts'=>[['year','url','is_pdf'], ...]]  ·  $vid = unique id --}}
<div class="ocv">
  <div class="ocv-head">
    <div>
      <div class="ocv-title">{{ $v['name'] }}</div>
      @if(!empty($v['institution']))<div class="ocv-sub">{{ $v['institution'] }}</div>@endif
    </div>
    @if(count($v['charts']) > 1)
    <div class="ocv-yearpick">
      <span>Academic Year</span>
      <select class="ocv-year" onchange="ocvShow('{{ $vid }}', this.value)">
        @foreach($v['charts'] as $i => $c)<option value="{{ $i }}">AY {{ $c['year'] }}</option>@endforeach
      </select>
    </div>
    @elseif(count($v['charts']) === 1)
    <span class="ocv-yearlabel">AY {{ $v['charts'][0]['year'] }}</span>
    @endif
  </div>

  @forelse($v['charts'] as $i => $c)
  <div class="ocv-chart" data-v="{{ $vid }}" data-i="{{ $i }}" style="display:{{ $i === 0 ? 'block' : 'none' }}">
    @if($c['is_pdf'])
    <div class="ocv-pdf">
      <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="var(--grey)" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      <div>PDF organisation chart · AY {{ $c['year'] }}</div>
      <a href="{{ $c['url'] }}" target="_blank" rel="noopener">Open PDF →</a>
    </div>
    @else
    <img src="{{ $c['url'] }}" alt="{{ $v['name'] }} AY {{ $c['year'] }}" loading="lazy"
         onclick="openLightbox('{{ $c['url'] }}', '{{ addslashes($v['name'].' — AY '.$c['year']) }}')"/>
    @endif
  </div>
  @empty
  <div class="ocv-empty">No organisation chart available.</div>
  @endforelse
</div>
