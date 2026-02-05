<?php

class SpaceController extends Controller
{
    /* =========================
     * INDEX
     * ========================= */
    public function actionIndex()
    {
        $model = new Space('search');
        $model->unsetAttributes();

        if (isset($_GET['Space'])) {
            $model->attributes = $_GET['Space'];
        }

        //header
        $types = [
            'space_title',
            'space_sub_title',
            'space_view_button'
        ];

        $criteria = new CDbCriteria();
        $criteria->addInCondition('type', $types);
        $criteria->order = 'id ASC';

        $headerItems = Header::model()->findAll($criteria);

        $this->render('index', [
            'model' => $model,
            'headerItems' => $headerItems
        ]);
    }

    /* =========================
     * CREATE
     * ========================= */
    public function actionCreate()
    {
        $model = new Space;

        // AUTO SORT ORDER
        $maxSort = Yii::app()->db_website
            ->createCommand('SELECT MAX(sort_order) FROM space')
            ->queryScalar();
        $model->sort_order = ((int)$maxSort) + 1;


        if (isset($_POST['Space'])) {
            $model->attributes = $_POST['Space'];

            $folderName = Yii::app()->request->getPost('folder_name');

            if (!$folderName) {
                $model->addError('images_folder_url', 'Folder images wajib diisi');
            } else {
                $model->images_folder_url = 'spaces/' . $folderName;
            }

            if (!$model->hasErrors() && $model->save()) {
                $this->ensureImageFolder($model->images_folder_url);

                Yii::app()->user->setFlash(
                    'success',
                    'Space <b>' . CHtml::encode($model->title) . '</b> berhasil diperbarui.'
                );


                $this->redirect(['index']);
            }

        }


        $this->render('create', [
            'model'  => $model,
            'images' => [],
        ]);
    }

    /* =========================
     * UPDATE
     * ========================= */
    public function actionUpdate($id)
    {
        $model = Space::model()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404, 'Data not found');
        }

        if (isset($_POST['Space'])) {
            $model->attributes = $_POST['Space'];

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    'success',
                    'Space <b>' . CHtml::encode($model->title) . '</b> berhasil diperbarui.'
                );


                $this->redirect(['index']);
            }

        }


        $this->render('create', [
            'model'  => $model,
            'images' => $this->getImagesByFolder($model->images_folder_url),
        ]);
    }

    /* =========================
     * IMAGE LIST
     * ========================= */
    private function getImagesByFolder($folder)
    {
        if (empty($folder)) return [];

        $p = Yii::app()->params;
        $basePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            ? $p['websiteImagePath']['windows']
            : $p['websiteImagePath']['linux'];

        $fullPath = rtrim($basePath, '/') . '/' . trim($folder, '/');
        $baseUrl  = rtrim($p['websiteImageUrl'], '/') . '/' . trim($folder, '/');

        $images = [];
        if (is_dir($fullPath)) {
            foreach (scandir($fullPath) as $file) {
                if ($file === '.' || $file === '..') continue;
                if (preg_match('/\.(jpg|jpeg|png|webp)$/i', $file)) {
                    $images[] = [
                        'name' => $file,
                        'url'  => $baseUrl . '/' . $file,
                    ];
                }
            }
        }
        return $images;
    }

    /* =========================
     * AUTO CREATE FOLDER
     * ========================= */
    private function ensureImageFolder($folder)
    {
        $p = Yii::app()->params;
        $basePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            ? $p['websiteImagePath']['windows']
            : $p['websiteImagePath']['linux'];

        $path = rtrim($basePath, '/') . '/' . trim($folder, '/');

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    /* =========================
     * UPLOAD IMAGE
     * ========================= */
    public function actionUploadImage()
    {
        $folder = Yii::app()->request->getPost('folder');
        if (!$folder || empty($_FILES['image'])) {
            throw new CHttpException(400, 'Invalid request');
        }

        $p = Yii::app()->params;
        $basePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            ? $p['websiteImagePath']['windows']
            : $p['websiteImagePath']['linux'];

        $dir = rtrim($basePath, '/') . '/' . trim($folder, '/');
        if (!is_dir($dir)) {
            throw new CHttpException(404, 'Folder not found');
        }

        $file = $_FILES['image'];
        $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, ['jpg','jpeg','png','webp'])) {
            throw new CHttpException(400, 'Invalid file type');
        }

        $target = $dir . '/' . basename($file['name']);

        if (!is_writable($dir)) {
            throw new CHttpException(500, 'Directory not writable: ' . $dir);
        }

        if (!move_uploaded_file($file['tmp_name'], $target)) {
            throw new CHttpException(500, 'Failed to move uploaded file');
        }

        echo 'OK';
        Yii::app()->end();

    }

    /* =========================
     * DELETE IMAGE
     * ========================= */
    public function actionDeleteImage()
    {
        $folder = Yii::app()->request->getPost('folder');
        $file   = Yii::app()->request->getPost('file');

        if (!$folder || !$file) {
            throw new CHttpException(400, 'Invalid request');
        }

        $p = Yii::app()->params;
        $basePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            ? $p['websiteImagePath']['windows']
            : $p['websiteImagePath']['linux'];

        $path = rtrim($basePath, '/') . '/' . trim($folder, '/') . '/' . basename($file);
        if (is_file($path)) {
            unlink($path);
        }

        echo 'OK';
        Yii::app()->end();
    }
    public function actionSetCover()
    {
        try {
            $folder = Yii::app()->request->getPost('folder');
            $file   = Yii::app()->request->getPost('file');

            if (!$folder || !$file) {
                throw new Exception('Folder atau file kosong');
            }

            $p = Yii::app()->params;
            $basePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
                ? $p['websiteImagePath']['windows']
                : $p['websiteImagePath']['linux'];

            $dir = rtrim($basePath, '/\\') . DIRECTORY_SEPARATOR . trim($folder, '/\\');

            if (!is_dir($dir)) {
                throw new Exception('Folder tidak ditemukan');
            }

            $source = $dir . DIRECTORY_SEPARATOR . basename($file);
            if (!is_file($source)) {
                throw new Exception('File gambar tidak ditemukan');
            }

            $ext    = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $target = $dir . DIRECTORY_SEPARATOR . 'cover.' . $ext;

            /* backup cover lama */
            foreach (['jpg','jpeg','png','webp'] as $e) {
                $old = $dir . DIRECTORY_SEPARATOR . 'cover.' . $e;
                if (is_file($old)) {
                    rename(
                        $old,
                        $dir . DIRECTORY_SEPARATOR . 'old_cover_' . time() . '.' . $e
                    );
                    break;
                }
            }

            /* copy + delete */
            if (!copy($source, $target)) {
                throw new Exception('Gagal copy file ke cover');
            }

            if (!unlink($source)) {
                throw new Exception('Cover dibuat, tapi gagal hapus file lama');
            }

            echo json_encode([
                'status'  => 'success',
                'message' => 'Cover berhasil diubah'
            ]);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }

        Yii::app()->end();
    }

    public function actionUpdateHeader($type)
    {
        $model = Header::model()->findByAttributes([
            'type' => $type,
        ]);

        if (!$model) {
            throw new CHttpException(404, 'Data tidak ditemukan');
        }

        if (isset($_POST['Header'])) {
            $model->attributes = $_POST['Header'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Konten berhasil diperbarui');
                $this->redirect(['index']);
            }
        }

        $this->render('update_header', [
            'model' => $model,
        ]);
    }



}
