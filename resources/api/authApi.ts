import axios from 'axios';
import router from "../ts/router";
import { Login, SingUp, AuthUserRes } from "../ts/type/AuthType";

// ログイン
const authLogin = async (email: string, password: string) => {
    await axios
        .get("/sanctum/csrf-cookie")
        .then(() => {
            axios
                .post<Login>(`/api/user/login`, {
                    password: password,
                    email: email,
                })
                .then((res) => {
                    router.push("/dash_board");
                    return res
                })
                .catch((err) => {
                    alert('ログインに失敗しました。');
                })
        })
        .catch(() => {
            alert('ログインに失敗しました。');
        });
};

// ログアウト
const authLogout = async () => {
    axios
        .post("/api/user/logout")
        .then((res) => {
            router.push("/login");

        })
        .catch((err) => {
            alert('ログアウトに失敗しました。');
        });
};

// ユーザー情報取得
const authGet = async () => {
    const { data } = await axios.get<AuthUserRes>("/api/user/auth")
    return data
};

// 新規登録
const authSingUp = async (name: string, email: string, password: string) => {
    await axios.post<SingUp>(`/api/user/sing_up`, {
        name: name,
        email: email,
        password: password,
    });
};

export { authLogin, authLogout, authGet, authSingUp }
