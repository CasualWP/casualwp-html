<?php

namespace CasualWP\HTML;

class Element {
    protected $tag;
    protected $attributes;
    protected $content;

    public function __construct(string $tag, array $attributes = null, $content = null) {
        $this->tag = $tag;
        $this->attributes = $attributes;
        $this->content = $content;
        
        $this->attributes_string = !empty($attributes) ? $this->create_attributes_string($attributes) : null;
        $this->start_tag = $this->create_start_tag($this->tag, $this->attributes_string);
        $this->end_tag = boolval($this->content) ? $this->create_end_tag($this->tag) : null;
    }

    public function get_tag() : string {
        return $this->tag;
    }

    public function get_attributes() : ?array {
        return $this->attributes;
    }

    public function add_content($content) {
        if(is_array($content)) {
            $this->content = array_merge($this->content, $content);
        } else {
            $this->content[] = $content;
        }

        return $this;
    }

    public function get_content() : ?array {
        return $this->content;
    }

    public function render() : void {
        ob_start();
        echo $this->start_tag;

        if(!empty($this->content)) {
            if(is_array($this->content)) {
                array_walk($this->content, function($content) {
                    $this->render_content($content);
                });
            } else {
                $this->render_content($this->content);
            }
        }

        echo $this->end_tag;
        echo ob_get_clean();
    }

    protected function render_content($content) : void {
        if($content instanceof Element) {
            $content->render();
        } else {
            echo $content;
        }
    }

    protected function create_start_tag(string $tag, string $attributes_string = null) : string {
        return trim("<{$tag} {$attributes_string}>");
    }

    protected function create_end_tag(string $tag) : ?string {
        return "</{$tag}>";
    }

    protected function create_attributes_string(array $attributes) : ?string {
        $attributes_string = null;

        foreach($attributes as $attribute => $value) {
            if(empty($value)) {
                continue;
            }

            $attributes_string .= " {$attribute}='{$value}'";
        }

        return trim($attributes_string);
    }
}
