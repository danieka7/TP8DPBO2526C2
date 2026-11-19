<?php

class Template
{
    var $filename = '';
    var $content = '';

    function __construct($filename = '')
    {
        $this->filename = $filename;

        $this->content = implode('', @file($filename));
    }

    // Menghapus placeholder DATA_* yang tidak diisi
    function clear()
    {
        $this->content = preg_replace("/DATA_[A-Z_0-9]+/", "", $this->content);
    }

    function write()
    {
        $this->clear();
        print $this->content;
    }

    function getContent()
    {
        $this->clear();
        return $this->content;
    }

    function replace($old = '', $new = '')
    {
        if (is_int($new)) {
            $value = sprintf("%d", $new);
        } elseif (is_float($new)) {
            $value = sprintf("%f", $new);
        } elseif (is_array($new)) {
            $value = '';

            foreach ($new as $item) {
                $value .= $item . ' ';
            }
        } else {
            $value = (string) $new;
        }
        // str_replace agar karakter seperti $ atau \ pada data tidak dianggap regex
        $this->content = str_replace($old, $value, $this->content);
    }
}
