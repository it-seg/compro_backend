<div class="container mt-3">
    <h3>Website Images</h3>
    <hr>
</div>

<?php
// calculate parent path
$parentPath = '';
if (!empty($currentPath)) {
    $parts = explode('/', $currentPath);
    array_pop($parts);
    $parentPath = implode('/', $parts);
}
?>

<div class="d-flex align-items-center mb-3">
    <?php if ($currentPath !== ''): ?>
        <a class="btn btn-outline-secondary me-2"
           href="<?php echo $this->createUrl('index', ['path' => $parentPath]); ?>">
            🔙 Back
        </a>
    <?php endif; ?>
    <small id="imagePath" class="text-muted">Path: /images/<?php echo CHtml::encode($currentPath); ?></small>
</div>

<style>
    .file-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 15px;
    }

    .file-item {
        text-align: center;
        cursor: pointer;
        position: relative;
    }

    .file-item img {
        width: 100%;
        height: 90px;
        object-fit: cover;
        border-radius: 6px;
    }

    .file-icon {
        font-size: 48px;
    }

    /* context menu */
    .context-menu {
        position: absolute;
        z-index: 9999;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 6px;
        display: none;
        min-width: 140px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
    }

    .context-menu button {
        width: 100%;
        padding: 8px 12px;
        border: 0;
        background: none;
        text-align: left;
    }

    .context-menu button:hover {
        background: #f1f1f1;
    }
</style>

<?php if (AuthHelper::can('WEBSITEIMAGES|UPLOAD')): ?>
    <div id="dropzone" class="border rounded p-4 text-center mb-3" style="border-style:dashed;">
        <i class="bi bi-cloud-upload fs-1"></i>
        <p class="mb-0">Drag & drop images here or click</p>
        <input type="file" id="fileInput" multiple hidden>
    </div>
<?php endif; ?>

<div class="file-grid" id="fileGrid">
    <?php foreach ($items as $item): ?>
        <div class="file-item"
             data-name="<?php echo CHtml::encode($item['name']); ?>"
             data-dir="<?php echo $item['isDir'] ? '1' : '0'; ?>"
             oncontextmenu="showMenu(event, this)"
            <?php if ($item['isDir']): ?>
                onclick="openFolder('<?php echo CHtml::encode($item['name']); ?>')"
            <?php else: ?>
                onclick="selectFile('<?php echo CHtml::encode($item['name']); ?>')"
            <?php endif; ?>>

            <?php if ($item['isDir']): ?>
                <i class="bi bi-folder-fill file-icon text-warning"></i>
            <?php elseif ($item['isImage']): ?>
                <img src="<?php echo CHtml::encode($item['url']); ?>">
            <?php else: ?>
                <i class="bi bi-file-earmark file-icon"></i>
            <?php endif; ?>

            <div><?php echo CHtml::encode($item['name']); ?></div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Context Menu -->
<div id="contextMenu" class="context-menu">
    <?php if (AuthHelper::can('WEBSITEIMAGES|SETCOVER')): ?>
        <button id="btnSetCover" onclick="setCover()">➤ Set as Cover</button>
    <?php endif; ?>

    <?php if (AuthHelper::can('WEBSITEIMAGES|RENAME')): ?>
        <button id="btnRename" onclick="renameItem()">✏ Rename</button>
    <?php endif; ?>

    <?php if (AuthHelper::can('WEBSITEIMAGES|DELETE')): ?>
        <button id="btnDelete" onclick="deleteItem()" class="text-danger">🗑 Delete</button>
    <?php endif; ?>
</div>

<script>
    CURRENT_PATH = '<?php echo CHtml::encode($currentPath); ?>';
    INDEX_URL = '<?php echo $this->createUrl('index'); ?>';
    UPLOAD_URL = <?php echo CJSON::encode($this->createUrl('Upload')); ?>;
    DELETE_URL = <?php echo CJSON::encode($this->createUrl('Delete')); ?>;
    RENAME_URL = <?php echo CJSON::encode($this->createUrl('Rename')); ?>;
    SET_COVER_URL = <?php echo CJSON::encode($this->createUrl('SetCover')); ?>;

    let selectedItem = null;

    /* open folder */
    function openFolder(name) {
        const newPath = CURRENT_PATH ? CURRENT_PATH + '/' + name : name;
        window.location.href = INDEX_URL + '&path=' + encodeURIComponent(newPath);
    }

    function selectFile(name) {
        const fullPath = CURRENT_PATH
            ? CURRENT_PATH + '/' + name
            : name;

        document.getElementById('imagePath').textContent =
            'Path: /images/' + fullPath;
    }

    /* context menu */
    function showMenu(e, el) {
        e.preventDefault();
        selectedItem = el;

        const isDir = el.dataset.dir === '1';

        // 🚫 if folder, do not show context menu at all
        if (isDir) {
            return;
        }

        const setCoverBtn = document.getElementById('btnSetCover');
        const renameBtn = document.getElementById('btnRename');
        const deleteBtn = document.getElementById('btnDelete');

        if(setCoverBtn) setCoverBtn.style.display = 'block';
        if(renameBtn) renameBtn.style.display = 'block';
        if(deleteBtn) deleteBtn.style.display = 'block';

        const menu = document.getElementById('contextMenu');
        menu.style.left = e.pageX + 'px';
        menu.style.top = e.pageY + 'px';
        menu.style.display = 'block';
    }


    document.addEventListener('click', () => {
        document.getElementById('contextMenu').style.display = 'none';
    });

    /* delete */
    function deleteItem() {
        if (!selectedItem) return;
        if (!confirm('Delete this item?')) return;

        const form = new FormData();
        form.append('path', CURRENT_PATH);
        form.append('name', selectedItem.dataset.name);

        fetch(DELETE_URL, {
            method: 'POST',
            body: form
        }).then(() => location.reload());
    }

    /* rename */
    function renameItem() {
        if (!selectedItem) return;

        const oldName = selectedItem.dataset.name;

        // split name + extension
        const lastDot = oldName.lastIndexOf('.');
        const isFile = lastDot > 0;

        const baseName = isFile ? oldName.substring(0, lastDot) : oldName;
        const extension = isFile ? oldName.substring(lastDot) : '';

        const newBase = prompt('New name:', baseName);
        if (!newBase || newBase === baseName) return;

        const form = new FormData();
        form.append('path', CURRENT_PATH);
        form.append('old', oldName);
        form.append('new', newBase); // WITHOUT extension

        fetch(RENAME_URL, {
            method: 'POST',
            body: form
        }).then(() => location.reload());
    }

    /* set as cover */
    function setCover() {
        if (!selectedItem) return;

        if (!confirm('Set image as cover?')) return;

        const oldName = selectedItem.dataset.name;

        const form = new FormData();
        form.append('path', CURRENT_PATH);
        form.append('old', oldName);

        fetch(SET_COVER_URL, {
            method: 'POST',
            body: form
        }).then(async response => {
            // fetch only rejects on network failure,
            // so we must manually check for 4xx/5xx status codes
            if (!response.ok) {
                // Try to get error message from server response, otherwise use status text
                const errorText = await response.text();
                throw new Error(errorText || `Server error: ${response.status}`);
            }
            location.reload();
        })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to set cover');
            });
    }

    /* upload */
    const dropzone = document.getElementById('dropzone');
    const input = document.getElementById('fileInput');

    if(dropzone) {
        dropzone.onclick = () => input.click();
        dropzone.ondragover = e => {
            e.preventDefault();
            dropzone.classList.add('bg-light');
        };
        dropzone.ondragleave = () => dropzone.classList.remove('bg-light');
        dropzone.ondrop = e => {
            e.preventDefault();
            dropzone.classList.remove('bg-light');
            uploadFiles(e.dataTransfer.files);
        };

        input.onchange = () => uploadFiles(input.files);

        function uploadFiles(files) {
            const form = new FormData();
            for (const f of files) form.append('files[]', f);
            form.append('path', CURRENT_PATH);

            fetch(UPLOAD_URL, {method: 'POST', body: form})
                .then(() => location.reload());
        }
    }
</script>
