<?php
/**
 * Created by PhpStorm.
 * User: secret
 * Date: 16.04.18
 * Time: 16:26
 */

include_once('libphp/base.obj.inc.php');

class RelocatePhoto extends NeadsContentUtil
{


    private function getUrlProductPhoto()
    {
        $QS = 'SELECT `bigPhoto`,`smallPhoto`,`mediumPhoto`,`main__catalog`.`id`
                     FROM `main__catalog_pics` 
                         LEFT JOIN `main__catalog` ON `main__catalog_pics`.`catalogID` = `main__catalog`.`id`    ';

        parent::Retrieve($QS);

        return $this->Items;
    }


    public function copyFile()
    {
        $countResult = '';
        $errorResult = '';
        $errorURL = array();

        $productInfo = $this->getUrlProductPhoto();
        if (!empty($productInfo)) {
            foreach ($productInfo AS $detail) {
                if (!empty($detail->mediumPhoto)) {
                    $countResult++;

                    $url = "/var/www/t/www.xn--80aqft7b.xn--j1amh" . $detail->mediumPhoto;
                    $file = '/var/www/shapki/temp' . $detail->mediumPhoto;

                    $res = copy($url, $file);

                    if (!$res) {
                        $errorResult++;
                        $errorURL['medium'][] = $detail->bigPhoto;
                    }
                }

                if (!empty($detail->smallPhoto)) {
                    $countResult++;

                    $url = "/var/www/t/www.xn--80aqft7b.xn--j1amh" . $detail->smallPhoto;
                    $file = '/var/www/shapki/temp' . $detail->smallPhoto;

                    $res = copy($url, $file);

                    if (!$res) {
                        $errorResult++;
                        $errorURL['small'][] = $detail->bigPhoto;
                    }
                }

                if (!empty($detail->bigPhoto)) {
                    $countResult++;
                    $url = "/var/www/t/www.xn--80aqft7b.xn--j1amh" . $detail->bigPhoto;
                    $file = '/var/www/shapki/temp' . $detail->bigPhoto;
                    
                    $res = copy($url, $file);

                    if (!$res) {
                        $errorResult++;
                        $errorURL['big'][] = $detail->bigPhoto;
                    }
                }
            }
        }

        dumper($countResult);
        dumper($errorResult);
        dumper( $errorURL);
    }
}

$relocatePhoto = new RelocatePhoto();
$result = $relocatePhoto->copyFile();
