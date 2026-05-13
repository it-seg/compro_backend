<style>
    .cms-wrapper {
        max-width: 680px;
        margin: auto;
    }

    .cms-card {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }

    .cms-header {
        background: linear-gradient(135deg, #6610f2, #520dc2);
        color: #fff;
        padding: 16px 22px;
    }

    .cms-header h4 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
    }

    .cms-header p {
        margin: 5px 0 0;
        opacity: .92;
        font-size: 12px;
    }

    .cms-body {
        padding: 20px;
        background: #fff;
    }

    .field-card {
        border: 1px solid #eee;
        border-radius: 14px;
        padding: 16px;
        background: #fff;
    }

    .field-title {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .field-desc {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 12px;
    }

    .form-control {
        border-radius: 10px;
        min-height: 42px;
        border: 1px solid #dcdcdc;
        box-shadow: none !important;
        font-size: 13px;
    }

    .upload-box {
        border: 2px dashed #d0d7de;
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        background: #fafafa;
        transition: .2s;
    }

    .upload-box:hover {
        border-color: #6610f2;
        background: #faf7ff;
    }

    .upload-icon {
        font-size: 32px;
        margin-bottom: 6px;
    }

    .upload-text {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .upload-subtext {
        font-size: 11px;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .preview-wrapper {
        margin-top: 14px;
        display: none;
    }

    .preview-wrapper img {
        width: 220px;
        height: 320px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #eee;
        margin: auto;
        display: block;
    }

    .image-info {
        margin-top: 12px;
        border-radius: 10px;
        background: #f8f9fa;
        padding: 10px 12px;
        text-align: left;
    }

    .image-info-title {
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #212529;
    }

    .image-info ul {
        margin: 0;
        padding-left: 16px;
    }

    .image-info li {
        font-size: 11px;
        color: #6c757d;
        margin-bottom: 2px;
    }

    .action-area {
        border-top: 1px solid #eee;
        margin-top: 18px;
        padding-top: 16px;
    }

    .btn-save {
        min-width: 120px;
        height: 40px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
    }

    .btn-cancel {
        min-width: 100px;
        height: 40px;
        border-radius: 10px;
        font-weight: 500;
        font-size: 13px;
    }
</style>

<div class="container py-3 cms-wrapper">

    <div class="card cms-card">

        <!-- HEADER -->
        <div class="cms-header">

            <h4>
                Upload Music Image
            </h4>

            <p>
                Tambahkan cover image untuk section music website.
            </p>

        </div>

        <!-- BODY -->
        <div class="cms-body">

            <form method="post" enctype="multipart/form-data">

                <div class="field-card">

                    <div class="field-title">
                        Upload Image
                    </div>

                    <div class="field-desc">
                        Gunakan gambar portrait berkualitas tinggi agar tampilan music section lebih premium.
                    </div>

                    <label class="upload-box w-100">

                        <div class="upload-icon">
                            🎵
                        </div>

                        <div class="upload-text">
                            Choose Image
                        </div>

                        <div class="upload-subtext">
                            JPG, PNG, WEBP
                        </div>

                        <input type="file"
                               id="imageInput"
                               name="image"
                               class="form-control"
                               required
                               accept="image/*">

                        <!-- PREVIEW -->
                        <div class="preview-wrapper" id="previewWrapper">

                            <img id="previewImage">

                        </div>

                        <!-- IMAGE INFO -->
                        <div class="image-info">

                            <div class="image-info-title">
                                Recommended Image
                            </div>

                            <ul>
                                <li>
                                    Recommended Size:
                                    <strong>800 × 1200 px</strong>
                                </li>

                                <li>
                                    Recommended Ratio:
                                    <strong>2:3 (Portrait)</strong>
                                </li>

                                <li>
                                    Max File Size:
                                    <strong>5 MB</strong>
                                </li>

                                <li>
                                    Supported Format:
                                    <strong>JPG, PNG, WEBP</strong>
                                </li>

                            </ul>

                        </div>

                    </label>

                </div>

                <!-- ACTION -->
                <div class="action-area d-flex gap-2">

                    <button class="btn btn-primary btn-save">
                        Upload
                    </button>

                    <a href="<?= $this->createUrl('index') ?>"
                       class="btn btn-light border btn-cancel">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<script>
    const imageInput = document.getElementById('imageInput');
    const previewImage = document.getElementById('previewImage');
    const previewWrapper = document.getElementById('previewWrapper');

    imageInput.addEventListener('change', function (e) {

        const file = e.target.files[0];

        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (event) {

            previewImage.src = event.target.result;
            previewWrapper.style.display = 'block';

        };

        reader.readAsDataURL(file);

    });
</script>