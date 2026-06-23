@extends('admin.layouts.app')

@section('title', 'Flagship Events')

@section('topbar-actions')
<button class="btn-primary" onclick="openPanel()">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    New Flagship Event
</button>
@endsection

@section('content')

{{-- ── STAT CARDS ── --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px">
    @foreach([
        ['Total Events',    $counts['total'],    'total',    'var(--navy)',  '<path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>'],
        ['In Planning',     $counts['planning'], 'planning', 'var(--amber)', '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>'],
        ['Upcoming / Open', $counts['upcoming'], 'upcoming', 'var(--green)', '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>'],
        ['Past Events',     $counts['past'],     'past',     'var(--grey)',  '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>'],
    ] as [$label, $val, $key, $color, $icon])
    <div class="panel" style="padding:20px 22px;display:flex;align-items:center;gap:14px">
        <div style="width:40px;height:40px;border-radius:8px;background:{{ $color }}15;display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $color }}" stroke-width="2">{!! $icon !!}</svg>
        </div>
        <div>
            <div data-count="{{ $key }}" style="font-family:'Playfair Display',serif;font-size:26px;font-weight:900;color:var(--navy);line-height:1">{{ $val }}</div>
            <div style="font-size:11px;color:var(--grey);letter-spacing:.5px;margin-top:2px">{{ $label }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- ── EVENTS LIST ── --}}
<div class="panel">
    <div class="ph" style="display:flex;align-items:center;justify-content:space-between">
        <div class="pt">Flagship <em>Events</em></div>
        <div style="display:flex;align-items:center;gap:10px">
            <div style="display:flex;align-items:center;gap:6px;background:var(--off);border:1px solid var(--light);padding:7px 12px">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="var(--grey)" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input id="evSearch" type="text" placeholder="Search events…" oninput="filterEvents()"
                    style="border:none;outline:none;background:transparent;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);width:160px"/>
            </div>
            <select id="evFilter" onchange="filterEvents()"
                style="border:1px solid var(--light);background:var(--off);padding:7px 10px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);cursor:pointer;outline:none">
                <option value="">All Statuses</option>
                <option value="planning">Planning</option>
                <option value="upcoming">Upcoming</option>
                <option value="open">Open</option>
                <option value="past">Past</option>
            </select>
        </div>
    </div>

    {{-- Empty state — shown by JS when there are no events at all --}}
    <div id="evEmpty" style="display:none;padding:80px 24px;text-align:center">
        <div style="width:64px;height:64px;background:var(--off);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--light)" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <div style="font-size:16px;font-weight:700;color:var(--navy);margin-bottom:6px">No flagship events yet</div>
        <div style="font-size:13px;color:var(--grey);margin-bottom:20px">Create your first flagship event — NATSUM, CAFEO, or any major YES programme.</div>
        <button class="btn-prim" onclick="openPanel()">Create First Event</button>
    </div>

    {{-- No-results state — shown by JS when filters hide everything --}}
    <div id="evNoResults" style="display:none;padding:48px;text-align:center;color:var(--grey);font-size:13px">
        No events match your search.
    </div>

    {{-- Category sections — rendered by JS, grouped by category & sorted by year --}}
    <div id="evGroups" style="padding:0"></div>
</div>

{{-- ── SLIDE-OUT PANEL ── --}}
<div id="feOverlay" onclick="closePanel()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.35);z-index:900"></div>

<div id="fePanel" style="position:fixed;top:0;right:0;height:100vh;width:680px;background:#fff;z-index:901;transform:translateX(100%);transition:transform .3s ease;display:flex;flex-direction:column;box-shadow:-8px 0 40px rgba(0,31,69,0.15)">

    {{-- Panel header --}}
    <div style="padding:20px 24px;border-bottom:1px solid var(--light);display:flex;align-items:center;justify-content:space-between;flex-shrink:0">
        <div>
            <div style="font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--gold);margin-bottom:4px" id="panelEyebrow">New Event</div>
            <div style="font-family:'Playfair Display',serif;font-size:18px;font-weight:900;color:var(--navy-dark)" id="panelTitle">Create <em>Flagship Event</em></div>
        </div>
        <div style="display:flex;align-items:center;gap:8px">
            <a id="panelViewLink" href="#" target="_blank" style="display:none;font-size:11px;color:var(--grey);text-decoration:none;border:1px solid var(--light);padding:5px 10px;border-radius:3px;transition:all .15s"
                onmouseover="this.style.borderColor='var(--navy)';this.style.color='var(--navy)'" onmouseout="this.style.borderColor='var(--light)';this.style.color='var(--grey)'">
                View Public Page ↗
            </a>
            <button onclick="closePanel()" style="width:32px;height:32px;border:1px solid var(--light);background:var(--off);border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .15s"
                onmouseover="this.style.background='var(--light)'" onmouseout="this.style.background='var(--off)'">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
    </div>

    {{-- Panel body --}}
    <div style="flex:1;overflow-y:auto;padding:24px">
        <form id="feForm" method="POST" action="{{ route('admin.flagship-events.store') }}">
            @csrf
            <input type="hidden" name="_method" id="feMethod" value="POST"/>
            <input type="hidden" name="_event_id" id="feEventId" value=""/>

            {{-- ── SECTION: Basic Info ── --}}
            <div style="font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--gold);margin-bottom:14px">Basic Info</div>

            {{-- Category + Year --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:18px">
                <div>
                    <label class="pf-lbl">Flagship Category <span style="color:var(--red)">*</span></label>
                    <select class="pf-input" id="f_short_name" name="short_name" onchange="onCategoryChange()">
                        <option value="" disabled selected>Select a category…</option>
                        @foreach($categories as $cat => $defaultName)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                    <div style="font-size:10px;color:var(--grey);margin-top:4px">Each edition is filed under its category by year</div>
                </div>
                <div>
                    <label class="pf-lbl">Year <span style="color:var(--red)">*</span></label>
                    <input class="pf-input" id="f_year" type="number" name="year" value="{{ now()->year }}" min="2000"/>
                </div>
            </div>

            {{-- Full name --}}
            <div style="margin-bottom:18px">
                <label class="pf-lbl">Full Event Name <span style="color:var(--red)">*</span></label>
                <input class="pf-input" id="f_full_name" type="text" name="full_name" placeholder="e.g. National Student Summit"/>
                <div style="font-size:10px;color:var(--grey);margin-top:4px">Auto-filled from the category — edit if this edition differs</div>
            </div>

            {{-- Divider --}}
            <div style="height:1px;background:var(--light);margin:4px 0 20px"></div>
            <div style="font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);margin-bottom:14px">Logistics</div>

            {{-- Date + Delegates --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:18px">
                <div>
                    <label class="pf-lbl">Event Date</label>
                    <input class="pf-input" id="f_event_date" type="text" name="event_date" placeholder="e.g. August 2026 (TBC)"/>
                    <div style="font-size:10px;color:var(--grey);margin-top:4px">Free text — can be approximate</div>
                </div>
                <div>
                    <label class="pf-lbl">Expected Delegates</label>
                    <input class="pf-input" id="f_expected_delegates" type="number" name="expected_delegates" value="0" min="0"/>
                </div>
            </div>

            {{-- Location + Host --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:18px">
                <div>
                    <label class="pf-lbl">Location</label>
                    <input class="pf-input" id="f_location" type="text" name="location" placeholder="e.g. Universiti Malaya, KL"/>
                </div>
                <div>
                    <label class="pf-lbl">Host</label>
                    <input class="pf-input" id="f_host" type="text" name="host" placeholder="e.g. Malaysia (YES IEM)"/>
                </div>
            </div>

            {{-- Registration URL --}}
            <div style="margin-bottom:18px">
                <label class="pf-lbl">Registration Link</label>
                <input class="pf-input" id="f_registration_url" type="url" name="registration_url" placeholder="https://forms.gle/..."/>
                <div style="font-size:10px;color:var(--grey);margin-top:4px">Shown as a "Register Now" button on the public page</div>
            </div>

            {{-- ── SECTION: Edition Stats ── --}}
            <div style="height:1px;background:var(--light);margin:4px 0 20px"></div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px">
                <div style="font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--gold)">Edition Stats</div>
                <span style="font-size:10px;color:var(--grey)">Figures shown on the public page hero &amp; highlights</span>
            </div>
            <div id="statsHint" style="font-size:11px;color:var(--grey);margin-bottom:14px">Select a category above to set its distinguishing figures.</div>
            @foreach($statFields as $cat => $fields)
            <div class="stats-group" data-cat="{{ $cat }}" style="display:none;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:8px">
                @foreach($fields as $f)
                <div>
                    <label class="pf-lbl">{{ $f['label'] }}</label>
                    <input class="pf-input stat-input" data-key="{{ $f['key'] }}" type="text" placeholder="{{ $f['placeholder'] }}"/>
                </div>
                @endforeach
            </div>
            @endforeach

            {{-- Divider --}}
            <div style="height:1px;background:var(--light);margin:18px 0 20px"></div>
            <div style="font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);margin-bottom:14px">Status</div>

            {{-- Status tiles --}}
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:6px">
                @foreach([
                    ['planning','Planning','var(--amber)','<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>'],
                    ['upcoming','Upcoming','var(--navy)','<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>'],
                    ['open','Open','var(--green)','<polyline points="20 6 9 17 4 12"/>'],
                    ['past','Past','var(--grey)','<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>'],
                ] as [$val,$lbl,$col,$ico])
                <label style="display:flex;flex-direction:column;align-items:center;gap:6px;padding:10px 6px;border:2px solid var(--light);cursor:pointer;border-radius:3px;transition:all .2s" class="status-tile" data-val="{{ $val }}">
                    <input type="radio" name="status" value="{{ $val }}" style="display:none" {{ $val === 'planning' ? 'checked' : '' }} onchange="highlightStatus()"/>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $col }}" stroke-width="2">{!! $ico !!}</svg>
                    <span style="font-size:10px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--navy)">{{ $lbl }}</span>
                </label>
                @endforeach
            </div>

            {{-- Live / Draft visibility --}}
            <div style="margin-top:18px;display:flex;align-items:center;gap:12px;padding:12px 14px;background:var(--off);border:1px solid var(--light);border-radius:4px">
                <button type="button" id="f_pub_toggle" onclick="togglePublish()"
                    style="width:42px;height:24px;border-radius:12px;border:none;cursor:pointer;background:var(--green);position:relative;transition:background .2s;flex-shrink:0">
                    <span id="f_pub_knob" style="position:absolute;top:3px;left:21px;width:18px;height:18px;border-radius:50%;background:#fff;transition:left .2s;box-shadow:0 1px 3px rgba(0,0,0,.2)"></span>
                </button>
                <input type="hidden" id="f_is_published" value="1"/>
                <div>
                    <div id="f_pub_lbl" style="font-size:13px;font-weight:600;color:var(--navy)">Live — visible on public site</div>
                    <div style="font-size:11px;color:var(--grey)">Draft editions are hidden from the public site &amp; year navigation</div>
                </div>
            </div>

            {{-- ── SECTION: Page Content ── --}}
            <div style="height:1px;background:var(--light);margin:20px 0"></div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px">
                <div style="font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--gold)">Public Page Content</div>
                <span style="font-size:10px;color:var(--grey)">Generates the dedicated event page on the public site</span>
            </div>

            {{-- Theme / Tagline --}}
            <div style="margin-bottom:18px">
                <label class="pf-lbl">Event Theme / Tagline</label>
                <input class="pf-input" id="f_theme" type="text" name="theme" placeholder="e.g. Engineering Tomorrow, Leading Today"/>
                <div style="font-size:10px;color:var(--grey);margin-top:4px">Displayed prominently below the event title on the public page</div>
            </div>

            {{-- Description --}}
            <div style="margin-bottom:18px">
                <label class="pf-lbl">Hero Description</label>
                <textarea class="pf-input" id="f_description" name="description" rows="3"
                    style="resize:vertical;line-height:1.6"
                    placeholder="A short paragraph shown in the hero section of the public page. Describe what this edition is about..."></textarea>
            </div>

            {{-- Content blocks --}}
            <div style="margin-bottom:18px">
                <label class="pf-lbl">Content Blocks</label>
                <div style="font-size:10px;color:var(--grey);margin-bottom:12px;line-height:1.6">Fill the sections below — the public page renders them into a clean layout. No HTML needed. Leave a section blank to hide it.</div>

                <div style="margin-bottom:14px">
                    <div style="font-size:11px;font-weight:700;color:var(--navy);margin-bottom:6px">About This Edition</div>
                    <textarea class="pf-input" id="f_block_overview" rows="3" style="resize:vertical;line-height:1.6" placeholder="What makes this year's edition special…"></textarea>
                </div>

                <div style="margin-bottom:14px">
                    <div style="font-size:11px;font-weight:700;color:var(--navy);margin-bottom:6px">Programme Highlights</div>
                    <div id="f_block_programme"></div>
                    <button type="button" onclick="cbAddRow('programme')" style="font-size:11px;color:var(--navy);background:none;border:1px dashed var(--light);padding:6px 12px;cursor:pointer;border-radius:3px;margin-top:4px;font-family:'DM Sans',sans-serif">+ Add row</button>
                </div>

                <div style="margin-bottom:14px">
                    <div style="font-size:11px;font-weight:700;color:var(--navy);margin-bottom:6px">Who Should Attend</div>
                    <textarea class="pf-input" id="f_block_audience" rows="2" style="resize:vertical;line-height:1.6" placeholder="Who the event is open to…"></textarea>
                </div>

                <div style="margin-bottom:14px">
                    <div style="font-size:11px;font-weight:700;color:var(--navy);margin-bottom:6px">Key Dates</div>
                    <div id="f_block_key_dates"></div>
                    <button type="button" onclick="cbAddRow('key_dates')" style="font-size:11px;color:var(--navy);background:none;border:1px dashed var(--light);padding:6px 12px;cursor:pointer;border-radius:3px;margin-top:4px;font-family:'DM Sans',sans-serif">+ Add date</button>
                </div>

                <div>
                    <div style="font-size:11px;font-weight:700;color:var(--navy);margin-bottom:6px">Venue &amp; Travel</div>
                    <textarea class="pf-input" id="f_block_venue" rows="2" style="resize:vertical;line-height:1.6" placeholder="Venue, hotels, travel notes…"></textarea>
                </div>
            </div>
        </form>
    </div>

    {{-- Panel footer --}}
    <div style="padding:16px 24px;border-top:1px solid var(--light);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;background:var(--off)">
        <div id="panelDeleteBtn" style="display:none">
            <button id="panelDeleteAction" type="button" onclick="" style="font-size:12px;color:var(--red);background:none;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;padding:0;display:flex;align-items:center;gap:5px">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                Delete Event
            </button>
        </div>
        <div style="flex:1"></div>
        <div style="display:flex;gap:10px">
            <button type="button" onclick="closePanel()" class="btn-ghost">Cancel</button>
            <button type="button" id="panelSubmitBtn" onclick="submitPanel()" class="btn-prim">
                <span id="panelBtnLabel">Create Flagship Event</span>
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
const CSRF         = document.querySelector('meta[name="csrf-token"]').content;
const feData       = @json($events->keyBy('id'));  // live cache
const CATEGORIES   = @json($categories);            // { SHORT_NAME: 'Default Full Name' }
const fePublicBase = '{{ url('/events/flagship') }}';
const feAdminBase  = '/dashboard/admin/flagship-events';

const STATUS_META = {
    planning: { label:'Planning', color:'var(--amber)',    bg:'var(--amber-l)' },
    upcoming: { label:'Upcoming', color:'var(--navy)',     bg:'var(--blue-l)'  },
    open:     { label:'Open',     color:'var(--green)',    bg:'#d1fae5'        },
    past:     { label:'Past',     color:'var(--grey)',     bg:'var(--light)'   },
};

let editingId = null;

/* ── helpers ── */
async function api(url, method, body) {
    const r = await fetch(url, {
        method,
        headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept':'application/json' },
        body: body ? JSON.stringify(body) : undefined,
    });
    const json = await r.json();
    if (!r.ok) {
        // Surface the first validation message so the catch block can show it
        const firstMsg = json.errors ? Object.values(json.errors)[0]?.[0] : (json.message || 'Server error');
        throw new Error(firstMsg);
    }
    return json;
}
function shortAbbr(s) { return (s||'').toUpperCase().slice(0,3); }
function limitStr(s, n) { return s && s.length > n ? s.slice(0,n)+'…' : (s||'—'); }
function fmtDelegates(n) { return n ? Number(n).toLocaleString() : '—'; }

/* ── grouped render ── */
function buildEventRow(ev) {
    const sm = STATUS_META[ev.status] || STATUS_META.past;
    return `
    <tr class="ev-row" data-id="${ev.id}"
        style="border-bottom:1px solid var(--light);transition:background .15s;cursor:pointer"
        onclick="openPanelEdit(${ev.id})"
        onmouseover="this.style.background='var(--off)'" onmouseout="this.style.background=''">
      <td style="padding:14px 20px;width:90px">
        <span style="font-family:'Playfair Display',serif;font-size:22px;font-weight:900;color:var(--navy);line-height:1">${ev.year}</span>
      </td>
      <td style="padding:14px 12px">
        <div style="font-size:13px;font-weight:700;color:var(--navy-dark)">${ev.short_name} ${ev.year}</div>
        <div style="font-size:11px;color:var(--grey);margin-top:1px">${limitStr(ev.full_name,46)}</div>
      </td>
      <td style="padding:14px 12px;font-size:12px;color:var(--grey)">${ev.event_date||'—'}</td>
      <td style="padding:14px 12px;font-size:12px;color:var(--grey)">${limitStr(ev.location,28)}</td>
      <td style="padding:14px 12px;text-align:center">
        ${ev.expected_delegates
          ? `<span style="font-size:13px;font-weight:700;color:var(--navy)">${fmtDelegates(ev.expected_delegates)}</span>`
          : `<span style="color:var(--light)">—</span>`}
      </td>
      <td style="padding:14px 12px">
        <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;background:${sm.bg};color:${sm.color};border-radius:2px">
          <span style="width:5px;height:5px;border-radius:50%;background:${sm.color};display:inline-block"></span>${sm.label}
        </span>
        ${ev.is_published === false
          ? `<span style="margin-left:6px;font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--grey)">○ Draft</span>`
          : `<span style="margin-left:6px;font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--green)">● Live</span>`}
      </td>
      <td style="padding:14px 20px;text-align:right" onclick="event.stopPropagation()">
        <div style="display:flex;align-items:center;justify-content:flex-end;gap:6px">
          <button onclick="openPanelEdit(${ev.id})" title="Edit"
            style="width:30px;height:30px;border:1px solid var(--light);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;border-radius:3px;transition:all .15s"
            onmouseover="this.style.borderColor='var(--navy)'" onmouseout="this.style.borderColor='var(--light)'">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          </button>
          <div style="position:relative" id="menu-${ev.id}">
            <button onclick="toggleMenu(${ev.id})" title="More"
              style="width:30px;height:30px;border:1px solid var(--light);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;border-radius:3px;transition:all .15s"
              onmouseover="this.style.borderColor='var(--navy)'" onmouseout="this.style.borderColor='var(--light)'">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2.5"><circle cx="12" cy="5" r="1" fill="currentColor"/><circle cx="12" cy="12" r="1" fill="currentColor"/><circle cx="12" cy="19" r="1" fill="currentColor"/></svg>
            </button>
            <div id="dropdown-${ev.id}" style="display:none;position:absolute;right:0;top:34px;background:#fff;border:1px solid var(--light);box-shadow:0 8px 24px rgba(0,0,0,0.1);z-index:50;min-width:160px;border-radius:3px">
              ${Object.entries(STATUS_META).filter(([k])=>k!==ev.status).map(([k,m])=>`
              <button onclick="changeStatus(${ev.id},'${k}')"
                style="display:block;width:100%;text-align:left;padding:9px 14px;border:none;background:none;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);cursor:pointer;transition:background .15s"
                onmouseover="this.style.background='var(--off)'" onmouseout="this.style.background=''">Mark: ${m.label}</button>`).join('')}
              <div style="height:1px;background:var(--light);margin:4px 0"></div>
              <button onclick="deleteEvent(${ev.id},'${ev.short_name} ${ev.year}')"
                style="display:block;width:100%;text-align:left;padding:9px 14px;border:none;background:none;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--red);cursor:pointer;transition:background .15s"
                onmouseover="this.style.background='var(--red-l)'" onmouseout="this.style.background=''">Delete Event</button>
            </div>
          </div>
        </div>
      </td>
    </tr>`;
}

function buildCategorySection(cat, rows) {
    const latest = rows[0];  // rows already sorted year desc
    const pubUrl = fePublicBase + '/' + cat.toLowerCase();
    return `
    <div class="cat-section" style="border-bottom:8px solid var(--off)">
      <div style="display:flex;align-items:center;gap:14px;padding:16px 20px;background:var(--navy-dark)">
        <div style="width:42px;height:42px;background:var(--gold);border-radius:5px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
          <span style="font-family:'Playfair Display',serif;font-size:13px;font-weight:900;color:var(--navy-dark);letter-spacing:-0.5px">${shortAbbr(cat)}</span>
        </div>
        <div style="flex:1">
          <div style="font-size:15px;font-weight:700;color:#fff">${cat}</div>
          <div style="font-size:11px;color:rgba(255,255,255,.55);margin-top:1px">${limitStr(latest.full_name,60)} · ${rows.length} edition${rows.length!==1?'s':''}</div>
        </div>
        <a href="${pubUrl}" target="_blank" rel="noopener"
           style="font-size:11px;color:var(--gold);text-decoration:none;border:1px solid rgba(200,168,75,.4);padding:6px 12px;border-radius:3px;white-space:nowrap;transition:all .15s"
           onmouseover="this.style.background='rgba(200,168,75,.12)'" onmouseout="this.style.background='transparent'">
          View Public ↗
        </a>
      </div>
      <table style="width:100%;border-collapse:collapse">
        <thead>
          <tr style="background:var(--off);border-bottom:1px solid var(--light)">
            <th style="padding:8px 20px;text-align:left;font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey)">Year</th>
            <th style="padding:8px 12px;text-align:left;font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey)">Edition</th>
            <th style="padding:8px 12px;text-align:left;font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey)">Date</th>
            <th style="padding:8px 12px;text-align:left;font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey)">Location</th>
            <th style="padding:8px 12px;text-align:center;font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey)">Delegates</th>
            <th style="padding:8px 12px;text-align:left;font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey)">Status</th>
            <th style="padding:8px 20px;text-align:right;font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey)">Actions</th>
          </tr>
        </thead>
        <tbody>${rows.map(buildEventRow).join('')}</tbody>
      </table>
    </div>`;
}

function renderGroups() {
    const q  = (document.getElementById('evSearch').value || '').toLowerCase().trim();
    const st = document.getElementById('evFilter').value;

    // Filter
    const matched = Object.values(feData).filter(ev => {
        const hay = (ev.short_name + ' ' + ev.full_name + ' ' + (ev.location||'')).toLowerCase();
        return (!q || hay.includes(q)) && (!st || ev.status === st);
    });

    // Group by category (short_name)
    const groups = {};
    matched.forEach(ev => { (groups[ev.short_name] ||= []).push(ev); });

    // Sort each group by year desc; order categories by their newest edition desc
    const cats = Object.keys(groups).sort((a, b) => {
        const ya = Math.max(...groups[a].map(e => e.year));
        const yb = Math.max(...groups[b].map(e => e.year));
        return yb - ya || a.localeCompare(b);
    });
    cats.forEach(c => groups[c].sort((a, b) => b.year - a.year));

    const container = document.getElementById('evGroups');
    container.innerHTML = cats.map(c => buildCategorySection(c, groups[c])).join('');

    // Empty / no-results states
    const totalAll = Object.keys(feData).length;
    document.getElementById('evEmpty').style.display     = totalAll === 0 ? 'block' : 'none';
    document.getElementById('evNoResults').style.display = (totalAll > 0 && matched.length === 0) ? 'block' : 'none';

    refreshCounts();
}

function refreshCounts() {
    const all = Object.values(feData);
    document.querySelectorAll('[data-count]').forEach(el => {
        const key = el.dataset.count;
        if (key === 'total')    el.textContent = all.length;
        if (key === 'planning') el.textContent = all.filter(e=>e.status==='planning').length;
        if (key === 'upcoming') el.textContent = all.filter(e=>['upcoming','open'].includes(e.status)).length;
        if (key === 'past')     el.textContent = all.filter(e=>e.status==='past').length;
    });
}

/* ── panel ── */
function openPanel() {
    editingId = null;
    document.getElementById('panelEyebrow').textContent = 'New Event';
    document.getElementById('panelTitle').innerHTML = 'Create <em>Flagship Event</em>';
    document.getElementById('panelBtnLabel').textContent = 'Create Flagship Event';
    document.getElementById('panelDeleteBtn').style.display = 'none';
    document.getElementById('panelViewLink').style.display = 'none';
    ['f_short_name','f_full_name','f_event_date','f_location','f_host',
     'f_theme','f_description','f_registration_url'].forEach(id => {
        document.getElementById(id).value = '';
    });
    cbReset();
    document.getElementById('f_year').value = new Date().getFullYear();
    document.getElementById('f_expected_delegates').value = 0;
    document.querySelector('input[name="status"][value="planning"]').checked = true;
    // Reset all stat inputs and hide the groups
    document.querySelectorAll('.stat-input').forEach(i => i.value = '');
    showStatsForCategory('');
    setPublish(true);   // new editions default to Live
    highlightStatus();
    showPanel();
}

function openPanelEdit(id) {
    const data = feData[id];
    if (!data) return;
    editingId = id;
    document.getElementById('panelEyebrow').textContent = 'Edit Event';
    document.getElementById('panelTitle').innerHTML = data.short_name + ' ' + data.year;
    document.getElementById('panelBtnLabel').textContent = 'Save Changes';
    document.getElementById('panelDeleteBtn').style.display = 'block';
    document.getElementById('panelDeleteAction').onclick = () => deleteEvent(id, data.short_name + ' ' + data.year);

    const link = document.getElementById('panelViewLink');
    link.href = fePublicBase + '/' + data.short_name.toLowerCase();
    link.style.display = 'inline-flex';

    // Ensure the category select has an option for this event (covers legacy categories)
    const catSel = document.getElementById('f_short_name');
    if (data.short_name && !Array.from(catSel.options).some(o => o.value === data.short_name)) {
        catSel.insertAdjacentHTML('beforeend', `<option value="${data.short_name}">${data.short_name}</option>`);
    }
    catSel.value = data.short_name || '';
    document.getElementById('f_year').value                 = data.year || new Date().getFullYear();
    document.getElementById('f_full_name').value            = data.full_name || '';
    document.getElementById('f_event_date').value           = data.event_date || '';
    document.getElementById('f_expected_delegates').value   = data.expected_delegates || 0;
    document.getElementById('f_location').value             = data.location || '';
    document.getElementById('f_host').value                 = data.host || '';
    document.getElementById('f_registration_url').value     = data.registration_url || '';
    document.getElementById('f_theme').value                = data.theme || '';
    document.getElementById('f_description').value          = data.description || '';
    cbFill(data.content_blocks);

    const radio = document.querySelector(`input[name="status"][value="${data.status}"]`);
    if (radio) radio.checked = true;

    // Stats: show this category's group and fill from saved values
    document.querySelectorAll('.stat-input').forEach(i => i.value = '');
    showStatsForCategory(data.short_name || '');
    fillStats(data.short_name, data.stats || {});

    // Live/Draft — default to Live for legacy rows where the flag is undefined
    setPublish(data.is_published === undefined ? true : !!data.is_published);

    highlightStatus();
    showPanel();
}

function showPanel() {
    document.getElementById('feOverlay').style.display = 'block';
    document.getElementById('fePanel').style.transform = 'translateX(0)';
    document.body.style.overflow = 'hidden';
}

function closePanel() {
    document.getElementById('feOverlay').style.display = 'none';
    document.getElementById('fePanel').style.transform = 'translateX(100%)';
    document.body.style.overflow = '';
}

async function submitPanel() {
    const shortName = document.getElementById('f_short_name').value.trim();
    const fullName  = document.getElementById('f_full_name').value.trim();
    if (!shortName || !fullName) { showToast('Category and Full Name are required.', 'danger'); return; }

    const payload = {
        short_name:           shortName,
        full_name:            fullName,
        year:                 parseInt(document.getElementById('f_year').value),
        event_date:           document.getElementById('f_event_date').value.trim() || null,
        expected_delegates:   parseInt(document.getElementById('f_expected_delegates').value) || null,
        location:             document.getElementById('f_location').value.trim() || null,
        host:                 document.getElementById('f_host').value.trim() || null,
        registration_url:     (() => { const v = document.getElementById('f_registration_url').value.trim(); return (v && /^https?:\/\/.+\..+/.test(v)) ? v : null; })(),
        status:               document.querySelector('input[name="status"]:checked')?.value || 'planning',
        is_published:         document.getElementById('f_is_published').value === '1',
        theme:                document.getElementById('f_theme').value.trim() || null,
        description:          document.getElementById('f_description').value.trim() || null,
        content_blocks:       cbCollect(),
        stats:                collectStats(),
    };

    const btn = document.getElementById('panelSubmitBtn');
    btn.disabled = true;
    document.getElementById('panelBtnLabel').textContent = 'Saving…';

    try {
        const url    = editingId ? `${feAdminBase}/${editingId}` : feAdminBase;
        const method = editingId ? 'PUT' : 'POST';
        const res    = await api(url, method, payload);
        if (res.event) {
            feData[res.event.id] = res.event;
            renderGroups();
            closePanel();
            showToast(editingId ? 'Event updated' : 'Event created', 'success');
        }
    } catch (e) {
        showToast(e.message || 'Something went wrong.', 'danger');
    } finally {
        btn.disabled = false;
        document.getElementById('panelBtnLabel').textContent = editingId ? 'Save Changes' : 'Create Flagship Event';
    }
}

/* ── live / draft toggle ── */
function togglePublish() {
    setPublish(document.getElementById('f_is_published').value !== '1');
}
function setPublish(live) {
    document.getElementById('f_is_published').value = live ? '1' : '0';
    const toggle = document.getElementById('f_pub_toggle');
    const knob   = document.getElementById('f_pub_knob');
    const lbl    = document.getElementById('f_pub_lbl');
    toggle.style.background = live ? 'var(--green)' : 'var(--light)';
    knob.style.left = live ? '21px' : '3px';
    lbl.textContent = live ? 'Live — visible on public site' : 'Draft — hidden from public site';
}

/* ── status tile highlight ── */
function highlightStatus() {
    document.querySelectorAll('.status-tile').forEach(tile => {
        const radio = tile.querySelector('input[type="radio"]');
        tile.style.borderColor = radio.checked ? 'var(--navy)' : 'var(--light)';
        tile.style.background  = radio.checked ? 'var(--off)'  : '#fff';
    });
}

/* ── dropdown menus ── */
function toggleMenu(id) {
    const dd = document.getElementById('dropdown-' + id);
    const open = dd.style.display === 'block';
    closeAllMenus();
    if (!open) dd.style.display = 'block';
}
function closeAllMenus() {
    document.querySelectorAll('[id^="dropdown-"]').forEach(d => d.style.display = 'none');
}
document.addEventListener('click', e => { if (!e.target.closest('[id^="menu-"]')) closeAllMenus(); });

/* ── status change ── */
async function changeStatus(id, status) {
    closeAllMenus();
    try {
        const res = await api(`${feAdminBase}/${id}`, 'PUT', { _status_only: true, status });
        if (res.event) { feData[res.event.id] = res.event; renderGroups(); showToast(`Marked as ${status}`, 'success'); }
    } catch (e) { showToast(e.message || 'Could not update status.', 'danger'); }
}

/* ── delete ── */
async function deleteEvent(id, name) {
    closeAllMenus();
    if (!confirm(`Permanently delete "${name}"? This cannot be undone.`)) return;
    const res = await api(`${feAdminBase}/${id}`, 'DELETE');
    if (res.success) {
        delete feData[id];
        renderGroups();
        closePanel();
        showToast('Event deleted', 'danger');
    }
}

/* ── search / filter ── */
function filterEvents() { renderGroups(); }

/* ── category → auto-fill full name + show its stat fields ── */
function onCategoryChange() {
    const cat = document.getElementById('f_short_name').value;
    const fullNameEl = document.getElementById('f_full_name');
    // Only auto-fill when empty so manual edits are never clobbered
    if (cat && CATEGORIES[cat] && !fullNameEl.value.trim()) {
        fullNameEl.value = CATEGORIES[cat];
    }
    showStatsForCategory(cat);
}

/* ── stats section visibility ── */
function showStatsForCategory(cat) {
    let shown = false;
    document.querySelectorAll('.stats-group').forEach(g => {
        const match = g.dataset.cat === cat;
        g.style.display = match ? 'grid' : 'none';
        if (match) shown = true;
    });
    document.getElementById('statsHint').style.display = shown ? 'none' : 'block';
}

/* Read the visible stat inputs into a { key: value } object */
function collectStats() {
    const out = {};
    const group = document.querySelector('.stats-group[data-cat="' + document.getElementById('f_short_name').value + '"]');
    if (!group) return out;
    group.querySelectorAll('.stat-input').forEach(inp => {
        const v = inp.value.trim();
        if (v) out[inp.dataset.key] = v;
    });
    return out;
}

/* ── content blocks ── */
const CB_ROWS = {
  programme: { fields: ['label', 'text'], ph: ['Day 1', 'Opening Ceremony & Keynote'] },
  key_dates: { fields: ['label', 'date'], ph: ['Early-bird registration', 'closes 31 Aug 2026'] },
};
function cbAddRow(type, vals = {}) {
  const cfg = CB_ROWS[type];
  const wrap = document.getElementById('f_block_' + type);
  const row = document.createElement('div');
  row.className = 'cb-row';
  row.style.cssText = 'display:flex;gap:8px;margin-bottom:6px';
  row.innerHTML = cfg.fields.map((f, i) =>
    `<input class="pf-input cb-field" data-f="${f}" value="${(vals[f] || '').replace(/"/g, '&quot;')}" placeholder="${cfg.ph[i]}" style="flex:${i === 0 ? '0 0 32%' : '1'}"/>`
  ).join('') +
    `<button type="button" onclick="this.parentElement.remove()" title="Remove" style="border:1px solid var(--light);background:#fff;color:var(--red);cursor:pointer;padding:0 11px;border-radius:3px;flex-shrink:0">×</button>`;
  wrap.appendChild(row);
}
function cbRows(type) {
  return Array.from(document.querySelectorAll('#f_block_' + type + ' .cb-row')).map(r => {
    const o = {};
    r.querySelectorAll('.cb-field').forEach(f => o[f.dataset.f] = f.value.trim());
    return o;
  }).filter(o => Object.values(o).some(v => v));
}
function cbCollect() {
  return {
    overview:  document.getElementById('f_block_overview').value.trim(),
    programme: cbRows('programme'),
    audience:  document.getElementById('f_block_audience').value.trim(),
    key_dates: cbRows('key_dates'),
    venue:     document.getElementById('f_block_venue').value.trim(),
  };
}
function cbFill(blocks) {
  blocks = blocks || {};
  document.getElementById('f_block_overview').value = blocks.overview || '';
  document.getElementById('f_block_audience').value = blocks.audience || '';
  document.getElementById('f_block_venue').value    = blocks.venue || '';
  ['programme', 'key_dates'].forEach(type => {
    const wrap = document.getElementById('f_block_' + type);
    wrap.innerHTML = '';
    (blocks[type] || []).forEach(v => cbAddRow(type, v));
  });
}
function cbReset() {
  document.getElementById('f_block_overview').value = '';
  document.getElementById('f_block_audience').value = '';
  document.getElementById('f_block_venue').value    = '';
  ['programme', 'key_dates'].forEach(t => document.getElementById('f_block_' + t).innerHTML = '');
}

/* Fill the stat inputs for a category from a stats object */
function fillStats(cat, stats) {
    const group = document.querySelector('.stats-group[data-cat="' + cat + '"]');
    if (!group) return;
    group.querySelectorAll('.stat-input').forEach(inp => {
        inp.value = (stats && stats[inp.dataset.key]) || '';
    });
}

/* ── initial render ── */
renderGroups();

document.addEventListener('keydown', e => { if (e.key === 'Escape') closePanel(); });
</script>
@endsection
