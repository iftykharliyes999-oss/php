// Shared toast helper
function toast(msg, err){
  const t=document.getElementById('toast'); if(!t) return alert(msg);
  t.textContent=msg; t.className='toast show'+(err?' error':'');
  setTimeout(()=>t.classList.remove('show'),2200);
}
const $ = id => document.getElementById(id);
const fmtBDT = n => '৳' + Number(n||0).toLocaleString('en-IN');
function initials(n){ return (n||'').split(' ').slice(0,2).map(x=>x[0]||'').join('').toUpperCase(); }
function avColor(n){ const c=['#2563eb','#22c55e','#eab308','#ef4444','#a855f7','#0ea5e9','#06b6d4','#ec4899'];
  let h=0; for(const ch of (n||'')) h=(h+ch.charCodeAt(0))%c.length; return c[h]; }

// generic AJAX helper
async function api(url, data){
  const opts = { headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'} };
  if (data){
    const fd = new FormData();
    Object.entries(data).forEach(([k,v])=> fd.append(k, v ?? ''));
    opts.method='POST'; opts.body=fd;
  }
  const r = await fetch(url, opts);
  return r.json();
}
