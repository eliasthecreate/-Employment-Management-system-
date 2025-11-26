<?php require_once '../includes/functions.php'; 
if (is_logged_in()) redirect('/pages/dashboard.php');
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username && $password) {
        require_once '../config/db.php';
        $stmt = $pdo->prepare("SELECT u.*, e.first_name, e.last_name FROM users u JOIN employees e ON u.employee_id = e.employee_id WHERE u.username = ? AND u.is_active = 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['employee_id'] = $user['employee_id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['first_name'] . ' ' . $user['last_name'];
            redirect('/pages/dashboard.php');
        } else {
            $message = "Invalid credentials.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - EMS</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-50 min-h-screen flex items-center justify-center">
  <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(56,189,248,0.2),_transparent_60%),_radial-gradient(circle_at_bottom,_rgba(59,130,246,0.18),_transparent_55%)] pointer-events-none"></div>
  <div class="relative z-10 w-full max-w-md px-4">
    <div class="mb-6 flex flex-col items-center gap-2">
      <div class="h-11 w-11 rounded-2xl bg-gradient-to-br from-blue-500 via-cyan-400 to-emerald-400 flex items-center justify-center text-slate-950 font-bold text-xl shadow-lg shadow-blue-500/40">
        EMS
      </div>
      <div class="text-center">
        <h1 class="text-xl font-semibold tracking-tight">Sign in to Employee Management</h1>
        <p class="text-xs text-slate-400 mt-1">Access your team dashboard, attendance, and payroll in one place.</p>
      </div>
    </div>
    <div class="rounded-2xl border border-slate-800/80 bg-slate-950/80 backdrop-blur-sm shadow-2xl shadow-blue-950/40 p-6">
      <h2 class="text-lg font-semibold mb-4">Welcome back</h2>
      <?php if ($message): ?>
        <p class="mb-4 rounded-lg border border-red-500/50 bg-red-500/10 px-3 py-2 text-sm text-red-200 text-center">
          <?= h($message) ?>
        </p>
      <?php endif; ?>
      <form method="POST" action="" class="space-y-4">
        <div>
          <label class="block text-xs font-medium text-slate-300 mb-1">Username</label>
          <input id="login-username" type="text" name="username" required
                 class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent" />
        </div>
        <div>
          <label class="block text-xs font-medium text-slate-300 mb-1">Password</label>
          <input id="login-password" type="password" name="password" required
                 class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent" />
        </div>
        <button type="submit"
                class="w-full inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-500 via-cyan-400 to-emerald-400 px-4 py-2.5 text-sm font-semibold text-slate-950 shadow-lg shadow-blue-500/40 hover:shadow-blue-400/60 hover:translate-y-[1px] transition-all">
          Sign in
        </button>
      </form>
      <p class="text-center text-[11px] text-slate-400 mt-4">
        Quick demo:
        <button type="button" id="demo-fill" class="font-semibold text-cyan-300 hover:text-cyan-200 underline-offset-2 hover:underline">
          Fill demo credentials
        </button>
      </p>
    </div>
    <p class="mt-4 text-center text-[11px] text-slate-500">
      Use the demo account to explore the dashboard. You can change data safely inside your local environment.
    </p>
  </div>

  <script>
    (function() {
      var btn = document.getElementById('demo-fill');
      if (!btn) return;
      btn.addEventListener('click', function () {
        var u = document.getElementById('login-username');
        var p = document.getElementById('login-password');
        if (u) u.value = 'john.smith';
        if (p) p.value = 'password';
        if (u) u.focus();
      });
    })();
  </script>
</body>
</html>