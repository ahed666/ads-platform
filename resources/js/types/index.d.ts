import { SubCategory, Ad, Company, AdType } from './index.d';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';



export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};
export type FeatureSet = {
  [key: string]: string|null;
};

export type AttributeItem = {
  key: string;
  value: {label_en:string|null,label_ar:string|null,value:string|null};
};

export interface AdForm {
  
  ad_type_id:number|null
  category_id: number | null
  subcategory_id: number | null
  brand_id: number | null
  model_id: number | null
   name_en: string,
    name_ar:string,
    description_en: string,
    description_ar:string,
  price: number|null,
  images: Image[]|null,
  video: Video|null,
  purpose:string,
  status:string,
  availability:string,
  features:FeatureSet,
  attributes:AttributeItem[],
};
export interface Image {
  file: File
  url: string | null
  loading: boolean
  type: 'image' 
}
export interface Video {
  file: File
  url: string | null
  loading: boolean
  type: 'video' 
}
export interface SubCategory {
  id: number;
  name_en: string;
  name_ar: string;
  category_id:number;
};
export interface AdType {
  id: number;
  name_en: string;
  name_ar: string;
  slug:string;
};
export interface FeatureField {
  key: string;
  label: string;
  placeholder: string;
}

export interface AdFeatureConfig {
  default: Record<string, string | number | null>;
  fields: FeatureField[];
}

export interface Category {
  id: number;
  name_en: string;
  name_ar: string;
  ad_type_id:number;
};

export interface Brand {
  id: number;
  name_en: string;
  name_ar: string;
   logo_url?: string;
  ad_type_id?: number;
};

export interface BrandModel {
  id: number;
  name_en: string;
  name_ar: string;
  brand_id: number;
};

export interface Country {
  id: number;
  name_en: string;
  name_ar: string;
  code: string; //  "AE", "JO", "DE"...
  phone_code: string; //  "+971"
  created_at?: string;
  updated_at?: string;
}
export interface City {
  id: number;
  name_en: string;
  name_ar: string;
  country_id: number;
  created_at?: string;
  updated_at?: string;
}

export interface User {
    id: number;
    name: string;
    email?: string;
    account_type:string;
    avatar?: string;
    email_verified_at: string | null;
    // Contact Info
    email?: string | null;
    phone?: string | null;
    whatsapp?: string | null;
    

    // Location
    country_id?: number | null;
    city_id?: number | null;
    address?: string | null;
    latitude?: number | null;
    longitude?: number | null;
    // Social
    facebook?: string | null;
    instagram?: string | null;
    company:Company;
    country?: Country; // 
    city?: City;
    created_at: string;
    updated_at: string;

}

export interface Company {
  id: number;
  name: string;
  slug: string;
  owner_id: number | null;

  description: string;
  logo?: string;

  website?: string | null;

  // Type / Classification
  
  industry?: string | null;
  tax_id?: string | null;
  registration_number?: string | null;

  

  // Status
  is_verified: boolean;
  is_active: boolean;

  // Timestamps
  created_at: string|null;
  updated_at: string|null;

 
}




export interface Auth {
  user: User;
  role: string;
  permissions: string[];
}

export type FeatureSet = {
  [key: string]: string | number | null;
};

export interface Ad {
  id: number;
  name_en: string;
  name_ar: string;
  ad_type_id:number;
  company_id: number;
  category_id: number;
  subcategory_id: number;
  brand_id?: number;
  model_id?:number;
  slug: string;
  description_ar?: string;
  description_en?: string;
  price: number|null;
  is_sold: boolean;
  purpose:string;
  status:string;
    availability:string,
  created_at: string;
  updated_at: string;
company:Company|null;
  AdType:AdType;
    category?: Category;
  brand?: Brand;
  subCategory?:SubCategory;
  model?:BrandModel;
    user:User;
   images: Image[];
  video: Video | null;
  features:FeatureSet,
  attributes:AttributeItem[],
}

export interface AdSEO{
  title:string;
  description:string;
  type:string;
  category:string;
  subcategory:string;
  brand:string;
  model:string;
}
export interface AdFilter{
   ad_type_id?: number | string
    category_id?: number | string
  subcategory_id?: number | string
  brand_id?: number | string
  model_id?: number | string
  [key: string]: any

}

export interface Pagination<T> {
  data: T[];
  meta: {
    current_page: number;
    last_page: number;
    total: number;
    per_page: number;
    links: {
      url: string | null;
      label: string;
      active: boolean;
    }[];
  };
}




export type AdPageProps = AppPageProps<{
  categories: Category[];
  brands: Brand[];
  subCategories: SubCategory[];
  models: BrandModel[];
  ads:Ad[];
  filters:Filter;
}>;

export type BreadcrumbItemType = BreadcrumbItem;
