<?php

namespace WpAdv\PostTypes;

abstract class PostTypeInterface
{

    public abstract function __construct($slug, array $args);

    public abstract function paginate($query);

}
