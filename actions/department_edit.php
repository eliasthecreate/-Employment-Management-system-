<?php
require_once '../includes/functions.php';
require_role(['Admin', 'Manager']);
require_once '../config/db.php';

$department_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($department_id <= 0) {
    redirect('/pages/departments.php');
}

// Load department
$stmt = $pdo->prepare('SELECT * FROM departments WHERE department_id = ?');
$stmt->execute([$department_id]);
$dept = $stmt->fetch();

if (!$dept) {
    redirect('/pages/departments.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['department_name'] ?? '');
    $code        = trim($_POST['department_code'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name && $code) {
        $stmt = $pdo->prepare('UPDATE departments SET department_name = ?, department_code = ?, description = ? WHERE department_id = ?');
        if ($stmt->execute([$name, $code, $description, $department_id])) {
            redirect('/pages/departments.php?updated=1');
        } else {
            $error = 'Failed to update department.';
        }
    } else {
        $error = 'Department name and code are required.';
    }
}

include '../includes/header.php';
?>
<h2 class="text-2xl font-semibold mb-4">Edit Department</h2>
<?php if (isset($error)): ?>
  <p class="mb-4 rounded-lg border border-red-500/50 bg-red-500/10 px-3 py-2 text-sm text-red-200"><?= h($error) ?></p>
<?php endif; ?>

<div class="max-w-3xl">
  <form method="POST" class="rounded-2xl border border-slate-800/80 bg-slate-950/80 p-6 shadow-xl shadow-slate-950/40 text-sm">
    <div class="space-y-4">
      <div>
        <label for="department_name" class="block text-xs font-medium text-slate-300 mb-1">Department name</label>
        <input id="department_name" name="department_name" type="text" required
               class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent"
               value="<?= h($dept['department_name']) ?>">
      </div>
      <div>
        <label for="department_code" class="block text-xs font-medium text-slate-300 mb-1">Department code</label>
        <input id="department_code" name="department_code" type="text" maxlength="10" required
               class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent"
               value="<?= h($dept['department_code']) ?>">
      </div>
      <div>
        <label for="description" class="block text-xs font-medium text-slate-300 mb-1">Description</label>
        <textarea id="description" name="description" rows="3"
                  class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent"><?= h($dept['description'] ?? '') ?></textarea>
      </div>
    </div>
    <div class="mt-5 flex flex-wrap gap-3">
      <button type="submit"
              class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-500 via-cyan-400 to-emerald-400 px-5 py-2.5 text-sm font-semibold text-slate-950 shadow-lg shadow-blue-500/40 hover:shadow-blue-400/60 hover:translate-y-[1px] transition-all">
        Update Department
      </button>
      <a href="<?= BASE_PATH ?>/pages/departments.php" class="inline-flex items-center justify-center rounded-xl border border-slate-700 px-5 py-2.5 text-sm font-medium text-slate-200 hover:border-slate-400 hover:text-white transition-colors">
        Cancel
      </a>
    </div>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
