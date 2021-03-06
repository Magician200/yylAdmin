<?php
/*
 * @Description  : 系统设置
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-08-05
 * @LastEditTime : 2020-11-21
 */

namespace app\admin\controller;

use think\facade\Request;
use app\admin\validate\AdminVerifyValidate;
use app\admin\validate\AdminTokenValidate;
use app\admin\service\AdminSettingService;

class AdminSetting
{
    /**
     * 缓存设置
     *
     * @method GET
     *
     * @return json
     */
    public function settingCache()
    {
        if (Request::isGet()) {
            $data = AdminSettingService::settingCache();
        } else {
            $data = AdminSettingService::settingCache([], 'post');
        }

        return success($data);
    }

    /**
     * 验证码设置
     *
     * @method GET|POST
     *
     * @return josn
     */
    public function settingVerify()
    {
        if (Request::isGet()) {
            $data = AdminSettingService::settingVerify();
        } else {
            $param = Request::only(
                [
                    'type'   => 1,
                    'length' => 4,
                    'expire' => 180,
                ]
            );
            $param['switch'] = Request::param('switch/b', false);
            $param['curve']  = Request::param('curve/b', false);
            $param['noise']  = Request::param('noise/b', false);
            $param['bgimg']  = Request::param('bgimg/b', false);

            validate(AdminVerifyValidate::class)->scene('edit')->check($param);

            $data = AdminSettingService::settingVerify($param, 'post');
        }

        return success($data);
    }

    /**
     * Token设置
     *
     * @method GET|POST
     *
     * @return josn
     */
    public function settingToken()
    {
        if (Request::isGet()) {
            $data = AdminSettingService::settingToken();
        } else {
            $param = Request::only(
                [
                    'iss' => 'yylAdmin',
                    'exp' => 12,
                ]
            );

            validate(AdminTokenValidate::class)->scene('edit')->check($param);

            $data = AdminSettingService::settingToken($param, 'post');
        }

        return success($data);
    }

    /**
     * 服务器信息
     *
     * @method GET
     *
     * @return json
     */
    public function serverInfo()
    {
        $data = AdminSettingService::serverInfo();

        return success($data);
    }
}
