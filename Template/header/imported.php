<?php if ($this->user->hasAccess('UserListController', 'show')) : ?>
    <li>
        <?= $this->url->icon('download', t('Imported Projects management'), 'ImportedProjectListController', 'show') ?>
    </li>
<?php endif ?>