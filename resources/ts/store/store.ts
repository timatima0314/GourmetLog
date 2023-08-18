import { InjectionKey } from 'vue';
import { createStore, Store, useStore as baseUseStore } from "vuex";
import * as MutationTypes from "./mutationTypes";
import { ADD_RESTAURANT_DETA } from './mutationTypes';

type RestaurantData = {
    name: string,
    name_katakana: string,
    review: number,
    food_picture: any,
    map_url: string,
    comment: string,
    tel: string,
    user_id: number,
    categorie: [],
};
// stateの型定義
type State = {
    restaurantData: RestaurantData[];
};

// storeをprovide/injectするためのキー
export const key: InjectionKey<Store<State>> = Symbol();

// store本体
export const store = createStore<State>({
    state: {
        restaurantData: [
            {
                name: "",
                name_katakana: "",
                review: 1,
                food_picture: '',
                map_url: '',
                comment: '',
                tel: '',
                user_id: 1,
                categorie: []
            }
        ]
    },
    mutations: {
        [MutationTypes.ADD_RESTAURANT_DETA](state, restaurantData: RestaurantData) {
            state.restaurantData.push(restaurantData);
        }
    }
});

// useStoreを使う時にキーの指定を省略するためのラッパー関数
export const useStore = () => {
    return baseUseStore(key);
}