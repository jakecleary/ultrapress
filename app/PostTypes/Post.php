<?php

namespace UltraPress\PostTypes;

use WP_Post;
use WP_Query;
use UltraPress\PostTypes\PostType;

class Post extends PostType
{

    public function __construct()
    {
        $this->postType = 'post';
        $this->singular = $this->postType;
        $this->plural   = $this->postType . 's';
    }

}
