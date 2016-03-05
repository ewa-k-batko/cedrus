<?php

class Manager_Helper_Opengraph
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

//jak bedzie facebook
/*<meta property="og:title" content="THE CYCLE OF PLUMS" />
    <meta property="og:url" content="http://www.montere.it/?page_id=5222&amp;lang=en" />
    <meta property="og:image" content="http://www.montere.it/wp-content/uploads/2014/02/cp27.jpg" />
    <meta property="og:site_name" content="Monte Ré" />
    <meta property="og:description" content="The production of plums for drying is carried out in highly specialised farms by producers who choose to adopt it as their main arboreal cultivation..." />
<meta property="fb:app_id" content="438577716225831" />*/
