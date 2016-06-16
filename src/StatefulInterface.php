<?php

namespace MikeRice\Stateful;

/**
 * Interface StatefulInterface
 */
interface StatefulInterface
{
    public function getInitialState();

    public function setInitialState();

    public function getStateColumn();
}