<?php


namespace bookstore\models;


use bookstore\exceptions\Exception400;

class Author
{
    protected string $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @throws Exception400
     */
    public function setName(string $name): void
    {
        if (empty($name)){
            throw new Exception400("Missing or invalid Author name");
        }
        $this->name = $name;
    }


}