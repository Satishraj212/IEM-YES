<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Student Login – YES IEM</title>
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
body { font-family: 'DM Sans', sans-serif; background: var(--offwhite); color: #222; min-height: 100vh; display: flex; flex-direction: column; }

/* Nav */
nav { background: var(--white); border-bottom: 3px solid var(--gold); display: flex; align-items: center; justify-content: space-between; padding: 0 60px; height: 72px; box-shadow: 0 2px 20px rgba(0,0,0,0.08); }
.logo { display: flex; align-items: center; text-decoration: none; }
.nav-logo-img { height: 52px; width: auto; display: block; object-fit: contain; }
.nav-back { color: var(--navy); text-decoration: none; font-size: 13px; font-weight: 600; letter-spacing: 0.5px; display: flex; align-items: center; gap: 6px; transition: color .2s; }
.nav-back:hover { color: var(--gold); }

/* Page layout */
.page { flex: 1; display: flex; align-items: flex-start; justify-content: center; padding: 48px 24px; }
.card { background: var(--white); width: 100%; max-width: 600px; box-shadow: 0 4px 40px rgba(0,51,102,0.1); }

/* Card header */
.card-head { background: var(--navy); padding: 32px 36px; }
.card-head .eyebrow { font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 8px; }
.card-head h1 { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 900; color: var(--white); margin-bottom: 6px; }
.card-head p { font-size: 13px; color: rgba(255,255,255,0.65); line-height: 1.6; }

/* Search */
.search-wrap { padding: 20px 36px 0; }
.search-box { position: relative; }
.search-box input {
  width: 100%; padding: 11px 14px 11px 38px;
  border: 1.5px solid var(--light-grey); font-family: 'DM Sans', sans-serif;
  font-size: 13px; color: #222; background: var(--offwhite);
  outline: none; transition: border-color .2s;
}
.search-box input:focus { border-color: var(--navy); background: var(--white); }
.search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--grey); pointer-events: none; }

/* Branch list */
.branch-list { padding: 16px 36px; max-height: 380px; overflow-y: auto; }
.branch-list::-webkit-scrollbar { width: 4px; }
.branch-list::-webkit-scrollbar-track { background: var(--offwhite); }
.branch-list::-webkit-scrollbar-thumb { background: var(--light-grey); }

.branch-option { display: none; } /* hide actual radio */
.branch-label {
  display: flex; align-items: center; gap: 14px;
  padding: 13px 16px; cursor: pointer; border: 1.5px solid transparent;
  transition: all .15s; margin-bottom: 6px; background: var(--offwhite);
}
.branch-label:hover { border-color: var(--light-grey); background: var(--white); }
.branch-option:checked + .branch-label {
  border-color: var(--navy); background: var(--white);
}
.branch-option:checked + .branch-label .avatar { background: var(--navy); color: var(--gold); }
.branch-option:checked + .branch-label .check-dot { background: var(--navy); border-color: var(--navy); }
.branch-option:checked + .branch-label .check-dot::after { display: block; }

.avatar {
  width: 40px; height: 40px; background: var(--light-grey); color: var(--navy);
  display: flex; align-items: center; justify-content: center;
  font-size: 11px; font-weight: 700; letter-spacing: 0.5px;
  flex-shrink: 0; transition: all .15s;
}
.branch-info { flex: 1; min-width: 0; }
.branch-name { font-size: 14px; font-weight: 600; color: var(--navy); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.branch-meta { font-size: 11px; color: var(--grey); margin-top: 2px; }
.check-dot {
  width: 18px; height: 18px; border: 2px solid var(--light-grey);
  border-radius: 50%; flex-shrink: 0; position: relative; transition: all .15s;
}
.check-dot::after {
  content: ''; display: none; position: absolute;
  top: 50%; left: 50%; transform: translate(-50%, -50%);
  width: 8px; height: 8px; border-radius: 50%; background: var(--white);
}

.no-results { padding: 24px; text-align: center; font-size: 13px; color: var(--grey); display: none; }

/* Footer */
.card-foot { padding: 20px 36px 28px; border-top: 1px solid var(--light-grey); display: flex; align-items: center; justify-content: space-between; gap: 16px; }
.branch-count { font-size: 12px; color: var(--grey); }
.branch-count strong { color: var(--navy); }

.btn-submit {
  background: var(--gold); color: var(--navy-dark);
  padding: 13px 32px; border: none; cursor: pointer;
  font-family: 'DM Sans', sans-serif; font-size: 13px;
  font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
  display: flex; align-items: center; gap: 8px; transition: all .2s;
}
.btn-submit:hover { background: var(--navy); color: var(--gold); }
.btn-submit:disabled { opacity: 0.45; cursor: not-allowed; }

/* Error */
.error-msg { margin: 0 36px 12px; padding: 10px 14px; background: #fee2e2; border-left: 3px solid #ef4444; font-size: 12px; color: #991b1b; font-weight: 600; }

@media (max-width: 640px) {
  nav { padding: 0 20px; }
  .card-head, .search-wrap, .branch-list, .card-foot, .error-msg { padding-left: 20px; padding-right: 20px; }
}
</style>
</head>
<body>

<nav>
  <a class="logo" href="{{ route('home') }}">
    <img src="{{ asset('images/iem-yes-logo.png') }}" alt="IEM Young Engineers Section" class="nav-logo-img"/>
  </a>
  <a class="nav-back" href="{{ route('home') }}">← Back to main site</a>
</nav>

<div class="page">
  <div class="card">

    <div class="card-head">
      <div class="eyebrow">Student Section Portal</div>
      <h1>Pick Your Student Chapter</h1>
      <p>Choose the student chapter you represent to access your dashboard.</p>
    </div>

    @if ($errors->any())
    <div class="error-msg">{{ $errors->first() }}</div>
    @endif

    <div class="search-wrap">
      <div class="search-box">
        <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" id="branchSearch" placeholder="Search by university or branch name…" autocomplete="off" oninput="filterBranches(this.value)"/>
      </div>
    </div>

    <form method="POST" action="{{ route('login.student.post') }}" id="branchForm">
      @csrf

      <div class="branch-list" id="branchList">
        @forelse ($branches as $branch)
        @php
          // Generate 2–4 letter abbreviation from branch name
          $words = preg_split('/[\s\-]+/', $branch->name);
          $abbr  = strtoupper(implode('', array_map(fn($w) => substr($w, 0, 1), array_slice($words, 0, 4))));
        @endphp
        <div class="branch-row" data-name="{{ strtolower($branch->name) }}">
          <input class="branch-option" type="radio" name="branch_id" id="branch_{{ $branch->id }}" value="{{ $branch->id }}"
            onchange="updateSubmit()" {{ old('branch_id') == $branch->id ? 'checked' : '' }}/>
          <label class="branch-label" for="branch_{{ $branch->id }}">
            <div class="avatar">{{ $abbr }}</div>
            <div class="branch-info">
              <div class="branch-name">{{ $branch->name }}</div>
              <div class="branch-meta">Academic Year {{ $branch->academic_year ?? now()->year }}</div>
            </div>
            <div class="check-dot"></div>
          </label>
        </div>
        @empty
        <div style="padding:32px;text-align:center;font-size:13px;color:var(--grey)">
          No branches found. Please contact the administrator.
        </div>
        @endforelse

        <div class="no-results" id="noResults">No branches match your search.</div>
      </div>

      <div class="card-foot">
        <div class="branch-count">
          <strong id="visibleCount">{{ $branches->count() }}</strong> branch{{ $branches->count() !== 1 ? 'es' : '' }} available
        </div>
        <button type="submit" class="btn-submit" id="submitBtn" disabled>
          Enter Dashboard
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
          </svg>
        </button>
      </div>
    </form>

  </div>
</div>

<script>
function updateSubmit() {
  document.getElementById('submitBtn').disabled = !document.querySelector('input[name="branch_id"]:checked');
}

function filterBranches(q) {
  const rows = document.querySelectorAll('.branch-row');
  const term = q.toLowerCase().trim();
  let visible = 0;
  rows.forEach(row => {
    const match = !term || row.dataset.name.includes(term);
    row.style.display = match ? '' : 'none';
    if (match) visible++;
  });
  document.getElementById('visibleCount').textContent = visible;
  document.getElementById('noResults').style.display = visible === 0 ? 'block' : 'none';
}

// Re-enable button if old() reselected a value after validation error
updateSubmit();
</script>

</body>
</html>