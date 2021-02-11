<?php
namespace app\api\controller;

class Face extends BaseController
{
    /**
     * 人脸搜索M:N识别API
     * 待识别图片中含有多个人脸时，在指定人脸集合中，找到这多个人脸分别最相似的人脸
     */
    public function multi_search($img = '', $dorm = '', $grade = '')
    {
        $token = $this->get_token();
        $url = 'https://aip.baidubce.com/rest/2.0/face/v3/multi-search?access_token=' . $token;
        $base64_one = base64_encode(file_get_contents($img)); // 转换为base64

        $dorm = $this->get_all_py($dorm); // 宿舍转为拼音
        $dorm = implode("", $dorm); // 把数组元素组合为字符串
        $bodys = array(
            'image' => $base64_one, // 图片
            'image_type' => "BASE64",  // 图片类型
            'group_id_list' => $grade . $dorm,  // 人脸库group
            "max_face_num" => 10,
            'max_user_num' => 10
        );

        $res = $this->request_post($url, $bodys);
        return $res;
    }

    // 添加人脸到人脸数据库（批量）
    public function add_face($id = '', $dorm = '', $grade = '', $img = '')
    {
        if (empty($grade)) {
            return json(['error_code' => 1, 'msg' => '请输入年级！']);
        } else if (empty($id)) {
            return json(['error_code' => 1, 'msg' => '请输入学号！']);
        } else if (empty($dorm)) {
            return json(['error_code' => 1, 'msg' => '请输入宿舍！']);
        } else if (empty($img)) {
            return json(['error_code' => 1, 'msg' => '请上传照片！']);
        }

        $data = array('face' => $img);
        Db('student')->where(['id' => $id])->setField($data);

        $token = $this->get_token();
        $url = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/user/add?access_token=' . $token;

        $base64_one = base64_encode(file_get_contents($img)); // 转换为base64
        $dorm = explode("#", $dorm)[0] . explode("#", $dorm)[1];
        $dorm = $this->get_all_py($dorm); // 东二410
        $dorm = implode("", $dorm);
        $bodys = array(
            'image' => $base64_one,
            'image_type' => "BASE64",
            'group_id' => $grade . $dorm,
            'user_id' => $id
        );

        $res = $this->request_post($url, $bodys);
        $res = json_decode($res, true);
        if ($res['error_code'] == 0) {
            dump('Add ' . $id . ' Success!');
        } else {
            dump('Add ' . $id . ' Failed!');
        }
    }

    /**
     * 在线图片活体检测
     */
    public function faceverify($img = '')
    {
        $token = $this->get_token();
        $url = 'https://aip.baidubce.com/rest/2.0/face/v3/faceverify?access_token=' . $token;
        $base64_one = base64_encode(file_get_contents($img)); // 转换为base64

        $bodys = array(
            'image' => $base64_one,
            'image_type' => "BASE64"
        );

        $res = $this->request_post($url, $bodys);
        return $res;
    }

    /**
     * 删除用户组
     */
    public function delete()
    {
        $token = $this->get_token();
        $url = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/group/delete?access_token=' . $token;

        $bodys = array(
            'group_id' => "student",
        );

        $res = $this->request_post($url, $bodys);
        return $res;
    }

    public function extract() // zip批量导入，处理人脸库
    {
        if (empty($_FILES['file'])) {
            return json(['error_code' => 1, 'msg' => '请选择.zip压缩包！']);
        } else if (empty($_POST['grade'])) {
            return json(['error_code' => 1, 'msg' => '请输入年级！']);
        }

        $file = request()->file('file');  // 压缩包上传至服务器地址
        $info = $file->move(ROOT_PATH . 'public', $_FILES['file']['name']);
        // move_uploaded_file($_FILES['file']['tmp_name'], $_FILES['file']['name']); 

        $zipName = $_FILES['file']['name'];

        $grade = $_POST['grade'];
        $toDir = 'face';

        $zip = new \ZipArchive;
        if ($zip->open($zipName) === true) {
            $rf = zip_open($zipName);
            $i = 0;

            if (!file_exists($toDir)) {
                mkdir($toDir, 777, true);
            }

            while ($fr = zip_read($rf)) {
                if (zip_entry_open($rf, $fr)) {

                    $fileInfo = $zip->statIndex($i, \ZipArchive::FL_ENC_RAW);
                    $fileName = iconv('GBK', 'UTF-8', $fileInfo['name']);

                    $file_path = substr($fileName, 0, strrpos($fileName, "/")); // 压缩包父文件夹
                    $file_name = substr($fileName, strrpos($fileName, "/") + 1, -1); // 压缩包名字

                    if (!is_dir($toDir . '/' . $file_path)) {  // 父文件夹存在则新建
                        mkdir($toDir . '/' . $file_path, 0777, true);
                    }

                    if (!is_dir($toDir . '/' . $file_name)) {  // 压缩包存在则写入
                        $content = zip_entry_read($fr, zip_entry_filesize($fr));
                        file_put_contents($toDir . '/' . $fileName, $content);
                    }

                    zip_entry_close($fr);
                    $i++;
                }
            }
            zip_close($rf);
        }

        $zip->close();

        if (!empty($zipName)) {  // 删除压缩包
            unlink($zipName);
        }

        $name = array();
        if (is_dir($toDir . '/' . $file_path)) {
            $files = scandir($toDir . '/' . $file_path);  // 遍历文件夹          
            $files = array_slice($files, 2);  // 截取文件名数组
            foreach ($files as $k => $v) {  // 提取文件名信息
                $student_id = explode("_", explode(".", $v)[0])[0];
                $name[$k]['student_id'] = $student_id;
                $name[$k]['file_path'] = $toDir . '/' . $file_path . '/' . $v;
                $name[$k]['dorm'] = Db('student')->where(['id' => $student_id])->field('dorm')->find()['dorm'];
            }
        } else {
            $files = scandir($toDir);
            $files = array_slice($files, 2);

            foreach ($files as $k => $v) {
                $student_id = explode("_", explode(".", $v)[0])[0];

                $name[$k]['student_id'] = $student_id;
                $name[$k]['file_path'] = $toDir . '/' . $v;
                $name[$k]['dorm'] = Db('student')->where(['id' => $student_id])->field('dorm')->find()['dorm'];
            }
        }

        foreach ($name as $k => $v) {
            $this->add_face($v['student_id'], $v['dorm'], $grade, $v['file_path']);
        }

        return json(['error_code' => 0, 'msg' => '添加人脸库结束！']);
    }

    public function add_face_single() // 添加及更新人脸（单次）
    {
        // $file = request()->file('file');
        if (empty($_POST['id'])) {
            return json(['error_code' => 1, 'msg' => '请输入学号！']);
        } else if (empty($_POST['grade'])) {
            return json(['error_code' => 1, 'msg' => '请输入年级！']);
        } else if (empty($_POST['department'])) {
            return json(['error_code' => 1, 'msg' => '请输入系！']);
        } else if (empty($_POST['dorm'])) {
            return json(['error_code' => 1, 'msg' => '请输入宿舍！']);
        } else if (empty($_FILES['img'])) {
            return json(['error_code' => 1, 'msg' => '请上传照片！']);
        }

        $type = array("jpeg", "jpg", "png", "bmp");  // 允许上传的图片后缀
        $temp = explode(".", $_FILES['img']['name']);  // 图片名
        $extension = $temp[count($temp) - 1];     // 获取文件后缀名

        if (in_array($extension, $type) && $_FILES["img"]["size"] < 5242880) {

            if ($_FILES["img"]["error"] > 0) {
                return json(['error_code' => 2, 'msg' => '文件上传错误！']);
            } else {
                $new_file_name = $_POST['id'];
                $new_name = $new_file_name . '.' . $extension; // 新文件名 学号.jpg

                $dir = 'face/' . $_POST['grade'] . $_POST['department'];
                $path = $dir . '/' . $new_name; //face为保存图片目录

                $token = $this->get_token();

                //是否存在该文件,存在则更新,否则添加
                if (file_exists($path)) {
                    // $return_data = array();
                    // $return_data['error_code'] = 5;
                    // $return_data['msg'] = '文件已存在！';
                    // return json($return_data);
                    // 更新
                    $url = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/user/update?access_token=' . $token;
                } else {
                    if (!file_exists($dir)) { // 路径不存在新建
                        mkdir($dir, 0777, true);
                    }
                    // 添加
                    $url = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/user/add?access_token=' . $token;
                }
                move_uploaded_file($_FILES['img']['tmp_name'], $path); // 上传至服务器 face/年级系 下
            }

            $base64_one = base64_encode(file_get_contents($path)); // 转换为base64
            $dorm = str_replace("#", '', $_POST['dorm']); // 替换掉#
            $dorm = $this->get_all_py($dorm); // 中二203
            $dorm = implode("", $dorm);
            $bodys = array(
                'image' => $base64_one,
                'image_type' => "BASE64",
                'group_id' => $_POST['grade'] . $dorm,
                'user_id' => $_POST['id']
            );

            $res = $this->request_post($url, $bodys);
            $res = json_decode($res, true);

            if ($res['error_code'] == 0) {
                Db('student') // 保存人脸照片路径至服务器
                    ->where('id', $_POST['id'])
                    ->setField('face', $path);
                return json(['error_code' => 0, 'msg' => '添加人脸库成功！']);
            } else {
                return json(['error_code' => 3, 'msg' => $res['error_msg']]);
            }
        }
    }

    public function getList() // 组列表查询
    {
        $token = $this->get_token();
        $url = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/group/getlist?access_token=' . $token;

        $bodys = array(
            'start' => 0
        );

        $res = $this->request_post($url, $bodys);
        return $res;
    }

    public function getAllUser()  //获取所有已经上传人脸库的名单
    {
        $res = $this->getlist();
        $res = json_decode($res, true);
        $res = $res['result']['group_id_list'];
        foreach ($res as $k => $v) {
            $list[$v] = json_decode($this->getusers($v), true)['result']['user_id_list'];
        }

        return json($list);
    }

    public function getUsers($group_id = '') // 获取用户列表
    {
        $token = $this->get_token();
        $url = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/group/getusers?access_token=' . $token;

        $bodys = array(
            'group_id' => $group_id,
        );

        $res = $this->request_post($url, $bodys);
        return $res;
    }

    // 拼音
    private $dict_list  = array(
        'a' => -20319, 'ai' => -20317, 'an' => -20304, 'ang' => -20295, 'ao' => -20292,
        'ba' => -20283, 'bai' => -20265, 'ban' => -20257, 'bang' => -20242, 'bao' => -20230, 'bei' => -20051, 'ben' => -20036, 'beng' => -20032, 'bi' => -20026, 'bian' => -20002, 'biao' => -19990, 'bie' => -19986, 'bin' => -19982, 'bing' => -19976, 'bo' => -19805, 'bu' => -19784,
        'ca' => -19775, 'cai' => -19774, 'can' => -19763, 'cang' => -19756, 'cao' => -19751, 'ce' => -19746, 'ceng' => -19741, 'cha' => -19739, 'chai' => -19728, 'chan' => -19725, 'chang' => -19715, 'chao' => -19540, 'che' => -19531, 'chen' => -19525, 'cheng' => -19515, 'chi' => -19500, 'chong' => -19484, 'chou' => -19479, 'chu' => -19467, 'chuai' => -19289, 'chuan' => -19288, 'chuang' => -19281, 'chui' => -19275, 'chun' => -19270, 'chuo' => -19263, 'ci' => -19261, 'cong' => -19249, 'cou' => -19243, 'cu' => -19242, 'cuan' => -19238, 'cui' => -19235, 'cun' => -19227, 'cuo' => -19224,
        'da' => -19218, 'dai' => -19212, 'dan' => -19038, 'dang' => -19023, 'dao' => -19018, 'de' => -19006, 'deng' => -19003, 'di' => -18996, 'dian' => -18977, 'diao' => -18961, 'die' => -18952, 'ding' => -18783, 'diu' => -18774, 'dong' => -18773, 'dou' => -18763, 'du' => -18756, 'duan' => -18741, 'dui' => -18735, 'dun' => -18731, 'duo' => -18722,
        'e' => -18710, 'en' => -18697, 'er' => -18696,
        'fa' => -18526, 'fan' => -18518, 'fang' => -18501, 'fei' => -18490, 'fen' => -18478, 'feng' => -18463, 'fo' => -18448, 'fou' => -18447, 'fu' => -18446,
        'ga' => -18239, 'gai' => -18237, 'gan' => -18231, 'gang' => -18220, 'gao' => -18211, 'ge' => -18201, 'gei' => -18184, 'gen' => -18183, 'geng' => -18181, 'gong' => -18012, 'gou' => -17997, 'gu' => -17988, 'gua' => -17970, 'guai' => -17964, 'guan' => -17961, 'guang' => -17950, 'gui' => -17947,
        'gun' => -17931, 'guo' => -17928,
        'ha' => -17922, 'hai' => -17759, 'han' => -17752, 'hang' => -17733, 'hao' => -17730, 'he' => -17721, 'hei' => -17703, 'hen' => -17701, 'heng' => -17697, 'hong' => -17692, 'hou' => -17683, 'hu' => -17676, 'hua' => -17496, 'huai' => -17487, 'huan' => -17482, 'huang' => -17468, 'hui' => -17454,
        'hun' => -17433, 'huo' => -17427,
        'ji' => -17417, 'jia' => -17202, 'jian' => -17185, 'jiang' => -16983, 'jiao' => -16970, 'jie' => -16942, 'jin' => -16915, 'jing' => -16733, 'jiong' => -16708, 'jiu' => -16706, 'ju' => -16689, 'juan' => -16664, 'jue' => -16657, 'jun' => -16647,
        'ka' => -16474, 'kai' => -16470, 'kan' => -16465, 'kang' => -16459, 'kao' => -16452, 'ke' => -16448, 'ken' => -16433, 'keng' => -16429, 'kong' => -16427, 'kou' => -16423, 'ku' => -16419, 'kua' => -16412, 'kuai' => -16407, 'kuan' => -16403, 'kuang' => -16401, 'kui' => -16393, 'kun' => -16220, 'kuo' => -16216,
        'la' => -16212, 'lai' => -16205, 'lan' => -16202, 'lang' => -16187, 'lao' => -16180, 'le' => -16171, 'lei' => -16169, 'leng' => -16158, 'li' => -16155, 'lia' => -15959, 'lian' => -15958, 'liang' => -15944, 'liao' => -15933, 'lie' => -15920, 'lin' => -15915, 'ling' => -15903, 'liu' => -15889,
        'long' => -15878, 'lou' => -15707, 'lu' => -15701, 'lv' => -15681, 'luan' => -15667, 'lue' => -15661, 'lun' => -15659, 'luo' => -15652,
        'ma' => -15640, 'mai' => -15631, 'man' => -15625, 'mang' => -15454, 'mao' => -15448, 'me' => -15436, 'mei' => -15435, 'men' => -15419, 'meng' => -15416, 'mi' => -15408, 'mian' => -15394, 'miao' => -15385, 'mie' => -15377, 'min' => -15375, 'ming' => -15369, 'miu' => -15363, 'mo' => -15362, 'mou' => -15183, 'mu' => -15180,
        'na' => -15165, 'nai' => -15158, 'nan' => -15153, 'nang' => -15150, 'nao' => -15149, 'ne' => -15144, 'nei' => -15143, 'nen' => -15141, 'neng' => -15140, 'ni' => -15139, 'nian' => -15128, 'niang' => -15121, 'niao' => -15119, 'nie' => -15117, 'nin' => -15110, 'ning' => -15109, 'niu' => -14941,
        'nong' => -14937, 'nu' => -14933, 'nv' => -14930, 'nuan' => -14929, 'nue' => -14928, 'nuo' => -14926,
        'o' => -14922, 'ou' => -14921,
        'pa' => -14914, 'pai' => -14908, 'pan' => -14902, 'pang' => -14894, 'pao' => -14889, 'pei' => -14882, 'pen' => -14873, 'peng' => -14871, 'pi' => -14857, 'pian' => -14678, 'piao' => -14674, 'pie' => -14670, 'pin' => -14668, 'ping' => -14663, 'po' => -14654, 'pu' => -14645,
        'qi' => -14630, 'qia' => -14594, 'qian' => -14429, 'qiang' => -14407, 'qiao' => -14399, 'qie' => -14384, 'qin' => -14379, 'qing' => -14368, 'qiong' => -14355, 'qiu' => -14353, 'qu' => -14345, 'quan' => -14170, 'que' => -14159, 'qun' => -14151,
        'ran' => -14149, 'rang' => -14145, 'rao' => -14140, 're' => -14137, 'ren' => -14135, 'reng' => -14125, 'ri' => -14123, 'rong' => -14122, 'rou' => -14112, 'ru' => -14109, 'ruan' => -14099, 'rui' => -14097, 'run' => -14094, 'ruo' => -14092,
        'sa' => -14090, 'sai' => -14087, 'san' => -14083, 'sang' => -13917, 'sao' => -13914, 'se' => -13910, 'sen' => -13907, 'seng' => -13906, 'sha' => -13905, 'shai' => -13896, 'shan' => -13894, 'shang' => -13878, 'shao' => -13870, 'she' => -13859, 'shen' => -13847, 'sheng' => -13831, 'shi' => -13658, 'shou' => -13611, 'shu' => -13601, 'shua' => -13406, 'shuai' => -13404, 'shuan' => -13400, 'shuang' => -13398, 'shui' => -13395, 'shun' => -13391, 'shuo' => -13387, 'si' => -13383, 'song' => -13367, 'sou' => -13359, 'su' => -13356, 'suan' => -13343, 'sui' => -13340, 'sun' => -13329, 'suo' => -13326,
        'ta' => -13318, 'tai' => -13147, 'tan' => -13138, 'tang' => -13120, 'tao' => -13107, 'te' => -13096, 'teng' => -13095, 'ti' => -13091, 'tian' => -13076, 'tiao' => -13068, 'tie' => -13063, 'ting' => -13060, 'tong' => -12888, 'tou' => -12875, 'tu' => -12871, 'tuan' => -12860, 'tui' => -12858, 'tun' => -12852, 'tuo' => -12849,
        'wa' => -12838, 'wai' => -12831, 'wan' => -12829, 'wang' => -12812, 'wei' => -12802, 'wen' => -12607, 'weng' => -12597, 'wo' => -12594, 'wu' => -12585,
        'xi' => -12556, 'xia' => -12359, 'xian' => -12346, 'xiang' => -12320, 'xiao' => -12300, 'xie' => -12120, 'xin' => -12099, 'xing' => -12089, 'xiong' => -12074, 'xiu' => -12067, 'xu' => -12058, 'xuan' => -12039, 'xue' => -11867, 'xun' => -11861,
        'ya' => -11847, 'yan' => -11831, 'yang' => -11798, 'yao' => -11781, 'ye' => -11604, 'yi' => -11589, 'yin' => -11536, 'ying' => -11358, 'yo' => -11340, 'yong' => -11339, 'you' => -11324, 'yu' => -11303, 'yuan' => -11097, 'yue' => -11077, 'yun' => -11067,
        'za' => -11055, 'zai' => -11052, 'zan' => -11045, 'zang' => -11041, 'zao' => -11038, 'ze' => -11024, 'zei' => -11020, 'zen' => -11019, 'zeng' => -11018, 'zha' => -11014, 'zhai' => -10838, 'zhan' => -10832, 'zhang' => -10815, 'zhao' => -10800, 'zhe' => -10790, 'zhen' => -10780, 'zheng' => -10764, 'zhi' => -10587, 'zhong' => -10544, 'zhou' => -10533, 'zhu' => -10519, 'zhua' => -10331, 'zhuai' => -10329, 'zhuan' => -10328, 'zhuang' => -10322, 'zhui' => -10315, 'zhun' => -10309, 'zhuo' => -10307, 'zi' => -10296, 'zong' => -10281, 'zou' => -10274, 'zu' => -10270, 'zuan' => -10262,
        'zui' => -10260, 'zun' => -10256, 'zuo' => -10254
    );

    // 输出全拼
    public function get_all_py($chinese, $charset = 'utf-8')
    {
        if ($charset != 'gb2312') $chinese = $this->_U2_Utf8_Gb($chinese);
        $py = $this->zh_to_pys($chinese);

        return $py;
    }

    private function _U2_Utf8_Gb($_C)
    {
        $_String = '';
        if ($_C < 0x80) $_String .= $_C;
        elseif ($_C < 0x800) {
            $_String .= chr(0xC0 | $_C >> 6);
            $_String .= chr(0x80 | $_C & 0x3F);
        } elseif ($_C < 0x10000) {
            $_String .= chr(0xE0 | $_C >> 12);
            $_String .= chr(0x80 | $_C >> 6 & 0x3F);
            $_String .= chr(0x80 | $_C & 0x3F);
        } elseif ($_C < 0x200000) {
            $_String .= chr(0xF0 | $_C >> 18);
            $_String .= chr(0x80 | $_C >> 12 & 0x3F);
            $_String .= chr(0x80 | $_C >> 6 & 0x3F);
            $_String .= chr(0x80 | $_C & 0x3F);
        }
        return iconv('UTF-8', 'GB2312', $_String);
    }

    private function zh_to_py($num, $blank = '')
    {
        if ($num > 0 && $num < 160) {
            return chr($num);
        } elseif ($num < -20319 || $num > -10247) {
            return $blank;
        } else {
            foreach ($this->dict_list as $py => $code) {
                if ($code > $num) break;
                $result = $py;
            }
            return $result;
        }
    }

    private function zh_to_pys($chinese)
    {
        $result = array();
        for ($i = 0; $i < strlen($chinese); $i++) {
            $p = ord(substr($chinese, $i, 1));
            if ($p > 160) {
                $q = ord(substr($chinese, ++$i, 1));
                $p = $p * 256 + $q - 65536;
            }
            $result[] = $this->zh_to_py($p);
        }
        return $result;
    }
}
