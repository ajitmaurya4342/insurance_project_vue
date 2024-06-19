const TOKEN_KEY = "access_token";
const USER_PROFILE_KEY = "user_profile";
const COUNTRY = "country";
const LANGUAGE = "language";
const CITY = "city";
const PWA = "IS_PWA";

const TokenService = {
  getToken() {
    return localStorage.getItem(TOKEN_KEY);
  },

  saveToken(accessToken) {
    localStorage.setItem(TOKEN_KEY, accessToken);
  },

  removeToken() {
    localStorage.removeItem(TOKEN_KEY);
  },
};

const UserService = {
  getUserProfile() {
    return localStorage.getItem(USER_PROFILE_KEY);
  },

  saveUserProfile(userProfile) {
    localStorage.setItem(USER_PROFILE_KEY, userProfile);
  },

  removeUserProfile() {
    localStorage.removeItem(USER_PROFILE_KEY);
  },
};

const LanguageService = {
  getLanguage() {
    return localStorage.getItem(LANGUAGE);
  },

  saveLanguage(language) {
    localStorage.setItem(LANGUAGE, language);
  },

  removeLanguage() {
    localStorage.removeItem(LANGUAGE);
  },
};

// const CountryService = {
//   getCountry() {
//     return localStorage.getItem(COUNTRY) ? JSON.parse(localStorage.getItem(COUNTRY)) : null;
//   },

//   saveCountry(country) {
//     localStorage.setItem(COUNTRY, JSON.stringify(country))
//   },

//   removeCountry() {
//     localStorage.removeItem(COUNTRY)
//   }
// }

// const CityService = {
//   getCity() {
//     return JSON.parse(localStorage.getItem(CITY) || null);
//   },

//   saveCity(city) {
//     localStorage.setItem(CITY, JSON.stringify(city));
//   },

//   removeCity() {
//     localStorage.removeItem(CITY);
//   },
// };

// const PwaService = {
//   getIsPwa() {
//     return localStorage.getItem(PWA);
//   },
//   setIsPwa(val) {
//     localStorage.setItem(PWA, val);
//   },
//   removeIsPwa() {
//     localStorage.removeItem(PWA);
//   },
// };

export {
  TokenService,
  UserService,
  LanguageService,
  // CountryService,
  // CityService,
  // PwaService,
};
