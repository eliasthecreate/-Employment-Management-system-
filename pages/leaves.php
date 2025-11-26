<?php 
require_once '../includes/header.php'; 
require_role(['Admin', 'Manager', 'Employee']);
require_once '../config/db.php';

// Handle leave application
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_leave'])) {
    $leave_type = $_POST['leave_type'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date   = $_POST['end_date'] ?? '';
    $reason     = trim($_POST['reason'] ?? '');

    if ($leave_type && $start_date && $end_date && $reason) {
        try {
            $start = new DateTime($start_date);
            $end   = new DateTime($end_date);
            $total_days = $start->diff($end)->days + 1; // inclusive

            $stmt = $pdo->prepare("INSERT INTO leaves (employee_id, leave_type, start_date, end_date, total_days, reason) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$_SESSION['employee_id'], $leave_type, $start_date, $end_date, $total_days, $reason])) {
                $success = "Leave application submitted successfully!";
            } else {
                $error = "Failed to submit leave application.";
            }
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "All fields are required.";
    }
}

// Fetch user's leave applications
$leaves = $pdo->prepare("SELECT l.*, CONCAT(e.first_name, ' ', e.last_name) as approved_by_name 
                        FROM leaves l 
                        LEFT JOIN employees e ON l.approved_by = e.employee_id 
                        WHERE l.employee_id = ? 
                        ORDER BY l.applied_date DESC");
$leaves->execute([$_SESSION['employee_id']]);
$leave_applications = $leaves->fetchAll();
?>

<h2 class="text-2xl font-semibold mb-4">Leaves</h2>
<p class="text-sm text-slate-300 mb-4">Apply for leave and review your recent applications.</p>

<?php if (isset($success)): ?>
  <p class="mb-4 rounded-lg border border-emerald-500/50 bg-emerald-500/10 px-3 py-2 text-sm text-emerald-200"><?= h($success) ?></p>
<?php endif; ?>
<?php if (isset($error)): ?>
  <p class="mb-4 rounded-lg border border-red-500/50 bg-red-500/10 px-3 py-2 text-sm text-red-200"><?= h($error) ?></p>
<?php endif; ?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-5 text-sm text-slate-200">
    <h3 class="text-sm font-semibold mb-3">Apply for leave</h3>
    <form method="POST" class="space-y-4">
      <div>
        <label for="leave_type" class="block text-xs font-medium text-slate-300 mb-1">Leave type</label>
        <select id="leave_type" name="leave_type" required
                class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent">
          <option value="Sick">Sick Leave</option>
          <option value="Vacation">Vacation</option>
          <option value="Personal">Personal</option>
          <option value="Maternity">Maternity</option>
          <option value="Paternity">Paternity</option>
          <option value="Bereavement">Bereavement</option>
          <option value="Other">Other</option>
        </select>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="start_date" class="block text-xs font-medium text-slate-300 mb-1">Start date</label>
          <input type="date" id="start_date" name="start_date" required
                 class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent">
        </div>
        <div>
          <label for="end_date" class="block text-xs font-medium text-slate-300 mb-1">End date</label>
          <input type="date" id="end_date" name="end_date" required
                 class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent">
        </div>
      </div>
      <div>
        <label for="reason" class="block text-xs font-medium text-slate-300 mb-1">Reason</label>
        <textarea id="reason" name="reason" rows="3" required
                  class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent"></textarea>
      </div>
      <button type="submit" name="apply_leave"
              class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-500 via-cyan-400 to-emerald-400 px-4 py-2.5 text-sm font-semibold text-slate-950 shadow-lg shadow-blue-500/40 hover:shadow-blue-400/60 hover:translate-y-[1px] transition-all">
        Apply for leave
      </button>
    </form>
  </div>

  <div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-5 text-sm text-slate-200">
    <h3 class="text-sm font-semibold mb-3">My leave applications</h3>
    <?php if (!$leave_applications): ?>
      <p class="text-xs text-slate-400">You haven't applied for any leave yet.</p>
    <?php else: ?>
      <div class="overflow-x-auto">
        <table class="min-w-full text-xs text-left border border-slate-800/80 bg-slate-950/60 rounded-xl overflow-hidden">
          <thead class="bg-slate-900/90">
            <tr>
              <th class="px-4 py-2 font-semibold text-slate-400 uppercase tracking-wider">Type</th>
              <th class="px-4 py-2 font-semibold text-slate-400 uppercase tracking-wider">Start</th>
              <th class="px-4 py-2 font-semibold text-slate-400 uppercase tracking-wider">End</th>
              <th class="px-4 py-2 font-semibold text-slate-400 uppercase tracking-wider">Days</th>
              <th class="px-4 py-2 font-semibold text-slate-400 uppercase tracking-wider">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/80">
            <?php foreach ($leave_applications as $leave): ?>
            <tr class="hover:bg-slate-900/80 transition-colors">
              <td class="px-4 py-2 text-slate-200"><?= h($leave['leave_type']) ?></td>
              <td class="px-4 py-2 text-slate-300"><?= h($leave['start_date']) ?></td>
              <td class="px-4 py-2 text-slate-300"><?= h($leave['end_date']) ?></td>
              <td class="px-4 py-2 text-slate-300"><?= h($leave['total_days']) ?></td>
              <td class="px-4 py-2">
                <?php 
                  $status = $leave['status'];
                  $badgeClass = $status === 'Approved' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/60'
                              : ($status === 'Pending' ? 'bg-amber-500/20 text-amber-300 border-amber-500/60'
                              : 'bg-rose-500/20 text-rose-300 border-rose-500/60');
                ?>
                <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-[11px] font-medium <?= $badgeClass ?>">
                  <?= h($status) ?>
                </span>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php require_once '../includes/footer.php'; ?>
