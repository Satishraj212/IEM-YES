<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Admin') – YES IEM Malaysia</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<style>
:root {
  --navy:#003366; --navy-dark:#001f45; --navy-mid:#002855;
  --gold:#c8a84b; --gold-light:#e8c96a; --gold-dim:rgba(200,168,75,0.12);
  --white:#fff; --off:#f5f4f0; --grey:#6b7280; --light:#e8e8e4;
  --green:#1a6b3c; --green-a:#4caf7d; --green-bg:#dcfce7; --green-border:#bbf7d0;
  --red:#c0392b; --red-l:#fdecea;
  --amber:#d97706; --amber-l:#fef3c7; --amber-border:rgba(217,119,6,.25);
  --blue:#1d4ed8; --blue-l:#eff6ff;
  --purple:#5b21b6; --purple-l:#ede9fe;
  --sidebar:240px; --topbar:60px;
}
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;color:#222;background:var(--off);display:flex;min-height:100vh;overflow-x:hidden}

/* ── SIDEBAR ── */
.sb{width:var(--sidebar);min-height:100vh;background:var(--navy-dark);display:flex;flex-direction:column;position:fixed;top:0;left:0;z-index:200;border-right:1px solid rgba(255,255,255,.06)}
.sb-brand{padding:18px 20px 16px;border-bottom:1px solid rgba(255,255,255,.08);display:flex;align-items:center;gap:10px}
.sb-logo{width:36px;height:36px;background:var(--gold);border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:var(--navy-dark);letter-spacing:.5px;flex-shrink:0}
.sb-title{font-size:14px;font-weight:600;color:#fff;line-height:1.2}
.sb-sub{font-size:9px;color:rgba(255,255,255,.35);letter-spacing:1.5px;text-transform:uppercase;margin-top:2px}
.sb-sec{padding:16px 0 4px}
.sb-lbl{font-size:9px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:rgba(255,255,255,.25);padding:0 20px;margin-bottom:4px}
.ni{display:flex;align-items:center;gap:10px;padding:9px 20px;color:rgba(255,255,255,.52);text-decoration:none;font-size:12px;font-weight:500;transition:all .15s;position:relative;cursor:pointer}
.ni:hover{color:#fff;background:rgba(255,255,255,.05)}
.ni.active{color:var(--gold);background:rgba(200,168,75,.1)}
.ni.active::before{content:'';position:absolute;left:0;top:0;bottom:0;width:2px;background:var(--gold)}
.ni-icon{width:15px;height:15px;flex-shrink:0;stroke:currentColor;fill:none;stroke-width:1.8}
.nb{margin-left:auto;background:rgba(200,168,75,.18);color:var(--gold);font-size:9px;font-weight:700;padding:2px 7px;border-radius:10px;line-height:1.5}
.nb.red{background:rgba(229,62,62,.22);color:#f87171}
.nb.blue{background:rgba(29,78,216,.18);color:#60a5fa}
.nb.amber{background:rgba(217,119,6,.18);color:#f59e0b}
.sb-foot{margin-top:auto;padding:14px 20px 18px;border-top:1px solid rgba(255,255,255,.08);display:flex;align-items:center;gap:10px}
.av{width:30px;height:30px;background:var(--gold);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:var(--navy-dark);flex-shrink:0}
.av-name{font-size:12px;font-weight:600;color:#fff}
.av-role{font-size:9px;color:rgba(255,255,255,.38);letter-spacing:.5px;text-transform:uppercase}

/* ── MAIN ── */
.main{margin-left:var(--sidebar);flex:1;display:flex;flex-direction:column;min-height:100vh}
.topbar{height:var(--topbar);background:#fff;border-bottom:1px solid var(--light);display:flex;align-items:center;justify-content:space-between;padding:0 28px;position:sticky;top:0;z-index:100;box-shadow:0 1px 8px rgba(0,0,0,.04)}
.tb-left{display:flex;flex-direction:column;justify-content:center}
.tb-title{font-family:'Playfair Display',serif;font-size:18px;font-weight:900;color:var(--navy)}
.tb-title em{color:var(--gold);font-style:normal}
.tb-sub{font-size:11px;color:var(--grey);margin-top:1px}
.tb-right{display:flex;align-items:center;gap:9px}
.btn-primary{display:flex;align-items:center;gap:6px;padding:8px 16px;background:var(--navy-dark);color:#fff;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:600;letter-spacing:.4px;border-radius:3px;transition:background .2s;text-decoration:none}
.btn-primary:hover{background:var(--navy-mid)}
.btn-primary svg{width:12px;height:12px;stroke:#fff;fill:none;stroke-width:2.5}
.icon-btn{width:34px;height:34px;border:1px solid var(--light);background:#fff;border-radius:3px;display:flex;align-items:center;justify-content:center;cursor:pointer;position:relative;transition:border-color .2s}
.icon-btn:hover{border-color:var(--navy)}
.icon-btn svg{width:15px;height:15px;stroke:var(--grey);fill:none;stroke-width:1.8}
.notif-dot{width:6px;height:6px;border-radius:50%;background:var(--red);border:1.5px solid #fff;position:absolute;top:6px;right:6px}

/* ── NOTIFICATION DROPDOWN ── */
.notif-wrap{position:relative}
.notif-badge{min-width:17px;height:17px;border-radius:9px;background:var(--red);color:#fff;font-size:8px;font-weight:700;display:flex;align-items:center;justify-content:center;padding:0 4px;position:absolute;top:-5px;right:-5px;border:2px solid #fff;line-height:1}
.notif-dropdown{position:absolute;top:calc(100% + 10px);right:0;width:320px;background:#fff;border:1px solid var(--light);border-radius:6px;box-shadow:0 8px 40px rgba(0,31,69,.14);z-index:300;display:none;overflow:hidden}
.notif-dropdown.open{display:block}
.nd-head{padding:12px 16px;border-bottom:1px solid var(--light);display:flex;align-items:center;justify-content:space-between}
.nd-title{font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--navy)}
.nd-clear{font-size:10px;color:var(--grey);background:none;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;font-weight:600}
.nd-clear:hover{color:var(--navy)}
.nd-group-lbl{font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(0,31,69,.35);padding:9px 16px 3px}
.nd-item{display:flex;align-items:flex-start;gap:10px;padding:10px 16px;cursor:pointer;transition:background .12s;text-decoration:none}
.nd-item:hover{background:var(--off)}
.nd-icon{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px}
.nd-icon svg{width:12px;height:12px;fill:none;stroke:#fff;stroke-width:2.5}
.nd-body{flex:1;min-width:0}
.nd-text{font-size:12px;font-weight:600;color:var(--navy);line-height:1.4}
.nd-sub{font-size:10px;color:var(--grey);margin-top:1px}
.nd-count{min-width:19px;height:19px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;padding:0 5px;flex-shrink:0;align-self:center}
.nd-divider{border:none;border-top:1px solid var(--light)}
.nd-foot{padding:10px 16px;text-align:center}
.nd-foot a{font-size:11px;color:var(--navy);text-decoration:none;font-weight:600;letter-spacing:.3px}
.nd-foot a:hover{color:var(--gold)}
.nd-empty{padding:20px 16px;text-align:center;font-size:12px;color:var(--grey)}

/* ── COMMAND PALETTE ── */
.cmd-ov{position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:800;display:none;align-items:flex-start;justify-content:center;padding-top:13vh}
.cmd-ov.open{display:flex}
.cmd-box{width:560px;max-width:calc(100vw - 40px);background:#fff;border-radius:8px;box-shadow:0 24px 80px rgba(0,31,69,.28);overflow:hidden}
.cmd-input-row{display:flex;align-items:center;gap:10px;padding:14px 18px;border-bottom:1px solid var(--light)}
.cmd-input-row svg{width:16px;height:16px;stroke:var(--grey);fill:none;stroke-width:2;flex-shrink:0}
.cmd-input{flex:1;border:none;outline:none;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--navy);background:transparent}
.cmd-input::placeholder{color:var(--grey)}
.cmd-esc-key{font-size:10px;font-weight:600;color:var(--grey);background:var(--off);border:1px solid var(--light);padding:3px 7px;border-radius:4px;white-space:nowrap}
.cmd-results{max-height:360px;overflow-y:auto}
.cmd-sec-lbl{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);padding:10px 18px 4px;background:var(--off);border-bottom:1px solid var(--light)}
.cmd-item{display:flex;align-items:center;gap:12px;padding:11px 18px;cursor:pointer;transition:background .1s;text-decoration:none}
.cmd-item:hover,.cmd-item.selected{background:#f0f4ff}
.cmd-item-icon{width:30px;height:30px;border-radius:6px;background:var(--off);border:1px solid var(--light);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.cmd-item-icon svg{width:13px;height:13px;stroke:var(--navy);fill:none;stroke-width:2}
.cmd-item-body{flex:1;min-width:0}
.cmd-item-text{font-size:13px;color:var(--navy);font-weight:500}
.cmd-item-sub{font-size:10px;color:var(--grey);margin-top:1px}
.cmd-item-badge{font-size:9px;font-weight:700;background:var(--amber-l);color:var(--amber);padding:2px 7px;border-radius:10px;border:1px solid var(--amber-border);white-space:nowrap}
.cmd-footer{padding:9px 18px;border-top:1px solid var(--light);display:flex;gap:14px;background:var(--off)}
.cmd-hint{display:flex;align-items:center;gap:5px;font-size:10px;color:var(--grey)}
.cmd-key{font-size:9px;background:#fff;border:1px solid var(--light);padding:2px 6px;border-radius:3px;color:var(--navy);font-weight:700}

/* ── GLOBAL CONFIRM MODAL ── */
.confirm-ov{position:fixed;inset:0;background:rgba(0,0,0,.48);z-index:700;display:none;align-items:center;justify-content:center;padding:20px}
.confirm-ov.open{display:flex}
.confirm-box{background:#fff;width:420px;max-width:100%;border-radius:6px;box-shadow:0 16px 60px rgba(0,31,69,.25);overflow:hidden}
.confirm-head{padding:16px 20px;display:flex;align-items:center;gap:10px}
.confirm-head-icon{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.confirm-head-icon svg{width:14px;height:14px;fill:none;stroke:#fff;stroke-width:2.5}
.confirm-head h4{font-family:'Playfair Display',serif;font-size:15px;font-weight:900;color:#fff}
.confirm-body{padding:20px}
.confirm-body p{font-size:13px;color:#444;line-height:1.65;margin-bottom:14px}
.confirm-chip{background:var(--off);border:1px solid var(--light);border-radius:3px;padding:9px 13px;font-size:12px;color:var(--navy);font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px}
.confirm-chip svg{width:13px;height:13px;stroke:var(--grey);fill:none;stroke-width:2;flex-shrink:0}
.confirm-notes-lbl{font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);display:block;margin-bottom:5px}
.confirm-notes{width:100%;border:1px solid var(--light);background:var(--off);padding:9px 12px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);outline:none;border-radius:3px;min-height:80px;resize:vertical;transition:border-color .2s}
.confirm-notes:focus{border-color:var(--navy);background:#fff}
.confirm-notes.err{border-color:var(--red)}
.confirm-foot{padding:12px 20px;display:flex;gap:8px;justify-content:flex-end;border-top:1px solid var(--light);background:#fafaf8}

/* ── CONTENT ── */
.content{padding:22px 28px 60px}

/* ── SHARED COMPONENTS ── */
.panel{background:#fff;border:1px solid var(--light);border-radius:4px}
.ph{padding:15px 20px 13px;border-bottom:1px solid var(--light);display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
.pt{font-family:'Playfair Display',serif;font-size:15px;font-weight:700;color:var(--navy)}
.pt em{color:var(--gold);font-style:italic}
.pb{padding:16px 20px}
.pa{font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--navy);text-decoration:none;border-bottom:2px solid var(--gold);padding-bottom:1px;background:none;border-top:none;border-left:none;border-right:none;cursor:pointer;font-family:'DM Sans',sans-serif;transition:color .2s}
.pa:hover{color:var(--gold)}

/* ── STAT CARDS ── */
.sc{background:#fff;border:1px solid var(--light);padding:18px 20px;position:relative;overflow:hidden;border-radius:4px;transition:box-shadow .2s;cursor:pointer}
.sc:hover{box-shadow:0 4px 18px rgba(0,31,69,.07)}
.sc-bar{position:absolute;top:0;left:0;right:0;height:3px}
.sc-lbl{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);margin-bottom:6px}
.sc-val{font-family:'Playfair Display',serif;font-size:28px;font-weight:900;color:var(--navy);line-height:1}
.sc-ch{font-size:11px;color:var(--green);font-weight:600;margin-top:5px}
.sc-ch.dn{color:var(--red)}
.sc-sub{font-size:11px;color:var(--grey);margin-top:4px}

/* ── BADGES ── */
.badge{display:inline-block;font-size:9px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;padding:3px 8px;border-radius:2px}
.b-open{background:#dcfce7;color:#166534}
.b-upcoming{background:var(--blue-l);color:var(--blue)}
.b-past,.b-closed{background:var(--light);color:var(--grey)}
.b-official{background:var(--navy-dark);color:var(--gold)}
.b-student{background:var(--gold-dim);color:#7a5b14}
.b-board{background:#e0f2fe;color:#0369a1}
.b-retreat{background:#ede9fe;color:#5b21b6}
.b-summit{background:#dbeafe;color:#1e40af}
.b-forum{background:#d1fae5;color:#065f46}
.b-gala{background:#fef3c7;color:#92400e}
.b-review{background:#fce7f3;color:#9d174d}
.b-hackathon{background:#ede9fe;color:#5b21b6}
.b-career{background:#dbeafe;color:#1e40af}
.b-webinar{background:#d1fae5;color:#065f46}
.b-workshop{background:#fef3c7;color:#92400e}
.b-competition{background:#fce7f3;color:#9d174d}
.b-pending{background:var(--amber-l);color:var(--amber);border:1px solid var(--amber-border)}
.b-ppw{background:#ede9fe;color:#5b21b6;border:1px solid rgba(91,33,182,.2)}
.b-budget{background:#dbeafe;color:#1e40af;border:1px solid rgba(29,78,216,.2)}
.b-approved{background:var(--green-bg);color:#166534;border:1px solid var(--green-border)}
.b-rejected{background:var(--red-l);color:var(--red);border:1px solid rgba(192,57,43,.15)}

/* ── TABLES ── */
.etbl{width:100%;border-collapse:collapse}
.etbl th{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);text-align:left;padding:0 0 9px;border-bottom:2px solid var(--light)}
.etbl td{padding:10px 0;border-bottom:1px solid var(--light);vertical-align:middle}
.etbl tr:last-child td{border-bottom:none}
.etbl tr:hover td{background:#fafaf8}
.et-name{font-size:12px;font-weight:600;color:var(--navy)}
.et-sub{font-size:11px;color:var(--grey);margin-top:2px}
.et-sm{font-size:11px;color:var(--grey);white-space:nowrap}

/* ── TABS ── */
.tabs{display:flex;border-bottom:2px solid var(--light);margin-bottom:16px;overflow-x:auto}
.tab{padding:8px 16px;font-size:10px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--grey);cursor:pointer;background:none;border:none;border-bottom:2px solid transparent;margin-bottom:-2px;font-family:'DM Sans',sans-serif;transition:color .15s;white-space:nowrap}
.tab:hover{color:var(--navy)}
.tab.active{color:var(--navy);border-bottom-color:var(--gold)}

/* ── SEARCH ROW ── */
.sr{display:flex;gap:9px;margin-bottom:14px;align-items:center;flex-wrap:wrap}
.si-wrap{display:flex;align-items:center;gap:7px;background:var(--off);border:1px solid var(--light);padding:7px 12px;flex:1;min-width:180px;border-radius:2px}
.si-wrap svg{width:13px;height:13px;stroke:var(--grey);fill:none;stroke-width:2;flex-shrink:0}
.si-wrap input{border:none;outline:none;background:transparent;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);width:100%}
.fsel{border:1px solid var(--light);background:#fff;padding:7px 10px;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:600;color:var(--navy);cursor:pointer;outline:none;border-radius:2px}

/* ── SEAT BAR ── */
.sbar{margin-top:3px;height:3px;background:var(--light);border-radius:2px;width:72px}
.sfill{height:100%;border-radius:2px;background:var(--gold)}
.sfill.warn{background:var(--amber)}
.sfill.full{background:var(--red)}

/* ── ACTION BUTTONS ── */
.abtns{display:flex;align-items:center;gap:4px}
.abtn{width:26px;height:26px;border:1px solid var(--light);background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .15s;border-radius:3px}
.abtn svg{width:11px;height:11px;stroke:var(--grey);fill:none;stroke-width:2}
.abtn:hover{border-color:var(--navy);background:#f0f4ff}
.abtn:hover svg{stroke:var(--navy)}
.abtn.del:hover{border-color:var(--red);background:var(--red-l)}
.abtn.del:hover svg{stroke:var(--red)}

/* ── ACTIVITY ── */
.act-item{display:flex;gap:11px;padding:10px 0;border-bottom:1px solid var(--light)}
.act-item:last-child{border-bottom:none}
.act-dot{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px}
.act-dot svg{width:12px;height:12px;stroke:#fff;fill:none;stroke-width:2.5}
.act-txt{font-size:12px;color:#444;line-height:1.55}
.act-txt strong{color:var(--navy);font-weight:600}
.act-time{font-size:10px;color:var(--grey);margin-top:2px;display:block}

/* ── BRANCH BAR ── */
.br-item{display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid var(--light)}
.br-item:last-child{border-bottom:none}
.br-dot{width:9px;height:9px;border-radius:50%;flex-shrink:0}
.br-name{font-size:12px;font-weight:600;color:var(--navy);min-width:140px}
.br-bar{flex:1;height:4px;background:var(--light);border-radius:2px;overflow:hidden}
.br-fill{height:100%;border-radius:2px}
.br-cnt{font-size:11px;color:var(--grey);white-space:nowrap;min-width:80px;text-align:right}

/* ── BUTTONS ── */
.btn-prim{background:var(--navy-dark);color:#fff;border:none;padding:9px 20px;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;cursor:pointer;border-radius:3px;transition:background .2s}
.btn-prim:hover{background:var(--navy-mid)}
.btn-danger{background:var(--red);color:#fff;border:none;padding:9px 20px;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;cursor:pointer;border-radius:3px;transition:opacity .2s}
.btn-danger:hover{opacity:.88}
.btn-ghost{background:transparent;color:var(--grey);border:1px solid var(--light);padding:9px 16px;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:600;cursor:pointer;border-radius:3px;transition:border-color .2s}
.btn-ghost:hover{border-color:var(--grey)}
.btn-approve{display:flex;align-items:center;gap:5px;padding:9px 16px;background:var(--green-bg);color:#166534;border:1px solid var(--green-border);cursor:pointer;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;border-radius:3px;transition:all .2s}
.btn-approve:hover{background:#16a34a;color:#fff;border-color:#16a34a}
.btn-approve svg{width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5}
.btn-reject{display:flex;align-items:center;gap:5px;padding:9px 16px;background:var(--red-l);color:var(--red);border:1px solid rgba(192,57,43,.2);cursor:pointer;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;border-radius:3px;transition:all .2s}
.btn-reject:hover{background:var(--red);color:#fff;border-color:var(--red)}
.btn-reject svg{width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5}

/* ── TOGGLE ── */
.toggle{width:32px;height:18px;background:var(--light);border-radius:9px;position:relative;cursor:pointer;transition:background .2s;flex-shrink:0;border:none}
.toggle.on{background:var(--green)}
.toggle-knob{width:12px;height:12px;border-radius:50%;background:#fff;position:absolute;top:3px;left:3px;transition:left .2s;box-shadow:0 1px 3px rgba(0,0,0,.2)}
.toggle.on .toggle-knob{left:17px}

/* ── SLIDE-OUT PANEL ── */
.dim-overlay{position:fixed;inset:0;background:rgba(0,0,0,.35);z-index:400;display:none;opacity:0;transition:opacity .25s}
.dim-overlay.on{display:block;opacity:1}
.slide-panel{position:fixed;top:0;right:-540px;width:520px;height:100vh;background:#fff;border-left:1px solid var(--light);z-index:500;transition:right .3s cubic-bezier(.4,0,.2,1);display:flex;flex-direction:column;overflow:hidden;box-shadow:-8px 0 40px rgba(0,31,69,.12)}
.slide-panel.open{right:0}
.sp-head{padding:18px 22px;border-bottom:1px solid var(--light);display:flex;align-items:flex-start;justify-content:space-between;background:var(--navy-dark);flex-shrink:0}
.sp-mode-badge{font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:4px}
.sp-head h3{font-family:'Playfair Display',serif;font-size:16px;font-weight:900;color:#fff;line-height:1.3;max-width:400px}
.sp-close{background:none;border:none;color:rgba(255,255,255,.4);font-size:22px;cursor:pointer;line-height:1;padding:2px;flex-shrink:0;margin-top:2px;transition:color .15s}
.sp-close:hover{color:#fff}
.sp-body{flex:1;overflow-y:auto;padding:22px}
.sp-foot{padding:14px 22px;border-top:1px solid var(--light);display:flex;gap:9px;justify-content:flex-end;flex-shrink:0;background:#fafaf8}

/* ── FORM PANEL FIELDS ── */
.pf-row{margin-bottom:16px}
.pf-lbl{display:block;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:5px}
.pf-val{font-size:13px;color:#333;font-weight:500;line-height:1.5}
.pf-val.muted{color:var(--grey);font-weight:400;font-size:12px;line-height:1.65}
.pf-input{width:100%;border:1px solid var(--light);background:var(--off);padding:9px 12px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);outline:none;border-radius:3px;transition:border-color .2s}
.pf-input:focus{border-color:var(--navy);background:#fff}
.pf-select{width:100%;border:1px solid var(--light);background:var(--off);padding:9px 12px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);outline:none;border-radius:3px}
.pf-textarea{width:100%;border:1px solid var(--light);background:var(--off);padding:9px 12px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);outline:none;border-radius:3px;min-height:90px;resize:vertical}
.pf-textarea:focus{border-color:var(--navy);background:#fff}
.pf-grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.pf-divider{border:none;border-top:1px solid var(--light);margin:16px 0}

/* ── SKELETON LOADER ── */
@keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
.skeleton{background:linear-gradient(90deg,var(--light) 25%,#f0efea 50%,var(--light) 75%);background-size:200% 100%;animation:shimmer 1.5s infinite;border-radius:3px;display:inline-block}

/* ── TOAST ── */
.toast{position:fixed;bottom:24px;left:50%;transform:translateX(-50%) translateY(12px);background:var(--navy-dark);color:#fff;padding:10px 20px;border-radius:4px;font-size:12px;font-weight:500;z-index:1000;opacity:0;transition:all .3s;pointer-events:none;white-space:nowrap;display:flex;align-items:center;gap:8px}
.toast.show{transform:translateX(-50%) translateY(0);opacity:1}
.toast.success{background:var(--green)}
.toast.danger{background:var(--red)}
.toast.warn{background:var(--amber)}
.toast svg{width:13px;height:13px;stroke:#fff;fill:none;stroke-width:2.5;flex-shrink:0}

/* ── PRINT ── */
@media print{
  .sb,.topbar,.toast,.cmd-ov,.confirm-ov,.notif-dropdown{display:none!important}
  .main{margin-left:0}
  .content{padding:0}
  body{background:#fff}
}

</style>
@yield('styles')
</head>
<body>

@include('admin.partials.sidebar')

<div class="main">

    {{-- TOP BAR ── ─────────────────────────────────── --}}
    @php
        $nbStudentPending = \App\Models\StudentEventSubmission::where('stage','pending')->count();
        $nbReportsPending = \App\Models\AnnualReport::pending()->count();
        $nbTotal = $nbStudentPending + $nbReportsPending;
    @endphp
    <div class="topbar">
        <div class="tb-left">
            <div class="tb-title">@yield('page-title', 'Dashboard') <em>@yield('page-subtitle', 'Overview')</em></div>
            <div class="tb-sub">@yield('page-desc', 'YES IEM National Admin · ' . now()->format('j F Y'))</div>
        </div>
        <div class="tb-right">
            @yield('topbar-actions')

            {{-- Global Search / Command Palette ── --}}
            <button class="icon-btn" onclick="openCmd()" title="Quick search  Ctrl+K">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </button>

            {{-- Notification Bell ── --}}
            <div class="notif-wrap" id="notifWrap">
                <button class="icon-btn" onclick="toggleNotif(event)" title="Notifications" id="notifBtn">
                    <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    @if($nbTotal > 0)
                        <span class="notif-badge">{{ $nbTotal > 9 ? '9+' : $nbTotal }}</span>
                    @else
                        <span class="notif-dot"></span>
                    @endif
                </button>

                <div class="notif-dropdown" id="notifDropdown">
                    <div class="nd-head">
                        <span class="nd-title">Notifications</span>
                        <button class="nd-clear" onclick="markAllRead()">Mark all read</button>
                    </div>

                    @if($nbTotal > 0)
                    <div class="nd-group-lbl">Requires Action</div>
                    @if($nbStudentPending > 0)
                    <a href="{{ route('admin.student-section-events-admin') }}" class="nd-item" onclick="closeNotif()">
                        <div class="nd-icon" style="background:var(--amber)">
                            <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                        </div>
                        <div class="nd-body">
                            <div class="nd-text">{{ $nbStudentPending }} student event{{ $nbStudentPending !== 1 ? 's' : '' }} pending review</div>
                            <div class="nd-sub">Awaiting admin approval</div>
                        </div>
                        <span class="nd-count" style="background:var(--amber-l);color:var(--amber)">{{ $nbStudentPending }}</span>
                    </a>
                    @endif
                    @if($nbReportsPending > 0)
                    <a href="{{ route('admin.annual-reports') }}" class="nd-item" onclick="closeNotif()">
                        <div class="nd-icon" style="background:var(--blue)">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        <div class="nd-body">
                            <div class="nd-text">{{ $nbReportsPending }} annual report{{ $nbReportsPending !== 1 ? 's' : '' }} under review</div>
                            <div class="nd-sub">Chapter submissions awaiting review</div>
                        </div>
                        <span class="nd-count" style="background:var(--blue-l);color:var(--blue)">{{ $nbReportsPending }}</span>
                    </a>
                    @endif
                    <hr class="nd-divider"/>
                    @endif

                    <div class="nd-group-lbl">Quick Links</div>
                    <a href="{{ route('admin.annual-reports') }}" class="nd-item" onclick="closeNotif()">
                        <div class="nd-icon" style="background:var(--blue)">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        </div>
                        <div class="nd-body">
                            <div class="nd-text">Annual Reports</div>
                            <div class="nd-sub">Review chapter submissions</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.awards') }}" class="nd-item" onclick="closeNotif()">
                        <div class="nd-icon" style="background:var(--gold)">
                            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        </div>
                        <div class="nd-body">
                            <div class="nd-text">Award Management</div>
                            <div class="nd-sub">Assign points to chapters</div>
                        </div>
                    </a>

                    <div class="nd-foot">
                        <a href="{{ route('admin.activity') }}">View all activity →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        @yield('content')
    </div>
</div>

{{-- ── COMMAND PALETTE ───────────────────────────────── --}}
<div class="cmd-ov" id="cmdOverlay" onclick="if(event.target===this)closeCmd()">
    <div class="cmd-box">
        <div class="cmd-input-row">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input class="cmd-input" id="cmdInput" placeholder="Search pages, actions…" oninput="filterCmd(this.value)" autocomplete="off"/>
            <span class="cmd-esc-key">Esc</span>
        </div>
        <div class="cmd-results" id="cmdResults">
            <div class="cmd-sec-lbl">Navigation</div>
            <a class="cmd-item" href="{{ route('admin.dashboard') }}" onclick="closeCmd()">
                <div class="cmd-item-icon"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg></div>
                <div class="cmd-item-body"><div class="cmd-item-text">Dashboard</div><div class="cmd-item-sub">Overview of YES IEM activity</div></div>
            </a>
            <a class="cmd-item" href="{{ route('admin.official-events') }}" onclick="closeCmd()">
                <div class="cmd-item-icon"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                <div class="cmd-item-body"><div class="cmd-item-text">Official Events</div><div class="cmd-item-sub">Manage YES board events</div></div>
            </a>
            <a class="cmd-item" href="{{ route('admin.student-section-events-admin') }}" onclick="closeCmd()">
                <div class="cmd-item-icon"><svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/></svg></div>
                <div class="cmd-item-body"><div class="cmd-item-text">Student Events</div><div class="cmd-item-sub">Review chapter submissions</div></div>
                @if($nbStudentPending > 0)<span class="cmd-item-badge">{{ $nbStudentPending }} pending</span>@endif
            </a>
            <a class="cmd-item" href="{{ route('admin.flagship-events') }}" onclick="closeCmd()">
                <div class="cmd-item-icon"><svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
                <div class="cmd-item-body"><div class="cmd-item-text">Flagship Events</div><div class="cmd-item-sub">NATSUM, CAFEO management</div></div>
            </a>
            <a class="cmd-item" href="{{ route('admin.annual-reports') }}" onclick="closeCmd()">
                <div class="cmd-item-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                <div class="cmd-item-body"><div class="cmd-item-text">Annual Reports</div><div class="cmd-item-sub">Review chapter annual submissions</div></div>
            </a>
            <a class="cmd-item" href="{{ route('admin.awards') }}" onclick="closeCmd()">
                <div class="cmd-item-icon"><svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
                <div class="cmd-item-body"><div class="cmd-item-text">Award Management</div><div class="cmd-item-sub">Assign points to chapters</div></div>
            </a>
            <a class="cmd-item" href="{{ route('admin.branches') }}" onclick="closeCmd()">
                <div class="cmd-item-icon"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
                <div class="cmd-item-body"><div class="cmd-item-text">State Branches</div><div class="cmd-item-sub">YES state branch network</div></div>
            </a>
            <a class="cmd-item" href="{{ route('admin.chapters') }}" onclick="closeCmd()">
                <div class="cmd-item-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                <div class="cmd-item-body"><div class="cmd-item-text">Chapter Accounts</div><div class="cmd-item-sub">Manage student chapter access</div></div>
            </a>
            <a class="cmd-item" href="{{ route('admin.activity') }}" onclick="closeCmd()">
                <div class="cmd-item-icon"><svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
                <div class="cmd-item-body"><div class="cmd-item-text">Activity Feed</div><div class="cmd-item-sub">Audit trail and system events</div></div>
            </a>
            <a class="cmd-item" href="{{ route('admin.settings') }}" onclick="closeCmd()">
                <div class="cmd-item-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg></div>
                <div class="cmd-item-body"><div class="cmd-item-text">Settings</div><div class="cmd-item-sub">Portal configuration</div></div>
            </a>
            <div id="cmdEmpty" style="display:none" class="nd-empty">No results found.</div>
        </div>
        <div class="cmd-footer">
            <div class="cmd-hint"><span class="cmd-key">↑↓</span> Navigate</div>
            <div class="cmd-hint"><span class="cmd-key">↵</span> Open</div>
            <div class="cmd-hint"><span class="cmd-key">Esc</span> Close</div>
            <div class="cmd-hint" style="margin-left:auto"><span class="cmd-key">Ctrl</span><span class="cmd-key">K</span> Open palette</div>
        </div>
    </div>
</div>

{{-- ── GLOBAL CONFIRM MODAL ─────────────────────────── --}}
<div class="confirm-ov" id="confirmOv" onclick="if(event.target===this)cancelConfirm()">
    <div class="confirm-box">
        <div class="confirm-head" id="confirmHead">
            <div class="confirm-head-icon" id="confirmIcon"></div>
            <h4 id="confirmTitle">Confirm Action</h4>
        </div>
        <div class="confirm-body">
            <p id="confirmMsg"></p>
            <div class="confirm-chip" id="confirmChip" style="display:none">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                <span id="confirmChipText"></span>
            </div>
            <div id="confirmNotesWrap" style="display:none">
                <label class="confirm-notes-lbl" for="confirmNotes">Notes / Feedback <span style="color:var(--red)">*</span></label>
                <textarea class="confirm-notes" id="confirmNotes" placeholder="Add feedback or reason for the chapter…"></textarea>
                <div style="font-size:10px;color:var(--grey);margin-top:4px">This note will be visible to the chapter.</div>
            </div>
        </div>
        <div class="confirm-foot">
            <button class="btn-ghost" onclick="cancelConfirm()">Cancel</button>
            <button id="confirmActionBtn" onclick="executeConfirm()">Confirm</button>
        </div>
    </div>
</div>

<div class="toast" id="toast"></div>

<script>
/* ── TOAST ── */
function showToast(msg, type = '') {
    const t = document.getElementById('toast');
    const icons = {
        success: '<svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>',
        danger:  '<svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
        warn:    '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>',
    };
    t.innerHTML = (icons[type] || '') + msg;
    t.className = 'toast show' + (type ? ' ' + type : '');
    clearTimeout(t._t);
    t._t = setTimeout(() => t.classList.remove('show'), 3000);
}

/* ── NOTIFICATION DROPDOWN ── */
function toggleNotif(e) {
    e.stopPropagation();
    document.getElementById('notifDropdown').classList.toggle('open');
}
function closeNotif() {
    document.getElementById('notifDropdown').classList.remove('open');
}
function markAllRead() {
    const badge = document.querySelector('.notif-badge');
    if (badge) { badge.remove(); const dot = document.createElement('span'); dot.className = 'notif-dot'; document.getElementById('notifBtn').appendChild(dot); }
    closeNotif();
    showToast('All notifications marked as read.', 'success');
}
document.addEventListener('click', e => {
    const w = document.getElementById('notifWrap');
    if (w && !w.contains(e.target)) closeNotif();
});

/* ── COMMAND PALETTE ── */
let _cmdSel = -1;
function openCmd() {
    document.getElementById('cmdOverlay').classList.add('open');
    const inp = document.getElementById('cmdInput');
    inp.value = ''; filterCmd('');
    setTimeout(() => inp.focus(), 40);
}
function closeCmd() {
    document.getElementById('cmdOverlay').classList.remove('open');
    _cmdSel = -1;
}
function filterCmd(q) {
    const ql = q.toLowerCase();
    const items = [...document.querySelectorAll('#cmdResults .cmd-item')];
    let vis = 0;
    items.forEach(el => {
        const t = el.querySelector('.cmd-item-text')?.textContent.toLowerCase() || '';
        const s = el.querySelector('.cmd-item-sub')?.textContent.toLowerCase() || '';
        const show = !q || t.includes(ql) || s.includes(ql);
        el.style.display = show ? 'flex' : 'none';
        if (show) vis++;
    });
    document.getElementById('cmdEmpty').style.display = vis ? 'none' : 'block';
    _cmdSel = -1; _updateCmdSel();
}
function _visibleCmdItems() {
    return [...document.querySelectorAll('#cmdResults .cmd-item')].filter(i => i.style.display !== 'none');
}
function _updateCmdSel() {
    _visibleCmdItems().forEach((el, i) => el.classList.toggle('selected', i === _cmdSel));
}

/* ── GLOBAL CONFIRM MODAL ── */
let _confirmCb = null, _confirmNeedNotes = false;
function showConfirm({ title, msg, chip, type = 'info', requireNotes = false, onConfirm }) {
    _confirmCb = onConfirm; _confirmNeedNotes = requireNotes;
    document.getElementById('confirmTitle').textContent = title;
    document.getElementById('confirmMsg').textContent   = msg;
    const chipEl = document.getElementById('confirmChip');
    if (chip) { chipEl.style.display = 'flex'; document.getElementById('confirmChipText').textContent = chip; }
    else chipEl.style.display = 'none';
    const notesWrap = document.getElementById('confirmNotesWrap');
    notesWrap.style.display = requireNotes ? 'block' : 'none';
    const notes = document.getElementById('confirmNotes');
    notes.value = ''; notes.classList.remove('err');
    const head = document.getElementById('confirmHead');
    const icon = document.getElementById('confirmIcon');
    const btn  = document.getElementById('confirmActionBtn');
    const configs = {
        approve: { bg:'#166534', ico:'<svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>', cls:'btn-approve', lbl:'Approve' },
        reject:  { bg:'var(--red)', ico:'<svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>', cls:'btn-reject', lbl:'Return to Chapter' },
        warn:    { bg:'var(--amber)', ico:'<svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>', cls:'btn-prim', lbl:'Confirm' },
        info:    { bg:'var(--navy-dark)', ico:'<svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>', cls:'btn-prim', lbl:'Confirm' },
    };
    const c = configs[type] || configs.info;
    head.style.background = c.bg; icon.innerHTML = c.ico; btn.className = c.cls; btn.textContent = c.lbl;
    document.getElementById('confirmOv').classList.add('open');
}
function cancelConfirm() { document.getElementById('confirmOv').classList.remove('open'); _confirmCb = null; }
function executeConfirm() {
    if (_confirmNeedNotes) {
        const n = document.getElementById('confirmNotes');
        if (!n.value.trim()) { n.classList.add('err'); n.focus(); return; }
    }
    document.getElementById('confirmOv').classList.remove('open');
    if (_confirmCb) _confirmCb(document.getElementById('confirmNotes').value.trim());
    _confirmCb = null;
}

/* ── KEYBOARD SHORTCUTS ── */
document.addEventListener('keydown', e => {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') { e.preventDefault(); openCmd(); return; }
    if (e.key === 'Escape') {
        closeCmd(); cancelConfirm();
        document.querySelectorAll('.slide-panel.open').forEach(p => p.classList.remove('open'));
        document.querySelectorAll('.dim-overlay.on').forEach(o => o.classList.remove('on'));
        document.querySelectorAll('.modal-ov.open').forEach(m => m.classList.remove('open'));
        return;
    }
    if (!document.getElementById('cmdOverlay')?.classList.contains('open')) return;
    const items = _visibleCmdItems();
    if (e.key === 'ArrowDown') { e.preventDefault(); _cmdSel = Math.min(_cmdSel + 1, items.length - 1); _updateCmdSel(); items[_cmdSel]?.scrollIntoView({block:'nearest'}); }
    else if (e.key === 'ArrowUp') { e.preventDefault(); _cmdSel = Math.max(_cmdSel - 1, -1); _updateCmdSel(); }
    else if (e.key === 'Enter' && _cmdSel >= 0) { items[_cmdSel]?.click(); }
});
</script>
@yield('scripts')
</body>
</html>
