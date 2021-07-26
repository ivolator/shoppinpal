<?php


namespace bookstore\services;


use bookstore\exceptions\Exception500;
use Exception;
use stdClass;

/**
 *
 * @author Vo
 *
 */
class JsonOutput
{

    /**
     * @param stdClass $data
     * @return string
     * @throws Exception
     */
    public function convertToJson($data): string
    {
        $ret = json_encode($data);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new Exception500('There was an error while encoding result to JSON');
        }
        return $ret;
    }
}