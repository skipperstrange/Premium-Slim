<?php

namespace Premium\Models;




class Search extends \Illuminate\Database\Eloquent\Model
{
    protected $table = '';
    public $_order_by = 'id DESC';
    public $_search_fields = array('id'); //Feilds to be matched against for dearch 
    public $_data_feilds = array('id'); // Feilds to be returned after search
    public $keyword;

    function setSearchFields(array $fields)
    {
        $this->_search_fields = $fields;
    }

    function setDataFields(array $fields)
    {
        $this->_data_fields = $fields;
    }


    public function SetModel($model){
        $this->table = $model;
    }

    function setKeyword(string $keyword){
        $this->keyword = $keyword;
    }

    public function Search(){  

        $results = $this->select($this->_data_fields);
        foreach ($this->_search_fields as $field => $value) {
            
             $results->orWhere($value, 'LIKE', "%{$this->keyword}%");
        } 

        return $results->get();
    }
   
}
