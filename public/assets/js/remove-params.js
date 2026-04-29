let currentUrl = new URL(window.location.href);

let macAddress = currentUrl.searchParams.get('mac');
let token = currentUrl.searchParams.get('token');
let keyword = currentUrl.searchParams.get('keyword');

// Store values in sessionStorage
if (macAddress) {
    sessionStorage.setItem('mac', macAddress);
    currentUrl.searchParams.delete('mac');
}

if (token) {
    sessionStorage.setItem('token', token);
    currentUrl.searchParams.delete('token');
}

if (keyword) {
    sessionStorage.setItem('keyword', keyword);
    currentUrl.searchParams.delete('keyword');
}

// Remove the parameters from the URL and update it
let newUrl = currentUrl.toString();
window.history.replaceState(null, '', newUrl);
