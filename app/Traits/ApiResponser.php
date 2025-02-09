<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser
{
    protected function successResponse($data, int $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, int $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showMultiple($data, $code = 200)
    {
        return $this->successResponse([
            'status' => 'Success',
            'statusCode' => $code,
            'data' => $data
        ], $code);
    }

    protected function showAll(Collection $collection, $code = 200, $pageMutated = false, $sumField = null)
    {
        if($sumField){
            $sumData = $collection->sum($sumField);
        }
        $collection = $this->filterData($collection);
        $collection = $this->sortData($collection);
        $collection = $this->paginate($collection, $pageMutated);
        $collection = $this->cacheResponse($collection);

        // $collection = $collection->shuffle();

        $responseArray = [
            'status' => 'Success',
            'statusCode' => $code,
            'numberOfEntry' => $collection->count(),
            'totalSum' => $sumData ?? null,
            'data' => $collection
        ];

        return $this->successResponse($responseArray, $code);
    }

    protected function showOne(Model $model, $code = 200)
    {
        return $this->successResponse([
            'status' => 'Success',
            'statusCode' => $code,
            'data' => $model
        ], $code);
    }

    protected function showMessage($message, $code = 200, $optionalData = null)
    {
        return $this->successResponse([
            'status' => 'Success',
            'statusCode' => $code,
            'message' => $message,
            'optionalData' => $optionalData
        ], $code);
    }

    protected function sortData(Collection $collection)
    {
        if (request()->has('sort_by')) {
            $attribute = request()->sort_by;
            if (request()->has('order_by') && request()->order_by == 'desc') {
                $collection = $collection->sortByDesc($attribute);
            } else {
                $collection = $collection->sortBy($attribute);
            }
        }
        return $collection;
    }

    protected function filterData(Collection $collection)
    {
        foreach (request()->query() as $query => $value) {
            if (isset($query, $value) && $query != 'sort_by' && $query != 'order_by' && $query != 'page' && $query != 'per_page') {
                $collection = $collection->where($query, $value);
            }
        }

        return $collection;
    }

    protected function paginate(Collection $collection, $pageMutated)
    {
        $rule = [
            'per_page' => 'integer|min:2|max:100'
        ];
        Validator::validate(request()->all(), $rule);

        if ($pageMutated) {
            $page = (int) $pageMutated;
        } else {
            $page = LengthAwarePaginator::resolveCurrentPage();
        }


        if (request()->has('per_page')) {
            $perPage = (int) request()->per_page;
        } else {
            $perPage = 30;
        }

        $result = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator($result, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        $paginated->appends(request()->all());

        return $paginated;
    }

    protected function cacheResponse($data)
    {
        $url = request()->url();
        $queryParams = request()->query();
        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30 / 60, function () use ($data) {
            return $data;
        });
    }

    protected function clearPhoneNumber($number)
    {
        $number = str_replace('+880', '0', $number);
        // $number = str_replace('+', '', $number);
        // $number = str_replace(' ', '', $number);
        // $number = str_replace('-', '', $number);
        // $number = str_replace('.', '', $number);

        foreach (['88', '8', '+', '-', '.', ' '] as $prefix) {
            if (substr($number, 0, strlen($prefix)) == $prefix) {
                $number = substr($number, strlen($prefix));
            }
        }

        return $number;
    }
}
