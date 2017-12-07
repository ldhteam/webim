<?php
namespace App\Controller;

use Swoole\Client\CURL;

class Page extends \Swoole\Controller
{
    function index()
    {
        $this->session->start();
        if (!empty($_SESSION['isLogin']))
        {
            chatroom:
            $this->http->redirect('/page/chatroom/');
            return;
        }

        if (!empty($_GET['token']))
        {
            $curl = new CURL();
            $user = $curl->get($this->config['login']['get_user_info'] . '?token=' . urlencode($_GET['token']));
            $user = json_decode('{"id":"2767","username":"sina_1967057333","usertype":"0","nickname":"\u4e00\u5207\u5747\u968f\u98ce","realname":"","intro":"","sex":"","email":"","mobile":"","php_level":"0","skill":"","company":"","blog":"http:\/\/blog.sina.com.cn\/engowiththewind","birth_year":"0","work_year":"0","avatar":"http:\/\/tva4.sinaimg.cn\/crop.0.0.180.180.180\/753ee9b5jw1e8qgp5bmzyj2050050aa8.jpg","education":"","certificate":"","province":"\u5317\u4eac","city":"\u671d\u9633\u533a","active_days":"0","vip":"0","gold":"0","login_times":"0"}');
            var_dump($user);die();
            if (empty($user))
            {
                login:
                $this->http->redirect($this->config['login']['passport'] . '?return_token=1&refer=' . urlencode($this->config['webim']['server']['origin']));
            }
            else
            {
                $_SESSION['isLogin'] = 1;
                $_SESSION['user'] = json_decode($user, true);
                goto chatroom;
            }
        }
        else
        {
            goto login;
        }
    }

    function chatroom()
    {
        $this->session->start();
        if (empty($_SESSION['isLogin']))
        {
            $this->http->redirect('/page/index/');
            return;
        }
        $user = $_SESSION['user'];
        $this->assign('user', $user);
        $this->assign('debug', 'true');
        $this->display('page/chatroom.php');
    }

    /**
     * 用flash添加照片
     */
    function upload()
    {
        if ($_FILES)
        {
            global $php;
            $php->upload->thumb_width = 136;
            $php->upload->thumb_height = 136;
            $php->upload->thumb_qulitity = 100;
            $up_pic = $php->upload->save('Filedata');
            if (empty($up_pic))
            {
                echo '上传失败，请重新上传！ Error:' . $php->upload->error_msg;
            }
            echo json_encode($up_pic);
        }
        else
        {
            echo "Bad Request\n";
        }
    }
}