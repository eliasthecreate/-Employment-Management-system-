<?php
// index.php
require_once 'includes/functions.php';

// CORRECT BASE PATH
$base = '/employee_management';  // ← MUST MATCH FOLDER

$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);
$path = str_replace($base, '', $path);
$path = ltrim($path, '/');
$path = preg_replace('/\.php$/', '', $path);

// Public landing page directly in index.php
if ($path === '' || $path === 'index') {
    if (is_logged_in()) {
        redirect('/pages/dashboard.php');
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Employee Management System - Modern HR Platform</title>
      <script src="https://cdn.tailwindcss.com"></script>
      <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/style.css">
    </head>
    <body class="bg-slate-950 text-slate-50 font-sans">
      <div class="min-h-screen flex flex-col">
        <header class="border-b border-slate-800/80 bg-slate-950/80 backdrop-blur">
          <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-blue-500 via-cyan-400 to-emerald-400 flex items-center justify-center text-slate-950 font-bold text-lg shadow-lg shadow-blue-500/40">
                EMS
              </div>
              <div>
                <div class="font-semibold tracking-tight">Employee Management</div>
                <div class="text-xs text-slate-400">Modern HR & workforce platform</div>
              </div>
            </div>
            <nav class="hidden md:flex items-center gap-6 text-sm text-slate-300">
              <a href="#features" class="hover:text-white transition-colors">Features</a>
              <a href="#analytics" class="hover:text-white transition-colors">Analytics</a>
              <a href="#security" class="hover:text-white transition-colors">Security</a>
              <a href="#cta" class="hover:text-white transition-colors">Get started</a>
            </nav>
            <div class="flex items-center gap-3">
              <a href="<?= BASE_PATH ?>/pages/login.php" class="hidden sm:inline-flex px-3 py-1.5 text-sm rounded-lg border border-slate-700/80 hover:border-slate-400/80 text-slate-200 hover:text-white transition-colors">Sign in</a>
              <a href="<?= BASE_PATH ?>/pages/login.php" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-blue-500 via-cyan-400 to-emerald-400 text-slate-950 font-semibold text-sm shadow-lg shadow-blue-500/40 hover:shadow-blue-400/60 hover:translate-y-[1px] transition-all">
                Launch dashboard
                <span class="text-lg">→</span>
              </a>
            </div>
          </div>
        </header>

        <main class="flex-1">
          <!-- Hero -->
          <section class="relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(56,189,248,0.18),_transparent_60%),_radial-gradient(circle_at_bottom,_rgba(59,130,246,0.14),_transparent_55%)] pointer-events-none"></div>
            <div class="max-w-6xl mx-auto px-4 pt-16 pb-20 relative z-10 grid md:grid-cols-[minmax(0,1.2fr)_minmax(0,1fr)] gap-12 items-center">
              <div>
                <span class="inline-flex items-center gap-2 text-xs font-medium px-3 py-1 rounded-full border border-emerald-400/40 bg-emerald-400/10 text-emerald-200 mb-5">
                  <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                  Live workforce visibility
                </span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-semibold tracking-tight mb-4">
                  Run your entire team
                  <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-300 to-emerald-300">from a single modern dashboard.</span>
                </h1>
                <p class="text-sm sm:text-base text-slate-300/90 max-w-xl mb-6">
                  Centralize employees, departments, attendance, leaves, payroll, and performance in one intuitive system.
                  Designed for growing teams that need clarity, not spreadsheets.
                </p>
                <div class="flex flex-wrap items-center gap-3 mb-7">
                  <a href="<?= BASE_PATH ?>/pages/login.php" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-500 via-cyan-400 to-emerald-400 text-slate-950 font-semibold text-sm shadow-lg shadow-blue-500/40 hover:shadow-blue-400/60 hover:translate-y-[1px] transition-all">
                    Get started now
                    <span class="text-lg">→</span>
                  </a>
                  <a href="#features" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border border-slate-700/80 text-slate-200 text-sm hover:border-slate-400/80 hover:text-white transition-colors">
                    Explore features
                  </a>
                </div>
                <div class="flex flex-wrap items-center gap-6 text-xs text-slate-400">
                  <div class="flex items-center gap-2">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-400/10 text-emerald-300 text-sm">✓</span>
                    <span>Role-based access for Admins, Managers & HR</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-500/10 text-blue-300 text-sm">✓</span>
                    <span>Secure, on-premise friendly PHP stack</span>
                  </div>
                </div>
              </div>
              <div>
                <div class="relative">
                  <div class="absolute -inset-4 bg-gradient-to-tr from-blue-500/30 via-cyan-400/10 to-emerald-400/0 blur-2xl opacity-70"></div>
                  <div class="relative rounded-2xl border border-slate-700/70 bg-slate-900/70 backdrop-blur-sm shadow-2xl shadow-blue-900/40 overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-2 border-b border-slate-800/80 bg-slate-900/80">
                      <div class="flex items-center gap-1.5">
                        <span class="h-2.5 w-2.5 rounded-full bg-rose-400"></span>
                        <span class="h-2.5 w-2.5 rounded-full bg-amber-300"></span>
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                      </div>
                      <span class="text-[11px] text-slate-400">Dashboard · Today</span>
                    </div>
                    <div class="p-4 sm:p-5 space-y-4 text-[11px] sm:text-xs text-slate-200">
                      <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-xl border border-slate-700/80 bg-slate-900/80 p-3 space-y-1.5">
                          <div class="flex items-center justify-between">
                            <span class="text-[11px] text-slate-400">Active employees</span>
                            <span class="inline-flex px-1.5 py-0.5 rounded-full bg-emerald-500/10 text-[10px] text-emerald-300">+12%</span>
                          </div>
                          <div class="text-lg font-semibold">128</div>
                          <div class="h-8 rounded-lg bg-gradient-to-r from-emerald-500/30 via-cyan-400/20 to-blue-500/10"></div>
                        </div>
                        <div class="rounded-xl border border-slate-700/80 bg-slate-900/80 p-3 space-y-1.5">
                          <div class="flex items-center justify-between">
                            <span class="text-[11px] text-slate-400">Attendance today</span>
                            <span class="inline-flex px-1.5 py-0.5 rounded-full bg-blue-500/10 text-[10px] text-blue-300">96%</span>
                          </div>
                          <div class="flex items-end gap-1">
                            <span class="text-lg font-semibold">115</span>
                            <span class="text-[11px] text-slate-400">present</span>
                          </div>
                          <div class="flex gap-1.5 mt-1.5">
                            <div class="flex-1 h-1.5 rounded-full bg-emerald-400/70"></div>
                            <div class="flex-1 h-1.5 rounded-full bg-emerald-400/40"></div>
                            <div class="flex-1 h-1.5 rounded-full bg-slate-600"></div>
                          </div>
                        </div>
                      </div>
                      <div class="grid grid-cols-[minmax(0,1.3fr)_minmax(0,1fr)] gap-3">
                        <div class="rounded-xl border border-slate-700/80 bg-slate-900/80 p-3">
                          <div class="flex items-center justify-between mb-2">
                            <span class="text-[11px] text-slate-400">Department overview</span>
                            <span class="text-[10px] text-slate-500">This week</span>
                          </div>
                          <div class="grid grid-cols-3 gap-2 text-[10px]">
                            <div>
                              <div class="text-slate-400 mb-0.5">Engineering</div>
                              <div class="font-semibold">42</div>
                              <div class="h-1.5 rounded-full bg-cyan-400/80 mt-1"></div>
                            </div>
                            <div>
                              <div class="text-slate-400 mb-0.5">Operations</div>
                              <div class="font-semibold">31</div>
                              <div class="h-1.5 rounded-full bg-emerald-400/80 mt-1"></div>
                            </div>
                            <div>
                              <div class="text-slate-400 mb-0.5">HR & Finance</div>
                              <div class="font-semibold">19</div>
                              <div class="h-1.5 rounded-full bg-blue-400/80 mt-1"></div>
                            </div>
                          </div>
                        </div>
                        <div class="rounded-xl border border-slate-700/80 bg-slate-900/80 p-3 flex flex-col justify-between">
                          <div>
                            <div class="text-[11px] text-slate-400 mb-1">Upcoming leave</div>
                            <div class="text-[11px] flex flex-col gap-0.5">
                              <div class="flex items-center justify-between">
                                <span>Sarah • Design</span>
                                <span class="text-slate-400">Tomorrow</span>
                              </div>
                              <div class="flex items-center justify-between">
                                <span>Omar • Backend</span>
                                <span class="text-slate-400">Fri</span>
                              </div>
                            </div>
                          </div>
                          <div class="mt-3 text-[10px] text-emerald-300 flex items-center justify-between">
                            <span>Payroll ready • 100% synced</span>
                            <span class="h-1.5 w-16 rounded-full bg-gradient-to-r from-emerald-400 to-cyan-400"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- Features -->
          <section id="features" class="border-t border-slate-800/80 bg-slate-950/80">
            <div class="max-w-6xl mx-auto px-4 py-12">
              <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
                <div>
                  <h2 class="text-xl sm:text-2xl font-semibold tracking-tight mb-2">Everything HR needs in one place</h2>
                  <p class="text-sm text-slate-300 max-w-xl">
                    Replace disconnected spreadsheets with a single system designed for people operations.
                    Built on PHP/MySQL so it fits seamlessly into existing environments.
                  </p>
                </div>
                <div class="flex flex-wrap gap-2 text-[11px] text-slate-400">
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full border border-slate-700/80 bg-slate-900/60">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                    Self-hosted ready
                  </span>
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full border border-slate-700/80 bg-slate-900/60">
                    Role-based permissions
                  </span>
                </div>
              </div>
              <div class="grid md:grid-cols-3 gap-5">
                <div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-4 flex flex-col gap-2">
                  <div class="h-9 w-9 rounded-xl bg-blue-500/15 text-blue-300 flex items-center justify-center text-lg">👥</div>
                  <h3 class="font-semibold text-sm">Smart employee directory</h3>
                  <p class="text-xs text-slate-300">
                    Centralize records, contact details, roles, and departments. Search and filter employees in seconds.
                  </p>
                  <ul class="mt-1.5 space-y-1 text-[11px] text-slate-400">
                    <li>• Role & department mapping</li>
                    <li>• Employment status & history</li>
                  </ul>
                </div>
                <div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-4 flex flex-col gap-2">
                  <div class="h-9 w-9 rounded-xl bg-emerald-500/15 text-emerald-300 flex items-center justify-center text-lg">⏱</div>
                  <h3 class="font-semibold text-sm">Attendance & leave automation</h3>
                  <p class="text-xs text-slate-300">
                    Track daily attendance, manage leave requests, and keep managers in sync with team capacity.
                  </p>
                  <ul class="mt-1.5 space-y-1 text-[11px] text-slate-400">
                    <li>• Real-time presence overview</li>
                    <li>• Leave approvals & history</li>
                  </ul>
                </div>
                <div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-4 flex flex-col gap-2">
                  <div class="h-9 w-9 rounded-xl bg-cyan-500/15 text-cyan-300 flex items-center justify-center text-lg">💰</div>
                  <h3 class="font-semibold text-sm">Payroll & performance</h3>
                  <p class="text-xs text-slate-300">
                    Keep payroll aligned with attendance and performance so payouts are accurate and on time.
                  </p>
                  <ul class="mt-1.5 space-y-1 text-[11px] text-slate-400">
                    <li>• Payroll-ready summaries</li>
                    <li>• Performance tracking</li>
                  </ul>
                </div>
              </div>
            </div>
          </section>

          <!-- Analytics -->
          <section id="analytics" class="border-t border-slate-800/80 bg-gradient-to-b from-slate-950 via-slate-950 to-slate-950">
            <div class="max-w-6xl mx-auto px-4 py-12 grid md:grid-cols-[minmax(0,1.1fr)_minmax(0,1fr)] gap-10 items-center">
              <div>
                <h2 class="text-xl sm:text-2xl font-semibold tracking-tight mb-3">Real-time workforce analytics</h2>
                <p class="text-sm text-slate-300 mb-4">
                  See who is in, who is out, and where capacity is stretched — before it becomes a problem.
                </p>
                <ul class="space-y-2.5 text-sm text-slate-300">
                  <li class="flex gap-3">
                    <span class="mt-1 h-5 w-5 rounded-full bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-xs">1</span>
                    <span><strong class="font-medium">Instant visibility</strong> into attendance, leaves, and utilization across departments.</span>
                  </li>
                  <li class="flex gap-3">
                    <span class="mt-1 h-5 w-5 rounded-full bg-cyan-500/20 text-cyan-300 flex items-center justify-center text-xs">2</span>
                    <span><strong class="font-medium">Manager-ready views</strong> for managing teams, approvals, and workloads.</span>
                  </li>
                  <li class="flex gap-3">
                    <span class="mt-1 h-5 w-5 rounded-full bg-blue-500/20 text-blue-300 flex items-center justify-center text-xs">3</span>
                    <span><strong class="font-medium">Audit-friendly history</strong> for attendance, leave, and payroll-related changes.</span>
                  </li>
                </ul>
              </div>
              <div class="rounded-2xl border border-slate-800/80 bg-slate-950/80 p-4 sm:p-5 shadow-2xl shadow-blue-950/40">
                <div class="flex items-center justify-between mb-3">
                  <span class="text-xs text-slate-400">Today's snapshot</span>
                  <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-500/10 text-[11px] text-emerald-300">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                    Healthy workforce
                  </span>
                </div>
                <div class="grid grid-cols-3 gap-3 text-xs text-slate-200 mb-4">
                  <div class="rounded-xl bg-slate-900/80 border border-slate-800/80 p-2.5">
                    <div class="text-[11px] text-slate-400 mb-0.5">Present</div>
                    <div class="text-lg font-semibold">115</div>
                    <div class="mt-1 h-1.5 rounded-full bg-emerald-400/80"></div>
                  </div>
                  <div class="rounded-xl bg-slate-900/80 border border-slate-800/80 p-2.5">
                    <div class="text-[11px] text-slate-400 mb-0.5">On leave</div>
                    <div class="text-lg font-semibold">7</div>
                    <div class="mt-1 h-1.5 rounded-full bg-amber-400/80"></div>
                  </div>
                  <div class="rounded-xl bg-slate-900/80 border border-slate-800/80 p-2.5">
                    <div class="text-[11px] text-slate-400 mb-0.5">Late / absent</div>
                    <div class="text-lg font-semibold">6</div>
                    <div class="mt-1 h-1.5 rounded-full bg-rose-400/80"></div>
                  </div>
                </div>
                <div class="text-[11px] text-slate-400 flex items-center justify-between">
                  <span>Data powered by your live EMS instance.</span>
                  <a href="<?= BASE_PATH ?>/pages/login.php" class="text-emerald-300 hover:text-emerald-200">Open dashboard →</a>
                </div>
              </div>
            </div>
          </section>

          <!-- Security -->
          <section id="security" class="border-t border-slate-800/80 bg-slate-950">
            <div class="max-w-6xl mx-auto px-4 py-10 grid md:grid-cols-2 gap-8 items-center">
              <div>
                <h2 class="text-xl sm:text-2xl font-semibold tracking-tight mb-3">Built for secure, compliant teams</h2>
                <p class="text-sm text-slate-300 mb-4">
                  Keep sensitive employee data protected while staying in full control of where your system runs.
                </p>
                <ul class="space-y-2.5 text-sm text-slate-300">
                  <li class="flex gap-2">
                    <span class="mt-1 h-4 w-4 rounded-full bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-[10px]">✓</span>
                    <span>Role-based access for Admin, Manager, and HR users.</span>
                  </li>
                  <li class="flex gap-2">
                    <span class="mt-1 h-4 w-4 rounded-full bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-[10px]">✓</span>
                    <span>Session-based authentication using PHP, ready for on-premise setups.</span>
                  </li>
                  <li class="flex gap-2">
                    <span class="mt-1 h-4 w-4 rounded-full bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-[10px]">✓</span>
                    <span>MySQL-backed data for easy backup and integration with existing tools.</span>
                  </li>
                </ul>
              </div>
              <div class="rounded-2xl border border-emerald-500/40 bg-gradient-to-br from-emerald-500/10 via-slate-900 to-slate-950 p-4 sm:p-5">
                <div class="flex items-center justify-between mb-3">
                  <span class="inline-flex items-center gap-2 text-xs text-emerald-200">
                    <span class="h-6 w-6 rounded-full bg-emerald-500/20 flex items-center justify-center text-sm">🔒</span>
                    Security status
                  </span>
                  <span class="text-[11px] text-emerald-300">All systems normal</span>
                </div>
                <div class="space-y-2 text-[11px] text-slate-100">
                  <div class="flex items-center justify-between">
                    <span>Authentication</span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-200">
                      Active
                    </span>
                  </div>
                  <div class="flex items-center justify-between">
                    <span>Role enforcement</span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-200">
                      Enabled
                    </span>
                  </div>
                  <div class="flex items-center justify-between">
                    <span>Data residency</span>
                    <span class="text-slate-200">Your server • Your rules</span>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- CTA -->
          <section id="cta" class="border-t border-slate-800/80 bg-slate-950">
            <div class="max-w-6xl mx-auto px-4 py-10 flex flex-col md:flex-row gap-5 items-center justify-between">
              <div>
                <h2 class="text-xl sm:text-2xl font-semibold tracking-tight mb-2">Ready to see your team in one view?</h2>
                <p class="text-sm text-slate-300 max-w-xl">
                  Log in, add your first employees, and start managing attendance, leaves, and payroll from a single source of truth.
                </p>
              </div>
              <div class="flex flex-wrap items-center gap-3">
                <a href="<?= BASE_PATH ?>/pages/login.php" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-500 via-cyan-400 to-emerald-400 text-slate-950 font-semibold text-sm shadow-lg shadow-blue-500/40 hover:shadow-blue-400/60 hover:translate-y-[1px] transition-all">
                  Go to login
                  <span class="text-lg">→</span>
                </a>
                <span class="text-[11px] text-slate-400">No long setup. Use your existing PHP/MySQL stack.</span>
              </div>
            </div>
          </section>
        </main>

        <footer class="border-t border-slate-800/80 bg-slate-950 text-[11px] text-slate-500">
          <div class="max-w-6xl mx-auto px-4 py-4 flex flex-col sm:flex-row gap-2 items-center justify-between">
            <span>© <?= date('Y') ?> Employee Management System.</span>
            <span class="text-slate-500">Built for modern HR and operations teams.</span>
          </div>
        </footer>
      </div>
    </body>
    </html>
    <?php
    exit;
}

$pages = [
    'login' => 'pages/login.php',
    'dashboard' => 'pages/dashboard.php',
    'employees' => 'pages/employees.php',
    'departments' => 'pages/departments.php',
    'attendance' => 'pages/attendance.php',
    'leaves' => 'pages/leaves.php',
    'payroll' => 'pages/payroll.php',
    'performance' => 'pages/performance.php',
    'projects' => 'pages/projects.php',
    'logout' => 'logout.php',
];

if (isset($pages[$path])) {
    if ($path === 'logout') {
        require $pages[$path];
    } elseif ($path === '' || $path === 'login') {
        if (is_logged_in()) {
            redirect('/pages/dashboard.php');
        } else {
            require $pages[$path];
        }
    } else {
        require_login();
        require $pages[$path];
    }
} else {
    http_response_code(404);
    echo "<h1>404 - Page Not Found</h1>";
    echo "<p>Requested: " . h($request) . "</p>";
}