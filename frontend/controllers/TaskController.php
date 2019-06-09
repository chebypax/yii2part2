<?php

namespace frontend\controllers;

use common\models\ProjectUser;
use common\models\query\ProjectQuery;
use common\models\query\TaskQuery;
use common\models\User;
use Yii;
use common\models\Task;
use common\models\search\TaskSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['user'],
                    ],

                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        /** @var TaskQuery $query*/
        $query = $dataProvider->query;
        $query->byUser(Yii::$app->user->id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!Yii::$app->taskService->canManage($model->project, \Yii::$app->user->identity))
        {
            return 'Что-то пошло не так!';
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $task = $this->findModel($id);
        if (!Yii::$app->taskService->canManage($task->project, \Yii::$app->user->identity))
        {
            return 'Что-то пошло не так!';
        }
        $task->delete();

        return $this->redirect(['index']);
    }

    public function actionTakeTask($id)
    {
        $task = $this->findModel($id);
        if (\Yii::$app->taskService->takeTask($task, \Yii::$app->user->identity))
        {
            \Yii::$app->taskService->informTakeTask($task, Yii::$app->user->identity);
            Yii::$app->session->setFlash('success', 'Задание принято в работу!');
            return $this->redirect(['view', 'id' => $task->id]);
        }
        return 'Что-то пошло не так!';

    }
    public function actionCompleteTask($id)
    {
        $task = $this->findModel($id);
        if (\Yii::$app->taskService->completeTask($task))
        {
            Yii::$app->taskService->informCompleteTask($task, $task->creator);
            $project = $task->project;
            if ($userId = $project->getProjectUsers()->where(['role' => ProjectUser::ROLE_TESTER])->one())
            {
                $user = User::findOne($userId->user_id);
                Yii::$app->taskService->informCompleteTask($task, $user);
            }
            Yii::$app->session->setFlash('success', 'Задание выполнено!');
            return $this->redirect(['view', 'id' => $task->id]);
        }
        return 'Что-то пошло не так!';
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
