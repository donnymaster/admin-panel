<?php

namespace App\Services\AdminPanel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AjaxService
{
    /**
     * @var Request;
     */
    private $request;

    private $fields = [];

    /**
     * @var Model;
     */
    private $model;

    private $searchParams = [];

    private $searchParamsWhere = [];

    /**
     * @var int;
     */
    private const PER_PAGE_ITEMS = 15;

    private const VALIDATE_OPERATORS = [
        "=",
        "<",
        ">",
        "<=",
        ">=",
        "<>",
        "!=",
        "<=>",
        "like",
        "like binary",
        "not like",
        "ilike",
        "&",
        "|",
        "^",
        "<<",
        ">>",
        "&~",
        "is",
        "is not",
        "rlike",
        "not rlike",
        "regexp",
        "not regexp",
        "~",
        "~*",
        "!~",
        "!~*",
        "similar to",
        "not similar to",
        "not ilike",
        "~~*",
        "!~~*",
    ];

    public function __construct(
        Request $request = null,
        Model $model = null,
        array $fields = null
        ) {
        $this->request = $request;
        $this->model = $model;
        $this->fields = $fields;

        $this->generateFields();
        $this->generateSearchParams();
        $this->generateSearchParamsOperator();
    }

    public function setRequest(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function setFields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function setModel(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function ajax(): Response
    {
        $query = $this->model->newQuery();

        if (count($this->fields) >= 1) {
            $query = $query->select($this->fields);
        }

        foreach ($this->searchParamsWhere as $name => $value) {
            $query = $query->orWhere(...$this->makeCondition($name, $value));
        }

        $query = $query->limit(self::PER_PAGE_ITEMS);

        return response($query->get());
    }

    private function generateFields(): self
    {
        $this->fields = array_filter(
            explode(',', $this->request->get('fields', '')),
            fn ($item) => $item != ''
        );

        return $this;
    }

    private function generateSearchParams(): self
    {
        $raw = $this->request->get('search', []);

        foreach ($raw as $key => $value) {
            if (is_int($key)) unset($raw[$key]);

            if (is_null($value)) unset($raw[$key]);
        }

        $this->searchParams = $raw;

        return $this;
    }

    private function generateSearchParamsOperator(): self
    {
        $raw = collect($this->request->get('operator', []));

        foreach ($this->searchParams as $name => $value) {
            $operator = $raw->first( fn ($_, $key) => $key == $name);

            $this->searchParamsWhere[$name] = [
                'operator' => $this->validateOperator($operator, $value),
                'value' => $value
            ];
        }
        return $this;
    }

    private function validateOperator($rawOperator, $value): string
    {
        if (is_null($rawOperator)) {
            if (is_numeric($value)) return '=';

            if (is_string($value)) return 'like';
        }

        if (in_array($rawOperator, self::VALIDATE_OPERATORS)) return $rawOperator;

        return '=';
    }

    private function makeCondition($field, $value): array
    {
        $array = [$field];

        array_push($array, $value['operator']);

        if ($value['operator'] == 'like') {
            array_push($array, "%{$value['value']}%");
        } else {
            array_push($array, $value['value']);
        }

        return $array;
    }
}
