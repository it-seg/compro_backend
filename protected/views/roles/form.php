<?php
$grouped = [
    'Dashboard' => [
        'Dashboard' => ['DASHBOARD'],
    ],

    'User Management' => [
        'Users' => ['USERS', 'USERS|CREATE', 'USERS|EDIT', 'USERS|PASSWORD'],
        'Roles' => ['ROLES', 'ROLES|CREATE', 'ROLES|EDIT'],
    ],

    'Website Setting' => [
        'Setting' => ['WEBSITE|SETTING', 'WEBSITE|SETTING|CREATE'],
        'Header' => ['WEBSITE|HEADER', 'WEBSITE|HEADER|CREATE'],
        'Navigation' => ['WEBSITE|NAVIGATION', 'WEBSITE|NAVIGATION|CREATE'],
        'Image' => [
            'WEBSITEIMAGES',
            'WEBSITEIMAGES|UPLOAD',
            'WEBSITEIMAGES|SETCOVER',
            'WEBSITEIMAGES|RENAME',
            'WEBSITEIMAGES|DELETE',
        ],
    ],

    'Website Content' => [
        'Carousel' => ['WEBSITE|CAROUSEL', 'WEBSITE|CAROUSEL|CREATE', 'WEBSITE|CAROUSEL|DELETE'],
        'About' => ['WEBSITE|ABOUT', 'WEBSITE|ABOUT|CREATE', 'WEBSITE|ABOUT|DELETE'],
        'Contact' => ['WEBSITE|CONTACT', 'WEBSITE|CONTACT|CREATE', 'WEBSITE|CONTACT|DELETE'],
        'Gallery' => ['WEBSITE|GALLERY', 'WEBSITE|GALLERY|CREATE', 'WEBSITE|GALLERY|DELETE'],
        'Music' => ['WEBSITE|MUSIC', 'WEBSITE|MUSIC|CREATE', 'WEBSITE|MUSIC|DELETE'],
        'Events' => ['WEBSITE|EVENTS', 'WEBSITE|EVENTS|CREATE', 'WEBSITE|EVENTS|UPDATE'],
        'Menu'   => ['WEBSITE|MENU', 'WEBSITE|MENU|CREATE', 'WEBSITE|MENU|UPDATE'],
        'News'   => ['WEBSITE|NEWS', 'WEBSITE|NEWS|CREATE', 'WEBSITE|NEWS|UPDATE'],
        'Space'  => ['WEBSITE|SPACE', 'WEBSITE|SPACE|CREATE', 'WEBSITE|SPACE|UPDATE'],
    ],
];

$actionLabels = [
    'CREATE'   => 'Create',
    'UPDATE'     => 'Edit',
    'PASSWORD' => 'Password',
    'UPLOAD'   => 'Upload',
    'SETCOVER' => 'Setcover',
    'RENAME'   => 'Rename',
    'DELETE'   => 'Delete',
];
?>

<h3><?= $model->isNewRecord ? 'Create Role' : 'Edit Role'; ?></h3>

<div class="card shadow-sm">
    <div class="card-body">

        <?php $form = $this->beginWidget('CActiveForm'); ?>

        <!-- PENTING: jangan hapus -->
        <input type="hidden" name="Roles[section]" value="">

        <div class="row">

            <!-- LEFT -->
            <div class="col-md-3">
                <?= $form->labelEx($model, 'name', ['class'=>'fw-semibold']); ?>
                <?= $form->textField($model, 'name', [
                    'class'=>'form-control',
                    'placeholder'=>'Admin, Kasir, Owner'
                ]); ?>
                <?= $form->error($model, 'name', ['class'=>'text-danger small']); ?>
            </div>

            <!-- RIGHT -->
            <div class="col-md-9">

                <?php foreach ($grouped as $sectionTitle => $modules): ?>
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary border-bottom pb-1">
                            <?= $sectionTitle ?>
                        </h6>

                        <table class="table table-sm align-middle">
                            <tbody>

                            <?php foreach ($modules as $moduleName => $permissions): ?>
                                <tr>
                                    <td width="160" class="fw-semibold">
                                        <?= $moduleName ?>
                                    </td>
                                    <td>

                                        <?php foreach ($permissions as $perm): ?>
                                            <?php
                                            $parts = explode('|', $perm);
                                            $last  = strtoupper(end($parts));

                                            if (isset($actionLabels[$last])) {
                                                $label = $actionLabels[$last];
                                            } else {
                                                $label = 'View';
                                            }
                                            ?>

                                            <label class="form-check form-check-inline me-3">
                                                <input
                                                        type="checkbox"
                                                        class="form-check-input"
                                                        name="Roles[section][]"
                                                        value="<?= $perm ?>"
                                                    <?= is_array($model->section) && in_array($perm, $model->section) ? 'checked' : '' ?>
                                                >
                                                <span class="form-check-label">
                                            <?= $label ?>
                                        </span>
                                            </label>

                                        <?php endforeach; ?>

                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>

            </div>

        </div>

        <hr>

        <div class="text-end">
            <button class="btn btn-success px-4">
                <i class="bi bi-save"></i> Save
            </button>
        </div>

        <?php $this->endWidget(); ?>

    </div>
</div>
