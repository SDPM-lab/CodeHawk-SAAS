<?php
    class _Xml{
        public $Element = array();
    }

    class _Element{
        //Component(0) Interface(1) Class(2)
        public $type;
        public $Name;
        public $id;
        public $Operation = array();
    }

    class _Operation{
        public $Name;
        public $Visibility;
        public $isVoid = true;
        public $Parameter = array();
        public $kind = array();
        public $DataType = array();
    }
?>