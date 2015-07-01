<?php


/**
 * Description of XMindAnalysis
 *
 * @author jeffy
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
