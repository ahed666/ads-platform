import type { AdFeatureConfig } from '@/types';

export const adFeatures:Record<string, AdFeatureConfig> = {
  cars: {
    default: {
      engine: null,
      fuel: null,
      transmission: null,
    },
    fields: [
      { key: 'engine', label: 'Engine', placeholder: 'e.g., V8 Turbo' },
      { key: 'fuel', label: 'Fuel Type', placeholder: 'e.g., Diesel' },
      { key: 'transmission', label: 'Transmission', placeholder: 'e.g., Automatic' },
    ],
  },
  heavy_equipment: {
    default: {
      power: null,
      weight: null,
    },
    fields: [
      { key: 'power', label: 'Power', placeholder: 'e.g., 200HP' },
      { key: 'weight', label: 'Weight', placeholder: 'e.g., 25 Ton' },
    ],
  },
  electronics: {
    default: {
      ram: null,
      storage: null,
      screen_size: null,
    },
    fields: [
      { key: 'ram', label: 'RAM', placeholder: 'e.g., 16GB' },
      { key: 'storage', label: 'Storage', placeholder: 'e.g., 512GB SSD' },
      { key: 'screen_size', label: 'Screen Size', placeholder: 'e.g., 15.6 inch' },
    ],
  },
 property: {
  default: {
    bedrooms: null,
    bathrooms: null,
    area: null,
    furnished: null,
    parking: null,
  },
  fields: [
    { key: 'bedrooms', label: 'Bedrooms', placeholder: 'e.g., 3' },
    { key: 'bathrooms', label: 'Bathrooms', placeholder: 'e.g., 2' },
    { key: 'area', label: 'Area (sqm)', placeholder: 'e.g., 120' },
    { key: 'furnished', label: 'Furnished', placeholder: 'e.g., Yes/No' },
    { key: 'parking', label: 'Parking', placeholder: 'e.g., 1 spot' },
  ],
}

};

