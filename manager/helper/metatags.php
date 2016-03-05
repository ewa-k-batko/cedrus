<?php

class Manager_Helper_Metatags
{

    private $title, $description, $keywords;

    public function setTitle($title, $concat = 'prepend', $join = ' - ')
    {
        $this->title = $this->concat($this->title, $title, $concat);
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setKeywords($keywords, $concat = 'prepend', $join = ',')
    {
        $this->keywords = $this->concat($this->keywords, $keywords, $concat);
        return $this;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setDescription($description, $concat = 'prepend', $join = ' ')
    {
        $this->description = $this->concat($this->description, $description, $concat);
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    private function concat($parent, $string, $concat = 'prepend', $join = ' ')
    {
        switch ($concat) {
            case 'prepend':
                return $string . $join . $parent;
                break;
            case 'append':
                return $parent . $join . $string;
                break;
            default:
                return $string;
                break;
        }
    }

}
