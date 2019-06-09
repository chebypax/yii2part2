<?php
namespace common\services;

use Yii;
use yii\base\Component;


class EmailService implements EmailServiceInterface
{
    public function send($to, $subject, $viewHTML, $viewText, $data)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => $viewHTML, 'text' => $viewText],
                $data
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }

}