<?php

class MYSQLConnectionPDO {

    public static $instance = NULL;
    public static $connecion = NULL;

    private function __construct() {
        
    }

    private function __clone() {
        
    }

    public static function getInstance() {
        if (self::$instance == NULL) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection( $user = "", $password = "", $new_config = NULL ) {
        $cn = NULL;
        try {
            if (self::$connecion == NULL) {
                $cf = new config();
                
                if( $user!='' ){ $cf->setUser($user); }
                if( $password!='' ){ $cf->setPass($password); }
                if( $new_config!=NULL ){ $cf = $new_config; }
                
                //self::$connecion = new PDO($cf->getDns(), $cf->getUser(), $cf->getPassword(), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_PERSISTENT => true));
				self::$connecion = new PDO($cf->getDns(), $cf->getUser(), $cf->getPass(), array( PDO::ATTR_PERSISTENT => true));
                self::$connecion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            /*$cf = new config();
            $cn = new PDO($cf->getDns(), $cf->getUser(), $cf->getPassword(), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_PERSISTENT => true));
            $cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);*/
            //@$cn->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
            //echo json_encode(array('rst' => false, 'msg' => 'Error KNCHE0000000160007x16 : COBRAST not found'));
            exit();
        }
        //var_dump($cn);
        return self::$connecion;
    }

}

?>
