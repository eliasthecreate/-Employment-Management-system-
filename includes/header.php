<?php require_once __DIR__ . '/functions.php'; require_login(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Employee Management System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/style.css">
</head>
<body class="bg-slate-950 text-slate-50 font-sans">
  <div class="min-h-screen flex flex-col bg-[radial-gradient(circle_at_top,_rgba(56,189,248,0.18),_transparent_60%),_radial-gradient(circle_at_bottom,_rgba(59,130,246,0.14),_transparent_55%)]">
    <header class="border-b border-slate-800/80 bg-slate-950/80 backdrop-blur">
      <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-blue-500 via-cyan-400 to-emerald-400 flex items-center justify-center text-slate-950 font-bold text-lg shadow-lg shadow-blue-500/40">
            EMS
          </div>
          <div>
            <div class="font-semibold tracking-tight">Employee Management</div>
            <div class="text-xs text-slate-400">Team operations dashboard</div>
          </div>
        </div>
        <nav class="hidden md:flex items-center gap-5 text-sm text-slate-300">
          <a href="<?= BASE_PATH ?>/pages/dashboard.php" class="hover:text-white transition-colors">Dashboard</a>
          <?php if (has_role(['Admin', 'Manager'])): ?>
            <a href="<?= BASE_PATH ?>/pages/employees.php" class="hover:text-white transition-colors">Employees</a>
            <a href="<?= BASE_PATH ?>/pages/departments.php" class="hover:text-white transition-colors">Departments</a>
            <a href="<?= BASE_PATH ?>/pages/projects.php" class="hover:text-white transition-colors">Projects</a>
          <?php endif; ?>
          <a href="<?= BASE_PATH ?>/pages/attendance.php" class="hover:text-white transition-colors">Attendance</a>
          <a href="<?= BASE_PATH ?>/pages/leaves.php" class="hover:text-white transition-colors">Leaves</a>
          <a href="<?= BASE_PATH ?>/pages/payroll.php" class="hover:text-white transition-colors">Payroll</a>
        </nav>
        <div class="flex items-center gap-3">
          <span class="hidden sm:inline-flex items-center text-xs text-slate-400">
            <?= h($_SESSION['name'] ?? '') ?>
          </span>
          <a href="<?= BASE_PATH ?>/logout.php" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border border-red-400/60 text-xs text-red-100 hover:bg-red-500/10 transition-colors">
            Logout
          </a>
        </div>
      </div>
    </header>
    <main class="flex-1">
      <div class="max-w-6xl mx-auto mt-6 px-4 pb-10">