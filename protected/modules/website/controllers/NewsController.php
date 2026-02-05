<?php
class NewsController extends Controller
{
    public function actionCreate()
    {
        $model = new News;

        if (isset($_POST['News'])) {
            $model->attributes = $_POST['News'];

            $imageFile = CUploadedFile::getInstanceByName('news-image-file');

            if ($imageFile) {
                $ext = strtolower($imageFile->extensionName);

                if (!in_array($ext, ['jpg','jpeg','png','webp'])) {
                    $model->addError('image', 'Invalid image format');
                } else {
                    $fileName = time() . '_' . preg_replace('/\s+/', '-', $imageFile->name);
                    $folder   = $this->getWebsiteImagePath() . '/news';

                    if (!is_dir($folder)) {
                        mkdir($folder, 0755, true);
                    }

                    $imageFile->saveAs($folder . '/' . $fileName);
                    $model->image = '/images/news/' . $fileName;
                }
            }

            if (!$model->hasErrors() && $model->save()) {
                Yii::app()->user->setFlash('success', 'News created.');
                $this->redirect(['index']);
            }
        }

        $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = News::model()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404, 'News not found');
        }

        // SIMPAN IMAGE LAMA
        $oldImage = $model->image;

        if (isset($_POST['News'])) {
            $model->attributes = $_POST['News'];

            $imageFile = CUploadedFile::getInstanceByName('news-image-file');

            if ($imageFile) {
                $ext = strtolower($imageFile->extensionName);

                if (!in_array($ext, ['jpg','jpeg','png','webp'])) {
                    $model->addError('image', 'Invalid image format');
                } else {
                    $fileName = time() . '_' . preg_replace('/\s+/', '-', $imageFile->name);
                    $folder   = $this->getWebsiteImagePath() . '/news';

                    if (!is_dir($folder)) {
                        mkdir($folder, 0755, true);
                    }

                    // upload image baru
                    $imageFile->saveAs($folder . '/' . $fileName);

                    // set path baru
                    $model->image = '/images/news/' . $fileName;
                }
            }

            if (!$model->hasErrors() && $model->save()) {

                // HAPUS IMAGE LAMA JIKA ADA IMAGE BARU
                if ($imageFile && $oldImage) {
                    $oldPath = $this->getWebsiteImagePath()
                        . str_replace('/images', '', $oldImage);

                    if (is_file($oldPath)) {
                        unlink($oldPath);
                    }
                }

                Yii::app()->user->setFlash('success', 'News updated.');
                $this->redirect(['index']);
            }
        }

        $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionIndex()
    {
        $model = new News('search');
        $model->unsetAttributes();
        if (isset($_GET['News'])) $model->attributes = $_GET['News'];
        $this->render('index', ['model' => $model]);
    }
}