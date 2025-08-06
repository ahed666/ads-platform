<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\AdService;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\AdType;
use App\Models\Ad;
use App\Models\SubCategory;
use App\Models\BrandModel;
use App\Models\Brand;
use App\Http\Resources\AdResource;
use Illuminate\Support\Facades\Log;
use App\Jobs\ShareAdToSocialMedia;
use App\Http\Controllers\Controller;
use App\Filters\AdFilter;

class AdController extends Controller
{  
    

    public function __construct(protected AdService $adService)
    {
    }

    public function index(Request $request)
    {
        $query = Ad::query();
        $filter = new AdFilter($request);
        $query = $filter->apply($query);

        
        $ads = $this->adService->paginateQueryAds($query,15);

        $prods = AdResource::collection($ads);
        
        // dd($prods);
        return Inertia::render('admin/ads/Index', [
            'ads' => $prods,
            'filters' => $request->only(['category_id', 'subcategory_id', 'brand_id', 'model_id']),
            'adTypes'=>AdType::all(),
            'categories' => Category::all(),
            'subCategories' => SubCategory::all(),
            'brands' => Brand::all(),
            'models' => BrandModel::all()
        ]);
    }

    // create
    public function create()
    {
        return Inertia::render('admin/ads/Create', [
            'adTypes'=>AdType::all(),
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'subCategories' => SubCategory::all(),
            'models' => BrandModel::all(),
        ]);
    }

    public function edit(Ad $ad)
    {
        $ad = (new AdResource($ad->load('media')))->resolve();
        
        return Inertia::render('admin/ads/Edit', [
        'ad' => $ad,
         'adTypes'=>AdType::all(),
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'subCategories' => SubCategory::all(),
            'models' => BrandModel::all(),
        ]);
    }

    // create new ad
    public function store(Request $request)
    {
        
         
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'required|string|max:255',
            'description_ar' => 'required|string|max:255',
            'price' => 'required|numeric',
            'ad_type_id' => 'required|exists:ad_types,id',
            'category_id' => 'required|exists:categories,id',
            
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'model_id' => 'nullable|exists:brand_models,id',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'availability'=>'required|string|max:255',
            'purpose'=>'required|string|max:255',
            'status'=>'required|string|max:255',
            'video' => 'nullable|mimes:mp4,mov,avi|max:10240',
            'features' => 'required|json',     
            'attributes' => 'required|json',
            

            // Add more fields as needed
        ]);

        $validated['features'] = json_decode($validated['features'], true);
$validated['attributes'] = json_decode($validated['attributes'], true);


        $uploadedMedia=[];
       $uploadedMedia=$this->getUploadedMedia($request);

        $ad = $this->adService->create($validated, $uploadedMedia);

        if (!$ad) {
            return response()->json(['message' => 'error while create ad   '], 500);
        }

       // ShareAdToFacebook::dispatchSync($ad);
       ShareAdToSocialMedia::dispatchSync($ad);
        return response()->json([
            'ad' => $ad,
            'message' => 'Ad created successfully!'
        ], 201);
    }

   

    // view single ad
    public function show($id)
    {
        
        return response()->json($this->adService->getById($id));
    }

    // update ad
    public function update(Request $request,  $adId)
    {
        $ad=Ad::find($adId);
      
        $this->authorizeAd($ad);
                
      
  
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'required|string|max:255',
            'description_ar' => 'required|string|max:255',
            'price' => 'sometimes|numeric',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi|max:10240',
            'status'=>'required|string|max:255',
            'purpose'=>'required|string|max:255',
            'availability'=>'required|string|max:255',
            'features' => 'required|json',     
            'attributes' => 'required|json',
            
        ]);
       $validated['features'] = json_decode($validated['features'], true);
        $validated['attributes'] = json_decode($validated['attributes'], true);
        $deletedMedia=$request->deletedMedia?$request->deletedMedia:[];
       
          
        $uploadedMedia = [];
        $uploadedMedia=$this->getUploadedMedia($request);
       
        $ad = $this->adService->update($ad, $validated,$deletedMedia,$uploadedMedia);
        
       
    }

    public function destroy(Ad $ad)
    {  
        $this->authorizeAd($ad);
        $this->adService->delete($ad);
        return response()->json(['message' => 'Deleted successfully.']);
    }


    // get uploaded media for ad when create/update 
     public function getUploadedMedia(Request $request){
        log::info('getUploadedMedia');
         $uploadedVideo=$request->file('video') ?? [];
        $uploadedImages = $request->file('images') ?? [];
          log::info('getUploadedMedia',[$uploadedImages,$uploadedVideo]);
        $uploadedMedia = [];

        if ($request->hasFile('images')) {
            $uploadedMedia = array_merge($uploadedMedia, $request->file('images'));
        }

        if ($request->hasFile('video')) {
            $uploadedMedia[] = $request->file('video');
        }
        return $uploadedMedia;
    }

    // check if this ad for this company
    private function authorizeAd(Ad $ad)
    {
        if ($ad->company_id !== auth()->user()->company_id) {
            abort(403, 'Unauthorized action.');
        }
    }

    
}
