<?php 
require_once '../includes/header.php'; 
require_role(['Admin', 'Manager', 'Employee']);
require_once '../config/db.php';

// Fetch today's attendance
$today = date('Y-m-d');
$attendance_today = $pdo->prepare("
    SELECT a.*, CONCAT(e.first_name, ' ', e.last_name) as employee_name, d.department_name
    FROM attendance a 
    JOIN employees e ON a.employee_id = e.employee_id 
    JOIN departments d ON e.department_id = d.department_id 
    WHERE a.date = ? 
    ORDER BY a.check_in DESC
");
$attendance_today->execute([$today]);
$attendance_records = $attendance_today->fetchAll();

// Handle check-in/check-out
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['check_in'])) {
        $stmt = $pdo->prepare("INSERT INTO attendance (employee_id, date, check_in, status) VALUES (?, ?, NOW(), 'Present') 
                              ON DUPLICATE KEY UPDATE check_in = VALUES(check_in), status = 'Present'");
        $stmt->execute([$_SESSION['employee_id'], $today]);
        redirect('/pages/attendance.php');
    } elseif (isset($_POST['check_out'])) {
        $stmt = $pdo->prepare("UPDATE attendance SET check_out = NOW(), total_hours = TIMESTAMPDIFF(HOUR, check_in, NOW()) WHERE employee_id = ? AND date = ?");
        $stmt->execute([$_SESSION['employee_id'], $today]);
        redirect('/pages/attendance.php');
    }
}
?>

<h2 class="text-2xl font-semibold mb-2">Attendance</h2>
<p class="text-sm text-slate-300 mb-4">Check in/out for today and view who is present.</p>

<div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-5 mb-6 text-sm text-slate-200">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
      <h3 class="text-sm font-semibold">Today's attendance</h3>
      <p class="text-xs text-slate-400"><?= h(date('F j, Y')) ?></p>
    </div>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Employee'): ?>
      <div class="flex flex-wrap gap-3">
        <form method="POST">
          <button type="submit" name="check_in"
                  class="inline-flex items-center justify-center rounded-xl bg-emerald-500 px-4 py-2 text-xs font-semibold text-slate-950 shadow-md hover:bg-emerald-400 transition">
            Check in
          </button>
        </form>
        <form method="POST">
          <button type="submit" name="check_out"
                  class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-4 py-2 text-xs font-semibold text-slate-950 shadow-md hover:bg-amber-400 transition">
            Check out
          </button>
        </form>
      </div>
    <?php endif; ?>
  </div>
</div>

<div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-5 text-sm text-slate-200">
  <h3 class="text-sm font-semibold mb-3">Today's records</h3>
  <div class="overflow-x-auto">
    <table class="min-w-full text-xs text-left border border-slate-800/80 bg-slate-950/60 rounded-xl overflow-hidden">
      <thead class="bg-slate-900/90">
        <tr>
          <th class="px-4 py-2 font-semibold text-slate-400 uppercase tracking-wider">Employee</th>
          <th class="px-4 py-2 font-semibold text-slate-400 uppercase tracking-wider">Department</th>
          <th class="px-4 py-2 font-semibold text-slate-400 uppercase tracking-wider">Check in</th>
          <th class="px-4 py-2 font-semibold text-slate-400 uppercase tracking-wider">Check out</th>
          <th class="px-4 py-2 font-semibold text-slate-400 uppercase tracking-wider">Total hours</th>
          <th class="px-4 py-2 font-semibold text-slate-400 uppercase tracking-wider">Status</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-800/80">
        <?php if (!$attendance_records): ?>
          <tr>
            <td colspan="6" class="px-4 py-3 text-center text-slate-400">No attendance records for today.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($attendance_records as $record): ?>
          <tr class="hover:bg-slate-900/80 transition-colors">
            <td class="px-4 py-2 text-slate-200"><?= h($record['employee_name']) ?></td>
            <td class="px-4 py-2 text-slate-300"><?= h($record['department_name']) ?></td>
            <td class="px-4 py-2 text-slate-300"><?= $record['check_in'] ? h($record['check_in']) : 'Not checked in' ?></td>
            <td class="px-4 py-2 text-slate-300"><?= $record['check_out'] ? h($record['check_out']) : 'Not checked out' ?></td>
            <td class="px-4 py-2 text-slate-300"><?= $record['total_hours'] !== null ? h($record['total_hours']) : '0' ?></td>
            <td class="px-4 py-2">
              <?php 
                $status = $record['status'];
                $badgeClass = $status === 'Present' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/60'
                            : ($status === 'Late' ? 'bg-amber-500/20 text-amber-300 border-amber-500/60'
                            : 'bg-rose-500/20 text-rose-300 border-rose-500/60');
              ?>
              <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-[11px] font-medium <?= $badgeClass ?>">
                <?= h($status) ?>
              </span>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once '../includes/footer.php'; ?>
