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


    public function exec()
    {
//        $strOriginalDir = '/Users/baidu/Downloads/BaiDuYunDownload/每天听本书mp3/test';
//        $strDestinationDir = '/Users/baidu/Downloads/BaiDuYunDownload/每天听本书mp3';
        global $argc, $argv;

        if (empty($argv[1])) {
            throw new Exception("OriginalDir cannot be empty");
        } else if (empty($argv[2])) {
            throw new Exception("DestinationDir cannot be empty");
        }

        $strOriginalDir = $argv[1];
        $strDestinationDir = $argv[2];

        $arrFiles = self::readAllFiles($strOriginalDir);
        self::moveAllFiles($arrFiles, $strDestinationDir);
    }

    /**
     * 将指定文件夹下的所有文件移动到新文件夹下
     *
     * @param $strOriginalDir
     * @return $array
     */
    public function readAllFiles($strOriginalDir)
    {
        $result = array();
        $handle = opendir($strOriginalDir);
        $arrFiles = array();
        if ($handle) {
            while (($file = readdir($handle)) !== false) {
                if ($file != '.' && $file != '..') {
                    $cur_path = $strOriginalDir . DIRECTORY_SEPARATOR . $file;
                    if (is_dir($cur_path)) {
                        $result['dir'][$cur_path] = self::readAllFiles($cur_path);
                    } else {
                        $result['file'][] = $cur_path;

                        array_push($arrFiles, $cur_path);
                    }
                }
            }
            closedir($handle);
        }
        return $arrFiles;
    }

    public function moveAllFiles($arrFiles, $strDestinationDir)
    {

        foreach ($arrFiles as $key => $value) {
            $pathInfo = pathinfo($value);
            $fileName = $pathInfo[basename];
            echo "$fileName\n";
            rename($value,  $strDestinationDir.'/'.$fileName);

        }
    }


}

$test = new MoveFiles();
$test->exec();
