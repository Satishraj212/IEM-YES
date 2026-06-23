<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>404 — Page Not Found | YES IEM Malaysia</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet"/>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--navy:#003366;--navy-dark:#001f45;--gold:#c8a84b;--off:#f5f4f0;--grey:#6b7280;--light:#e8e8e4}
html{height:100%}
body{font-family:'DM Sans',sans-serif;background:var(--navy-dark);color:#fff;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:40px 20px;text-align:center;position:relative;overflow:hidden}
body::before{content:'';position:absolute;top:-200px;left:-200px;width:700px;height:700px;border-radius:50%;background:radial-gradient(circle,rgba(200,168,75,0.05) 0%,transparent 70%);pointer-events:none}
body::after{content:'';position:absolute;bottom:-200px;right:-200px;width:700px;height:700px;border-radius:50%;background:radial-gradient(circle,rgba(0,51,102,0.4) 0%,transparent 70%);pointer-events:none}
.err-code{font-family:'Playfair Display',serif;font-size:clamp(80px,15vw,160px);font-weight:900;color:rgba(200,168,75,0.12);line-height:1;letter-spacing:-4px;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);user-select:none;pointer-events:none}
.card{position:relative;z-index:2;max-width:480px;width:100%}
.icon-wrap{width:72px;height:72px;border-radius:50%;background:rgba(200,168,75,0.1);border:1px solid rgba(200,168,75,0.25);display:flex;align-items:center;justify-content:center;margin:0 auto 24px}
.icon-wrap svg{width:32px;height:32px;stroke:var(--gold);fill:none;stroke-width:1.5}
h1{font-family:'Playfair Display',serif;font-size:clamp(24px,4vw,36px);font-weight:900;color:#fff;margin-bottom:12px}
h1 em{color:var(--gold);font-style:italic}
p{font-size:15px;color:rgba(255,255,255,0.55);line-height:1.75;max-width:380px;margin:0 auto 32px}
.actions{display:flex;gap:12px;justify-content:center;flex-wrap:wrap}
.btn-primary{display:inline-flex;align-items:center;gap:8px;padding:12px 28px;background:var(--gold);color:var(--navy-dark);font-weight:700;font-size:13px;letter-spacing:0.5px;text-decoration:none;transition:opacity .2s}
.btn-primary:hover{opacity:0.88}
.btn-ghost{display:inline-flex;align-items:center;gap:8px;padding:12px 28px;border:1px solid rgba(255,255,255,0.2);color:rgba(255,255,255,0.7);font-size:13px;font-weight:600;text-decoration:none;transition:all .2s}
.btn-ghost:hover{border-color:rgba(255,255,255,0.5);color:#fff}
.divider{width:48px;height:2px;background:var(--gold);margin:28px auto}
.hint{font-size:11px;color:rgba(255,255,255,0.25);letter-spacing:1px;text-transform:uppercase}
</style>
</head>
<body>
<div class="err-code">404</div>

<div class="card">
    <div class="icon-wrap">
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/><line x1="11" y1="8" x2="11" y2="11"/><line x1="11" y1="14" x2="11.01" y2="14"/></svg>
    </div>
    <h1>Page <em>Not Found</em></h1>
    <p>The page you're looking for doesn't exist or has been moved. Check the URL or navigate back to safety.</p>
    <div class="divider"></div>
    <div class="actions">
        <a href="{{ url('/') }}" class="btn-primary">← Back to Home</a>
        <a href="{{ route('official-board-events') }}" class="btn-ghost">View Events</a>
    </div>
    <div style="margin-top:32px" class="hint">Error 404 · YES IEM Malaysia</div>
</div>
</body>
</html>
