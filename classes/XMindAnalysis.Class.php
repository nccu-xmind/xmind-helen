<?php

/**
 * Description of XMindAnalysis
 * Xmind 資料分析類別
 *
 * @author ninthday <bee.me@ninthday.info>
 * @since version 1.0 2015-07-01
 * @copyright (c) 2015, ninthday
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

    public function setAppColorScheme($package_ids, $hex_colors)
    {
        if(count($package_ids) != count($hex_colors)){
            throw new Exception('應用程式編號數量與顏色數量不符！');
        }
        
        $sql = 'UPDATE `info_pkg` SET `color_scheme` = :color_scheme WHERE `id` = :id';
        try {
            $stmt = $this->dbh->prepare($sql);
            for($i = 0; $i < count($package_ids); $i++){
                $stmt->bindParam(':id', $package_ids[$i], \PDO::PARAM_INT);
                $stmt->bindParam(':color_scheme', $hex_colors[$i], \PDO::PARAM_STR);
                $stmt->execute();
            }
            
        } catch (\PDOException $exc) {
            throw new \Exception($exc->getMessage());
        }
    }

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
     * 解構子歸還資源
     */
    function __destruct()
    {
        $this->dbh = null;
        unset($this->dbh);
    }

}
