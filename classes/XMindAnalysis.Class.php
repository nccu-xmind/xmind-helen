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
    public function getAppCateList(){
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
     * 解構子歸還資源
     */
    function __destruct()
    {
        $this->dbh = null;
        unset($this->dbh);
    }
}
