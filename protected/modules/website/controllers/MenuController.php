<?php
class MenuController extends Controller
{
    public function actionCreate()
    {
        $model = new Menu;

        if (isset($_POST['Menu'])) {
            $model->attributes = $_POST['Menu'];

            $folderName = Yii::app()->request->getPost('folder_name');
            if (!$folderName) {
                $model->addError('images_folder_url', 'Folder images wajib diisi');
            } else {
                $model->images_folder_url = 'menu/' . $folderName;
            }

            if (!$model->hasErrors() && $model->save()) {
                $this->ensureImageFolder($model->images_folder_url);
                Yii::app()->user->setFlash('success', 'Menu created.');
                $this->redirect(['index']);
            }
        }

        $this->render('create', [
            'model'  => $model,
            'is_active' => [1=>'ACTIVE',0=>'INACTIVE'],
            'images' => [],
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Menu::model()->findByPk($id);
        if (!$model) throw new CHttpException(404,'Not found');

        if (isset($_POST['Menu'])) {
            $model->attributes = $_POST['Menu'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Menu updated.');
                $this->redirect(['index']);
            }
        }

        $this->render('create', [
            'model'  => $model,
            'is_active' => [1=>'ACTIVE',0=>'INACTIVE'],
            'images' => $this->getImagesByFolder($model->images_folder_url),
        ]);
    }

    public function actionIndex()
    {
        $model = new Menu('search');
        $model->unsetAttributes();
        if (isset($_GET['Menu'])) $model->attributes = $_GET['Menu'];
        $this->render('index', ['model' => $model]);
    }

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

    private function ensureImageFolder($folder)
    {
        $p = Yii::app()->params;

        $basePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            ? $p['websiteImagePath']['windows']
            : $p['websiteImagePath']['linux'];

        $path = rtrim($basePath, '/') . '/' . trim($folder, '/');

        if (!is_dir($path)) {

            mkdir($path, 0777, true);

            chmod($path, 0777);
        }
    }

    public function actionUploadImage()
    {
        if (empty($_FILES['image'])) {
            throw new CHttpException(400, 'No image uploaded');
        }

        $folder = Yii::app()->request->getPost('folder');

        if (!$folder) {
            throw new CHttpException(400, 'Folder missing');
        }

        $p = Yii::app()->params;

        $basePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            ? $p['websiteImagePath']['windows']
            : $p['websiteImagePath']['linux'];

        $fullPath = rtrim($basePath, '/') . '/' . trim($folder, '/');

        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0777, true);
            chmod($fullPath, 0777);
        }

        $file = CUploadedFile::getInstanceByName('image');

        if (!$file) {
            throw new CHttpException(400, 'Invalid file');
        }

        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9.\-_]/', '', $file->name);

        $target = $fullPath . '/' . $filename;

        if (!$file->saveAs($target)) {
            throw new CHttpException(500, 'Failed save image');
        }

        chmod($target, 0777);

        echo json_encode([
            'success' => true,
            'file' => $filename
        ]);

        Yii::app()->end();
    }

}