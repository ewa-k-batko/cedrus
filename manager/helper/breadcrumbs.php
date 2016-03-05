<?php

class Manager_Helper_Breadcrumbs
{

    private $list;

    public function set($level, Model_Link_Container $link)
    {
        $this->list[$level] = $link;
        return $this;
    }

    public function get($level = false)
    {
        if (!$level) {
            return $this->list;
        }
        return $this->list[$level];
    }

    public function render()
    {
        ksort($this->list);
        $res = null;
        foreach ($this->list as $level => $link) {
            $res .= $this->prepareLink($link);
        }
        return $res;
    }

    private function prepareLink(Model_Link_Container $link)
    {
        $item = '<div class="breadcrumbs-item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';
        $url = $link->getUrl();
        if (!empty($url)) {
            $item .= '<a class="breadcrumbs-url" href="' . $url . '" itemprop="url">';
            $item .= '<span class="breadcrumbs-url-title breadcrumbs-title" itemprop = "title">' . $link->getTitle() . '</span>';
            $item .= '</a>';
        } else {
            if ($link->isRoot()) {
                $item .= '<h1 class="breadcrumbs-title" itemprop = "title">' . $link->getTitle() . '</h1>';
            } else {
                $item .= '<strong class="breadcrumbs-title" itemprop = "title">' . $link->getTitle() . '</strong>';
            }
        }
        $item .= '</div>';
        return $item;
    }

}
