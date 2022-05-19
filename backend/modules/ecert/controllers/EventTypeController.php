<?php
namespace backend\modules\ecert\controllers;

use backend\modules\ecert\models\Event;
use backend\modules\ecert\models\EventType;
use common\models\UploadFile;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * EventTypeController implements the CRUD actions for EventType model.
 */
class EventTypeController extends Controller
{

    /**
     *
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [
                            '@'
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all EventType models.
     *
     * @return mixed
     */
    public function actionIndex($event)
    {
        $event = $this->findEvent($event);
        $dataProvider = new ActiveDataProvider([
            'query' => EventType::find()->where([
                'event_id' => $event->id
            ])
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'event' => $event
        ]);
    }

    /**
     * Displays a single EventType model.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new EventType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate($event)
    {
        $event = $this->findEvent($event);
        $model = new EventType();
        $model->event_id = $event->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'id' => $model->id
            ]);
        }

        return $this->render('create', [
            'model' => $model,
            'event' => $event
        ]);
    }

    /**
     * Updates an existing EventType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'id' => $model->id
            ]);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionPublish($id)
    {
        $model = $this->findModel($id);
        if ($model->template_file) {

            $model->published = 1;
            $model->published_at = new Expression('NOW()');
            if ($model->save()) {
                $file = Yii::getAlias('@upload/' . $model->template_file);
                $f = basename($file);
                $paste = 'images/ecert/' . $f;
                if (is_file($file)) {
                    copy($file, $paste);
                }
            } else {
                Yii::$app->session->addFlash('error', "Data failed!");
            }
        } else {
            Yii::$app->session->addFlash('error', "Provide template first!");
        }

        return $this->redirect([
            'view',
            'id' => $id
        ]);
    }

    public function actionUnpublish($id)
    {
        $model = $this->findModel($id);
        $model->published = 0;
        if ($model->save()) {
            $file = Yii::getAlias('@upload/' . $model->template_file);
            $f = basename($file);
            $paste = 'images/ecert/' . $f;
            if (is_file($paste)) {
                unlink($paste);
            }
        } else {
            Yii::$app->session->addFlash('error', "Data failed!");
        }

        return $this->redirect([
            'view',
            'id' => $id
        ]);
    }

    /**
     * Deletes an existing EventType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect([
            'index'
        ]);
    }

    /**
     * Finds the EventType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return EventType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EventType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findEvent($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUploadFile($attr, $id)
    {
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'event-type';
        $path = 'ecert/' . $id;

        return UploadFile::upload($model, $attr, 'updated_at', $path);
    }

    protected function clean($string)
    {
        $allowed = [
            'template'
        ];

        foreach ($allowed as $a) {
            if ($string == $a) {
                return $a;
            }
        }

        throw new NotFoundHttpException('Invalid Attribute');
    }

    public function actionDeleteFile($attr, $id)
    {
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $attr_db = $attr . '_file';

        $file = Yii::getAlias('@upload/' . $model->{$attr_db});

        $model->scenario = $attr . '_delete';
        $model->{$attr_db} = '';
        $model->updated_at = new Expression('NOW()');
        if ($model->save()) {
            if (is_file($file)) {
                unlink($file);
            }

            return Json::encode([
                'good' => 1
            ]);
        } else {
            return Json::encode([
                'errors' => $model->getErrors()
            ]);
        }
    }

    public function actionDownloadFile($attr, $id, $identity = true)
    {
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $filename = strtoupper($attr) . ' cert';

        UploadFile::download($model, $attr, $filename);
    }
}
