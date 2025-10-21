<?php require baseUrl('views/partials/head.php'); ?>
<?php require baseUrl('views/partials/nav.php'); ?>
<?php require baseUrl('views/partials/banner.php'); ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <ul class="mb-6">
      <?php foreach ($notes as $note) : ?>
        <li>
          <a href="/note?id=<?= $note['id'] ?>" class="text-blue-500 hover:underline">
            <?= htmlspecialchars($note['title']) ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
    <a href="/notes/create" class="text-blue-500 hover:underline">Create a note</a>
  </div>
</main>

<?php require baseUrl('views/partials/foot.php'); ?>