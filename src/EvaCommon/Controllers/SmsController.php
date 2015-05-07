<?php

namespace Eva\EvaCommon\Controllers;

use Eva\EvaEngine\Mvc\Controller\ControllerBase as Controller;
use Eva\EvaEngine\Exception;

class SmsController extends Controller
{
    /**
     * 发送验证码
     * @param mobile 待发送手机号
     * @param type   验证码类型，如注册，找回密码,具体见配置文件 template
     * @return string
    */
    public function captchaAction()
    {
        $this->view->disable();

        $mobile = $this->request->getPost('mobile');
        $type = $this->request->getPost('type','string' ,'default');

        if (empty($mobile)) {
            return $this->showResponseAsJson(['ret: 1', 'message' => 'no mobile']);
        } else {
            $search ='/^(1(([35][0-9])|(47)|[8][0126789]))\d{8}$/';
            if(!preg_match($search,$mobile)) { //手机号格式不正确
                return $this->showResponseAsJson(['ret: 2', 'message' => 'incorrect mobile']);
            }
        }

        $cache = $this->getDI()->get('modelsCache');
        $cacheKey = 'sms_captcha_' . $type . $mobile;

        $now = time();
        if ($cache->exists($cacheKey)) {
            $data = $cache->get($cacheKey);
            //60s内不重复发送
            if (($now - $data['timestamp']) < 60) {
                return;
            }
        }

        /** @var \Eva\EvaSms\Sender $sender */
        $sender = $this->getDI()->getSmsSender();
        $captcha = mt_rand(100000, 999999);
        $templates = $this->getDI()->getConfig()->smsSender->templates;
        if (isset($templates[$type])) {
            $templateId = $templates[$type];
        } else {
            $templateId = $templates->commonCode;
        }

        $result = $sender->sendTemplateMessage($mobile, $templateId, ['number' => $captcha]);

        $data['timestamp'] = $now;
        $data['captcha'] = $captcha;

        //一小时内有效
        $cacheTime = 1 * 60 * 60;
        $cache->save($cacheKey, $data, $cacheTime);

        return $this->showResponseAsJson(['ret' => 0, 'message' => 'success']);
    }

    public function captchaCheckAction()
    {
        $this->view->disable();

        $mobile = $this->request->getPost('mobile');
        $type = $this->request->getPost('type','string' ,'default');
        $captcha = $this->request->getPost('captcha');

        $cache = $this->getDI()->get('modelsCache');

        $mobileCountKey = 'mobile_count' . $mobile;
        $mobileCountKey = md5($mobileCountKey);
        if ($cache->exists($mobileCountKey)) {
            $mobileCount = $cache->get($mobileCountKey);
            $cache->save($mobileCountKey, $mobileCount+1, 5 * 60);
            if ($mobileCount > 5) { //尝试超过5次
                return $this->showResponseAsJson(['ret' => 2, 'message' => 'has no chance to try']);
            }
        } else {
            $cache->save($mobileCountKey, 0, 5 * 60);
        }

        $cacheKey = 'sms_captcha_' . $type . $mobile;
        if ($cache->exists($cacheKey)) {
            $data = $cache->get($cacheKey);
            if ($data['captcha'] == $captcha) {
                return $this->showResponseAsJson(['ret' => 0, 'message' => 'correct']);
            }
        }
        return $this->showResponseAsJson(['ret' => 1, 'message' => 'incorrect']);
    }

}
