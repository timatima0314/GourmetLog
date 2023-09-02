type Categorie = {
    created_at: Date;
    deleted_at: null | Date;
    id: number;
    name: string;
    updated_at: Date;
    user_id: number;
    select?: boolean
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
    categories?: any,
    categorieId?: any,
    config: any,
    listId?: number,
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
type PageNationHotpepperData = {
    current_page: number,
    data: any,
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
type CsvData = {
    name: string,
    review: number,
    comment: string,
    categories?: any,
    listId?: number,
}
export { Categorie, RestaurantData, PageNationData, PageNationHotpepperData, CsvData }