<?php require baseUrl('views/partials/head.php'); ?>
<?php require baseUrl('views/partials/nav.php'); ?>
<?php require baseUrl('views/partials/banner.php'); ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <a href="/notes" class="text-blue-500 hover:underline">go back...</a>
    <h2 class="text-2xl font-bold tracking-tight text-gray-900"><?= htmlspecialchars($note['title']) ?></h2>
    <p><?= htmlspecialchars($note['body']) ?></p>

    <footer class="mt-6">
      <a href="/note/edit?id=<?= $note['id'] ?>" class="text-gray-500 border border-current px-4 py-2 rounded">Edit</a>
    </footer>
  </div>
</main>

<?php require baseUrl('views/partials/foot.php'); ?>