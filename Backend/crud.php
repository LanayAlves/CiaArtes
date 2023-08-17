<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/teste_sima/Backend/conexao.php";

class Crud
{

    public function execute($sql, $where = null, $isOne = false, $isUpdate = false){
        try{
            $conexao = conexao::getInstance();
            $stm = $conexao->prepare($sql);
            if(isset($where)){
                foreach ($where as $key => $value) {
                    if(is_array($value)){
                        $stm->bindValue($key + 1,$value[0], $value[1]);
                    }else{
                        $stm->bindValue($key + 1,$value);
                    }
                }
            }
            $stm->execute();
            if($isOne && !$isUpdate){
                $data = $stm->fetch(PDO::FETCH_OBJ);
            }else if(!$isUpdate){
                $data = $stm->fetchAll(PDO::FETCH_OBJ);
            }else{
                $data = true;
            }
            return $data;
        }catch(PDOException $ex){
            return $ex;
        }
    }

    public function executeOne($sql,$where = null){
         return Crud::execute($sql,$where,true);
    }

    public function update ($sql,$where = null){
        return Crud::execute($sql,$where,false,true);
    }

    public function delete ($table, $filter = null){
        try{
            $conexao = conexao::getInstance();
            $sql = 'DELETE FROM '.$table.' WHERE 1 = 1 ';
            $where = Where::getWhere($filter);
            if(isset($where)){
                $sql = $sql.' AND ( '.$where['Where'].' )';
                $stm = $conexao->prepare($sql);
                foreach ($where['Values'] as $key => $value) {
                    $stm->bindValue($key + 1,$value);
                }
            }else{
                $stm = $conexao->prepare($sql);
            }
            $stm->execute();
            return 'success';
        }catch(PDOException $ex){
            return $ex;
        }
    }
}  
