<?php 
require_once '../includes/header.php'; 
require_role(['Admin', 'Manager', 'Employee']);
require_once '../config/db.php';

// Get real statistics
$total_employees = $pdo->query("SELECT COUNT(*) FROM employees WHERE is_active = 1")->fetchColumn();
$pending_leaves = $pdo->query("SELECT COUNT(*) FROM leaves WHERE status = 'Pending'")->fetchColumn();

$today = date('Y-m-d');
$today_attendance = $pdo->prepare("SELECT COUNT(*) FROM attendance WHERE date = ?");
$today_attendance->execute([$today]);
$attendance_count = $today_attendance->fetchColumn();

// Department statistics (ready for future use)
$dept_stats = $pdo->query("
    SELECT d.department_name, COUNT(e.employee_id) as employee_count 
    FROM departments d 
    LEFT JOIN employees e ON d.department_id = e.department_id AND e.is_active = 1 
    GROUP BY d.department_id, d.department_name 
    ORDER BY employee_count DESC
")->fetchAll();
?>
<h2 class="text-3xl font-bold mb-6">Welcome, <?= h($_SESSION['name']) ?>!</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
  <div class="bg-slate-900/80 border border-slate-800/80 p-6 rounded-2xl shadow-lg">
    <h3 class="text-sm font-semibold text-slate-300">Total Employees</h3>
    <p class="text-3xl font-bold text-emerald-300 mt-2"><?= (int)$total_employees ?></p>
  </div>
  <div class="bg-slate-900/80 border border-slate-800/80 p-6 rounded-2xl shadow-lg">
    <h3 class="text-sm font-semibold text-slate-300">Pending Leaves</h3>
    <p class="text-3xl font-bold text-amber-300 mt-2"><?= (int)$pending_leaves ?></p>
  </div>
  <div class="bg-slate-900/80 border border-slate-800/80 p-6 rounded-2xl shadow-lg">
    <h3 class="text-sm font-semibold text-slate-300">Today's Attendance</h3>
    <p class="text-3xl font-bold text-cyan-300 mt-2"><?= (int)$attendance_count ?></p>
  </div>
</div>

<?php if (has_role(['Admin', 'Manager'])): ?>
  <h3 class="text-xl font-bold mb-4">Quick Actions</h3>
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <a href="employees.php" class="bg-blue-600 text-white p-4 rounded text-center hover:bg-blue-700">Manage Employees</a>
    <a href="departments.php" class="bg-indigo-600 text-white p-4 rounded text-center hover:bg-indigo-700">Departments</a>
    <a href="leaves.php" class="bg-yellow-600 text-white p-4 rounded text-center hover:bg-yellow-700">Review Leaves</a>
    <a href="payroll.php" class="bg-green-600 text-white p-4 rounded text-center hover:bg-green-700">Run Payroll</a>
  </div>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>