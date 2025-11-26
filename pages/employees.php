<?php 
require_once '../includes/header.php'; 
require_role(['Admin', 'Manager']);
require_once '../config/db.php';

$employees = $pdo->query("SELECT * FROM employee_details")->fetchAll();
?>
<h2 class="text-2xl font-semibold mb-4">Employees</h2>
<a href="<?= BASE_PATH ?>/actions/employee_add.php" class="inline-flex items-center px-4 py-2 rounded-xl bg-gradient-to-r from-emerald-500 to-cyan-400 text-slate-950 text-sm font-semibold mb-4 hover:brightness-110 transition-all shadow-md shadow-emerald-500/30">Add Employee</a>

<div class="overflow-x-auto">
  <table class="min-w-full text-sm text-left border border-slate-800/80 bg-slate-950/60 rounded-xl overflow-hidden">
    <thead class="bg-slate-900/90">
      <tr>
        <th class="px-6 py-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Name</th>
        <th class="px-6 py-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Email</th>
        <th class="px-6 py-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Department</th>
        <th class="px-6 py-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Position</th>
        <th class="px-6 py-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Salary</th>
        <th class="px-6 py-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-slate-800/80">
      <?php foreach ($employees as $e): ?>
      <tr class="hover:bg-slate-900/80 transition-colors">
        <td class="px-6 py-3 whitespace-nowrap text-slate-50"><?= h($e['full_name']) ?></td>
        <td class="px-6 py-3 whitespace-nowrap text-slate-300"><?= h($e['email']) ?></td>
        <td class="px-6 py-3 whitespace-nowrap text-slate-300"><?= h($e['department_name']) ?></td>
        <td class="px-6 py-3 whitespace-nowrap text-slate-300"><?= h($e['position_title']) ?></td>
        <td class="px-6 py-3 whitespace-nowrap text-emerald-300"><?= format_money($e['salary']) ?></td>
        <td class="px-6 py-3 whitespace-nowrap">
          <a href="<?= BASE_PATH ?>/actions/employee_edit.php?id=<?= $e['employee_id'] ?>" class="text-cyan-300 hover:text-cyan-200 hover:underline text-xs">Edit</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require_once '../includes/footer.php'; ?>