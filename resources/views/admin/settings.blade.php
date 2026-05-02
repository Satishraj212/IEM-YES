@extends('admin.layouts.app')

@section('title', 'State Branches')

@section('topbar-actions')
<button class="btn-primary" onclick="document.getElementById('addBranchModal').classList.add('open')">
    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add Branch
</button>
@endsection

@section('styles')
<style>
.branch-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
.bc{background:#fff;border:1px solid var(--light);border-radius:4px;overflow:hidden;transition:box-shadow .2s}
.bc:hover{box-shadow:0 4px 18px rgba(0,31,69,.08)}
.bc-top{height:5px}
.bc-body{padding:16px 18px}
.bc-name{font-size:13px;font-weight:700;color:var(--navy);margin-bottom:2px}
.bc-state{font-size:10px;color:var(--grey);letter-spacing:.5px;text-transform:uppercase;margin-bottom:14px}
.bc-stat{display:flex;align-items:baseline;gap:6px;margin-bottom:6px}
.bc-stat-val{font-family:'Playfair Display',serif;font-size:22px;font-weight:900;color:var(--navy);line-height:1}
.bc-stat-lbl{font-size:10px;color:var(--grey);font-weight:500}
.bc-bar{height:3px;background:var(--light);border-radius:2px;overflow:hidden;margin-bottom:14px}
.bc-fill{height:100%;border-radius:2px}
.bc-foot{display:flex;align-items:center;justify-content:space-between;padding-top:10px;border-top:1px solid var(--light)}
.bc-new{font-size:11px;font-weight:600;color:var(--green)}
.bc-actions{display:flex;gap:4px}
/* simple modal reuse */
.modal-ov{position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:900;display:none;align-items:center;justify-content:center}
.modal-ov.open{display:flex}
.modal{background:#fff;width:480px;border-radius:4px;box-shadow:0 24px 60px rgba(0,31,69,.3);overflow:hidden}
.mh{background:var(--navy-dark);padding:18px 24px;display:flex;align-items:center;justify-content:space-between}
.mh h3{font-family:'Playfair Display',serif;font-size:17px;font-weight:900;color:#fff}
.mc-btn{background:none;border:none;color:rgba(255,255,255,.45);font-size:22px;cursor:pointer}
.mb{padding:22px 24px}
.fg{margin-bottom:14px}
.fl{display:block;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:5px}
.fi{width:100%;border:1px solid var(--light);background:var(--off);padding:9px 12px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);outline:none;border-radius:2px}
.fi:focus{border-color:var(--navy);background:#fff}
.f2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.mf{padding:12px 24px 20px;display:flex;gap:9px;justify-content:flex-end;border-top:1px solid var(--light)}
.btn-sub{background:var(--navy-dark);color:#fff;border:none;padding:9px 22px;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;cursor:pointer;border-radius:2px}
.btn-cxl{background:transparent;color:var(--grey);border:1px solid var(--light);padding:9px 18px;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:600;cursor:pointer;border-radius:2px}
</style>
@endsection

@section('content')

{{-- Summary row --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:22px">
    <div class="sc">
        <div class="sc-bar" style="background:var(--navy)"></div>
        <div class="sc-lbl">Total Branches</div>
        <div class="sc-val">{{ $branches->count() }}</div>
        <div class="sc-sub">Nationwide</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--gold)"></div>
        <div class="sc-lbl">Total Members</div>
        <div class="sc-val">{{ number_format($branches->sum('member_count')) }}</div>
        <div class="sc-sub">All branches combined</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--green)"></div>
        <div class="sc-lbl">New This Month</div>
        <div class="sc-val">{{ number_format($branches->sum('new_members_this_month')) }}</div>
        <div class="sc-sub">Across all branches</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--amber)"></div>
        <div class="sc-lbl">Active Branches</div>
        <div class="sc-val">{{ $branches->where('is_active', true)->count() }}</div>
        <div class="sc-sub">Out of {{ $branches->count() }} total</div>
    </div>
</div>

{{-- Branch cards --}}
<div class="panel" style="margin-bottom:0">
    <div class="ph">
        <div class="pt">All <em>Branches</em></div>
        <div style="font-size:11px;color:var(--grey)">{{ $branches->count() }} branches · {{ number_format($branches->sum('member_count')) }} total members</div>
    </div>
    <div class="pb">
        @php $maxMembers = $branches->max('member_count') ?: 1; @endphp
        <div class="branch-grid">
            @forelse($branches->where('name', '!=', 'National') as $branch)
            <div class="bc">
                <div class="bc-top" style="background:{{ $branch->color ?? 'var(--navy)' }}"></div>
                <div class="bc-body">
                    <div class="bc-name">{{ $branch->name }}</div>
                    <div class="bc-state">{{ $branch->state ?? 'Malaysia' }}</div>
                    <div class="bc-stat">
                        <div class="bc-stat-val">{{ number_format($branch->member_count) }}</div>
                        <div class="bc-stat-lbl">members</div>
                    </div>
                    <div class="bc-bar">
                        <div class="bc-fill" style="width:{{ round($branch->member_count / $maxMembers * 100) }}%;background:{{ $branch->color ?? 'var(--navy)' }}"></div>
                    </div>
                    <div class="bc-foot">
                        <span class="bc-new">▲ {{ $branch->new_members_this_month }} this month</span>
                        <div class="bc-actions">
                            <span class="badge {{ $branch->is_active ? 'b-open' : 'b-past' }}">
                                {{ $branch->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:48px;color:var(--grey);font-size:13px">No branches found.</div>
            @endforelse
        </div>
    </div>
</div>

{{-- Add Branch Modal --}}
<div class="modal-ov" id="addBranchModal" onclick="if(event.target===this)this.classList.remove('open')">
    <div class="modal" onclick="event.stopPropagation()">
        <div class="mh">
            <h3>Add State Branch</h3>
            <button class="mc-btn" onclick="document.getElementById('addBranchModal').classList.remove('open')">×</button>
        </div>
        <form method="POST" action="{{ route('admin.branches') }}">
            @csrf
            <div class="mb">
                <div class="f2">
                    <div class="fg"><label class="fl">Branch Name</label><input class="fi" name="name" type="text" placeholder="e.g. Johor" required/></div>
                    <div class="fg"><label class="fl">State</label><input class="fi" name="state" type="text" placeholder="e.g. Johor"/></div>
                </div>
                <div class="f2">
                    <div class="fg"><label class="fl">Member Count</label><input class="fi" name="member_count" type="number" value="0" min="0"/></div>
                    <div class="fg"><label class="fl">Color</label><input class="fi" name="color" type="color" value="#003366" style="height:38px;padding:4px 8px;cursor:pointer"/></div>
                </div>
            </div>
            <div class="mf">
                <button type="button" class="btn-cxl" onclick="document.getElementById('addBranchModal').classList.remove('open')">Cancel</button>
                <button type="submit" class="btn-sub">Add Branch</button>
            </div>
        </form>
    </div>
</div>

@endsection