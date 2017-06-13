<?php
/**
 * Created by PhpStorm.
 * User: takuya
 * Date: 2017/06/13
 * Time: 12:04
 */
trait CommonModules {
    /*
     * 汎用空白チェック関数
     *
     * @param  $val    チェック対象の変数
     * @return boolean 空白の場合[true]
     */
    private function isBlank($val)
    {
        if (is_array($val)) {
            if (empty($val)) {
                return true;
            }
            $array_result = true;
            foreach ($val as $in) {
                $array_result = $this->isBlank($in);
                if (!$array_result) return false;
            }
            return $array_result;
        }
        // 全角は問答無用でtrim
        $val = trim(preg_replace('/　/', '', $val));

        if (strlen($val) > 0) {
            return false;
        }
        return true;
    }
}
