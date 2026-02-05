<?php
class GalleryController extends Controller
{
    public function actionIndex()
    {
        $images = $this->getImagesByFolder('demo_ig');
        $this->render('index', [
            'images' => $images
        ]);
    }


    public function actionCreate()
    {
        if (isset($_FILES['image'])) {

            $p = Yii::app()->params;
            $basePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
                ? $p['websiteImagePath']['windows']
                : $p['websiteImagePath']['linux'];

            $path = rtrim($basePath, '/') . '/demo_ig';

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
        if (!AuthHelper::can('WEBSITE|GALLERY|DELETE')) {
            throw new CHttpException(403, 'Forbidden');
        }

        $p = Yii::app()->params;
        $basePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            ? $p['websiteImagePath']['windows']
            : $p['websiteImagePath']['linux'];

        $path = rtrim($basePath, '/') . '/demo_ig/' . basename($file);

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

}