<?php

namespace App\Services\LogsDecoder;

class EventAbi
{
    protected $abi;
    protected $inputs = [];
    protected $indexedInputs = [];
    protected $nonIndexedInputs = [];

    public function __construct(array $abi)
    {
        $this->abi = $abi;
        $this->setInputsFromAbi($abi);
    }

    public function getAbi(): array
    {
        return $this->abi;
    }

    public function getInputs(): array
    {
        return $this->inputs;
    }

    public function getIndexedInputs(): array
    {
        return $this->indexedInputs;
    }

    public function getNonIndexedInputs(): array
    {
        return $this->nonIndexedInputs;
    }

    public function setInputs(array $inputs): void
    {
        $this->inputs = $inputs;
    }

    public function setIndexedInputs(array $indexedInputs): void
    {
        $this->indexedInputs = $indexedInputs;
    }

    public function setNonIndexedInputs(array $nonIndexedInputs): void
    {
        $this->nonIndexedInputs = $nonIndexedInputs;
    }

    public function getInputsTypes(bool $indexed): array
    {
        $inputs = $indexed ? $this->indexedInputs : $this->nonIndexedInputs;
        $types = [];
        foreach ($inputs as $input) {
            $types[] = $input['type'];
        }
        return $types;
    }

    protected function setInputsFromAbi(array $abi): void
    {
        $inputs = $abi['inputs'] ?? [];
        $indexedInputs = [];
        $nonIndexedInputs = [];
        foreach ($inputs as $input) {
            if ($input['indexed'] ?? false) {
                $indexedInputs[] = $input;
            } else {
                $nonIndexedInputs[] = $input;
            }
        }
        $this->setInputs($inputs);
        $this->setIndexedInputs($indexedInputs);
        $this->setNonIndexedInputs($nonIndexedInputs);
    }
}
