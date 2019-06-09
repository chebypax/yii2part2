<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property Task @activedTasks
 * @property Task @createdTasks
 * @property Task @updatedTasks
 * @property Project @createdProjects
 * @property Project @updatedProjects
 * @property ProjectUser @role
 */
class User extends ActiveRecord implements IdentityInterface
{
    private $password;

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const STATUSES = [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_INACTIVE];
    const STATUS_LABELS = [
        self::STATUS_INACTIVE => 'Неактивный',
        self::STATUS_DELETED => 'Удален',
        self::STATUS_ACTIVE => 'Активный'
    ];

    const SCENARIO_UPDATE = 'update';
    const SCENARIO_CREATE = 'create';

    const AVATAR_SMALL = 'smallPhoto';
    const AVATAR_PREVIEW = 'previewPhoto';

    const RELATION_ACTIVED_TASKS = 'activedTasks';
    const RELATION_CREATED_TASKS = 'createdTasks';
    const RELATION_UPDATED_TASKS = 'updatedTasks';
    const RELATION_CREATED_PROJECTS = 'createdProjects';
    const RELATION_UPDATED_PROJECTS = 'updatedProjects';
    const RELATION_ROLE = 'role';

    public function getRole()
    {
        return $this->hasOne(ProjectUser::class, ['user_id' => 'id']);
    }

    public function getActivedTasks()
    {
        return $this->hasMany(Task::class, ['executor_id'=>'id']);
    }

    public function getCreatedTasks()
    {
        return $this->hasMany(Task::class, ['created_at' => 'id']);
    }
    public function getUpdatedTasks()
    {
        return $this->hasMany(Task::class, ['updater_id' => 'id']);
    }
    public function getCreatedProjects()
    {
        return $this->hasMany(Project::class, ['creator_id' => 'id']);
    }
    public function getUpdatedProjects()
    {
        return $this->hasMany(Project::class, ['updater_id' => 'id']);
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => \mohorev\file\UploadImageBehavior::class,
                'attribute' => 'avatar',
                'scenarios' => [self::SCENARIO_UPDATE],
                //'placeholder' => '@app/modules/user/assets/images/userpic.jpg',
                'path' => '@frontend/web/upload/user/{id}',
                'url' => Yii::$app->params['host.front'] . Yii::getAlias('@web/upload/user/{id}'),
                'thumbs' => [
                    self::AVATAR_SMALL => ['width' => 30, 'height' => 30, 'quality' => 90],
                    self::AVATAR_PREVIEW => ['width' => 200, 'height' => 200],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            ['password', 'safe'],
            ['email', 'email'],
            ['email', 'email', 'on' => self::SCENARIO_CREATE],
            ['email', 'email', 'on' => self::SCENARIO_UPDATE],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => self::STATUSES],
            ['avatar', 'image', 'extensions' => 'jpeg, jpg, png, gif','on' => self::SCENARIO_UPDATE],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->generateAuthKey();
        $this->generateEmailVerificationToken();


        return true;
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }




    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
        if ($password) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }
    }

    public function  getPassword()
    {
        return $this->password;
    }


    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UserQuery(get_called_class());
    }


}
