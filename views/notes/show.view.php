<?php require baseUrl('views/partials/head.php'); ?>
<?php require baseUrl('views/partials/nav.php'); ?>
<?php require baseUrl('views/partials/banner.php'); ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold tracking-tight text-gray-900"><?= htmlspecialchars($note['title']) ?></h2>
    <p><?= htmlspecialchars($note['body']) ?></p>
    <a href="/notes" class="text-blue-500 hover:underline">go back...</a>
    <form action="#" method="post" class="mt-6">
      <input type="hidden" name="_method" value="DELETE">
      <input type="hidden" name="id" value="<?= $note['id'] ?>">
      <button type="submit" class="text-sm text-red-500">Delete</button>
    </form>
  </div>
</main>

<?php require baseUrl('views/partials/foot.php'); ?>