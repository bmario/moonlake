<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class Moonlake_View_Macro {

    protected $content = "";
    protected $attributes = array();
    protected $assigns = array();

    public function  __construct($attributes, $content, $assigns) {
        $this->attributes = $attributes;
        $this->content = $content;
        $this->assigns = $assigns;
    }

    public function render() {
        return $this->prepend().$this->content().$this->append();
    }

    abstract protected function content();
    abstract protected function prepend();
    abstract protected function append();
}

?>
