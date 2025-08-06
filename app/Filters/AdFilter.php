<?php
namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AdFilter
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $query): Builder
    {
        return $query
            ->when($this->request->filled('ad_type_id'), function ($q) {
                $q->where('ad_type_id', $this->request->ad_type_id);
            })
            ->when($this->request->filled('category_id'), function ($q) {
                $q->where('category_id', $this->request->category_id);
            })
            ->when($this->request->filled('subcategory_id'), function ($q) {
                $q->where('subcategory_id', $this->request->subcategory_id);
            })
            ->when($this->request->filled('brand_id'), function ($q) {
                $q->where('brand_id', $this->request->brand_id);
            })
            ->when($this->request->filled('model_id'), function ($q) {
                $q->where('model_id', $this->request->model_id);
            });
    }
}
