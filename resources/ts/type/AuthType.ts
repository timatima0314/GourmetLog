type Login = {
    email: string,
    password: string
}
type SingUp = {
    name: string,
    email: string,
    password: string
}
type AuthUser = {
    created_at: Date,
    email: string,
    email_verified_at: Date,
    id: number,
    name: string,
    updated_at: Date,
}
type AuthUserRes={
    user:AuthUser
}
export { Login, SingUp, AuthUser ,AuthUserRes}