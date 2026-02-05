<?php
class ImageController extends Controller
{
    public function actionUpload()
    {
        $path = Yii::app()->request->getPost('path', '');
        $base = $this->getWebsiteImagePath();
        $target = realpath($base . DIRECTORY_SEPARATOR . $path);

        if (!$target || strpos($target, realpath($base)) !== 0) {
            throw new CHttpException(403, 'Invalid path');
        }

        foreach ($_FILES['files']['tmp_name'] as $i => $tmp) {
            $name = basename($_FILES['files']['name'][$i]);
            move_uploaded_file($tmp, $target . DIRECTORY_SEPARATOR . $name);
        }
    }

    public function actionDelete()
    {
        $path = Yii::app()->request->getPost('path', '');
        $name = Yii::app()->request->getPost('name');

        $root = $this->getWebsiteImagePath();
        $target = realpath($root . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $name);

        if (!$target || strpos($target, realpath($root)) !== 0) {
            throw new CHttpException(403, 'Invalid path');
        }

        if (is_dir($target)) {
            rmdir($target);
        } else {
            unlink($target);
        }

        Yii::app()->end();
    }

    public function actionRename()
    {
        $path = Yii::app()->request->getPost('path', '');
        $old  = Yii::app()->request->getPost('old');

        $ext = pathinfo($old, PATHINFO_EXTENSION);
        $new  = Yii::app()->request->getPost('new') . '.'. $ext;

        $root = $this->getWebsiteImagePath();

        $oldPath = realpath($root . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $old);
        $newPath = dirname($oldPath) . DIRECTORY_SEPARATOR . basename($new);

        if (!$oldPath || strpos($oldPath, realpath($root)) !== 0) {
            throw new CHttpException(403, 'Invalid path');
        }

        rename($oldPath, $newPath);
        Yii::app()->end();
    }

    public function actionSetCover()
    {
        $path = Yii::app()->request->getPost('path', '');
        $old  = Yii::app()->request->getPost('old');
        $new  = 'cover.jpg';

        $root = $this->getWebsiteImagePath();

        $oldPath = realpath($root . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $old);
        $coverPath = dirname($oldPath) . DIRECTORY_SEPARATOR . basename($new);

        if (!$oldPath || strpos($oldPath, realpath($root)) !== 0) {
            throw new CHttpException(403, 'Invalid path');
        }
        if (!is_file($coverPath)) {
            throw new CHttpException(403, 'Invalid cover');
        }

        rename($coverPath, $coverPath. '.old');
        rename($oldPath, $coverPath);
        rename($coverPath. '.old', $oldPath);

        Yii::app()->end();
    }

    public function actionIndex()
    {
        $rootDir = $this->getWebsiteImagePath();

        if (!$rootDir || !is_dir($rootDir)) {
            throw new CHttpException(500, 'Image directory not found');
        }

        $relativePath = Yii::app()->request->getParam('path', '');

        $currentPath = realpath($rootDir . DIRECTORY_SEPARATOR . $relativePath);

        // 🔒 prevent directory traversal
        if ($currentPath === false || strpos($currentPath, realpath($rootDir)) !== 0) {
            throw new CHttpException(403, 'Invalid path');
        }

        // URL for browser
        $baseUrl = Yii::app()->request->hostInfo
            . Yii::app()->params['websiteImageUrl']
            . ($relativePath ? '/' . $relativePath : '');

        $items = [];
        $imageExt = ['jpg','jpeg','png','gif','webp','svg'];

        foreach (scandir($currentPath) as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $fullPath = $currentPath . DIRECTORY_SEPARATOR . $item;
            $isDir = is_dir($fullPath);

            $items[] = [
                'name'    => $item,
                'isDir'   => $isDir,
                'isImage' => !$isDir
                    && in_array(strtolower(pathinfo($item, PATHINFO_EXTENSION)), $imageExt),
                'url'     => !$isDir
                    ? $baseUrl . '/' . rawurlencode($item)
                    : null,
            ];
        }

        /**
         * Sort:
         * 1. Folder first
         * 2. Then files/images
         * 3. Alphabetical by name (case-insensitive)
         */
        usort($items, function ($a, $b) {

            // folder first
            if ($a['isDir'] !== $b['isDir']) {
                return $a['isDir'] ? -1 : 1;
            }

            // same type → sort by name
            return strcasecmp($a['name'], $b['name']);
        });


        $this->render('index', [
            'items' => $items,
            'currentPath' => $relativePath,
        ]);
    }
}

