<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdService;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Ad;
use App\Models\SubCategory;
use App\Models\BrandModel;
use App\Models\Brand;
use App\Http\Resources\AdResource;
use Illuminate\Support\Facades\Log;
use App\Jobs\ShareAdToSocialMedia;
use App\Filters\AdFilter;
class HomeController extends Controller
{
     public function __construct(protected AdService $adService)
    {
    }

    public function index(Request $request){

      $query = Ad::query();
        $filter = new AdFilter($request);
        $query = $filter->apply($query);

        
        $ads = $this->adService->paginateQueryAds($query,15,true);
        
        $prods = AdResource::collection($ads)->resolve();
         
    return Inertia::render('Welcome',[
            'ads' => $prods,
            'filters' => $request->only(['category_id', 'subcategory_id', 'brand_id', 'model_id']),
            'categories' => Category::all(),
            'subCategories' => SubCategory::all(),
            'brands' => Brand::all(),
            'models' => BrandModel::all()
        ]);

    }
}
