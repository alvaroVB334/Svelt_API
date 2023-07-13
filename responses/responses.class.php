<?php

class responses{
    
    public $response=[
        'status'=>'ok',
        'result'=>array()
    ];

    public function error_405(){
        $this->response['status']='error';
        $this->response['result']=array(
            'error_id'=>'405',
            'error_message'=>'Metodo no permitido'
        );
        return $this->response;
    }
    public function error_200($errorMsg="datos incorrectos"){
        $this->response['status']='error';
        $this->response['result']=array(
            'error_id'=>'200',
            'error_message'=>$errorMsg
        );
        return $this->response;
    }
    public function error_400(){
        $this->response['status']='error';
        $this->response['result']=array(
            'error_id'=>'400',
            'error_message'=>"Datos enviados incompletos o con formato incorrecto"
        );
        return $this->response;
    }
    public function error_401($valor="No está autorizado para realizar esa operación"){
        $this->response['status']='error';
        $this->response['result']=array(
            'error_id'=>'401',
            'error_message'=>$valor
        );
        return $this->response;
    }
    public function error_500($valor="Error 500 del servidor"){
        $this->response['status']='error';
        $this->response['result']=array(
            'error_id'=>'500',
            'error_message'=>$valor
        );
        return $this->response;
    }

}
