<div class="validation-error alert alert-danger">
    <?php if (isset($errors) && !empty($errors)): ?>
        <ul class="mb-0">
            <?php foreach ($errors as $field => $error): ?>
                <li><?= $this->e($error) ?></li>
            <?php endforeach ?>
        </ul>
    <?php else: ?>
        <p class="mb-0">Please check your input and try again.</p>
    <?php endif ?>
</div>
