export default {
  // Endpoints
  loginEndpoint: 'api/auth/login',
  registerEndpoint: 'api/auth/register',
  refreshEndpoint: 'api/auth/refresh-token',
  logoutEndpoint: 'api/auth/logout',

  // This will be prefixed in authorization header with token
  // e.g. Authorization: Bearer <token>
  tokenType: 'Bearer',

  // Value of this property will be used as key to store JWT token in storage
  storageTokenKeyName: 'accessToken',
  storageRefreshTokenKeyName: 'refreshToken',
}
