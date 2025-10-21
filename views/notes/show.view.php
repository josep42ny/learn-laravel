<?php require baseUrl('views/partials/head.php'); ?>
<?php require baseUrl('views/partials/nav.php'); ?>
<?php require baseUrl('views/partials/banner.php'); ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold tracking-tight text-gray-900"><?= htmlspecialchars($note['title']) ?></h2>
    <p><?= htmlspecialchars($note['body']) ?></p>
    <a href="/notes" class="text-blue-500 hover:underline">go back...</a>
  </div>
</main>

<?php require baseUrl('views/partials/foot.php'); ?>