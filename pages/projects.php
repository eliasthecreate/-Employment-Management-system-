<?php 
require_once '../includes/header.php'; 
require_role(['Admin', 'Manager']);

if (!isset($_SESSION['projects'])) {
    $_SESSION['projects'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? '');
    if ($title !== '') {
        $_SESSION['projects'][] = [
            'title' => $title,
            'description' => $description,
            'image' => $image,
        ];
    }
}

$projects = $_SESSION['projects'];
?>
<h2 class="text-2xl font-semibold mb-4">Projects</h2>
<p class="text-sm text-slate-300 mb-4">Create simple project cards with an image and description. They will stay for this session.</p>
<div class="grid md:grid-cols-[minmax(0,1.1fr)_minmax(0,1.1fr)] gap-6 mb-6">
  <div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-4">
    <h3 class="text-sm font-semibold mb-3">New project</h3>
    <form method="post" class="space-y-3 text-sm">
      <div>
        <label class="block mb-1 text-slate-300">Title</label>
        <input name="title" type="text" required class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm" placeholder="Project name" />
      </div>
      <div>
        <label class="block mb-1 text-slate-300">Image URL</label>
        <input name="image" type="url" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm" placeholder="https://example.com/image.jpg" />
      </div>
      <div>
        <label class="block mb-1 text-slate-300">Description</label>
        <textarea name="description" rows="3" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm" placeholder="Short project summary"></textarea>
      </div>
      <button class="inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-blue-500 via-cyan-400 to-emerald-400 px-4 py-2 text-xs font-semibold text-slate-950">Create project</button>
    </form>
  </div>
  <div class="rounded-2xl border border-slate-800/80 bg-slate-900/80 p-4">
    <h3 class="text-sm font-semibold mb-3">Preview</h3>
    <p class="text-xs text-slate-400 mb-3">Projects you add will appear below in a responsive grid.</p>
    <?php if (!$projects): ?>
      <p class="text-sm text-slate-400">No projects yet. Add one using the form.</p>
    <?php else: ?>
      <div class="grid sm:grid-cols-2 gap-4">
        <?php foreach ($projects as $p): ?>
          <div class="rounded-xl border border-slate-800/80 bg-slate-950/90 overflow-hidden text-sm">
            <?php if (!empty($p['image'])): ?>
              <div class="h-32 w-full bg-slate-900 overflow-hidden">
                <img src="<?= h($p['image']) ?>" alt="<?= h($p['title']) ?>" class="h-full w-full object-cover" />
              </div>
            <?php endif; ?>
            <div class="p-3">
              <h4 class="font-semibold mb-1 text-slate-50"><?= h($p['title']) ?></h4>
              <?php if (!empty($p['description'])): ?>
                <p class="text-xs text-slate-300 mb-1"><?= nl2br(h($p['description'])) ?></p>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>
