<?php
/**
 * 将指定文件夹下的所有文件移动到新文件夹下
 *
 * User: wenshengping
 * Date: 2018/1/4
 * Time: 下午4:40
 */

class MoveFiles
{


//    public $strOriginalDir = '/Users/baidu/Downloads/BaiDuYunDownload/樊登读书会/2017年';
//    public $strDestinationPath = '/Users/baidu/Downloads/BaiDuYunDownload/樊登读书会/2015/';

    public function exec()
    {
        global $argc, $argv;

        if (empty($argv[1])) {
            throw new Exception("OriginalDir cannot be empty");
        } else if (empty($argv[2])) {
            throw new Exception("DestinationDir cannot be empty");
        }

        $strOriginalDir = $argv[1];
        $strDestinationDir = $argv[2];

        self::moveAllFiles($strOriginalDir, $strDestinationDir);
    }

    /**
     * 将指定文件夹下的所有文件移动到新文件夹下
     *
     * @param $strOriginalDir
     * @param $strDestinationDir
     */
    public function moveAllFiles($strOriginalDir, $strDestinationDir)
    {
        $result = array();
        $handle = opendir($strOriginalDir);
        $arrFiles = array();
        if ($handle) {
            while (($file = readdir($handle)) !== false) {
                if ($file != '.' && $file != '..') {
                    $cur_path = $strOriginalDir . DIRECTORY_SEPARATOR . $file;
                    if (is_dir($cur_path)) {
                        $result['dir'][$cur_path] = read_all_dir($cur_path);
                    } else {
                        $result['file'][] = $cur_path;

                        array_push($arrFiles, $cur_path);
                    }
                }
            }
            closedir($handle);
        }
        foreach ($arrFiles as $key => $value) {
            $pathInfo = pathinfo($value);
            $fileName = $pathInfo[basename];
            echo "$fileName\n";
            rename($value, $strDestinationDir . $fileName);

        }
    }


}

$test = new MoveFiles();
$test->exec();
exit(0);