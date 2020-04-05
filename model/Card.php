<?php namespace App\Model;


class Card
{
    public $card_id;
    public $title = "";
    public $list_state = "";
    public $content = "";
    public $label = "";
    public $created_by = "";

    public function __construct($dados){
        if( $dados["card_id"] )
            $this->card_id = $dados["card_id"];
        $this->title = $dados["title"];
        $this->list_state = $dados["list_state"] ?? $this->list_state;
        $this->content = $dados["content"];
        $this->label = $dados["label"] ?? $this->label;
        $this->created_by = $dados["created_by"];
    }

    public function metadata() {
        $show = [
        ];
        if( $this->card_id != null)
            $show["card_id"] = $this->card_id;
        if( $this->title != "")
            $show["title"] = $this->title;
        if( $this->list_state != "")
            $show["list_state"] = $this->list_state;
        if( $this->content != "")
            $show["content"] = $this->content;
        if( $this->label != "")
            $show["label"] = $this->label;
        if( $this->created_by != "")
            $show["created_by"] = $this->created_by;

        return $show;
    }

}

?>