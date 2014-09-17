<?php

class Core_Image {

    public static function rename1($file_name, $file, $info) {
        if ($file_name->isUploaded()) {
            $time = ((int) microtime(true));
            $newName = $time . '_' . $file_name->getFileName($file, null, false);
            $path = $info['destination'] . date('/d/m/Y', $time);
            if (!is_dir($path))
                mkdir($path, 0777, true);
            $file_name->setDestination($path);
            $file_name->addFilter(new Zend_Filter_File_Rename(array('target' => $path . '/' . $newName, 'overwrite' => false)));
        }
    }

    public static function rename($file) {
        if ($file->isUploaded()) {
            $time = ((int) microtime(true));
            $oldName = pathinfo($file->getFileName());
            $newName = $time . '_' . $oldName['basename'];
            $path = $file->getDestination() . date('/d/m/Y', $time);
            if (!is_dir($path))
                mkdir($path, 0777, true);
            $file->setDestination($path);
            $file->addFilter(new Zend_Filter_File_Rename(array('target' => $newName, 'overwrite' => true)));
        }
    }

    public static function path($file, $site = 'backend', $thum = NULL) {
        if (!empty($thum) && ($thum == '40x40' || $thum == '40x50')) {
            $thum = '60x75';
        }
        if (self::isUrl($file)) {
            if (!empty($thum) && $thum != '1200x1500') {
                $ext = strrchr($file, '.');
                $file = str_replace($ext, "_{$thum}{$ext}", $file);
            }
            return $file;
        }
        if (preg_match('/^([0-9]+)\_/', $file, $matches)) {
            $time = (int) $matches[1];

            $param = array();
            $param[] = Core_Global::getApplicationIni()->app->static->{$site}->uploads;
            $param[] = date('d', $time);
            $param[] = date('m', $time);
            $param[] = date('Y', $time);

            if (!empty($thum)) {
                $param[] = $thum;
            }

            $param[] = $file;
            return join('/', $param);
        }
        return NULL;
    }

    public static function info($file, $thum = NULL) {
        if (!empty($thum) && ($thum == '40x40' || $thum == '40x50')) {
            $thum = '60x75';
        }
        if (self::isUrl($file)) {
            if (!empty($thum) && $thum != '1200x1500') {
                $ext = strrchr($file, '.');
                $file = str_replace($ext, "_{$thum}{$ext}", $file);
            }
            $info = getimagesize($file);
            if (!empty($info)) {
                return array('width' => $info[0], 'height' => $info[1]);
            } else {
                return array('width' => 0, 'height' => 0);
            }
        }
        if (preg_match('/^([0-9]+)\_/', $file, $matches)) {
            $time = (int) $matches[1];

            $param = array();
            $param[] = Core_Global::getApplicationIni()->app->static->backend->uploads_dir;
            $param[] = date('d', $time);
            $param[] = date('m', $time);
            $param[] = date('Y', $time);

            if (!empty($thum)) {
                $param[] = $thum;
            }


            $param[] = $file;

            $path = join(DIRECTORY_SEPARATOR, $param);
            if (is_file($path) && file_exists($path)) {
                $info = getimagesize($path);
                return array('width' => $info[0], 'height' => $info[1]);
            }
        }
        return array('width' => 0, 'height' => 0);
    }

    public static function remove($file) {
        if (preg_match('/^([0-9]+)\_/', $file, $matches)) {
            $time = (int) $matches[1];

            $param = array();
            $param[] = Core_Global::getApplicationIni()->app->static->backend->uploads_dir;
            $param[] = date('d', $time);
            $param[] = date('m', $time);
            $param[] = date('Y', $time);

            if ($thumb = Core_Global::getApplicationIni()->param->thumb) {
                foreach ($thumb as $folder => $t) {
                    $clone = $param;
                    $clone[] = $folder;
                    $clone[] = $file;

                    $path = join(DIRECTORY_SEPARATOR, $clone);
                    if (is_file($path) && file_exists($path)) {
                        unlink($path);
                    }
                }
            }


            $param[] = $file;

            $path = join(DIRECTORY_SEPARATOR, $param);
            if (is_file($path) && file_exists($path)) {
                unlink($path);
            }
        }
    }

    public static function isUrl($file) {
        if (preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $file)) {
            return true;
        }
        return false;
    }

}

?>