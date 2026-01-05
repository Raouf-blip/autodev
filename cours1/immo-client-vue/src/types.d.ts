export interface Property {
  id: number;
  name: string;
  type: string;
  city: string;
  description: string;
  surface: number;
  price: number;
  options: Option[];
  images: Image[];
  mainImage: string;
}

export interface Option {
  id: number;
  name: string;
}

export interface Image {
  id: number;
  link: string;
}