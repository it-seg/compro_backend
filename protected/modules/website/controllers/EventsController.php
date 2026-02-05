<?php
class EventsController extends Controller
{
    public function actionIndex()
    {
        $model = new Events('search');
        $model->unsetAttributes();
        if (isset($_GET['Events'])) $model->attributes = $_GET['Events'];
        $this->render('index', ['model' => $model]);
    }

    public function actionCreate()
    {
        $model = new Events;

        if (isset($_POST['Events'])) {
            $model->attributes = $_POST['Events'];


            $imageFile = CUploadedFile::getInstanceByName('event-image-file');

            if ($imageFile) {
                $ext = strtolower($imageFile->extensionName);
                if (!in_array($ext, ['jpg','jpeg','png','webp'])) {
                    $model->addError('image', 'Invalid image format');
                } else {
                    $fileName = time().'_'.$imageFile->name;
                    $folder = $this->getWebsiteImagePath().'/events';
                    if (!is_dir($folder)) mkdir($folder,0755,true);

                    $imageFile->saveAs($folder.'/'.$fileName);
                    $model->image_url = '/images/events/'.$fileName;
                }
            }

            if (!$model->hasErrors() && $model->save()) {
                Yii::app()->user->setFlash('success','Event created.');
                $this->redirect(['index']);
            }
        }
        $this->render('create',['model'=>$model]);
    }

    public function actionUpdate($id)
    {
        $model = Events::model()->findByPk($id);
        if(!$model) throw new CHttpException(404,'Not found');

        $oldImage = $model->image_url;

        if (isset($_POST['Events'])) {
            $model->attributes = $_POST['Events'];

            $imageFile = CUploadedFile::getInstanceByName('event-image-file');

            if ($imageFile) {
                $ext = strtolower($imageFile->extensionName);
                if (in_array($ext,['jpg','jpeg','png','webp'])) {
                    $fileName = time().'_'.$imageFile->name;
                    $folder = $this->getWebsiteImagePath().'/events';
                    if (!is_dir($folder)) mkdir($folder,0755,true);

                    $imageFile->saveAs($folder.'/'.$fileName);
                    $model->image_url = '/images/events/'.$fileName;
                }
            }

            if ($model->save()) {
                if ($imageFile && $oldImage) {
                    $oldPath = $this->getWebsiteImagePath()
                        . str_replace('/images','',$oldImage);
                    if (is_file($oldPath)) unlink($oldPath);
                }
                Yii::app()->user->setFlash('success','Event updated.');
                $this->redirect(['index']);
            }
        }
        $this->render('create',['model'=>$model]);
    }


}