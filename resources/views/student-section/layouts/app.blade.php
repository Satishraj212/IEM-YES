{{-- resources/views/student-section/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>@yield('title', 'Student Section') — YES UTM Johor</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --navy:#001f45;--navy-dark:#001030;--navy-mid:#002a5c;
  --gold:#c8a84b;--gold-light:#e0c068;
  --green:#1a6b3c;--green-a:#4caf7d;--green-dark:#0f4526;--green-l:#a8e6c1;
  --amber:#d97706;--amber-l:#fef3c7;
  --blue:#1d4ed8;--blue-l:#dbeafe;
  --red:#c0392b;--grey:#6b7280;--light:#e5e7eb;--off:#f8f9fa;
}
body{font-family:'DM Sans',sans-serif;background:#f3f4f6;color:#1f2937;display:flex;min-height:100vh}

/* ── SIDEBAR ── */
.dash-sidebar{width:260px;min-height:100vh;background:var(--navy-dark);display:flex;flex-direction:column;flex-shrink:0;position:sticky;top:0;height:100vh;overflow-y:auto}
.branch-card{padding:22px 20px 18px;border-bottom:1px solid rgba(255,255,255,.07)}
.branch-seal{width:44px;height:44px;background:var(--gold);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:13px;font-weight:900;color:var(--navy-dark);margin-bottom:10px;letter-spacing:1px}
.branch-name{font-family:'Playfair Display',serif;font-size:15px;font-weight:700;color:#fff;margin-bottom:2px}
.branch-chapter{font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--gold);margin-bottom:4px}
.branch-meta{font-size:10px;color:rgba(255,255,255,.45);line-height:1.5;margin-bottom:10px}
.branch-badges{display:flex;flex-wrap:wrap;gap:5px}
.bb{display:inline-flex;align-items:center;gap:4px;padding:3px 8px;background:rgba(200,168,75,.12);border:1px solid rgba(200,168,75,.25);font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--gold)}
.info-items{padding:16px 20px;border-bottom:1px solid rgba(255,255,255,.07)}
.info-item{display:flex;align-items:flex-start;gap:10px;padding:6px 0}
.info-icon{width:13px;height:13px;fill:none;stroke:rgba(200,168,75,.5);stroke-width:2;flex-shrink:0;margin-top:2px}
.info-label{font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:1px}
.info-value{font-size:11px;color:rgba(255,255,255,.75);font-weight:500}
.sb-nav{padding:14px 12px;display:flex;flex-direction:column;gap:3px}
.sb-ni{display:flex;align-items:center;gap:10px;padding:10px 12px;background:transparent;border:none;color:rgba(255,255,255,.55);font-family:'DM Sans',sans-serif;font-size:12px;font-weight:600;cursor:pointer;text-align:left;transition:all .2s;border-radius:2px;text-decoration:none}
.sb-ni svg{width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2;flex-shrink:0}
.sb-ni:hover{background:rgba(255,255,255,.06);color:rgba(255,255,255,.85)}
.sb-ni.active{background:rgba(200,168,75,.12);color:var(--gold);border-left:3px solid var(--gold);padding-left:9px}
.sb-nb{margin-left:auto;background:var(--navy-mid);color:var(--gold);font-size:9px;font-weight:700;padding:2px 6px;border-radius:10px}
.sb-nb.green{background:rgba(76,175,125,.15);color:var(--green-a)}

/* ── MAIN ── */
.dash-main{flex:1;padding:28px 32px;overflow-x:hidden}
.sec-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px}
.sh-eyebrow{font-size:9px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--gold);margin-bottom:6px}
.sh-title{font-family:'Playfair Display',serif;font-size:26px;font-weight:900;color:var(--navy);line-height:1.1;margin-bottom:6px}
.sh-title em{color:var(--gold);font-style:italic}
.sh-sub{font-size:12px;color:var(--grey);line-height:1.6}

/* ── STATS ── */
.stat-row{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px}
.sc{background:#fff;border:1px solid var(--light);padding:18px;position:relative;overflow:hidden;cursor:pointer;transition:box-shadow .2s}
.sc:hover{box-shadow:0 4px 16px rgba(0,31,69,.08)}
.sc-bar{position:absolute;top:0;left:0;right:0;height:3px}
.sc-lbl{font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:8px}
.sc-val{font-family:'Playfair Display',serif;font-size:30px;font-weight:900;color:var(--navy);line-height:1;margin-bottom:4px}
.sc-sub{font-size:11px;color:var(--grey)}
.sc-trend{font-size:10px;font-weight:700;margin-top:4px}
.trend-up{color:var(--green-a)}

/* ── PANELS ── */
.g2{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}
.panel{background:#fff;border:1px solid var(--light);margin-bottom:16px}
.ph{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--light)}
.pt{font-family:'Playfair Display',serif;font-size:15px;font-weight:700;color:var(--navy)}
.pt em{color:var(--gold);font-style:italic}
.pa{background:none;border:none;color:var(--navy);font-size:11px;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;letter-spacing:.5px;text-transform:uppercase}
.pa:hover{color:var(--gold)}
.pb{padding:16px 20px}
.ph-actions{display:flex;align-items:center;gap:10px}

/* ── TABLE ── */
.ev-table{width:100%;border-collapse:collapse}
.ev-table th{font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);padding:10px 14px;text-align:left;border-bottom:1px solid var(--light)}
.ev-table td{padding:11px 14px;border-bottom:1px solid var(--light);vertical-align:middle}
.ev-table tr:last-child td{border-bottom:none}
.ev-title{font-size:12px;font-weight:600;color:var(--navy);margin-bottom:3px}
.ev-cat{display:inline-flex;align-items:center;font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;padding:3px 7px}
.b-hackathon{background:#ede9fe;color:#5b21b6}
.b-career{background:#dbeafe;color:#1e40af}
.b-sdg{background:#d1fae5;color:#065f46}
.b-workshop{background:#fef3c7;color:#92400e}
.b-webinar{background:#e0f2fe;color:#0369a1}
.b-volunteer{background:#d1fae5;color:#065f46}
.b-competition{background:#fce7f3;color:#9d174d}
.pill{display:inline-flex;align-items:center;font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;padding:3px 8px}
.pill-open{background:#d1fae5;color:#065f46}
.pill-upcoming{background:#dbeafe;color:#1e40af}
.pill-draft{background:var(--light);color:var(--grey)}
.pill-review{background:#fef3c7;color:#92400e}
.pill-approved{background:#d1fae5;color:#065f46}
.pill-closed{background:var(--light);color:var(--grey)}
.prog-wrap{display:flex;align-items:center;gap:6px}
.prog-bar{flex:1;height:4px;background:var(--light);overflow:hidden}
.prog-fill{height:100%;background:var(--green-a)}
.prog-txt{font-size:10px;font-weight:600;color:var(--navy);white-space:nowrap}

/* ── TABS / SEARCH ── */
.tabs{display:flex;gap:2px;margin-bottom:12px}
.tab{padding:7px 14px;background:transparent;border:none;border-bottom:2px solid transparent;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;color:var(--grey);cursor:pointer;text-transform:uppercase;letter-spacing:.5px;transition:all .2s}
.tab.active{color:var(--navy);border-bottom-color:var(--gold)}
.tab:hover{color:var(--navy)}
.sr{display:flex;align-items:center;gap:10px;margin-bottom:14px}
.si{display:flex;align-items:center;gap:8px;flex:1;background:var(--off);border:1px solid var(--light);padding:8px 12px}
.si svg{width:14px;height:14px;fill:none;stroke:var(--grey);stroke-width:2;flex-shrink:0}
.si input{border:none;background:none;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);outline:none;width:100%}
.fsel{padding:7px 10px;border:1px solid var(--light);background:#fff;font-family:'DM Sans',sans-serif;font-size:11px;color:var(--navy);cursor:pointer;outline:none}

/* ── EVENT LIST ── */
.ev-list{display:flex;flex-direction:column;gap:0}
.ev-row{border-bottom:1px solid var(--light)}
.ev-row:last-child{border-bottom:none}
.ev-summary{display:flex;align-items:center;gap:14px;padding:14px 20px;cursor:pointer;transition:background .15s}
.ev-summary:hover{background:var(--off)}
.ev-summary.expanded{background:var(--off)}
.ev-info-wrap{flex:1;min-width:0}
.ev-name{font-size:13px;font-weight:700;color:var(--navy);margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.ev-meta{display:flex;flex-wrap:wrap;gap:10px}
.ev-meta-item{display:flex;align-items:center;gap:4px;font-size:11px;color:var(--grey)}
.ev-meta-item svg{width:11px;height:11px;fill:none;stroke:currentColor;stroke-width:2}
.ev-right{display:flex;align-items:center;gap:8px;flex-shrink:0}
.abtns{display:flex;gap:4px}
.abtn{width:28px;height:28px;display:flex;align-items:center;justify-content:center;background:var(--off);border:1px solid var(--light);cursor:pointer;transition:all .2s}
.abtn svg{width:13px;height:13px;fill:none;stroke:var(--navy);stroke-width:2}
.abtn:hover{background:var(--navy);border-color:var(--navy)}
.abtn:hover svg{stroke:#fff}
.abtn.del:hover{background:var(--red);border-color:var(--red)}
.ev-chevron{width:16px;height:16px;fill:none;stroke:var(--grey);stroke-width:2;transition:transform .2s}
.ev-chevron.open{transform:rotate(180deg)}

/* ── EVENT DETAIL ── */
.ev-detail{max-height:0;overflow:hidden;transition:max-height .35s ease}
.ev-detail.open{max-height:800px}
.ev-detail-inner{display:grid;grid-template-columns:120px 1fr 200px;gap:20px;padding:20px;border-top:1px solid var(--light);background:#fafafa}
.poster-col{}
.sec-lbl{font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:8px}
.poster-box{border:2px dashed var(--light);background:#fff;aspect-ratio:3/4;overflow:hidden;cursor:pointer;position:relative;transition:border-color .2s}
.poster-box:hover{border-color:var(--navy)}
.poster-box input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.poster-box img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.poster-box.has-poster{border-style:solid;border-color:var(--light)}
.poster-clear-btn{width:100%;margin-top:4px;padding:5px;background:none;border:1px solid var(--light);font-size:9px;font-weight:700;color:var(--red);cursor:pointer;font-family:'DM Sans',sans-serif;display:flex;align-items:center;justify-content:center}
.desc-col{}
.desc-text{font-size:12px;color:#374151;line-height:1.65}
.status-track{display:flex;gap:0;margin:6px 0}
.st-step{display:flex;flex-direction:column;align-items:center;flex:1;position:relative}
.st-step:not(:last-child)::after{content:'';position:absolute;top:10px;left:50%;width:100%;height:1px;z-index:0}
.s-done::after{background:var(--green-a)}
.s-active::after,.s-pending::after{background:var(--light)}
.st-dot{width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center;position:relative;z-index:1;flex-shrink:0}
.s-done .st-dot{background:var(--green-a)}
.s-done .st-dot svg{width:10px;height:10px;fill:none;stroke:#fff;stroke-width:2.5}
.s-active .st-dot{background:var(--gold)}
.s-active .st-dot svg{display:none}
.s-pending .st-dot{background:var(--light)}
.s-pending .st-dot svg{display:none}
.st-lbl{font-size:9px;font-weight:600;color:var(--grey);text-align:center;margin-top:4px;white-space:nowrap}
.s-done .st-lbl{color:var(--green)}
.s-active .st-lbl{color:var(--amber);font-weight:700}
.notes-area{width:100%;border:1px solid var(--light);background:#fff;font-family:'DM Sans',sans-serif;font-size:11px;color:var(--navy);padding:8px 10px;outline:none;resize:vertical;min-height:50px;margin-top:6px}
.info-col{}
.ic-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:10px}
.ic{background:#fff;border:1px solid var(--light);padding:8px 10px}
.ic-full{grid-column:1/-1}
.ic-lbl{font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);margin-bottom:3px}
.ic-val{font-size:12px;font-weight:600;color:var(--navy)}
.tag-wrap{display:flex;flex-wrap:wrap;gap:4px}
.tag-pill{padding:3px 8px;background:var(--off);border:1px solid var(--light);font-size:9px;font-weight:600;color:var(--grey)}
.action-row{display:flex;gap:6px;margin-top:8px}
.btn-edit-sm{flex:1;padding:7px;background:var(--navy-dark);color:var(--gold);font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;border:none;cursor:pointer;font-family:'DM Sans',sans-serif}
.btn-del-sm{flex:1;padding:7px;background:none;color:var(--red);font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;border:1px solid rgba(192,57,43,.3);cursor:pointer;font-family:'DM Sans',sans-serif}

/* ── SLIDE PANEL ── */
.dim-overlay{position:fixed;inset:0;background:rgba(0,16,48,.4);z-index:900;opacity:0;pointer-events:none;transition:opacity .3s}
.dim-overlay.on{opacity:1;pointer-events:all}
.slide-panel{position:fixed;top:0;right:-520px;width:480px;height:100vh;background:#fff;z-index:901;display:flex;flex-direction:column;box-shadow:-8px 0 40px rgba(0,0,0,.15);transition:right .32s cubic-bezier(.4,0,.2,1)}
.slide-panel.open{right:0}
.sp-head{display:flex;align-items:flex-start;justify-content:space-between;padding:20px 24px;border-bottom:1px solid var(--light);flex-shrink:0}
.sp-mode-badge{font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--gold);margin-bottom:4px}
.sp-head h3{font-family:'Playfair Display',serif;font-size:17px;font-weight:700;color:var(--navy)}
.sp-close{width:30px;height:30px;background:var(--off);border:1px solid var(--light);font-size:18px;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--grey);flex-shrink:0}
.sp-body{flex:1;overflow-y:auto;padding:20px 24px}
.sp-foot{padding:16px 24px;border-top:1px solid var(--light);display:flex;justify-content:flex-end;gap:10px;flex-shrink:0}
.pf-row{margin-bottom:14px}
.pf-lbl{font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);margin-bottom:6px;display:block}
.pf-val{font-size:12px;color:#374151;line-height:1.6}
.pf-val.muted{color:var(--grey)}
.pf-input{width:100%;border:1px solid var(--light);padding:8px 10px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);outline:none;background:#fff}
.pf-input:focus{border-color:var(--navy)}
.pf-select{width:100%;border:1px solid var(--light);padding:8px 10px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);outline:none;background:#fff}
.pf-textarea{width:100%;border:1px solid var(--light);padding:8px 10px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);outline:none;resize:vertical;min-height:70px}
.pf-divider{border:none;border-top:1px solid var(--light);margin:14px 0}
.pf-grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:14px}
.info-card{background:var(--off);border:1px solid var(--light);padding:10px 12px}
.ic-lbl2{font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);margin-bottom:3px}
.ic-val2{font-size:12px;font-weight:600;color:var(--navy)}
.ic-val2.muted{color:var(--grey);font-weight:400}

/* ── MODAL ── */
.modal-overlay{position:fixed;inset:0;background:rgba(0,16,48,.55);z-index:1000;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity .25s}
.modal-overlay.open{opacity:1;pointer-events:all}
.modal{background:#fff;max-height:90vh;overflow-y:auto;display:flex;flex-direction:column;box-shadow:0 20px 60px rgba(0,0,0,.25)}
.modal-head{display:flex;align-items:center;justify-content:space-between;padding:20px 28px;border-bottom:1px solid var(--light);flex-shrink:0;position:sticky;top:0;background:#fff;z-index:1}
.modal-head h3{font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--navy)}
.modal-close{width:30px;height:30px;background:var(--off);border:1px solid var(--light);font-size:20px;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--grey)}
.modal-body{padding:24px 28px;flex:1}
.modal-footer{padding:16px 28px;border-top:1px solid var(--light);display:flex;justify-content:flex-end;gap:10px;flex-shrink:0;position:sticky;bottom:0;background:#fff}

/* ── FORMS ── */
.form-section-lbl{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);margin-bottom:10px;padding-bottom:7px;border-bottom:1px solid var(--light)}
.form-row{margin-bottom:14px}
.form-lbl{display:block;font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);margin-bottom:5px}
.form-inp{width:100%;border:1px solid var(--light);padding:9px 11px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);outline:none;background:#fff}
.form-inp:focus{border-color:var(--navy)}
.form-sel{width:100%;border:1px solid var(--light);padding:9px 11px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);outline:none;background:#fff;cursor:pointer}
.form-ta{width:100%;border:1px solid var(--light);padding:9px 11px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);outline:none;resize:vertical}
.form-2{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px}

/* ── ACTIVITY FEED ── */
.activity-feed{display:flex;flex-direction:column;gap:0}
.af-item{display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid var(--light)}
.af-item:last-child{border-bottom:none}
.af-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;margin-top:4px}
.af-content{flex:1}
.af-text{font-size:12px;color:#374151;line-height:1.55}
.af-time{font-size:10px;color:var(--grey);margin-top:3px}

/* ── ORG CHART UPLOAD ── */
.chart-upload-zone{border:2px dashed var(--light);background:var(--off);cursor:pointer;padding:30px;text-align:center;transition:border-color .2s}
.chart-upload-zone:hover{border-color:var(--navy)}
.chart-upload-zone input[type=file]{display:none}

/* ── BUTTONS ── */
.btn-primary{display:inline-flex;align-items:center;gap:7px;background:var(--navy-dark);color:var(--gold);padding:10px 20px;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .2s}
.btn-primary:hover{background:var(--navy-mid)}
.btn-secondary{display:inline-flex;align-items:center;gap:7px;background:#fff;color:var(--navy);padding:9px 18px;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;border:1px solid var(--light);cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .2s}
.btn-secondary:hover{border-color:var(--navy)}
.btn-ghost{padding:9px 18px;background:none;border:1px solid var(--light);font-size:11px;font-weight:700;color:var(--grey);cursor:pointer;font-family:'DM Sans',sans-serif;text-transform:uppercase;letter-spacing:.5px}
.btn-prim{padding:9px 18px;background:var(--navy-dark);color:var(--gold);font-size:11px;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;border:none;text-transform:uppercase;letter-spacing:.5px}
.btn-danger{padding:9px 18px;background:var(--red);color:#fff;font-size:11px;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;border:none;text-transform:uppercase;letter-spacing:.5px}
.btn-gold{display:inline-flex;align-items:center;gap:7px;background:var(--gold);color:var(--navy-dark);padding:11px 22px;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .2s}
.btn-gold:hover{background:var(--gold-light);box-shadow:0 4px 20px rgba(200,168,75,.3)}
.btn-outline-white{display:inline-flex;align-items:center;gap:7px;background:transparent;color:rgba(255,255,255,.75);padding:10px 20px;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;border:1px solid rgba(255,255,255,.25);cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .2s}
.btn-outline-white:hover{border-color:#fff;color:#fff}
.btn-mini{flex:1;padding:8px;font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .2s}
.btn-mini-navy{background:var(--navy-dark);color:var(--gold)}
.btn-mini-navy:hover{background:var(--navy-mid)}
.btn-mini-outline{background:transparent;color:var(--navy);border:1px solid var(--light)!important}
.btn-mini-outline:hover{border-color:var(--navy)!important;background:var(--off)}

/* ── TOAST ── */
#toast{position:fixed;bottom:24px;right:24px;padding:12px 20px;font-size:12px;font-weight:600;color:#fff;background:var(--navy-dark);box-shadow:0 4px 20px rgba(0,0,0,.2);z-index:9999;transform:translateY(20px);opacity:0;transition:all .3s;pointer-events:none;max-width:320px}
#toast.show{transform:translateY(0);opacity:1}
#toast.success{background:var(--green)}
#toast.danger{background:var(--red)}
</style>
@yield('styles')
</head>
<body>

<aside class="dash-sidebar">
  <div class="branch-card">
    <div class="branch-seal">JHR</div>
    <div class="branch-name">YES UTM Johor</div>
    <div class="branch-chapter">YES Johor Chapter</div>
    <div class="branch-meta">Universiti Teknologi Malaysia, Skudai</div>
    <div class="branch-badges">
      <span class="bb">
        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        Pledge Active
      </span>
      <span class="bb">Active Branch</span>
    </div>
  </div>

  <div class="info-items">
    <div style="font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:10px">Branch Information</div>
    <div class="info-item">
      <svg class="info-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      <div><div class="info-label">Year Founded</div><div class="info-value">2008</div></div>
    </div>
    <div class="info-item">
      <svg class="info-icon" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
      <div><div class="info-label">Location</div><div class="info-value">UTM Skudai, Johor Bahru</div></div>
    </div>
    <div class="info-item">
      <svg class="info-icon" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
      <div><div class="info-label">Institution</div><div class="info-value">Universiti Teknologi Malaysia</div></div>
    </div>
    <div class="info-item">
      <svg class="info-icon" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      <div><div class="info-label">Total Members</div><div class="info-value">84 members · 76 active</div></div>
    </div>
    <div class="info-item">
      <svg class="info-icon" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      <div><div class="info-label">Academic Year</div><div class="info-value">2024 / 2025</div></div>
    </div>
    <div class="info-item">
      <svg class="info-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      <div><div class="info-label">Branch Ranking</div><div class="info-value">#3 among YES Johor</div></div>
    </div>
  </div>

  <div class="sb-nav">
    <a href="{{ route('student.overview') }}" class="sb-ni {{ request()->routeIs('student.overview') || request()->routeIs('student.dashboard') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      Student Section
    </a>
    <a href="{{ route('student.events') }}" class="sb-ni {{ request()->routeIs('student.events') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/></svg>
      My Events
      <span class="sb-nb">5</span>
    </a>
    <a href="{{ route('student.budget') }}" class="sb-ni {{ request()->routeIs('student.budget') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
      Budget Requests
      <span class="sb-nb" style="background:rgba(217,119,6,.18);color:var(--amber)">2</span>
    </a>
    <a href="{{ route('student.awards') }}" class="sb-ni {{ request()->routeIs('student.awards') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      Awards
      <span class="sb-nb green">3</span>
    </a>
    <a href="{{ route('student.reports') }}" class="sb-ni {{ request()->routeIs('student.reports') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
      Reports &amp; Analytics
    </a>
    <div style="height:1px;background:rgba(255,255,255,.07);margin:10px 0"></div>
    <form method="POST" action="{{ route('logout') }}" style="margin:0">
      @csrf
      <button type="submit" class="sb-ni" style="width:100%;background:none;border:none;cursor:pointer;color:rgba(255,120,120,.55);font-family:inherit;font-size:inherit;text-align:left">
        <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Log Out
      </button>
    </form>
  </div>
</aside>

<main class="dash-main">
  @yield('content')
</main>

<div id="toast"></div>

<script>
function showToast(msg, type) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.className = 'show' + (type ? ' ' + type : '');
  clearTimeout(t._timer);
  t._timer = setTimeout(() => t.className = '', 3000);
}
</script>
@yield('scripts')
</body>
</html>
