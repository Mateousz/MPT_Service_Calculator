<?php 
    class Service{
        public $category;
        public $name;
        public $quantity;
        public $mediaprice;
        public $laborfee;
        public $discountmedia;
        public $discountlabor;

        function __construct($category,$name,$quantity,$mediaprice,$laborfee,$discountmedia,$discountlabor){
            $this->category = $category;
            $this->name = $name;
            $this->quantity = $quantity;
            $this->mediaprice = $mediaprice;
            $this->laborfee = $laborfee;
            $this->discountmedia = $discountmedia;
            $this->discountlabor = $discountlabor;
        }
        function getCategory(){
            return $this->category;
        }
        function getService(){
            return $this->name;
        }
        function getQuantity(){
            return $this->quantity;
        }
        function getFullMedia(){
            return $this->mediaprice;
        }
        function getFullLabor(){
            return $this->laborfee;
        }
        function getDiscMedia(){
            return $this->discountmedia;
        }
        function getDiscLabor(){
            return $this->discountlabor;
        }
        function toString(){
            return $this->name;
        }
    }
?>