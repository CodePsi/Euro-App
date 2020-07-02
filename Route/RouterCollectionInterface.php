<?php


namespace Euro\Route;


interface RouterCollectionInterface
{
    function add($element): void;
    function addAll($elements): void;
    function contains($element): bool;
    function get($index);
    function indexOf($element);
    function remove($element);
    function size(): int;
}