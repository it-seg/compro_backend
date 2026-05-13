<style>
    .contact-card {
        border: 0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        background: #fff;
    }

    .contact-header {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: #fff;
        padding: 14px 18px;
    }

    .contact-header h5 {
        margin: 0;
        font-weight: 700;
        font-size: 18px;
    }

    .contact-header p {
        margin: 3px 0 0;
        font-size: 11px;
        opacity: .88;
    }

    .contact-body {
        padding: 14px;
    }

    .contact-item {
        border: 1px solid #f1f3f5;
        border-radius: 12px;
        padding: 10px 12px;
        margin-bottom: 10px;
        transition: .2s;
        background: #fff;
    }

    .contact-item:hover {
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    }

    .contact-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .contact-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }

    .contact-content {
        flex: 1;
        min-width: 0;
    }

    .contact-label {
        font-size: 11px;
        color: #6c757d;
        margin-bottom: 2px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .contact-value {
        font-size: 13px;
        font-weight: 600;
        color: #212529;
        overflow-wrap: break-word;
        line-height: 1.4;
    }

    .contact-map {
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #eee;
        height: 100%;
        min-height: 360px;
    }

    .contact-map iframe {
        width: 100%;
        height: 100%;
        border: 0;
    }

    .map-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .map-title {
        font-size: 14px;
        font-weight: 700;
        color: #212529;
    }

    .btn-sm {
        border-radius: 8px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 600;
    }

    .contact-edit {
        margin-left: auto;
    }

    @media (max-width: 768px) {
        .contact-map {
            min-height: 280px;
            margin-top: 10px;
        }
    }
</style>

<div class="container mt-3">

    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success py-2">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <div class="contact-card">

        <!-- HEADER -->
        <div class="contact-header">

            <h5>
                Kelola Contact Website
            </h5>

            <p>
                Informasi kontak dan lokasi website.
            </p>

        </div>

        <!-- BODY -->
        <div class="contact-body">

            <div class="row g-3">

                <!-- LEFT -->
                <div class="col-md-4">

                    <?php foreach ($settingItems as $item): ?>

                        <?php if ($item->key !== 'map'): ?>

                            <div class="contact-item">

                                <div class="contact-row">

                                    <!-- ICON -->
                                    <div class="contact-icon">

                                        <?php
                                        switch ($item->key) {

                                            case 'phone':
                                                echo '📞';
                                                break;

                                            case 'email':
                                                echo '✉️';
                                                break;

                                            case 'instagram':
                                                echo '📷';
                                                break;

                                            case 'facebook':
                                                echo '📘';
                                                break;

                                            case 'address':
                                                echo '📍';
                                                break;

                                            case 'whatsapp':
                                            case 'whatsapp_number':
                                                echo '💬';
                                                break;

                                            default:
                                                echo 'ℹ️';
                                                break;
                                        }
                                        ?>

                                    </div>

                                    <!-- CONTENT -->
                                    <div class="contact-content">

                                        <div class="contact-label">
                                            <?= $settingLabels[$item->key] ?? $item->key ?>
                                        </div>

                                        <div class="contact-value">
                                            <?= nl2br(CHtml::encode($item->value)) ?>
                                        </div>

                                    </div>

                                    <!-- ACTION -->
                                    <?php if (AuthHelper::can('WEBSITE|CONTACT|CREATE')): ?>

                                        <div class="contact-edit">

                                            <a href="<?= $this->createUrl('updateSetting', ['type'=>$item->key]) ?>"
                                               class="btn btn-warning btn-sm">

                                                Edit

                                            </a>

                                        </div>

                                    <?php endif; ?>

                                </div>

                            </div>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </div>

                <!-- RIGHT -->
                <div class="col-md-8">

                    <?php foreach ($settingItems as $item): ?>

                        <?php if ($item->key === 'map'): ?>

                            <div class="map-header">

                                <div class="map-title">
                                    📍 Google Maps Preview
                                </div>

                                <?php if (AuthHelper::can('WEBSITE|CONTACT|CREATE')): ?>

                                    <a href="<?= $this->createUrl('updateSetting', ['type'=>$item->key]) ?>"
                                       class="btn btn-warning btn-sm">

                                        Edit Map

                                    </a>

                                <?php endif; ?>

                            </div>

                            <div class="contact-map">

                                <iframe
                                        src="<?= CHtml::encode($item->value) ?>"
                                        allowfullscreen=""
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade">
                                </iframe>

                            </div>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>

    </div>

</div>