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
use App\Services\SEO\SEOServiceFactory;


class AdController extends Controller
{
    protected $seoService;
      public function __construct(protected AdService $adService)
    {
      
     $this->seoService = SEOServiceFactory::make('ad');
    
    }

    public function index(Request $request){

       $query = Ad::query();
        $filter = new AdFilter($request);
        $query = $filter->apply($query);

        
        $ads = $this->adService->paginateQueryAds($query,15);
        $prods = AdResource::collection($ads);
         
         return Inertia::render('website/ads/Index', [
            'ads' => $prods,
            'filters' => $request->only(['category_id', 'subcategory_id', 'brand_id', 'model_id']),
            'categories' => Category::all(),
            'subCategories' => SubCategory::all(),
            'brands' => Brand::all(),
            'models' => BrandModel::all()
        ]);
    }

    public function show($id){
      
      $ad=$this->adService->getById($id,true);
      
      $prod=( new AdResource($ad))->resolve();
      $seo = $this->seoService->generate($prod);
      
        return Inertia::render('website/ads/AdDetails', [
          'ad'=>$prod,
          
        ])->withViewData(['seo'=>$seo]);

    }
}
