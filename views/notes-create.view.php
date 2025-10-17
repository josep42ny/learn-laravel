<?php require 'partials/head.php' ?>
<?php require 'partials/nav.php' ?>
<?php require 'partials/banner.php' ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <form method="POST" action="#">
      <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12">

          <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-4">
              <label for="title" class="block text-sm/6 font-medium text-gray-900">Title</label>
              <div class="mt-2">
                <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                  <input id="title" type="text" name="title" placeholder="My note" value="<?= $_POST['title'] ?? '' ?>" class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" />
                </div>
                <?php foreach ($errors['title'] ?? [] as $error) : ?>
                  <p class="text-red-500 text-xs mt-2"><?= $error ?></p>
                <?php endforeach ?>
              </div>
            </div>

            <div class="col-span-full">
              <label for="body" class="block text-sm/6 font-medium text-gray-900">Body</label>
              <div class="mt-2">
                <textarea id="body" name="body" rows="3" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"><?= $_POST['body'] ?? '' ?></textarea>
                <?php foreach ($errors['body'] ?? [] as $error) : ?>
                  <p class="text-red-500 text-xs mt-2"><?= $error ?></p>
                <?php endforeach ?>
              </div>
              <p class="mt-3 text-sm/6 text-gray-600">Write to your heart's content.</p>
            </div>

          </div>
        </div>
      </div>

      <div class="mt-6 flex items-center justify-end gap-x-6">
        <button type="button" class="text-sm/6 font-semibold text-gray-900">Cancel</button>
        <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
      </div>
    </form>

  </div>
</main>

<?php require 'partials/foot.php' ?>