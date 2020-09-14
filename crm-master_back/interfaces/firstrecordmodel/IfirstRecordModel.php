<?php

namespace app\interfaces\firstrecordmodel;

/**
 * this interface for any model
 */
interface IfirstRecordModel
{
    /**
     * 
     * This method returns the first record of any model
     * 
     * @param  string $id
     * @return iterable
     */
    public function getFirstRecordModel(?string $id = null);
}
