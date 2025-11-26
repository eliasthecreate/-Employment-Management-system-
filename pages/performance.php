<?php 
require_once '../includes/header.php'; 
require_role(['Admin', 'Manager']);
?>
<h2 class="text-2xl font-semibold mb-4">Performance</h2>
<p class="text-sm text-slate-300 mb-4">Track how teams and individuals are performing.</p>
<div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-4 text-sm text-slate-300">
  <p>You can later plug in KPIs, reviews and scorecards here. The layout already matches the rest of the app.</p>
</div>
<?php require_once '../includes/footer.php'; ?>
