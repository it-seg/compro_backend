<?php
class AboutController extends Controller
{
    public function actionIndex()
    {
        $images = $this->getImagesByFolder('about');

        $p = Yii::app()->params;
        $basePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            ? $p['websiteImagePath']['windows']
            : $p['websiteImagePath']['linux'];

        $baseUrl = rtrim($p['websiteImageUrl'], '/');

        $logoPath = rtrim($basePath, '/') . '/logo.png';
        $logoUrl  = $baseUrl . '/logo.png';

        $logoImage = null;
        if (is_file($logoPath)) {
            $logoImage = [
                'name' => 'logo.png',
                'url'  => $logoUrl . '?v=' . filemtime($logoPath),
            ];
        }

        $types = [
            'about_sub_title',
            'about_title',
            'about_value_p1',
            'about_value_p2'
        ];

        $criteria = new CDbCriteria();
        $criteria->addInCondition('type', $types);
        $criteria->order = 'id ASC';
        $aboutItems = Header::model()->findAll($criteria);

        $this->render('index', [
            'images' => $images,
            'aboutItems' => $aboutItems,
            'logoImage'   => $logoImage,
        ]);
    }


    public function actionCreate()
    {
        if (isset($_FILES['image'])) {

            $p = Yii::app()->params;
            $basePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
                ? $p['websiteImagePath']['windows']
                : $p['websiteImagePath']['linux'];

            $path = rtrim($basePath, '/') . '/about';

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $file = CUploadedFile::getInstanceByName('image');

            if ($file) {
                $filename = time() . '_' . preg_replace('/\s+/', '-', strtolower($file->name));
                $file->saveAs($path . '/' . $filename);

                Yii::app()->user->setFlash('success', 'Gambar berhasil ditambahkan');
                $this->redirect(['index']);
            }
        }

        $this->render('create');
    }


    public function actionDeleteImage($file)
    {
        if (!AuthHelper::can('WEBSITE|ABOUT|DELETE')) {
            throw new CHttpException(403, 'Forbidden');
        }

        $p = Yii::app()->params;
        $basePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            ? $p['websiteImagePath']['windows']
            : $p['websiteImagePath']['linux'];

        $path = rtrim($basePath, '/') . '/about/' . basename($file);

        if (is_file($path)) {
            unlink($path);
            Yii::app()->user->setFlash('success', 'Gambar berhasil dihapus');
        }

        $this->redirect(['index']);
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
                    $fullFile = $fullPath . '/' . $file;
                    $images[] = [
                        'name' => $file,
                        'url'  => $baseUrl . '/' . $file . '?v=' . filemtime($fullFile),
                    ];
                }
            }
        }
        return $images;
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

    public function actionSetCover($file)
    {
        if (!AuthHelper::can('WEBSITE|ABOUT|CREATE')) {
            throw new CHttpException(403, 'Forbidden');
        }

        $p = Yii::app()->params;
        $basePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            ? $p['websiteImagePath']['windows']
            : $p['websiteImagePath']['linux'];

        $dir = rtrim($basePath, '/') . '/about';

        $file = basename($file);
        $source = $dir . '/' . $file;
        $cover  = $dir . '/cover.jpg';

        if (!is_file($source)) {
            throw new CHttpException(404, 'File tidak ditemukan');
        }

        // backup cover lama (optional)
        if (is_file($cover)) {
            $backupName = 'gallery_' . time() . '.jpg';
            rename($cover, $dir . '/' . $backupName);
        }

        rename($source, $cover);

        Yii::app()->user->setFlash('success', 'Cover berhasil diperbarui');
        $this->redirect(['index']);
    }

    public function actionReplaceLogo()
    {
        if (!AuthHelper::can('WEBSITE|ABOUT|CREATE')) {
            throw new CHttpException(403, 'Forbidden');
        }

        if (!isset($_FILES['logo'])) {
            $this->redirect(['index']);
        }

        $p = Yii::app()->params;
        $basePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            ? $p['websiteImagePath']['windows']
            : $p['websiteImagePath']['linux'];

        $logoPath = rtrim($basePath, '/') . '/logo.png';

        $file = CUploadedFile::getInstanceByName('logo');

        if ($file) {
            $ext = strtolower($file->getExtensionName());

            if (!in_array($ext, ['png','jpg','jpeg','webp','svg'])) {
                Yii::app()->user->setFlash('error', 'Format logo tidak didukung');
                $this->redirect(['index']);
            }

            // overwrite logo lama
            $file->saveAs($logoPath, true);

            Yii::app()->user->setFlash('success', 'Logo berhasil diperbarui');
        }

        $this->redirect(['index']);
    }

}