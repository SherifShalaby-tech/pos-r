<?php

// general function get subCategory paths
function getSubcategoryPaths($category, $paths = [], $path = [])
{
    $path[] = $category->name;

    foreach ($category->children as $child) {
        getSubcategoryPaths($child, $paths, $path);
    }

    $paths[] = $path;
}
