<?php

class Where
{
    public function getWhere ($filter){
        if(isset($filter)){
            $where = '';
            $values = array();
            foreach ($filter as $value) {
                if(empty($values)){
                    $where = $value['Params'].' '.$value['Operator'].' ?';
                }else{
                    $where = $where.' '.$value['Option'].' '.$value['Params'].' '.$value['Operator'].' ?';
                }
                array_push($values,$value['Value']);
            }
            return array('Where' => $where,'Values' => $values);
        }else{
            return null;
        }
    }
}
