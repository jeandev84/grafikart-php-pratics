<?php

\App\Security\Auth::check();

$connection = \App\Helpers\Connection::make();
$request    = \Grafikart\Http\Request\Request::createFromGlobals();

$categoryRepository = new \App\Repository\CategoryRepository($connection);
$categories         = $categoryRepository->list();
$postRepository     = new \App\Repository\PostRepository($connection);
/** @var \App\Entity\Post $post */
$post = $postRepository->find($params['id']);
$categoryRepository->hydratePosts([$post]);
$success = false;
$errors = [];

if ($request->isMethod('POST')) {
    $data = $request->getParsedBodyWithFiles();
    $validator = new \App\Validators\PostValidator($data, $postRepository, $post->getId(), $categories);
    \Grafikart\Helpers\ObjectHelper::hydrate($post, $data, ['name', 'content', 'slug', 'created_at', 'image']);

    if ($validator->validate()) {
        $pdo = $connection->getPdo();
        $pdo->beginTransaction();
        \App\Attachment\PostAttachment::upload($post);
        $postRepository->updatePost($post);
        $postRepository->attachCategories($post->getId(), $request->request->get('category_ids'));
        $pdo->commit();
        $categoryRepository->hydratePosts([$post]); // mise ajour
        $success = true;
    } else {
        $errors = $validator->errors();
    }
}

$form = new \Grafikart\HTML\Form($post, $errors);
?>

<?php if ($success): ?>
<div class="alert alert-success">
    L' article a bien ete modifiee
</div>
<?php endif; ?>

<?php if ($request->queries->has('created')): ?>
    <div class="alert alert-success">
        L' article a bien ete cree
    </div>
<?php endif; ?>


<?php if ($errors): ?>
    <div class="alert alert-danger">
        L' article n'a pas pu etre modifier, merci de corriger vos errors
    </div>
<?php endif; ?>

<h1>Editer l'article <?= e($post->getName()) ?></h1>

<?php require '_form.php';