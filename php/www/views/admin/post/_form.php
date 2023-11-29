<form action="" method="POST" enctype="multipart/form-data">
    <?= $form->input('name', 'Titre') ?>
    <?= $form->input('slug', 'URL') ?>
    <?= $form->file('image', 'Image a la une') ?>
    <?= $form->select('category_ids', 'Categories', $categories) ?>
    <?= $form->textarea('content', 'Contenu') ?>
    <?= $form->input('created_at', 'Date de publication') ?>
    <button class="btn btn-primary">
        <?= $post->getId() !== null ? 'Modifier' : 'Creer' ?>
    </button>
</form>

<!---
https://flatpickr.js.org/examples