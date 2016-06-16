<?php

namespace MikeRice\Stateful;

trait StatefulTrait
{
    /**
     * Overload methods.
     *
     * @param  str $method
     * @param  arr $parameters
     * @return void
     */
    public function __call($method, $parameters)
    {
        if (array_key_exists($method, $this->transitions)) {
            return $this->performTransition($method);
        } elseif (array_key_exists($method, $this->states) || in_array($method, $this->states)) {
            return $this->isState($method);
        }

        return parent::__call($method, $parameters);
    }

    /**
     * Determine if the state of the model is the given state.
     *
     * @param  str  $state
     * @return boolean
     */
    private function isState($state)
    {
        return $state === $this->{$this->getStateColumn()};
    }

    /**
     * Perform a state transition.
     *
     * @param  str $transition
     * @return void
     */
    private function performTransition($transition)
    {
        $to = $this->transitions[$transition]['to'];

        if ($this->canPerformTransition($transition)) {
            return $this->update([$this->getStateColumn() => $to]);
        }
    }

    /**
     * Determine if we can perform the state transition.
     *
     * @param  str $transition
     * @return boolean
     */
    private function canPerformTransition($transition)
    {
        $from = $this->transitions[$transition]['from'];
        $currentState = $this->{$this->getStateColumn()};

        return is_array($from) ? in_array($currentState, $from) : $currentState === $from;
    }

    /**
     * Set the initial state.
     *
     * @return void
     */
    public function setInitialState()
    {
        $this->setAttribute($this->getStateColumn(), $this->getInitialState());
    }

    /**
     * Get the inital state.
     *
     * @return str
     */
    public function getInitialState()
    {
        foreach ($this->states as $state => $value) {
            if ($value['inital']) {
               return $state;
            }
        }

        return false;
    }

    /**
     * Get the state attribute name.
     *
     * @return str
     */
    public function getStateColumn()
    {
        return defined('static::STATE') ? static::STATE : 'state';
    }
}