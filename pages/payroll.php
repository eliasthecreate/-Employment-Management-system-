<?php 
require_once '../includes/header.php'; 
require_role(['Admin', 'Manager']);
?>
<h2 class="text-2xl font-semibold mb-4">Payroll (Kwacha)</h2>
<p class="text-sm text-slate-300 mb-4">Review payroll totals in Kwacha for your workforce.</p>
<div class="grid md:grid-cols-3 gap-4 mb-6 text-sm">
  <div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-4">
    <p class="text-xs text-slate-400">This month total</p>
    <p class="mt-2 text-2xl font-semibold text-emerald-300">K 250,000.00</p>
  </div>
  <div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-4">
    <p class="text-xs text-slate-400">Average per employee</p>
    <p class="mt-2 text-2xl font-semibold text-cyan-300">K 8,200.00</p>
  </div>
  <div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-4">
    <p class="text-xs text-slate-400">Bonuses</p>
    <p class="mt-2 text-2xl font-semibold text-blue-300">K 35,000.00</p>
  </div>
</div>
<div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-4 text-sm text-slate-300">
  <p>This page is using Kwacha (K) for all amounts. Anywhere the app calls <code>format_money()</code> will now show Kwacha.</p>
</div>
<?php require_once '../includes/footer.php'; ?>
