const ROUTE_URL_POS = "https://shwemanager.com/pos/";
const ROUTE_URL_ADMIN = "https://shwemanager.com/admin/";
const IMAGE_URL = "https://shwemanager.com/";
const DOMAIN = "https://shwemanager.com/";

// const ROUTE_URL_POS = "http://localhost:8000/pos/";
// const ROUTE_URL_ADMIN = "http://localhost:8000/admin/";
// const IMAGE_URL = "http://localhost:8000/";
// const DOMAIN = "http://localhost:8000/";

const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

export default {
    ROUTE_URL_POS: ROUTE_URL_POS,
    ROUTE_URL_ADMIN: ROUTE_URL_ADMIN,
    IMAGE_URL : IMAGE_URL,
    DOMAIN : DOMAIN,
    CSRF : CSRF,
}
