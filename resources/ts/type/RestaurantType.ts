type Categorie = {
    created_at: Date;
    deleted_at: null | Date;
    id: number;
    name: string;
    updated_at: Date;
    user_id: number;
};

type RestaurantData = {
    name: string,
    name_katakana: string,
    review: number,
    food_picture: any,
    map_url: string,
    comment: string,
    tel: string,
    user_id: number,
    categorie: any,
    config: any,
    id?: number

}
type PageNationData = {
    current_page: number,
    data: [RestaurantData],
    first_page_url: URL,
    from: number,
    last_page: number,
    last_page_url: URL,
    path: URL,
    per_page: number,
    prev_page_url: URL | null,
    to: number,
    total: number,
    links: any
}
export { Categorie, RestaurantData,PageNationData }