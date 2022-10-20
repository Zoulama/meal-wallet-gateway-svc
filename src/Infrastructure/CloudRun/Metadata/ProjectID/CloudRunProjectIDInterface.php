<?php


namespace MealWallet\Infrastructure\CloudRun\Metadata\ProjectID;


interface CloudRunProjectIDInterface
{
    /**
     * @return string
     */
    public function projectId():string;
}
