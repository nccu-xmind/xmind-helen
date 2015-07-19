<?php

/**
 * Description of XMindAnalysis
 * Xmind 資料分析類別
 *
 * @author ninthday <bee.me@ninthday.info>
 * @since version 1.0 2015-07-01
 * @copyright (c) 2015, ninthday
 * @version 1.2
 * 
 */

namespace ninthday\xmind;

class XMindAnalysis
{

    private $dbh = null;

    /**
     * 建構子包含連線設定
     * @param \ninthday\niceToolbar\myPDOConn $pdoConn myPDOConn object
     */
    function __construct(\ninthday\niceToolbar\myPDOConn $pdoConn)
    {
        $this->dbh = $pdoConn->dbh;
    }

    /**
     * 取得目前所有的應用程式分類清單，依照每個類別中的應用程式數量多寡降冪
     * 
     * @return array ['category']：分類，[CNT]：應用程式數
     * @throws \Exception
     * @since version 1.0
     * @access public
     */
    public function getAppCateList()
    {
        $ary_rtn = array();
        $sql = 'SELECT `category`, COUNT(*) AS `CNT` FROM `info_pkg` WHERE `category` != \'Unknow\''
                . ' GROUP BY `category` ORDER BY `CNT` DESC';
//        $sql = 'SELECT `type`, `category`, COUNT(*) AS `CNT` FROM `info_pkg`
//            GROUP BY `category`, `type` ORDER BY `category`';
        try {
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();

            $rs = $stmt->fetchAll(\PDO::FETCH_NUM);
            foreach ($rs as $row) {
                array_push($ary_rtn, $row[0]);
            }
        } catch (\PDOException $exc) {
            throw new \Exception($exc->getMessage());
        }
        return $ary_rtn;
    }

    /**
     * 取得編碼後的使用者清單（不包含開發者）
     * 
     * @return array 使用者清單
     * @throws \Exception
     * @since version 1.0
     * @access public
     */
    public function getEncodeUserList()
    {
        $ary_rtn = array();
        $sql = 'SELECT DISTINCT `encode` FROM `info_user` WHERE `encode` != \'Programmer\''
                . ' ORDER BY `encode` DESC';
        try {
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();

            $rs = $stmt->fetchAll(\PDO::FETCH_NUM);
            foreach ($rs as $row) {
                array_push($ary_rtn, $row[0]);
            }
        } catch (\PDOException $exc) {
            throw new \Exception($exc->getMessage());
        }
        return $ary_rtn;
    }

    /**
     * 設定應用程式的色碼資料
     * 
     * @param array $package_ids 應用程式編號陣列
     * @param array $hex_colors 網頁色碼陣列
     * @throws \Exception
     * @since version 1.1
     */
    public function setAppColorScheme($package_ids, $hex_colors)
    {
        if (count($package_ids) != count($hex_colors)) {
            throw new \Exception('應用程式編號數量與顏色數量不符！');
        }

        $sql = 'UPDATE `info_pkg` SET `color_scheme` = :color_scheme WHERE `id` = :id';
        try {
            $stmt = $this->dbh->prepare($sql);
            for ($i = 0; $i < count($package_ids); $i++) {
                $stmt->bindParam(':id', $package_ids[$i], \PDO::PARAM_INT);
                $stmt->bindParam(':color_scheme', $hex_colors[$i], \PDO::PARAM_STR);
                $stmt->execute();
            }
        } catch (\PDOException $exc) {
            throw new \Exception($exc->getMessage());
        }
    }

    /**
     * 取得有色碼仍為 NULL 的類型及分類名稱陣列
     * 
     * @return array 類型及分類名稱陣列，[0]: 類型，[1]: 分類
     * @throws \Exception
     * @since version 1.1
     */
    public function getAppTypeCate()
    {
        $ary_rtn = array();
        $sql = 'SELECT `type`, `category` FROM `info_pkg` WHERE `color_scheme` IS NULL '
                . 'GROUP BY `type`, `category` ';
        try {
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();

            $rs = $stmt->fetchAll(\PDO::FETCH_NUM);
            foreach ($rs as $row) {
                array_push($ary_rtn, $row);
            }
        } catch (\PDOException $exc) {
            throw new \Exception($exc->getMessage());
        }
        return $ary_rtn;
    }

    /**
     * 指定應用程式類型、分類取得資料表的應用程式編號
     * 
     * @param string $type 應用程式類型（APP、GAME）
     * @param string $category 應用程式分類
     * @return array 應用程式編號
     * @throws \Exception
     * @since version 1.1
     */
    public function getPackageIDByTypeCate($type, $category)
    {
        $ary_rtn = array();
        $sql = 'SELECT `id` FROM `info_pkg` WHERE `type` = \'' . $type . '\' AND `category` = \'' . $category . '\' ';
        try {
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();

            $rs = $stmt->fetchAll(\PDO::FETCH_NUM);
            foreach ($rs as $row) {
                array_push($ary_rtn, $row[0]);
            }
        } catch (\PDOException $exc) {
            throw new \Exception($exc->getMessage());
        }
        return $ary_rtn;
    }

    /**
     * 由使用者ID、指定的年月、應用程式名稱回傳使用者LOG
     * 
     * @param string $user_id 使用者ID
     * @param string $use_time 指定的時間，年-月 ex:2013-02
     * @param string  $app_name 應用程式名稱
     * @return array [0]: 使用者ID,[1]: 時間（Datetime）,[2]: Acitvity
     * @throws \Exception
     * @since version 1.2
     */
    public function getLogByUserTimeApp($user_id, $use_time, $app_name)
    {
        $ary_rtn = array();
        $package_name = $this->getPackageNameByAppName($app_name);
        $sql = 'SELECT FROM_UNIXTIME(`Time_Stamp`, "%Y-%m") AS `MYTIME`, FROM_UNIXTIME(`Time_Stamp`) AS `USETIME`, `Name_Activity` '
                . 'FROM `activitylogs` '
                . 'WHERE `ID_User` = :userid AND `Name_App` = :package HAVING `MYTIME` = :usetime';
        try {
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':userid', $user_id, \PDO::PARAM_STR);
            $stmt->bindParam(':package', $package_name, \PDO::PARAM_STR);
            $stmt->bindParam(':usetime', $use_time, \PDO::PARAM_STR);
            $stmt->execute();
            
            $rs = $stmt->fetchAll(\PDO::FETCH_NUM);
            foreach ($rs as $row) {
                array_push($ary_rtn, array(
                    'userid' => $user_id,
                    'usetime' => $row[1],
                    'activity' => $row[2]
                ));
            }
        } catch (\PDOException $exc) {
            throw new \Exception($exc->getMessage());
        }
        return $ary_rtn;
    }

    /**
     * 由應用程式名稱取得套件名稱
     * 
     * @param string $app_name 應用程式名稱
     * @return string 應用程式的套件名稱
     * @throws \Exception
     * @since version 1.2
     */
    private function getPackageNameByAppName($app_name)
    {
        $rtn = '';
        $sql = 'SELECT `pkgName` FROM `info_pkg` WHERE `appname` =\'' . $app_name . '\'';
        try {
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();

            $rs = $stmt->fetch(\PDO::FETCH_NUM);
            $rtn = $rs[0];
        } catch (\PDOException $exc) {
            throw new \Exception($exc->getMessage());
        }
        return $rtn;
    }

    /**
     * 解構子歸還資源
     */
    function __destruct()
    {
        $this->dbh = null;
        unset($this->dbh);
    }

}
