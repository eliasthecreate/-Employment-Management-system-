<?php 
require_once '../includes/header.php'; 
require_role(['Admin', 'Manager']);
require_once '../config/db.php';

// Handle add department
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_department'])) {
    $name        = trim($_POST['department_name'] ?? '');
    $code        = trim($_POST['department_code'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name !== '' && $code !== '') {
        $stmt = $pdo->prepare("INSERT INTO departments (department_name, department_code, description) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $code, $description])) {
            $success = "Department added successfully!";
        } else {
            $error = "Failed to add department.";
        }
    } else {
        $error = "Department name and code are required.";
    }
}

// Fetch existing departments
$departments = $pdo->query("SELECT d.*, CONCAT(e.first_name, ' ', e.last_name) as manager_name 
                           FROM departments d 
                           LEFT JOIN employees e ON d.manager_id = e.employee_id 
                           ORDER BY d.department_name")
                  ->fetchAll();
?>

<h2 class="text-2xl font-semibold mb-4">Departments</h2>
<p class="text-sm text-slate-300 mb-4">Manage your company structure and how teams are grouped.</p>

<?php if (isset($success)): ?>
  <p class="mb-4 rounded-lg border border-emerald-500/50 bg-emerald-500/10 px-3 py-2 text-sm text-emerald-200"><?= h($success) ?></p>
<?php endif; ?>
<?php if (isset($error)): ?>
  <p class="mb-4 rounded-lg border border-red-500/50 bg-red-500/10 px-3 py-2 text-sm text-red-200"><?= h($error) ?></p>
<?php endif; ?>

<div class="grid md:grid-cols-2 gap-4 mb-6">
  <div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-4 text-sm text-slate-200">
    <h3 class="text-sm font-semibold mb-3">Add new department</h3>
    <form method="post" class="space-y-3">
      <div>
        <label for="department_name" class="block mb-1 text-slate-300 text-xs font-medium">Department name *</label>
        <input id="department_name" type="text" name="department_name" required
               class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent"
               placeholder="e.g. Engineering" />
      </div>
      <div>
        <label for="department_code" class="block mb-1 text-slate-300 text-xs font-medium">Department code *</label>
        <input id="department_code" type="text" name="department_code" required maxlength="10"
               class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent"
               placeholder="e.g. ENG" />
      </div>
      <div>
        <label for="description" class="block mb-1 text-slate-300 text-xs font-medium">Description</label>
        <textarea id="description" name="description" rows="3"
                  class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent"
                  placeholder="Short description"></textarea>
      </div>
      <button type="submit" name="add_department"
              class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-500 via-cyan-400 to-emerald-400 px-4 py-2 text-xs font-semibold text-slate-950 shadow-md shadow-blue-500/40 hover:shadow-blue-400/60 hover:translate-y-[1px] transition-all">
        Add department
      </button>
    </form>
  </div>

  <div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-4 text-sm text-slate-200">
    <h3 class="text-sm font-semibold mb-3">Departments overview</h3>
    <p class="text-xs text-slate-400 mb-2">You can edit department details from the list below.</p>
    <?php if (!$departments): ?>
      <p class="text-xs text-slate-400">No departments found yet.</p>
    <?php else: ?>
      <ul class="space-y-2 text-xs">
        <?php foreach ($departments as $dept): ?>
          <li class="flex items-center justify-between border border-slate-800/80 rounded-lg px-3 py-2 bg-slate-950/60">
            <div>
              <div class="font-medium text-slate-100"><?= h($dept['department_name']) ?> <span class="text-slate-500">(<?= h($dept['department_code']) ?>)</span></div>
              <div class="text-[11px] text-slate-400">Manager: <?= h($dept['manager_name'] ?? 'Not assigned') ?></div>
            </div>
            <a href="<?= BASE_PATH ?>/actions/department_edit.php?id=<?= (int)$dept['department_id'] ?>"
               class="inline-flex items-center rounded-lg border border-slate-700 px-3 py-1 text-[11px] text-slate-200 hover:border-slate-400 hover:text-white transition-colors">
              Edit
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</div>

<div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-4 text-sm text-slate-200">
  <h3 class="text-sm font-semibold mb-3">All departments</h3>
  <div class="overflow-x-auto">
    <table class="min-w-full text-xs text-left border border-slate-800/80 bg-slate-950/60 rounded-xl overflow-hidden">
      <thead class="bg-slate-900/90">
        <tr>
          <th class="px-4 py-2 font-semibold text-slate-400 uppercase tracking-wider">Code</th>
          <th class="px-4 py-2 font-semibold text-slate-400 uppercase tracking-wider">Department</th>
          <th class="px-4 py-2 font-semibold text-slate-400 uppercase tracking-wider">Manager</th>
          <th class="px-4 py-2 font-semibold text-slate-400 uppercase tracking-wider">Established</th>
          <th class="px-4 py-2 font-semibold text-slate-400 uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-800/80">
        <?php if (!$departments): ?>
          <tr>
            <td colspan="5" class="px-4 py-3 text-center text-slate-400">No departments found.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($departments as $dept): ?>
          <tr class="hover:bg-slate-900/80 transition-colors">
            <td class="px-4 py-2 text-slate-300"><?= h($dept['department_code']) ?></td>
            <td class="px-4 py-2 text-slate-200"><?= h($dept['department_name']) ?></td>
            <td class="px-4 py-2 text-slate-300"><?= h($dept['manager_name'] ?? 'Not assigned') ?></td>
            <td class="px-4 py-2 text-slate-300"><?= h($dept['established_date'] ?? 'N/A') ?></td>
            <td class="px-4 py-2">
              <a href="<?= BASE_PATH ?>/actions/department_edit.php?id=<?= (int)$dept['department_id'] ?>"
                 class="inline-flex items-center rounded-lg border border-slate-700 px-3 py-1 text-[11px] text-slate-200 hover:border-slate-400 hover:text-white transition-colors">
                Edit
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once '../includes/footer.php'; ?>
