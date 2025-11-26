<?php
require_once '../includes/functions.php';
require_role(['Admin', 'Manager']);
require_once '../config/db.php';

$employee_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($employee_id <= 0) {
    redirect('/pages/employees.php');
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = (int)($_POST['employee_id'] ?? 0);
    $first_name  = trim($_POST['first_name'] ?? '');
    $last_name   = trim($_POST['last_name'] ?? '');
    $email       = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $department_id = (int)($_POST['department_id'] ?? 0);
    $position_id   = (int)($_POST['position_id'] ?? 0);
    $salary        = (float)($_POST['salary'] ?? 0);
    $hire_date     = $_POST['hire_date'] ?? '';

    if ($employee_id && $first_name && $last_name && $email && $department_id && $position_id && $salary && $hire_date) {
        try {
            $stmt = $pdo->prepare("UPDATE employees
                                   SET first_name = ?, last_name = ?, email = ?, department_id = ?, position_id = ?, salary = ?, hire_date = ?
                                   WHERE employee_id = ?");
            $stmt->execute([$first_name, $last_name, $email, $department_id, $position_id, $salary, $hire_date, $employee_id]);
            redirect('/pages/employees.php?updated=1');
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    } else {
        $error = 'All fields are required.';
    }
}

// Load employee
$stmt = $pdo->prepare('SELECT * FROM employees WHERE employee_id = ?');
$stmt->execute([$employee_id]);
$employee = $stmt->fetch();

if (!$employee) {
    redirect('/pages/employees.php');
}

// Load departments & positions
$depts = $pdo->query('SELECT * FROM departments')->fetchAll();
$positions = $pdo->query('SELECT * FROM positions')->fetchAll();

include '../includes/header.php';
?>
<h2 class="text-2xl font-semibold mb-4">Edit Employee</h2>
<?php if (isset($error)): ?>
  <p class="mb-4 rounded-lg border border-red-500/50 bg-red-500/10 px-3 py-2 text-sm text-red-200"><?= h($error) ?></p>
<?php endif; ?>

<div class="max-w-3xl">
  <form method="POST" class="rounded-2xl border border-slate-800/80 bg-slate-950/80 p-6 shadow-xl shadow-slate-950/40">
    <input type="hidden" name="employee_id" value="<?= (int)$employee['employee_id'] ?>">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
      <div>
        <label class="block text-xs font-medium text-slate-300 mb-1">First name</label>
        <input type="text" name="first_name" required
               class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent"
               value="<?= h($employee['first_name']) ?>">
      </div>
      <div>
        <label class="block text-xs font-medium text-slate-300 mb-1">Last name</label>
        <input type="text" name="last_name" required
               class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent"
               value="<?= h($employee['last_name']) ?>">
      </div>
      <div class="md:col-span-2">
        <label class="block text-xs font-medium text-slate-300 mb-1">Email</label>
        <input type="email" name="email" required
               class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent"
               value="<?= h($employee['email']) ?>">
      </div>
      <div class="md:col-span-2">
        <label class="block text-xs font-medium text-slate-300 mb-1">Department</label>
        <select name="department_id" required
                class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent">
          <option value="" class="bg-slate-900">Select department</option>
          <?php foreach ($depts as $d): ?>
            <option value="<?= $d['department_id'] ?>" class="bg-slate-900" <?= $d['department_id'] == $employee['department_id'] ? 'selected' : '' ?>>
              <?= h($d['department_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="md:col-span-2">
        <label class="block text-xs font-medium text-slate-300 mb-1">Position</label>
        <select name="position_id" required
                class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent">
          <option value="" class="bg-slate-900">Select position</option>
          <?php foreach ($positions as $p): ?>
            <option value="<?= $p['position_id'] ?>" class="bg-slate-900" <?= $p['position_id'] == $employee['position_id'] ? 'selected' : '' ?>>
              <?= h($p['position_title']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="block text-xs font-medium text-slate-300 mb-1">Salary (Kwacha)</label>
        <input type="number" step="0.01" name="salary" required
               class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent"
               value="<?= h($employee['salary']) ?>">
      </div>
      <div>
        <label class="block text-xs font-medium text-slate-300 mb-1">Hire date</label>
        <input type="date" name="hire_date" required
               class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent"
               value="<?= h($employee['hire_date']) ?>">
      </div>
    </div>
    <button type="submit"
            class="mt-5 inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-500 via-cyan-400 to-emerald-400 px-6 py-2.5 text-sm font-semibold text-slate-950 shadow-lg shadow-blue-500/40 hover:shadow-blue-400/60 hover:translate-y-[1px] transition-all">
      Save Changes
    </button>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
