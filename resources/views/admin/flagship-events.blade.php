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
        ['Total Events',    $counts['total'],    'var(--navy)',  '<path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>'],
        ['In Planning',     $counts['planning'], 'var(--amber)', '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>'],
        ['Upcoming / Open', $counts['upcoming'], 'var(--green)', '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>'],
        ['Past Events',     $counts['past'],     'var(--grey)',  '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>'],
    ] as [$label, $val, $color, $icon])
    <div class="panel" style="padding:20px 22px;display:flex;align-items:center;gap:14px">
        <div style="width:40px;height:40px;border-radius:8px;background:{{ $color }}15;display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $color }}" stroke-width="2">{!! $icon !!}</svg>
        </div>
        <div>
            <div style="font-family:'Playfair Display',serif;font-size:26px;font-weight:900;color:var(--navy);line-height:1">{{ $val }}</div>
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

    @if($events->isEmpty())
    {{-- Empty state --}}
    <div style="padding:80px 24px;text-align:center">
        <div style="width:64px;height:64px;background:var(--off);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--light)" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <div style="font-size:16px;font-weight:700;color:var(--navy);margin-bottom:6px">No flagship events yet</div>
        <div style="font-size:13px;color:var(--grey);margin-bottom:20px">Create your first flagship event — NATSUM, CAFEO, or any major YES programme.</div>
        <button class="btn-prim" onclick="openPanel()">Create First Event</button>
    </div>
    @else
    {{-- Events table --}}
    <div class="pb" style="padding:0">
        <table style="width:100%;border-collapse:collapse" id="evTable">
            <thead>
                <tr style="background:var(--off);border-bottom:2px solid var(--light)">
                    <th style="padding:10px 20px;text-align:left;font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey)">Event</th>
                    <th style="padding:10px 16px;text-align:left;font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey)">Year</th>
                    <th style="padding:10px 16px;text-align:left;font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey)">Date</th>
                    <th style="padding:10px 16px;text-align:left;font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey)">Location</th>
                    <th style="padding:10px 16px;text-align:center;font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey)">Delegates</th>
                    <th style="padding:10px 16px;text-align:left;font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey)">Status</th>
                    <th style="padding:10px 20px;text-align:right;font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey)">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $ev)
                @php
                    $statusMeta = [
                        'planning' => ['label' => 'Planning',  'color' => 'var(--amber)',    'bg' => 'var(--amber-l)'],
                        'upcoming' => ['label' => 'Upcoming',  'color' => 'var(--navy)',     'bg' => 'var(--blue-l)'],
                        'open'     => ['label' => 'Open',      'color' => 'var(--green)',    'bg' => '#d1fae5'],
                        'past'     => ['label' => 'Past',      'color' => 'var(--grey)',     'bg' => 'var(--light)'],
                    ][$ev->status] ?? ['label' => ucfirst($ev->status), 'color' => 'var(--grey)', 'bg' => 'var(--light)'];
                @endphp
                <tr class="ev-row" data-status="{{ $ev->status }}" data-name="{{ strtolower($ev->short_name . ' ' . $ev->full_name) }}"
                    style="border-bottom:1px solid var(--light);transition:background .15s;cursor:pointer"
                    onclick="openPanelEdit({{ $ev->id }}, {{ json_encode($ev->toArray()) }})"
                    onmouseover="this.style.background='var(--off)'" onmouseout="this.style.background=''">
                    <td style="padding:16px 20px">
                        <div style="display:flex;align-items:center;gap:12px">
                            <div style="width:38px;height:38px;background:var(--navy-dark);border-radius:4px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <span style="font-family:'Playfair Display',serif;font-size:11px;font-weight:900;color:var(--gold);letter-spacing:-0.5px">{{ strtoupper(substr($ev->short_name, 0, 3)) }}</span>
                            </div>
                            <div>
                                <div style="font-size:13px;font-weight:700;color:var(--navy-dark)">{{ $ev->short_name }} {{ $ev->year }}</div>
                                <div style="font-size:11px;color:var(--grey);margin-top:1px">{{ Str::limit($ev->full_name, 40) }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding:16px">
                        <span style="font-family:'Playfair Display',serif;font-size:16px;font-weight:700;color:var(--navy)">{{ $ev->year }}</span>
                    </td>
                    <td style="padding:16px;font-size:12px;color:var(--grey)">{{ $ev->event_date ?: '—' }}</td>
                    <td style="padding:16px;font-size:12px;color:var(--grey)">{{ Str::limit($ev->location ?: '—', 30) }}</td>
                    <td style="padding:16px;text-align:center">
                        @if($ev->expected_delegates)
                        <span style="font-size:13px;font-weight:700;color:var(--navy)">{{ number_format($ev->expected_delegates) }}</span>
                        @else
                        <span style="color:var(--light)">—</span>
                        @endif
                    </td>
                    <td style="padding:16px">
                        <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;background:{{ $statusMeta['bg'] }};color:{{ $statusMeta['color'] }};border-radius:2px">
                            <span style="width:5px;height:5px;border-radius:50%;background:{{ $statusMeta['color'] }};display:inline-block"></span>
                            {{ $statusMeta['label'] }}
                        </span>
                    </td>
                    <td style="padding:16px 20px;text-align:right" onclick="event.stopPropagation()">
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:6px">
                            <button onclick="openPanelEdit({{ $ev->id }}, {{ json_encode($ev->toArray()) }})"
                                title="Edit" style="width:30px;height:30px;border:1px solid var(--light);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;border-radius:3px;transition:all .15s"
                                onmouseover="this.style.borderColor='var(--navy)'" onmouseout="this.style.borderColor='var(--light)'">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <div style="position:relative" id="menu-{{ $ev->id }}">
                                <button onclick="toggleMenu({{ $ev->id }})"
                                    title="More" style="width:30px;height:30px;border:1px solid var(--light);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;border-radius:3px;transition:all .15s"
                                    onmouseover="this.style.borderColor='var(--navy)'" onmouseout="this.style.borderColor='var(--light)'">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2.5"><circle cx="12" cy="5" r="1" fill="currentColor"/><circle cx="12" cy="12" r="1" fill="currentColor"/><circle cx="12" cy="19" r="1" fill="currentColor"/></svg>
                                </button>
                                <div id="dropdown-{{ $ev->id }}" style="display:none;position:absolute;right:0;top:34px;background:#fff;border:1px solid var(--light);box-shadow:0 8px 24px rgba(0,0,0,0.1);z-index:50;min-width:160px;border-radius:3px">
                                    @foreach(['planning'=>'Mark: Planning','upcoming'=>'Mark: Upcoming','open'=>'Mark: Open','past'=>'Mark: Past'] as $st => $lbl)
                                    @if($ev->status !== $st)
                                    <button onclick="changeStatus({{ $ev->id }}, '{{ $st }}')" style="display:block;width:100%;text-align:left;padding:9px 14px;border:none;background:none;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);cursor:pointer;transition:background .15s"
                                        onmouseover="this.style.background='var(--off)'" onmouseout="this.style.background=''">{{ $lbl }}</button>
                                    @endif
                                    @endforeach
                                    <div style="height:1px;background:var(--light);margin:4px 0"></div>
                                    <button onclick="deleteEvent({{ $ev->id }}, '{{ $ev->short_name }} {{ $ev->year }}')"
                                        style="display:block;width:100%;text-align:left;padding:9px 14px;border:none;background:none;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--red);cursor:pointer;transition:background .15s"
                                        onmouseover="this.style.background='var(--red-l)'" onmouseout="this.style.background=''">
                                        Delete Event
                                    </button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                <tr id="noEvRow" style="display:none">
                    <td colspan="7" style="padding:48px;text-align:center;color:var(--grey);font-size:13px">No events match your search.</td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- ── SLIDE-OUT PANEL ── --}}
<div id="feOverlay" onclick="closePanel()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.35);z-index:900;transition:opacity .25s"></div>

<div id="fePanel" style="position:fixed;top:0;right:0;height:100vh;width:520px;background:#fff;z-index:901;transform:translateX(100%);transition:transform .3s ease;display:flex;flex-direction:column;box-shadow:-8px 0 40px rgba(0,31,69,0.15)">

    {{-- Panel header --}}
    <div style="padding:20px 24px;border-bottom:1px solid var(--light);display:flex;align-items:center;justify-content:space-between;flex-shrink:0">
        <div>
            <div style="font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--gold);margin-bottom:4px" id="panelEyebrow">New Event</div>
            <div style="font-family:'Playfair Display',serif;font-size:18px;font-weight:900;color:var(--navy-dark)" id="panelTitle">Create <em>Flagship Event</em></div>
        </div>
        <button onclick="closePanel()" style="width:32px;height:32px;border:1px solid var(--light);background:var(--off);border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .15s"
            onmouseover="this.style.background='var(--light)'" onmouseout="this.style.background='var(--off)'">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>

    {{-- Panel body --}}
    <div style="flex:1;overflow-y:auto;padding:24px">
        <form id="feForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="feMethod" value="POST"/>
            <input type="hidden" name="_event_id" id="feEventId" value=""/>

            {{-- Short name + Year --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:18px">
                <div>
                    <label class="pf-lbl">Short Name <span style="color:var(--red)">*</span></label>
                    <input class="pf-input" id="f_short_name" type="text" name="short_name" placeholder="e.g. NATSUM"/>
                    <div style="font-size:10px;color:var(--grey);margin-top:4px">Acronym used in badges &amp; headers</div>
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
                    <div style="font-size:10px;color:var(--grey);margin-top:4px">If different from location</div>
                </div>
            </div>

            {{-- Divider --}}
            <div style="height:1px;background:var(--light);margin:4px 0 20px"></div>
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

@push('scripts')
<script>
// ── Panel open/close ────────────────────────────────────────────────────
let editingId = null;

function openPanel() {
    editingId = null;
    document.getElementById('panelEyebrow').textContent = 'New Event';
    document.getElementById('panelTitle').innerHTML = 'Create <em>Flagship Event</em>';
    document.getElementById('panelBtnLabel').textContent = 'Create Flagship Event';
    document.getElementById('panelDeleteBtn').style.display = 'none';
    document.getElementById('feMethod').value = 'POST';
    document.getElementById('feEventId').value = '';

    // Reset form
    ['f_short_name','f_full_name','f_event_date','f_location','f_host'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('f_year').value = new Date().getFullYear();
    document.getElementById('f_expected_delegates').value = 0;
    document.querySelector('input[name="status"][value="planning"]').checked = true;
    highlightStatus();

    showPanel();
}

function openPanelEdit(id, data) {
    editingId = id;
    document.getElementById('panelEyebrow').textContent = 'Edit Event';
    document.getElementById('panelTitle').innerHTML = data.short_name + ' ' + data.year;
    document.getElementById('panelBtnLabel').textContent = 'Save Changes';
    document.getElementById('panelDeleteBtn').style.display = 'block';
    document.getElementById('panelDeleteAction').onclick = () => deleteEvent(id, data.short_name + ' ' + data.year);
    document.getElementById('feMethod').value = 'PUT';
    document.getElementById('feEventId').value = id;

    // Populate form
    document.getElementById('f_short_name').value = data.short_name || '';
    document.getElementById('f_year').value = data.year || new Date().getFullYear();
    document.getElementById('f_full_name').value = data.full_name || '';
    document.getElementById('f_event_date').value = data.event_date || '';
    document.getElementById('f_expected_delegates').value = data.expected_delegates || 0;
    document.getElementById('f_location').value = data.location || '';
    document.getElementById('f_host').value = data.host || '';

    const statusRadio = document.querySelector(`input[name="status"][value="${data.status}"]`);
    if (statusRadio) { statusRadio.checked = true; }
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

function submitPanel() {
    const form = document.getElementById('feForm');
    // Validate required fields
    const shortName = document.getElementById('f_short_name').value.trim();
    const fullName  = document.getElementById('f_full_name').value.trim();
    if (!shortName || !fullName) {
        showToast('Short Name and Full Name are required.', 'warn');
        return;
    }

    // In demo mode: show success toast
    showToast(editingId ? 'Flagship event updated.' : 'Flagship event created.', 'success');
    closePanel();
}

// ── Status tile highlight ────────────────────────────────────────────────
function highlightStatus() {
    document.querySelectorAll('.status-tile').forEach(tile => {
        const radio = tile.querySelector('input[type="radio"]');
        if (radio.checked) {
            tile.style.borderColor = 'var(--navy)';
            tile.style.background = 'var(--off)';
        } else {
            tile.style.borderColor = 'var(--light)';
            tile.style.background = '#fff';
        }
    });
}

// ── Dropdown menus ────────────────────────────────────────────────────────
function toggleMenu(id) {
    const dd = document.getElementById('dropdown-' + id);
    const isOpen = dd.style.display === 'block';
    closeAllMenus();
    if (!isOpen) dd.style.display = 'block';
}
function closeAllMenus() {
    document.querySelectorAll('[id^="dropdown-"]').forEach(d => d.style.display = 'none');
}
document.addEventListener('click', e => {
    if (!e.target.closest('[id^="menu-"]')) closeAllMenus();
});

// ── Status change ─────────────────────────────────────────────────────────
function changeStatus(id, status) {
    closeAllMenus();
    showConfirm({
        title: 'Change Event Status',
        msg: `Update event status to <strong>${status}</strong>?`,
        chip: status.charAt(0).toUpperCase() + status.slice(1),
        type: status === 'past' ? 'reject' : 'approve',
        onConfirm: () => showToast(`Status updated to ${status}.`, 'success'),
    });
}

// ── Delete ────────────────────────────────────────────────────────────────
function deleteEvent(id, name) {
    closeAllMenus();
    showConfirm({
        title: 'Delete Flagship Event',
        msg: `Permanently delete <strong>${name}</strong>? This cannot be undone.`,
        chip: 'Delete',
        type: 'reject',
        requireNotes: false,
        onConfirm: () => showToast(`${name} deleted.`, 'danger'),
    });
}

// ── Search / filter ───────────────────────────────────────────────────────
function filterEvents() {
    const q = document.getElementById('evSearch').value.toLowerCase();
    const st = document.getElementById('evFilter').value;
    let visible = 0;
    document.querySelectorAll('.ev-row').forEach(row => {
        const matchQ  = !q  || row.dataset.name.includes(q);
        const matchSt = !st || row.dataset.status === st;
        const show = matchQ && matchSt;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    const noRow = document.getElementById('noEvRow');
    if (noRow) noRow.style.display = visible === 0 ? '' : 'none';
}

// Keyboard: Escape closes panel
document.addEventListener('keydown', e => { if (e.key === 'Escape') closePanel(); });
</script>
@endpush
