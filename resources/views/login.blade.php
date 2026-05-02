<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Sign In – YES IEM Malaysia</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --navy:#003366;--navy-dark:#001f45;--navy-mid:#002855;
  --gold:#c8a84b;--gold-dim:rgba(200,168,75,.12);
  --off:#f5f4f0;--light:#e8e8e4;--grey:#6b7280;
  --red:#c0392b;--red-l:#fdecea;
  --green:#1a6b3c;
}
html{height:100%}
body{font-family:'DM Sans',sans-serif;background:var(--off);min-height:100vh;display:flex;flex-direction:column}

/* ── TOP BAR ── */
.topbar{background:var(--navy-dark);padding:0 32px;height:54px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.tb-brand{display:flex;align-items:center;gap:10px;text-decoration:none}
.tb-logo{width:32px;height:32px;background:var(--gold);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:11px;font-weight:900;color:var(--navy-dark);letter-spacing:.5px}
.tb-name{font-size:13px;font-weight:700;color:#fff;letter-spacing:.3px}
.tb-back{font-size:11px;color:rgba(255,255,255,.45);text-decoration:none;display:flex;align-items:center;gap:5px;transition:color .2s}
.tb-back:hover{color:rgba(255,255,255,.8)}
.tb-back svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2}

/* ── MAIN ── */
.page{flex:1;display:flex;align-items:center;justify-content:center;padding:40px 20px}
.card{width:100%;max-width:440px;background:#fff;border:1px solid var(--light);box-shadow:0 4px 32px rgba(0,31,69,.07)}

/* ── CARD HEADER ── */
.card-head{background:var(--navy-dark);padding:28px 32px}
.ch-eyebrow{font-size:9px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:rgba(200,168,75,.6);margin-bottom:8px}
.ch-title{font-family:'Playfair Display',serif;font-size:22px;font-weight:900;color:#fff;margin-bottom:4px}
.ch-title em{color:var(--gold);font-style:normal}
.ch-sub{font-size:11px;color:rgba(255,255,255,.45);line-height:1.5}

/* ── ROLE SELECTOR ── */
.role-tabs{display:flex;border-bottom:1px solid var(--light);background:var(--off)}
.rtab{flex:1;padding:12px 0;text-align:center;font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);cursor:pointer;border:none;background:none;border-bottom:3px solid transparent;margin-bottom:-1px;font-family:'DM Sans',sans-serif;transition:all .2s}
.rtab:hover{color:var(--navy)}
.rtab.active{color:var(--navy);border-bottom-color:var(--gold);background:#fff}

/* ── FORM ── */
.card-body{padding:28px 32px}
.field{margin-bottom:18px}
.field label{display:block;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:6px}
.field input{width:100%;border:1px solid var(--light);background:var(--off);padding:10px 13px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--navy-dark);outline:none;border-radius:3px;transition:border-color .2s}
.field input:focus{border-color:var(--navy);background:#fff}
.field input.error{border-color:var(--red)}
.field-error{font-size:11px;color:var(--red);margin-top:4px;display:none}
.field.has-error .field-error{display:block}
.field.has-error input{border-color:var(--red)}

.pw-wrap{position:relative}
.pw-wrap input{padding-right:40px}
.pw-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--grey);display:flex;align-items:center;justify-content:center;padding:2px}
.pw-toggle svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2}
.pw-toggle:hover{color:var(--navy)}

.forgot{font-size:11px;color:var(--grey);text-decoration:none;float:right;margin-top:-14px;margin-bottom:18px;display:block;text-align:right}
.forgot:hover{color:var(--navy)}

.role-hint{background:var(--gold-dim);border:1px solid rgba(200,168,75,.25);padding:10px 14px;border-radius:3px;font-size:11px;color:#7a5b14;line-height:1.5;margin-bottom:18px;display:flex;gap:8px;align-items:flex-start}
.role-hint svg{width:14px;height:14px;stroke:#7a5b14;fill:none;stroke-width:2;flex-shrink:0;margin-top:1px}

.btn-submit{width:100%;padding:12px;background:var(--navy-dark);color:var(--gold);border:none;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:12px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;border-radius:3px;transition:background .2s;display:flex;align-items:center;justify-content:center;gap:8px}
.btn-submit:hover{background:var(--navy-mid)}
.btn-submit svg{width:14px;height:14px;stroke:var(--gold);fill:none;stroke-width:2.5}
.btn-submit:disabled{opacity:.5;cursor:not-allowed}

/* ── ALERT ── */
.alert{padding:10px 14px;border-radius:3px;font-size:12px;margin-bottom:16px;display:flex;align-items:flex-start;gap:8px;display:none}
.alert.show{display:flex}
.alert svg{width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;flex-shrink:0;margin-top:1px}
.alert-danger{background:var(--red-l);color:var(--red);border:1px solid rgba(192,57,43,.2)}

/* ── FOOTER ── */
.card-foot{padding:16px 32px;border-top:1px solid var(--light);background:var(--off);display:flex;align-items:center;justify-content:space-between}
.cf-text{font-size:11px;color:var(--grey)}
.cf-text a{color:var(--navy);text-decoration:none;font-weight:600}
.cf-text a:hover{color:var(--gold)}

.page-foot{text-align:center;padding:16px;font-size:10px;color:var(--grey)}
.page-foot a{color:var(--grey);text-decoration:none}
.page-foot a:hover{color:var(--navy)}
</style>
</head>
<body>

<nav class="topbar">
    <a href="{{ route('home') }}" class="tb-brand">
        <div class="tb-logo">YES</div>
        <span class="tb-name">YES IEM Malaysia</span>
    </a>
    <a href="{{ route('home') }}" class="tb-back">
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Back to Public Site
    </a>
</nav>

<div class="page">
    <div class="card">
        <div class="card-head">
            <div class="ch-eyebrow">Portal Access</div>
            <div class="ch-title">Welcome to <em>YES IEM</em></div>
            <div class="ch-sub">Sign in to access your dashboard. Select your account type below.</div>
        </div>

        {{-- Role Tabs --}}
        <div class="role-tabs">
            <button class="rtab active" id="tab-admin" onclick="switchRole('admin')">YES Administrator</button>
            <button class="rtab" id="tab-chapter" onclick="switchRole('chapter')">Student Chapter</button>
        </div>

        <div class="card-body">

            {{-- Session/Validation Errors --}}
            @if(session('error'))
            <div class="alert alert-danger show">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
            @endif

            <div id="hint-admin" class="role-hint">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                YES national board and regional administrators. Contact the IT secretariat if you do not have an account.
            </div>
            <div id="hint-chapter" class="role-hint" style="display:none">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Student chapter accounts are created by YES administrators. Contact your national liaison if you need credentials.
            </div>

            <input type="hidden" id="role-input" value="admin"/>

                <div class="field">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" placeholder="yourname@iem.org.my" autocomplete="email"/>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="pw-wrap">
                        <input type="password" id="password" placeholder="••••••••" autocomplete="current-password"/>
                        <button type="button" class="pw-toggle" onclick="togglePw()" title="Show/hide password">
                            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <div style="height:14px"></div>

                <button type="button" class="btn-submit" id="btn-submit" onclick="goToDashboard()">
                    <svg viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    <span id="btn-label">Sign In to Admin Panel</span>
                </button>
        </div>

        <div class="card-foot">
            <span class="cf-text">Public site: <a href="{{ route('home') }}">yes.iem.org.my</a></span>
            <span class="cf-text"><a href="#">Privacy Policy</a> · <a href="#">Help</a></span>
        </div>
    </div>
</div>

<div class="page-foot">
    © {{ date('Y') }} Young Engineer Section, IEM Malaysia. All rights reserved.
</div>

<script>
function switchRole(role) {
    document.getElementById('role-input').value = role;
    document.getElementById('tab-admin').classList.toggle('active', role === 'admin');
    document.getElementById('tab-chapter').classList.toggle('active', role === 'chapter');
    document.getElementById('hint-admin').style.display  = role === 'admin'   ? 'flex' : 'none';
    document.getElementById('hint-chapter').style.display = role === 'chapter' ? 'flex' : 'none';
    document.getElementById('btn-label').textContent =
        role === 'admin' ? 'Sign In to Admin Panel' : 'Sign In to Chapter Dashboard';
}

const ADMIN_URL   = '{{ route('admin.dashboard') }}';
const STUDENT_URL = '{{ route('student.dashboard') }}';

function goToDashboard() {
    const role = document.getElementById('role-input').value;
    document.getElementById('btn-label').textContent = 'Redirecting…';
    document.getElementById('btn-submit').disabled = true;
    window.location.href = role === 'admin' ? ADMIN_URL : STUDENT_URL;
}

function togglePw() {
    const inp = document.getElementById('password');
    inp.type = inp.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>
